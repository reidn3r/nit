<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

$element_options	= RSPageBuilderHelper::escapeHtmlArray($displayData['options']);
$class				= 'rspbld-divider';
$style				= array();
$image_prefix		= RSPageBuilderHelper::getClient('site') ? '' : '../';

// Divider settings
if (!empty($element_options['divider_type'])) {
	switch ($element_options['divider_type']) {
		case 'border':
			if (!empty($element_options['border_side'])) {
				$element_options['border_side'] = $element_options['border_side'].'-';
			}
			if (!empty($element_options['border_width'])) {
				$style['border-'.$element_options['border_side'].'width'] = $element_options['border_width'];
			}
			if (!empty($element_options['border_style'])) {
				$style['border-'.$element_options['border_side'].'style'] = $element_options['border_style'];
			}
			if (!empty($element_options['border_color'])) {
				$style['border-'.$element_options['border_side'].'color'] = $element_options['border_color'];
			}
		break;
		case 'image':
			if (!empty($element_options['background_image'])) {
				$style['background-image'] = $element_options['background_image'];
				
				if (!empty($element_options['background_repeat'])) {
					$style['background-repeat'] = $element_options['background_repeat'];
				}
				if (!empty($element_options['background_size'])) {
					$style['background-size'] = $element_options['background_size'];
				}
				if (!empty($element_options['background_position'])) {
					$style['background-position'] = str_replace('-', ' ', $element_options['background_position']);
				}
			}
		break;
	}
	
	// Divider style
	if (!empty($element_options['height'])) {
		$style['height'] = $element_options['height'];
	}
	if (!empty($element_options['margin'])) {
		$style['margin'] = $element_options['margin'];
	}
	if (!empty($element_options['padding'])) {
		$style['padding'] = $element_options['padding'];
	}

	// Divider class
	if (!empty($element_options['class'])) {
		$class .= ' '.$element_options['class'];
	}

// Build Divider HTML
?>

<div class="<?php echo $class; ?>"<?php echo RSPageBuilderHelper::buildStyle($style); ?>></div>
<?php } ?>