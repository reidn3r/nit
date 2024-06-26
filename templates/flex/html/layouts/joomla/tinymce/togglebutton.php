<?php
/**
 * Flex @package Helix3 Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

?>
<!--
<div class="toggle-editor btn-toolbar pull-right clearfix">
	<a class="btn sppb-btn-default" href="#"
		onclick="tinyMCE.execCommand('mceToggleEditor', false, '<?php echo $name; ?>');return false;"
		title="<?php echo JText::_('PLG_TINY_BUTTON_TOGGLE_EDITOR'); ?>"
	>
		<i class="fas fa-eye"></i> <?php echo JText::_('PLG_TINY_BUTTON_TOGGLE_EDITOR'); ?>
	</a>
</div>
-->
<div class="toggle-editor btn-toolbar float-end clearfix mt-3">
	<div class="btn-group">
		<button type="button" disabled class="btn sppb-btn-default js-tiny-toggler-button">
			<i class="fas fa-eye" aria-hidden="true"></i> <?php echo Text::_('PLG_TINY_BUTTON_TOGGLE_EDITOR'); ?>
		</button>
	</div>
</div>