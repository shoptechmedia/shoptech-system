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



	<div class="menu-row-content">
		<div class="modal fade row-settings-modal" tabindex="-1" role="dialog" aria-labelledby="rowSettings" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-body">
						<div class="form-group">
							<label class="control-label col-lg-3">
								{l s='Background color' mod='iqitmegamenu'}
							</label>
							<div class="col-lg-9">
								<div class="row">
									<div class="input-group">
										<input type="text"  class="spectrumcolor  row-bgc {if isset($node.elementId)}row-bgc-{$node.elementId}{/if}"  name="row-bgc" value="{if isset($node.row_s.bgc)}{$node.row_s.bgc}{/if}" />
									</div>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-3">
								{l s='Background image' mod='iqitmegamenu'}
							</label>
							<div class="col-lg-9">
									<input value="{if isset($node.row_s.bgi)}{$node.row_s.bgi}{/if}" type="text" class="row-bgi i-upload-input" name="{if isset($node.elementId)}{$node.elementId}-{/if}row-bgi"  id="{if isset($node.elementId)}{$node.elementId}-{/if}row-bgi" >
									<a href="{if isset($admin_link)}{$admin_link}{/if}filemanager/dialog.php?type=1&field_id={if isset($node.elementId)}{$node.elementId}-{/if}row-bgi" class="btn btn-default iframe-column-upload i-upload-input"  data-input-name="{if isset($node.elementId)}{$node.elementId}-{/if}row-bgi" type="button">{l s='Select image' mod='iqitmegamenu'} <i class="icon-angle-right"></i></a>
						</div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-3">{l s='Background image repeat' mod='iqitmegamenu'}</label>
							<select class="select-row-bgr col-lg-9">
								<option value="3" {if isset($node.row_s.bgr) && $node.row_s.bgr==3}selected{/if}>{l s='Repeat XY' mod='iqitmegamenu'}</option>
								<option value="2" {if isset($node.row_s.bgr) && $node.row_s.bgr==2}selected{/if}>{l s='Repeat X' mod='iqitmegamenu'}</option>
								<option value="1" {if isset($node.row_s.bgr) && $node.row_s.bgr==1}selected{/if}>{l s='Repeat Y' mod='iqitmegamenu'}</option>
								<option value="0" {if isset($node.row_s.bgr) && $node.row_s.bgr==0}selected{/if} >{l s='No repeat' mod='iqitmegamenu'}</option>

							</select></div>

						<div class="form-group">
							<label class="control-label col-lg-3">{l s='Background image parallax' mod='iqitmegamenu'}</label>
							<div class="col-lg-9">
							<select class="select-row-prlx">
								<option value="0" {if isset($node.row_s.prlx) && $node.row_s.prlx==0}selected{/if}>{l s='No' mod='iqitmegamenu'}</option>
								<option value="1" {if isset($node.row_s.prlx) && $node.row_s.prlx==1}selected{/if}>{l s='Yes' mod='iqitmegamenu'}</option>
							</select>
							<p class="help-block">
								{l s='Make shure you uploaded background image before enabling this option, for good effect it should be 1920px width' mod='iqitmegamenu'}
							</p>
						</div>
						</div>	

						<div class="form-group">
							<label class="control-label col-lg-3">{l s='Row width' mod='iqitmegamenu'}</label>
							<div class="col-lg-9">
							<select class="select-row-bgw">
								<option value="0" {if isset($node.row_s.bgw) && $node.row_s.bgw==0}selected{/if}>{l s='Content width' mod='iqitmegamenu'}</option>
								<option value="2" {if isset($node.row_s.bgw) && $node.row_s.bgw==2}selected{/if}>{l s='Force full width' mod='iqitmegamenu'}</option>
								<option value="1" {if isset($node.row_s.bgw) && $node.row_s.bgw==1}selected{/if}>{l s='Force full width of background only' mod='iqitmegamenu'}</option>
						</select>
						<p class="help-block">
								{l s='Enable force full width option only if you not using columns(left, right). There is no need to use force full width option if you allready set full width for entire theme in themeeditor' mod='iqitmegamenu'}
							</p>
					</div></div>

					<div class="form-group">
							<label class="control-label col-lg-3">{l s='Row height' mod='iqitmegamenu'}</label>
							<div class="col-lg-9">
							<select class="select-row-bgh">
								<option value="0" {if isset($node.row_s.bgh) && $node.row_s.bgh==0}selected{/if}>{l s='Auto' mod='iqitmegamenu'}</option>
								<option value="1" {if isset($node.row_s.bgh) && $node.row_s.bgh==1}selected{/if}>{l s='100% viewport height' mod='iqitmegamenu'}</option>
						</select>
						<p class="help-block">
								{l s='100 viewport height will make row to fill entire screen. It maybe useful for parallax effect in combination with vertical centering of columns' mod='iqitmegamenu'}
							</p>
					</div></div>

					<div class="form-group">
						<label class="control-label col-lg-3">
							{l s='Border top' mod='iqitmegamenu'}
						</label>
					<div class="col-lg-9 ">
							<div class="form-group">
									<div class="row">
										<div class="col-xs-6">
											<select name="br_top_st" class="br_top_st">
												<option value="5" {if isset($node.row_s.br_top_st) && $node.row_s.br_top_st==5}selected{/if}>{l s='groove' mod='iqitmegamenu'}</option>
												<option value="4" {if isset($node.row_s.br_top_st) && $node.row_s.br_top_st==4}selected{/if}>{l s='double' mod='iqitmegamenu'}</option>
												<option value="3" {if isset($node.row_s.br_top_st) && $node.row_s.br_top_st==3}selected{/if}>{l s='dotted' mod='iqitmegamenu'}</option>
												<option value="2" {if isset($node.row_s.br_top_st) && $node.row_s.br_top_st==2}selected{/if}>{l s='dashed' mod='iqitmegamenu'}</option>
												<option value="1" {if isset($node.row_s.br_top_st) && $node.row_s.br_top_st==1}selected{/if}>{l s='solid' mod='iqitmegamenu'}</option>
												<option value="0" {if isset($node.row_s.br_top_st)}{if $node.row_s.br_top_st==0}selected{/if}{else}selected{/if}>{l s='none' mod='iqitmegamenu'}</option>
											</select>
										</div>
										<div class="col-xs-3">
											<select name="br_top_wh" class="br_top_wh">
												{for $i=1 to 10}
												<option value="{$i}" {if isset($node.row_s.br_top_wh)}{if $i==$node.row_s.br_top_wh}selected{/if}{else}{if $i==1}selected{/if}{/if}>{$i}px</option>
												{/for}
											</select>

										</div>

										<div class="col-xs-3">
											<div class="form-group">
												<div class="col-xs-12">
													<div class="row">
														<div class="input-group">
															<input type="text" class="spectrumcolor br_top_c {if isset($node.elementId)}br_top_c-{$node.elementId}{/if}" value="{if isset($node.row_s.br_top_c)}{$node.row_s.br_top_c}{/if}" />
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
							{l s='Border bottom' mod='iqitmegamenu'}
						</label>
					<div class="col-lg-9 ">
							<div class="form-group">
									<div class="row">
										<div class="col-xs-6">
											<select name="br_bottom_st" class="br_bottom_st">
												<option value="5" {if isset($node.row_s.br_bottom_st) && $node.row_s.br_bottom_st==5}selected{/if}>{l s='groove' mod='iqitmegamenu'}</option>
												<option value="4" {if isset($node.row_s.br_bottom_st) && $node.row_s.br_bottom_st==4}selected{/if}>{l s='double' mod='iqitmegamenu'}</option>
												<option value="3" {if isset($node.row_s.br_bottom_st) && $node.row_s.br_bottom_st==3}selected{/if}>{l s='dotted' mod='iqitmegamenu'}</option>
												<option value="2" {if isset($node.row_s.br_bottom_st) && $node.row_s.br_bottom_st==2}selected{/if}>{l s='dashed' mod='iqitmegamenu'}</option>
												<option value="1" {if isset($node.row_s.br_bottom_st) && $node.row_s.br_bottom_st==1}selected{/if}>{l s='solid' mod='iqitmegamenu'}</option>
												<option value="0" {if isset($node.row_s.br_bottom_st)}{if $node.row_s.br_bottom_st==0}selected{/if}{else}selected{/if}>{l s='none' mod='iqitmegamenu'}</option>
											</select>
										</div>
										<div class="col-xs-3">
											<select name="br_bottom_wh" class="br_bottom_wh">
												{for $i=1 to 10}
												<option value="{$i}" {if isset($node.row_s.br_bottom_wh)}{if $i==$node.row_s.br_bottom_wh}selected{/if}{else}{if $i==1}selected{/if}{/if}>{$i}px</option>
												{/for}
											</select>

										</div>

										<div class="col-xs-3">
											<div class="form-group">
												<div class="col-xs-12">
													<div class="row">
														<div class="input-group">
															<input type="text" class="spectrumcolor br_bottom_c {if isset($node.elementId)}br_bottom_c-{$node.elementId}{/if}" value="{if isset($node.row_s.br_bottom_c)}{$node.row_s.br_bottom_c}{/if}" />
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
							<label class="control-label col-lg-3">{l s='Padding-top' mod='iqitmegamenu'}</label>
							<div class="col-lg-9">
							<select class="select-r-padding-top">
								<option value="0" {if isset($node.row_s.p_t) && $node.row_s.p_t==0}selected{/if}>{l s='No Padding' mod='iqitmegamenu'}</option>
								<option value="20" {if isset($node.row_s.p_t) && $node.row_s.p_t==20}selected{/if}>{l s='20px padding' mod='iqitmegamenu'}</option>
								<option value="40" {if isset($node.row_s.p_t) && $node.row_s.p_t==40}selected{/if}>{l s='40px padding' mod='iqitmegamenu'}</option>
								<option value="60" {if isset($node.row_s.p_t) && $node.row_s.p_t==60}selected{/if}>{l s='60px padding' mod='iqitmegamenu'}</option>
						</select>
						<p class="help-block">
								{l s='Note that each column in row have 20px margin-top, so if you add row padding top 20px, you should also add padding bottom 40px for equal bottom and top padding' mod='iqitcontentcreator'}
					</p>
							</p>
					</div></div>

					<div class="form-group">
							<label class="control-label col-lg-3">{l s='Padding-bottom' mod='iqitmegamenu'}</label>
							<div class="col-lg-9">
							<select class="select-r-padding-bottom">
								<option value="0" {if isset($node.row_s.p_b) && $node.row_s.p_b==0}selected{/if}>{l s='No Padding' mod='iqitmegamenu'}</option>
								<option value="20" {if isset($node.row_s.p_b) && $node.row_s.p_b==20}selected{/if}>{l s='20px padding' mod='iqitmegamenu'}</option>
								<option value="40" {if isset($node.row_s.p_b) && $node.row_s.p_b==40}selected{/if}>{l s='40px padding' mod='iqitmegamenu'}</option>
								<option value="60" {if isset($node.row_s.p_b) && $node.row_s.p_b==60}selected{/if}>{l s='60px padding' mod='iqitmegamenu'}</option>
								<option value="80" {if isset($node.row_s.p_b) && $node.row_s.p_b==80}selected{/if}>{l s='80px padding' mod='iqitmegamenu'}</option>
						</select>
						<p class="help-block">
								{l s='Note that each column in row have 20px margin-top, so if you add row padding top 20px, you should also add padding bottom 40px for equal bottom and top padding' mod='iqitcontentcreator'}
					</p>
							</p>
					</div></div>


					<div class="form-group">
						<label class="control-label col-lg-3">
							{l s='Disable row negative margin' mod='iqitcontentcreator'}
						</label>
					<div class="col-lg-9 ">
					<div class="column-checkbox"><input type="checkbox" class="r-margin-right" value="1" {if isset($node.row_s.m_r) && $node.row_s.m_r==1}checked{/if}> {l s='Disable Right' mod='iqitcontentcreator'} </div>
					<div class="column-checkbox"><input type="checkbox" class="r-margin-left" value="1" {if isset($node.row_s.m_l) && $node.row_s.m_l==1}checked{/if}> {l s='Disable Left' mod='iqitcontentcreator'} </div>
					<p class="help-block">
								{l s='It maybe usefull if you want to show banners images without spaces between them' mod='iqitcontentcreator'}
					</p>
					</div>
					</div>

					<div class="form-group">
							<label class="control-label col-lg-3">{l s='Disable columns padding' mod='iqitmegamenu'}</label>
							<div class="col-lg-9">
							<select class="select-row-padd">
								<option value="0" {if isset($node.row_s.padd) && $node.row_s.padd==0}selected{/if}>{l s='No' mod='iqitmegamenu'}</option>
								<option value="1" {if isset($node.row_s.padd) && $node.row_s.padd==1}selected{/if}>{l s='Yes' mod='iqitmegamenu'}</option>
							</select>
							<p class="help-block">
								{l s='It maybe usefull if you want to show banners images without spaces between them' mod='iqitcontentcreator'}
							</p>
					</div>
					</div>	
					
					<div class="form-group">
							<label class="control-label col-lg-3">{l s='Center columns vertically' mod='iqitmegamenu'}</label>
							<div class="col-lg-9">
							<select class="select-row-valign">
								<option value="0" {if isset($node.row_s.valign) && $node.row_s.valign==0}selected{/if}>{l s='No' mod='iqitmegamenu'}</option>
								<option value="1" {if isset($node.row_s.valign) && $node.row_s.valign==1}selected{/if}>{l s='Yes' mod='iqitmegamenu'}</option>
							</select>
							<p class="help-block">
								{l s='It maybe usefull if you want to show big banner next to product slider' mod='iqitcontentcreator'}
							</p>
					</div>
					</div>	


					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">{l s='Save' mod='iqitmegamenu'}</button>
					</div>
				</div>	
			</div>
		</div>
	</div>	


