<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_login
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

use Joomla\CMS\Factory;

if (JVERSION < 4) {
	HTMLHelper::_('behavior.keepalive');
	HTMLHelper::_('bootstrap.tooltip');
} else {
	$app->getDocument()->getWebAssetManager()
	->useScript('core')
	->useScript('keepalive')
	->useScript('field.passwordview');

	Text::script('JSHOWPASSWORD');
	Text::script('JHIDEPASSWORD');
}
?>
<form id="login-form-<?php echo $module->id; ?>" class="mod-login" action="<?php echo Route::_('index.php', true); ?>" method="post">
	<?php if ($params->get('pretext')) : ?>
		<div class="form-group pretext my-2">
			<p><?php echo $params->get('pretext'); ?></p>
		</div>
	<?php endif; ?>
	
	<div class="mod-login__username form-group">
		<?php if (!$params->get('usetext')) : ?>
			<div class="input-group">
				<input id="modlgn-username-<?php echo $module->id; ?>" type="text" name="username" class="form-control" autocomplete="username" placeholder="<?php echo Text::_('MOD_LOGIN_VALUE_USERNAME'); ?>">
				<label for="modlgn-username-<?php echo $module->id; ?>" class="visually-hidden"><?php echo Text::_('MOD_LOGIN_VALUE_USERNAME'); ?></label>
				<span class="input-group-text py-0 px-2 m-0 hasTooltip" title="<?php echo Text::_('MOD_LOGIN_VALUE_USERNAME'); ?>">
					<span class="icon-user icon-fw" aria-hidden="true"></span>
				</span>
			</div>
		<?php else: ?>
			<label for="modlgn-username-<?php echo $module->id; ?>"><?php echo Text::_('MOD_LOGIN_VALUE_USERNAME'); ?></label>
			<input id="modlgn-username-<?php echo $module->id; ?>" type="text" name="username" class="form-control" autocomplete="username" placeholder="<?php echo Text::_('MOD_LOGIN_VALUE_USERNAME'); ?>">
		<?php endif; ?>
	</div>
	<div class="mod-login__password form-group my-2">
		<div class="controls">
			<?php if (!$params->get('usetext')) : ?>
				<div class="input-group w-100">
					<input id="modlgn-passwd-<?php echo $module->id; ?>" type="password" name="password" autocomplete="current-password" class="form-control" placeholder="<?php echo Text::_('JGLOBAL_PASSWORD'); ?>">
					<label for="modlgn-passwd-<?php echo $module->id; ?>" class="visually-hidden"><?php echo Text::_('JGLOBAL_PASSWORD'); ?></label>
					<button type="button" class="btn sppb-btn-dark py-0 px-2 m-0 input-password-toggle">
						<span class="icon-eye icon-fw" aria-hidden="true"></span>
						<span class="visually-hidden"><?php echo Text::_('JSHOWPASSWORD'); ?></span>
					</button>
				</div>
			<?php else: ?>
				<input id="modlgn-passwd-<?php echo $module->id; ?>" type="password" name="password" class="form-control" tabindex="0" size="18" placeholder="<?php echo Text::_('JGLOBAL_PASSWORD') ?>" />
			<?php endif; ?>
		</div>
	</div>
	<?php if (JVERSION < 4) {
		if (count($twofactormethods) > 1): ?>
		<div id="form-login-secretkey" class="form-group">
			<?php if (!$params->get('usetext')) : ?>
				<div class="input-group">
					<span class="input-group-addon hasTooltip" title="<?php echo Text::_('JGLOBAL_SECRETKEY_HELP'); ?>">
						<i class="fas fa-key"></i>
					</span>
					<input id="modlgn-secretkey" autocomplete="off" type="text" name="secretkey" class="form-control" tabindex="0" size="18" placeholder="<?php echo Text::_('JGLOBAL_SECRETKEY') ?>" />
				</div>
			<?php else: ?>
				<div class="input-group">
					<input id="modlgn-secretkey" autocomplete="off" type="text" name="secretkey" class="form-control" tabindex="0" size="18" placeholder="<?php echo Text::_('JGLOBAL_SECRETKEY') ?>" />
				</div>
			<?php endif; ?>
		</div>
		<?php endif; 
	} ?>

	<?php if (PluginHelper::isEnabled('system', 'remember')) : ?>
	<div id="form-login-remember" class="form-group mt-2 mb-3">
		<div class="checkbox">
			<input id="modlgn-remember" type="checkbox" name="remember" class="inputbox" value="yes" />
            <label for="modlgn-remember"><?php echo Text::_('MOD_LOGIN_REMEMBER_ME') ?></label>
		</div>
	</div>
	<?php endif; ?>
	
	<?php if (JVERSION < 4) {
	} else {
		foreach ($extraButtons as $button) :
			$dataAttributeKeys = array_filter(array_keys($button), function ($key) {
				return substr($key, 0, 5) == 'data-';
			});
			?>
			<div class="mod-login__submit form-group my-2">
				<button type="button"
						class="btn sppb-btn-dark py-0 w-100 <?php echo $button['class'] ?? '' ?>"
						<?php foreach ($dataAttributeKeys as $key) : ?>
							<?php echo $key ?>="<?php echo $button[$key] ?>"
						<?php endforeach; ?>
						<?php if ($button['onclick']) : ?>
						onclick="<?php echo $button['onclick'] ?>"
						<?php endif; ?>
						title="<?php echo Text::_($button['label']) ?>"
						id="<?php echo $button['id'] ?>"
						>
					<?php if (!empty($button['icon'])) : ?>
						<span class="<?php echo $button['icon'] ?>"></span>
					<?php elseif (!empty($button['image'])) : ?>
						<?php echo $button['image']; ?>
					<?php elseif (!empty($button['svg'])) : ?>
						<?php echo $button['svg']; ?>
					<?php endif; ?>
					<?php echo Text::_($button['label']) ?>
				</button>
			</div>
		<?php endforeach; 
	} ?>
	<div id="form-login-submit" class="form-group">
		<button type="submit" tabindex="0" name="Submit" class="btn btn-primary w-100"><?php echo Text::_('JLOGIN') ?></button>
		<?php $usersConfig = ComponentHelper::getParams('com_users');
			if ($usersConfig->get('allowUserRegistration')) : ?>
			<a style="margin:10px 0;" class="btn sppb-btn-default w-100" href="<?php echo Route::_($registerLink); ?>"><i style="margin-left:-5px;margin-right:9px;opacity:0.6;" class="fa fa-user-plus"></i><?php echo Text::_('MOD_LOGIN_REGISTER'); ?></a>
		<?php endif; ?>
	</div>

	<ul class="form-links">
		<li>
			<a style="padding-left:5px;font-size:90%;" href="<?php echo Route::_('index.php?option=com_users&view=remind'); ?>">
			<?php echo Text::_('MOD_LOGIN_FORGOT_YOUR_USERNAME'); ?></a>
		</li>
		<li>
			<a style="padding-left:5px;font-size:90%;" href="<?php echo Route::_('index.php?option=com_users&view=reset'); ?>">
			<?php echo Text::_('MOD_LOGIN_FORGOT_YOUR_PASSWORD'); ?></a>
		</li>
	</ul>
	
		<input type="hidden" name="option" value="com_users">
		<input type="hidden" name="task" value="user.login">
		<input type="hidden" name="return" value="<?php echo $return; ?>">
		<?php echo HTMLHelper::_('form.token'); ?>

	<?php if ($params->get('posttext')) : ?>
		<div class="posttext form-group my-2">
			<p><?php echo $params->get('posttext'); ?></p>
		</div>
	<?php endif; ?>
</form>
