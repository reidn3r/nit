<?php
/**
 * @name		Mobile Menu CK
 * @package		com_mobilemenuck
 * @copyright	Copyright (C) 2017. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Cedric Keiflin - http://www.template-creator.com - http://www.joomlack.fr
 */

// No direct access
defined('_JEXEC') or die;

// set variables
//if (!defined('MOBILEMENUCK_PATH')) {
	define('MOBILEMENUCK_BASE_PATH', JPATH_BASE . '/components/com_mobilemenuck');
//	define('MOBILEMENUCK_SITE_PATH', JPATH_SITE . '/components/com_mobilemenuck');
//	define('MOBILEMENUCK_PATH', JPATH_SITE . '/administrator/components/com_mobilemenuck');
//	define('MOBILEMENUCK_PARAMS_PATH', JPATH_SITE . '/administrator/components/com_mobilemenuck/pro');
//	define('MOBILEMENUCK_PROJECTS_PATH', JPATH_SITE . '/administrator/components/com_mobilemenuck/projects');
//	define('MOBILEMENUCK_ADMIN_URL', \Joomla\CMS\Uri\Uri::root(true) . '/administrator/index.php?option=com_mobilemenuck');
//	define('MOBILEMENUCK_BASE_URL', \Joomla\CMS\Uri\Uri::base(true) . '/index.php?option=com_mobilemenuck');
	define('MOBILEMENUCK_ADMIN_GENERAL_URL', \Joomla\CMS\Uri\Uri::root(true) . '/administrator/index.php?option=com_mobilemenuck');
//	define('MOBILEMENUCK_MEDIA_URI', \Joomla\CMS\Uri\Uri::root(true) . '/media/com_mobilemenuck');
//	define('MOBILEMENUCK_MEDIA_URL', MOBILEMENUCK_MEDIA_URI);
//	define('MOBILEMENUCK_MEDIA_PATH', JPATH_ROOT . '/media/com_mobilemenuck');
//	define('MOBILEMENUCK_PLUGIN_URL', MOBILEMENUCK_MEDIA_URI);
//	define('MOBILEMENUCK_TEMPLATES_PATH', JPATH_SITE . '/templates');
//	define('MOBILEMENUCK_SITE_ROOT', JPATH_ROOT);
//	define('MOBILEMENUCK_URI', \Joomla\CMS\Uri\Uri::root(true) . '/administrator/components/com_mobilemenuck');
//	define('MOBILEMENUCK_URI_ROOT', \Joomla\CMS\Uri\Uri::root(true));
//	define('MOBILEMENUCK_URI_BASE', \Joomla\CMS\Uri\Uri::base(true));
//	define('MOBILEMENUCK_VERSION', simplexml_load_file(MOBILEMENUCK_PATH . '/mobilemenuck.xml')->version);
//	define('MOBILEMENUCK_ISJ4', version_compare(JVERSION, "4") >= 0);
//}

if (!defined('MOBILEMENUCK_ADMIN_PATH'))
{
define('MOBILEMENUCK_ADMIN_PATH', JPATH_SITE . '/administrator/components/com_mobilemenuck');
}

if (!defined('MOBILEMENUCK_MEDIA_PATH'))
{
define('MOBILEMENUCK_MEDIA_PATH', JPATH_SITE . '/media/com_mobilemenuck');
}

if (!defined('MOBILEMENUCK_SITE_PATH'))
{
define('MOBILEMENUCK_SITE_PATH', JPATH_SITE . '/components/com_mobilemenuck');
}

if (!defined('MOBILEMENUCK_ADMIN_URI'))
{
define('MOBILEMENUCK_ADMIN_URI', \Joomla\CMS\Uri\Uri::root(true) . '/administrator/?option=com_mobilemenuck');
}

if (!defined('MOBILEMENUCK_MEDIA_URI'))
{
define('MOBILEMENUCK_MEDIA_URI', \Joomla\CMS\Uri\Uri::root(true) . '/media/com_mobilemenuck');
}
