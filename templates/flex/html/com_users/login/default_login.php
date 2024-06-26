<?php
/**
 * Flex @package Helix3 Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Router\Route;

HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('behavior.formvalidator');

$usersConfig = ComponentHelper::getParams('com_users');
?>
<div class="row login-wrapper">
  <i class="pe pe-7s-key d-none d-lg-block"></i>
	<div class="col-sm-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
		<div class="container login<?php echo $this->pageclass_sfx?>">
			<?php if ($this->params->get('show_page_heading')) : ?>
				<h2 class="title mobile-centered">
					<svg style="margin:-7px 0 0;vertical-align:middle;" width="1.22em" height="1.22em" viewBox="0 0 16 16" class="bi bi-person major_color-lighten-20" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M13 14s1 0 1-1-1-4-6-4-6 3-6 4 1 1 1 1h10zm-9.995-.944v-.002.002zM3.022 13h9.956a.274.274 0 0 0 .014-.002l.008-.002c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664a1.05 1.05 0 0 0 .022.004zm9.974.056v-.002.002zM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/></svg>
					<?php echo $this->escape($this->params->get('page_heading')); ?>
				</h2>
			<?php endif; ?>
			<?php if (($this->params->get('logindescription_show') == 1 && str_replace(' ', '', $this->params->get('login_description')) != '') || $this->params->get('login_image') != '') : ?>
			<div class="com-users-login__description login-description">
			<?php endif; ?>
				<?php if ($this->params->get('logindescription_show') == 1) : ?>
					<?php echo $this->params->get('login_description'); ?>
				<?php endif; ?>
				<?php if ($this->params->get('login_image') != '') : ?>
					<?php echo LayoutHelper::render('joomla.html.image', ['src' => $this->params->get('login_image'), 'class' => 'com-users-login__image login-image', 'alt' => empty($this->params->get('login_image_alt')) && empty($this->params->get('login_image_alt_empty')) ? false : $this->params->get('login_image_alt')]); ?>
				<?php endif; ?>
			<?php if (($this->params->get('logindescription_show') == 1 && str_replace(' ', '', $this->params->get('login_description')) != '') || $this->params->get('login_image') != '') : ?>
			</div>
			<?php endif; ?>
			<form action="<?php echo Route::_('index.php?option=com_users&task=user.login'); ?>" method="post" class="com-users-login__form form-validate form-horizontal" id="com-users-login__form">
				<?php /* Set placeholder for username, password and secretekey (J3) */
					$this->form->setFieldAttribute( 'username', 'hint', Text::_('COM_USERS_LOGIN_USERNAME_LABEL') );
					$this->form->setFieldAttribute( 'password', 'hint', Text::_('JGLOBAL_PASSWORD') );
					if (JVERSION < 4) {
						$this->form->setFieldAttribute( 'secretkey', 'hint', Text::_('JGLOBAL_SECRETKEY') );
					}
				?>
				<fieldset>
					 <div class="fieldset_name"> 
						 <?php echo $this->form->renderFieldset('credentials', ['class' => 'com-users-login__input']); ?>
						 <?php //echo $this->form->renderFieldset('credentials'); ?>
                    </div>
				<?php if (JVERSION < 4) {
					if ($this->tfa) : 
						echo $this->form->renderField('secretkey', null, null, ['class' => 'com-users-login__secretkey']); 
					endif; 
				} ?>
				<?php if (PluginHelper::isEnabled('system', 'remember')) : ?>
					<div class="checkbox">
						<input id="remember" type="checkbox" name="remember" class="inputbox" value="yes" />
						<label for="remember"><?php echo Text::_('COM_USERS_LOGIN_REMEMBER_ME') ?></label>
					</div>
				<?php endif; ?>
					
				<?php if (JVERSION < 4) {
					// Joomla 3...
				} else {
					// Joomla 4...
					foreach ($this->extraButtons as $button) :
					$dataAttributeKeys = array_filter(array_keys($button), function ($key) {
						return substr($key, 0, 5) == 'data-';
					});
					?>
					<div class="com-users-login__submit control-group mt-4 mb-0 mb-sm-3">
						<div class="controls">
							<button type="button"
									class="btn btn-secondary sppb-btn-3d btn-xs-block web-auth-btn py-1 w-100 <?php echo $button['class'] ?? '' ?>"
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
									<?php echo HTMLHelper::_('image', $button['image'], Text::_($button['tooltip'] ?? ''), [
										'class' => 'icon',
									], true) ?>
								<?php elseif (!empty($button['svg'])) : ?>
									<?php echo $button['svg']; ?>
								<?php endif; ?>
								<?php echo Text::_($button['label']) ?>
							</button>
						</div>
					</div>
				<?php endforeach; 
				} ?>
					
				<div class="form-group">
					<button style="margin:10px 0;" type="submit" class="btn btn-primary sppb-btn-3d d-block d-md-inline-block col-12 col-md-4 mt-3 mt-md-0 text-shadow">
						<?php echo Text::_('JLOGIN'); ?>
					</button>
					<div class="form-links mt-2 mt-sm-0 col-12 col-sm-7">	
						<?php echo Text::_('MOD_LOGIN_FORGOT'); ?> <a href="<?php echo Route::_('index.php?option=com_users&view=remind'); ?>">
						<?php echo Text::_('MOD_LOGIN_FORGOT_USERNAME'); ?></a> <?php echo Text::_('MOD_LOGIN_OR'); ?> <a href="<?php echo Route::_('index.php?option=com_users&view=reset'); ?>">
						<?php echo Text::_('MOD_LOGIN_FORGOT_PASSWORD'); ?></a> <?php echo Text::_('FLEX_QUESTION_MARK'); ?>
					</div>
				</div>  
                <?php $return = $this->form->getValue('return', '', $this->params->get('login_redirect_url', $this->params->get('login_redirect_menuitem'))); ?>
 				<input type="hidden" name="return" value="<?php echo base64_encode($return); ?>" />
				<?php echo HTMLHelper::_('form.token'); ?>	
				</fieldset>
			</form>
			<?php
			$usersConfig = JComponentHelper::getParams('com_users');
			if ($usersConfig->get('allowUserRegistration')) { ?>
			<div class="form-footer">
				<?php echo Text::_('MOD_NEW_REGISTER'); ?>
				<a href="<?php echo Route::_('index.php?option=com_users&view=registration'); ?>">
					<?php echo Text::_('MOD_LOGIN_CREATE_ACCOUNT'); ?>
				</a>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
