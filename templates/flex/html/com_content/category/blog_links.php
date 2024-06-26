<?php
/**
 * Flex @package Helix Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Router\Route;
use Joomla\Component\Content\Site\Helper\RouteHelper;
?>
<ol class="clearfix">
<?php foreach ($this->link_items as &$item) : 
	if (JVERSION < 4) {
		$link = Route::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid, $item->language));
	} else {
		$link = Route::_(RouteHelper::getArticleRoute($item->slug, $item->catid, $item->language));
	}
	?>
	<li>
    	<a href="<?php echo $link; ?>"><?php echo $item->title; ?></a>
	</li>
<?php endforeach; ?>
</ol>