<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

$element_options	= RSPageBuilderHelper::escapeHtmlArray($displayData['options']);
$class				= 'rspbld-image';
$style				= array();
$image_prefix		= RSPageBuilderHelper::getClient('site') ? '' : '../';

// Image
if (!empty($element_options['image'])) {
	
	// Image style
	$style = array();
	
	if (!empty($element_options['height'])) {
		$style['height'] = $element_options['height'];
	}
	if (!empty($element_options['width'])) {
		$style['width'] = $element_options['width'];
	}
	if (!empty($element_options['background_color'])) {
		$style['background-color'] = $element_options['background_color'];
	}
	if (!empty($element_options['border_style'])) {
		$style['border-style'] = $element_options['border_style'];
		
		if (!empty($element_options['border_width'])) {
			$style['border-width'] = $element_options['border_width'];
		}
		if (!empty($element_options['border_color'])) {
			$style['border-color'] = $element_options['border_color'];
		}
		if (!empty($element_options['border_radius'])) {
			$style['border-radius'] = $element_options['border_radius'];
		}
	}
	if (!empty($element_options['margin'])) {
		$style['margin'] = $element_options['margin'];
	}
	if (!empty($element_options['padding'])) {
		$style['padding'] = $element_options['padding'];
	}
	
	// Image alignment
	if (!empty($element_options['alignment'])) {
		$class .= ' '.$element_options['alignment'];
	}
	
	// Image URL target
	$url_target = '';
	if (!empty($element_options['target'])) {
		$url_target = ' target="' . $element_options['target'] . '"';
	}
	
	// Image ALT text
	if (!empty($element_options['alt_text'])) {
		$element_options['alt_text'] = ' alt="'.$element_options['alt_text'].'"';
	}
	
	// Image class
	if (!empty($element_options['class'])) {
		$class .= ' '.$element_options['class'];
	}
	
	// Load Image gallery scripts
	if (!empty($element_options['tag'])) {
		RSPageBuilderHelper::loadAsset('component', 'magnific-popup.css');
		RSPageBuilderHelper::loadAsset('component', 'jquery.magnific-popup.min.js');
	}
	
	// Build Image HTML
?>

<div class="<?php echo $class; ?>"<?php echo RSPageBuilderHelper::buildStyle($style); ?>>
	<?php if (!empty($element_options['url'])) { ?>
	<a href="<?php echo $element_options['url']; ?>"<?php echo $url_target; ?>>
	<?php } else if (empty($element_options['url']) && (!empty($element_options['tag']) && RSPageBuilderHelper::getClient('site'))) { ?>
	<a class="rspbld-magnific-popup" href="<?php echo $element_options['image']; ?>" data-tag="<?php echo $element_options['tag']; ?>" title="<?php echo $element_options['caption']; ?>">
	<?php  } ?>
	
	<img src="<?php echo $image_prefix.$element_options['image']; ?>"<?php echo $element_options['alt_text']; ?>>
	
	<?php if (!empty($element_options['url']) || (!empty($element_options['tag']) && RSPageBuilderHelper::getClient('site'))) { ?>
	</a>
	<?php } ?>
	
	<?php if (!empty($element_options['caption'])) { ?>
	<span class="rspbld-image-caption"><?php echo $element_options['caption']; ?></span>
	<?php } ?>
</div>
<?php } ?>