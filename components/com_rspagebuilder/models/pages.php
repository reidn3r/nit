<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');

class RSPageBuilderModelPages extends JModelList {

	protected function populateState($ordering = 'p.ordering', $direction = 'DESC') {
		$app = JFactory::getApplication();
		
		// Load language
		$user = JFactory::getUser();
		
		if (!$user->authorise('core.edit.state', 'com_rspagebuilder') && !$user->authorise('core.edit', 'com_rspagebuilder')) {
			$this->setState('filter.published', 1);
		}
		
		$this->setState('filter.language', JLanguageMultilang::isEnabled());
		
		// Load the parameters.
		$params = $app->getParams();
		$this->setState('params', $params);
		
		// List state information
		$limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->input->get('limit', $app->getCfg('list_limit', 0), 'uint'), 'int');
		$this->setState('list.limit', $limit);
		
		$lstart = $app->input->get('limitstart', 0, 'uint');
		$this->setState('list.start', $lstart);
		
		
		$filter = $app->getUserStateFromRequest('rspagebuilder.search', 'search', $app->input->get('search', '', 'string'));
		$this->setState('list.filter', $filter);
	}
	
	protected function getListQuery() {
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		
		// Select the required fields from the table.
		$query->select('DISTINCT p.*');
		
		// Select from table
		$query->from($db->qn('#__rspagebuilder','p'));
		
		// Filter by published state
		$published = $this->getState('filter.published');

		if (is_numeric($published)) {
			$query->where($db->qn('p.published').' = ' . (int) $published);
		} else if (is_array($published)) {
			JArrayHelper::toInteger($published);
			$published = implode(',', $published);
			$query->where($db->qn('p.published').' IN ('.$published.')');
		}
		
		// Filter search
		if ($filter = $this->getState('list.filter')) {
			$patterns	= array(
				'/[^a-zA-Z0-9\s]/',
				'/\s+/'
			);
			$replaces	= array(
				'',
				' '
			);
			$filter		= trim(preg_replace($patterns, $replaces, $filter));
			$terms		= explode(' ', $filter);
			$terms		= array_unique($terms);
			$wheres		= array();
			
			foreach($terms as $term) {
				if (strlen($term) > 1) {
					$wheres[] = '('.$db->qn('p.title').' LIKE '.$db->q('%'.$term.'%').' OR '.$db->qn('p.content').' LIKE '.$db->q('%'.$term.'%').')';
				}
			}
			
			if (count($wheres)) {
				$query->where('('.implode(' OR ', $wheres).')');
			}
		}
		
		return (string) $query;
	}
	
	protected function _getNavigation() {
		$db = JFactory::getDbo();
		$query = $this->getListQuery();
		$ids = array();
		
		$db->setQuery($query);
		if ($results = $db->loadObjectList()) {
			foreach ($results as $post) {
				$ids[] = $post->id;
			}
		}
		
		return $ids;
	}
	
	public function getPrevious() {
		$ids = $this->_getNavigation();
		JArrayHelper::toInteger($ids);
		
		$prev	 = 0;
		$current = JFactory::getApplication()->input->getInt('id');
		
		reset($ids);
		$key = array_search($current,$ids);
		
		if (isset($ids[$key]))
		{
			if (isset($ids[$key - 1]))
				$prev = $ids[$key - 1];
		}
		
		return $prev;
	}
	
	public function getNext() {
		$ids = $this->_getNavigation();
		JArrayHelper::toInteger($ids);
		
		$next	 = 0;
		$current = JFactory::getApplication()->input->getInt('id');
		
		reset($ids);
		$key = array_search($current,$ids);
		
		if (isset($ids[$key])) {
			if (isset($ids[$key + 1])) {
				$next = $ids[$key + 1];
			}
		}
		
		return $next;
	}
	
	public function getStart() {
		return $this->getState('list.start');
	}
}