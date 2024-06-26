<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

$element_options	= RSPageBuilderHelper::escapeHtmlArray($displayData['options']);
$class				= 'rspbld-animated-number';
$limit				= '';
$separator			= '';
$animation_duration	= '';
$animation_delay	= '';
$title_show			= (!isset($element_options['title_show']) || (isset($element_options['title_show']) && ($element_options['title_show'] == '1'))) ? '1' : '0';
$subtitle_show		= (!isset($element_options['subtitle_show']) || (isset($element_options['subtitle_show']) && ($element_options['subtitle_show'] == '1'))) ? '1' : '0';
$title_style		= array();
$number_style		= array();

// Animated Number title
if (!empty($element_options['title']) && !empty($title_show)) {
	
	// Animated Number title style
	$title_style = array();
	
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

// Animated Number subtitle
if (!empty($element_options['subtitle']) && !empty($subtitle_show)) {
	
	// Animated Number subtitle style
	$subtitle_style = array();
	
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

// Animated Number limit
if (!empty($element_options['limit'])) {
	$limit = ' data-limit="' . $element_options['limit'] . '"';
	
	// Animated Number separator
	$separator = ' data-separator="' . $element_options['separator'] . '"';
	
	// Animated Number animation duration
	$animation_duration = ' data-duration="' . $element_options['animation_duration'] . '"';
	
	// Animated Number animation delay
	$animation_delay = ' data-delay="' . $element_options['animation_delay'] . '"';
	
	// Animated Number number style
	if (!empty($element_options['number_font_size'])) {
		$number_style['font-size'] = $element_options['number_font_size'];
	}
	if (!empty($element_options['number_font_weight'])) {
		$number_style['font-weight'] = $element_options['number_font_weight'];
	}
	if (!empty($element_options['number_text_color'])) {
		$number_style['color'] = $element_options['number_text_color'];
	}
	if (!empty($element_options['number_background_color'])) {
		$number_style['background-color'] = $element_options['number_background_color'];
	}
	if (!empty($element_options['number_margin'])) {
		$number_style['margin'] = $element_options['number_margin'];
	}
	if (!empty($element_options['number_padding'])) {
		$number_style['padding'] = $element_options['number_padding'];
	}
	
	// Load Animated Number scripts
	RSPageBuilderHelper::loadAsset('component', 'jquery.visible.min.js');
	RSPageBuilderHelper::loadAsset('component', 'jquery.animateNumber.min.js');
}

// Animated Number alignment
if (!empty($element_options['alignment'])) {
	$class .= ' '.$element_options['alignment'];
}

// Animated Number class
if (!empty($element_options['class'])) {
	$class .= ' '.$element_options['class'];
}

// Build Animated Number content HTML
if (!empty($element_options['limit']) || (!empty($element_options['title']) && !empty($title_show)) || (!empty($element_options['subtitle']) && !empty($subtitle_show))) {
?>

<div class="<?php echo $class; ?>">
	<?php
	if (!empty($element_options['number_position'])) {
		switch ($element_options['number_position']) {
			case 'after-number':
	?>
	<?php if (!empty($element_options['title']) && !empty($title_show)) { ?>
	<<?php echo $element_options['title_heading']; ?> class="rspbld-title"<?php echo RSPageBuilderHelper::buildStyle($title_style); ?>>
		<?php echo $element_options['title']; ?>
	</<?php echo $element_options['title_heading']; ?>>
	<?php } ?>
	
	<?php if (!empty($element_options['subtitle']) && !empty($subtitle_show)) { ?>
	<<?php echo $element_options['subtitle_heading']; ?> class="rspbld-subtitle"<?php echo RSPageBuilderHelper::buildStyle($subtitle_style); ?>>
		<?php echo $element_options['subtitle']; ?>
	</<?php echo $element_options['subtitle_heading']; ?>>
	<?php } ?>
	
	<?php if (!empty($element_options['limit'])) { ?>
	<div class="rspbld-number"<?php echo RSPageBuilderHelper::buildStyle($number_style) . $limit . $separator . $animation_duration . $animation_delay; ?>>0</div>
	<?php } ?>
	<?php
			break;
			case 'before-number':
	?>
	<?php if (!empty($element_options['limit'])) { ?>
	<div class="rspbld-number"<?php echo RSPageBuilderHelper::buildStyle($number_style) . $limit . $separator . $animation_duration . $animation_delay; ?>>0</div>
	<?php } ?>
	
	<?php if (!empty($element_options['title']) && !empty($title_show)) { ?>
	<<?php echo $element_options['title_heading']; ?> class="rspbld-title"<?php echo RSPageBuilderHelper::buildStyle($title_style); ?>>
		<?php echo $element_options['title']; ?>
	</<?php echo $element_options['title_heading']; ?>>
	<?php } ?>

	<?php if (!empty($element_options['subtitle']) && !empty($subtitle_show)) { ?>
	<<?php echo $element_options['subtitle_heading']; ?> class="rspbld-subtitle"<?php echo RSPageBuilderHelper::buildStyle($subtitle_style); ?>>
		<?php echo $element_options['subtitle']; ?>
	</<?php echo $element_options['subtitle_heading']; ?>>
	<?php } ?>
	<?php
			break;
		}
	}
	?>
</div>
<?php } ?>