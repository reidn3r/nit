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
$class				= 'rspbld-portfolio-filtering';
$title_show			= (!isset($element_options['title_show']) || (isset($element_options['title_show']) && ($element_options['title_show'] == '1'))) ? '1' : '0';
$subtitle_show		= (!isset($element_options['subtitle_show']) || (isset($element_options['subtitle_show']) && ($element_options['subtitle_show'] == '1'))) ? '1' : '0';
$layout				= (!isset($element_options['layout'])) ? 'sameSize' : $element_options['layout'];
$style				= array();
$image_prefix		= RSPageBuilderHelper::getClient('site') ? '' : '../';

// Portfolio Filtering title
if (!empty($element_options['title']) && !empty($title_show)) {
	
	// Portfolio Filtering title style
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

// Portfolio Filtering subtitle
if (!empty($element_options['subtitle']) && !empty($subtitle_show)) {
	
	// Portfolio Filtering subtitle style
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

// Portfolio Filtering style
if (!empty($element_options['margin'])) {
	$style['margin'] = $element_options['margin'];
}
if (!empty($element_options['padding'])) {
	$style['padding'] = $element_options['padding'];
}

// Portfolio Filtering alignment
if (!empty($element_options['alignment'])) {
	$class .= ' '.$element_options['alignment'];
}

// Portfolio Filtering class
if (!empty($element_options['class'])) {
	$class .= ' '.$element_options['class'];
}

// Build Portfolio Filtering HTML
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
<?php 
if (count($items)) {
	
	// Prepare tags
	$tags = array();
	foreach ($items as $item_index => $item) {
		if (!empty($item['options']['item_tags'])) {
			$tmp_tags = explode(',', $item['options']['item_tags']);
			$tags = array_merge($tags, $tmp_tags);
		}
	}
	$tags = array_map('trim', $tags);
	$tags = array_unique($tags);
	ksort($tags);
	$tags = array_combine(range(1, count($tags)), $tags); // filterizr requires the index to start from 1

	// Tags container style
	$tags_style = array();
	if (!empty($element_options['tags_margin'])) {
		$tags_style['margin'] = $element_options['tags_margin'];
	}
	if (!empty($element_options['tags_padding'])) {
		$tags_style['padding'] = $element_options['tags_padding'];
	}
	
	// Load Portfolio Filtering scripts
	RSPageBuilderHelper::loadAsset('component', 'jquery.filterizr.js');
?>
	<ul class="rspbld-filter" <?php echo RSPageBuilderHelper::buildStyle($tags_style);?>>
<?php
	if (!empty($tags)) {
		$tag_style = array();
		// Portfolio Filtering tag style
		if (!empty($element_options['tag_font_size'])) {
			$tag_style['font-size'] = $element_options['tag_font_size'];
		}
		if (!empty($element_options['tag_font_weight'])) {
			$tag_style['font-weight'] = $element_options['tag_font_weight'];
		}
		if (!empty($element_options['tag_text_color'])) {
			$tag_style['color'] = $element_options['tag_text_color'];
		}
		if (!empty($element_options['tag_background_color'])) {
			$tag_style['background-color'] = $element_options['tag_background_color'];
		}
		if (!empty($element_options['tag_margin'])) {
			$tag_style['margin'] = $element_options['tag_margin'];
		}
		if (!empty($element_options['tag_padding'])) {
			$tag_style['padding'] = $element_options['tag_padding'];
		}
		$tag_styling = RSPageBuilderHelper::buildStyle($tag_style);
?>
		<li class="active badge bg-dark" data-filter="all" <?php echo $tag_styling;?>><?php echo JText::_('COM_RSPAGEBUILDER_ALL');?></li>
	<?php foreach ($tags as $i => $tag) { ?>
		<li data-filter="<?php echo $i;?>" class="badge bg-dark" <?php echo $tag_styling;?>><?php echo $tag;?></li>
	<?php } ?>
<?php } ?>
	
	</ul>
	<div class="rspbld-portfolio-filtering-container" data-layout="<?php echo $layout; ?>">
<?php
		  foreach ($items as $item_index => $item) {
			$item_title_show	= (!isset($item['options']['item_title_show']) || (isset($item['options']['item_title_show']) && ($item['options']['item_title_show'] == '1'))) ? '1' : '0';
			$item_style			= array();
			$title_style 		= array();
			$content_style 		= array();
			$item_tags 			= array_intersect( $tags , array_map( 'trim', explode( ',', $item['options']['item_tags'] ) ));
			$item_alt           = '';

			// Portfolio Filtering item style
			if (!empty($item['options']['item_background_color'])) {
				$item_style['background-color'] = $item['options']['item_background_color'];
			}
			if (!empty($item['options']['item_margin'])) {
				$item_style['margin'] = $item['options']['item_margin'];
			}
			if (!empty($item['options']['item_padding'])) {
				$item_style['padding'] = $item['options']['item_padding'];
			}
			if (!empty($item['options']['item_title_color'])) {
				$title_style['color'] = $item['options']['item_title_color'];
			}
			if (!empty($item['options']['item_text_color'])) {
				$content_style['color'] = $item['options']['item_text_color'];
			}
			
			// Portfolio item image alt
			if (!empty($item['options']['item_title'])) {
                $item_alt = ' alt="' . $item['options']['item_title'] . '"';
            }
			
			// Portfolio item URL target
			$item_url_target = '';
			if (!empty($item['options']['item_url_target'])) {
				$item_url_target = ' target="' . $item['options']['item_url_target'] . '"';
			}

?>
			<div class="grid_1<?php echo $element_options['grid'];?> filtr-item" data-category="<?php echo implode(', ', array_keys($item_tags));?>" data-sort="<?php echo $item['options']['item_title'];?>">
				<div class="filtr-item-inner" <?php echo RSPageBuilderHelper::buildStyle($item_style); ?>>
				<?php if (!empty($item['options']['item_url'])) { ?>
					<a href="<?php echo $item['options']['item_url']; ?>"<?php echo $item_url_target; ?>>
				<?php } ?>
						<img class="img-responsive" src="<?php echo $image_prefix.$item['options']['item_image'];?>" <?php echo $item_alt;?>>
						<?php if (!empty($item['options']['item_title']) && !empty($item_title_show)) { ?>
						<<?php echo $item['options']['item_title_heading']; ?> class="rspbld-title" <?php echo RSPageBuilderHelper::buildStyle($title_style); ?>><?php echo $item['options']['item_title'];?></<?php echo $item['options']['item_title_heading']; ?>>
						<?php } ?>
				<?php if (!empty($item['options']['item_url'])) { ?>
					</a>
				<?php } ?>
				<?php if (!empty($item['options']['item_text'])) { ?>
					<div class="rspbld-content" <?php echo RSPageBuilderHelper::buildStyle($content_style); ?>><?php echo $item['options']['item_text'];?></div>
				<?php } ?>
				</div>
			</div>
	<?php } ?>
	</div>
<?php } ?>
</div>