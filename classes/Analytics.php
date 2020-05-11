<?php

class AnalyticsCore {

    public function __construct($query, $label = '', $format = 'JSON')
    {
        $this->image_dir = _PS_COL_IMG_DIR_;

        $this->context = Context::getContext();

        $PIWIK_SITEID = (int) Configuration::get('PIWIK_SITEID');
        $DREPDATE = Configuration::get('PIWIK_DREPDATE');

        if ($DREPDATE !== FALSE && (strpos($DREPDATE, '|') !== FALSE)) {
            list($period, $date) = explode('|', $DREPDATE);
        } else {
            $period = "day";
            $date = "today";
        }

        $query['module'] = 'API';
        $query['token_auth'] = Configuration::get('PIWIK_TOKEN_AUTH');
        $query['idSite'] = $PIWIK_SITEID;
        $query['period'] = $period;
        $query['date'] = $date;
        $query['language'] = $this->context->language->iso_code;

        $this->raw_query = $query;

        $query = http_build_query($query);

        if($label){ 
            $label = str_replace(' ', '%2520', $label);
            $label = str_replace(':', '%253A', $label);
            $label = str_replace(',', '%252C', $label);
            $label = str_replace('@', '%40', $label);
        }

        $this->query = $query . '&label=' . $label . '&format=' . $format;

        $this->response = false;

        // $this->getData();
    }

    private function getData(){
    	$url = 'https://' .  $this->context->shop->domain_ssl . '/analytics/index.php?' . $this->query;

        if($_SERVER['REMOTE_ADDR'] == '124.104.190.210'){
            // echo $url;
            // exit;
        }

    	$this->response = Tools::jsonDecode(file_get_contents($url));

        if(count($this->response) <= 1)
    	   $this->response = @$this->response[0];
    }

}