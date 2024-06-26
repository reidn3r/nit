<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

class RSPageBuilderController extends JControllerLegacy {

	function display($cachable = false, $urlparams = false) {
		$input = JFactory::getApplication()->input;
		$input->set('view', $input->getCmd('view','pages'));

		parent::display($cachable);
	}
}