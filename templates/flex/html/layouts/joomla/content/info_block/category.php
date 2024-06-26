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
<dd class="category-name">
	<i class="far fa-folder-open" aria-hidden="true"></i>
	<?php $title = $this->escape($displayData['item']->category_title); ?>
	<?php if ($displayData['params']->get('link_category') && !empty($displayData['item']->catid)) : ?>
	
	 <?php if (JVERSION < 4) {  ?>
		<?php echo '<a href="' . Route::_(ContentHelperRoute::getCategoryRoute($displayData['item']->catslug)) . '" itemprop="genre" data-toggle="tooltip" title="' . Text::_('COM_CONTENT_CONTENT_TYPE_CATEGORY') . '">' . $title . '</a>'; ?>	
	<?php } else { ?>
		<?php $url = '<a href="' . Route::_(
			RouteHelper::getCategoryRoute($displayData['item']->catid, $displayData['item']->category_language)
			)
			. '" itemprop="genre" data-toggle="tooltip" data-bs-toggle="tooltip" title="'. Text::_('COM_CONTENT_CONTENT_TYPE_CATEGORY') .'">' . $title . '</a>'; ?>
		<?php echo Text::sprintf('COM_CONTENT_CATEGORY', $url); ?>
	<?php }  ?>
	
	<?php else : ?>
		<?php echo Text::sprintf('COM_CONTENT_CATEGORY', '<span itemprop="genre" data-toggle="tooltip" data-bs-toggle="tooltip" title="'. Text::_('COM_CONTENT_CONTENT_TYPE_CATEGORY') .'">' . $title . '</span>'); ?>
	<?php endif; ?>
</dd>