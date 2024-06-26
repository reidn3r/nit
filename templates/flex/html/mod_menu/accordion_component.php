<?php
/**
 * Flex @package Helix Ultimate Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Filter\OutputFilter;
use Joomla\CMS\HTML\HTMLHelper;

// get item params and decode it
$item_decode = json_decode($item->getParams());

$attributes = array();

if ($item->anchor_title)
{
	$attributes['title'] = $item->anchor_title;
}

if ($item->anchor_css)
{
	$attributes['class'] = $item->anchor_css;
}

if ($item->anchor_rel)
{
	$attributes['rel'] = $item->anchor_rel;
}

if ($item->id == $active_id)
{
	$attributes['aria-current'] = 'location';
	

	if ($item->current)
	{
		$attributes['aria-current'] = 'page';
	}
} 

$linktype = $item->title;

if ($item->menu_image)
{
	if ($item->menu_image_css)
	{
		$image_attributes['class'] = $item->menu_image_css;
		$linktype = HTMLHelper::_('image', $item->menu_image, $item->title, $image_attributes);
	}
	else
	{
		$linktype = HTMLHelper::_('image', $item->menu_image, $item->title);
	}

	if ($itemParams->get('menu_text', 1))
	{
		$linktype .= '<span class="image-title">' . $item->title . '</span>';
	}
}

$icon = '';
	
//Add Menu Pixeden Icon (for Flex)
if (isset($item_decode->peicon) && $item_decode->peicon) {
	$icon = ' <i class="pe ' . $item_decode->peicon . '" aria-hidden="true"></i>';
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
		
		$icon = ' <i class="' . $fa_icon . '" aria-hidden="true"></i>';
	}
	
}

if ($item->browserNav == 1)
{
	$attributes['target'] = '_blank';
}
elseif ($item->browserNav == 2)
{
	$options = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes';

	$attributes['onclick'] = "window.open(this.href, 'targetWindow', '" . $options . "'); return false;";
}

echo HTMLHelper::_('link', OutputFilter::ampReplace(htmlspecialchars($item->flink, ENT_COMPAT, 'UTF-8', false)), $icon . ' ' . $linktype, $attributes);

$expanded = '';	
$collapsed = '';

if (in_array($item->id, $path)) {
	$expanded .= 'true';
	$collapsed = '';
		
	} else {
	$expanded .= 'false';
	$collapsed = ' collapsed';
}


if($item->deeper) {
	echo '<span class="accordion-menu-toggler' . $collapsed . '" data-bs-toggle="collapse" data-bs-target="#collapse-menu-'. $item->id .'-'.$module->id.'" role="button" aria-expanded="' . $expanded . '" aria-controls="collapse-menu-'. $item->id .'-'.$module->id.'"><i class="open-icon fas fa-chevron-down"></i></span>';	
} 

