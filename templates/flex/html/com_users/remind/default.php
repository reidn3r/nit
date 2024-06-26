<?php
/**
 * Flex @package Helix3 Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('behavior.formvalidator');
?>
<div class="row remind-wrapper">
	<!--<i class="pe pe-7s-mail-open-file d-none d-sm-block"></i>-->
	<i style="left:8vw;font-size:13vw;" class="pe pe-7s-mail-open-file d-none d-lg-block pt-5"></i>
 	  <div class="col-10 offset-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 py-5">
	   <!--<div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-4 offset-lg-4">-->
		<div class="remind<?php echo $this->pageclass_sfx?>">
			<!--<?php if ($this->params->get('show_page_heading')) : ?>
				<h1>
					<?php echo $this->escape($this->params->get('page_heading')); ?>
				</h1>
			<?php endif; ?>-->
			<form id="user-registration" action="<?php echo Route::_('index.php?option=com_users&task=remind.remind'); ?>" method="post" class="com-users-remind__form form-validate form-horizontal well">
				<?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
				<p><?php echo Text::_($fieldset->label); ?></p>
				<?php foreach ($this->form->getFieldset($fieldset->name) as $name => $field) : ?>
					<div class="form-group">
						<?php echo $field->label; ?>
						<div class="group-control">
							<?php echo $field->input; ?>
						</div>
					</div>
				<?php endforeach; ?>
				<?php endforeach; ?>
				<div class="form-group">
					<button type="submit" class="btn btn-primary validate"><?php echo Text::_('JSUBMIT'); ?></button>
				</div>
				<?php echo HTMLHelper::_('form.token'); ?>
			</form>
		</div>
	</div>
</div>
