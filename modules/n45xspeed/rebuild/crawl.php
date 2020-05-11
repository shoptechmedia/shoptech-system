<?php set_time_limit(0);

require __DIR__ . '/parallel-curl.php';


$pages_to_cache = array();

function add_to_pages_to_cache($url){
    global $pages_to_cache;

    $url = trim($url, '/');

    echo $url . "\n";
    $pages_to_cache[$url] = $url;
}


/***************************** GET PAGES IN DATABASE START **********************************/

include(__DIR__ . '/../../../config/config.inc.php');

include(__DIR__ . '/../n45xspeed.php');

if (!Module::isInstalled('n45xspeed'))
        die('Bad token');

$n45xspeed = new n45xspeed();
$context = Context::getContext();

$langs = Language::getLanguages();
$link = new Link();

$urls = array();

$curid_lang = (int) $context->language->id;
$curid_shop = (int) $context->shop->id;

$n45xspeed->clearCache($curid_shop);

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

    /*$shopObj = new Shop($shop);
    $shopUrl = $shopObj->getBaseURL();

    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
        $shopUrl = str_replace('http://', 'https://', $shopUrl);
    }

    //add_to_pages_to_cache($shopUrl);*/

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



/***************************** GET PAGES NOT IN DATABASE START **********************************/

$proto = 'http';
if(@$_SERVER['HTTPS'] == 'on'){
    $proto .= 's';
}

$site = $proto . '://' . $_SERVER['HTTP_HOST'];

$parallel_curl = new ParallelCurl($max_requests);

$max_requests = 100;

$fields = array(
    'get_all_links' => 1
);

function curl_get_links($pages){
    global $pages_to_cache, $parallel_curl, $max_requests, $fields, $site;

    $pages = json_decode($pages);

    if(is_array($pages)){
        foreach($pages as $page){
            if(count($pages_to_cache) > $max_requests)
                break;

            $page = trim($page, '/');

            if(
                strpos($page, $site) === false || 
                isset($pages_to_cache[$page]) || 
                strpos($page, '?') !== false || 
                strpos($page, '#') !== false || 
                strpos($page, '.jpg') !== false || 
                strpos($page, '.png') !== false || 
                strpos($page, '/module') !== false || 
                strpos($page, '/quick-order') !== false
            ){
            }else{
                add_to_pages_to_cache($page);

                $parallel_curl->startRequest($page, 'curl_get_links', array(), $fields);
            }
        }
    }
}

curl_get_links(json_encode(array($site)));

$parallel_curl->finishAllRequests();

/***************************** GET PAGES NOT IN DATABASE END **********************************/