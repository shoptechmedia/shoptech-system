<?php

class Cart extends CartCore
{
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    public function resetCartDiscountCache()
    {
        self::$_discounts     = NULL;
        self::$_discountsLite = NULL;
    }
}
