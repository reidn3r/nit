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
$class				= 'rspbld-tab tab';
$id					= RSPageBuilderHelper::randomNumber();
$title_show			= (!isset($element_options['title_show']) || (isset($element_options['title_show']) && ($element_options['title_show'] == '1'))) ? '1' : '0';
$subtitle_show		= (!isset($element_options['subtitle_show']) || (isset($element_options['subtitle_show']) && ($element_options['subtitle_show'] == '1'))) ? '1' : '0';

foreach ($items as $key => $item) {
	$ids[$key] = RSPageBuilderHelper::randomNumber();
}

// Tab title
if (!empty($element_options['title']) && !empty($title_show)) {
	
	// Tab title style
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
}

// Tab subtitle
if (!empty($element_options['subtitle']) && !empty($subtitle_show)) {
	
	// Tab subtitle style
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

// Tab class
if (!empty($element_options['class'])) {
	$class .= ' '.$element_options['class'];
}

// Build Tab content HTML
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
	
	<?php if (count($items)) { ?>
		<ul class="nav nav-tabs">
			<?php
			foreach ($items as $item_index => $item) {
				$item_options			= RSPageBuilderHelper::escapeHtmlArray($item['options']);
				$item_title_style		= array();
				$item_title_icon_style	= array();
				$item_id				= $ids[$item_index];
				
				// Tab item title style
				if (!empty($item_options['item_title'])) {
					$item_id = RSPageBuilderHelper::createId($item_options['item_title'], $item_id);
					
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
				
				// Tab item title icon style
				if (!empty($item_options['item_title_icon'])) {
					if (!empty($item_options['item_title_icon_font_size'])) {
						$item_title_icon_style['font-size'] = $item_options['item_title_icon_font_size'];
					}
					if (!empty($item_options['item_title_icon_color'])) {
						$item_title_icon_style['color'] = $item_options['item_title_icon_color'];
					}
				}
				
				// Make first item active
				if ($item_index) {
					$tab_heading = '';
				} else {
					$tab_heading = ' active';
				}
				
				// Build Tab navigation HTML
				if (!empty($item_options['item_title']) || !empty($item_options['item_title_icon'])) {
			?>
			<li class="nav-item">
				<a class="nav-link<?php echo $tab_heading; ?>" href="#<?php echo $item_id;?>" data-toggle="tab"<?php echo RSPageBuilderHelper::buildStyle($item_title_style); ?>>
					<?php if (!empty($item_options['item_title_icon'])) { ?>
					<i class="fa fa-<?php echo $item_options['item_title_icon']; ?>"<?php echo RSPageBuilderHelper::buildStyle($item_title_icon_style); ?>></i>
					<?php
					}
					echo $item_options['item_title'];
					?>
				</a>
			</li>
			<?php
				}
			}
			?>
		</ul>
		<div class="tab-content">
			<?php
			foreach ($items as $item_index => $item) {
				$item_options		= RSPageBuilderHelper::escapeHtmlArray($item['options']);
				$item_content_style	= array();
				$item_id			= $ids[$item_index];
				
				// Tab item content
				if (!empty($item_options['item_content'])) {
					$item_id = RSPageBuilderHelper::createId($item_options['item_title'], $item_id);
					
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
					
					// Make first item active
					if ($item_index) {
						$tab_content = '';
					} else {
						$tab_content = ' show active';
					}
					
					// Build Tab item content HTML
			?>
					<div id="<?php echo $item_id; ?>" class="tab-pane fade<?php echo $tab_content; ?>"<?php echo RSPageBuilderHelper::buildStyle($item_content_style);?>>
					<?php echo $item_options['item_content']; ?>
					</div>
			<?php
				}
			}
			?>
		</div>
	<?php } ?>
</div>