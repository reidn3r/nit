<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

$jversion = RSPageBuilderHelper::getJoomlaVersion();
?>

<div class="elements-wrapper hidden">
	<ul class="elements">
	<?php
	foreach ($this->elements as $element) {
		if (!empty($element['options']['title'])) {
			$title = RSPageBuilderHelper::escapeHtml($element['options']['title']);
		} else {
			$title = RSPageBuilderHelper::elementTypeToTitle($element['type']);
		}
	?>
	<li class="<?php echo $element['category']; ?> text-center">
		<a id="<?php echo $element['type']; ?>" href="javascript:void(0)">
			<img class="image-left <?php echo $element['type'];?>" src="<?php echo RSPageBuilderHelper::getElementIcon($element['type']); ?>" alt="<?php echo $title; ?>"/>
			<h3 class="element-title"><?php echo $title; ?></h3>
		</a>
		<div class="element-container">
			<div class="element">
				<img class="element-image <?php echo $element['type'];?> pull-left" src="<?php echo RSPageBuilderHelper::getElementIcon($element['type']); ?>" alt="<?php echo $title; ?>"/>
				<h3 class="element-title"><?php echo $title; ?></h3>
				<h4 class="element-type" data-type="<?php echo $element['type'];?>"><?php echo $title; ?></h4>
				<div class="element-actions">
					<a class="publish-element published" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_PUBLISH_ELEMENT'); ?>"><i class="fa fa-check-circle"></i></a>
					<a class="edit-element" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_EDIT_ELEMENT'); ?>"><i class="fa fa-pencil"></i></a>
					<a class="view-element-html" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_VIEW_ELEMENT_HTML'); ?>"><i class="fa fa-file-code-o"></i></a>
					<a class="duplicate-element" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_DUPLICATE_ELEMENT'); ?>"><i class="fa fa-copy-o"></i></a>
					<a class="remove-element" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_REMOVE_ELEMENT'); ?>"><i class="fa fa-times"></i></a>
				</div>
				<div class="element-options hidden">
				</div>
				<input class="element-json" type="hidden" value="<?php echo $this->escape(json_encode($element)); ?>">
			</div>
		</div>
	</li>
	<?php
	}
	foreach ($this->my_elements as $element) {
		if (!empty($element['options']['title'])) {
			$title = RSPageBuilderHelper::escapeHtml($element['options']['title']);
		} else if (!empty($element['options']['text'])) {
			$title = RSPageBuilderHelper::escapeHtml($element['options']['text']);
		} else {
			$title = RSPageBuilderHelper::elementTypeToTitle($element['type']);
		}
		$subtitle = RSPageBuilderHelper::elementTypeToTitle($element['type']);
	?>
	<li class="<?php echo $element['category']; ?> text-center hidden">
		<a id="<?php echo $element['type']; ?>" href="javascript:void(0)">
			<img class="image-left <?php echo $element['type'];?>" src="<?php echo RSPageBuilderHelper::getElementIcon($element['type']); ?>" alt="<?php echo $title; ?>"/>
			<h3 class="element-title"><?php echo $title; ?></h3>
			<?php if ($title != $subtitle) { ?>
				<h4 class="element-subtitle">(<?php echo $subtitle; ?>)</h4>
			<?php } ?>
		</a>
		<div class="element-container">
			<div class="element">
				<img class="element-image <?php echo $element['type'];?> pull-left" src="<?php echo RSPageBuilderHelper::getElementIcon($element['type']); ?>" alt="<?php echo $title; ?>"/>
				<h3 class="element-title"><?php echo $title; ?></h3>
				<h4 class="element-type" data-type="<?php echo $element['type'];?>"><?php echo $subtitle; ?></h4>
				<div class="element-actions">
					<a class="publish-element<?php echo (!isset($element['options']['publish']) || (isset($element['options']['publish']) && $element['options']['publish'] == '1')) ? ' published' : ' unpublished'; ?>" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_PUBLISH_ELEMENT'); ?>"><i class="fa <?php echo (!isset($element['options']['publish']) || (isset($element['options']['publish']) && $element['options']['publish'] == '1')) ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i></a>
					<a class="edit-element" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_EDIT_ELEMENT'); ?>"><i class="fa fa-pencil"></i></a>
					<a class="view-element-html" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_VIEW_ELEMENT_HTML'); ?>"><i class="fa fa-file-code-o"></i></a>
					<a class="duplicate-element" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_DUPLICATE_ELEMENT'); ?>"><i class="fa fa-copy-o"></i></a>
					<a class="remove-element" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_REMOVE_ELEMENT'); ?>"><i class="fa fa-times"></i></a>
				</div>
				<div class="element-options hidden">
				</div>
				<input class="element-json" type="hidden" value="<?php echo $this->escape(json_encode($element)); ?>">
			</div>
		</div>
	</li>
	<?php } ?>
	</ul>
</div>