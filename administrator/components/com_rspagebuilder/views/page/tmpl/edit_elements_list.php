<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');
?>

<div class="<?php echo RSPageBuilderHelper::getGridElement('row'); ?>">
	<div class="<?php echo RSPageBuilderHelper::getGridElement(3); ?>">
		<div class="elements-categories">
			<ul>
				<?php foreach($this->categories as $key => $element_category) { ?>
					<li <?php echo ($key == 0) ? 'class="active"' : ''; ?> data-category="<?php echo str_replace(' ', '_', strtolower($element_category)); ?>"><a href="javascript:void(0)"><?php echo ucwords(str_replace('_', ' ', $element_category)); ?></a></li>
				<?php } ?>
			</ul>
		</div>
		<input class="elements-filter" name="elements_filter" type="text" placeholder="<?php echo JText::_('COM_RSPAGEBUILDER_SEARCH_ELEMENT'); ?>">
	</div>
	<div class="<?php echo RSPageBuilderHelper::getGridElement(9); ?>">
		<div class="elements-list-wrapper"></div>
	</div>
</div>