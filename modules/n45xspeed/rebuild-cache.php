<?php file_put_contents(__DIR__ . '/rebuild/cron_running', '');

$pages_to_cache = array();

function add_to_pages_to_cache($url){
    global $pages_to_cache;

    $url = trim($url, '/');

    $pages_to_cache[$url] = $url;
}


/***************************** GET PAGES IN DATABASE START **********************************/

include(__DIR__ . '/../../config/config.inc.php');

include(__DIR__ . '/n45xspeed.php');

if (!Module::isInstalled('n45xspeed'))
        die('Bad token');

$n45xspeed = new n45xspeed();
$context = Context::getContext();

$langs = Language::getLanguages();
$link = new Link();

$urls = array();

$curid_lang = (int) $context->language->id;
$curid_shop = (int) $context->shop->id;

foreach($langs as $lang){
    if($_REQUEST['allShops'] != 4){
        if($curid_lang != $lang['id_lang'])
            continue;
    }

    $products = Product::getProducts($lang['id_lang'], 0, 99999, 'id_product', 'asc');
    $categories = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
        SELECT c.`id_category`, cl.`name`
        FROM `'._DB_PREFIX_.'category` c
        LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON (c.`id_category` = cl.`id_category`'.Shop::addSqlRestrictionOnLang('cl').')
        '.Shop::addSqlAssociation('category', 'c').'
        WHERE cl.`id_lang` = '.(int)$lang['id_lang'].'
        AND c.`id_category` != '.Configuration::get('PS_ROOT_CATEGORY').'
        AND c.`active` = 1 
        GROUP BY c.id_category
        ORDER BY c.`id_category`, category_shop.`position`
    ');

    $pages = CMS::getLinks($lang['id_lang']);

    $shop = $lang['id_shop'];

    $shopObj = new Shop($shop);
    $shopUrl = $shopObj->getBaseURL();

    $n45xspeed->clearCache($shop);

    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
        $shopUrl = str_replace('http://', 'https://', $shopUrl);
    }

    add_to_pages_to_cache($shopUrl);

    foreach($categories as $category){
        $id_category = $category['id_category'];
        if($id_category == 2 || $id_category == 3)
            continue;

        $category = new Category($id_category);

        if(!empty($category->link_rewrite[$lang['id_lang']])){
            $url = $link->getCategoryLink($category, $category->link_rewrite[$lang['id_lang']], $lang['id_lang'], null, $shop);

            add_to_pages_to_cache($url);
        }
    }

    foreach($pages as $page){
        $url = $page['link'];

        add_to_pages_to_cache($url);
    }

    foreach($products as $product){
        if($product['active'] == 0)
            continue;

        $product = new Product($product['id_product']);

        if(is_object($product)){
            if(!empty($product->link_rewrite[$lang['id_lang']])){
                $id_product = $product->id_product;
                $id_category = $product->id_category_default;

                $category = Category::getLinkRewrite((int)$id_category, (int)$lang['id_lang']);

                $url = $link->getProductLink($product, $product->link_rewrite[$lang['id_lang']], $category, $product->ean13[$shop], $lang['id_lang'], $shop);

                add_to_pages_to_cache($url);
            }
        }
    }
}

/***************************** GET PAGES IN DATABASE END **********************************/


/*START REBUILD CACHE*/

echo "\n\n" . 'Rebuilding Cache' . "\n";

function curl_rebuild_cache($pages){
    if(is_array($pages)){
        $commands = '';
        foreach($pages as $page){
            $page = trim($page, '/');

            $commands .= "curl -L '" . $page . "'" . ' -XPOST -d"rebuildCache=1"' . "\n";
        }

        $commands .= 'rm -f ' . __DIR__ . '/rebuild/cron_running';

        file_put_contents(__DIR__ . '/rebuild/cache.sh', $commands);

        exec(__DIR__ . '/rebuild/cache.sh > /dev/null 2>/dev/null &', $out, $return);
    }
}

curl_rebuild_cache($pages_to_cache);

// unlink(__DIR__ . '/rebuild/cron_running');

echo "\n\n" . 'Rebuild Finished' . "\n";