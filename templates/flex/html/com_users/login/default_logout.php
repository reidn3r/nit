<?php
/**
 * Flex @package Helix Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
?>
<div class="row login-wrapper jviewport-height60">
	<!--<div class="col-sm-4 col-sm-offset-4"> style="top:25vh;left:3vw;font-size:15vw;"  -->
	<i style="left:5vw;font-size:15vw;" class="pe pe-7s-unlock d-none d-lg-block"></i>
	<div class="col-8 offset-2 col-lg-4 offset-lg-4 pt-5">
		<div class="pt-5 logout<?php echo $this->pageclass_sfx?>">
			<?php if ($this->params->get('show_page_heading')) : ?>
				<h2>
					<?php echo $this->escape($this->params->get('page_heading')); ?>
				</h2>
                <hr />
			<?php endif; ?>

			<?php if (($this->params->get('logoutdescription_show') == 1 && str_replace(' ', '', $this->params->get('logout_description')) != '')|| $this->params->get('logout_image') != '') : ?>
			<div class="logout-description">
			<?php endif; ?>
				<?php if ($this->params->get('logoutdescription_show') == 1) : ?>
					<p><?php echo $this->params->get('logout_description'); ?></p>
				<?php endif; ?>
			<?php if ($this->params->get('logout_image') != '') : ?>
				<?php echo LayoutHelper::render('joomla.html.image', ['src' => $this->params->get('logout_image'), 'class' => 'com-users-logout__image thumbnail float-end logout-image', 'alt' => empty($this->params->get('logout_image_alt')) && empty($this->params->get('logout_image_alt_empty')) ? false : $this->params->get('logout_image_alt')]); ?>
			<?php endif; ?>

			<?php if (($this->params->get('logoutdescription_show') == 1 && str_replace(' ', '', $this->params->get('logout_description')) != '')|| $this->params->get('logout_image') != '') : ?></div>
			<?php endif; ?>

			<form action="<?php echo Route::_('index.php?option=com_users&task=user.logout'); ?>" method="post" class="com-users-logout__form form-horizontal well">
				<div class="form-group">
					<button type="submit" class="btn btn-primary"><i style="margin-left:-3px;margin-right:9px;" class="fas fa-unlock-alt"></i><?php echo Text::_('JLOGOUT'); ?></button>
				</div>
				<?php if ($this->params->get('logout_redirect_url')) : ?>
					<input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('logout_redirect_url', $this->form->getValue('return'))); ?>" />
				<?php else : ?>
					<input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('logout_redirect_menuitem', $this->form->getValue('return'))); ?>" />
				<?php endif; ?>
				<?php echo HTMLHelper::_('form.token'); ?>
			</form>
		</div>
	</div>
</div>
