<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

$element_options	= RSPageBuilderHelper::escapeHtmlArray($displayData['options']);
$items				= $displayData['items'];
$class				= 'rspbld-progress-circles';
$title_show			= (!isset($element_options['title_show']) || (isset($element_options['title_show']) && ($element_options['title_show'] == '1'))) ? '1' : '0';
$subtitle_show		= (!isset($element_options['subtitle_show']) || (isset($element_options['subtitle_show']) && ($element_options['subtitle_show'] == '1'))) ? '1' : '0';
$animation_duration	= '';
$animation_delay	= '';

// Progress Circles title
if (!empty($element_options['title']) && !empty($title_show)) {
	
	// Progress Circles title style
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

// Progress Circles subtitle
if (!empty($element_options['subtitle']) && !empty($subtitle_show)) {
	
	// Progress Circles subtitle style
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

// Progress Circles alignment
if (!empty($element_options['alignment'])) {
	$class .= ' '.$element_options['alignment'];
}

// Progress Circles class
if (!empty($element_options['class'])) {
	$class .= ' '.$element_options['class'];
}

// Progress Circles animate
if (!empty($element_options['animate'])) {
	$class .= ' animate';
	
	// Progress Circles animation duration
	$animation_duration = ' data-duration="' . $element_options['animation_duration'] . '"';
	
	// Progress Circles animation delay
	$animation_delay = ' data-delay="' . $element_options['animation_delay'] . '"';
	
	// Load Progress Circles script
	RSPageBuilderHelper::loadAsset('component', 'jquery.visible.min.js');
}
// Build Progress Circles content HTML
?>

<div class="<?php echo $class; ?>"<?php echo $animation_duration.$animation_delay; ?>>
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
	if (count($items)) {
		foreach ($items as $item_index => $item) {
			$item_options				= RSPageBuilderHelper::escapeHtmlArray($item['options']);
			$item_title_show			= (!isset($item_options['item_title_show']) || (isset($item_options['item_title_show']) && ($item_options['item_title_show'] == '1'))) ? '1' : '0';
			$item_title_style			= array();
			$item_title_icon_style		= array();
			$item_style					= array();
			$item_item_wrapper_style	= array();
			$item_center_style			= array();
			$item_bar_wrapper_style		= array();
			$item_bar_style				= array();
			
			// Progress Circles item title
			if (!empty($item_options['item_title']) && !empty($item_title_show)) {
				
				// Progress Circles item title style
				if (!empty($item_options['item_title_font_size'])) {
					$item_title_style['font-size'] = $item_options['item_title_font_size'];
				}
				if (!empty($item_options['item_title_font_weight'])) {
					$item_title_style['font-weight'] = $item_options['item_title_font_weight'];
				}
				if (!empty($item_options['item_title_text_color'])) {
					$item_title_style['color'] = $item_options['item_title_text_color'];
				}
				if (!empty($item_options['item_title_margin'])) {
					$item_title_style['margin'] = $item_options['item_title_margin'];
				}
				if (!empty($item_options['item_title_padding'])) {
					$item_title_style['padding'] = $item_options['item_title_padding'];
				}
			}
			
			// Progress Circles item title icon style
			if (!empty($item_options['item_title_icon'])) {
				if (!empty($item_options['item_title_icon_font_size'])) {
					$item_title_icon_style['font-size'] = $item_options['item_title_icon_font_size'];
				}
				if (!empty($item_options['item_title_icon_color'])) {
					$item_title_icon_style['color'] = $item_options['item_title_icon_color'];
				}
			}
			
			// Progress Circles item wrapper style
			if (!empty($item_options['item_size'])) {
				$item_item_wrapper_style['height'] = $item_options['item_size'];
				$item_item_wrapper_style['width'] = $item_options['item_size'];
				
				$item_center_style['height'] = (intval(str_replace('px', '', $item_options['item_size'])) - 2 * intval(str_replace('px', '', $item_options['item_bar_height']))).'px';
				$item_center_style['line-height'] = (intval(str_replace('px', '', $item_options['item_size'])) - 2 * intval(str_replace('px', '', $item_options['item_bar_height']))).'px';
				$item_center_style['width'] = (intval(str_replace('px', '', $item_options['item_size'])) - 2 * intval(str_replace('px', '', $item_options['item_bar_height']))).'px';
				
				if ((intval(str_replace('%', '', $item_options['item_bar_width'])) < 50) || $element_options['animate']) {
					$item_bar_wrapper_style['clip'] = 'rect(0, '.$item_options['item_size'].', '.$item_options['item_size'].', '.(intval(str_replace('px', '', $item_options['item_size']))/2).'px)';
				}
				$item_bar_wrapper_style['height'] = $item_options['item_size'];
				$item_bar_wrapper_style['width'] = $item_options['item_size'];
				
				$item_bar_style['clip'] = 'rect(0, '.(intval(str_replace('px', '', $item_options['item_size']))/2).'px, '.$item_options['item_size'].', 0)';
				$item_bar_style['height'] = $item_options['item_size'];
				$item_bar_style['width'] = $item_options['item_size'];
			}
			
			// Progress Circles item bar style
			if (!empty($item_options['item_bar_width'])) {
				if (!empty($item_options['item_bar_height'])) {
					$item_bar_style['border-width'] = $item_options['item_bar_height'];
				}
				if (!empty($item_options['item_bar_fill_color'])) {
					$item_bar_style['border-color'] = $item_options['item_bar_fill_color'];
				}
				if (!empty($item_options['item_bar_color'])) {
					$item_item_wrapper_style['background-color'] = $item_options['item_bar_color'];
				}
				if ($element_options['animate']) {
					$data_width = ' data-width="0"';
				} else {
					$data_width = ' data-width="'.str_replace('%', '', $item_options['item_bar_width']).'"';
				}
				
				$data_max_width = ' data-max-width="'.str_replace('%', '', $item_options['item_bar_width']).'"';
				$data_max_value = (!empty($item_options['item_alt_value'])) ? ' data-max-value="'.$item_options['item_alt_value'].'"' : '';
			}
			
			// Progress Circle item center style
			if (!empty($item_options['item_background_color'])) {
				$item_center_style['background-color'] = $item_options['item_background_color'];
			}
			if (!empty($item_options['item_percentage_font_size'])) {
				$item_center_style['font-size'] = $item_options['item_percentage_font_size'];
			}
			if (!empty($item_options['item_percentage_color'])) {
				$item_center_style['color'] = $item_options['item_percentage_color'];
			}
			
			// Progress Circle item style
			if (!empty($item_options['item_margin'])) {
				$item_style['margin'] = $item_options['item_margin'];
			}
			if (!empty($item_options['item_padding'])) {
				$item_style['padding'] = $item_options['item_padding'];
			}
			
			// Build Progress Circles item HTML
			if (!empty($item_options['item_bar_width'])) {
				$item_value	 = (!empty($item_options['item_alt_value'])) ? $item_options['item_alt_value'] : str_replace('%', '', $item_options['item_bar_width']);
				$item_symbol = (empty($item_options['item_alt_value']) && !empty($item_options['show_item_percentage'])) ? '%' : '';
	?>
	<div class="progress-circle"<?php echo RSPageBuilderHelper::buildStyle($item_style); ?>>
		<div class="item-wrapper"<?php echo $data_width.$data_max_width.$data_max_value.RSPageBuilderHelper::buildStyle($item_item_wrapper_style); ?>>
			<div class="bar-wrapper"<?php echo RSPageBuilderHelper::buildStyle($item_bar_wrapper_style); ?>>
				<div class="bar"<?php echo RSPageBuilderHelper::buildStyle($item_bar_style); ?>></div>
				<div class="fill"<?php echo RSPageBuilderHelper::buildStyle($item_bar_style); ?>></div>
			</div>
			<span<?php echo RSPageBuilderHelper::buildStyle($item_center_style); ?>>
				<?php
					echo ($element_options['animate']) ? '0'.$item_symbol : $item_value.$item_symbol;
				?>
			</span>
		</div>
		<?php if ((!empty($item_options['item_title']) && !empty($item_title_show)) || !empty($item_options['item_title_icon'])) { ?>
		<div class="rspbld-item-title"<?php echo (!empty($item_options['item_title']) && !empty($item_title_show)) ? RSPageBuilderHelper::buildStyle($item_title_style) : ''; ?>>
			<?php if (!empty($item_options['item_title_icon'])) { ?>
			<i class="fa fa-<?php echo $item_options['item_title_icon']; ?>"<?php echo RSPageBuilderHelper::buildStyle($item_title_icon_style); ?>></i>
			<?php } ?>
			
			<?php if (!empty($item_options['item_title']) && !empty($item_title_show)) {
				echo $item_options['item_title'];
			} ?>
		</div>
		<?php } ?>
	</div>
	<?php
			}
		}
	}
	?>
</div>