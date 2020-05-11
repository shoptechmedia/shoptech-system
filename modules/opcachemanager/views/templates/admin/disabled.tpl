{*
 * Copyright (C) 2017-2018 thirty bees
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.md
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@thirtybees.com so we can send you a copy immediately.
 *
 * @author    thirty bees <contact@thirtybees.com>
 * @copyright 2017-2018 thirty bees
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *}

<div class="panel">
  <div class="row moduleconfig-header">
    <h1>{l s='Unable to retrieve OPCache status' mod='opcachemanager'}</h1>
    <p>{l s='It looks like you do not have OPCache running on your server or one of the following functions has been disabled:' mod='opcachemanager'}</p>
    <ul>
      <li><kbd>opcache_reset</kbd></li>
      <li><kbd>opcache_invalidate</kbd></li>
      <li><kbd>opcache_get_configuration</kbd></li>
      <li><kbd>opcache_get_status</kbd></li>
    </ul>
  </div>
</div>
