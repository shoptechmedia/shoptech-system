<?php
/**
 * 2010-2019 Bl Modules.
 *
 * If you wish to customize this module for your needs,
 * please contact the authors first for more information.
 *
 * It's not allowed selling, reselling or other ways to share
 * this file or any other module files without author permission.
 *
 * @author    Bl Modules
 * @copyright 2010-2019 Bl Modules
 * @license
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class FeedType
{
    public function getType($mode)
    {
        $types = $this->getAllTypes();

        return $types[$mode];
    }

    public function getAllTypes()
    {
        return array(
            'c' => array(
                'name' => 'Custom',
                'category_name' => '',
            ),
            'f' => array(
                'name' => 'Facebook',
                'category_name' => 'google',
            ),
            'g' => array(
                'name' => 'Google',
                'category_name' => 'google',
            ),
            's' => array(
                'name' => 'Skroutz',
                'category_name' => '',
            ),
            'i' => array(
                'name' => 'Siroop',
                'category_name' => '',
            ),
            'x' => array(
                'name' => 'Xikixi',
                'category_name' => '',
            ),
            'r' => array(
                'name' => 'Fruugo',
                'category_name' => 'fruugo',
            ),
            'h' => array(
                'name' => 'Hansabay',
                'category_name' => '',
            ),
            'm' => array(
                'name' => 'Sitemap',
                'category_name' => '',
            ),
            'a' => array(
                'name' => 'Marktplaats',
                'category_name' => 'marktplaats',
            ),
            'o' => array(
                'name' => 'Shoptet',
                'category_name' => '',
            ),
        );
    }
}