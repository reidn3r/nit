<?php
/**
 * Flex @package Helix Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Layout\LayoutHelper;
//use Joomla\CMS\Language\Text;

$params = Factory::getApplication()->getTemplate(true)->params;

if( ( $params->get('commenting_engine') != 'disabled' ) && ( $params->get('comments_count') ) ) {
	
	$url = Route::_(ContentHelperRoute::getArticleRoute($displayData['item']->id . ':' . $displayData['item']->alias, $displayData['item']->catid, $displayData['item']->language));
	$root = Uri::base();
	$root = new Uri($root);
	$url = $root->getScheme() . '://' . $root->getHost() . $url;

	?>
	<dd class="comment">
		<i class="fa fa-comments-o"></i>
		<?php echo LayoutHelper::render( 'joomla.content.comments.engine.count.' . $params->get('commenting_engine'), array( 'item'=>$displayData, 'params'=>$params, 'url'=>$url ) ); ?>
	</dd>
	<?php

}