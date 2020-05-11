<?php

if (!defined('_PS_VERSION_')){
	exit;
}

class STMEvents extends ObjectModel{
    // @codingStandardsIgnoreStart
    /**
     * @see ObjectModel::$definition
     */
    public static $definition = [
        'table'          => 'stm_events',
        'primary'        => 'id_stm_event',
        'multilang'      => true,
        'fields'         => [
            'id_product' => ['type' => self::TYPE_INT, 'lang' => false],
            'active' => ['type' => self::TYPE_INT, 'lang' => false],
            'buy_pack' => ['type' => self::TYPE_INT, 'lang' => false],
            'buy_one' => ['type' => self::TYPE_INT, 'lang' => false],
            'youtube_video' => ['type' => self::TYPE_STRING, 'lang' => false],
            'streaming_start_time' => ['type' => self::TYPE_STRING, 'lang' => false],
            'streaming_end_time' => ['type' => self::TYPE_STRING, 'lang' => false],
            'streaming_url' => ['type' => self::TYPE_STRING, 'lang' => false],
            'venue' => ['type' => self::TYPE_STRING, 'lang' => false],
            'start_date' => ['type' => self::TYPE_STRING, 'lang' => false],
            'end_date' => ['type' => self::TYPE_STRING, 'lang' => false],
            'event_image' => ['type' => self::TYPE_STRING, 'lang' => false],
            'event_categories' => ['type' => self::TYPE_STRING, 'lang' => false],
            'cancelation_period' => ['type' => self::TYPE_INT, 'lang' => false],

            'name' => ['type' => self::TYPE_STRING, 'lang' => true, 'required' => true],
            'description' => ['type' => self::TYPE_HTML, 'lang' => true],
            'meta_title' => ['type' => self::TYPE_STRING, 'lang' => true],
            'meta_description' => ['type' => self::TYPE_HTML, 'lang' => true],
            'link_rewrite' => ['type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isLinkRewrite', 'required' => true, 'size' => 128],
        ],
    ];

    public $id_product;
    public $active;
    public $buy_pack;
    public $buy_one;
    public $youtube_video;
    public $streaming_start_time;
    public $streaming_end_time;
    public $streaming_url;
    public $venue;
    public $start_date;
    public $end_date;
    public $event_image;
    public $event_categories;
    public $cancelation_period;

    public $name;
    public $description;
    public $meta_title;
    public $meta_description;
    public $link_rewrite;

    public $price;

    public function addPackProduct($id_product){
        Pack::addItem($this->id_product, $id_product, 1);
    }

    public function add($autoDate = true, $nullValues = false){
        $this->price = $this->price * 0.8;

        $pack = new Product();
        $pack->id_tax_rules_group = 2;
        $pack->price = (float) $this->price;
        $pack->is_virtual = 1;

        $pack->name = $this->name;
        $pack->link_rewrite = $this->link_rewrite;

        $pack->add();

        if($pack->id){
            $pack->addToCategories(explode(',', $this->event_categories));

            $this->id_product = $pack->id;
            return parent::add($autoDate, $nullValues);
        }

        return false;
    }

    public function update($nullValues = false){
        $process = false;
        $this->price = $this->price * 0.8;

        if($this->id_product == 0){
            $pack = new Product();
            $pack->id_tax_rules_group = 2;
            $pack->is_virtual = 1;

            $pack->price = (float) $this->price;
            $pack->name = $this->name;
            $pack->link_rewrite = $this->link_rewrite;

            $process = $pack->add();

            if($pack->id){
                $pack->addToCategories(explode(',', $this->event_categories));
            }
        }else{
            $pack = new Product($this->id_product);
            $pack->price = (float) $this->price;
            $pack->name = $this->name;
            $pack->link_rewrite = $this->link_rewrite;
            $pack->id_tax_rules_group = 2;

            $process = $pack->update();

            if($pack->id){
                $pack->addToCategories(explode(',', $this->event_categories));
            }
        }

        $this->id_product = $pack->id;

        if($process){
            return parent::update($nullValues);
        }

        return false;
    }

    public function delete(){
        $pack = new Product($this->id_product);

        $pack->delete();

        return parent::delete();
    }
}