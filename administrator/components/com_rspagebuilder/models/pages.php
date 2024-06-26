<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

use Joomla\Utilities\ArrayHelper;

class RSPageBuilderModelPages extends JModelList {
	
	public function __construct($config = array()) {
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id', 'p.id',
				'title', 'p.title',
				'published', 'p.published',
				'access', 'p.access', 'access_level',
				'created_by', 'p.created_by', 'author_id',
                'created', 'p.created',
				'language', 'p.language'
			);
		}
		
		parent::__construct($config);
	}
	
	protected function populateState($ordering = 'p.id', $direction = 'desc') {
		$app = JFactory::getApplication();
		
		$search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);
		
		$published = $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '');
		$this->setState('filter.published', $published);
		
		$language = $this->getUserStateFromRequest($this->context . '.filter.language', 'filter_language', '');
		$this->setState('filter.language', $language);
		
		$formSubmited = $app->input->post->get('form_submited');

		$access     = $this->getUserStateFromRequest($this->context . '.filter.access', 'filter_access');
		$author_id	= $this->getUserStateFromRequest($this->context . '.filter.author_id', 'filter_author_id');

		if ($formSubmited) {
			$access = $app->input->post->get('access');
			$this->setState('filter.access', $access);

			$author_id = $app->input->post->get('author_id');
			$this->setState('filter.author_id', $authorId);
		}
		
		// List state information.
		parent::populateState('p.id', 'desc');
	}
	
	protected function getStoreId($id = '') {
		// Compile the store id.
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . serialize($this->getState('filter.access'));
		$id .= ':' . $this->getState('filter.published');
		$id .= ':' . serialize($this->getState('filter.author_id'));
		$id .= ':' . $this->getState('filter.language');

		return parent::getStoreId($id);
	}
	
	protected function getListQuery() {
		// Create a new query object.
		$db    = $this->getDbo();
		$query = $db->getQuery(true);
		
		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'DISTINCT p.id, p.title, p.alias, p.published, p.access, p.created, p.created_by, p.language'
			)
		);
		
		$query->from('#__rspagebuilder AS p');
		
		// Join over the asset groups.
		$query->select('ag.title AS access_level')
			->join('LEFT', '#__viewlevels AS ag ON ag.id = p.access');
		
		// Join over the users for the author.
		$query->select('ua.name AS author_name')
			->join('LEFT', '#__users AS ua ON ua.id = p.created_by');
			
		// Join over the language
		$query->select('l.title AS language_title')
			->join('LEFT', $db->quoteName('#__languages') . ' AS l ON l.lang_code = p.language');

		// Filter by published state
		$published = $this->getState('filter.published');

		if (is_numeric($published)) {
			$query->where('p.published = ' . (int) $published);
		} else if ($published === '') {
			$query->where('(p.published = 0 OR p.published = 1)');
		}
		
		// Filter by access level.
		$access = $this->getState('filter.access');

		if (is_numeric($access)) {
			$query->where('p.access = ' . (int) $access);
		} else if (is_array($access)) {
			$access = ArrayHelper::toInteger($access);
			$access = implode(',', $access);
			$query->where('p.access IN (' . $access . ')');
		}
		
		// Filter by author
		$author_id = $this->getState('filter.author_id');

		if (is_numeric($author_id)) {
			$type = $this->getState('filter.author_id.include', true) ? '= ' : '<>';
			$query->where('p.created_by ' . $type . (int) $author_id);
		} else if (is_array($author_id)) {
			$author_id = ArrayHelper::toInteger($author_id);
			$author_id = implode(',', $author_id);
			$query->where('p.created_by IN (' . $author_id . ')');
		}
		
		// Filter on the language.
		if ($language = $this->getState('filter.language')) {
			$query->where('p.language = ' . $db->quote($language));
		}
		
		// Filter by search in title.
		$search = $this->getState('filter.search');

		if (!empty($search)) {
			if (stripos($search, 'id:') === 0) {
				$query->where('p.id = ' . (int) substr($search, 3));
			} else if (stripos($search, 'author:') === 0) {
				$search = $db->quote('%' . $db->escape(substr($search, 7), true) . '%');
				$query->where('(ua.name LIKE ' . $search . ' OR ua.username LIKE ' . $search . ')');
			} else {
				$search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
				$query->where('(p.title LIKE ' . $search . ' OR p.alias LIKE ' . $search . ')');
			}
		}
		
		// Add the list ordering clause.
		$orderCol  = $this->state->get('list.ordering', 'p.id');
		$orderDirn = $this->state->get('list.direction', 'DESC');

		$query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));
		
		return $query;
	}
}