<?php
/**
 * Flex @package Helix Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
defined('_JEXEC') or die;

if( $displayData['params']->get('custom_post') ) {
	echo '<div class="entry-gallery">';
	echo $displayData['params']->get('custom_post');
	echo '</div>';
}

