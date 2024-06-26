<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

class RSPageBuilderConfig {
	public static $forms = array();
	
	public static function getColumnConfig() {
		$column_config			= array();
		$form					= JForm::getInstance('rspbld_column', JPATH_COMPONENT_ADMINISTRATOR.'/models/forms/column.xml');
		$column_general_fields	= $form->getFieldset('general');
		$column_options_fields	= $form->getFieldset('options');
		
		foreach ($column_general_fields as $field) {
			$column_config[$field->name] = (string)$form->getFieldAttribute($field->name, 'default');
		}
		foreach ($column_options_fields as $field) {
			$column_config['options'][$field->name] = (string)$form->getFieldAttribute($field->name, 'default');
		}
		$form->reset(true);
		
		return $column_config;
	}
	
	public static function getRowConfig() {
		$row_config	= array();
		$form		= JForm::getInstance('rspbld_row', JPATH_COMPONENT_ADMINISTRATOR.'/models/forms/row.xml');
		$row_general_fields	= $form->getFieldset('general');
		$row_options_fields	= $form->getFieldset('options');
		
		foreach ($row_general_fields as $field) {
			$row_config[$field->name] = (string)$form->getFieldAttribute($field->name, 'default');
		}
		foreach ($row_options_fields as $field) {
			$row_config['options'][$field->name] = (string)$form->getFieldAttribute($field->name, 'default');
		}
		$form->reset(true);
		
		return $row_config;
	}
	
	public static function getElements() {
		$elements	= array();
		$files		= JFolder::files(JPATH_ADMINISTRATOR.'/components/com_rspagebuilder/models/forms/elements', '.xml', false, true);
		
		foreach ($files as $file) {
			$form		= JForm::getInstance('rspbld_'.str_replace('.xml', '', basename($file)), $file);
			
			RSPageBuilderConfig::$forms[$form->getFieldAttribute('type', 'default')] = $form;
			
			$elements[]	= array(
				'type'		=> $form->getFieldAttribute('type', 'default'),
				'category'	=> $form->getFieldAttribute('category', 'default')
			);
		}
		
		return $elements;
	}
	
	public static function getMyElements() {
		$elements	= array();
		$db     	= JFactory::getDbo();
		$query		= $db->getQuery(true)
			->select($db->qn('content'))
			->from($db->qn('#__rspagebuilder'))
			->where($db->qn('published') . ' = 1');
		$db->setQuery($query);
		
		$pages = $db->loadObjectList();
		
		foreach ($pages as $page) {
			$content = json_decode($page->content);
			
			foreach ($content as $row) {
				$row = RSPageBuilderHelper::toArray($row);
				
				foreach ($row['columns'] as $column ) {
					foreach ($column['elements'] as $element) {
						$element['category'] = 'my_elements';
						$elements[] = $element;
					}
				}
			}
		}
		
		return $elements;
	}
}