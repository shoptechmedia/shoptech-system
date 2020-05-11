<?php

$pages_to_cache = $_REQUEST['pages'];

$fields = array(
    'rebuildCache' => 1
);

function curl_rebuild_caches($pages, $fields = array()){
    $cache_requests = array();

    $query = http_build_query($fields);

    foreach($pages as $page){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $page);

        curl_setopt($ch, CURLOPT_POST, count($fields));

        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);

        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $cache_requests[] = $ch;
    }

    if(empty($cache_requests)){
        return false;
    }

    $mh = curl_multi_init();

    foreach($cache_requests as $cache_request){
        curl_multi_add_handle($mh, $cache_request);
    }


    $active = null;

    $redirects = array();

    //execute the handles
    do {
        $mrc = curl_multi_exec($mh, $active);
    } while ($mrc == CURLM_CALL_MULTI_PERFORM);

    while ($active && $mrc == CURLM_OK) {
        if (curl_multi_select($mh) != -1) {

            do {
                $mrc = curl_multi_exec($mh, $active);

                $done = curl_multi_info_read($mh);

                if(!empty($done)){
                    $info = curl_getinfo($done['handle']);

                    if(!empty($info['redirect_url'])){
                        $redirects[] = $info['redirect_url'];
                    }
                }
            } while ($mrc == CURLM_CALL_MULTI_PERFORM);

        }
    }


    $cached = array();

    $pages = array_keys($pages);

    foreach($cache_requests as $i => $cache_request){
        $response = curl_multi_getcontent($cache_request);

        if(!empty($response)){
            $cached[] = $pages[$i];
        }

        curl_multi_remove_handle($mh, $cache_request);
    }

    curl_multi_close($mh);


    if(!empty($redirects)){
        $cached_redirects = curl_rebuild_caches($redirects, $fields);

        $cached = array_merge($cached, $cached_redirects);
    }

    return $cached;
}


$cached_pages = curl_rebuild_caches($pages_to_cache, $fields);

echo json_encode($cached_pages);