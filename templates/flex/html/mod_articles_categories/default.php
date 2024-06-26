<?php
/**
 * Flex @package SP Page Builder
 * Template Name - Flex
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
// no direct access
defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;

if (JVERSION < 4) {
  	// Joomla 3...
} else {
	// Joomla 4...
	if (!$list) {
		return;
	}
}
?>
<ul class="category-module<?php echo $moduleclass_sfx; ?> mod-list">
<?php require ModuleHelper::getLayoutPath('mod_articles_categories', $params->get('layout', 'default') . '_items'); ?>
</ul>