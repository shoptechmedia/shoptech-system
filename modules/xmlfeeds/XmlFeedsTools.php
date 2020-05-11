<?php
/**
 * 2010-2018 Bl Modules.
 *
 * If you wish to customize this module for your needs,
 * please contact the authors first for more information.
 *
 * It's not allowed selling, reselling or other ways to share
 * this file or any other module files without author permission.
 *
 * @author    Bl Modules
 * @copyright 2010-2018 Bl Modules
 * @license
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class XmlFeedsTools
{
    const ITEM_IN_PAGE = 50;
    public static $pageName = '1';

    public static function pagination($page = 1, $maxInPage = 10, $totalInvoice = 0, $pageAddress = false, $selectorName = 'page')
    {
        $currentPage = $page;
        $html = '<div class = "pagination">';

        if (empty($page)) {
            $page = 1;
            $currentPage = 1;
        }

        if ($maxInPage >= $totalInvoice) {
            $html .= '</div>';
            return array (0, $maxInPage, $html);
        }

        $start = ($maxInPage * $page) - $maxInPage;

        if ($totalInvoice <= $maxInPage) {
            $num_of_pages = 1;
        } elseif (($totalInvoice % $maxInPage) == 0) {
            $num_of_pages = $totalInvoice / $maxInPage;
        } else {
            $num_of_pages = $totalInvoice / $maxInPage + 1;
        }

        if ($currentPage > 1) {
            $back = $currentPage - 1;
            $html .= '<a href = "'.$pageAddress.$selectorName.'='.$back.'">«</a>' . ' ';
        }

        $html .= '|';
        $num_of_pages_f = (int)$num_of_pages;

        if ($currentPage - 4 > 1) {
            $html .= '<a href = "'.$pageAddress.$selectorName.'=1">1</a>|';
        }

        if ($currentPage - 5 > 1) {
            $html .= ' ... |';
        }

        $firs_element = $currentPage - 4;

        if ($firs_element < 1) {
            $firs_element = 1;
        }

        for ($i = $firs_element; $i < $currentPage; $i++) {
            $html .= '<a href = "'.$pageAddress.$selectorName.'='.$i.'">'.$i.'</a>|';
        }

        $html .= ' '.$currentPage . ' |';

        for ($i = $currentPage + 1; $i < $currentPage + 5; $i++) {
            if ($i > $num_of_pages_f) {
                break;
            }

            $html .= '<a href = "'.$pageAddress.$selectorName.'='.$i.'">'.$i.'</a>|';
        }

        if ($currentPage + 5 < $num_of_pages_f) {
            $html .= ' ... |';
        }

        if ($currentPage + 4 < $num_of_pages_f) {
            $html .= '<a href = "'.$pageAddress.$selectorName.'='.$num_of_pages_f.'">'.$num_of_pages_f.'</a>|';
        }

        if ($currentPage + 1 < $num_of_pages) {
            $next = $currentPage + 1;
            $html .= '<a href = "'.$pageAddress.$selectorName.'='.$next.'">»</a>';
        }

        $html .= '</div>';

        return array ($start, $maxInPage, $html);
    }
}