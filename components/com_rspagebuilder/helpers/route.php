<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

abstract class RSPageBuilderHelperRoute {

	protected static $lookup		= array();
	protected static $lang_lookup	= array();

	public static function getPageRoute($id, $language = 0) {
		if ($id != null) {
			$needles = array(
				'page' => array((int) $id)
			);
			
			$link = 'index.php?option=com_rspagebuilder&view=page&id=' . $id;

			if ($language && $language != "*" && JLanguageMultilang::isEnabled()) {
				self::buildLanguageLookup();

				if (isset(self::$lang_lookup[$language])) {
					$link .= '&lang=' . self::$lang_lookup[$language];
					$needles['language'] = $language;
				}
			}

			if ($item = self::_findItem($needles)) {
				$link .= '&Itemid=' . $item;
			}

			return $link;
		} else {
			$needles = array(
				'view' => 'pages'
			);

			$itemid = '';
			if ($item = self::_findItemid($needles)) {
				$itemid = $item;
			} else if ($item = self::_findItemid()) {
				$itemid = $item;
			}

			return $itemid;
		}
	}
	
	protected static function buildLanguageLookup() {
		if (count(self::$lang_lookup) == 0) {
			$db    = JFactory::getDbo();
			$query = $db->getQuery(true)
				->select('a.sef AS sef')
				->select('a.lang_code AS lang_code')
				->from('#__languages AS a');

			$db->setQuery($query);
			$langs = $db->loadObjectList();

			foreach ($langs as $lang) {
				self::$lang_lookup[$lang->lang_code] = $lang->sef;
			}
		}
	}

	protected static function _findItem($needles = null) {
		$app      = JFactory::getApplication();
		$menus    = $app->getMenu('site');
		$language = isset($needles['language']) ? $needles['language'] : '*';

		// Prepare the reverse lookup array.
		if (!isset(self::$lookup[$language])) {
			self::$lookup[$language] = array();

			$component  = JComponentHelper::getComponent('com_rspagebuilder');

			$attributes = array('component_id');
			$values     = array($component->id);

			if ($language != '*') {
				$attributes[] = 'language';
				$values[]     = array($needles['language'], '*');
			}

			$menu_items = $menus->getItems($attributes, $values);

			foreach ($menu_items as $menu_item) {
				if (isset($menu_item->query) && isset($menu_item->query['view'])) {
					$view = $menu_item->query['view'];

					if (!isset(self::$lookup[$language][$view])) {
						self::$lookup[$language][$view] = array();
					}

					if (isset($menu_item->query['id'])) {
						if (!isset(self::$lookup[$language][$view][$menu_item->query['id']]) || $menu_item->language != '*') {
							self::$lookup[$language][$view][$menu_item->query['id']] = $menu_item->id;
						}
					}
				}
			}
		}

		if ($needles) {
			foreach ($needles as $view => $ids) {
				if (isset(self::$lookup[$language][$view])) {
					foreach ($ids as $id) {
						if (isset(self::$lookup[$language][$view][(int) $id])) {
							return self::$lookup[$language][$view][(int) $id];
						}
					}
				}
			}
		}

		// Check if the active menuitem matches the requested language
		$active = $menus->getActive();

		if ($active && $active->component == 'com_rspagebuilder' && ($language == '*' || in_array($active->language, array('*', $language)) || !JLanguageMultilang::isEnabled())) {
			return $active->id;
		}

		// If not found, return language specific home link
		$default = $menus->getDefault($language);

		return !empty($default->id) ? $default->id : null;
	}
	
	protected static function _findItemid($needles = null) {
		$app		= JFactory::getApplication();
		$language	= isset($needles['language']) ? $needles['language'] : '*';
		$menus    	= $app->getMenu('site');
		
		$active = $menus->getActive();
		
		if ($active && $active->component == 'com_rspagebuilder' && ($language == '*' || in_array($active->language, array('*', $language)) || !JLanguageMultilang::isEnabled())) {
			return $active->id;
		} else {
			return JUri::getInstance()->getVar('Itemid');
		}
	}
}