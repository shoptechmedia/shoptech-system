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
    die('Not Allowed, GoogleCategoryBlMod');
}

class GoogleCategoryBlMod
{
    public $lang = '';
    public $path = '';

    public function __construct($type = 'google', $language = 'en-US')
    {
        if ($type == 'marktplaats') {
            $language = 'nl-NL';
        }

        $this->lang = $language;
        $this->path = _PS_MODULE_DIR_.'xmlfeeds/ga_categories/'.$type.'-'.$this->lang.'.txt';
    }

    public function getList()
    {
        $file = $this->readFile();

        if (empty($file)) {
            return false;
        }

        return $file;
    }

    private function readFile()
    {
        $categories = array();
        $isFirstRow = true;

        if (is_file($this->path) && is_readable($this->path)) {
            $handle = fopen($this->path, 'r');
        }

        if (empty($handle)) {
            return false;
        }

        while (($data = fgetcsv($handle, 1000, '-')) !== false) {
            if ($isFirstRow) {
                $isFirstRow = false;
                continue;
            }

            $id = trim($data[0]);
            unset($data[0]);
            $categories[$id] = trim(implode('-', $data));
        }

        return $categories;
    }
}
