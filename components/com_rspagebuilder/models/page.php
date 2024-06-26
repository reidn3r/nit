<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

class RSPageBuilderModelPage extends JModelItem
{
	
	protected function populateState() {
		$app		= JFactory::getApplication('site');
		$page_id	= $app->input->getInt('id');
		$this->setState('page.id', $page_id);
		
		$user = JFactory::getUser();
		
		if (!$user->authorise('core.edit.state', 'com_rspagebuilder') && !$user->authorise('core.edit', 'com_rspagebuilder')) {
			$this->setState('filter.published', 1);
		}
		
		$this->setState('filter.language', JLanguageMultilang::isEnabled());
	}
	
	public function getItem($page_id = null) {
		$user		= JFactory::getUser();
		$page_id	= (!empty($page_id)) ? $page_id : (int)$this->getState('page.id');
		
		if ($this->_item == null) {
			$this->_item = array();	
		}
		
		if (!isset($this->_item[$page_id])) {
			try {
				$db = $this->getDbo();
				$query = $db->getQuery(true)
					->select('a.*')
					->from('#__rspagebuilder as a')
					->where('a.id = ' . (int) $page_id);

				$query->select('l.title AS language_title')
					->leftJoin($db->quoteName('#__languages') . ' AS l ON l.lang_code = a.language');

				$query->select('ua.name AS author_name')
					->leftJoin('#__users AS ua ON ua.id = a.created_by');

				// Filter by published state.
				$published = $this->getState('filter.published');
				
				if (is_numeric($published)) {
					$query->where('a.published = ' . (int) $published);
				} else if ($published === '') {
					$query->where('(a.published IN (0, 1))');
				}
				
				if ($this->getState('filter.language')) {
					$query->where('a.language in (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
				}
				
				$db->setQuery($query);
				$data = $db->loadObject();
				
				if (empty($data)) {
					throw new \Exception(JText::_('JERROR_PAGE_NOT_FOUND'), 404);
				}
				
				if ($access = $this->getState('filter.access')) {
					$data->access_view = true;
				} else {
					$user				= JFactory::getUser();
					$groups				= $user->getAuthorisedViewLevels();
					$data->access_view	= in_array($data->access, $groups);
				}
				
				$this->_item[$page_id] = $data;
			} catch (Exception $e) {
				if ($e->getCode() == 404) {
					throw $e;
				} else {
					$this->setError($e);
					$this->_item[$page_id] = false;
				}
			}
		}
		
		return $this->_item[$page_id];
	}
}