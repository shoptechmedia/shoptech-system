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

class AdminPrestaBlogAjaxController extends ModuleAdminController
{
	public function ajaxProcessPrestaBlogRun()
	{
		$current_lang = (int)$this->context->language->id;

		switch (Tools::getValue('do'))
		{
			case 'sortSubBlocks' :
				if (Tools::getValue('items') && Tools::getValue('hook_name'))
					SubBlocksClass::updatePositions(Tools::getValue('items'), Tools::getValue('hook_name'));
				break;
			case 'sortBlocs' :
				if (Tools::getValue('sortblocLeft'))
					$sort_bloc_left = serialize(Tools::getValue('sortblocLeft'));
				else
					$sort_bloc_left = serialize(array(0 => ''));

				if (Tools::getValue('sortblocRight'))
					$sort_bloc_right = serialize(Tools::getValue('sortblocRight'));
				else
					$sort_bloc_right = serialize(array(0 => ''));

				Configuration::updateValue('prestablog_sbl', $sort_bloc_left, false, null, (int)Tools::getValue('id_shop'));
				Configuration::updateValue('prestablog_sbl', $sort_bloc_left);
				Configuration::updateValue('prestablog_sbr', $sort_bloc_right, false, null, (int)Tools::getValue('id_shop'));
				Configuration::updateValue('prestablog_sbr', $sort_bloc_right);
				break;

			case 'loadProductsLink' :
				$prestablog = new PrestaBlog();
				if (Tools::getValue('req'))
				{
						$list_product_linked = array();
						$list_product_linked = preg_split('/;/', rtrim(Tools::getValue('req'), ';'));

						if (count($list_product_linked) > 0)
						{
							foreach ($list_product_linked as $product_link)
							{
								$product_search = new Product((int)$product_link, false, $current_lang);
								$product_cover = Image::getCover($product_search->id);
								$image_product = new Image((int)$product_cover['id_image']);
								$image_thumb_path = ImageManager::thumbnail(_PS_IMG_DIR_.'p/'.$image_product->getExistingImgPath().'.jpg',
									'product_mini_'.$product_search->id.'.jpg', 45, 'jpg');

								echo '
										<tr class="noInlisted_'.$product_search->id.'">
											<td class="'.($product_search->active ? '' : 'noactif ').'center">'.$product_search->id.'</td>
											<td class="'.($product_search->active ? '' : 'noactif ').'center">'.$image_thumb_path.'</td>
											<td class="'.($product_search->active ? '' : 'noactif ').'">'.$product_search->name.'</td>
											<td class="'.($product_search->active ? '' : 'noactif ').'center">
												<img src="../modules/prestablog/views/img/disabled.gif" rel="'.$product_search->id.'" class="delinked" />
											</td>
										</tr>'."\n";
							}
							echo '
								<script type="text/javascript">

									$(".productLinked2 img.delinked, .productLinked3 img.delinked").click(function() {
										var idP = $(this).attr("rel");
										var target = $(this).parent().parent().parent().attr("data-target");
										$("#"+target).find("input.linked_"+idP).remove();
										$(this).parent().parent().remove();
										if(target === "currentProductLink2"){
											ReloadLinkedProducts2();
											ReloadLinkedSearchProducts2();
										}
										if(target === "currentProductLink3"){
											ReloadLinkedProducts3();
											ReloadLinkedSearchProducts3();
										}
									});

									$("#productLinked img.delinked").click(function() {
										var idP = $(this).attr("rel");
										$("#currentProductLink input.linked_"+idP).remove();
										$("#productLinked .noInlisted_"+idP).remove();
										console.log($(this).parent());
										ReloadLinkedProducts();
										ReloadLinkedSearchProducts();
									});
								</script>'."\n";
						}
						else
							echo '<tr><td colspan="4" class="center">'.$prestablog->message_call_back['no_result_listed'].'</td></tr>'."\n";
				}
				else
					echo '<tr><td colspan="4" class="center">'.$prestablog->message_call_back['no_result_listed'].'</td></tr>'."\n";

				break;

			case 'loadArticlesLink' :
				$prestablog = new PrestaBlog();
				if (Tools::getValue('req'))
				{
						$list_article_linked = array();
						$list_article_linked = preg_split('/;/', rtrim(Tools::getValue('req'), ';'));

						if (count($list_article_linked) > 0)
						{
							foreach ($list_article_linked as $article_link)
							{
								$article_search = new NewsClass((int)$article_link, $current_lang);

								if (file_exists(dirname(__FILE__).'/../../views/img/'.Configuration::get('prestablog_theme').'/up-img/adminth_'
								.$article_search->id.'.jpg'))
									$thumbnail = '<img class="imgm img-thumbnail" src="../modules/prestablog/views/img/'.Configuration::get('prestablog_theme')
													.'/up-img/adminth_'.$article_search->id.'.jpg?'.md5(time()).'" />';
								else
									$thumbnail = '-';

								echo '
										<tr class="noInlisted_'.$article_search->id.'">
											<td class="'.($article_search->actif ? '' : 'noactif ').'center">'.$article_search->id.'</td>
											<td class="'.($article_search->actif ? '' : 'noactif ').'center">'.$thumbnail.'</td>
											<td class="'.($article_search->actif ? '' : 'noactif ').'">'.$article_search->title.'</td>
											<td class="'.($article_search->actif ? '' : 'noactif ').'center">
												<img src="../modules/prestablog/views/img/disabled.gif" rel="'.$article_search->id.'" class="delinked" />
											</td>
										</tr>'."\n";
							}
							echo '
								<script type="text/javascript">
									$("#articleLinked img.delinked").click(function() {
										var idN = $(this).attr("rel");
										$("#currentArticleLink input.linked_"+idN).remove();
										$("#articleLinked .noInlisted_"+idN).remove();
										ReloadLinkedArticles();
										ReloadLinkedSearchArticles();
									});
								</script>'."\n";
						}
						else
							echo '<tr><td colspan="4" class="center">'.$prestablog->message_call_back['no_result_listed'].'</td></tr>'."\n";
				}
				else
					echo '<tr><td colspan="4" class="center">'.$prestablog->message_call_back['no_result_listed'].'</td></tr>'."\n";

				break;

			case 'searchProducts' :
				if (Tools::getValue('req') != '')
				{
					if (Tools::strlen(Tools::getValue('req')) >= (int)Configuration::get('prestablog_nb_car_min_linkprod'))
					{
						$start = 0;
						$pas = (int)Configuration::get('prestablog_nb_list_linkprod');
						if (!$pas || $pas == 0)
							$pas = 5;

						if (Tools::getValue('start'))
							$start = (int)Tools::getValue('start');

						$end = (int)$pas + (int)$start;

						$list_product_linked = array();

						if (Tools::getValue('listLinkedProducts') != '')
							$list_product_linked = preg_split('/;/', rtrim(Tools::getValue('listLinkedProducts'), ';'));

						$result_search = array();
						$prestablog = new PrestaBlog();
						$rsql_search = '';
						$rsql_lang = '';

						$query = Tools::strtoupper(pSQL(Trim(Tools::getValue('req'))));
						$querys = array_filter(explode(' ', $query));

						$list_champs_product_lang = array(
//							'description',
//							'description_short',
//							'link_rewrite',
							'name',
//							'meta_title',
//							'meta_description',
//							'meta_keywords'
						);

						//foreach ($querys as $value)
						//{
							foreach ($list_champs_product_lang as $value_c)
								$rsql_search .= ' UPPER(pl.`'.pSQL($value_c).'`) LIKE \'%'.pSQL($query).'%\' OR';
						//}

						if (Tools::getValue('lang') != '')
							$current_lang = (int)Tools::getValue('lang');

						$rsql_lang = 'AND pl.`id_lang` = '.(int)$current_lang;
						$rsql_shop = 'AND ps.`id_shop` = '.(int)Tools::getValue('id_shop');

						$rsql_search = ' WHERE ('.rtrim($rsql_search, 'OR').') '.$rsql_lang.' '.$rsql_shop;

						$rsql_plink = '';

						foreach ($list_product_linked as $product_link)
							$rsql_plink .= ' AND pl.`id_product` <> '.(int)$product_link;

						$rsql_search .= $rsql_plink;

						$count_search = Db::getInstance(_PS_USE_SQL_SLAVE_)->GetRow('SELECT COUNT(DISTINCT pl.`id_product`) AS `value`
									FROM 	`'.bqSQL(_DB_PREFIX_).'product_lang` AS pl
									LEFT JOIN `'.bqSQL(_DB_PREFIX_).'product_shop` AS ps ON (ps.`id_product` = pl.`id_product`)
									'.$rsql_search.';');

						$rsql	=	'SELECT DISTINCT(pl.`id_product`)
									FROM 	`'.bqSQL(_DB_PREFIX_).'product_lang` AS pl
									LEFT JOIN `'.bqSQL(_DB_PREFIX_).'product_shop` AS ps ON (ps.`id_product` = pl.`id_product`)
									'.$rsql_search.'
									ORDER BY pl.`name`
									LIMIT '.(int)$start.', '.(int)$pas.' ;';

						$result_search = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($rsql);

						if (count($result_search) > 0)
						{
							foreach ($result_search as $value)
							{
								$product_search = new Product((int)$value['id_product'], false, $current_lang);
								$product_cover = Image::getCover($product_search->id);
								$image_product = new Image((int)$product_cover['id_image']);
								$image_thumb_path = ImageManager::thumbnail(_PS_IMG_DIR_.'p/'.$image_product->getExistingImgPath().'.jpg',
									'product_mini_'.$product_search->id.'.jpg', 45, 'jpg');

								echo '	<tr class="Outlisted noOutlisted_'.$product_search->id.'">
												<td class="'.($product_search->active ? '' : 'noactif ').'center">
													<img src="../modules/prestablog/views/img/linked.png" rel="'.$product_search->id.'" class="linked" />
												</td>
												<td class="'.($product_search->active ? '' : 'noactif ').'center">'.$product_search->id.'</td>
												<td class="'.($product_search->active ? '' : 'noactif ').'center" style="width:50px;">'.$image_thumb_path.'</td>
												<td class="'.($product_search->active ? '' : 'noactif ').'">'.$product_search->name.'</td>
											</tr>'."\n";
							}
							echo '
								<tr class="prestablog-footer-search">
									<td colspan="4">
										'.$prestablog->message_call_back['total_results'].' : '.$count_search['value'].'
										'.($end < (int)$count_search['value'] ? '<span id="prestablog-next-search" class="prestablog-search">
										'.$prestablog->message_call_back['next_results'].
										'<img src="../modules/prestablog/views/img/list-next2.gif" /></span>' : '').'
										'.($start > 0?'<span id="prestablog-prev-search" class="prestablog-search">
										<img src="../modules/prestablog/views/img/list-prev2.gif" />
										'.$prestablog->message_call_back['prev_results'].'</span>':'').'
									</td>
								</tr>'."\n";
							echo '
								<script type="text/javascript">
									$("span#prestablog-prev-search").click(function() {
										ReloadLinkedSearchProducts('.($start - $pas).');
									});
									$("span#prestablog-next-search").click(function() {
										ReloadLinkedSearchProducts('.($start + $pas).');
									});
									$(".productLinkResult img.linked").click(function() {
										var idP = $(this).attr("rel");
										$("#currentProductLink").append(\'<input type="text" name="productsLink[]" value="\'+idP+\'" class="productsLink linked_\'+idP+\'" />\');
										$(".productLinkResult .noOutlisted_"+idP).remove();
										ReloadLinkedProducts();
										ReloadLinkedSearchProducts();
									});
									$(".productLinkResult2 img.linked").click(function() {
										var idP = $(this).attr("rel");
										$("#currentProductLink2").append(\'<input type="text" name="productsLink2[]" value="\'+idP+\'" class="productsLink2 linked_\'+idP+\'" />\');
										$(".productLinkResult2 .noOutlisted_"+idP).remove();
										ReloadLinkedProducts2();
										ReloadLinkedSearchProducts2();
									});
									$(".productLinkResult3 img.linked").click(function() {
										var idP = $(this).attr("rel");
										$("#currentProductLink3").append(\'<input type="text" name="productsLink3[]" value="\'+idP+\'" class="productsLink3 linked_\'+idP+\'" />\');
										$(".productLinkResult3 .noOutlisted_"+idP).remove();
										ReloadLinkedProducts3();
										ReloadLinkedSearchProducts3();
									});
								</script>'."\n";
						}
						else
							echo '
								<tr class="warning">
									<td colspan="4" class="center">'.$prestablog->message_call_back['no_result_found'].'</td>
								</tr>'."\n";

					}
					else
					{
						$prestablog = new PrestaBlog();
						echo '
							<tr class="warning">
								<td colspan="4" class="center">'.$prestablog->message_call_back['no_result_found'].'</td>
							</tr>'."\n";
					}
				}
				break;

			case 'searchArticles' :
				if (Tools::getValue('req') != '')
				{
					if (Tools::strlen(Tools::getValue('req')) >= (int)Configuration::get('prestablog_nb_car_min_linknews'))
					{
						$start = 0;
						$pas = (int)Configuration::get('prestablog_nb_list_linknews');
						if (!$pas || $pas == 0)
							$pas = 5;

						if (Tools::getValue('start'))
							$start = (int)Tools::getValue('start');

						$end = (int)$pas + (int)$start;

						$list_article_linked = array();

						if (Tools::getValue('listLinkedArticles') != '')
							$list_article_linked = preg_split('/;/', rtrim(Tools::getValue('listLinkedArticles'), ';'));

						$result_search = array();
						$prestablog = new PrestaBlog();
						$rsql_search = '';
						$rsql_lang = '';

						$query = Tools::strtoupper(pSQL(Trim(Tools::getValue('req'))));
						$querys = array_filter(explode(' ', $query));

						$list_champs_article_lang = array(
							'paragraph',
							'content',
							'link_rewrite',
							'title',
							'meta_title',
							'meta_description',
							'meta_keywords'
						);

						foreach ($querys as $value)
						{
							foreach ($list_champs_article_lang as $value_c)
								$rsql_search .= ' UPPER(nl.`'.pSQL($value_c).'`) LIKE \'%'.pSQL($value).'%\' OR';
						}

						if (Tools::getValue('lang') != '')
							$current_lang = (int)Tools::getValue('lang');

						$rsql_lang = 'AND nl.`id_lang` = '.(int)$current_lang;
						$rsql_shop = 'AND n.`id_shop` = '.(int)Tools::getValue('id_shop');

						$rsql_search = ' WHERE ('.rtrim($rsql_search, 'OR').') '.$rsql_lang.' '.$rsql_shop;

						$rsql_plink = '';

						foreach ($list_article_linked as $article_link)
							$rsql_plink .= ' AND nl.`id_prestablog_news` <> '.(int)$article_link;

						$rsql_search .= $rsql_plink;

						$count_search = Db::getInstance(_PS_USE_SQL_SLAVE_)->GetRow('SELECT COUNT(DISTINCT nl.`id_prestablog_news`) AS `value`
									FROM 	`'.bqSQL(_DB_PREFIX_).'prestablog_news_lang` AS nl
									LEFT JOIN `'.bqSQL(_DB_PREFIX_).'prestablog_news` AS n ON (n.`id_prestablog_news` = nl.`id_prestablog_news`)
									'.$rsql_search.';');

						$rsql	=	'SELECT DISTINCT(nl.`id_prestablog_news`)
									FROM 	`'.bqSQL(_DB_PREFIX_).'prestablog_news_lang` AS nl
									LEFT JOIN `'.bqSQL(_DB_PREFIX_).'prestablog_news` AS n ON (n.`id_prestablog_news` = nl.`id_prestablog_news`)
									'.$rsql_search.'
									ORDER BY nl.`title`
									LIMIT '.(int)$start.', '.(int)$pas.' ;';

						$result_search = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($rsql);
						$prestablog = new PrestaBlog();

						if (count($result_search) > 0)
						{
							foreach ($result_search as $value)
							{
								$article_search = new NewsClass((int)$value['id_prestablog_news'], $current_lang);

								if (file_exists(dirname(__FILE__).'/../../views/img/'.Configuration::get('prestablog_theme').'/up-img/adminth_'
								.$article_search->id.'.jpg'))
									$thumbnail = '<img class="imgm img-thumbnail" src="../modules/prestablog/views/img/'.Configuration::get('prestablog_theme')
													.'/up-img/adminth_'.$article_search->id.'.jpg?'.md5(time()).'" />';
								else
									$thumbnail = '-';

								echo '	<tr class="Outlisted noOutlisted_'.$article_search->id.'">
												<td class="'.($article_search->actif ? '' : 'noactif ').'center">
													<img src="../modules/prestablog/views/img/linked.png" rel="'.$article_search->id.'" class="linked" />
												</td>
												<td class="'.($article_search->actif ? '' : 'noactif ').'center">'.$article_search->id.'</td>
												<td class="'.($article_search->actif ? '' : 'noactif ').'center" style="width:50px;">'.$thumbnail.'</td>
												<td class="'.($article_search->actif ? '' : 'noactif ').'">'.$article_search->title.'</td>
											</tr>'."\n";
							}
							echo '
								<tr class="prestablog-footer-search">
									<td colspan="4">
										'.$prestablog->message_call_back['total_results'].' : '.$count_search['value'].'
										'.($end < (int)$count_search['value'] ? '<span id="prestablog-next-search" class="prestablog-search">
										'.$prestablog->message_call_back['next_results'].
										'<img src="../modules/prestablog/views/img/list-next2.gif" /></span>' : '').'
										'.($start > 0?'<span id="prestablog-prev-search" class="prestablog-search">
										<img src="../modules/prestablog/views/img/list-prev2.gif" />
										'.$prestablog->message_call_back['prev_results'].'</span>':'').'
									</td>
								</tr>'."\n";
							echo '
								<script type="text/javascript">
									$("span#prestablog-prev-search").click(function() {
										ReloadLinkedSearchArticles('.($start - $pas).');
									});
									$("span#prestablog-next-search").click(function() {
										ReloadLinkedSearchArticles('.($start + $pas).');
									});
									$("#articleLinkResult img.linked").click(function() {
										var idN = $(this).attr("rel");
										$("#currentArticleLink").append(\'<input type="text" name="articlesLink[]" value="\'+idN+\'" class="linked_\'+idN+\'" />\');
										$("#articleLinkResult .noOutlisted_"+idN).remove();
										ReloadLinkedArticles();
										ReloadLinkedSearchArticles();
									});
								</script>'."\n";
						}
						else
							echo '
								<tr class="warning">
									<td colspan="4" class="center">'.$prestablog->message_call_back['no_result_found'].'</td>
								</tr>'."\n";

					}
					else
					{
						$prestablog = new PrestaBlog();
						echo '
							<tr class="warning">
								<td colspan="4" class="center">'.$prestablog->message_call_back['no_result_found'].'</td>
							</tr>'."\n";
					}
				}
				break;

			case 'search' :
				break;

			default :
				break;
		}
	}
}

?>
