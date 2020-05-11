<?php
/**
 * 2008 - 2018 (c) Prestablog
 *
 * MODULE PrestaBlog
 *
 * @author    Prestablog
 * @copyright Copyright (c) permanent, Prestablog
 * @license   Commercial
 * @version    3.7.6
 
 */

class NewsClass extends ObjectModel
{
	public $id;
	public $id_shop = 1;
	public $title;
	public $langues;
	public $paragraph;
	public $content;
	public $content2;
	public $content3;
	public $date;
	public $meta_title;
	public $meta_description;
	public $meta_keywords;
	public $link_rewrite;
	public $categories = array();
	public $products_liaison = array();
	public $products_liaison2 = array();
	public $products_liaison3 = array();
	public $articles_liaison = array();
	public $slide = 0;
	public $actif = null;
	public $actif_langue = 0;
	public $read = 0;
	public $is_product_slide_1 = 1;
	public $is_product_slide_2 = 1;
	public $is_product_slide_3 = 1;
	public $url_redirect = '';
	public $author_name;
	public $author_desc;
	public $writer_id;

	protected $table = 'prestablog_news';
	protected $identifier = 'id_prestablog_news';

	public static $table_static = 'prestablog_news';
	public static $identifier_static = 'id_prestablog_news';

	public static $definition = array(
		'table' => 'prestablog_news',
		'primary' => 'id_prestablog_news',
		'multilang' => true,
		'fields' => array(
			'id_shop' =>			array('type' => self::TYPE_INT, 		'validate' => 'isunsignedInt', 'required' => true),
			'date' =>				array('type' => self::TYPE_DATE,		'validate' => 'isDateFormat',		'required' => true),
			'langues' =>			array('type' => self::TYPE_STRING,	'validate' => 'isSerializedArray',	'required' => true),
			'slide' =>				array('type' => self::TYPE_BOOL,		'validate' => 'isBool',				'required' => true),
			'actif' =>				array('type' => self::TYPE_BOOL,		'validate' => 'isBool',				'required' => true),
			'url_redirect' =>		array('type' => self::TYPE_STRING,	'validate' => 'isAbsoluteUrl'),

			'title' =>				array('type' => self::TYPE_STRING,	'lang' => true, 'validate' => 'isString',	'size' => 255),
			'meta_title' =>			array('type' => self::TYPE_STRING,	'lang' => true, 'validate' => 'isString',	'size' => 255),
			'meta_description' =>	array('type' => self::TYPE_STRING,	'lang' => true, 'validate' => 'isString',	'size' => 255),
			'meta_keywords' =>		array('type' => self::TYPE_STRING,	'lang' => true, 'validate' => 'isString',	'size' => 255),
			'link_rewrite' =>		array('type' => self::TYPE_STRING,	'lang' => true, 'validate' => 'isLinkRewrite',	'size' => 255),
			'content' =>			array('type' => self::TYPE_HTML,	'lang' => true, 'validate' => 'isString'),
			'content2' =>			array('type' => self::TYPE_HTML,	'lang' => true, 'validate' => 'isString'),
			'content3' =>			array('type' => self::TYPE_HTML,	'lang' => true, 'validate' => 'isString'),
			'paragraph' =>			array('type' => self::TYPE_HTML,	'lang' => true, 'validate' => 'isString'),
			'is_product_slide_1' =>	array('type' => self::TYPE_BOOL,		'validate' => 'isBool'),
			'is_product_slide_2' =>	array('type' => self::TYPE_BOOL,		'validate' => 'isBool'),
			'is_product_slide_3' =>	array('type' => self::TYPE_BOOL,		'validate' => 'isBool'),
			'author_name' =>	array('type' => self::TYPE_STRING,	'lang' => true, 'validate' => 'isString'),
			'author_desc' =>	array('type' => self::TYPE_STRING,	'lang' => true, 'validate' => 'isString'),
			'writer_id' =>			array('type' => self::TYPE_INT, 		'required' => true),
			/*'read' =>				array('type' => self::TYPE_INT, 	'lang' => true, 'validate' => 'isunsignedInt', 'required' => true), */
		)
	);

	public function copyFromPost()
	{
		$object = $this;
		$table = $this->table;

		/* Classical fields */
		foreach ($_POST as $key => $value)
			if (array_key_exists($key, $object) && $key != 'id_'.$table)
			{
				/* Do not take care of password field if empty */
				if ($key == 'passwd' && Tools::getValue('id_'.$table) && empty($value))
					continue;
				/* Automatically encrypt password in MD5 */
				if ($key == 'passwd' && !empty($value))
					$value = Tools::encrypt($value);
				$object->{$key} = Tools::getValue($key);
			}

		/* Multilingual fields */
		$rules = call_user_func(array(get_class($object), 'getValidationRules'), get_class($object));
		if (count($rules['validateLang']))
		{
			$languages = Language::getLanguages(false);
			foreach ($languages as $language)
			{
				foreach (array_keys($rules['validateLang']) as $field)
				{
					if (Tools::getIsset($field.'_'.(int)$language['id_lang']))
						$object->{$field}[(int)$language['id_lang']] = Tools::getValue($field.'_'.(int)$language['id_lang']);
				}
			}
		}
	}

