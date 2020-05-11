{*
	* 2007-2014 PrestaShop
	*
	* NOTICE OF LICENSE
	*
	* This source file is subject to the Academic Free License (AFL 3.0)
	* that is bundled with this package in the file LICENSE.txt.
	* It is also available through the world-wide-web at this URL:
	* http://opensource.org/licenses/afl-3.0.php
	* If you did not receive a copy of the license and are unable to
	* obtain it through the world-wide-web, please send an email
	* to license@prestashop.com so we can send you a copy immediately.
	*
	* DISCLAIMER
	*
	* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
	* versions in the future. If you wish to customize PrestaShop for your
	* needs please refer to http://www.prestashop.com for more information.
	*
	*  @author    PrestaShop SA <contact@prestashop.com>
	*  @copyright 2007-2014 PrestaShop SA
	*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
	*  International Registered Trademark & Property of PrestaShop SA
	*}


		<div class="modal fade column-content-modal" tabindex="-1" role="dialog" aria-labelledby="columnContent" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-body">

						<div class="form-group">
							<label class="control-label col-lg-3">
								{l s='Column title' mod='iqitcontentcreator'}
							</label>
				
							
							{foreach from=$languages item=language}
							{if $languages|count > 1}
							<div class="translatable-field lang-{$language.id_lang}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
								{/if}
								<div class="col-lg-7">
									<input value="{if isset($node.content_s.title[$language.id_lang])}{$node.content_s.title[$language.id_lang]}{/if}" type="text" class="column-title-{$language.id_lang}">
									<p class="help-block">
										{l s='Optional column title' mod='iqitcontentcreator'}
									</p>
								</div>
								{if $languages|count > 1}
								<div class="col-lg-2">
									<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
										{$language.iso_code}
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu">
										{foreach from=$languages item=lang}
										<li><a href="javascript:hideOtherLanguage({$lang.id_lang});" tabindex="-1">{$lang.name}</a></li>
										{/foreach}
									</ul>
								</div>
								{/if}
								{if $languages|count > 1}
							</div>
							{/if}
							{/foreach}
						</div>
						
						<div class="form-group">
							<label class="control-label col-lg-3">
								{l s='Column title link' mod='iqitcontentcreator'}
							</label>
				
							
							{foreach from=$languages item=language}
							{if $languages|count > 1}
							<div class="translatable-field lang-{$language.id_lang}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
								{/if}
								<div class="col-lg-7">
									<input value="{if isset($node.content_s.href[$language.id_lang])}{$node.content_s.href[$language.id_lang]}{/if}" type="text" class="column-href-{$language.id_lang}">
									<p class="help-block">
								{l s='Optional link. Use entire url with http:// prefix' mod='iqitcontentcreator'}
							</p>
								</div>
								{if $languages|count > 1}
								<div class="col-lg-2">
									<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
										{$language.iso_code}
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu">
										{foreach from=$languages item=lang}
										<li><a href="javascript:hideOtherLanguage({$lang.id_lang});" tabindex="-1">{$lang.name}</a></li>
										{/foreach}
									</ul>
								</div>
								{/if}
								{if $languages|count > 1}
							</div>
							{/if}
							{/foreach}
						</div>

						<div class="form-group">
							<label class="control-label col-lg-3">
								{l s='Title legend' mod='iqitcontentcreator'}
							</label>
				
							
							{foreach from=$languages item=language}
							{if $languages|count > 1}
							<div class="translatable-field lang-{$language.id_lang}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
								{/if}
								<div class="col-lg-7">
									<input value="{if isset($node.content_s.legend[$language.id_lang])}{$node.content_s.legend[$language.id_lang]}{/if}" type="text" class="column-legend-{$language.id_lang}">
									<p class="help-block">
										{l s='Optional additional text showed in tooltip' mod='iqitcontentcreator'}
									</p>
								</div>
								{if $languages|count > 1}
								<div class="col-lg-2">
									<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
										{$language.iso_code}
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu">
										{foreach from=$languages item=lang}
										<li><a href="javascript:hideOtherLanguage({$lang.id_lang});" tabindex="-1">{$lang.name}</a></li>
										{/foreach}
									</ul>
								</div>
								{/if}
								{if $languages|count > 1}
							</div>
							{/if}
							{/foreach}
						</div>
						

			

						<div class="form-group">
							<label class="control-label col-lg-3">{l s='Content type' mod='iqitcontentcreator'}</label>
							<select class="select-column-content col-lg-9">
								<option value="9" {if isset($node.contentType) && $node.contentType==9}selected{/if}>{l s='Module include' mod='iqitcontentcreator'}</option>
								<option value="8" {if isset($node.contentType) && $node.contentType==8}selected{/if}>{l s='Custom hook' mod='iqitcontentcreator'}</option>
								<option value="7" {if isset($node.contentType) && $node.contentType==7}selected{/if}>{l s='Manufacturers logos' mod='iqitcontentcreator'}</option>
								<option value="6" {if isset($node.contentType) && $node.contentType==6}selected{/if}>{l s='Banner image' mod='iqitcontentcreator'}</option>
								<option value="4" {if isset($node.contentType) && $node.contentType==4}selected{/if}>{l s='Selected Products' mod='iqitcontentcreator'}</option>
								<option value="2" {if isset($node.contentType) && $node.contentType==2}selected{/if}>{l s='Products(new, special, bestesllers or categories)' mod='iqitcontentcreator'}</option>
								<option value="1" {if isset($node.contentType) && $node.contentType==1}selected{/if}>{l s='Html Content' mod='iqitcontentcreator'}</option>
								<option value="0" {if isset($node.contentType)}{if $node.contentType==0}selected{/if}{else}selected{/if} >{l s='Empty' mod='iqitcontentcreator'}</option>

							</select></div>
						
					<div class="htmlcontent-wrapper content-options-wrapper">
							<div class="form-group">
							<label class="control-label col-lg-3">
								{l s='Custom Html content' mod='iqitcontentcreator'}
							</label>
								<select class="select-customhtml col-lg-9">
							<option value="0">{l s='No content' mod='iqitcontentcreator'}</option>
							{foreach from=$custom_html_select item=customhtml}
							<option value="{$customhtml.id_html}" {if isset($node.content.ids) && $node.content.ids == $customhtml.id_html}selected{/if} >{$customhtml.title}</option>
							{/foreach}
							</select>
			
									
								
								
						</div>
					</div>	
					
					<div class="categorytree-wrapper content-options-wrapper">
						
						<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Source of products' mod='iqitcontentcreator'}</label>
								<select class="select-categories-ids col-lg-9">
									<option value="n" {if isset($node.content.ids) && $node.content.ids == 'n'}selected{/if}>{l s='New products' mod='iqitcontentcreator'}</option>
									<option value="s" {if isset($node.content.ids) && $node.content.ids == 's'}selected{/if}>{l s='Price drops' mod='iqitcontentcreator'}</option>
									<option value="b" {if isset($node.content.ids) && $node.content.ids == 'b'}selected{/if}>{l s='Best sellers' mod='iqitcontentcreator'}</option>
									<option value="null" disabled>--- {l s='Categories' mod='iqitcontentcreator'} ---</option>
									{foreach from=$categories_select item=category}
										<option value="{$category.id}" {if isset($node.content.ids) && $node.content.ids == '2'}selected{/if}>{$category.name}</option>

										{if isset($category.children)}
											{if isset($node.content.ids) && $node.contentType == 2}
												{include file="./subcategory.tpl" categories=$category.children ids=$node.content.ids type=$node.contentType}
											{else}
												{include file="./subcategory.tpl" categories=$category.children}
											{/if}     
										{/if}  
									{/foreach}
								</select>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='View type' mod='iqitcontentcreator'}</label>
								<div class="col-lg-9"><select class="select-categories-view">
									<option value="1" {if isset($node.content.view) && $node.content.view == 1}selected{/if} >{l s='Slider - info below big image ' mod='iqitcontentcreator'}</option>
									<option value="0"  {if isset($node.content.view) && $node.content.view == 0}selected{/if}>{l s='Grid - info below big image' mod='iqitcontentcreator'}</option>
									<option value="disabled" disabled>{l s='------------------'}</option>
									<option value="3" {if isset($node.content.view) && $node.content.view == 3}selected{/if} >{l s='Slider - info next to small image ' mod='iqitcontentcreator'}</option>
									<option value="2"  {if isset($node.content.view) && $node.content.view == 2}selected{/if}>{l s='Grid - info next to small image' mod='iqitcontentcreator'}</option>
									
								</select>
							</div>
							</div>
								<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Image size' mod='iqitcontentcreator'}</label>
								<div class="col-lg-9"><select class="select-image-type">
								<option value="0" {if isset($node.content.itype) && $node.content.itype == 0}selected{/if}>{l s='Default - Recommanded' mod='iqitcontentcreator'}</option>
								{foreach from=$images_formats item=format}
										<option value="{$format.name}" {if isset($node.content.itype) && $node.content.itype == $format.name}selected{/if}>{$format.name}</option>
										{/foreach}
								</select>
								<p class="help-block">
										{l s='For big image sliders home_default should be fine. For small images sliders small_default but everthing depends of your configuration. If you not shure keep default option' mod='iqitcontentcreator'}
									</p>
							</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Products limit' mod='iqitcontentcreator'}</label>
								<div class="col-lg-9">
									<input value="{if isset($node.content.limit)}{$node.content.limit}{else}10{/if}" type="text" class="categories-products-limit" >
									<p class="help-block">
										{l s='Maxiumum number of products to show' mod='iqitcontentcreator'}
									</p>
								</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Order products by' mod='iqitcontentcreator'}</label>
								<div class="col-lg-9">
								<select class="select-categories-o">
									<option value="position"  {if isset($node.content.o) && $node.content.o == 'position'}selected{/if} > {l s='Position' mod='iqitcontentcreator'}</option>
									<option value="name"  {if isset($node.content.o) && $node.content.o == 'name'}selected{/if} > {l s='Name' mod='iqitcontentcreator'}</option>
									<option value="date_add"  {if isset($node.content.o) && $node.content.o == 'date_add'}selected{/if} >{l s='Date add' mod='iqitcontentcreator'}</option>
									<option value="price"  {if isset($node.content.o) && $node.content.o == 'price'}selected{/if} > {l s='Price' mod='iqitcontentcreator'}</option>
									<option value="1"  {if isset($node.content.o) && $node.content.o == 1}selected{/if} > {l s='Random(works only with categories)' mod='iqitcontentcreator'}</option> 
								</select>
								<p class="help-block">
										{l s='This settings do not affects bestsellers' mod='iqitcontentcreator'}
								</p>
								</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Order way' mod='iqitcontentcreator'}</label>
								<div class="col-lg-9">
								<select class="select-categories-ob">
									<option value="ASC"  {if isset($node.content.ob) && $node.content.ob == 'ASC'}selected{/if} >Ascending</option>
									<option value="DESC"  {if isset($node.content.ob) && $node.content.ob == 'DESC'}selected{/if} >Descending</option>
								</select>
								</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Products per column' mod='iqitcontentcreator'}</label>
								<div class="col-lg-9">
								<select class="select-categories-per-column">
									<option value="1"  {if isset($node.content.colnb) && $node.content.colnb == 1}selected{/if} >1</option>
									<option value="2"  {if isset($node.content.colnb) && $node.content.colnb == 2}selected{/if} >2</option>
									<option value="3"  {if isset($node.content.colnb) && $node.content.colnb == 3}selected{/if} >3</option>
									<option value="4"  {if isset($node.content.colnb) && $node.content.colnb == 4}selected{/if} >4</option>
									<option value="5"  {if isset($node.content.colnb) && $node.content.colnb == 5}selected{/if} >5</option>
									<option value="6"  {if isset($node.content.colnb) && $node.content.colnb == 6}selected{/if} >6</option>
									<option value="7"  {if isset($node.content.colnb) && $node.content.colnb == 7}selected{/if} >7</option>
									<option value="8"  {if isset($node.content.colnb) && $node.content.colnb == 8}selected{/if} >8</option>
									<option value="9"  {if isset($node.content.colnb) && $node.content.colnb == 9}selected{/if} >9</option>
									<option value="10" {if isset($node.content.colnb) && $node.content.colnb == 10}selected{/if} >10</option>
								</select>
								<p class="help-block">
										{l s='Affects sliders only' mod='iqitcontentcreator'}
									</p>
									</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Slider autoplay' mod='iqitcontentcreator'}</label>
								<div class="col-lg-9">
								<select class="select-categories-ap">
									<option value="0"  {if isset($node.content.ap) && $node.content.ap == 0}selected{/if} >No</option>
									<option value="1"  {if isset($node.content.ap) && $node.content.ap == 1}selected{/if} >Yes</option>
								</select>
								</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Slider arrows' mod='iqitcontentcreator'}</label>
								<div class="col-lg-9">
								<select class="select-categories-ar">
									<option value="0"  {if isset($node.content.ar) && $node.content.ar == 0}selected{/if} >In middle of slider</option>
									<option value="1"  {if isset($node.content.ar) && $node.content.ar == 1}selected{/if} >Above slider(on column title)</option>
									<option value="2"  {if isset($node.content.ar) && $node.content.ar == 2}selected{/if} >Hide</option>
								</select>
								</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Slider dots' mod='iqitcontentcreator'}</label>
								<div class="col-lg-9">
								<select class="select-categories-dt">
									<option value="0"  {if isset($node.content.dt) && $node.content.dt == 0}selected{/if} >No</option>
									<option value="1"  {if isset($node.content.dt) && $node.content.dt == 1}selected{/if} >Yes</option>
								</select>
								</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Products per line - large desktop' mod='iqitcontentcreator'}</label>
								<select class="select-categories-line-lg col-lg-9">
									<option value="12"  {if isset($node.content.line_lg) && $node.content.line_lg == 12}selected{/if} >1</option>
									<option value="6"  {if isset($node.content.line_lg) && $node.content.line_lg == 6}selected{/if}>2</option>
									<option value="4"  {if isset($node.content.line_lg) && $node.content.line_lg == 4}selected{/if} >3</option>
									<option value="3"  {if isset($node.content.line_lg) && $node.content.line_lg == 3}selected{/if}>4</option>
									<option value="15"  {if isset($node.content.line_lg) && $node.content.line_lg == 15}selected{/if}>5</option>
									<option value="2"  {if isset($node.content.line_lg) && $node.content.line_lg == 2}selected{/if}>6</option>
								</select>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Products per line - desktop' mod='iqitcontentcreator'}</label>
								<select class="select-categories-line-md col-lg-9">
									<option value="12"  {if isset($node.content.line_md) && $node.content.line_md == 12}selected{/if} >1</option>
									<option value="6"  {if isset($node.content.line_md) && $node.content.line_md == 6}selected{/if}>2</option>
									<option value="4"  {if isset($node.content.line_md) && $node.content.line_md == 4}selected{/if} >3</option>
									<option value="3"  {if isset($node.content.line_md) && $node.content.line_md == 3}selected{/if}>4</option>
									<option value="15"  {if isset($node.content.line_md) && $node.content.line_md == 15}selected{/if}>5</option>
									<option value="2"  {if isset($node.content.line_md) && $node.content.line_md == 2}selected{/if}>6</option>
								</select>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Products per line - tablet' mod='iqitcontentcreator'}</label>
								<select class="select-categories-line-sm col-lg-9">
									<option value="12"  {if isset($node.content.line_sm) && $node.content.line_sm == 12}selected{/if} >1</option>
									<option value="6"  {if isset($node.content.line_sm) && $node.content.line_sm == 6}selected{/if}>2</option>
									<option value="4"  {if isset($node.content.line_sm) && $node.content.line_sm == 4}selected{/if}>3</option>
									<option value="3"  {if isset($node.content.line_sm) && $node.content.line_sm == 3}selected{/if}>4</option>
								</select>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Products per line - phone landscape' mod='iqitcontentcreator'}</label>
								<select class="select-categories-line-ms col-lg-9">
									<option value="12"  {if isset($node.content.line_ms) && $node.content.line_ms == 12}selected{/if} >1</option>
									<option value="6"  {if isset($node.content.line_ms) && $node.content.line_ms == 6}selected{/if}>2</option>
									<option value="4"  {if isset($node.content.line_ms) && $node.content.line_ms == 4}selected{/if} >3</option>
								</select>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Products per line - phone portrait' mod='iqitcontentcreator'}</label>
								<select class="select-categories-line-xs col-lg-9">
									<option value="12"  {if isset($node.content.line_xs) && $node.content.line_xs == 12}selected{/if} >1</option>
									<option value="6"  {if isset($node.content.line_xs) && $node.content.line_xs == 6}selected{/if}>2</option>
								</select>
							</div>
					</div>

					<div class="column-image-wrapper content-options-wrapper">
						
						<div class="form-group">
							<label class="control-label col-lg-3">
								{l s='Image source' mod='iqitcontentcreator'}
							</label>	
							{foreach from=$languages item=language}
							{if $languages|count > 1}
							<div class="translatable-field lang-{$language.id_lang}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
								{/if}
								<div class="col-lg-7">
									<input value="{if isset($node.content.source[$language.id_lang])}{$node.content.source[$language.id_lang]}{/if}" type="text" class="i-upload-input image-source image-source-{$language.id_lang}" name="{if isset($node.elementId)}{$node.elementId}-{/if}image-source-{$language.id_lang}"  id="{if isset($node.elementId)}{$node.elementId}-{/if}image-source-{$language.id_lang}" data-lang-id="{$language.id_lang}" >
									<a href="{if isset($admin_link)}{$admin_link}{/if}filemanager/dialog.php?type=1&field_id={if isset($node.elementId)}{$node.elementId}-{/if}image-source-{$language.id_lang}" class="btn i-upload-input btn-default iframe-column-upload"  data-input-name="{if isset($node.elementId)}{$node.elementId}-{/if}image-source-{$language.id_lang}" type="button">{l s='Select image' mod='iqitcontentcreator'} <i class="icon-angle-right"></i></a>
								</div>
								{if $languages|count > 1}
								<div class="col-lg-2">
									<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
										{$language.iso_code}
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu">
										{foreach from=$languages item=lang}
										<li><a href="javascript:hideOtherLanguage({$lang.id_lang});" tabindex="-1">{$lang.name}</a></li>
										{/foreach}
									</ul>
								</div>
								{/if}
								{if $languages|count > 1}
							</div>
							{/if}
							{/foreach}
						</div>

						<div class="form-group">
							<label class="control-label col-lg-3">
								{l s='Image link' mod='iqitcontentcreator'}
							</label>	
							{foreach from=$languages item=language}
							{if $languages|count > 1}
							<div class="translatable-field lang-{$language.id_lang}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
								{/if}
								<div class="col-lg-7">
									<input value="{if isset($node.content.href[$language.id_lang])}{$node.content.href[$language.id_lang]}{/if}" type="text" class="image-href-{$language.id_lang}">
									<p class="help-block">
								{l s='Optional link. Use entire url with http:// prefix' mod='iqitcontentcreator'}
							</p>
								</div>
								{if $languages|count > 1}
								<div class="col-lg-2">
									<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
										{$language.iso_code}
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu">
										{foreach from=$languages item=lang}
										<li><a href="javascript:hideOtherLanguage({$lang.id_lang});" tabindex="-1">{$lang.name}</a></li>
										{/foreach}
									</ul>
								</div>
								{/if}
								{if $languages|count > 1}
							</div>
							{/if}
							{/foreach}
						</div>


						<div class="form-group">
							<label class="control-label col-lg-3">
								{l s='Alt tag(image description)' mod='iqitcontentcreator'}
							</label>	
							{foreach from=$languages item=language}
							{if $languages|count > 1}
							<div class="translatable-field lang-{$language.id_lang|escape:'htmlall':'UTF-8'}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
								{/if}
								<div class="col-lg-7">
									<input value="{if isset($node.content.alt[$language.id_lang])}{$node.content.alt[$language.id_lang]|escape:'htmlall':'UTF-8'}{/if}" type="text" class="image-alt-{$language.id_lang|escape:'htmlall':'UTF-8'}">
								</div>
								{if $languages|count > 1}
								<div class="col-lg-2">
									<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
										{$language.iso_code|escape:'htmlall':'UTF-8'}
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu">
										{foreach from=$languages item=lang}
										<li><a href="javascript:hideOtherLanguage({$lang.id_lang|escape:'htmlall':'UTF-8'});" tabindex="-1">{$lang.name|escape:'html'}</a></li>
										{/foreach}
									</ul>
								</div>
								{/if}
								{if $languages|count > 1}
							</div>
							{/if}
							{/foreach}
						</div>

						
						<div class="form-group">
								<label  class="control-label col-lg-3">{l s='New window' mod='iqitcontentcreator'}</label>
								<div class="col-lg-9">
								<select class="select-image-window">
									<option value="0"  {if isset($node.content.window) && $node.content.window== 0}selected{/if} >No</option>
									<option value="1"  {if isset($node.content.window) && $node.content.window == 1}selected{/if} >Yes</option>
								</select>
								<p class="help-block">
										{l s='Open link in new window' mod='iqitcontentcreator'}
									</p>
									</div>
							</div>
						<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Fill entire height of row' mod='iqitcontentcreator'}</label>
								<div class="col-lg-9">
								<select class="select-image-height">
									<option value="0"  {if isset($node.content.iheight) && $node.content.iheight== 0}selected{/if} >No</option>
									<option value="1"  {if isset($node.content.iheight) && $node.content.iheight == 1}selected{/if} >Yes</option>
								</select>
								<p class="help-block">
										{l s='This options works only with center vertical align for columns in row settings' mod='iqitcontentcreator'}
									</p>
									</div>
							</div>
					</div>


					<div class="products-wrapper content-options-wrapper">
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Search product' mod='iqitcontentcreator'}</label>
								<div class="col-lg-9"><input type="text" class="product-autocomplete form-control" ></div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-3">{l s='Selected products' mod='iqitcontentcreator'}</label>
								<div class="col-lg-9">
								<select class="select-products-ids" multiple="multiple" style="height: 160px;">
								{if isset($node.content.ids) && $node.contentType == 4}
								{foreach from=$node.content.ids item=product}
									<option value="{$product.id_product}" >(ID: {$product.id_product}) {$product.name}</option>
								{/foreach}
								{/if}
								</select>
								<br />
								<button type="button" class="btn btn-danger remove-products-ids"><i class="icon-trash"></i> {l s='Remove selected' mod='iqitcontentcreator'}</button>
								</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='View type' mod='iqitcontentcreator'}</label>
								<div class="col-lg-9"><select class="select-products-view">
									<option value="1" {if isset($node.content.view) && $node.content.view == 1}selected{/if} >{l s='Slider - info below big image ' mod='iqitcontentcreator'}</option>
									<option value="0"  {if isset($node.content.view) && $node.content.view == 0}selected{/if}>{l s='Grid - info below big image' mod='iqitcontentcreator'}</option>
									<option value="disabled" disabled>{l s='------------------'}</option>
									<option value="3" {if isset($node.content.view) && $node.content.view == 3}selected{/if} >{l s='Slider - info next to small image ' mod='iqitcontentcreator'}</option>
									<option value="2"  {if isset($node.content.view) && $node.content.view == 2}selected{/if}>{l s='Grid - info next to small image' mod='iqitcontentcreator'}</option>
									
								</select>
							</div>
							</div>
								<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Image size' mod='iqitcontentcreator'}</label>
								<div class="col-lg-9"><select class="select-pimage-type">
								<option value="0" {if isset($node.content.itype) && $node.content.itype == 0}selected{/if}>{l s='Default - Recommanded' mod='iqitcontentcreator'}</option>
								{foreach from=$images_formats item=format}
										<option value="{$format.name}" {if isset($node.content.itype) && $node.content.itype == $format.name}selected{/if}>{$format.name}</option>
										{/foreach}
								</select>
								<p class="help-block">
										{l s='You can adjust your image sizes to your slider. If you not shure just keep Default recommanded option' mod='iqitcontentcreator'}
									</p>
							</div>
							</div>

							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Products per column' mod='iqitcontentcreator'}</label>
								<div class="col-lg-9">
								<select class="select-products-per-column">
									<option value="1"  {if isset($node.content.colnb) && $node.content.colnb == 1}selected{/if} >1</option>
									<option value="2"  {if isset($node.content.colnb) && $node.content.colnb == 2}selected{/if} >2</option>
									<option value="3"  {if isset($node.content.colnb) && $node.content.colnb == 3}selected{/if} >3</option>
									<option value="4"  {if isset($node.content.colnb) && $node.content.colnb == 4}selected{/if} >4</option>
									<option value="5"  {if isset($node.content.colnb) && $node.content.colnb == 5}selected{/if} >5</option>
									<option value="6"  {if isset($node.content.colnb) && $node.content.colnb == 6}selected{/if} >6</option>
									<option value="7"  {if isset($node.content.colnb) && $node.content.colnb == 7}selected{/if} >7</option>
									<option value="8"  {if isset($node.content.colnb) && $node.content.colnb == 8}selected{/if} >8</option>
									<option value="9"  {if isset($node.content.colnb) && $node.content.colnb == 9}selected{/if} >9</option>
									<option value="10" {if isset($node.content.colnb) && $node.content.colnb == 10}selected{/if} >10</option>
								</select>
								<p class="help-block">
										{l s='Affects sliders only' mod='iqitcontentcreator'}
									</p>
									</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Slider autoplay' mod='iqitcontentcreator'}</label>
								<div class="col-lg-9">
								<select class="select-products-ap">
									<option value="0"  {if isset($node.content.ap) && $node.content.ap == 0}selected{/if} >No</option>
									<option value="1"  {if isset($node.content.ap) && $node.content.ap == 1}selected{/if} >Yes</option>
								</select>
								</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Slider arrows' mod='iqitcontentcreator'}</label>
								<div class="col-lg-9">
								<select class="select-products-ar">
									<option value="0"  {if isset($node.content.ar) && $node.content.ar == 0}selected{/if} >In middle of slider</option>
									<option value="1"  {if isset($node.content.ar) && $node.content.ar == 1}selected{/if} >Above slider(on column title)</option>
								</select>
								</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Slider dots' mod='iqitcontentcreator'}</label>
								<div class="col-lg-9">
								<select class="select-products-dt">
									<option value="0"  {if isset($node.content.dt) && $node.content.dt == 0}selected{/if} >No</option>
									<option value="1"  {if isset($node.content.dt) && $node.content.dt == 1}selected{/if} >Yes</option>
								</select>
								</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Products per line - large desktop' mod='iqitcontentcreator'}</label>
								<select class="select-products-line-lg col-lg-9">
									<option value="12"  {if isset($node.content.line_lg) && $node.content.line_lg == 12}selected{/if} >1</option>
									<option value="6"  {if isset($node.content.line_lg) && $node.content.line_lg == 6}selected{/if}>2</option>
									<option value="4"  {if isset($node.content.line_lg) && $node.content.line_lg == 4}selected{/if} >3</option>
									<option value="3"  {if isset($node.content.line_lg) && $node.content.line_lg == 3}selected{/if}>4</option>
									<option value="15"  {if isset($node.content.line_lg) && $node.content.line_lg == 15}selected{/if}>5</option>
									<option value="2"  {if isset($node.content.line_lg) && $node.content.line_lg == 2}selected{/if}>6</option>
								</select>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Products per line - desktop' mod='iqitcontentcreator'}</label>
								<select class="select-products-line-md col-lg-9">
									<option value="12"  {if isset($node.content.line_md) && $node.content.line_md == 12}selected{/if} >1</option>
									<option value="6"  {if isset($node.content.line_md) && $node.content.line_md == 6}selected{/if}>2</option>
									<option value="4"  {if isset($node.content.line_md) && $node.content.line_md == 4}selected{/if} >3</option>
									<option value="3"  {if isset($node.content.line_md) && $node.content.line_md == 3}selected{/if}>4</option>
									<option value="15"  {if isset($node.content.line_md) && $node.content.line_md == 15}selected{/if}>5</option>
									<option value="2"  {if isset($node.content.line_md) && $node.content.line_md == 2}selected{/if}>6</option>
								</select>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Products per line - tablet' mod='iqitcontentcreator'}</label>
								<select class="select-products-line-sm col-lg-9">
									<option value="12"  {if isset($node.content.line_sm) && $node.content.line_sm == 12}selected{/if} >1</option>
									<option value="6"  {if isset($node.content.line_sm) && $node.content.line_sm == 6}selected{/if}>2</option>
									<option value="4"  {if isset($node.content.line_sm) && $node.content.line_sm == 4}selected{/if}>3</option>
									<option value="3"  {if isset($node.content.line_sm) && $node.content.line_sm == 3}selected{/if}>4</option>
								</select>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Products per line - phone landscape' mod='iqitcontentcreator'}</label>
								<select class="select-products-line-ms col-lg-9">
									<option value="12"  {if isset($node.content.line_ms) && $node.content.line_ms == 12}selected{/if} >1</option>
									<option value="6"  {if isset($node.content.line_ms) && $node.content.line_ms == 6}selected{/if}>2</option>
									<option value="4"  {if isset($node.content.line_ms) && $node.content.line_ms == 4}selected{/if} >3</option>
								</select>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Products per line - phone portrait' mod='iqitcontentcreator'}</label>
								<select class="select-products-line-xs col-lg-9">
									<option value="12"  {if isset($node.content.line_xs) && $node.content.line_xs == 12}selected{/if} >1</option>
									<option value="6"  {if isset($node.content.line_xs) && $node.content.line_xs == 6}selected{/if}>2</option>
								</select>
							</div>

							

						
					</div>

					<div class="manufacturers-wrapper content-options-wrapper">
						<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Select manufacturers' mod='iqitcontentcreator'}</label>
								<select class="select-manufacturers-ids col-lg-9" multiple="multiple" style="height: 160px;">
								 <optgroup label="____All_____">
								<option value="0" {if isset($node.content.ids) && $node.contentType == 7 && in_array(0, $node.content.ids)}selected{/if} >{l s='Show all' mod='iqitcontentcreator'}</option>
								 </optgroup>
								  <optgroup label="____Manual select_____">
									{foreach from=$manufacturers_select item=manufacturer}
										<option value="{$manufacturer.id}" {if isset($node.content.ids) && $node.contentType == 7 && in_array($manufacturer.id, $node.content.ids)}selected{/if} >{$manufacturer.name}</option>
									{/foreach}
								</select>
								</optgroup>
								<p class="help-block">
								{l s='Do not selecta Show all manufacturers if you have large amount of' mod='iqitcontentcreator'}
							</p>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='View type' mod='iqitcontentcreator'}</label>
								<div class="col-lg-9"><select class="select-manufacturers-view">
									<option value="1" {if isset($node.content.view) && $node.content.view == 1}selected{/if} >{l s='Slider' mod='iqitcontentcreator'}</option>
									<option value="0"  {if isset($node.content.view) && $node.content.view == 0}selected{/if}>{l s='Grid' mod='iqitcontentcreator'}</option>
								</select>
							<p class="help-block">
								{l s='You can show manufacuters in slider or in a grid view' mod='iqitcontentcreator'}
							</p></div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Manufacturers per column' mod='iqitcontentcreator'}</label>
								<div class="col-lg-9">
								<select class="select-manufacturers-per-column">
									<option value="1"  {if isset($node.content.colnb) && $node.content.colnb == 1}selected{/if} >1</option>
									<option value="2"  {if isset($node.content.colnb) && $node.content.colnb == 2}selected{/if} >2</option>
									<option value="3"  {if isset($node.content.colnb) && $node.content.colnb == 3}selected{/if} >3</option>
									<option value="4"  {if isset($node.content.colnb) && $node.content.colnb == 4}selected{/if} >4</option>
									<option value="5"  {if isset($node.content.colnb) && $node.content.colnb == 5}selected{/if} >5</option>
								</select>
								<p class="help-block">
										{l s='Affects sliders only' mod='iqitcontentcreator'}
									</p>
									</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Slider autoplay' mod='iqitcontentcreator'}</label>
								<div class="col-lg-9">
								<select class="select-manufacturers-ap">
									<option value="0"  {if isset($node.content.ap) && $node.content.ap == 0}selected{/if} >No</option>
									<option value="1"  {if isset($node.content.ap) && $node.content.ap == 1}selected{/if} >Yes</option>
								</select>
								</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Slider arrows' mod='iqitcontentcreator'}</label>
								<div class="col-lg-9">
								<select class="select-manufacturers-ar">
									<option value="0"  {if isset($node.content.ar) && $node.content.ar == 0}selected{/if} >In middle of slider</option>
									<option value="1"  {if isset($node.content.ar) && $node.content.ar == 1}selected{/if} >Above slider(on column title)</option>
								</select>
								</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Slider dots' mod='iqitcontentcreator'}</label>
								<div class="col-lg-9">
								<select class="select-manufacturers-dt">
									<option value="0"  {if isset($node.content.dt) && $node.content.dt == 0}selected{/if} >No</option>
									<option value="1"  {if isset($node.content.dt) && $node.content.dt == 1}selected{/if} >Yes</option>
								</select>
								</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Logos per line - large desktop' mod='iqitcontentcreator'}</label>
								<select class="select-manufacturers-line-lg col-lg-9">
									<option value="12"  {if isset($node.content.line_lg) && $node.content.line_lg == 12}selected{/if} >1</option>
									<option value="6"  {if isset($node.content.line_lg) && $node.content.line_lg == 6}selected{/if}>2</option>
									<option value="4"  {if isset($node.content.line_lg) && $node.content.line_lg == 4}selected{/if} >3</option>
									<option value="3"  {if isset($node.content.line_lg) && $node.content.line_lg == 3}selected{/if}>4</option>
									<option value="15"  {if isset($node.content.line_lg) && $node.content.line_lg == 15}selected{/if}>5</option>
									<option value="2"  {if isset($node.content.line_lg) && $node.content.line_lg == 2}selected{/if}>6</option>
									<option value="1" {if isset($node.content.line_lg) && $node.content.line_lg == 1}selected{/if}>12</option>
								</select>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Logos per line - desktop' mod='iqitcontentcreator'}</label>
								<select class="select-manufacturers-line-md col-lg-9">
									<option value="12"  {if isset($node.content.line_md) && $node.content.line_md == 12}selected{/if} >1</option>
									<option value="6"  {if isset($node.content.line_md) && $node.content.line_md == 6}selected{/if}>2</option>
									<option value="4"  {if isset($node.content.line_md) && $node.content.line_md == 4}selected{/if} >3</option>
									<option value="3"  {if isset($node.content.line_md) && $node.content.line_md == 3}selected{/if}>4</option>
									<option value="15"  {if isset($node.content.line_md) && $node.content.line_md == 15}selected{/if}>5</option>
									<option value="2"  {if isset($node.content.line_md) && $node.content.line_md == 2}selected{/if}>6</option>
									<option value="1" {if isset($node.content.line_md) && $node.content.line_md == 1}selected{/if}>12</option>
								</select>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Logos per line - tablet' mod='iqitcontentcreator'}</label>
								<select class="select-manufacturers-line-sm col-lg-9">
									<option value="12"  {if isset($node.content.line_sm) && $node.content.line_sm == 12}selected{/if} >1</option>
									<option value="6"  {if isset($node.content.line_sm) && $node.content.line_sm == 6}selected{/if}>2</option>
									<option value="4"  {if isset($node.content.line_sm) && $node.content.line_sm == 4}selected{/if} >3</option>
									<option value="3"  {if isset($node.content.line_sm) && $node.content.line_sm == 3}selected{/if}>4</option>
									<option value="15"  {if isset($node.content.line_sm) && $node.content.line_sm == 15}selected{/if}>5</option>
									<option value="2"  {if isset($node.content.line_sm) && $node.content.line_sm == 2}selected{/if}>6</option>
									<option value="1" {if isset($node.content.line_sm) && $node.content.line_sm == 1}selected{/if}>12</option>
								</select>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Logos per line - phone landscape' mod='iqitcontentcreator'}</label>
								<select class="select-manufacturers-line-ms col-lg-9">
									<option value="12"  {if isset($node.content.line_ms) && $node.content.line_ms == 12}selected{/if} >1</option>
									<option value="6"  {if isset($node.content.line_ms) && $node.content.line_ms == 6}selected{/if}>2</option>
									<option value="4"  {if isset($node.content.line_ms) && $node.content.line_ms == 4}selected{/if} >3</option>
									<option value="3"  {if isset($node.content.line_ms) && $node.content.line_ms == 3}selected{/if}>4</option>
									<option value="15"  {if isset($node.content.line_ms) && $node.content.line_ms == 15}selected{/if}>5</option>							
								</select>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Logos per line - phone portrait' mod='iqitcontentcreator'}</label>
								<select class="select-manufacturers-line-xs col-lg-9">
									<option value="12"  {if isset($node.content.line_xs) && $node.content.line_xs == 12}selected{/if} >1</option>
									<option value="6"  {if isset($node.content.line_xs) && $node.content.line_xs == 6}selected{/if}>2</option>
									<option value="4"  {if isset($node.content.line_xs) && $node.content.line_xs == 4}selected{/if} >3</option>
									<option value="3"  {if isset($node.content.line_xs) && $node.content.line_xs == 3}selected{/if}>4</option>
								</select>
							</div>
					</div>

					<div class="customhook-wrapper content-options-wrapper">
						<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Custom hook name' mod='iqitmegamenu'}</label>
								<div class="col-lg-9">
								<input value="{if isset($node.content.hook)}{$node.content.hook}{else}iqitContentCustom{/if}" type="text" class="custom-hook-name">
								<p class="help-block">
								<strong>{l s='!important! - Do not use same custom hook name twice' mod='iqitcontentcreator'}</strong><br />
								{l s='You can use this custom hook later in modules, for example in Revolution slider.' mod='iqitcontentcreator'}
								</p>
								</div>
						</div>
						</div>	

					<div class="moduleinclude-wrapper content-options-wrapper">
						<div class="alert alert-info col-lg-9 col-lg-offset-3">{l s='This function is only for advanced users, and issues related to this will be not supported. It maybe needed to clear Prestashop Cache if you do some changes in included module if they will be not visible.' mod='iqitcontentcreator'}</div>
						<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Module to show' mod='iqitcontentcreator'}</label>
								<select class="select-module col-lg-9">
										<option value="0" >{l s='- Select module -' mod='iqitcontentcreator'}</option>
									{foreach from=$available_modules item=module}
										<option value="{$module.id_module}" data-hooks="{$module.hooks}"{if isset($node.content.id_module) && $node.contentType == 9 && $node.content.id_module == $module.id_module}selected{/if} >{$module.name}</option>
									{/foreach}
								</select>
						</div>

						<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Show module using hook' mod='iqitcontentcreator'}</label>
								<div class="col-lg-9">
								<select class="select-module-hook ">
								{if isset($node.content.id_module) && $node.contentType == 9}
								{assign var="hooks" value=","|explode:$available_modules[$node.content.id_module].hooks}
								{foreach from=$hooks item=hook}
								<option value="{$hook}" {if isset($node.content.id_module) && $node.contentType == 9 && $node.content.hook == $hook}selected{/if} >{$hook}</option>
								{/foreach}
								{/if}
								</select>
								<div class="help-block">{l s='For IQITMEGAMENU and SIMPLESLIDESHOW you need to go also for module configuration and select IqitContentCreator as hook' mod='iqitcontentcreator'}</div></div>
						</div>
					</div>	

					<div class="product-boxes-styles-wrapper content-options-wrapper">
						<span class="optional-title">{l s='Optional style of product box - normal state' mod='iqitcontentcreator'}</span>
						<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Box shadow' mod='iqitcontentcreator'}</label>
								<select class="pbx_sh col-lg-9">
									<option value="0"  {if isset($node.content.box_style.pbx_sh) && $node.content.box_style.pbx_sh == 0}selected{/if} >{l s='Default' mod='iqitcontentcreator'}</option>
									<option value="1"  {if isset($node.content.box_style.pbx_sh) && $node.content.box_style.pbx_sh == 1}selected{/if} >{l s='Disabled' mod='iqitcontentcreator'}</option>
									<option value="2"  {if isset($node.content.box_style.pbx_sh) && $node.content.box_style.pbx_sh == 2}selected{/if} >{l s='Enabled' mod='iqitcontentcreator'}</option>									
								</select>
						</div>
						<div class="form-group">
						<label class="control-label col-lg-3">
							{l s='Border' mod='iqitcontentcreator'}
						</label>
					<div class="col-lg-9 ">
							<div class="form-group form-group-border">
									<div class="row">
										<div class="col-xs-6">
											<select name="pbx_b_st" class="pbx_b_st">
												<option value="5" {if isset($node.content.box_style.pbx_b_st) && $node.content.box_style.pbx_b_st==5}selected{/if}>{l s='groove' mod='iqitcontentcreator'}</option>
												<option value="4" {if isset($node.content.box_style.pbx_b_st) && $node.content.box_style.pbx_b_st==4}selected{/if}>{l s='double' mod='iqitcontentcreator'}</option>
												<option value="3" {if isset($node.content.box_style.pbx_b_st) && $node.content.box_style.pbx_b_st==3}selected{/if}>{l s='dotted' mod='iqitcontentcreator'}</option>
												<option value="2" {if isset($node.content.box_style.pbx_b_st) && $node.content.box_style.pbx_b_st==2}selected{/if}>{l s='dashed' mod='iqitcontentcreator'}</option>
												<option value="1" {if isset($node.content.box_style.pbx_b_st) && $node.content.box_style.pbx_b_st==1}selected{/if}>{l s='solid' mod='iqitcontentcreator'}</option>
												<option value="0" {if isset($node.content.box_style.pbx_b_st) && $node.content.box_style.pbx_b_st==0}selected{/if}>{l s='none' mod='iqitcontentcreator'}</option>
												<option value="6" {if isset($node.content.box_style.pbx_b_st)}{if $node.content.box_style.pbx_b_st==6}selected{/if}{else}selected{/if}>{l s='default' mod='iqitcontentcreator'}</option>
											</select>
										</div>
										<div class="col-xs-3">
											<select name="pbx_b_wh" class="pbx_b_wh">
												{for $i=1 to 10}
												<option value="{$i}" {if isset($node.content.box_style.pbx_b_wh)}{if $i==$node.content.box_style.pbx_b_wh}selected{/if}{else}{if $i==1}selected{/if}{/if}>{$i}px</option>
												{/for}
											</select>

										</div>

										<div class="col-xs-3">
											<div class="form-group">
												<div class="col-xs-12">
													<div class="row">
														<div class="input-group">
															<input type="text" class="spectrumcolor pbx_b_c {if isset($node.elementId)}pbx_b_c-{$node.elementId}{/if}" value="{if isset($node.content.box_style.pbx_b_c)}{$node.content.box_style.pbx_b_c}{/if}" />
														</div>
													</div>
												</div>
											</div>

										</div>
								
									</div>
								
							</div>
						</div>
					</div>

						<div class="form-group">
									<label class="control-label col-lg-3">
							{l s='Product box bg color' mod='iqitcontentcreator'}
						</label>
					<div class="col-lg-3 ">
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<div class="input-group">
											<input type="text" class="spectrumcolor pbx_bg {if isset($node.elementId)}pbx_bg-{$node.elementId}{/if}" value="{if isset($node.content.box_style.pbx_bg)}{$node.content.box_style.pbx_bg}{/if}" />
										</div>
									</div>
								</div>
							</div>
							
						</div>
						<label class="control-label col-lg-3">
							{l s='Product text color' mod='iqitcontentcreator'}
						</label>
					<div class="col-lg-3 ">
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<div class="input-group">
											<input type="text" class="spectrumcolor pbx_nc {if isset($node.elementId)}pbx_nc-{$node.elementId}{/if}" value="{if isset($node.content.box_style.pbx_nc)}{$node.content.box_style.pbx_nc}{/if}" />
										</div>
									</div>
								</div>
							</div>
							
						</div>
					</div>

					<div class="form-group">
								<label class="control-label col-lg-3">
							{l s='Product price color' mod='iqitcontentcreator'}
						</label>
					<div class="col-lg-3 ">
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<div class="input-group">
											<input type="text" class="spectrumcolor pbx_pc {if isset($node.elementId)}pbx_pc-{$node.elementId}{/if}" value="{if isset($node.content.box_style.pbx_pc)}{$node.content.box_style.pbx_pc}{/if}" />
										</div>
									</div>
								</div>
							</div>
							
						</div>

									<label class="control-label col-lg-3">
							{l s='Product ratings color' mod='iqitcontentcreator'}
						</label>
					<div class="col-lg-3 ">
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<div class="input-group">
											<input type="text" class="spectrumcolor pbx_rc {if isset($node.elementId)}pbx_rc-{$node.elementId}{/if}" value="{if isset($node.content.box_style.pbx_rc)}{$node.content.box_style.pbx_rc}{/if}" />
										</div>
									</div>
								</div>
							</div>
							
						</div>
					</div>

					<span class="optional-title">{l s='Optional style of product box - hover state' mod='iqitcontentcreator'}</span>

					<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Box shadow' mod='iqitcontentcreator'}</label>
								<select class="pbxh_sh col-lg-9">
									<option value="0"  {if isset($node.content.box_style.pbxh_sh) && $node.content.box_style.pbxh_sh == 0}selected{/if} >{l s='Default' mod='iqitcontentcreator'}</option>
									<option value="1"  {if isset($node.content.box_style.pbxh_sh) && $node.content.box_style.pbxh_sh == 1}selected{/if} >{l s='Disabled' mod='iqitcontentcreator'}</option>
									<option value="2"  {if isset($node.content.box_style.pbxh_sh) && $node.content.box_style.pbxh_sh == 2}selected{/if} >{l s='Enabled' mod='iqitcontentcreator'}</option>									
								</select>
						</div>
						<div class="form-group">
						<label class="control-label col-lg-3">
							{l s='Border' mod='iqitcontentcreator'}
						</label>
					<div class="col-lg-9 ">
							<div class="form-group form-group-border">
									<div class="row">
										<div class="col-xs-6">
											<select name="pbxh_b_st" class="pbxh_b_st">
												<option value="5" {if isset($node.content.box_style.pbxh_b_st) && $node.content.box_style.pbxh_b_st==5}selected{/if}>{l s='groove' mod='iqitcontentcreator'}</option>
												<option value="4" {if isset($node.content.box_style.pbxh_b_st) && $node.content.box_style.pbxh_b_st==4}selected{/if}>{l s='double' mod='iqitcontentcreator'}</option>
												<option value="3" {if isset($node.content.box_style.pbxh_b_st) && $node.content.box_style.pbxh_b_st==3}selected{/if}>{l s='dotted' mod='iqitcontentcreator'}</option>
												<option value="2" {if isset($node.content.box_style.pbxh_b_st) && $node.content.box_style.pbxh_b_st==2}selected{/if}>{l s='dashed' mod='iqitcontentcreator'}</option>
												<option value="1" {if isset($node.content.box_style.pbxh_b_st) && $node.content.box_style.pbxh_b_st==1}selected{/if}>{l s='solid' mod='iqitcontentcreator'}</option>
												<option value="0" {if isset($node.content.box_style.pbxh_b_st) && $node.content.box_style.pbxh_b_st==0}selected{/if}>{l s='none' mod='iqitcontentcreator'}</option>
												<option value="6" {if isset($node.content.box_style.pbxh_b_st)}{if $node.content.box_style.pbxh_b_st==6}selected{/if}{else}selected{/if}>{l s='default' mod='iqitcontentcreator'}</option>
											</select>
										</div>
										<div class="col-xs-3">
											<select name="pbxh_b_wh" class="pbxh_b_wh">
												{for $i=1 to 10}
												<option value="{$i}" {if isset($node.content.box_style.pbxh_b_wh)}{if $i==$node.content.box_style.pbxh_b_wh}selected{/if}{else}{if $i==1}selected{/if}{/if}>{$i}px</option>
												{/for}
											</select>

										</div>

										<div class="col-xs-3">
											<div class="form-group">
												<div class="col-xs-12">
													<div class="row">
														<div class="input-group">
															<input type="text" class="spectrumcolor pbxh_b_c {if isset($node.elementId)}pbxh_b_c-{$node.elementId}{/if}" value="{if isset($node.content.box_style.pbxh_b_c)}{$node.content.box_style.pbxh_b_c}{/if}" />
														</div>
													</div>
												</div>
											</div>

										</div>
								
									</div>
								
							</div>
						</div>
					</div>

						<div class="form-group">
									<label class="control-label col-lg-3">
							{l s='Product box bg color' mod='iqitcontentcreator'}
						</label>
					<div class="col-lg-3 ">
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<div class="input-group">
											<input type="text" class="spectrumcolor pbxh_bg {if isset($node.elementId)}pbxh_bg-{$node.elementId}{/if}" value="{if isset($node.content.box_style.pbxh_bg)}{$node.content.box_style.pbxh_bg}{/if}" />
										</div>
									</div>
								</div>
							</div>
							
						</div>
						<label class="control-label col-lg-3">
							{l s='Product text color' mod='iqitcontentcreator'}
						</label>
					<div class="col-lg-3 ">
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<div class="input-group">
											<input type="text" class="spectrumcolor pbxh_nc {if isset($node.elementId)}pbxh_nc-{$node.elementId}{/if}" value="{if isset($node.content.box_style.pbxh_nc)}{$node.content.box_style.pbxh_nc}{/if}" />
										</div>
									</div>
								</div>
							</div>
							
						</div>
					</div>

					<div class="form-group">
								<label class="control-label col-lg-3">
							{l s='Product price color' mod='iqitcontentcreator'}
						</label>
					<div class="col-lg-3 ">
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<div class="input-group">
											<input type="text" class="spectrumcolor pbxh_pc {if isset($node.elementId)}pbxh_pc-{$node.elementId}{/if}" value="{if isset($node.content.box_style.pbxh_pc)}{$node.content.box_style.pbxh_pc}{/if}" />
										</div>
									</div>
								</div>
							</div>
							
						</div>

									<label class="control-label col-lg-3">
							{l s='Product ratings color' mod='iqitcontentcreator'}
						</label>
					<div class="col-lg-3 ">
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<div class="input-group">
											<input type="text" class="spectrumcolor pbxh_rc {if isset($node.elementId)}pbxh_rc-{$node.elementId}{/if}" value="{if isset($node.content.box_style.pbxh_rc)}{$node.content.box_style.pbxh_rc}{/if}" />
										</div>
									</div>
								</div>
							</div>
							
						</div>
					</div>
					</div>

					<div class="style-wrapper clearfix">
						<div class="col-lg-9 col-md-offset-3">
						<p class="help-block">
								{l s='Optional column style fields' mod='iqitcontentcreator'}
							</p>
						</div>
						<div class="form-group">
						<label class="control-label col-lg-3">
							{l s='Column Background color' mod='iqitcontentcreator'}
						</label>
					<div class="col-lg-9 ">
							<div class="form-group">
								<div class="col-lg-4">
									<div class="row">
										<div class="input-group">
											<input type="text" class="spectrumcolor column_bg_color {if isset($node.elementId)}column_bg_color-{$node.elementId}{/if}"	name="column_bg_color" value="{if isset($node.content_s.bg_color)}{$node.content_s.bg_color}{/if}" />
										</div>
									</div>
								</div>
							</div>
							
						</div>
						</div>
							<div class="form-group">
									<label class="control-label col-lg-3">
							{l s='Title background color' mod='iqitcontentcreator'}
						</label>
					<div class="col-lg-3 ">
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<div class="input-group">
											<input type="text" class="spectrumcolor title_bg {if isset($node.elementId)}title_bg-{$node.elementId}{/if}" value="{if isset($node.content_s.title_bg)}{$node.content_s.title_bg}{/if}" />
										</div>
									</div>
								</div>
							</div>
							
						</div>
						<label class="control-label col-lg-3">
							{l s='Title border color if exist' mod='iqitcontentcreator'}
						</label>
					<div class="col-lg-3 ">
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<div class="input-group">
											<input type="text" class="spectrumcolor title_borderc {if isset($node.elementId)}title_borderc-{$node.elementId}{/if}" value="{if isset($node.content_s.title_borderc)}{$node.content_s.title_borderc}{/if}" />
										</div>
									</div>
								</div>
							</div>
							
						</div>
					</div>


					<div class="form-group">
						<label class="control-label col-lg-3">
							{l s='Title text color' mod='iqitcontentcreator'}
						</label>
					<div class="col-lg-3 ">
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<div class="input-group">
											<input type="text" class="spectrumcolor title_color {if isset($node.elementId)}title_color-{$node.elementId}{/if}" value="{if isset($node.content_s.title_color)}{$node.content_s.title_color}{/if}" />
										</div>
									</div>
								</div>
							</div>
							
						</div>
					
						<label class="control-label col-lg-3">
							{l s='Title text hover color' mod='iqitcontentcreator'}
						</label>
					<div class="col-lg-3 ">
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<div class="input-group">
											<input type="text" class="spectrumcolor title_colorh {if isset($node.elementId)}title_colorh-{$node.elementId}{/if}" value="{if isset($node.content_s.title_colorh)}{$node.content_s.title_colorh}{/if}" />
										</div>
									</div>
								</div>
							</div>
							
						</div>
					
					</div>

					<div class="form-group">
						<label class="control-label col-lg-3">
							{l s='Title legend backgrund color' mod='iqitcontentcreator'}
						</label>
					<div class="col-lg-3 ">
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<div class="input-group">
											<input type="text" class="spectrumcolor legend_bg {if isset($node.elementId)}legend_bg-{$node.elementId}{/if}"	name="legend_bg" value="{if isset($node.content_s.legend_bg)}{$node.content_s.legend_bg}{/if}" />
										</div>
									</div>
								</div>
							</div>
							
						</div>
					
						<label class="control-label col-lg-3">
							{l s='Title legend text color' mod='iqitcontentcreator'}
						</label>
					<div class="col-lg-3 ">
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<div class="input-group">
											<input type="text" class="spectrumcolor legend_txt {if isset($node.elementId)}legend_txt-{$node.elementId}{/if}"	name="legend_txt" value="{if isset($node.content_s.legend_txt)}{$node.content_s.legend_txt}{/if}" />
										</div>
									</div>
								</div>
							</div>
							
						</div>
					
					</div>
					

					<div class="form-group">
						<label class="control-label col-lg-3">
							{l s='Border top' mod='iqitcontentcreator'}
						</label>
					<div class="col-lg-9 ">
							<div class="form-group">
									<div class="row">
										<div class="col-xs-6">
											<select name="br_top_st" class="br_top_st">
												<option value="5" {if isset($node.content_s.br_top_st) && $node.content_s.br_top_st==5}selected{/if}>{l s='groove' mod='iqitcontentcreator'}</option>
												<option value="4" {if isset($node.content_s.br_top_st) && $node.content_s.br_top_st==4}selected{/if}>{l s='double' mod='iqitcontentcreator'}</option>
												<option value="3" {if isset($node.content_s.br_top_st) && $node.content_s.br_top_st==3}selected{/if}>{l s='dotted' mod='iqitcontentcreator'}</option>
												<option value="2" {if isset($node.content_s.br_top_st) && $node.content_s.br_top_st==2}selected{/if}>{l s='dashed' mod='iqitcontentcreator'}</option>
												<option value="1" {if isset($node.content_s.br_top_st) && $node.content_s.br_top_st==1}selected{/if}>{l s='solid' mod='iqitcontentcreator'}</option>
												<option value="0" {if isset($node.content_s.br_top_st)}{if $node.content_s.br_top_st==0}selected{/if}{else}selected{/if}>{l s='none' mod='iqitcontentcreator'}</option>
											</select>
										</div>
										<div class="col-xs-3">
											<select name="br_top_wh" class="br_top_wh">
												{for $i=1 to 10}
												<option value="{$i}" {if isset($node.content_s.br_top_wh)}{if $i==$node.content_s.br_top_wh}selected{/if}{else}{if $i==1}selected{/if}{/if}>{$i}px</option>
												{/for}
											</select>

										</div>

										<div class="col-xs-3">
											<div class="form-group">
												<div class="col-xs-12">
													<div class="row">
														<div class="input-group">
															<input type="text" class="spectrumcolor br_top_c {if isset($node.elementId)}br_top_c-{$node.elementId}{/if}" value="{if isset($node.content_s.br_top_c)}{$node.content_s.br_top_c}{/if}" />
														</div>
													</div>
												</div>
											</div>

										</div>

								
									</div>
								
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-3">
							{l s='Border right' mod='iqitcontentcreator'}
						</label>
					<div class="col-lg-9 ">
							<div class="form-group">
									<div class="row">
										<div class="col-xs-6">
											<select name="br_right_st" class="br_right_st">
												<option value="5" {if isset($node.content_s.br_right_st) && $node.content_s.br_right_st==5}selected{/if}>{l s='groove' mod='iqitcontentcreator'}</option>
												<option value="4" {if isset($node.content_s.br_right_st) && $node.content_s.br_right_st==4}selected{/if}>{l s='double' mod='iqitcontentcreator'}</option>
												<option value="3" {if isset($node.content_s.br_right_st) && $node.content_s.br_right_st==3}selected{/if}>{l s='dotted' mod='iqitcontentcreator'}</option>
												<option value="2" {if isset($node.content_s.br_right_st) && $node.content_s.br_right_st==2}selected{/if}>{l s='dashed' mod='iqitcontentcreator'}</option>
												<option value="1" {if isset($node.content_s.br_right_st) && $node.content_s.br_right_st==1}selected{/if}>{l s='solid' mod='iqitcontentcreator'}</option>
												<option value="0" {if isset($node.content_s.br_right_st)}{if $node.content_s.br_right_st==0}selected{/if}{else}selected{/if}>{l s='none' mod='iqitcontentcreator'}</option>
											</select>
										</div>
										<div class="col-xs-3">
											<select name="br_right_wh" class="br_right_wh">
												{for $i=1 to 10}
												<option value="{$i}" {if isset($node.content_s.br_right_wh)}{if $i==$node.content_s.br_right_wh}selected{/if}{else}{if $i==1}selected{/if}{/if}>{$i}px</option>
												{/for}
											</select>

										</div>

										<div class="col-xs-3">
											<div class="form-group">
												<div class="col-xs-12">
													<div class="row">
														<div class="input-group">
															<input type="text" class="spectrumcolor br_right_c {if isset($node.elementId)}br_right_c-{$node.elementId}{/if}" value="{if isset($node.content_s.br_right_c)}{$node.content_s.br_right_c}{/if}" />
														</div>
													</div>
												</div>
											</div>

										</div>
								
									</div>
								
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-3">
							{l s='Border bottom' mod='iqitcontentcreator'}
						</label>
					<div class="col-lg-9 ">
							<div class="form-group">
									<div class="row">
										<div class="col-xs-6">
											<select name="br_bottom_st" class="br_bottom_st">
												<option value="5" {if isset($node.content_s.br_bottom_st) && $node.content_s.br_bottom_st==5}selected{/if}>{l s='groove' mod='iqitcontentcreator'}</option>
												<option value="4" {if isset($node.content_s.br_bottom_st) && $node.content_s.br_bottom_st==4}selected{/if}>{l s='double' mod='iqitcontentcreator'}</option>
												<option value="3" {if isset($node.content_s.br_bottom_st) && $node.content_s.br_bottom_st==3}selected{/if}>{l s='dotted' mod='iqitcontentcreator'}</option>
												<option value="2" {if isset($node.content_s.br_bottom_st) && $node.content_s.br_bottom_st==2}selected{/if}>{l s='dashed' mod='iqitcontentcreator'}</option>
												<option value="1" {if isset($node.content_s.br_bottom_st) && $node.content_s.br_bottom_st==1}selected{/if}>{l s='solid' mod='iqitcontentcreator'}</option>
												<option value="0" {if isset($node.content_s.br_bottom_st)}{if $node.content_s.br_bottom_st==0}selected{/if}{else}selected{/if}>{l s='none' mod='iqitcontentcreator'}</option>
											</select>
										</div>
										<div class="col-xs-3">
											<select name="br_bottom_wh" class="br_bottom_wh">
												{for $i=1 to 10}
												<option value="{$i}" {if isset($node.content_s.br_bottom_wh)}{if $i==$node.content_s.br_bottom_wh}selected{/if}{else}{if $i==1}selected{/if}{/if}>{$i}px</option>
												{/for}
											</select>

										</div>

										<div class="col-xs-3">
											<div class="form-group">
												<div class="col-xs-12">
													<div class="row">
														<div class="input-group">
															<input type="text" class="spectrumcolor br_bottom_c {if isset($node.elementId)}br_bottom_c-{$node.elementId}{/if}" value="{if isset($node.content_s.br_bottom_c)}{$node.content_s.br_bottom_c}{/if}" />
														</div>
													</div>
												</div>
											</div>

										</div>
									</div>
								
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-3">
							{l s='Border left' mod='iqitcontentcreator'}
						</label>
					<div class="col-lg-9 ">
							<div class="form-group">
									<div class="row">
										<div class="col-xs-6">
											<select name="br_left_st" class="br_left_st">
												<option value="5" {if isset($node.content_s.br_left_st) && $node.content_s.br_left_st==5}selected{/if}>{l s='groove' mod='iqitcontentcreator'}</option>
												<option value="4" {if isset($node.content_s.br_left_st) && $node.content_s.br_left_st==4}selected{/if}>{l s='double' mod='iqitcontentcreator'}</option>
												<option value="3" {if isset($node.content_s.br_left_st) && $node.content_s.br_left_st==3}selected{/if}>{l s='dotted' mod='iqitcontentcreator'}</option>
												<option value="2" {if isset($node.content_s.br_left_st) && $node.content_s.br_left_st==2}selected{/if}>{l s='dashed' mod='iqitcontentcreator'}</option>
												<option value="1" {if isset($node.content_s.br_left_st) && $node.content_s.br_left_st==1}selected{/if}>{l s='solid' mod='iqitcontentcreator'}</option>
												<option value="0" {if isset($node.content_s.br_left_st)}{if $node.content_s.br_left_st==0}selected{/if}{else}selected{/if}>{l s='none' mod='iqitcontentcreator'}</option>
											</select>
										</div>
										<div class="col-xs-3">
											<select name="br_left_wh" class="br_left_wh">
												{for $i=1 to 10}
												<option value="{$i}" {if isset($node.content_s.br_left_wh)}{if $i==$node.content_s.br_left_wh}selected{/if}{else}{if $i==1}selected{/if}{/if}>{$i}px</option>
												{/for}
											</select>

										</div>

										<div class="col-xs-3">
											<div class="form-group">
												<div class="col-xs-12">
													<div class="row">
														<div class="input-group">
															<input type="text" class="spectrumcolor br_left_c {if isset($node.elementId)}br_left_c-{$node.elementId}{/if}" value="{if isset($node.content_s.br_left_c)}{$node.content_s.br_left_c}{/if}" />
														</div>
													</div>
												</div>
											</div>

										</div>
									</div>
								
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3">
							{l s='Padding' mod='iqitcontentcreator'}
						</label>
					<div class="col-lg-9 ">
					<div class="column-checkbox"><input type="checkbox" class="c-padding-top" value="1" {if isset($node.content_s.c_p_t) && $node.content_s.c_p_t==1}checked{/if}> {l s='Top' mod='iqitcontentcreator'} </div>
					<div class="column-checkbox"><input type="checkbox" class="c-padding-right" value="1" {if isset($node.content_s.c_p_r) && $node.content_s.c_p_r==1}checked{/if} > {l s='Right' mod='iqitcontentcreator'} </div>
					<div class="column-checkbox"><input type="checkbox" class="c-padding-bottom" value="1" {if isset($node.content_s.c_p_b) && $node.content_s.c_p_b==1}checked{/if}> {l s='Bottom' mod='iqitcontentcreator'} </div>
					<div class="column-checkbox"><input type="checkbox" class="c-padding-left" value="1" {if isset($node.content_s.c_p_l) && $node.content_s.c_p_l==1}checked{/if}> {l s='Left' mod='iqitcontentcreator'} </div>
					<p class="help-block">
								{l s='If you enabled borders or custom background color it maybe needed to add padding for better effect' mod='iqitcontentcreator'}
					</p>
					</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-3">
							{l s='Negative margin' mod='iqitcontentcreator'}
						</label>
					<div class="col-lg-9 ">
					<div class="column-checkbox"><input type="checkbox" class="c-margin-top" value="1" {if isset($node.content_s.c_m_t) && $node.content_s.c_m_t==1}checked{/if}> {l s='Top' mod='iqitcontentcreator'} </div>
					<div class="column-checkbox"><input type="checkbox" class="c-margin-top2" value="1" {if isset($node.content_s.c_m_t2) && $node.content_s.c_m_t2==1}checked{/if}> {l s='Top 2x' mod='iqitcontentcreator'} </div>
					<div class="column-checkbox"><input type="checkbox" class="c-margin-right" value="1" {if isset($node.content_s.c_m_r) && $node.content_s.c_m_r==1}checked{/if}> {l s='Right' mod='iqitcontentcreator'} </div>
					<div class="column-checkbox"><input type="checkbox" class="c-margin-left" value="1" {if isset($node.content_s.c_m_l) && $node.content_s.c_m_l==1}checked{/if}> {l s='Left' mod='iqitcontentcreator'} </div>
					<p class="help-block">
								{l s='If you enabled padding, it maybe needed to add negative margin. For example you added background and padding only in one column from a row and you want to position title on the same height as other blocks, you have to add top negative margin. It maybe usefull also if you want to show banners images without spaces between them' mod='iqitcontentcreator'}
					</p>
					</div>
					</div>



					</div>		
					

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">{l s='Save' mod='iqitcontentcreator'}</button>
					</div>
				</div>
			</div>
		</div>






