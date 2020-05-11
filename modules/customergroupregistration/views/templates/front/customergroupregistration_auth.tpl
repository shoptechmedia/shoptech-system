{*
 * This file is part of module Customer Group Registration
 *
 *  @author    Bellini Services <bellini@bellini-services.com>
 *  @copyright 2007-2017 bellini-services.com
 *  @license   readme
 *
 * Your purchase grants you usage rights subject to the terms outlined by this license.
 *
 * You CAN use this module with a single, non-multi store configuration, production installation and unlimited test installations of PrestaShop.
 * You CAN make any modifications necessary to the module to make it fit your needs. However, the modified module will still remain subject to this license.
 *
 * You CANNOT redistribute the module as part of a content management system (CMS) or similar system.
 * You CANNOT resell or redistribute the module, modified, unmodified, standalone or combined with another product in any way without prior written (email) consent from bellini-services.com.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *}
{if $cgr_mode==0}
	<fieldset class="account_creation">
		<h3>{l s='Choose a Customer Group' mod='customergroupregistration'}</h3>
			<p class="required select">
				<label for="id_group">{l s='Customer Group' mod='customergroupregistration'}</label>
				<select name="id_group" id="id_group">
					{foreach from=$groups item=g}
					<option value="{$g.id_group}" {if ($sl_group == $g.id_group)} selected="selected"{/if}>{$g.name|escape:'htmlall':'UTF-8'}</option>	{* bellini: nothing else needs to be escaped *}
					{/foreach}
				</select>
				<sup>*</sup>
			</p>
	</fieldset>
{elseif $cgr_mode==1}
	<fieldset class="account_creation">
		<h3>{l s='Choose a Customer Group' mod='customergroupregistration'}</h3>
			<p class="required select">
				<label for="id_group">{l s='Customer Group' mod='customergroupregistration'}</label>
				<select name="id_group[]" id="id_group" multiple="multiple" size="5">
					{foreach from=$groups item=g}
					<option value="{$g.id_group}" {if ($sl_group == $g.id_group)} selected="selected"{/if}>{$g.name|escape:'htmlall':'UTF-8'}</option>	{* bellini: nothing else needs to be escaped *}
					{/foreach}
				</select>
				<sup>*</sup>
			</p>
	</fieldset>
{/if}