	public static function getCountListeAllNoLang($only_actif = 0, $only_slide = 0, $date_debut = null, $date_fin = null, $categorie = null)
	{
		$context = Context::getContext();
		$multiboutique_filtre = 'AND n.`id_shop` = '.(int)$context->shop->id;

		$actif = '';
		if ($only_actif)
			$actif = 'AND n.`actif` = 1';
		$slide = '';
		if ($only_slide)
			$slide = 'AND n.`slide` = 1';

		$verbose_categorie = '';
		if ($categorie)
			$verbose_categorie = 'AND cc.`categorie` = '.(int)$categorie;

		$between_date = '';
		if (!empty($date_debut) && !empty($date_fin))
			$between_date = 'AND TIMESTAMP(n.`date`) BETWEEN \''.pSQL($date_debut).'\' AND \''.pSQL($date_fin).'\'';
		elseif (empty($date_debut) && !empty($date_fin))
			$between_date = 'AND TIMESTAMP(n.`date`) <= \''.pSQL($date_fin).'\'';
		elseif (!empty($date_debut) && empty($date_fin))
			$between_date = 'AND TIMESTAMP(n.`date`) >= \''.pSQL($date_debut).'\'';

		$value = Db::getInstance(_PS_USE_SQL_SLAVE_)->GetRow('
		SELECT count(DISTINCT n.id_prestablog_news) as `count`
		FROM `'.bqSQL(_DB_PREFIX_.self::$table_static).'` n
		LEFT JOIN `'.bqSQL(_DB_PREFIX_).'prestablog_correspondancecategorie` cc
			ON (n.`'.bqSQL(self::$identifier_static).'` = cc.`news`)
		WHERE n.`'.bqSQL(self::$identifier_static).'` > 0
		'.$multiboutique_filtre.'
		'.$actif.'
		'.$slide.'
		'.$verbose_categorie.'
		'.$between_date);

		return $value['count'];
	}

	public static function getTitleNews($id, $id_lang)
	{
		if (empty($id_lang))
			$id_lang = (int)Configuration::get('PS_LANG_DEFAULT');

		$value = Db::getInstance(_PS_USE_SQL_SLAVE_)->GetRow('
			SELECT nl.`title`
			FROM `'.bqSQL(_DB_PREFIX_.self::$table_static).'` n
			JOIN `'.bqSQL(_DB_PREFIX_.self::$table_static).'_lang` nl
				ON (n.`'.bqSQL(self::$identifier_static).'` = nl.`'.bqSQL(self::$identifier_static).'`)
			WHERE
				nl.`id_lang` = '.(int)$id_lang.'
			AND	n.`'.bqSQL(self::$identifier_static).'` = '.(int)$id);

		return $value['title'];
	}

	public static function getProductLinkListe($news, $active = false)
	{
		$return1 = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT	`id_product`
		FROM `'.bqSQL(_DB_PREFIX_.self::$table_static).'_product`
		WHERE `'.bqSQL(self::$identifier_static).'` = '.(int)$news);

		$return2 = array();
		foreach ($return1 as $value)
		{
			$product = new Product((int)$value['id_product']);

			if ((int)$product->id)
			{
				if ($active)
				{
					if ($product->active)
						$return2[] = $value['id_product'];
				}
				else
					$return2[] = $value['id_product'];
			}
			else
				NewsClass::removeProductLinkDeleted((int)$value['id_product']);
		}
		return $return2;
	}

	public static function getProductLinkListe2($news, $active = false)
	{
		$return1 = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT	`id_product`
		FROM `'.bqSQL(_DB_PREFIX_.self::$table_static).'_product2`
		WHERE `'.bqSQL(self::$identifier_static).'` = '.(int)$news);

		$return2 = array();
		foreach ($return1 as $value)
		{
			$product = new Product((int)$value['id_product']);

			if ((int)$product->id)
			{
				if ($active)
				{
					if ($product->active)
						$return2[] = $value['id_product'];
				}
				else
					$return2[] = $value['id_product'];
			}
			else
				NewsClass::removeProductLinkDeleted((int)$value['id_product']);
		}
		return $return2;
	}

	public static function getProductLinkListe3($news, $active = false)
	{
		$return1 = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT	`id_product`
		FROM `'.bqSQL(_DB_PREFIX_.self::$table_static).'_product3`
		WHERE `'.bqSQL(self::$identifier_static).'` = '.(int)$news);

		$return2 = array();
		foreach ($return1 as $value)
		{
			$product = new Product((int)$value['id_product']);

			if ((int)$product->id)
			{
				if ($active)
				{
					if ($product->active)
						$return2[] = $value['id_product'];
				}
				else
					$return2[] = $value['id_product'];
			}
			else
				NewsClass::removeProductLinkDeleted((int)$value['id_product']);
		}
		return $return2;
	}

	public static function getArticleLinkListe($news, $active = false)
	{
		$return1 = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT	`id_prestablog_newslink`
		FROM `'.bqSQL(_DB_PREFIX_.self::$table_static).'_newslink`
		WHERE `'.bqSQL(self::$identifier_static).'` = '.(int)$news);

		$return2 = array();
		foreach ($return1 as $value)
		{
			$news = new NewsClass((int)$value['id_prestablog_newslink']);

			if ((int)$news->id)
			{
				if ($active)
				{
					if ($news->actif)
						$return2[] = $value['id_prestablog_newslink'];
				}
				else
					$return2[] = $value['id_prestablog_newslink'];
			}
			else
				NewsClass::removeArticleLinkDeleted((int)$value['id_prestablog_newslink']);
		}
		return $return2;
	}

	public static function getNewsProductLinkListe($product, $active = false)
	{
		$return1 = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT	np.`'.bqSQL(self::$identifier_static).'`
		FROM `'.bqSQL(_DB_PREFIX_.self::$table_static).'_product` np
		LEFT JOIN `'.bqSQL(_DB_PREFIX_.'prestablog_news').'` n ON (np.`id_prestablog_news` = n.`id_prestablog_news`)
		WHERE np.`id_product` = '.(int)$product.'
		ORDER BY n.`date` DESC');

		$return2 = array();
		foreach ($return1 as $value)
		{
			$news = new NewsClass((int)$value['id_prestablog_news']);

			if ($active)
			{
				if ($news->actif)
					$return2[] = $value['id_prestablog_news'];
			}
			else
				$return2[] = $value['id_prestablog_news'];
		}
		return $return2;
	}

	public static function getNewsArticleLinkListe($news, $active = false)
	{
		$return1 = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT	`'.bqSQL(self::$identifier_static).'`
		FROM `'.bqSQL(_DB_PREFIX_.self::$table_static).'_newslink`
		WHERE `id_prestablog_news_newslink` = '.(int)$news);

		$return2 = array();
		foreach ($return1 as $value)
		{
			$news = new NewsClass((int)$value['id_prestablog_news']);

			if ($active)
			{
				if ($news->actif)
					$return2[] = $value['id_prestablog_news'];
			}
			else
				$return2[] = $value['id_prestablog_news'];
		}
		return $return2;
	}

	public static function removeProductLinkDeleted($product)
	{
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('
						DELETE FROM `'.bqSQL(_DB_PREFIX_.self::$table_static).'_product`
						WHERE `id_product` = '.(int)$product);
	}

	public static function removeArticleLinkDeleted($news)
	{
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('
						DELETE FROM `'.bqSQL(_DB_PREFIX_.self::$table_static).'_newslink`
						WHERE `id_prestablog_newslink` = '.(int)$news);
	}

	public static function updateProductLinkNews($news, $product)
	{
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('
						INSERT INTO `'.bqSQL(_DB_PREFIX_.self::$table_static).'_product`
							(`'.bqSQL(self::$identifier_static).'`, `id_product`)
						VALUES ('.(int)$news.', '.(int)$product.')');
	}

	public static function updateProductLinkNews2($news, $product)
	{
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('
						INSERT INTO `'.bqSQL(_DB_PREFIX_.self::$table_static).'_product2`
							(`'.bqSQL(self::$identifier_static).'`, `id_product`)
						VALUES ('.(int)$news.', '.(int)$product.')');
	}

	public static function updateProductLinkNews3($news, $product)
	{
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('
						INSERT INTO `'.bqSQL(_DB_PREFIX_.self::$table_static).'_product3`
							(`'.bqSQL(self::$identifier_static).'`, `id_product`)
						VALUES ('.(int)$news.', '.(int)$product.')');
	}

	public static function updateArticleLinkNews($news, $newslink)
	{
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('
						INSERT INTO `'.bqSQL(_DB_PREFIX_.self::$table_static).'_newslink`
							(`'.bqSQL(self::$identifier_static).'`, `id_prestablog_newslink`)
						VALUES ('.(int)$news.', '.(int)$newslink.')');
	}

	public static function removeAllProductsLinkNews($news)
	{
		Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('
						DELETE FROM `'.bqSQL(_DB_PREFIX_.self::$table_static).'_product`
						WHERE `'.bqSQL(self::$identifier_static).'` = '.(int)$news);

		Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('
						DELETE FROM `'.bqSQL(_DB_PREFIX_.self::$table_static).'_product2`
						WHERE `'.bqSQL(self::$identifier_static).'` = '.(int)$news);

		Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('
						DELETE FROM `'.bqSQL(_DB_PREFIX_.self::$table_static).'_product3`
						WHERE `'.bqSQL(self::$identifier_static).'` = '.(int)$news);

		return true;
	}

	public static function removeAllArticlesLinkNews($news)
	{
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('
						DELETE FROM `'.bqSQL(_DB_PREFIX_.self::$table_static).'_newslink`
						WHERE `'.bqSQL(self::$identifier_static).'` = '.(int)$news);
	}

	public static function removeProductLinkNews($news, $product)
	{
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('
						DELETE FROM `'.bqSQL(_DB_PREFIX_.self::$table_static).'_product`
						WHERE `'.bqSQL(self::$identifier_static).'` = '.(int)$news.' AND `id_product` = '.(int)$product);
	}

	public static function removeArticleLinkNews($news, $newslink)
	{
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('
						DELETE FROM `'.bqSQL(_DB_PREFIX_.self::$table_static).'_newslink`
						WHERE `'.bqSQL(self::$identifier_static).'` = '.(int)$news.' AND `id_prestablog_newslink` = '.(int)$newslink);
	}

	public static function getCountListeAll($id_lang = null,
														$only_actif = 0,
														$only_slide = 0,
														$date_debut = null,
														$date_fin = null,
														$categorie = null,
														$actif_langue = 0,
														$search = '')
	{
		$context = Context::getContext();
		$multiboutique_filtre = ' AND n.`id_shop` = '.(int)$context->shop->id;

		$actif = '';
		if ($only_actif)
			$actif = ' AND n.`actif` = 1';
		$actif_lang = '';
		if ($actif_langue)
			$actif_lang = ' AND nl.`actif_langue` = 1';
		$slide = '';
		if ($only_slide)
			$slide = ' AND n.`slide` = 1';

		$verbose_categorie = '';
		if ($categorie != null)
		{
			if (is_array($categorie))
			{
				$verbose_categorie = ' AND (';
				foreach ($categorie as $value)
					$verbose_categorie .= ' cc.`categorie` = '.(int)$value.' OR';
				$verbose_categorie = rtrim($verbose_categorie, 'OR');
				$verbose_categorie .= ')';
			}
			elseif (is_int($categorie))
				$verbose_categorie = ' AND cc.`categorie` = '.(int)$categorie;
		}

		$between_date = '';
		if (!empty($date_debut) && !empty($date_fin))
			$between_date = ' AND TIMESTAMP(n.`date`) BETWEEN \''.pSQL($date_debut).'\' AND \''.pSQL($date_fin).'\'';
		elseif (empty($date_debut) && !empty($date_fin))
			$between_date = ' AND TIMESTAMP(n.`date`) <= \''.pSQL($date_fin).'\'';
		elseif (!empty($date_debut) && empty($date_fin))
			$between_date = ' AND TIMESTAMP(n.`date`) >= \''.pSQL($date_debut).'\'';

		$lang = '';
		if (empty($id_lang))
			$lang = ' AND nl.`id_lang` = '.(int)Configuration::get('PS_LANG_DEFAULT');
		elseif (is_array($id_lang))
		{
			if (count($id_lang) > 0)
			{
				foreach ($id_lang as $lang_id)
					$lang = ' AND nl.`id_lang` = '.(int)$lang_id.' ';
			}
		}
		else
		{
			if ((int)$id_lang == 0)
				$lang = '';
			else
				$lang = ' AND nl.`id_lang` = '.(int)$id_lang;
		}

		// cc.`categorie`
		$filtre_groupes = PrestaBlog::getFiltreGroupes('cc.`categorie`');

		$search_sql = '';
		if ($search != '')
		{
			$from_fields = array(
				'nl.`title`',
				'nl.`content`',
				'nl.`paragraph`',
			);
			$search_sql = PrestaBlog::createSqlFilterSearch($from_fields, $search, 3);
		}

		$value = Db::getInstance(_PS_USE_SQL_SLAVE_)->GetRow('
		SELECT count(DISTINCT nl.id_prestablog_news) as `count`
		FROM `'.bqSQL(_DB_PREFIX_.self::$table_static).'_lang` nl
		LEFT JOIN `'.bqSQL(_DB_PREFIX_.self::$table_static).'` n
			ON (n.`'.bqSQL(self::$identifier_static).'` = nl.`'.bqSQL(self::$identifier_static).'`)
		LEFT JOIN `'.bqSQL(_DB_PREFIX_).'prestablog_correspondancecategorie` cc
			ON (n.`'.bqSQL(self::$identifier_static).'` = cc.`news`)
		WHERE 1=1
		'.$filtre_groupes.'
		'.$search_sql.'
		'.$multiboutique_filtre.'
		'.$lang.'
		'.$actif.'
		'.$actif_lang.'
		'.$slide.'
		'.$verbose_categorie.'
		'.$between_date);

		return $value['count'];
	}

	public static function getListe($id_lang = null,
												$only_actif = 0,
												$only_slide = 0,
												$limit_start = 0,
												$limit_stop = null,
												$tri_champ = 'n.`date`',
												$tri_ordre = 'desc',
												$date_debut = null,
												$date_fin = null,
												$categorie = null,
												$actif_langue = 0,
												$title_length = 80,
												$intro_length = 150,
												$search = '')
	{
		$context = Context::getContext();
		$multiboutique_filtre = ' AND n.`id_shop` = '.(int)$context->shop->id;

		$module = new PrestaBlog();

		$liste = array();

		$actif = '';
		if ($only_actif)
			$actif = ' AND n.`actif` = 1';
		$actif_lang = '';
		if ($actif_langue)
			$actif_lang = ' AND nl.`actif_langue` = 1';
		$slide = '';
		if ($only_slide)
			$slide = ' AND n.`slide` = 1';

		$cat = '';
		if ($categorie != null)
		{
			if (is_array($categorie))
			{
				$cat = ' AND (';
				foreach ($categorie as $value)
					$cat .= ' cc.`categorie` = '.(int)$value.' OR';
				$cat = rtrim($cat, 'OR');
				$cat .= ')';
			}
			elseif (is_int($categorie))
				$cat = ' AND cc.`categorie` = '.(int)$categorie;
		}

		$between_date = '';
		if (!empty($date_debut) && !empty($date_fin))
			$between_date = ' AND TIMESTAMP(n.`date`) BETWEEN \''.pSQL($date_debut).'\' AND \''.pSQL($date_fin).'\'';
		elseif (empty($date_debut) && !empty($date_fin))
			$between_date = ' AND TIMESTAMP(n.`date`) <= \''.pSQL($date_fin).'\'';
		elseif (!empty($date_debut) && empty($date_fin))
			$between_date = ' AND TIMESTAMP(n.`date`) >= \''.pSQL($date_debut).'\'';

		$limit = '';
		if (!empty($limit_stop))
			$limit = ' LIMIT '.(int)$limit_start.', '.(int)$limit_stop;

		$lang = '';
		if (empty($id_lang))
			$lang = ' AND nl.`id_lang` = '.(int)Configuration::get('PS_LANG_DEFAULT');
		elseif (is_array($id_lang))
		{
			if (count($id_lang) > 0)
			{
				foreach ($id_lang as $lang_id)
					$lang = ' AND nl.`id_lang` = '.(int)$lang_id.' ';
			}
		}
		else
		{
			if ((int)$id_lang == 0)
				$lang = '';
			else
				$lang = ' AND nl.`id_lang` = '.(int)$id_lang;
		}

		// cc.`categorie`
		$filtre_groupes = PrestaBlog::getFiltreGroupes('cc.`categorie`');

		$search_sql = '';
		if ($search != '')
		{
			$from_fields = array(
				'nl.`title`',
				'nl.`content`',
				'nl.`paragraph`',
			);
			$search_sql = PrestaBlog::createSqlFilterSearch($from_fields, $search, 3);
		}

		$sql = 'SELECT	DISTINCT(nl.`id_prestablog_news`), n.*, nl.*,
				LEFT(nl.`title`, '.(int)$title_length.') as title,
				(
					SELECT count(cn.`id_prestablog_commentnews`)
					FROM `'.bqSQL(_DB_PREFIX_).'prestablog_commentnews` cn
					WHERE cn.`news` = n.`id_prestablog_news`
						AND cn.`actif` = 1
				) as count_comments,
				n.`'.bqSQL(self::$identifier_static).'` as `id`
		FROM `'.bqSQL(_DB_PREFIX_.self::$table_static).'_lang` nl
		LEFT JOIN `'.bqSQL(_DB_PREFIX_.self::$table_static).'` n
			ON (n.`'.bqSQL(self::$identifier_static).'` = nl.`'.bqSQL(self::$identifier_static).'`)
		LEFT JOIN `'.bqSQL(_DB_PREFIX_).'prestablog_correspondancecategorie` cc
			ON (n.`'.bqSQL(self::$identifier_static).'` = cc.`news`)
		WHERE 1=1
		'.$filtre_groupes.'
		'.$search_sql.'
		'.$multiboutique_filtre.'
		'.$lang.'
		'.$actif.'
		'.$actif_lang.'
		'.$slide.'
		'.$cat.'
		'.$between_date.'
		ORDER BY '.pSQL($tri_champ).' '.pSQL($tri_ordre).'
		'.$limit;

		$liste = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql);

		if (count($liste) > 0)
		{
			foreach ($liste as $key => $value)
			{
				$liste[$key]['categories'] = CorrespondancesCategoriesClass::getCategoriesListeName((int)$value['id_prestablog_news'],
					(int)$context->language->id, 1);

				$liste[$key]['paragraph'] = $value['paragraph'];
				$liste[$key]['paragraph_crop'] = $value['paragraph'];

				if ((Tools::strlen(trim($value['paragraph'])) == 0)
					&&	(Tools::strlen(trim(strip_tags($value['content']))) >= 1))
					$liste[$key]['paragraph_crop'] = trim(strip_tags(html_entity_decode($value['content'])));

				if (Tools::strlen(trim($liste[$key]['paragraph_crop'])) > (int)$intro_length)
					$liste[$key]['paragraph_crop'] = PrestaBlog::cleanCut($liste[$key]['paragraph_crop'], (int)$intro_length, ' [...]');
				if (file_exists($module->module_path.'/views/img/'.Configuration::get($module->name.'_theme').'/up-img/'
					.$value[self::$identifier_static].'.jpg'))
					$liste[$key]['image_presente'] = 1;
				if (Tools::strlen(trim($value['content'])) >= 1)
					$liste[$key]['link_for_unique'] = 1;
			}
		}

		return $liste;
	}

	public function registerTablesBdd()
	{
		if (!Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('
		CREATE TABLE IF NOT EXISTS `'.bqSQL(_DB_PREFIX_.$this->table).'` (
		`'.bqSQL($this->identifier).'` int(10) unsigned NOT null auto_increment,
		`id_shop` int(10) unsigned NOT null,
		`date` datetime NOT null,
		`date_modification` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
		`langues` text NOT null,
		`actif` tinyint(1) NOT null DEFAULT \'1\',
		`slide` tinyint(1) NOT null DEFAULT \'0\',
		`url_redirect` text NOT null,
		PRIMARY KEY (`'.bqSQL($this->identifier).'`))
		ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8'))
			return false;

		if (!Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('
		CREATE TABLE IF NOT EXISTS `'.bqSQL(_DB_PREFIX_.$this->table).'_lang` (
		`'.bqSQL($this->identifier).'` int(10) unsigned NOT null,
		`id_lang` int(10) unsigned NOT null,
		`title` varchar(255) NOT null,
		`paragraph` text NOT null,
		`content` mediumtext NOT null,
		`content2` longtext null,
		`content3` longtext null,
		`meta_description` text NOT null,
		`meta_keywords` text NOT null,
		`meta_title` text NOT null,
		`link_rewrite` text NOT null,
		`actif_langue` tinyint(1) NOT null DEFAULT \'1\',
		`read` int(10) unsigned NOT null DEFAULT \'0\',
		PRIMARY KEY (`'.bqSQL($this->identifier).'`, `id_lang`))
		ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8'))
			return false;

		if (!Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('
		CREATE TABLE IF NOT EXISTS `'.bqSQL(_DB_PREFIX_.$this->table).'_product` (
		`'.bqSQL($this->identifier).'_product` int(10) unsigned NOT null auto_increment,
		`'.bqSQL($this->identifier).'` int(10) unsigned NOT null,
		`id_product` int(10) unsigned NOT null,
		PRIMARY KEY (`'.bqSQL($this->identifier).'_product`))
		ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8'))
			return false;

		if (!Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('
		CREATE TABLE IF NOT EXISTS `'.bqSQL(_DB_PREFIX_.$this->table).'_product2` (
		`'.bqSQL($this->identifier).'_product` int(10) unsigned NOT null auto_increment,
		`'.bqSQL($this->identifier).'` int(10) unsigned NOT null,
		`id_product` int(10) unsigned NOT null,
		PRIMARY KEY (`'.bqSQL($this->identifier).'_product`))
		ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8'))
			return false;

		if (!Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('
		CREATE TABLE IF NOT EXISTS `'.bqSQL(_DB_PREFIX_.$this->table).'_product3` (
		`'.bqSQL($this->identifier).'_product` int(10) unsigned NOT null auto_increment,
		`'.bqSQL($this->identifier).'` int(10) unsigned NOT null,
		`id_product` int(10) unsigned NOT null,
		PRIMARY KEY (`'.bqSQL($this->identifier).'_product`))
		ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8'))
			return false;

		if (!Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('
		CREATE TABLE IF NOT EXISTS `'.bqSQL(_DB_PREFIX_).'prestablog_news_newslink` (
		`id_prestablog_news_newslink` int(10) unsigned NOT null auto_increment,
		`id_prestablog_news` int(10) unsigned NOT null,
		`id_prestablog_newslink` int(10) unsigned NOT null,
		PRIMARY KEY (`id_prestablog_news_newslink`))
		ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8'))
			return false;

		$langues = Language::getLanguages(true);
		if (count($langues) > 0)
		{
			$langue_use = array();
			foreach ($langues as $value)
				$langue_use[] = (int)$value['id_lang'];

			if (!Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('
				INSERT INTO `'.bqSQL(_DB_PREFIX_.$this->table).'`
					(`'.bqSQL($this->identifier).'`, `id_shop`, `date` , `langues` , `actif`, `slide`)
				VALUES
					(1, 1, DATE_ADD(NOW(), INTERVAL -3 DAY), \''.serialize($langue_use).'\', 1, 1)'))
				return false;

			$title = Array (
				1 => 'Curabitur venenatis ut elit quis tempus, sed eget sem pretium',
			);

			$paragraph = Array (
				1 => 'Praesent fringilla adipiscing leo. Vestibulum eget venenatis risus. Aliquam tristique erat ac odio
				suscipit tempus. Nullam faucibus libero tortor, eget volutpat lacus molestie non',
			);

			$content = Array (
				1 => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eget pretium lectus, sed bibendum augue.
				In sollicitudin convallis blandit.</p><h2>Curabitur venenatis ut elit quis tempus.</h2><p>Sed eget sem pretium,
				consequat ante sit amet, accumsan nunc. Vestibulum adipiscing dapibus tortor, eget lacinia neque dapibus auctor.
				Integer a dui in tellus dignissim dictum eu eu orci. Integer venenatis libero a justo rutrum, eu facilisis libero
				aliquam. Praesent sit amet elit nunc. Vestibulum aliquam turpis tellus, sed sagittis velit suscipit molestie.
				Nullam eleifend convallis sodales. Aenean est magna, molestie quis viverra vitae, hendrerit nec dui.</p>
				<p><strong>Praesent fringilla adipiscing leo. </strong></p><p>Vestibulum eget venenatis risus. Aliquam
				tristique erat ac odio suscipit tempus. Nullam faucibus libero tortor, eget volutpat lacus molestie non.<br />
				<em>Phasellus euismod eu urna nec aliquet.</em></p><p>Aenean in rutrum dolor. Nulla eleifend pulvinar mauris,
				hendrerit tempus odio pretium vitae. Suspendisse blandit volutpat nisi. Pellentesque dignissim nibh consectetur
				metus rhoncus, eget venenatis ligula convallis. Fusce ullamcorper augue nec semper gravida.</p><p>Pellentesque
				semper leo at nulla commodo sodales. Integer purus sem, scelerisque in commodo eu, volutpat a nisi. Fusce placerat
				orci in neque condimentum, non consectetur massa adipiscing. Aenean vestibulum eros a ligula mattis imperdiet.
				Aenean sapien nibh, cursus ut mattis in, eleifend non diam.</p><h3>Vestibulum aliquam sem diam, eu sagittis
				quam luctus eu.</h3><p><img src="/modules/prestablog/views/img/demo/photo-mode.jpg" alt="photo de mode"
				style="display: block; margin-left: auto; margin-right: auto;" /></p><p>Suspendisse porta libero et
				est fringilla commodo. Donec congue massa in nisi aliquet dapibus. Cras aliquet posuere justo,
				a iaculis orci malesuada a. Ut ultricies tempus tempor. Pellentesque sit amet purus et tortor
				eleifend hendrerit. Curabitur aliquet rhoncus dolor, eget mollis ante malesuada eget. Suspendisse
				id orci est. Nulla erat sapien, aliquam porta pharetra at, ultricies id odio. Nam sed libero id magna egestas
				sodales vel quis ipsum. Mauris sit amet mauris eu odio sodales venenatis. Mauris consequat dolor nisi, at
				pharetra diam sollicitudin vitae. Pellentesque habitant morbi tristique senectus et netus et malesuada fames
				ac turpis egestas. Sed nec felis porttitor, facilisis metus sit amet, aliquam ipsum. Phasellus sed ante non
				nunc commodo fermentum et nec odio. Maecenas eleifend venenatis iaculis.</p><ul><li>Nulla facilisi. Fusce at
				consequat odio.</li><li>Donec id fermentum urna.</li><li>Integer nec augue volutpat</li></ul>
				<p><img class="f_left" src="/modules/prestablog/views/img/demo/photo-mode2.jpg" alt="photo de mode 2"
				style="display: block; margin-left: auto; margin-right: auto;" /></p><p> ultrices ipsum at, elementum nisi.
				Nam vel eros eu dui mollis ultrices.</p><p>Cras venenatis fermentum mauris, quis faucibus arcu.
				Aenean a lectus vel dui dapibus gravida quis a urna. Curabitur euismod arcu nec est fringilla commodo.
				Morbi consectetur id enim vel sagittis. Aenean at velit at lacus blandit volutpat. Aliquam in nibh enim.
				Sed ligula nisi, porttitor et vehicula ut, mattis id mauris.</p><h4>Aenean iaculis nibh ac lobortis dignissim.</h4>
				<p>In posuere pharetra libero, scelerisque iaculis purus cursus eget. Morbi sed vestibulum enim.</p>
				<ol><li>Ut facilisis nibh vel tortor malesuada commodo.</li><li>Maecenas pretium tincidunt eros vel elementum. </li>
				<li>Pellentesque in lectus lectus. </li><li>Nullam ac metus libero. Ut magna lorem, pulvinar ut dictum semper,
				vulputate a magna.</li></ol><p>Aliquam volutpat est urna, eget feugiat ante suscipit in. In varius tortor eu
				nunc volutpat, sit amet hendrerit tellus accumsan. <strong>Nunc at feugiat massa, eu porttitor nisi.</strong>
				Duis neque dui, vulputate in gravida a, luctus convallis sem.</p><h2>All embed video possible : vimeo, youtube etc.</h2>
				<p><iframe src="https://player.vimeo.com/video/85251723" width="870" height="400"></iframe></p>',
			);

			$meta_description = Array (
				1 => 'Praesent fringilla adipiscing leo. Vestibulum eget venenatis risus.',
			);

			$meta_keywords = Array (
				1 => 'Curabitur, venenatis, ut elit, quis tempus, sed eget, sem pretium',
			);

			$meta_title = Array (
				1 => 'Curabitur venenatis ut elit quis tempus, sed eget sem pretium',
			);

			$link_rewrite = Array (
				1 => 'curabitur-venenatis-ut-elit-quis-tempus-sed-eget-sem-pretium',
			);

			$sql_values = 'VALUES ';
			for ($i = 1; $i <= 1; $i++)
				foreach ($langues as $value)
					$sql_values .= '
						(
							'.(int)$i.',
							'.(int)$value['id_lang'].',
							\''.$title[$i].'\',
							\''.pSQL($paragraph[$i]).'\',
							\''.$content[$i].'\',
							\''.pSQL($meta_description[$i]).'\',
							\''.pSQL($meta_keywords[$i]).'\',
							\''.pSQL($meta_title[$i]).'\',
							\''.pSQL($link_rewrite[$i]).'\',
							1
						),';

			$sql_values = rtrim($sql_values, ',');
			if (!Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('
				INSERT INTO `'.bqSQL(_DB_PREFIX_.$this->table).'_lang`
					(
						`'.bqSQL($this->identifier).'`,
						`id_lang`,
						`title`,
						`paragraph`,
						`content`,
						`meta_description`,
						`meta_keywords`,
						`meta_title`,
						`link_rewrite`,
						`actif_langue`
					)
				'.$sql_values))
				return false;
		}

		return true;
	}

	public function deleteTablesBdd()
	{
		if (!Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('DROP TABLE IF EXISTS `'.bqSQL(_DB_PREFIX_.$this->table).'`'))
			return false;
		if (!Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('DROP TABLE IF EXISTS `'.bqSQL(_DB_PREFIX_.$this->table).'_lang`'))
			return false;
		if (!Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('DROP TABLE IF EXISTS `'.bqSQL(_DB_PREFIX_.$this->table).'_product`'))
			return false;
		if (!Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('DROP TABLE IF EXISTS `'.bqSQL(_DB_PREFIX_.$this->table).'_newslink`'))
			return false;

		return true;
	}

	public function changeEtat($field)
	{
		if (!Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('
			UPDATE `'.bqSQL(_DB_PREFIX_.$this->table).'` SET `'.pSQL($field).'`=CASE `'.pSQL($field).'` WHEN 1 THEN 0 WHEN 0 THEN 1 END
			WHERE `'.bqSQL($this->identifier).'`='.(int)$this->id))
			return false;
		return true;
	}

	public function razEtatLangue($id_news)
	{
		if (!Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('
			UPDATE `'.bqSQL(_DB_PREFIX_.$this->table).'_lang` SET `actif_langue` = 0
			WHERE `'.bqSQL($this->identifier).'`= '.(int)$id_news))
			return false;

		return true;
	}

	public function changeActiveLangue($id_news, $id_lang)
	{
		if (!Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('
			UPDATE `'.bqSQL(_DB_PREFIX_.$this->table).'_lang` SET `actif_langue` = 1
			WHERE `'.bqSQL($this->identifier).'`= '.(int)$id_news.'
			AND `id_lang` = '.(int)$id_lang))
			return false;

		return true;
	}

	public function incrementRead($id_news, $id_lang)
	{
		if (!Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('
			UPDATE `'.bqSQL(_DB_PREFIX_.$this->table).'_lang` SET `read` = (`read` + 1)
			WHERE `'.bqSQL($this->identifier).'`= '.(int)$id_news.'
			AND `id_lang` = '.(int)$id_lang))
			return false;

		return true;
	}

	public static function getRead($id_news, $id_lang)
	{
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
			SELECT `read`
			FROM `'.bqSQL(_DB_PREFIX_.self::$table_static).'_lang`
			WHERE `'.bqSQL(self::$identifier_static).'`= '.(int)$id_news.'
			AND `id_lang` = '.(int)$id_lang);
		return (int)$row['read'];
	}

}
