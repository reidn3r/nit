<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

$element_options	= RSPageBuilderHelper::escapeHtmlArray($displayData['options']);
$class				= 'rspbld-text-block';
$button_class		= 'rspbld-button btn';
$title_show			= (!isset($element_options['title_show']) || (isset($element_options['title_show']) && ($element_options['title_show'] == '1'))) ? '1' : '0';
$subtitle_show		= (!isset($element_options['subtitle_show']) || (isset($element_options['subtitle_show']) && ($element_options['subtitle_show'] == '1'))) ? '1' : '0';
$style				= array();

// Text Block title
if (!empty($element_options['title']) && !empty($title_show)) {
	
	// Text Block title style
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

// Text Block subtitle
if (!empty($element_options['subtitle']) && !empty($subtitle_show)) {
	
	// Text Block subtitle style
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

// Text Block content
if (!empty($element_options['content'])) {
	
	// Text Block content style
	$content_style = array();
	
	if (!empty($element_options['content_text_color'])) {
		$content_style['color'] = $element_options['content_text_color'];
	}
	if (!empty($element_options['content_margin'])) {
		$content_style['margin'] = $element_options['content_margin'];
	}
	if (!empty($element_options['content_padding'])) {
		$content_style['padding'] = $element_options['content_padding'];
	}
}

// Text Block button
if ((!empty($element_options['button_text']) || !empty($element_options['button_icon'])) && !empty($element_options['button_url'])) {
	if (!empty($element_options['button_size'])) {
		$button_class .= ' btn-'.$element_options['button_size'];
	}
	if (!empty($element_options['button_type'])) {
		$button_class .= ' btn-'.$element_options['button_type'];
	}
	
	// Button target
	$button_target = '';
	if (!empty($element_options['button_target'])) {
		$button_target = ' target="' . $element_options['button_target'] . '"';
	}
	
	// Load button style
	RSPageBuilderHelper::loadAsset('element', 'button.css');
}

// Text Block style
if (!empty($element_options['background_color'])) {
	$style['background-color'] = $element_options['background_color'];
}
if (!empty($element_options['margin'])) {
	$style['margin'] = $element_options['margin'];
}
if (!empty($element_options['padding'])) {
	$style['padding'] = $element_options['padding'];
}

// Text Block alignment
if (!empty($element_options['alignment'])) {
	$class .= ' '.$element_options['alignment'];
}

// Text Block class
if (!empty($element_options['class'])) {
	$class .= ' '.$element_options['class'];
}

// Build Text Block HTML
?>

<div class="<?php echo $class; ?>"<?php echo RSPageBuilderHelper::buildStyle($style); ?>>
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
	
	<?php if (!empty($element_options['content'])) { ?>
	<div class="rspbld-content"<?php echo RSPageBuilderHelper::buildStyle($content_style); ?>>
	<?php echo $element_options['content']; ?>
	</div>
	<?php } ?>
	
	<?php if ((!empty($element_options['button_text']) || !empty($element_options['button_icon'])) && !empty($element_options['button_url'])) { ?>
	<a href="<?php echo $element_options['button_url']; ?>"<?php echo $button_target; ?> class="<?php echo $button_class; ?>">
		<?php if (!empty($element_options['button_icon'])) { ?>
			<i class="fa fa-<?php echo $element_options['button_icon']; ?>"></i>
		<?php } ?>
		<?php
		if (!empty($element_options['button_text'])) {
			echo $element_options['button_text'];
		}
		?>
	</a>
	<?php } ?>
</div>