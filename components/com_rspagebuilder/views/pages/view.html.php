<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

class RSPageBuilderViewPages extends JViewLegacy {

	public function display($tpl = null) {
		require_once (JPATH_COMPONENT . '/helpers/element-parser.php');
		require_once (JPATH_COMPONENT_ADMINISTRATOR.'/helpers/rspagebuilder.php');
		
		$doc				= JFactory::getDocument();
		$app				= JFactory::getApplication();
		$menus				= $app->getMenu();
		$menu				= $menus->getActive();
		$bootstrap_versions	= array();
		
		$this->jversion		= RSPageBuilderHelper::getJoomlaVersion();
		$this->items 		= $this->get('Items');
		$this->state		= $this->get('State');
		$this->pagination	= $this->get('Pagination');
		$this->total		= $this->get('Total');
		$this->params		= $this->state->get('params');

		if (count($this->items)) {
			foreach ($this->items as $page) {
				$bootstrap_versions[] = $page->bootstrap_version;
			}
			
			// Get the highest number of pages with the same Bootstrap version
			$this->bootstrap_version = array_search(max(array_count_values($bootstrap_versions)), array_count_values($bootstrap_versions));
			
			// Load jQuery files
			JHtml::_('jquery.framework', true, null, true);

			// Load CSS files
			RSPageBuilderHelper::loadAsset('component', 'font-awesome.min.css');
			RSPageBuilderHelper::loadAsset('component', 'style-bs' . $this->bootstrap_version . '.css');
			
			// Load JS files
			$doc->addScriptDeclaration('var rspbld_jversion = '.$this->jversion.';');
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
			
			// Check for errors
			if (count($errors = $this->get('Errors'))) {
				throw new \Exception(implode("\n", $errors), 500);
			}
			
			parent::display($tpl);
		} else {
			$app->enqueueMessage(JText::_('COM_RSPAGEBUILDER_NO_PAGES_FOUND'), 'warning');
		}
	}
}