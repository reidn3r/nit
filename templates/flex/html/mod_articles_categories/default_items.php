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
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Factory;
use Joomla\Component\Content\Site\Helper\RouteHelper;

if (JVERSION < 4) {
  	// Joomla 3...
	$input  = Factory::getApplication()->input;
} else {
	// Joomla 4...
	$input  = $app->input;
}
$option = $input->getCmd('option');
$view   = $input->getCmd('view');
$id     = $input->getInt('id');

foreach ($list as $item) : ?>
    <li<?php if ($id == $item->id && in_array($view, array('category', 'categories')) && $option == 'com_content') {
        echo ' class="active"';
       } ?>> <?php $levelup = $item->level - $startLevel - 1; ?>
		<?php if (JVERSION < 4) { 
			// Joomla 3... ?>
			<a href="<?php echo Route::_(ContentHelperRoute::getCategoryRoute($item->id)); ?>">
		<?php } else {  
			// Joomla 4... ?>
			<a href="<?php echo Route::_(RouteHelper::getCategoryRoute($item->id, $item->language)); ?>">
		<?php } ?>
        
        <?php echo $item->title; ?>
            <?php if ($params->get('numitems')) : ?>
                (<?php echo $item->numitems; ?>)
            <?php endif; ?>
        </a>

        <?php if ($params->get('show_description', 0)) : ?>
            <?php echo HTMLHelper::_('content.prepare', $item->description, $item->getParams(), 'mod_articles_categories.content'); ?>
        <?php endif; ?>
        <?php
        if (
            $params->get('show_children', 0) && (($params->get('maxlevel', 0) == 0)
            || ($params->get('maxlevel') >= ($item->level - $startLevel)))
            && count($item->getChildren())
        ) : ?>
            <?php echo '<ul>'; ?>
            <?php $temp = $list; ?>
            <?php $list = $item->getChildren(); ?>
            <?php require ModuleHelper::getLayoutPath('mod_articles_categories', $params->get('layout', 'default') . '_items'); ?>
            <?php $list = $temp; ?>
            <?php echo '</ul>'; ?>
        <?php endif; ?>
    </li>
<?php endforeach; ?>