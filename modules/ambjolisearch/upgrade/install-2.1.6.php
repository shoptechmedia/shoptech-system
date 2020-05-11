<?php
/**
 *   AmbJoliSearch Module : Search for prestashop
 *
 *    @author    Ambris Informatique
 *    @copyright Copyright (c) 2013-2015 Ambris Informatique SARL
 *    @license   Commercial license
 *    @module     Advanced search (AmbJoliSearch)
 *    @file        ambjolisearch.php
 *    @subject     upgrade to 2.1.5
 *    Support by mail: support@ambris.com
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_2_1_6($object)
{
    $object;
    $query = '
				DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'ambjolisearch_synonyms`;
				CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ambjolisearch_synonyms` (
				  `id_synonym` int(10) unsigned NOT NULL AUTO_INCREMENT,
				  `synonym` varchar(15) NOT NULL,
				  `id_word` int(10) unsigned NOT NULL,
				  PRIMARY KEY (`id_synonym`),
				  UNIQUE KEY `unq_word_synonym` (`id_word`,`synonym`) USING BTREE,
				  KEY `id_word` (`id_word`),
				  KEY `idx_synonym` (`synonym`),
				  KEY `id_word_synonym` (`id_word`,`synonym`) USING BTREE
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;';

    $return = Db::getInstance()->execute($query);

    return $return;
}
