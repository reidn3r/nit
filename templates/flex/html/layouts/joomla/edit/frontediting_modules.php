<?php
/**
 * Flex @package Helix3 Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

use Joomla\CMS\HTML\HTMLHelper;

// JLayout for standard handling of the edit modules:

$moduleHtml   = &$displayData['moduleHtml'];
$mod          = $displayData['module'];
$position     = $displayData['position'];
$menusEditing = $displayData['menusediting'];
$parameters   = ComponentHelper::getParams('com_modules');
$redirectUri  = '&return=' . urlencode(base64_encode(Uri::getInstance()->toString()));
$target       = '_blank';
$itemid       = Factory::getApplication()->input->get('Itemid', '0', 'int');
$editUrl      = Uri::base() . 'administrator/index.php?option=com_modules&task=module.edit&id=' . (int) $mod->id;


// If Module editing site
if ($parameters->get('redirect_edit', 'site') === 'site')
{
	$editUrl = Uri::base() . 'index.php?option=com_config&view=modules&id=' . (int) $mod->id . '&Itemid=' . $itemid . $redirectUri;
	$target  = '_self';
}

$moduleHtml = preg_replace(
	// Find first tag of module
	'/^(\s*<(?:div|span|nav|ul|ol|h\d|section|aside|address|article|form) [^>]*>)/',
	// Create and add the edit link and tooltip
	//  d-inline justify-content-end align-items-end
	'\\1 <div class="jmoddiv_wrapper"><a class="btn btn-outline-danger btn-sm jmoddiv small px-3 py-2" href="' . $editUrl . '" target="' . $target . '" aria-describedby="tip-' . (int) $mod->id . '" data-toggle="tooltip" data-bs-html="true" title="<em>'. Text::_('JLIB_HTML_EDIT_MODULE') . ':</em><br /><b class=\'major_color-lighten-20\'>“' . htmlspecialchars($mod->title, ENT_COMPAT, 'UTF-8') . '”</b><br />' .  sprintf(JText::_('JLIB_HTML_EDIT_MODULE_IN_POSITION'), '<br /><b>'. htmlspecialchars($position, ENT_COMPAT, 'UTF-8')) . '</b>' .'"><span class="icon-edit" aria-hidden="true"></span></a></div>',
	$moduleHtml,
	1,
	$count
);

// If menu editing is enabled and allowed and it's a menu module add link for editing
if ($menusEditing && $mod->module === 'mod_menu')
{
	// find the menu item id
	$regex = '/\bitem-(\d+)\b/';

	preg_match_all($regex, $moduleHtml, $menuItemids);
	if ($menuItemids)
	{
		foreach ($menuItemids[1] as $menuItemid)
			{
				$menuitemEditUrl = Uri::base() . 'administrator/index.php?option=com_menus&view=item&client_id=0&layout=edit&id=' . (int) $menuItemid;
				$moduleHtml = preg_replace(
					// Find the link
					'/(<li.*?\bitem-' . $menuItemid . '.*?>)/',
					// Create and add the edit link
					'\\1 <a class="btn jmenuedit small" href="' . $menuitemEditUrl . '" target="' . $target . '" title="' . Text::_('JLIB_HTML_EDIT_MENU_ITEM') . ' ' . sprintf(Text::_('JLIB_HTML_EDIT_MENU_ITEM_ID'), (int) $menuItemid) . '">
					</a>',
					$moduleHtml
				);
			}
	}
}