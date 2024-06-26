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
$class				= 'rspbld-carousel';
$id					= RSPageBuilderHelper::randomNumber();
$image_prefix		= RSPageBuilderHelper::getClient('site') ? '' : '../';
$title_show			= (!isset($element_options['title_show']) || (isset($element_options['title_show']) && ($element_options['title_show'] == '1'))) ? '1' : '0';
$subtitle_show		= (!isset($element_options['subtitle_show']) || (isset($element_options['subtitle_show']) && ($element_options['subtitle_show'] == '1'))) ? '1' : '0';

// Carousel title
if (!empty($element_options['title']) && !empty($title_show)) {
	
	// Carousel title style
	$title_style	= array();
	$id				= RSPageBuilderHelper::createId(empty($element_options['title']), $id);
	
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

// Carousel subtitle
if (!empty($element_options['subtitle']) && !empty($subtitle_show)) {
	
	// Carousel subtitle style
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

// Carousel settings
if (!empty($element_options['slide_effect'])) {
	$element_options['slide_effect'] = ' '.$element_options['slide_effect'];
}
if (!empty($element_options['slide_interval'])) {
	$element_options['slide_interval'] = ' data-interval="'.$element_options['slide_interval'].'"';
} else {
	$element_options['slide_interval'] = ' data-interval="0"';
}
if (!empty($element_options['slide_swipe'])) {
	$element_options['slide_swipe'] = ' data-swipe="' . $element_options['slide_swipe'] . '"';

	RSPageBuilderHelper::loadAsset('component', 'jquery.touchSwipe.min.js');
}

// Carousel controls
if (!empty($element_options['show_controls']) && $element_options['show_controls'] == '1') {
	$controls_style = array();
	
	if (!empty($element_options['controls_font_size'])) {
		$controls_style['font-size'] = $element_options['controls_font_size'];
	}
	if (!empty($element_options['controls_size'])) {
		$controls_style['height'] = $element_options['controls_size'];
		$controls_style['width'] = $element_options['controls_size'];
	}
	if (!empty($element_options['controls_color'])) {
		$controls_style['color'] = $element_options['controls_color'];
	}
}

// Carousel class
if (!empty($element_options['one_item'])) {
	$class .= ' rspbld-one-item';
	$class .= ' items-per-slide-'.$element_options['items_per_slide'];
}
if (!empty($element_options['class'])) {
	$class .= ' '.$element_options['class'];
}

// Build Carousel HTML
?>

<div class="<?php echo $class; ?>">
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
	
	<div id="<?php echo $id; ?>" class="carousel slide<?php echo $element_options['slide_effect']; ?>"<?php echo $element_options['slide_interval'] . (isset($element_options['slide_swipe']) ? $element_options['slide_swipe'] : ''); ?>>
		<?php
		if ((!empty($element_options['show_indicators']) && $element_options['show_indicators'] == '1') && empty($element_options['one_item'])) {
			$slide = 0;
			
			if (count($items)) {
		?>
		<ol class="carousel-indicators <?php echo $element_options['indicators_position']; ?>">
			<?php
			foreach ($items as $item_index => $item) {
				$item_index++;
				
				if (($element_options['items_per_slide'] == 1) || ($item_index % $element_options['items_per_slide'] == 1)) {
					$indicators_style = array();
					
					if (!empty($element_options['indicators_color'])) {
						$indicators_style['background-color'] = $element_options['indicators_color'];
						$indicators_style['border-color'] = $element_options['indicators_color'];
					}
					if (!empty($element_options['indicators_size'])) {
						$indicators_style['height'] = $element_options['indicators_size'];
						$indicators_style['width'] = $element_options['indicators_size'];
					}
					$slide++;
			?>
			<li<?php echo (($item_index == 1) ? ' class="active"' : '') . RSPageBuilderHelper::buildStyle($indicators_style) . ' data-target="#' . $id . '" data-slide-to="' . ($slide - 1) . '"'; ?>></li>
		<?php
					}
				}
		?>
		</ol>
		<?php
			}
		}
		?>
		<div class="carousel-inner <?php echo $element_options['alignment']; ?>">
		<?php
		if (count($items)) {
			$item_span = 12 / $element_options['items_per_slide'];
			
			if (!empty($element_options['one_item']) && ($element_options['items_per_slide'] > 1)) {
				$new_items = array();
				
				foreach ($items as $item_index => $item) {
					if (count($items) >= ($item_index + $element_options['items_per_slide'])) {
						$new_items_slice = array_slice($items, $item_index, $element_options['items_per_slide']);
					} else {
						$new_items_slice_total	= 0;
						$i						= 0;
						
						while ($new_items_slice_total < $element_options['items_per_slide']) {
							if (isset($new_items_slices[$i-1]) && ($new_items_slices[$i - 1][count($new_items_slices[$i - 1]) - 1] == $items[count($items) - 1])) {
								$new_items_slices[$i] = array_slice($items, 0, $element_options['items_per_slide'] - $new_items_slice_total);
							} else {
								$new_items_slices[$i] = array_slice($items, $item_index, count($items));
							}
							
							$new_items_slice_total += count($new_items_slices[$i]);
							$i++;
						}
						
						$new_items_slice = RSPageBuilderHelper::arrayFlatten($new_items_slices);
					}
					
					$new_items = array_merge($new_items, $new_items_slice);
				}
				
				$items = $new_items;
			}
			
			foreach ($items as $item_index => $item) {
				$item_options					= RSPageBuilderHelper::escapeHtmlArray($item['options']);
				$item_class						= '';
				$item_id						= RSPageBuilderHelper::randomNumber();
				$item_button_class				= 'rspbld-button btn';
				$item_title_show				= (!isset($item_options['item_title_show']) || (isset($item_options['item_title_show']) && ($item_options['item_title_show'] == '1'))) ? '1' : '0';
				$item_image_style				= array();
				$item_background_style			= array();
				$item_background_overlay_style	= array();
				$item_title_style				= array();
				$item_content_style				= array();
				
				$item_index++;
				
				// Carousel item image
				if (!empty($item_options['item_image'])) {
					$item_image_alt_text		= '';
					$item_options['item_image']	= ' src="' . $image_prefix . $item_options['item_image'] . '"';
					
					if (!empty($item_options['item_title'])) {
						$item_image_alt_text = ' alt="'.$item_options['item_title'].'"';
					}
					
					// Carousel item image style
					if (!empty($item_options['item_image_height'])) {
						$item_image_style['height'] = $item_options['item_image_height'];
					}
					if (!empty($item_options['item_image_width'])) {
						$item_image_style['width'] = $item_options['item_image_width'];
					}
					if (!empty($item_options['item_image_margin'])) {
						$item_image_style['margin'] = $item_options['item_image_margin'];
					}
					if (!empty($item_options['item_image_padding'])) {
						$item_image_style['padding'] = $item_options['item_image_padding'];
					}
				}
				
				// Build Carousel item background style
				if (!empty($item_options['item_background_color'])) {
					$item_background_style['background-color'] = $item_options['item_background_color'];
				}
				if (!empty($item_options['item_background_image'])) {
					$item_background_style['background-image'] = $item_options['item_background_image'];
					
					if (!empty($item_options['item_background_repeat'])) {
						$item_background_style['background-repeat'] = $item_options['item_background_repeat'];
					}
					if (!empty($item_options['item_background_size'])) {
						$item_background_style['background-size'] = $item_options['item_background_size'];
					}
					if (!empty($item_options['item_background_position'])) {
						$item_background_style['background-position'] = str_replace('-', ' ', $item_options['item_background_position']);
					}
				}
				
				// Build Carousel item overlay style {
				if (!empty($item_options['item_background_overlay_color'])) {
					$item_background_overlay_style['background-color'] = $item_options['item_background_overlay_color'];
					
					if (!empty($item_options['item_background_overlay_opacity'])) {
						$item_background_overlay_style['opacity'] = $item_options['item_background_overlay_opacity'];
					}
				}
				
				// Carousel item title
				if (!empty($item_options['item_title'])) {
					$item_id = RSPageBuilderHelper::createId($item_options['item_title'], $item_id);
					
					// Carousel item title style
					if (!empty($item_options['item_title_font_size'])) {
						$item_title_style['font-size'] = $item_options['item_title_font_size'];
					}
					if (!empty($item_options['item_title_font_weight'])) {
						$item_title_style['font-weight'] = $item_options['item_title_font_weight'];
					}
					if (!empty($item_options['item_title_text_color'])) {
						$item_title_style['color'] = $item_options['item_title_text_color'];
					}
					if (!empty($item_options['item_title_background_color'])) {
						$item_title_style['background-color'] = $item_options['item_title_background_color'];
					}
					if (!empty($item_options['item_title_margin'])) {
						$item_title_style['margin'] = $item_options['item_title_margin'];
					}
					if (!empty($item_options['item_title_padding'])) {
						$item_title_style['padding'] = $item_options['item_title_padding'];
					}
				}
				
				// Carousel item content style
				if (!empty($item_options['item_content'])) {
					if ($item_options['item_content_text_color']) {
						$item_content_style['color'] = $item_options['item_content_text_color'];
					}
					if (!empty($item_options['item_content_background_color'])) {
						$item_content_style['background-color'] = $item_options['item_content_background_color'];
					}
					if (!empty($item_options['item_content_margin'])) {
						$item_content_style['margin'] = $item_options['item_content_margin'];
					}
					if (!empty($item_options['item_content_padding'])) {
						$item_content_style['padding'] = $item_options['item_content_padding'];
					}
				}
				
				// Carousel item button
				if ((!empty($item_options['button_text']) || !empty($item_options['button_icon'])) && !empty($item_options['button_url'])) {
					if (!empty($item_options['button_size'])) {
						$item_button_class .= ' btn-'.$item_options['button_size'];
					}
					if (!empty($item_options['button_type'])) {
						$item_button_class .= ' btn-'.$item_options['button_type'];
					}
					
					// Button target
					$item_button_target = '';
					if (!empty($item_options['button_target'])) {
						$item_button_target = ' target="' . $item_options['button_target'] . '"';
					}
					
					// Load button style
					RSPageBuilderHelper::loadAsset('element', 'button.css');
				}
				
				// Carousel item class
				if ($item_index == 1) {
					$item_class .= ' active';
				}
				if (($element_options['image_position'] == 'image-left') || ($element_options['image_position'] == 'image-right')) {
					$item_class .= ' horizontal-image';
				}
				
				if (($element_options['items_per_slide'] == 1) || ($item_index % $element_options['items_per_slide'] == 1)) {
		?>
			<div id="<?php echo $item_id; ?>" class="item<?php echo $item_class; ?>">
		<?php } ?>
				<div class="col-md-<?php echo $item_span;?>"<?php echo RSPageBuilderHelper::buildStyle($item_background_style); ?>>
					<div class="rspbld-item-container">
						<?php
						switch ($element_options['image_position']) {
							case 'image-left':
								if (!empty($item_options['item_image'])) {
						?>
						<div class="rspbld-image pull-left"<?php echo RSPageBuilderHelper::buildStyle($item_image_style); ?>>
							<img<?php echo $item_options['item_image'].$item_image_alt_text; ?>>
						</div>
						<?php } ?>
						
						<?php if ((!empty($item_options['item_title']) && !empty($item_title_show)) || !empty($item_options['item_content'])) { ?>
						<div class="rspbld-item-content-container">
						<?php if (!empty($item_options['item_title']) && !empty($item_title_show)) { ?>
						<<?php echo $item_options['item_title_heading']; ?> class="rspbld-item-title"<?php echo RSPageBuilderHelper::buildStyle($item_title_style); ?>>
							<?php echo $item_options['item_title']; ?>
						</<?php echo $item_options['item_title_heading']; ?>>
						<?php } ?>
						
						<?php if (!empty($item_options['item_content'])) { ?>
						<div class="rspbld-item-content"<?php echo RSPageBuilderHelper::buildStyle($item_content_style); ?>>
							<?php echo $item_options['item_content']; ?>
						</div>
						<?php } ?>
						
						<?php if ((!empty($item_options['button_text']) || !empty($item_options['button_icon'])) && !empty($item_options['button_url'])) { ?>
							<a href="<?php echo $item_options['button_url']; ?>"<?php echo $item_button_target; ?> class="<?php echo $item_button_class; ?>">
								<?php if (!empty($item_options['button_icon'])) { ?>
									<i class="fa fa-<?php echo $item_options['button_icon']; ?>"></i>
								<?php } ?>
								<?php
								if (!empty($item_options['button_text'])) {
									echo $item_options['button_text'];
								}
								?>
							</a>
						<?php } ?>
						</div>
						<?php } ?>
						
						<?php if (!empty($item_options['item_background_overlay_color'])) { ?>
						<div class="overlay"<?php echo RSPageBuilderHelper::buildStyle($item_background_overlay_style); ?>></div>
						<?php } ?>
					
						<?php
							break;
							case 'image-right':
								if (!empty($item_options['item_image'])) {
						?>
						<div class="rspbld-image pull-right"<?php echo RSPageBuilderHelper::buildStyle($item_image_style); ?>>
							<img<?php echo $item_options['item_image'].$item_image_alt_text; ?>>
						</div>
						<?php } ?>
						
						<?php if ((!empty($item_options['item_title']) && !empty($item_title_show)) || !empty($item_options['item_content'])) { ?>
						<div class="rspbld-item-content-container">
						<?php if (!empty($item_options['item_title']) && !empty($item_title_show)) { ?>
						<<?php echo $item_options['item_title_heading']; ?> class="rspbld-item-title"<?php echo RSPageBuilderHelper::buildStyle($item_title_style); ?>>
							<?php echo $item_options['item_title']; ?>
						</<?php echo $item_options['item_title_heading']; ?>>
						<?php } ?>
						
						<?php if (!empty($item_options['item_content'])) { ?>
						<div class="rspbld-item-content"<?php echo RSPageBuilderHelper::buildStyle($item_content_style); ?>>
							<?php echo $item_options['item_content']; ?>
						</div>
						<?php } ?>
						
						<?php if ((!empty($item_options['button_text']) || !empty($item_options['button_icon'])) && !empty($item_options['button_url'])) { ?>
							<a href="<?php echo $item_options['button_url']; ?>"<?php echo $item_button_target; ?> class="<?php echo $item_button_class; ?>">
								<?php if (!empty($item_options['button_icon'])) { ?>
									<i class="fa fa-<?php echo $item_options['button_icon']; ?>"></i>
								<?php } ?>
								<?php
								if (!empty($item_options['button_text'])) {
									echo $item_options['button_text'];
								}
								?>
							</a>
						<?php } ?>
						</div>
						<?php } ?>
						
						<?php if (!empty($item_options['item_background_overlay_color'])) { ?>
						<div class="overlay"<?php echo RSPageBuilderHelper::buildStyle($item_background_overlay_style); ?>></div>
						<?php } ?>
						
						<?php
							break;
							case 'image-top':
								if (!empty($item_options['item_image'])) {
						?>
						<div class="rspbld-image"<?php echo RSPageBuilderHelper::buildStyle($item_image_style); ?>>
							<img<?php echo $item_options['item_image'].$item_image_alt_text; ?>>
						</div>
						<?php } ?>
						
						<?php if ((!empty($item_options['item_title']) && !empty($item_title_show)) || !empty($item_options['item_content'])) { ?>
						<div class="rspbld-item-content-container">
						<?php if (!empty($item_options['item_title']) && !empty($item_title_show)) { ?>
						<<?php echo $item_options['item_title_heading']; ?> class="rspbld-item-title"<?php echo RSPageBuilderHelper::buildStyle($item_title_style); ?>>
							<?php echo $item_options['item_title']; ?>
						</<?php echo $item_options['item_title_heading']; ?>>
						<?php } ?>
						
						<?php if (!empty($item_options['item_content'])) { ?>
						<div class="rspbld-item-content"<?php echo RSPageBuilderHelper::buildStyle($item_content_style); ?>>
							<?php echo $item_options['item_content']; ?>
						</div>
						<?php } ?>
						
						<?php if ((!empty($item_options['button_text']) || !empty($item_options['button_icon'])) && !empty($item_options['button_url'])) { ?>
							<a href="<?php echo $item_options['button_url']; ?>"<?php echo $item_button_target; ?> class="<?php echo $item_button_class; ?>">
								<?php if (!empty($item_options['button_icon'])) { ?>
									<i class="fa fa-<?php echo $item_options['button_icon']; ?>"></i>
								<?php } ?>
								<?php
								if (!empty($item_options['button_text'])) {
									echo $item_options['button_text'];
								}
								?>
							</a>
						<?php } ?>
						</div>
						<?php } ?>
						
						<?php if (!empty($item_options['item_background_overlay_color'])) { ?>
						<div class="overlay"<?php echo RSPageBuilderHelper::buildStyle($item_background_overlay_style); ?>></div>
						<?php } ?>
						
						<?php
							break;
							case 'image-bottom';
						?>
						
						<?php if ((!empty($item_options['item_title']) && !empty($item_title_show)) || !empty($item_options['item_content'])) { ?>
						<div class="rspbld-item-content-container">
						<?php if (!empty($item_options['item_title']) && !empty($item_title_show)) { ?>
						<<?php echo $item_options['item_title_heading']; ?> class="rspbld-item-title"<?php echo RSPageBuilderHelper::buildStyle($item_title_style); ?>>
							<?php echo $item_options['item_title']; ?>
						</<?php echo $item_options['item_title_heading']; ?>>
						<?php } ?>
						
						<?php if (!empty($item_options['item_content'])) { ?>
						<div class="rspbld-item-content"<?php echo RSPageBuilderHelper::buildStyle($item_content_style); ?>>
							<?php echo $item_options['item_content']; ?>
						</div>
						<?php } ?>
						
						<?php if ((!empty($item_options['button_text']) || !empty($item_options['button_icon'])) && !empty($item_options['button_url'])) { ?>
							<a href="<?php echo $item_options['button_url']; ?>"<?php echo $item_button_target; ?> class="<?php echo $item_button_class; ?>">
								<?php if (!empty($item_options['button_icon'])) { ?>
									<i class="fa fa-<?php echo $item_options['button_icon']; ?>"></i>
								<?php } ?>
								<?php
								if (!empty($item_options['button_text'])) {
									echo $item_options['button_text'];
								}
								?>
							</a>
						<?php } ?>
						</div>
						<?php } ?>
						
						<?php if (!empty($item_options['item_background_overlay_color'])) { ?>
						<div class="overlay"<?php echo RSPageBuilderHelper::buildStyle($item_background_overlay_style); ?>></div>
						<?php } ?>
						
						<?php
							if (!empty($item_options['item_image'])) {
						?>
						<div class="rspbld-image"<?php echo RSPageBuilderHelper::buildStyle($item_image_style); ?>>
							<img<?php echo $item_options['item_image'].$item_image_alt_text; ?>>
						</div>
						<?php
								}
							break;
						}
						?>
					</div>
				</div>
		<?php if (($item_index == count($items)) || ($item_index % $element_options['items_per_slide'] == 0)) { ?>
			</div>
		<?php
				}
			}
		}
		?>
		</div>
		<?php if (!empty($element_options['show_controls']) && $element_options['show_controls'] == '1') { ?>
		<a class="carousel-control left" href="#<?php echo $id; ?>"<?php echo RSPageBuilderHelper::buildStyle($controls_style); ?> data-slide="prev"><i class="fa fa-chevron-left"></i></a>
		<a class="carousel-control right" href="#<?php echo $id; ?>"<?php echo RSPageBuilderHelper::buildStyle($controls_style); ?> data-slide="next"><i class="fa fa-chevron-right"></i></a>
		<?php } ?>
	</div>
</div>