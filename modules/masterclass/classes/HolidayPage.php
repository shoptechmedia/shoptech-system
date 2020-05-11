<?php

if (!defined('_PS_VERSION_')){
	exit;
}

class HolidayPage extends ObjectModule{
    // @codingStandardsIgnoreStart
    /**
     * @see ObjectModel::$definition
     */
    public static $definition = [
        'table'          => 'holiday_sale',
        'primary'        => 'id_holiday_sale',
        'multilang'      => true,
        'fields'         => [
            'description' => ['type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName',                     'size' => 255],
            'title'       => ['type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'required' => true, 'size' => 128],
            'link_rewrite'     => ['type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isLinkRewrite', 'required' => true, 'size' => 128],
        ],
    ];

    public $title;
    public $description;
    public $link_rewrite;
}