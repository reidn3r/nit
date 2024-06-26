<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

/**
 * Page controller.
 */
class RSPageBuilderControllerPage extends JControllerForm
{
	public function renderRow() {
		$app				= JFactory::getApplication();
		$html				= '';
		$row				= $app->input->getArray();
		$form				= JForm::getInstance(RSPageBuilderHelper::createId('rspbld_row', RSPageBuilderHelper::randomNumber()), JPATH_COMPONENT_ADMINISTRATOR.'/models/forms/row.xml');
		$jversion			= RSPageBuilderHelper::getJoomlaVersion();
		$row_general_fields	= $form->getFieldset('general');
		$row_options_fields	= $form->getFieldset('options');
		$basic_haystack		= array(
			'background_attachment',
			'background_image',
			'background_overlay_opacity',
			'background_position',
			'background_repeat',
			'class',
			'grid',
			'heading_alignment',
			'id',
			'publish',
			'subtitle',
			'title',
			'type'
		);
		$size_fields		= array();
		$size_haystack		= array(
			'background_size',
			'row_full_width',
			'subtitle_font_size',
			'subtitle_font_weight',
			'subtitle_heading',
			'title_font_size',
			'title_font_weight',
			'title_heading'
		);
		$spacing_haystack	= array(
			'margin',
			'padding',
			'subtitle_margin',
			'subtitle_padding',
			'title_margin',
			'title_padding'
		);
		$color_fields		= array();
		$color_haystack		= array(
			'background_color',
			'background_overlay_color',
			'subtitle_text_color',
			'text_color',
			'title_text_color'
		);
		
		// Render row basic options
		if (!empty($row_general_fields)) {
			foreach ($row_general_fields as $field) {
				$form->setFieldAttribute($field->name, 'default', $row[$field->name]);
				
				if (in_array($field->name, $basic_haystack)) {
					$basic_fields[] = $field->name;
				}
			}
		}
		
		// Render row options
		if (!empty($row_options_fields)) {
			foreach ($row_options_fields as $field) {
				if (!empty($row['options']) && isset($row['options'][$field->name])) {
					$form->setFieldAttribute($field->name, 'default', $row['options'][$field->name]);
				}
				if (in_array($field->name, $basic_haystack)) {
					$basic_fields[] = $field->name;
				}
				if (in_array($field->name, $size_haystack)) {
					$size_fields[] = $field->name;
				}
				if (in_array($field->name, $color_haystack)) {
					$color_fields[] = $field->name;
				}
				if (in_array($field->name, $spacing_haystack)) {
					$spacing_fields[] = $field->name;
				}
			}
			
			// Build row options tab
			if ($jversion >= 4) {
				$ul_class			= 'joomla-tabs nav nav-tabs';
				$li_class			= 'nav-item';
				$a_class			= 'nav-link';
				$li_active_class	= 'nav-item';
				$a_active_class		= 'nav-link active';
			} else {
				$ul_class			= 'nav nav-tabs';
				$li_class			= '';
				$a_class			= '';
				$li_active_class	= 'active';
				$a_active_class		= '';
			}
			
			$html .= '<div class="options-tab tab">';
			$html .= '<ul class="' . $ul_class . '" id="row-options-tab">';
			if (!empty($basic_fields)) {
				$html .= '<li class="' . $li_active_class . '"><a class="' . $a_active_class . '" href="#basics" '.RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle').'="tab">'.JText::_('COM_RSPAGEBUILDER_BASICS').'</a></li>';
			}
			if (!empty($size_fields)) {
				$html .= '<li class="' . $li_class . '"><a class="' . $a_class . '" href="#sizes" '.RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle').'="tab">'.JText::_('COM_RSPAGEBUILDER_SIZES').'</a></li>';
			}
			if (!empty($color_fields)) {
				$html .= '<li class="' . $li_class . '"><a class="' . $a_class . '" href="#colors" '.RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle').'="tab">'.JText::_('COM_RSPAGEBUILDER_COLORS').'</a></li>';
			}
			if (!empty($spacing_fields)) {
				$html .= '<li class="' . $li_class . '"><a class="' . $a_class . '" href="#spacing" '.RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle').'="tab">'.JText::_('COM_RSPAGEBUILDER_SPACING').'</a></li>';
			}
			$html .= '</ul>';
			$html .= '<div class="tab-content">';
			
			// Basics tab
			if (!empty($basic_fields)) {
				$html .= '<div class="tab-pane active" id="basics">';
				$html .= RSPageBuilderHelper::renderFormFields($form, $basic_fields, 'row');
				$html .= '</div>';
			}
			
			// Sizes tab
			if (!empty($size_fields)) {
				$html .= '<div class="tab-pane" id="sizes">';
				$html .= RSPageBuilderHelper::renderFormFields($form, $size_fields, 'row');
				$html .= '</div>';
			}
			
			// Colors tab
			if (!empty($color_fields)) {
				$html .= '<div class="tab-pane" id="colors">';
				$html .= RSPageBuilderHelper::renderFormFields($form, $color_fields, 'row');
				$html .= '</div>';
			}
			
			// Spacing tab
			if (!empty($spacing_fields)) {
				$html .= '<div class="tab-pane" id="spacing">';
				$html .= RSPageBuilderHelper::renderFormFields($form, $spacing_fields, 'row');
				$html .= '</div>';
			}
			$html .= '</div>';
			$html .= '</div>';
		}
		$form->reset(true);
		
		echo $html;
		
		Jexit();
	}
	
