<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

$element_options	= RSPageBuilderHelper::escapeHtmlArray($displayData['options']);
$class				= 'rspbld-vertical-icon-box';
$button_class		= 'rspbld-button btn';
$title_show			= (!isset($element_options['title_show']) || (isset($element_options['title_show']) && ($element_options['title_show'] == '1'))) ? '1' : '0';
$subtitle_show		= (!isset($element_options['subtitle_show']) || (isset($element_options['subtitle_show']) && ($element_options['subtitle_show'] == '1'))) ? '1' : '0';
$style				= array();

// Vertical Icon Box title
if (!empty($element_options['title']) && !empty($title_show)) {
	
	// Vertical Icon Box title style
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

// Vertical Icon Box subtitle
if (!empty($element_options['subtitle']) && !empty($subtitle_show)) {
	
	// Vertical Icon Box subtitle style
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

// Vertical Icon Box icon
if (!empty($element_options['icon'])) {
	
	// Vertical Icon Box icon style
	$icon_style = array();
	
	if (!empty($element_options['icon_font_size'])) {
		$icon_style['font-size'] = $element_options['icon_font_size'];
	}
	if (!empty($element_options['icon_color'])) {
		$icon_style['color'] = $element_options['icon_color'];
	}
	if (!empty($element_options['icon_background_color'])) {
		$icon_style['background-color'] = $element_options['icon_background_color'];
	}
	if (!empty($element_options['icon_margin'])) {
		$icon_style['margin'] = $element_options['icon_margin'];
	}
	if (!empty($element_options['icon_padding'])) {
		$icon_style['padding'] = $element_options['icon_padding'];
	}
}

// Vertical Icon Box content
if (!empty($element_options['content'])) {
	
	// Vertical Icon Box content style
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

// Vertical Icon Box button
if ((!empty($element_options['button_text']) || !empty($element_options['button_icon'])) && !empty($element_options['button_url'])) {
	if (!empty($element_options['button_size'])) {
		switch ($element_options['button_size']) {
			case 'mini':
				$element_options['button_size'] = 'xs';
			break;
			case 'small':
				$element_options['button_size'] = 'sm';
			break;
			case 'large':
				$element_options['button_size'] = 'lg';
			break;
		}
		
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

// Vertical Icon Box style
if (!empty($element_options['box_background_color'])) {
	$style['background-color'] = $element_options['box_background_color'];
}
if (!empty($element_options['box_margin'])) {
	$style['margin'] = $element_options['box_margin'];
}
if (!empty($element_options['box_padding'])) {
	$style['padding'] = $element_options['box_padding'];
}

// Vertical Icon Box alignment
if (!empty($element_options['box_alignment'])) {
	$class .= ' '.$element_options['box_alignment'];
}

// Vertical Icon Box class
if (!empty($element_options['class'])) {
	$class .= ' '.$element_options['class'];
}

// Build Vertical Icon Box HTML
if ((!empty($element_options['title']) && !empty($title_show)) || (!empty($element_options['subtitle']) && !empty($subtitle_show)) || !empty($element_options['icon']) || !empty($element_options['content'])) {
?>
<div class="<?php echo $class;?>"<?php echo RSPageBuilderHelper::buildStyle($style); ?>>
	<?php
	if (!empty($element_options['icon_position'])) {
		switch ($element_options['icon_position']) {
			case 'before-title':
	?>
	
	<?php if (!empty($element_options['icon'])) { ?>
	<div class="rspbld-icon"<?php echo RSPageBuilderHelper::buildStyle($icon_style); ?>>
		<i class="fa fa-<?php echo $element_options['icon']; ?>"></i>
	</div>
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
	
	<?php if (!empty($element_options['content'])) { ?>
	<div class="rspbld-content"<?php echo RSPageBuilderHelper::buildStyle($content_style); ?>>
		<?php echo $element_options['content']; ?>
	</div>
	<?php } ?>
	
	<?php if ((!empty($element_options['button_text']) || !empty($element_options['button_icon'])) && !empty($element_options['button_url'])) { ?>
		<div class="rspbld-button-container">
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
		</div>
	<?php } ?>
	
	<?php
			break;
			case 'after-title':
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
	
	<?php if (!empty($element_options['icon'])) { ?>
	<div class="rspbld-icon"<?php echo RSPageBuilderHelper::buildStyle($icon_style); ?>>
		<i class="fa fa-<?php echo $element_options['icon']; ?>"></i>
	</div>
	<?php } ?>
	
	<?php if (!empty($element_options['content'])) { ?>
	<div class="rspbld-content"<?php echo RSPageBuilderHelper::buildStyle($content_style); ?>>
		<?php echo $element_options['content']; ?>
	</div>
	<?php } ?>
	
	<?php if ((!empty($element_options['button_text']) || !empty($element_options['button_icon'])) && !empty($element_options['button_url'])) { ?>
		<div class="rspbld-button-container">
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
		</div>
	<?php } ?>
	
	<?php
			break;
			case 'after-content':
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
	
	<?php if (!empty($element_options['content'])) { ?>
	<div class="rspbld-content"<?php echo RSPageBuilderHelper::buildStyle($content_style); ?>>
		<?php echo $element_options['content']; ?>
	</div>
	<?php } ?>
	
	<?php if ((!empty($element_options['button_text']) || !empty($element_options['button_icon'])) && !empty($element_options['button_url'])) { ?>
		<div class="rspbld-button-container">
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
		</div>
	<?php } ?>
	
	<?php if (!empty($element_options['icon'])) { ?>
	<div class="rspbld-icon"<?php echo RSPageBuilderHelper::buildStyle($icon_style); ?>>
		<i class="fa fa-<?php echo $element_options['icon']; ?>"></i>
	</div>
	<?php } ?>
	
	<?php
			break;
		}
	}
	?>
</div>
<?php } ?>