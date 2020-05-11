CREATE TABLE IF NOT EXISTS `PREFIX_ntreduction` (
    `id_ntreduction` int(10) unsigned NOT NULL auto_increment,
    `id_specific_price` int(10) unsigned,
    `on_sale` tinyint(1),
    `monday` tinyint(1),
    `tuesday` tinyint(1),
    `wednesday` tinyint(1),
    `thursday` tinyint(1),
    `friday` tinyint(1),
    `saturday` tinyint(1),
    `sunday` tinyint(1),
	`id_product` int(10) unsigned,
	`id_shop` int(11) unsigned NOT NULL DEFAULT '1',
	`id_currency` int(10) unsigned,
	`id_country` int(10) unsigned,
	`id_group` int(10) unsigned,
	`id_customer` int(10) unsigned,
	`id_product_attribute` int(10) unsigned,
	`price` decimal(20,6),
	`from_quantity` mediumint(8) unsigned,
	`reduction` decimal(20,6),
	`reduction_type` enum('amount','percentage'),
	`from` datetime,
	`to` datetime,
    PRIMARY KEY (`id_ntreduction`)
) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_ntreduction_informations` (
    `id_ntreduction_informations` int(10) unsigned NOT NULL auto_increment,
	`id_product` int(10) unsigned,
	`init_price` decimal(20,6),
    PRIMARY KEY (`id_ntreduction_informations`)
) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;


