<?php
/**
 * 2007-2016 PrestaShop
 *
 * Thirty Bees is an extension to the PrestaShop e-commerce software developed by PrestaShop SA
 * Copyright (C) 2017 Thirty Bees
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@thirtybees.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://www.thirtybees.com for more information.
 *
 * @author    Thirty Bees <contact@thirtybees.com>
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2017 Thirty Bees
 * @copyright 2007-2016 PrestaShop SA
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *  PrestaShop is an internationally registered trademark & property of PrestaShop SA
 */

/**
 * Class ValidateCore
 *
 * @since 1.0.0
 */
class Validate extends ValidateCore
{
    /**
     * Check for name validity
     *
     * @param string $name Name to validate
     *
     * @return bool Validity is ok or not
     *
     * @since   1.0.0
     * @version 1.0.0 Initial version
     */
    public static function isName($name)
    {
        return ! preg_match('/www|http/ui', $name)
            && preg_match(
                Tools::cleanNonUnicodeSupport('/^[^0-9!\[\]<>;?=+()@#"°{}_$%:\/\\\*\^]*$/u'),
                $name
            );
    }

    /**
     * Check for price validity
     *
     * @param string $price Price to validate
     *
     * @return bool Validity is ok or not
     *
     * @since 1.0.0
     * @since 1.1.0 Also test for proper rounding, in development mode only.
     */
    public static function isPrice($price)
    {
        $result = (bool) preg_match('/^[0-9]{1,10}(\.[0-9]{1,9})?$/', $price);

        // Test for proper rounding. For retrocompatibility with modules and
        // for the time being, do this in development mode, only.
        if ($result
            && (_PS_MODE_DEV_ || (defined('TESTS_RUNNING') && TESTS_RUNNING))) {
            $rounded = round($price, _TB_PRICE_DATABASE_PRECISION_);

            // $price might be a string, so cast to float, first.
            $result = ((string) (float) $price === (string) $rounded);
        }

        return $result;
    }

    /**
     * Check for price validity (including negative price)
     *
     * @param string $price Price to validate
     *
     * @return bool Validity is ok or not
     *
     * @since 1.0.0
     * @since 1.1.0 Also test for proper rounding, in development mode only.
     */
    public static function isNegativePrice($price)
    {
        $result = (bool) preg_match('/^[-]?[0-9]{1,10}(\.[0-9]{1,9})?$/', $price);

        // See isPrice().
        if ($result
            && (_PS_MODE_DEV_ || (defined('TESTS_RUNNING') && TESTS_RUNNING))) {
            $rounded = round($price, _TB_PRICE_DATABASE_PRECISION_);

            $result = ((string) (float) $price === (string) $rounded);
        }

        return $result;
    }
}