	public function renderColumn() {
		$app					= JFactory::getApplication();
		$html					= '';
		$column					= $app->input->getArray();
		$form					= JForm::getInstance(RSPageBuilderHelper::createId('rspbld_column', RSPageBuilderHelper::randomNumber()), JPATH_COMPONENT_ADMINISTRATOR.'/models/forms/column.xml');
		$jversion				= RSPageBuilderHelper::getJoomlaVersion();
		$column_general_fields	= $form->getFieldset('general');
		$column_options_fields	= $form->getFieldset('options');
		$basic_fields			= array();
		$basic_haystack			= array(
			'animation_delay',
			'animation_duration',
			'animation_type',
			'class',
			'grid',
			'heading_alignment',
			'id',
			'publish',
			'subtitle',
			'title',
			'type'
		);
		$size_fields			= array();
		$size_haystack			= array(
			'subtitle_font_size',
			'subtitle_font_weight',
			'subtitle_heading',
			'title_font_size',
			'title_font_weight',
			'title_heading'
		);
		$spacing_haystack		= array(
			'margin',
			'padding',
			'subtitle_margin',
			'subtitle_padding',
			'title_margin',
			'title_padding'
		);
		$color_fields			= array();
		$color_haystack			= array(
			'background_color',
			'subtitle_text_color',
			'text_color',
			'title_text_color'
		);
		
		// Render column basic options
		if (!empty($column_general_fields)) {
			foreach ($column_general_fields as $field) {
				$form->setFieldAttribute($field->name, 'default', $column[$field->name]);
				
				if (in_array($field->name, $basic_haystack)) {
					$basic_fields[] = $field->name;
				}
			}
		}
		
		// Render column options
		if (!empty($column_options_fields)) {
			foreach ($column_options_fields as $field) {
				if (!empty($column['options']) && isset($column['options'][$field->name])) {
					$form->setFieldAttribute($field->name, 'default', $column['options'][$field->name]);
				}
				if (in_array($field->name, $basic_haystack)) {
					$basic_fields[] = $field->name;
				}
				if (in_array($field->name, $size_haystack)) {
					$size_fields[] = $field->name;
				}
				if (in_array($field->name, $color_haystack)) {
					$color_fields[] = $field->name;
				}
				if (in_array($field->name, $spacing_haystack)) {
					$spacing_fields[] = $field->name;
				}
			}
			
			// Build column options tab
			if ($jversion >= 4) {
				$ul_class			= 'joomla-tabs nav nav-tabs';
				$li_class			= 'nav-item';
				$a_class			= 'nav-link';
				$li_active_class	= 'nav-item';
				$a_active_class		= 'nav-link active';
			} else {
				$ul_class			= 'nav nav-tabs';
				$li_class			= '';
				$a_class			= '';
				$li_active_class	= 'active';
				$a_active_class		= '';
			}
			
			$html .= '<div class="options-tab tab">';
			$html .= '<ul class="' . $ul_class . '" id="column-options-tab">';
			if (!empty($basic_fields)) {
				$html .= '<li class="' . $li_active_class . '"><a class="' . $a_active_class . '" href="#basics" '.RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle').'="tab">'.JText::_('COM_RSPAGEBUILDER_BASICS').'</a></li>';
			}
			if (!empty($size_fields)) {
				$html .= '<li class="' . $li_class . '"><a class="' . $a_class . '" href="#sizes" '.RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle').'="tab">'.JText::_('COM_RSPAGEBUILDER_SIZES').'</a></li>';
			}
			if (!empty($color_fields)) {
				$html .= '<li class="' . $li_class . '"><a class="' . $a_class . '" href="#colors" '.RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle').'="tab">'.JText::_('COM_RSPAGEBUILDER_COLORS').'</a></li>';
			}
			if (!empty($spacing_fields)) {
				$html .= '<li class="' . $li_class . '"><a class="' . $a_class . '" href="#spacing" '.RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle').'="tab">'.JText::_('COM_RSPAGEBUILDER_SPACING').'</a></li>';
			}
			$html .= '</ul>';
			$html .= '<div class="tab-content">';
			
			// Basics tab
			if (!empty($basic_fields)) {
				$html .= '<div class="tab-pane active" id="basics">';
				$html .= RSPageBuilderHelper::renderFormFields($form, $basic_fields, 'column');
				$html .= '</div>';
			}
			
			// Sizes tab
			if (!empty($size_fields)) {
				$html .= '<div class="tab-pane" id="sizes">';
				$html .= RSPageBuilderHelper::renderFormFields($form, $size_fields, 'column');
				$html .= '</div>';
			}
			
			// Colors tab
			if (!empty($color_fields)) {
				$html .= '<div class="tab-pane" id="colors">';
				$html .= RSPageBuilderHelper::renderFormFields($form, $color_fields, 'column');
				$html .= '</div>';
			}
			
			// Spacing tab
			if (!empty($spacing_fields)) {
				$html .= '<div class="tab-pane" id="spacing">';
				$html .= RSPageBuilderHelper::renderFormFields($form, $spacing_fields, 'column');
				$html .= '</div>';
			}
			$html .= '</div>';
			$html .= '</div>';
		}
		$form->reset(true);
		
		echo $html;
		
		Jexit();
	}
	
