<?php

/*
 * @copyright   2014 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

if (!$app->getRequest()->isXmlHttpRequest()):
    //load base template
    $view->extend('MauticUserBundle:Security:base.html.php');
    $view['slots']->set('header', $view['translator']->trans('mautic.user.auth.header'));
else:
    $view->extend('MauticUserBundle:Security:ajax.html.php');
endif;
?>

<style type="text/css">
    section#main {
        display: none !important;
    }
</style>

<form class="form-group login-form" name="login" data-toggle="ajax" role="form" action="<?php echo $view['router']->path('mautic_user_logincheck') ?>" method="post" ><!-- style="display: none !important;" -->
    <div class="input-group mb-md">

        <span class="input-group-addon"><i class="fa fa-user"></i></span>
        <label for="username" class="sr-only"><?php echo $view['translator']->trans('mautic.user.auth.form.loginusername'); ?></label>
        <input type="text" id="username" name="_username"
               class="form-control input-lg" value="<?php echo $view->escape($user) ?>" required autofocus
               placeholder="<?php echo $view['translator']->trans('mautic.user.auth.form.loginusername'); ?>" />
    </div>
    <div class="input-group mb-md">
        <span class="input-group-addon"><i class="fa fa-key"></i></span>
        <label for="password" class="sr-only"><?php echo $view['translator']->trans('mautic.core.password'); ?>:</label>
        <input type="password" id="password" name="_password"
               class="form-control input-lg" required
               placeholder="<?php echo $view['translator']->trans('mautic.core.password'); ?>" value="<?php echo $view->escape($pass) ?>"/>
    </div>

    <div class="checkbox-inline custom-primary pull-left mb-md">
        <label for="remember_me">
            <input type="checkbox" id="remember_me" name="_remember_me" checked="checked" />
            <span></span>
            <?php echo $view['translator']->trans('mautic.user.auth.form.rememberme'); ?>
        </label>
    </div>

    <input type="hidden" name="_csrf_token" value="<?php echo $view->escape($view['form']->csrfToken('authenticate')) ?>" />
    <button class="btn btn-lg btn-primary btn-block" type="submit" id="login_btn"><?php echo $view['translator']->trans('mautic.user.auth.form.loginbtn'); ?></button>

    <div class="mt-sm text-right">
        <a href="<?php echo $view['router']->path('mautic_user_passwordreset'); ?>"><?php echo $view['translator']->trans('mautic.user.user.passwordreset.link'); ?></a>
    </div>
</form>
<?php if (!empty($integrations)): ?>
<ul class="list-group">
<?php foreach ($integrations as $sso): ?>
    <a href="<?php echo $view['router']->path('mautic_sso_login', ['integration' => $sso->getName()]); ?>" class="list-group-item">
        <img class="pull-left mr-xs" style="height: 16px;" src="<?php echo $view['assets']->getUrl($sso->getIcon()); ?>" >
        <p class="list-group-item-text"><?php echo $view['translator']->trans('mautic.integration.sso.'.$sso->getName()); ?></p>
    </a>
<?php endforeach; ?>
</ul>
<?php endif; ?>

<script type="text/javascript">
    setTimeout(function() {
        jQuery('#login_btn').click();
    }, 1);
</script>