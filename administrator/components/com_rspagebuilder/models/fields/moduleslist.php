<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('JPATH_PLATFORM') or die;

JFormHelper::loadFieldClass('list');

class JFormFieldModuleslist extends JFormFieldList {
	protected $type = 'Moduleslist';
	
	protected function getInput() {
		$html		= array();
		$attr		= !empty($this->class) ? ' class="' . $this->class . '"' : '';
		$options	= (array) $this->getModulesList();
		
		$html[] = JHtml::_('select.genericlist', $options, $this->name, trim($attr), 'value', 'text', $this->value, $this->id);
		
		return implode($html);
	}
	
	protected function getModulesList() {
		$db     = JFactory::getDbo();
		$query	= $db->getQuery(true)
			->select($db->qn('id') . ', ' . $db->qn('title'))
			->from($db->qn('#__modules'))
			->where($db->qn('client_id'). ' = 0')
			->where($db->qn('published') . ' = 1')
			->order($db->qn('ordering') . ', ' . $db->qn('title'));
		$db->setQuery($query);
		$modules = $db->loadObjectList();
		
		foreach ($modules as $module) {
			$tmp = array(
					'value'    => $module->id,
					'text'     => $module->title
				);
			
			$options[] = (object) $tmp;
		}
		
		reset($options);
		
		return $options;
	}
}