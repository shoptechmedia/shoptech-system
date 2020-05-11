<?php

if(isset($_POST['id_category'])){
    $id_category = Tools::getValue('id_category');

    $category = new Category($id_category);

    $shops = Shop::getCompleteListOfShopsID();

    foreach($shops as $shop){
        $url  = $this->context->link->getCategoryLink($category, $category->link_rewrite[$shop], $this->context->language->id, null, $shop);;
        $url .= '?refresh_cache=' . urlencode('Refresh Cache');

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);

        curl_setopt($ch, CURLOPT_VERBOSE, 0);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, 0);

        curl_setopt($ch, CURLOPT_HTTPGET, 1);

        $response = curl_exec($ch);

        curl_close($ch);
    }
}