<?php
/**
 * Flex @package Helix Ultimate Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

// get item params and decode it
$item_decode = json_decode($item->getParams());

$title      = $item->anchor_title ? ' title="' . $item->anchor_title . '"' : '';
$anchor_css = $item->anchor_css ?: '';
$linktype   = $item->title;

if ($item->menu_icon)
{
	// The link is an icon
	if ($itemParams->get('menu_text', 1))
	{
		// If the link text is to be displayed, the icon is added with aria-hidden
		$linktype = '<span class="p-2 ' . $item->menu_icon . '" aria-hidden="true"></span>' . $item->title;
	}
	else
	{
		// If the icon itself is the link, it needs a visually hidden text
		$linktype = '<span class="p-2 ' . $item->menu_icon . '" aria-hidden="true"></span><span class="visually-hidden">' . $item->title . '</span>';
	}
}
elseif ($item->menu_image)
{
	// The link is an image, maybe with its own class
	$image_attributes = [];

	if ($item->menu_image_css)
	{
		$image_attributes['class'] = $item->menu_image_css;
	}

	$linktype = HTMLHelper::_('image', $item->menu_image, $item->title, $image_attributes);

	if ($itemParams->get('menu_text', 1))
	{
		$linktype .= '<span class="image-title">' . $item->title . '</span>';
	}
}
//Add Menu Pixeden Icon (for Flex)
if (isset($item_decode->peicon) && $item_decode->peicon) {
	$icon = ' <i class="pe ' . $item_decode->peicon . '"></i>';
} else {
	// FontAwesome icon
	
	if (isset($item_decode->icon) && $item_decode->icon) {
		
		if(strpos($item_decode->icon, "fab") !== false || strpos($item_decode->icon, "fas") !== false || strpos($item_decode->icon, "far") !== false) {
			// FontAwesome 5
			$fa_icon = str_replace("fa ", "", $item_decode->icon);
		} else {
			// FontAwesome 4
			$fa_icon = 'fa ' . $item_decode->icon;
		}
		
		$icon = ' <i class="' . $fa_icon . '"></i>';
	}
	
}

?>
<span class="nav-header separator <?php echo $anchor_css; ?>"<?php echo $title; ?>><?php echo $icon . ' ' . $linktype; ?></span>
