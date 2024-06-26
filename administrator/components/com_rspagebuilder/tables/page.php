<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
*/


// No direct access
defined ('_JEXEC') or die ('Restricted access');

class RSPageBuilderTablePage extends JTable
{
	function __construct(&$db) {
        parent::__construct('#__rspagebuilder', 'id', $db);
    }
	
    public function store($updateNulls = true) {
		$table	= JTable::getInstance('Page', 'RSPageBuilderTable');
		$date	= JFactory::getDate();
		$user	= JFactory::getUser();
		$alias	= JFilterOutput::stringURLSafe($this->alias);
		
		if ($this->id) {
			$this->modified		= $date->toSql();
			$this->modified_by	= $user->get('id');
		} else {
			if (!(int) $this->created) {
				$this->created = $date->toSql();
			}
			if (empty($this->created_by)) {
				$this->created_by = $user->get('id');
			}
		}
		
		if ($alias == '') {
			$alias = JFilterOutput::stringURLSafe($this->title);
		}

		$this->alias = $alias;
		
		if ($table->load(array('alias' => $alias)) && ($table->id != $this->id || $this->id == 0)) {
			$this->setError(JText::_('COM_RSPAGEBUILDER_ERROR_UNIQUE_ALIAS'));
			return false;
		}

		return parent::store($updateNulls);
	}
}