	public function renderElement() {
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');
		
		include_once (JPATH_COMPONENT_ADMINISTRATOR.'/helpers/config.php');
		
		RSPageBuilderConfig::getElements();
		$app					= JFactory::getApplication();
		$jversion				= RSPageBuilderHelper::getJoomlaVersion();
		$html					= '';
		$items_html				= '';
		$element				= $app->input->getArray(array(), null, 'RAW');
		$form					= RSPageBuilderConfig::$forms[$element['type']];
		$fieldsets				= $form->getFieldsets();
		$element_general_fields	= $form->getFieldset('general');
		$element_options_fields	= $form->getFieldset('options');
		$first_item				= $form->getFieldset('item-1');
		$default_items			= 0;
		$basic_fields			= array();
		$basic_haystack			= array(
			'animate',
			'alert_type',
			'alignment',
			'alt_text',
			'animation_delay',
			'animation_duration',
			'background_image',
			'background_position',
			'background_repeat',
			'border_side',
			'border_style',
			'box_alignment',
			'box_background_attachment',
			'box_background_image',
			'box_background_position',
			'box_background_repeat',
			'button_icon',
			'button_target',
			'button_text',
			'button_type',
			'button_url',
			'category',
			'caption',
			'class',
			'client_avatar',
			'client_avatar_position',
			'client_avatar_target',
			'client_avatar_url',
			'client_details',
			'client_name',
			'close',
			'columns_number',
			'content',
			'content_border_style',
			'divider_type',
			'equal_columns',
			'format',
			'gutter',
			'hidden_desktop',
			'hidden_tablet',
			'hidden_phone',
			'icon',
			'icon_position',
			'image',
			'image_alt_text',
			'image_position',
			'indicators_position',
			'inline',
			'items_per_slide',
			'layout',
			'limit',
			'map_latitude',
			'map_longitude',
			'map_zoom',
			'map_theme',
			'map_scrollwheel',
			'map_draggable',
			'map_zoomcontrol',
			'map_streetviewcontrol',
			'map_maptypecontrol',
			'module',
			'number_position',
			'one_item',
			'orientation',
			'price',
			'price_after',
			'price_before',
			'publish',
			'separator',
			'show_controls',
			'show_indicators',
			'slide_effect',
			'slide_interval',
			'slide_swipe',
			'social_facebook',
			'social_twitter',
			'social_instagram',
			'social_linkedin',
			'social_youtube',
			'social_tumblr',
			'social_vimeo',
			'social_flickr',
			'social_pinterest',
			'social_icons_position',
			'social_icons_target',
			'subtitle',
			'subtitle_show',
			'type',
			'tag',
			'target',
			'text',
			'title',
			'title_show',
			'url',
			'video_auto_play',
			'video_loop',
			'video_quality',
			'video_show_controls',
			'video_show_info',
			'video_show_suggestions',
			'video_start_at',
			'video_stop_at',
			'video_url',
			'video_volume',
			'grid'
		);
		$size_fields			= array();
		$size_haystack			= array(
			'background_size',
			'border_radius',
			'border_width',
			'box_background_size',
			'box_height',
			'box_width',
			'button_full_width',
			'button_size',
			'client_avatar_height',
			'client_avatar_width',
			'content_border_radius',
			'content_border_width',
			'controls_font_size',
			'controls_size',
			'countdown_font_size',
			'countdown_font_weight',
			'details_font_size',
			'details_font_weight',
			'font_size',
			'font_weight',
			'height',
			'icon_font_size',
			'image_height',
			'image_width',
			'indicators_size',
			'min_size',
			'number_font_weight',
			'number_font_size',
			'price_font_size',
			'price_font_weight',
			'social_icons_font_size',
			'subtitle_font_size',
			'subtitle_font_weight',
			'subtitle_heading',
			'text_font_size',
			'text_font_weight',
			'title_font_size',
			'title_font_weight',
			'title_heading',
			'video_full_width',
			'width',
			'tag_font_size',
			'tag_font_weight',
			'vertical_height'
		);
		$spacing_fields			= array();
		$spacing_haystack		= array(
			'box_margin',
			'box_padding',
			'client_avatar_margin',
			'client_avatar_padding',
			'content_margin',
			'content_padding',
			'icon_margin',
			'icon_padding',
			'image_margin',
			'image_padding',
			'margin',
			'number_margin',
			'number_padding',
			'padding',
			'price_margin',
			'price_padding',
			'social_icons_margin',
			'social_icons_padding',
			'subtitle_margin',
			'subtitle_padding',
			'title_margin',
			'title_padding',
			'tags_margin',
			'tags_padding',
			'tag_margin',
			'tag_padding'
		);
		$color_fields			= array();
		$color_haystack			= array(
			'background_color',
			'border_color',
			'box_background_color',
			'color',
			'content_background_color',
			'content_border_color',
			'content_text_color',
			'controls_color',
			'countdown_text_color',
			'details_text_color',
			'icon_background_color',
			'icon_color',
			'indicators_color',
			'map_color',
			'map_brightness',
			'map_saturation',
			'number_text_color',
			'number_background_color',
			'price_text_color',
			'social_icons_color',
			'social_icons_background_color',
			'subtitle_text_color',
			'text_color',
			'title_text_color',
			'tag_text_color',
			'tag_background_color'
		);
		
		if (!empty($element['items'])) {
			
			// Count default items
			foreach ($fieldsets as $fieldset) {
				if (preg_match('/item-/', $fieldset->name)) {
					$default_items++;
				}
			}
			if (count($element['items']) - $default_items > 0) {
				
				$element_xml = simplexml_load_file(JPATH_COMPONENT_ADMINISTRATOR . '/models/forms/elements/' . preg_replace('/^rspbld_/', '' , $element['type']) . '.xml');
				
				for ($i = 1; $i <= count($element['items']) - $default_items; $i++) {
					$item_index	= $i + $default_items;
					$xml		= '<fieldset name="item-'.$item_index.'">';
					
					foreach ($element_xml->fieldset[2] as $field) {
						$field_name			= (string) $field->attributes()->name;
						$field_name_explode = explode('-', $field_name);
						
						if (($form->getFieldAttribute($field_name, 'type') == 'list') || ($form->getFieldAttribute($field_name, 'type') == 'radio')) {
							$xml .= '<field name="'.$field_name_explode[0].'-'.$item_index.'" type="'.$form->getFieldAttribute($field_name, 'type').'" default="'.$form->getFieldAttribute($field_name, 'default').'" class="'.$form->getFieldAttribute($field_name, 'class').'" label="'.$form->getFieldAttribute($field_name, 'label').'" description="'.$form->getFieldAttribute($field_name, 'description').'">';
							
							foreach ($field->option as $option) {
								$xml .= '<option value="' . (string) $option->attributes()->value . '">' . (string) $option . '</option>';
							}
							
							$xml .= '</field>';
						} else {
							$xml .= '<field name="'.$field_name_explode[0].'-'.$item_index.'" type="'.$form->getFieldAttribute($field_name, 'type').'" default="'.$form->getFieldAttribute($field_name, 'default').'" class="'.$form->getFieldAttribute($field_name, 'class').'" label="'.$form->getFieldAttribute($field_name, 'label').'" description="'.$form->getFieldAttribute($field_name, 'description').'"/>';
						}
					}
					
					$xml .= '</fieldset>';
					
					// Add saved items to form
					$form->setField(new SimpleXMLElement($xml));
				}
			} else {
				for ($i = 0; $i < $default_items - count($element['items']); $i++) {
					$item_index	= $default_items - $i;
					
					$item_fields = $form->getFieldset('item-'.$item_index);
					
					// Remove extra items from form
					foreach ($item_fields as $field) {
						$form->removeField($field->name);
					}
				}
			}
		}
		
		// Render element basic options
		if (!empty($element_general_fields)) {
			foreach ($element_general_fields as $field) {
				$form->setFieldAttribute($field->name, 'default', $element[$field->name]);
				
				if (in_array($field->name, $basic_haystack)) {
					$basic_fields[] = $field->name;
				}
			}
		}
		
		// Render element options
		if (!empty($element_options_fields)) {
			foreach ($element_options_fields as $field) {
				if (!empty($element['options']) && isset($element['options'][$field->name])) {
					$form->setFieldAttribute($field->name, 'default', $element['options'][$field->name]);
				}
				if (in_array($field->name, $basic_haystack)) {
					$basic_fields[] = $field->name;
				}
				if (in_array($field->name, $size_haystack)) {
					$size_fields[] = $field->name;
				}
				if (in_array($field->name, $color_haystack)) {
					$color_fields[] = $field->name;
				}
				if (in_array($field->name, $spacing_haystack)) {
					$spacing_fields[] = $field->name;
				}
			}
			
			// Build element options tab
			if ($jversion >= 4) {
				$ul_class			= 'joomla-tabs nav nav-tabs';
				$li_class			= 'nav-item';
				$a_class			= 'nav-link';
				$li_active_class	= 'nav-item';
				$a_active_class		= 'nav-link active';
			} else {
				$ul_class			= 'nav nav-tabs';
				$li_class			= '';
				$a_class			= '';
				$li_active_class	= 'active';
				$a_active_class		= '';
			}
			
			$html .= '<div class="options-tab tab">';
			$html .= '<ul class="' . $ul_class . '" id="element-options-tab">';
			if (!empty($basic_fields)) {
				$html .= '<li class="' . $li_active_class . '"><a class="' . $a_active_class . '" href="#basics" '.RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle').'="tab">'.JText::_('COM_RSPAGEBUILDER_BASICS').'</a></li>';
			}
			if (!empty($size_fields)) {
				$html .= '<li class="' . $li_class . '"><a class="' . $a_class . '" href="#sizes" '.RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle').'="tab">'.JText::_('COM_RSPAGEBUILDER_SIZES').'</a></li>';
			}
			if (!empty($color_fields)) {
				$html .= '<li class="' . $li_class . '"><a class="' . $a_class . '" href="#colors" '.RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle').'="tab">'.JText::_('COM_RSPAGEBUILDER_COLORS').'</a></li>';
			}
			if (!empty($spacing_fields)) {
				$html .= '<li class="' . $li_class . '"><a class="' . $a_class . '" href="#spacing" '.RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle').'="tab">'.JText::_('COM_RSPAGEBUILDER_SPACING').'</a></li>';
			}
			if (!empty($first_item)) {
				$html .= '<li class="' . $li_class . '"><a class="' . $a_class . '" href="#items" '.RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle').'="tab">'.JText::_('COM_RSPAGEBUILDER_ITEMS').'</a></li>';
			}
			$html .= '</ul>';
			$html .= '<div class="tab-content">';
			
			// Basics tab
			if (!empty($basic_fields)) {
				$html .= '<div class="tab-pane active" id="basics">';
				$html .= RSPageBuilderHelper::renderFormFields($form, $basic_fields, $element['type']);
				$html .= '</div>';
			}
			
			// Sizes tab
			if (!empty($size_fields)) {
				$html .= '<div class="tab-pane" id="sizes">';
				$html .= RSPageBuilderHelper::renderFormFields($form, $size_fields, $element['type']);
				$html .= '</div>';
			}
			
			// Colors tab
			if (!empty($color_fields)) {
				$html .= '<div class="tab-pane" id="colors">';
				$html .= RSPageBuilderHelper::renderFormFields($form, $color_fields, $element['type']);
				$html .= '</div>';
			}
			
			// Spacing tab
			if (!empty($spacing_fields)) {
				$html .= '<div class="tab-pane" id="spacing">';
				$html .= RSPageBuilderHelper::renderFormFields($form, $spacing_fields, $element['type']);
				$html .= '</div>';
			}
			
			// Items tab
			if (!empty($first_item)) {
				$html .= '<div class="tab-pane" id="items">';
				
				// Render element items
				$accordion_id	= RSPageBuilderHelper::createId('iterative', RSPageBuilderHelper::randomNumber());
				$item_index		= 0;
				$fieldsets		= $form->getFieldsets();
				
				// Collapse CSS classes
				$collapse_container	= 'accordion';
				$collapse_group		= ($jversion >= 4) ? 'accordion-item' : 'accordion-group';
				$collapse_header	= ($jversion >= 4) ? 'accordion-header' : 'accordion-heading';
				$collapse_toggle	= ($jversion >= 4) ? 'accordion-button collapsed' : 'accordion-toggle';
				$collapse_body		= ($jversion >= 4) ? 'accordion-collapse' : 'accordion-body';
				$collapse_inner		= ($jversion >= 4) ? 'accordion-body' : 'accordion-inner';
				
				foreach ($fieldsets as $fieldset) {
					if (preg_match('/item-/', $fieldset->name)) {
						$item_options_fields		= $form->getFieldset($fieldset->name);
						$item_id					= RSPageBuilderHelper::createId($fieldset->name, RSPageBuilderHelper::randomNumber());
						$item_name					= explode('-', $fieldset->name);
						
						$collapse_toggle_attribs	= ($jversion >= 4) ? RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle').'="collapse" '.RSPageBuilderHelper::getBootstrapElement('data', 0, 'target').'="#'.$item_id.'" aria-controls="'.$item_id.'"' : RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle').'="collapse" '.RSPageBuilderHelper::getBootstrapElement('data', 0, 'parent').'="'.$accordion_id.'"';
						$collapse_body_attribs		= ($jversion >= 4) ? RSPageBuilderHelper::getBootstrapElement('data', 0, 'parent').'="#'.$accordion_id.'"' : '';
						
						if (!empty($item_options_fields)) {
							if (!empty($element['items'][$item_index]['options']['item_title'])) {
								$item_title = $element['items'][$item_index]['options']['item_title'];
							} else if (!empty($element['items'][$item_index]['options']['item_text'])) {
								$item_title = $element['items'][$item_index]['options']['item_text'];
							} else if (!empty($element['items'][$item_index]['options']['marker_title'])) {
								$item_title = $element['items'][$item_index]['options']['marker_title'];
							} else if ($element['type'] == 'rspbld_price_box') {
								$item_title = JText::_('COM_RSPAGEBUILDER_ITEM_TEXT');
							} else if ($element['type'] == 'rspbld_google_map') {
								$item_title = JText::_('COM_RSPAGEBUILDER_MARKER_TITLE');
							} else {
								$item_title = JText::_('COM_RSPAGEBUILDER_ITEM_TITLE');
							}
							$items_html .= '<div class="'.$collapse_group.'">';
							$items_html .= '<div class="'.$collapse_header.'">';
							$items_html .= '<a href="#'.$item_id.'" class="'.$collapse_toggle.'" '.$collapse_toggle_attribs.'>'.$item_title.'</a>';
							$items_html .= '<div class="item-actions">';
							$items_html	.= '<a class="move-item" href="javascript:void(0)"><i class="fa fa-arrows-alt"></i></a>';
							$items_html	.= '<a class="duplicate-item" href="javascript:void(0)"><i class="fa fa-copy-o"></i></a>';
							$items_html	.= '<a class="delete-item" href="javascript:void(0)"><i class="fa fa-times"></i></a>';
							$items_html .= '</div>';
							$items_html .= '</div>';
							$items_html .= '<div class="'.$collapse_body.' collapse" id="'.$item_id.'"'.$collapse_body_attribs.'>';
							$items_html .= '<div class="'.$collapse_inner.'">';
							
							foreach ($item_options_fields as $field) {
								$field_name = explode('-', $field->name);
								
								if (!empty($element['items']) && isset($element['items'][$item_index]['options'][$field_name[0]])) {
									$form->setFieldAttribute($field->name, 'default', $element['items'][$item_index]['options'][$field_name[0]]);
								}
								$items_html .= '<div class="control-group';
								
								if ($form->getFieldAttribute($field->name, 'type') == 'hidden') {
									$items_html .= ' hidden';
								}
								$items_html .= '">';
								$items_html .= '<div class="control-label">';
			
								$field_label = $form->getLabel($field->name);
								
								// Add field label popover on Joomla 4
								if ($jversion >= 4) {
									$field_label = RSPageBuilderHelper::addFieldLabelPopover($field_label, JText::_($form->getFieldAttribute($field->name, 'label')), JText::_($form->getFieldAttribute($field->name, 'description')));
								}
								$items_html .= $field_label;
								$items_html .= '</div>';
								$items_html .= '<div class="controls">';
								$items_html .= $form->getInput($field->name);
								$items_html .= '</div>';
								$items_html .= '</div>';
							}
							$items_html .= '<div class="text-right">';
							$items_html .= '<a class="btn btn-warning close-item" href="javascript:void(0)" '.RSPageBuilderHelper::getBootstrapElement('data', 0, 'parent').'="'.$accordion_id.'"><i class="fa fa-bars"></i>'.JText::_('COM_RSPAGEBUILDER_CLOSE_ITEM').'</a>';
							$items_html .= '</div>';
							$items_html .= '</div>';
							$items_html .= '</div>';
							$items_html .= '</div>';
						}
						$item_index++;
					}
				}
				if ($items_html) {
					$html .= '<a href="javascript:void(0)" class="add-item btn btn-success"><i class="fa fa-plus"></i>'.JText::_('COM_RSPAGEBUILDER_ADD_ITEM').'</a>';
					$html .= '<div id="'.$accordion_id.'" class="iterative-items '.$collapse_container.'">';
					$html .= $items_html;
					$html .= '</div>';
				}
				$html .= '</div>';
			}
			$html .= '</div>';
			$html .= '</div>';
		}
		
		$form->reset(true);
		
		echo $html;
		
		Jexit();
	}
	
	public function elementHtml() {
		jimport('joomla.filesystem.file');
		
		$app			= JFactory::getApplication();
		$element		= $app->input->getArray(array(), null, 'RAW');
		$element_name	= str_replace('rspbld_', '', $element['type']);
		
		echo RSPageBuilderHelper::loadElementLayout($element, $element['bootstrap_version']);
		
		Jexit();
	}
}