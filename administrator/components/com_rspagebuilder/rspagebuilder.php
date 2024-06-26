<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

require_once JPATH_COMPONENT_ADMINISTRATOR . '/helpers/rspagebuilder.php';

// Initialize main helper
RSPageBuilderHelper::init();

$controller = JControllerLegacy::getInstance('RSPagebuilder');
$controller->execute(JFactory::getApplication()->input->getCmd('task'));
$controller->redirect();