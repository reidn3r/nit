<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

class RSPageBuilderViewPage extends JViewLegacy {

	public function display($tpl = null) {
		require_once (JPATH_COMPONENT . '/helpers/element-parser.php');
		require_once (JPATH_COMPONENT_ADMINISTRATOR.'/helpers/rspagebuilder.php');
		
		$doc						= JFactory::getDocument();
		$app						= JFactory::getApplication();
		$menus						= $app->getMenu();
		$menu						= $menus->getActive();

		$this->jversion				= RSPageBuilderHelper::getJoomlaVersion();
		$this->page 				= $this->get('Item');
		$this->state				= $this->get('State');
		$this->pageclass_sfx		= '';
		$this->show_page_heading	= '';
		$this->page_heading			= 0;
		
		// Load Bootstrap files
		if ($this->page->bootstrap_version == 2 || $this->page->bootstrap_version == 5) {
			JHtml::_('bootstrap.framework');
			JHtml::_('bootstrap.loadCss', true, $doc->direction);
		}

		// Load jQuery files
		JHtml::_('jquery.framework', true, null, true);

		// Load CSS files
		RSPageBuilderHelper::loadAsset('component', 'font-awesome.min.css');
		RSPageBuilderHelper::loadAsset('component', 'style-bs' . $this->page->bootstrap_version . '.css');
		
		// Load JS files
		$doc->addScriptDeclaration('var rspbld_jversion = ' . $this->jversion . ',
			rspbld_bversion = ' . $this->page->bootstrap_version . ';');
		RSPageBuilderHelper::loadAsset('component', 'rspagebuilder.js');
		
		// Messages translations
		JText::script('COM_RSPAGEBUILDER_COUNTDOWN_TIMER_EXPIRED');
		
		JText::script('WARNING');
		
		// Elements fields translations
		JText::script('COM_RSPAGEBUILDER_LONG_DAY');
		JText::script('COM_RSPAGEBUILDER_LONG_DAYS');
		JText::script('COM_RSPAGEBUILDER_LONG_HOUR');
		JText::script('COM_RSPAGEBUILDER_LONG_HOURS');
		JText::script('COM_RSPAGEBUILDER_LONG_MINUTE');
		JText::script('COM_RSPAGEBUILDER_LONG_MINUTES');
		JText::script('COM_RSPAGEBUILDER_LONG_SECOND');
		JText::script('COM_RSPAGEBUILDER_LONG_SECONDS');
		JText::script('COM_RSPAGEBUILDER_SHORT_DAYS');
		JText::script('COM_RSPAGEBUILDER_SHORT_HOURS');
		JText::script('COM_RSPAGEBUILDER_SHORT_MINUTES');
		JText::script('COM_RSPAGEBUILDER_SHORT_SECONDS');

		// Active menu item
		if ($menu) {
			$this->menu_params			= $this->state->get('parameters.menu');
			$this->pageclass_sfx 		= $this->menu_params->get('pageclass_sfx');
			$this->show_page_heading	= $this->menu_params->get('show_page_heading');
			$this->page_heading 		= $this->menu_params->get('page_heading');
		}
		
		// Check for errors
		if (count($errors = $this->get('Errors'))) {
			throw new \Exception(implode("\n", $errors), 500);
		}
		if ($this->page->access_view == false) {
			throw new \Exception(JText::_('JERROR_ALERTNOAUTHOR'), 403);
		}
		
		// Clear search
		$app->setUserState('rspagebuilder.search', '');
		
		$this->prepareDocument();
		parent::display($tpl);
	}

	protected function prepareDocument() {
		$config						= JFactory::getConfig();
		$app						= JFactory::getApplication();
		$doc 						= JFactory::getDocument();
		$menus						= $app->getMenu();
		$menu						= $menus->getActive();
		$this->menu_params			= $this->state->get('parameters.menu');
		$title						= ($menu ? $this->menu_params->get('page_title', '') : '');
		
		if (empty($title)) {
			$title = $this->page->title;
		}
		
		// Set page title
		$page_title = $title;
		if ($config->get('sitename_pagetitles') == 2) {
			$page_title = $title . ' | ' . $config->get('sitename');
		} elseif ($config->get('sitename_pagetitles') == 1) {
			$page_title = $config->get('sitename') . ' | ' . $title;
		}
		$doc->setTitle($page_title);
		
		// Open Graph meta tags
		$open_graph_title = $this->page->open_graph_title ? $this->page->open_graph_title : $title;
		$doc->setMetadata('og:title', $open_graph_title, 'property');
		$doc->setMetadata('og:type', 'website', 'property');
		
		if ($this->page->open_graph_image) {
			$doc->setMetadata('og:image', JUri::root() . $this->page->open_graph_image, 'property');
		}
		if ($this->page->open_graph_description) {
			$doc->setMetadata('og:description', $this->page->open_graph_description, 'property');
		}
		$doc->setMetadata('og:url', JUri::current(), 'property');
		
		if ($this->page->metadesc) {
			$doc->setDescription($this->page->metadesc);
		} else if ($menu && $this->menu_params->get('menu-meta_description')) {
			$doc->setDescription($this->menu_params->get('menu-meta_description'));
		}
		
		if ($this->page->metakey) {
			$doc->setMetadata('keywords', $this->page->metakey);
		} else if ($menu && $this->menu_params->get('menu-meta_keywords')) {
			$doc->setMetadata('keywords', $this->menu_params->get('menu-meta_keywords'));
		}
		
		if ($this->page->robots) {
			$doc->setMetadata('robots', $this->page->robots);
		} else if ($menu && $this->menu_params->get('robots')) {
			$doc->setMetadata('robots', $this->menu_params->get('robots'));
		}
	}
}