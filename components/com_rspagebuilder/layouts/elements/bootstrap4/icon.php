<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

$element_options	= RSPageBuilderHelper::escapeHtmlArray($displayData['options']);
$class				= 'rspbld-icon';
$style				= array();

// Icon
if (!empty($element_options['icon'])) {
	
	// Icon style
	$style = array();
	
	if (!empty($element_options['font_size'])) {
		$style['font-size'] = $element_options['font_size'];
	}
	if (!empty($element_options['color'])) {
		$style['color'] = $element_options['color'];
	}
	if (!empty($element_options['background_color'])) {
		$style['background-color'] = $element_options['background_color'];
	}
	if (!empty($element_options['border_radius'])) {
		$style['border-radius'] = $element_options['border_radius'];
	}
	if (!empty($element_options['border_style'])) {
		$style['border-style'] = $element_options['border_style'];
		
		if (!empty($element_options['border_width'])) {
			$style['border-width'] = $element_options['border_width'];
		}
		if (!empty($element_options['border_color'])) {
			$style['border-color'] = $element_options['border_color'];
		}
	}
	if (!empty($element_options['margin'])) {
		$style['margin'] = $element_options['margin'];
	}
	if (!empty($element_options['padding'])) {
		$style['padding'] = $element_options['padding'];
	}
	
	// Icon alignment
	if (!empty($element_options['alignment'])) {
		$class .= ' '.$element_options['alignment'];
	}
	
	// Icon URL target
	$url_target = '';
	if (!empty($element_options['target'])) {
		$url_target = ' target="' . $element_options['target'] . '"';
	}
	
	// Icon class
	if (!empty($element_options['class'])) {
		$class .= ' '.$element_options['class'];
	}
	
	// Build Icon HTML
?>

<div class="<?php echo $class; ?>"<?php echo RSPageBuilderHelper::buildStyle($style); ?>>
	<?php if (!empty($element_options['url'])) { ?>
	<a href="<?php echo $element_options['url']; ?>"<?php echo $url_target; ?>>
	<?php } ?>
	
	<i class="fa fa-<?php echo $element_options['icon']; ?>"></i>
	
	<?php if (!empty($element_options['url'])) { ?>
	</a>
	<?php } ?>
</div>
<?php } ?>