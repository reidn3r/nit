<?php
// set variables
define('MOBILEMENUCK_LOADED', 1);
define('MOBILEMENUCK_PLATFORM', 'joomla');
define('MOBILEMENUCK_PATH', dirname(__FILE__));
define('MOBILEMENUCK_MEDIA_URI', \Joomla\CMS\Uri\Uri::root(true) . '/media/com_mobilemenuck');
define('MOBILEMENUCK_PLUGIN_MEDIA_URI', \Joomla\CMS\Uri\Uri::root(true) . '/media/plg_system_mobilemenuck');
define('MOBILEMENUCK_SITE_ROOT', JPATH_ROOT);
define('MOBILEMENUCK_URI_ROOT', \Joomla\CMS\Uri\Uri::root(true));
define('MOBILEMENUCK_URI_BASE', \Joomla\CMS\Uri\Uri::base(true));