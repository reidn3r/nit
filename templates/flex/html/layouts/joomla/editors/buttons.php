<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

$buttons = $displayData;

// behavior.modal is crashing site with 500 error in Joomla 4 
//JHtml::_('behavior.modal', 'a.modal-button');
?>
<div id="editor-xtd-buttons" class="row clearfix w-100" role="toolbar" aria-label="<?php echo Text::_('JTOOLBAR'); ?>">
	<div class="d-xl-flex justify-content-center w-100">
	<?php if ($buttons) : ?>
		<?php foreach ($buttons as $button) : ?>
			<?php //echo JLayoutHelper::render('joomla.editors.buttons.button', $button); ?>
			<?php echo $this->sublayout('button', $button); ?>
			<?php echo $this->sublayout('modal', $button); ?>
		<?php endforeach; ?>
	<?php endif; ?>
	</div>
</div>