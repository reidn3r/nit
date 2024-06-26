<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

$doc				= JFactory::getDocument();
$google_api_key		= JComponentHelper::getParams('com_rspagebuilder')->get('google_api_key');
$element_options	= RSPageBuilderHelper::escapeHtmlArray($displayData['options']);
$class				= 'rspbld-google-map';
$markers			= $displayData['items'];
$id					= RSPageBuilderHelper::randomNumber();
$title_show			= (!isset($element_options['title_show']) || (isset($element_options['title_show']) && ($element_options['title_show'] == '1'))) ? '1' : '0';
$subtitle_show		= (!isset($element_options['subtitle_show']) || (isset($element_options['subtitle_show']) && ($element_options['subtitle_show'] == '1'))) ? '1' : '0';
$style				= array();
$map_style			= array();

// Google Map title
if (!empty($element_options['title']) && !empty($title_show)) {
	
	// Google Map title style
	$title_style	= array();
	$id				= RSPageBuilderHelper::createId($element_options['title'], $id);
	
	if (!empty($element_options['title_font_size'])) {
		$title_style['font-size'] = $element_options['title_font_size'];
	}
	if (!empty($element_options['title_font_weight'])) {
		$title_style['font-weight'] = $element_options['title_font_weight'];
	}
	if (!empty($element_options['title_text_color'])) {
		$title_style['color'] = $element_options['title_text_color'];
	}
	if (!empty($element_options['title_margin'])) {
		$title_style['margin'] = $element_options['title_margin'];
	}
	if (!empty($element_options['title_padding'])) {
		$title_style['padding'] = $element_options['title_padding'];
	}
}

// Google Map subtitle
if (!empty($element_options['subtitle']) && !empty($subtitle_show)) {
	
	// Google Map subtitle style
	$subtitle_style	= array();
	
	if (!empty($element_options['subtitle_font_size'])) {
		$subtitle_style['font-size'] = $element_options['subtitle_font_size'];
	}
	if (!empty($element_options['subtitle_font_weight'])) {
		$subtitle_style['font-weight'] = $element_options['subtitle_font_weight'];
	}
	if (!empty($element_options['subtitle_text_color'])) {
		$subtitle_style['color'] = $element_options['subtitle_text_color'];
	}
	if (!empty($element_options['subtitle_margin'])) {
		$subtitle_style['margin'] = $element_options['subtitle_margin'];
	}
	if (!empty($element_options['subtitle_padding'])) {
		$subtitle_style['padding'] = $element_options['subtitle_padding'];
	}
}

// Google Map style
if (!empty($element_options['height'])) {
	$map_style['height'] = $element_options['height'];
}
if (!empty($element_options['width'])) {
	$map_style['width'] = $element_options['width'];
}

// Google Map container style
if (!empty($element_options['margin'])) {
	$style['margin'] = $element_options['margin'];
}
if (!empty($element_options['padding'])) {
	$style['padding'] = $element_options['padding'];
}

// Google Map class
if (!empty($element_options['class'])) {
	$class .= ' '.$element_options['class'];
}

if (!empty($google_api_key)) {
	
	// Load Google Map script
	$doc->addScript('https://maps.google.com/maps/api/js?key=' . $google_api_key . '&callback=RSPageBuilder.initGoogleMap', array(), array('async' => 'async', 'defer' => 'defer'));
	
	// Add Google Map script
	$doc->addScriptDeclaration('jQuery(function() {
		setTimeout(function() {
			RSPageBuilder.initGoogleMap(\'' . $id . '\',' . json_encode($displayData) . ')
		}, 1000); });');
	
	// Build Google Map HTML
	if ((!empty($element_options['title']) && !empty($title_show)) || !empty($markers)) {
?>
	<div class="<?php echo $class; ?>"<?php echo RSPageBuilderHelper::buildStyle($style); ?>>
		<?php if (!empty($element_options['title']) && !empty($title_show)) { ?>
		<<?php echo $element_options['title_heading']; ?> class="rspbld-title"<?php echo RSPageBuilderHelper::buildStyle($title_style); ?>>
			<?php echo $element_options['title']; ?>
		</<?php echo $element_options['title_heading']; ?>>
		
		<?php if (!empty($element_options['subtitle']) && !empty($subtitle_show)) { ?>
		<<?php echo $element_options['subtitle_heading']; ?> class="rspbld-subtitle"<?php echo RSPageBuilderHelper::buildStyle($subtitle_style); ?>>
			<?php echo $element_options['subtitle']; ?>
		</<?php echo $element_options['subtitle_heading']; ?>>
		<?php } ?>
		
		<?php } ?>
		<div id="<?php echo $id; ?>" class="map"<?php echo RSPageBuilderHelper::buildStyle($map_style); ?>></div>
	</div>
<?php
	}
} else {
	echo '<div class="rspbld-error alert alert-danger">'.JText::_('COM_RSPAGEBUILDER_GOOGLE_NO_API_KEY_ERROR').'</div>';
}
?>