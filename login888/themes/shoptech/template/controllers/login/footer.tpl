{*
* 2007-2016 PrestaShop
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
				</div>
				<!-- CONTAINER CLOSED -->
			</div>
		</div>
	</div>
	<!-- BACKGROUND-IMAGE CLOSED -->

	<!-- JQUERY SCRIPTS JS-->
	<script src="{$theme_path}/js/vendors/jquery-3.2.1.min.js"></script>

	<!-- BOOTSTRAP SCRIPTS JS-->
	<script src="{$theme_path}/js/vendors/bootstrap.bundle.min.js"></script>

	<!-- SPARKLINE JS-->
	<script src="{$theme_path}/js/vendors/jquery.sparkline.min.js"></script>

	<!-- CHART-CIRCLE JS-->
	<script src="{$theme_path}/js/vendors/circle-progress.min.js"></script>

	<!-- RATING STAR JS-->
	<script src="{$theme_path}/plugins/rating/rating-stars.js"></script>

	<!-- INPUT MASK JS-->
	<script src="{$theme_path}/plugins/input-mask/input-mask.min.js"></script>

	<!-- CUSTOM JS-->
	<script src="{$theme_path}/js/custom.js"></script>

{if isset($php_errors)}
	{include file="error.tpl"}
{/if}

{if isset($modals)}
<div class="bootstrap">
	{$modals}
</div>
{/if}

</body>
</html>
