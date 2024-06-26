<?php
/**
 * Flex @package Helix Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\Component\Content\Site\Helper\RouteHelper;

?>
<dd class="parent-category-name">
	<i class="fa fa-folder-o"></i>
	<?php $title = $this->escape($displayData['item']->parent_title); ?>
	<?php if ($displayData['params']->get('link_parent_category') && !empty($displayData['item']->parent_slug)) : ?>
	
	
	<?php if (JVERSION < 4) {  ?>
		<?php echo '<a href="' . Route::_(ContentHelperRoute::getCategoryRoute($displayData['item']->parent_slug)) . '" itemprop="genre" data-toggle="tooltip" title="' . Text::sprintf('COM_CONTENT_PARENT', '') . '">' . $title . '</a>'; ?>
	<?php } else { ?>
		<?php $url = '<a href="' . Route::_(
			RouteHelper::getCategoryRoute($displayData['item']->parent_id, $displayData['item']->parent_language)
			)
			. '" itemprop="genre" data-toggle="tooltip" title="' . Text::sprintf('COM_CONTENT_PARENT', '') . '">' . $title . '</a>'; ?>
		<?php echo Text::sprintf('COM_CONTENT_PARENT', $url); ?>
	<?php }  ?>
	
	
	<?php else : ?>
		<?php echo '<span itemprop="genre" data-toggle="tooltip" title="' . JText::sprintf('COM_CONTENT_PARENT', '') . '">' . $title . '</span>'; ?>
	<?php endif; ?>
</dd>