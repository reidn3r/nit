<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Component\Router\RouterView;
use Joomla\CMS\Component\Router\RouterViewConfiguration;
use Joomla\CMS\Component\Router\Rules\MenuRules;
use Joomla\CMS\Component\Router\Rules\NomenuRules;
use Joomla\CMS\Component\Router\Rules\StandardRules;
use Joomla\CMS\Menu\AbstractMenu;

class RSPageBuilderRouter extends JComponentRouterView {
	
	protected $noIDs = false;

	public function __construct($app = null, $menu = null) {
		$jversion = new JVersion();
		
		$params = JComponentHelper::getParams('com_rspagebuilder');
		$this->noIDs = (bool) $params->get('sef_ids');
		$pages = new JComponentRouterViewconfiguration('pages');
		$this->registerView($pages);
		$page = new JComponentRouterViewconfiguration('page');
		$page->setKey('id');
		$this->registerView($page);

		parent::__construct($app, $menu);
		
		$this->attachRule(new JComponentRouterRulesMenu($this));
		$this->attachRule(new JComponentRouterRulesStandard($this));
		$this->attachRule(new JComponentRouterRulesNomenu($this));
	}

	public function getPageSegment($id, $query) {
		if (!strpos($id, ':')) {
			$db = JFactory::getDbo();
			$dbquery = $db->getQuery(true);
			$dbquery->select($dbquery->qn('alias'))
				->from($dbquery->qn('#__rspagebuilder'))
				->where('id = ' . $dbquery->q((int) $id));
			$db->setQuery($dbquery);

			$id .= ':' . $db->loadResult();
		}

		if ($this->noIDs) {
			list($void, $segment) = explode(':', $id, 2);

			return array($void => $segment);
		}

		return array((int) $id => $id);
	}
	
	public function getPageId($segment, $query) {
		if ($this->noIDs) {
			$db = JFactory::getDbo();
			$dbquery = $db->getQuery(true);
			$dbquery->select($dbquery->qn('id'))
				->from($dbquery->qn('#__rspagebuilder'))
				->where('alias = ' . $dbquery->q($segment));
			$db->setQuery($dbquery);

			return (int) $db->loadResult();
		}

		return (int) $segment;
	}
}

function RSPageBuilderBuildRoute(&$query) {
	$app	= JFactory::getApplication();
	$router	= new RSPageBuilderRouter($app, $app->getMenu());

	return $router->build($query);
}

function RSPageBuilderParseRoute($segments) {
	$app	= JFactory::getApplication();
	$router	= new RSPageBuilderRouter($app, $app->getMenu());

	return $router->parse($segments);
}