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
$class				= 'rspbld-list';
$title_show			= (!isset($element_options['title_show']) || (isset($element_options['title_show']) && ($element_options['title_show'] == '1'))) ? '1' : '0';
$subtitle_show		= (!isset($element_options['subtitle_show']) || (isset($element_options['subtitle_show']) && ($element_options['subtitle_show'] == '1'))) ? '1' : '0';
$style				= array();

// List title
if (!empty($element_options['title']) && !empty($title_show)) {
	
	// List title style
	$title_style	= array();
	
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

// List subtitle
if (!empty($element_options['subtitle']) && !empty($subtitle_show)) {
	
	// List subtitle style
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

// List style
if (!empty($element_options['margin'])) {
	$style['margin'] = $element_options['margin'];
}
if (!empty($element_options['padding'])) {
	$style['padding'] = $element_options['padding'];
}

// List alignment
if (!empty($element_options['alignment'])) {
	$class .= ' '.$element_options['alignment'];
}

// List class
if (!empty($element_options['class'])) {
	$class .= ' '.$element_options['class'];
}

// Build List content HTML
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
	
	<ul>
		<?php
		if (count($items)) {
			foreach ($items as $item_index => $item) {
				$item_options		= RSPageBuilderHelper::escapeHtmlArray($item['options']);
				$item_icon_style	= array();
				$item_style			= array();
				$html_item_icon		= '';
				$html_item_content	= '';
				
				// List item icon style
				if (!empty($item_options['item_icon'])) {
					if (!empty($item_options['item_icon_font_size'])) {
						$item_icon_style['font-size'] = $item_options['item_icon_font_size'];
					}
					if (!empty($item_options['item_icon_color'])) {
						$item_icon_style['color'] = $item_options['item_icon_color'];
					}
					if (!empty($item_options['item_icon_background_color'])) {
						$item_icon_style['background-color'] = $item_options['item_icon_background_color'];
					}
					if (!empty($item_options['item_icon_margin'])) {
						$item_icon_style['margin'] = $item_options['item_icon_margin'];
					}
					if (!empty($item_options['item_icon_padding'])) {
						$item_icon_style['padding'] = $item_options['item_icon_padding'];
					}
				}
				
				// List item style
				if (!empty($item_options['item_icon']) || !empty($item_options['item_content'])) {
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
					
					// Build List item HTML
		?>
		<li<?php echo RSPageBuilderHelper::buildStyle($item_style); ?>>
			<?php if (!empty($item_options['item_icon']) && $element_options['icon_position'] == 'left') { ?>
			<div class="rspbld-icon-container <?php echo $element_options['icon_position']; ?>">
				<div class="rspbld-icon"<?php echo RSPageBuilderHelper::buildStyle($item_icon_style); ?>>
					<i class="fa fa-<?php echo $item_options['item_icon']; ?>"></i>
				</div>
			</div>
			<?php } ?>
			
			<?php if (!empty($item_options['item_content'])) { ?>
			<div class="rspbld-content-container">
				<div class="rspbld-content">
				<?php echo $item_options['item_content']; ?>
				</div>
			</div>
			<?php } ?>
			
			<?php if (!empty($item_options['item_icon']) && $element_options['icon_position'] == 'right') { ?>
			<div class="rspbld-icon-container <?php echo $element_options['icon_position']; ?>">
				<div class="rspbld-icon"<?php echo RSPageBuilderHelper::buildStyle($item_icon_style); ?>>
					<i class="fa fa-<?php echo $item_options['item_icon']; ?>"></i>
				</div>
			</div>
			<?php } ?>
		</li>
		<?php
				}
			}
		}
		?>
	</ul>
</div>