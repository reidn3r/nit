<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */
 
 defined('_JEXEC') or die('Restricted access');

JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_rspagebuilder/tables/');

class RSPageBuilderXMLParser {
	
	protected function getTable() {
		return JTable::getInstance('Page', 'RSPageBuilderTable');
	}

	public function saveItem($item) {
		$item	= $this->prepareData($item);
		$table	= $this->getTable();
		
		$table->bind($item);
		$table->id			= null;
		$table->created		= date("Y-m-d H:i:s");
		$table->created_by	= JFactory::getUser()->id;
		$table->modified_by	= 0;
		
		if ($table->check()) {
			$table->store();
			$this->tableData[] = $table;
		}
	}
	
	public function addModulesIds($item_alias) {
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select($db->qn('content'))
			->from($db->qn('#__rspagebuilder'))
			->where($db->qn('alias') . ' = ' . $db->q($item_alias));
		$db->setQuery($query);
		$item_content = $db->loadResult();
		
		$query->clear();
		$query->update($db->qn('#__rspagebuilder'))
			->set($db->qn('content') . ' = ' . $db->q($this->parseContent($item_content)))
			->where($db->qn('alias') . ' = ' . $db->q($item_alias));
		$db->setQuery($query);
		$db->execute();
	}
	
	private function parseContent($content) {
		$data = json_decode($content);
		
		// for RSPageBuilder! Module elements get module id by using module title
		foreach ($data as $row) {
			foreach ($row->columns as $column) {
				foreach ($column->elements as $element) {
					if ($element->type == 'rspbld_module' && !(is_numeric($element->options->module))) {
						$db    = JFactory::getDbo();
						$query = $db->getQuery(true);

						$query->select($db->qn('id'))
							->from($db->qn('#__modules'))
							->where($db->qn('title') . ' = ' . $db->q($element->options->module))
							->where($db->qn('client_id'). ' = 0')
							->where($db->qn('published') . ' = 1');
						$db->setQuery($query);
						$module_id = $db->loadResult();
						
						$element->options->module = $module_id;
					}
				}
			}
		}
		
		return json_encode($data);
	}
	
	public function getPageId($alias) {
		static $cache = array();

		if (!isset($cache[$alias])) {
			foreach ($this->tableData as $position => $table) {
				if ($table->alias == $alias) {
					$cache[$alias] = $position;
					break;
				}
			}
		}

		return $this->tableData[$cache[$alias]]->id;
	}
	
	protected function prepareData($item) {
		$data = array();
		
		foreach ($item as $key => $val) {
			if ($key != 'child') {
				$data[$key] = (string) $val;
			} else {
				$data[$key][] = $val;
			}
		}

		return $data;
	}
}