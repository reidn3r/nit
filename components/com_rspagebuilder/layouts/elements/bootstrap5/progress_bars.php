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
$class				= 'rspbld-progress-bars';
$title_show			= (!isset($element_options['title_show']) || (isset($element_options['title_show']) && ($element_options['title_show'] == '1'))) ? '1' : '0';
$subtitle_show		= (!isset($element_options['subtitle_show']) || (isset($element_options['subtitle_show']) && ($element_options['subtitle_show'] == '1'))) ? '1' : '0';
$vertical_height	= '';
$animation_duration	= '';
$animation_delay	= '';

// Progress Bars title
if (!empty($element_options['title']) && !empty($title_show)) {
	
	// Progress Bars title style
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

// Progress Bars subtitle
if (!empty($element_options['subtitle']) && !empty($subtitle_show)) {
	
	// Progress Bars subtitle style
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

// Progress Bars class
if (!empty($element_options['class'])) {
	$class .= ' '.$element_options['class'];
}

// Progress Bars animate
if (!empty($element_options['animate'])) {
	$class .= ' animate';
	
	// Progress Bars animation duration
	$animation_duration = ' data-duration="' . $element_options['animation_duration'] . '"';
	
	// Progress Bars animation delay
	$animation_delay = ' data-delay="' . $element_options['animation_delay'] . '"';
	
	// Load Progress Bars script
	RSPageBuilderHelper::loadAsset('component', 'jquery.visible.min.js');
}

// Progress Bars orientation
if (!empty($element_options['orientation'])) {
	$class .= ' ' . $element_options['orientation'];
	
	if ($element_options['orientation'] == 'vertical' && !empty($element_options['vertical_height'])) {
		$vertical_height = ' style="height: ' . $element_options['vertical_height'] . ';"';
	}
}

// Build Progress Bars content HTML
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
	
	<?php if (count($items)) { ?>
	<div class="progress-container"<?php echo $vertical_height; ?>>
	<?php
		foreach ($items as $item_index => $item) {
			$item_options			= RSPageBuilderHelper::escapeHtmlArray($item['options']);
			$item_title_show		= (!isset($item_options['item_title_show']) || (isset($item_options['item_title_show']) && ($item_options['item_title_show'] == '1'))) ? '1' : '0';
			$item_title_style		= array();
			$item_title_icon_style	= array();
			$item_bar_style			= array();
			$item_style				= array();
			
			// Progress Bars item title
			if (!empty($item_options['item_title']) && !empty($item_title_show)) {
				
				// Progress Bars item title style
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
			} else if ($item_title_show == 0) {
				$item_title_style['font-size'] = 0;
			}
			
			// Progress Bars item title icon style
			if (!empty($item_options['item_title_icon'])) {
				if (!empty($item_options['item_title_icon_font_size'])) {
					$item_title_icon_style['font-size'] = $item_options['item_title_icon_font_size'];
				}
				if (!empty($item_options['item_title_icon_color'])) {
					$item_title_icon_style['color'] = $item_options['item_title_icon_color'];
				}
			}
			
			// Progress Bars item bar style
			if (!empty($item_options['item_width'])) {
				$item_bar_style['width'] = $item_options['item_width'];
				
				if (!empty($item_options['item_background_color'])) {
					$item_bar_style['background-color'] = $item_options['item_background_color'];
				}
			}
			
			// Progress Bars item style
			if (!empty($item_options['item_height'])) {
				$item_style['height'] = $item_options['item_height'];
				$item_title_style['line-height'] = $item_options['item_height'];
			}
			if (!empty($item_options['item_margin'])) {
				$item_style['margin'] = $item_options['item_margin'];
			}
			if (!empty($item_options['item_padding'])) {
				$item_style['padding'] = $item_options['item_padding'];
			}
			if (!empty($element_options['orientation']) && $element_options['orientation'] == 'vertical' && !empty($element_options['vertical_height'])) {
				$item_style['width'] = $element_options['vertical_height']; 
			}
			
			// Build Progress Bars item HTML
			if (!empty($item_options['item_width'])) {
	?>
		<div class="progress"<?php echo RSPageBuilderHelper::buildStyle($item_style); ?>>
			<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo str_replace('%', '', $item_options['item_width']); ?>" aria-valuemin="0" aria-valuemax="100"<?php echo RSPageBuilderHelper::buildStyle($item_bar_style); ?>>
				<?php if (!empty($item_options['item_title']) || !empty($item_options['item_title_icon'])) { ?>
				<div class="rspbld-item-title"<?php echo !empty($item_options['item_title']) ? RSPageBuilderHelper::buildStyle($item_title_style) : ''; ?>>
					<?php if (!empty($item_options['item_title_icon'])) { ?>
					<i class="fa fa-<?php echo $item_options['item_title_icon']; ?>"<?php echo RSPageBuilderHelper::buildStyle($item_title_icon_style); ?>></i>
					<?php } ?>
					
					<?php if (!empty($item_options['item_title'])) {
						echo $item_options['item_title'];
					} ?>
				</div>
				<?php } ?>
			</div>
		</div>
	<?php
			}
		}
	?>
	</div>
	<?php } ?>
</div>