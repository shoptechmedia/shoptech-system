<?php

if (!defined('_PS_VERSION_')){
    exit;
}

class HolidayPage extends ObjectModel{
    // @codingStandardsIgnoreStart
    /**
     * @see ObjectModel::$definition
     */
    public static $definition = [
        'table'          => 'holiday_sale',
        'primary'        => 'id_holiday_sale',
        'multilang'      => true,
        'fields'         => [
            'id_holiday_sale' => ['type' => self::TYPE_INT, 'lang' => false],
            'id_shop' => ['type' => self::TYPE_INT, 'lang' => false],
            'banner_image' => ['type' => self::TYPE_STRING, 'lang' => false],
            'banner_image_font_color' => ['type' => self::TYPE_STRING, 'lang' => false],
            'page_background_color' => ['type' => self::TYPE_STRING, 'lang' => false],
            'page_font_color' => ['type' => self::TYPE_STRING, 'lang' => false],
            'use_countdown' => ['type' => self::TYPE_INT, 'lang' => false],
            'hide_products' => ['type' => self::TYPE_INT, 'lang' => false],
            'release_date' => ['type' => self::TYPE_STRING, 'lang' => false],
            'end_date' => ['type' => self::TYPE_STRING, 'lang' => false],

            'title' => ['type' => self::TYPE_STRING, 'lang' => true, 'required' => true],
            'meta_title' => ['type' => self::TYPE_STRING, 'lang' => true],
            'meta_description' => ['type' => self::TYPE_HTML, 'lang' => true],
            'holiday_description' => ['type' => self::TYPE_HTML, 'lang' => true],
            'link_rewrite' => ['type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isLinkRewrite', 'required' => true, 'size' => 128],
            'starting_text' => ['type' => self::TYPE_STRING, 'lang' => true],
            'ending_text' => ['type' => self::TYPE_STRING, 'lang' => true],
        ],
    ];

    public $id;
    public $title;
    public $meta_title;
    public $meta_description;
    public $holiday_description;
    public $link_rewrite;
    public $starting_text;
    public $ending_text;
    public $use_countdown;
    public $release_date;
    public $end_date;
    public $banner_image;
    public $banner_image_font_color;
    public $page_background_color;
    public $page_font_color;
    public $hide_products;

    public function __construct($id = null, $id_lang = null, $id_shop = null){
        parent::__construct($id, $id_lang, $id_shop);

        $this->holiday_description = stripslashes($this->holiday_description);
    }

    public function addProducts(){
        
    }
}