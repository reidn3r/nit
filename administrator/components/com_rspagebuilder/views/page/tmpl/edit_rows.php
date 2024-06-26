<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

if ($this->item->language && $this->item->language != '*') {
	$language	= explode('-', $this->item->language);
	$languages	= '&lang='.$language[0];
}
?>

<div class="rspbld-builder-options">
	<div class="control-group">
		<a id="add-row" class="btn btn-primary" href="javascript:void(0)"><i class="fa fa-plus"></i> <?php echo JText::_('COM_RSPAGEBUILDER_ADD_ROW'); ?></a>
		<?php if(!empty($this->item->id)) { ?>
		<a id="view-page" class="btn btn-warning" href="<?php echo JUri::root() . 'index.php?option=com_rspagebuilder&view=page&id=' . $this->item->id . ((isset($languages)) ? $languages : ''); ?>" target="_blank"><i class="fa fa-share-square"></i><?php echo JText::_('COM_RSPAGEBUILDER_VIEW_PAGE'); ?></a>
		<?php } ?>
	</div>
</div>
<hr>
<?php if ($this->item->content) { ?>
<div id="rspbld" class="rspbld-wrapper<?php echo ($this->item->full_width) ? '': ' container'; ?>">
	<?php
		foreach (json_decode($this->item->content) as $key => $row) {
			$json_row = RSPageBuilderHelper::toArray($row);
			unset($json_row['columns']);
			
			$row_columns = count($row->columns);
	?>
	<div class="rspbld-container">
		<div class="row-controls">
			<ul class="row-grid-list">
				<li><a href="javascript:void(0)" class="row-grid-12 <?php echo (($row_columns == 1) ? 'active' : ''); ?>" data-grid="12" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::sprintf('COM_RSPAGEBUILDER_COLUMN_SIZE', '1'); ?>"></a></li>
				<li><a href="javascript:void(0)" class="row-grid-66 <?php echo (($row_columns == 2) ? 'active' : ''); ?>" data-grid="6,6" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::sprintf('COM_RSPAGEBUILDER_COLUMNS_SIZE', '2'); ?>"></a></li>
				<li><a href="javascript:void(0)" class="row-grid-444 <?php echo (($row_columns == 3) ? 'active' : ''); ?>" data-grid="4,4,4" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::sprintf('COM_RSPAGEBUILDER_COLUMNS_SIZE', '3'); ?>"></a></li>
				<li><a href="javascript:void(0)" class="row-grid-3333 <?php echo (($row_columns == 4) ? 'active' : ''); ?>" data-grid="3,3,3,3" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::sprintf('COM_RSPAGEBUILDER_COLUMNS_SIZE', '4'); ?>"></a></li>
				<li><a href="javascript:void(0)" class="row-grid-222222 <?php echo (($row_columns == 6) ? 'active' : ''); ?>" data-grid="2,2,2,2,2,2" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::sprintf('COM_RSPAGEBUILDER_COLUMNS_SIZE', '6'); ?>"></a></li>
			</ul>
		</div>
		<div class="row-actions">
			<a class="add-row" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_ADD_ROW'); ?>"><i class="fa fa-plus"></i></a>
			<a class="publish-row <?php echo (!isset($row->options->publish) || (isset($row->options->publish) && $row->options->publish == '1')) ? ' published' : ' unpublished'; ?>" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_PUBLISH_ROW'); ?>"><i class="fa <?php echo (!isset($row->options->publish) || (isset($row->options->publish) && $row->options->publish == '1')) ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i></a>
			<a class="configure-row" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_CONFIGURE_ROW'); ?>"><i class="fa fa-cog"></i></a>
			<a class="duplicate-row" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_DUPLICATE_ROW'); ?>"><i class="fa fa-copy-o"></i></a>
			<a class="delete-row" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_DELETE_ROW'); ?>"><i class="fa fa-times"></i></a>
		</div>
		<div class="row">
		<div class="columns<?php echo (($row->options->row_full_width == '0') ? ' container' : ''); ?>">
			<?php
				foreach ($row->columns as $key => $column) {
					$json_column = RSPageBuilderHelper::toArray($column);
					unset($json_column['elements']);
			?>
			<div class="column span<?php echo $column->grid; ?>">
				<div class="column-content">
				<?php
				foreach ($column->elements as $key => $element) {
					if (isset($element->options->title) && $element->options->title) {
						$title = RSPageBuilderHelper::escapeHtml($element->options->title);
					} else if (isset($element->options->text) && $element->options->text) {
						$title = RSPageBuilderHelper::escapeHtml($element->options->text);
					} else {
						$title = RSPageBuilderHelper::elementTypeToTitle($element->type);
					}
					$subtitle = RSPageBuilderHelper::elementTypeToTitle($element->type);
				?>
					<div class="element-container">
						<div class="element">
							<img class="element-image <?php echo $element->type; ?> pull-left" src="<?php echo RSPageBuilderHelper::getElementIcon($element->type); ?>" alt="<?php echo $element->type; ?>">
							<div class="element-details">
								<h3 class="element-title"><?php echo $title; ?></h3>
								<h4 class="element-type<?php echo (($title == $subtitle) ? ' hidden' : ''); ?>" data-type="<?php echo $element->type;?>"><?php echo $subtitle; ?></h4>
							</div>
							<div class="element-actions">
								<a class="publish-element<?php echo (!isset($element->options->publish) || (isset($element->options->publish) && $element->options->publish == '1')) ? ' published' : ' unpublished'; ?>" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_PUBLISH_ELEMENT'); ?>"><i class="fa <?php echo (!isset($element->options->publish) || (isset($element->options->publish) && $element->options->publish == '1')) ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i></a>
								<a class="edit-element" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_EDIT_ELEMENT'); ?>"><i class="fa fa-pencil"></i></a>
								<a class="view-element-html" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_VIEW_ELEMENT_HTML'); ?>"><i class="fa fa-file-code-o"></i></a>
								<a class="duplicate-element" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_DUPLICATE_ELEMENT'); ?>"><i class="fa fa-copy-o"></i></a>
								<a class="remove-element" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_REMOVE_ELEMENT'); ?>"><i class="fa fa-times"></i></a>
							</div>
							<div class="element-options hidden">
							</div>
							<input class="element-json" type="hidden" value="<?php echo $this->escape(json_encode(RSPageBuilderHelper::toArray($element))); ?>">
						</div>
					</div>
			<?php } ?>
						<div class="add-element-container">
							<a class="add-element" href="javascript:void(0)"><i class="fa fa-plus"></i></a>
						</div>
					</div>
					<span class="column-size">
						<sup><?php echo $column->grid; ?></sup>/<sub>12</sub>
					</span>
					<div class="column-actions">
						<a class="publish-column<?php echo (!isset($column->options->publish) || (isset($column->options->publish) && $column->options->publish == '1')) ? ' published' : ' unpublished'; ?>" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_PUBLISH_COLUMN'); ?>"><i class="fa <?php echo (!isset($column->options->publish) || (isset($column->options->publish) && $column->options->publish == '1')) ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i></a>
						<a class="configure-column" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_CONFIGURE_COLUMN'); ?>"><i class="fa fa-gears"></i></a>
					</div>
					<div class="column-options hidden">
					</div>
					<input class="column-json" type="hidden" value="<?php echo $this->escape(json_encode($json_column)); ?>">
				</div>
		<?php } ?>
			</div>
			<div class="row-options hidden">
			</div>
			<input class="row-json" type="hidden" value="<?php echo $this->escape(json_encode($json_row)); ?>">
		</div>
	</div>
	<?php } ?>
</div>
<?php } else { ?>
<div id="rspbld" class="rspbld-wrapper">
	<div class="rspbld-container">
		<div class="row-controls">
			<ul class="row-grid-list">
				<li><a href="javascript:void(0)" class="row-grid-12 active" data-grid="12" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::sprintf('COM_RSPAGEBUILDER_COLUMN_SIZE', '1'); ?>"></a></li>
				<li><a href="javascript:void(0)" class="row-grid-66" data-grid="6,6" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::sprintf('COM_RSPAGEBUILDER_COLUMNS_SIZE', '2'); ?>"></a></li>
				<li><a href="javascript:void(0)" class="row-grid-444" data-grid="4,4,4" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::sprintf('COM_RSPAGEBUILDER_COLUMNS_SIZE', '3'); ?>"></a></li>
				<li><a href="javascript:void(0)" class="row-grid-3333" data-grid="3,3,3,3" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::sprintf('COM_RSPAGEBUILDER_COLUMNS_SIZE', '4'); ?>"></a></li>
				<li><a href="javascript:void(0)" class="row-grid-222222" data-grid="2,2,2,2,2,2" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::sprintf('COM_RSPAGEBUILDER_COLUMNS_SIZE', '6'); ?>"></a></li>
			</ul>
		</div>
		<div class="row-actions">
			<a class="add-row" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_ADD_ROW'); ?>"><i class="fa fa-plus"></i></a>
			<a class="publish-row published" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_PUBLISH_ROW'); ?>"><i class="fa fa-check-circle"></i></a>
			<a class="configure-row" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_CONFIGURE_ROW'); ?>"><i class="fa fa-cog"></i></a>
			<a class="duplicate-row" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_DUPLICATE_ROW'); ?>"><i class="fa fa-copy-o"></i></a>
			<a class="delete-row" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_DELETE_ROW'); ?>"><i class="fa fa-times"></i></a>
		</div>
		<div class="row">
			<div class="columns">
				<div class="column span12">
					<div class="column-content">
						<div class="add-element-container">
							<a class="add-element" href="javascript:void(0)"><i class="fa fa-plus"></i></a>
						</div>
					</div>
					<span class="column-size">
						<sup>12</sup>/<sub>12</sub>
					</span>
					<div class="column-actions">
						<a class="publish-column published" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_PUBLISH_COLUMN'); ?>"><i class="fa fa-check-circle"></i></a>
						<a class="configure-column" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_CONFIGURE_COLUMN'); ?>"><i class="fa fa-gears"></i></a>
					</div>
					<div class="column-options hidden">
					</div>
					<input class="column-json" type="hidden" value="<?php echo $this->escape(json_encode($this->column_config)); ?>">
				</div>
			</div>
			<div class="row-options hidden">
			</div>
			<input class="row-json" type="hidden" value="<?php echo $this->escape(json_encode($this->row_config)); ?>">
		</div>
	</div>
</div>
<?php } ?>
<div class="rspbld-container hidden">
	<div class="row-controls">
		<ul class="row-grid-list">
			<li><a href="javascript:void(0)" class="row-grid-12 active" data-grid="12" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::sprintf('COM_RSPAGEBUILDER_COLUMN_SIZE', '1'); ?>"></a></li>
			<li><a href="javascript:void(0)" class="row-grid-66" data-grid="6,6" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::sprintf('COM_RSPAGEBUILDER_COLUMNS_SIZE', '2'); ?>"></a></li>
			<li><a href="javascript:void(0)" class="row-grid-444" data-grid="4,4,4" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::sprintf('COM_RSPAGEBUILDER_COLUMNS_SIZE', '3'); ?>"></a></li>
			<li><a href="javascript:void(0)" class="row-grid-3333" data-grid="3,3,3,3" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::sprintf('COM_RSPAGEBUILDER_COLUMNS_SIZE', '4'); ?>"></a></li>
			<li><a href="javascript:void(0)" class="row-grid-222222" data-grid="2,2,2,2,2,2" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::sprintf('COM_RSPAGEBUILDER_COLUMNS_SIZE', '6'); ?>"></a></li>
		</ul>
	</div>
	<div class="row-actions">
		<a class="add-row" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_ADD_ROW'); ?>"><i class="fa fa-plus"></i></a>
		<a class="publish-row published" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_PUBLISH_ROW'); ?>"><i class="fa fa-check-circle"></i></a>
		<a class="configure-row" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_CONFIGURE_ROW'); ?>"><i class="fa fa-cog"></i></a>
		<a class="duplicate-row" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_DUPLICATE_ROW'); ?>"><i class="fa fa-copy-o"></i></a>
		<a class="delete-row" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_DELETE_ROW'); ?>"><i class="fa fa-times"></i></a>
	</div>
	<div class="row">
		<div class="columns">
			<div class="column span12">
				<div class="column-content">
					<div class="add-element-container">
						<a class="add-element" href="javascript:void(0)"><i class="fa fa-plus"></i></a>
					</div>
				</div>
				<span class="column-size">
					<sup>12</sup>/<sub>12</sub>
				</span>
				<div class="column-actions">
					<a class="publish-column published" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_PUBLISH_COLUMN'); ?>"><i class="fa fa-check-circle"></i></a>
					<a class="configure-column" href="javascript:void(0)" <?php echo RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle'); ?>="tooltip" title="<?php echo JText::_('COM_RSPAGEBUILDER_CONFIGURE_COLUMN'); ?>"><i class="fa fa-gears"></i></a>
				</div>
				<div class="column-options hidden">
				</div>
				<input class="column-json" type="hidden" value="<?php echo $this->escape(json_encode($this->column_config)); ?>">
			</div>
		</div>
		<div class="row-options hidden">
		</div>
		<input class="row-json" type="hidden" value="<?php echo $this->escape(json_encode($this->row_config)); ?>">
	</div>
</div>