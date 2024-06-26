<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

$element_options	= RSPageBuilderHelper::escapeHtmlArray($displayData['options']);
$class				= 'rspbld-button btn';
$style				= array();

// Button text
if (!empty($element_options['text'])) {
	if (!empty($element_options['text_font_size'])) {
		$style['font-size'] = $element_options['text_font_size'];
	}
	if (!empty($element_options['text_font_weight'])) {
		$style['font-weight'] = $element_options['text_font_weight'];
	}
	if (!empty($element_options['text_color'])) {
		$style['color'] = $element_options['text_color'];
	}
}

// Button icon
if (!empty($element_options['icon'])) {
	$icon_style = array();
	
	if (!empty($element_options['icon_font_size'])) {
		$icon_style['font-size'] = $element_options['icon_font_size'];
	}
	if (!empty($element_options['icon_color'])) {
		$icon_style['color'] = $element_options['icon_color'];
	}
}

// Button style
if (!empty($element_options['margin'])) {
	$style['margin'] = $element_options['margin'];
}
if (!empty($element_options['padding'])) {
	$style['padding'] = $element_options['padding'];
}

// Button settings
if (!empty($element_options['button_size'])) {
	$class .= ' btn-'.$element_options['button_size'];
}
if (!empty($element_options['button_type'])) {
	$class .= ' btn-'.$element_options['button_type'];
}
if (!empty($element_options['button_full_width'])) {
	$class .= ' btn-block';
}

// Button class
if (!empty($element_options['class'])) {
	$class .= ' '.$element_options['class'];
}

// Build Button HTML
if (!empty($element_options['text']) || !empty($element_options['icon'])) {
	if (empty($element_options['inline'])) {
?>

<div class="rspbld-button-container<?php echo !empty($element_options['alignment']) ? ' ' . $element_options['alignment'] : ''; ?>">
<?php } ?>
	<a class="<?php echo $class; ?>"
		<?php echo RSPageBuilderHelper::buildStyle($style); ?>

		<?php if (!empty($element_options['url'])) { ?>
			href="<?php echo $element_options['url']; ?>"
		<?php } ?>

		<?php if (!empty($element_options['target'])) { ?>
			target="<?php echo $element_options['target']; ?>"
		<?php } ?>
		>
		<?php if (!empty($element_options['icon'])) { ?>
		<i class="fa fa-<?php echo $element_options['icon']; ?>"<?php echo RSPageBuilderHelper::buildStyle($icon_style); ?>></i>
		<?php } ?>

		<?php
		if (!empty($element_options['text'])) {
			echo $element_options['text'];
		}
		?>
	</a>
<?php if (empty($element_options['inline'])) { ?>
</div>
<?php
	}
}
?>