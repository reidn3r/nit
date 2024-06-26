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
$class				= 'rspbld-accordion';
$id					= RSPageBuilderHelper::randomNumber();
$title_show			= (!isset($element_options['title_show']) || (isset($element_options['title_show']) && ($element_options['title_show'] == '1'))) ? '1' : '0';
$subtitle_show		= (!isset($element_options['subtitle_show']) || (isset($element_options['subtitle_show']) && ($element_options['subtitle_show'] == '1'))) ? '1' : '0';

// Accordion title
if (!empty($element_options['title']) && !empty($title_show)) {
	
	// Accordion title style
	$title_style	= array();
	$id				= RSPageBuilderHelper::createId($element_options['title'], $id);
	
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
} else {
	$id = RSPageBuilderHelper::createId('accordion', $id);
}

// Accordion subtitle
if (!empty($element_options['subtitle']) && !empty($subtitle_show)) {
	
	// Accordion subtitle style
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

// Accordion class
if (!empty($element_options['class'])) {
	$class .= ' '.$element_options['class'];
}

// Build Accordion HTML
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
	
	<div id="<?php echo $id; ?>" class="card-container">
	<?php
	if (count($items)) {
		foreach ($items as $item_index => $item) {
			$item_options			= RSPageBuilderHelper::escapeHtmlArray($item['options']);
			$item_id				= RSPageBuilderHelper::randomNumber();
			$item_title_style		= array();
			$item_title_icon_style	= array();
			$item_content_style		= array();
			$item_expanded			= false;
			
			// Accordion item title
			if (!empty($item_options['item_title'])) {
				$item_id = RSPageBuilderHelper::createId($item_options['item_title'], $item_id);
				
				// Accordion item title style
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
			
			// Accordion item title icon style
			if (!empty($item_options['item_title_icon'])) {
				if (!empty($item_options['item_title_icon_font_size'])) {
					$item_title_icon_style['font-size'] = $item_options['item_title_icon_font_size'];
				}
				if (!empty($item_options['item_title_icon_color'])) {
					$item_title_icon_style['color'] = $item_options['item_title_icon_color'];
				}
			}
			
			// Accordion item content
			if (!empty($item_options['item_content'])) {
				if (!empty($item_options['item_content_text_color'])) {
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
			
			// Expand / collapse item
			if (!empty($item_options['item_expanded'])) {
				$item_expanded = true;
			} else {
				if (!isset($item_options['item_expanded']) && !$item_index) {
					$item_expanded = true;
				}
			}
			
			if ($item_expanded) {
				$accordion_heading	= '';
				$accordion_expanded	= 'true';
				$accordion_body		= ' show';
			} else {
				$accordion_heading	= ' collapsed';
				$accordion_expanded	= 'false';
				$accordion_body		= '';
			}
			
			// Build Accordion item HTML
			if ((!empty($item_options['item_title']) || !empty($item_options['item_title_icon'])) && !empty($item_options['item_content'])) {
	?>
		<div class="card">
			<div class="card-header">
				<a class="btn btn-link<?php echo $accordion_heading; ?>" href="#<?php echo $item_id; ?>" data-toggle="collapse" aria-expanded="<?php echo $accordion_expanded; ?>" aria-controls="<?php echo $item_id; ?>"
				<?php if (!empty($item_options['item_title'])) {
					echo RSPageBuilderHelper::buildStyle($item_title_style);
				} ?>
				>
				<?php if (!empty($item_options['item_title_icon'])) { ?>
					<i class="fa fa-<?php echo $item_options['item_title_icon']; ?>"<?php echo RSPageBuilderHelper::buildStyle($item_title_icon_style); ?>></i>
				<?php } ?>
				
				<?php if (!empty($item_options['item_title'])) {
					echo $item_options['item_title'];
				} ?>
				</a>
			</div>
			<?php if (!empty($item_options['item_content'])) { ?>
			<div class="collapse<?php echo $accordion_body; ?>" id="<?php echo $item_id; ?>" data-parent="#<?php echo $id; ?>" aria-labelledby="<?php echo $item_id; ?>">
				<div class="card-body"<?php echo RSPageBuilderHelper::buildStyle($item_content_style); ?>>
				<?php echo $item_options['item_content']; ?>
				</div>
			</div>
			<?php } ?>
		</div>
	<?php
			}
		}
	}
	?>
	</div>
</div>