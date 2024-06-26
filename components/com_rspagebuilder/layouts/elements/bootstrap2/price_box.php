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
$class				= 'rspbld-price-box';
$button_class		= 'rspbld-button btn';
$title_show			= (!isset($element_options['title_show']) || (isset($element_options['title_show']) && ($element_options['title_show'] == '1'))) ? '1' : '0';
$subtitle_show		= (!isset($element_options['subtitle_show']) || (isset($element_options['subtitle_show']) && ($element_options['subtitle_show'] == '1'))) ? '1' : '0';
$style				= array();

// Price Box title
if (!empty($element_options['title']) && !empty($title_show)) {
	
	// Price Box title style
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

// Price Box subtitle
if (!empty($element_options['subtitle']) && !empty($subtitle_show)) {
	
	// Price Box subtitle style
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

// Price Box icon
if (!empty($element_options['icon'])) {
	
	// Price Box icon style
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

// Price Box price
if (!empty($element_options['price'])) {
	
	// Price Box price style
	$price_style = array();
	
	if (!empty($element_options['price_font_size'])) {
		$price_style['font-size'] = $element_options['price_font_size'];
	}
	if (!empty($element_options['price_font_weight'])) {
		$price_style['font-weight'] = $element_options['price_font_weight'];
	}
	if (!empty($element_options['price_text_color'])) {
		$price_style['color'] = $element_options['price_text_color'];
	}
	if (!empty($element_options['price_margin'])) {
		$price_style['margin'] = $element_options['price_margin'];
	}
	if (!empty($element_options['price_padding'])) {
		$price_style['padding'] = $element_options['price_padding'];
	}
}

// Price Box content
if (!empty($element_options['content'])) {
	
	// Price Box content style
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

// Price Box button
if ((!empty($element_options['button_text']) || !empty($element_options['button_icon'])) && !empty($element_options['button_url'])) {
	if (!empty($element_options['button_size'])) {
		$button_class .= ' btn-'.$element_options['button_size'];
	}
	if (!empty($element_options['button_type'])) {
		$button_class .= ' btn-'.$element_options['button_type'];
	}
	
	// Price Box button target
	$button_target = '';
	if (!empty($element_options['button_target'])) {
		$button_target = ' target="' . $element_options['button_target'] . '"';
	}
	
	// Load button style
	RSPageBuilderHelper::loadAsset('element', 'button.css');
}

// Price Box style
if (!empty($element_options['box_background_color'])) {
	$style['background-color'] = $element_options['box_background_color'];
}
if (!empty($element_options['box_margin'])) {
	$style['margin'] = $element_options['box_margin'];
}
if (!empty($element_options['box_padding'])) {
	$style['padding'] = $element_options['box_padding'];
}

// Price Box class
if (!empty($element_options['class'])) {
	$class .= ' '.$element_options['class'];
}

// Build Price Box HTML
if ((!empty($element_options['title']) && !empty($title_show)) || (!empty($element_options['subtitle']) && !empty($subtitle_show)) || !empty($element_options['icon']) || !empty($element_options['content'])) {
?>

<div class="<?php echo $class; ?>"<?php echo RSPageBuilderHelper::buildStyle($style); ?>>
	<table class="table">
		<tr>
			<td>
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
				
				<?php
						break;
					}
				?>
				
				<?php if (!empty($element_options['price'])) { ?>
				<div class="rspbld-price"<?php echo RSPageBuilderHelper::buildStyle($price_style); ?>>
					<?php if (!empty($element_options['price_before'])) { ?>
					<div class="rspbld-price-before"><?php echo $element_options['price_before']; ?></div>
					<?php } ?>
					<div>
					<?php echo $element_options['price']; ?>
					</div>
					<?php if (!empty($element_options['price_after'])) { ?>
					<div class="rspbld-price-after"><?php echo $element_options['price_after']; ?></div>
					<?php } ?>
				</div>
				<?php } ?>
				
				<?php if (!empty($element_options['content'])) { ?>
					<div class="rspbld-content"<?php echo RSPageBuilderHelper::buildStyle($content_style); ?>>
						<?php echo $element_options['content']; ?>
					</div>
				<?php
					}
				}
				?>
			</td>
		</tr>
		<?php
		if (count($items)) {
			foreach($items as $item) {
				$item_options	= RSPageBuilderHelper::escapeHtmlArray($item['options']);
				$item_style		= array();
				
				// Price Box item text
				if (!empty($item_options['item_text'])) {
					 
					 // Price Box item style
					 if (!empty($item_options['item_font_size'])) {
						 $item_style['font-size'] = $item_options['item_font_size'];
					 }
					 if (!empty($item_options['item_font_weight'])) {
						 $item_style['font-weight'] = $item_options['item_font_weight'];
					 }
					 if (!empty($item_options['item_text_color'])) {
						 $item_style['color'] = $item_options['item_text_color'];
					 }
					 if (!empty($item_options['item_background_color'])) {
						 $item_style['background-color'] = $item_options['item_background_color'];
					 }
					 if (!empty($item_options['item_margin'])) {
						 $item_style['margin'] = $item_options['item_margin'];
					 }
					 if (!empty($item_options['item_padding'])) {
						 $item_style['padding'] = $item_options['item_padding'];
					 }
				}
		// Build Price Box item HTML
		?>
		<tr>
			<td<?php echo RSPageBuilderHelper::buildStyle($item_style); ?>>
				<?php echo $item_options['item_text']; ?>
			</td>
		</tr>
		<?php
			}
		}
		?>
		<tr>
			<td>
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
			</td>
		</tr>
	</table>
</div>
<?php } ?>