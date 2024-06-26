<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

$element_options	= RSPageBuilderHelper::escapeHtmlArray($displayData['options']);
$class				= 'rspbld-testimonial-box';
$title_show			= (!isset($element_options['title_show']) || (isset($element_options['title_show']) && ($element_options['title_show'] == '1'))) ? '1' : '0';
$subtitle_show		= (!isset($element_options['subtitle_show']) || (isset($element_options['subtitle_show']) && ($element_options['subtitle_show'] == '1'))) ? '1' : '0';
$style				= array();
$image_prefix		= RSPageBuilderHelper::getClient('site') ? '' : '../';

// Testimonial Box title
if (!empty($element_options['title']) && !empty($title_show)) {
	
	// Testimonial Box title style
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

// Testimonial Box subtitle
if (!empty($element_options['subtitle']) && !empty($subtitle_show)) {
	
	// Testimonial Box subtitle style
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

// Testimonial Box cilent avatar
if (!empty($element_options['client_avatar'])) {
	$avatar_alt_text					= '';
	$element_options['client_avatar']	= ' src="' . $image_prefix . $element_options['client_avatar'] . '"';
	
	if (!empty($element_options['client_name'])) {
		$avatar_alt_text = ' alt="'.$element_options['client_name'].'"';
	}
	
	// Testimonial Box client avatar style
	$avatar_style = array();
	
	if (!empty($element_options['client_avatar_height'])) {
		$avatar_style['height'] = $element_options['client_avatar_height'];
	}
	if (!empty($element_options['client_avatar_width'])) {
		$avatar_style['width'] = $element_options['client_avatar_width'];
	}
	if (!empty($element_options['client_avatar_margin'])) {
		$avatar_style['margin'] = $element_options['client_avatar_margin'];
	}
	if (!empty($element_options['client_avatar_padding'])) {
		$avatar_style['padding'] = $element_options['client_avatar_padding'];
	}
	
	// Testimonial Box button target
	$avatar_target = '';
	if (!empty($element_options['client_avatar_target'])) {
		$avatar_target = ' target="' . $element_options['client_avatar_target'] . '"';
	}
}

// Testimonial Box content and client details
if ($element_options['content']) {
	$content_style = array();
	
	// Testimonial Box content style
	if (!empty($element_options['content_text_color'])) {
		$content_style['color'] = $element_options['content_text_color'];
	}
	if (!empty($element_options['content_margin'])) {
		$content_style['margin'] = $element_options['content_margin'];
	}
	if (!empty($element_options['content_padding'])) {
		$content_style['padding'] = $element_options['content_padding'];
	}
	
	$element_options['content'] = '<i class="fa fa-quote-left"></i>'.$element_options['content'].'<i class="fa fa-quote-right"></i>';
}

// Testimonial Box style
if (!empty($element_options['box_background_color'])) {
	$style['background-color'] = $element_options['box_background_color'];
}
if (!empty($element_options['box_margin'])) {
	$style['margin'] = $element_options['box_margin'];
}
if (!empty($element_options['box_padding'])) {
	$style['padding'] = $element_options['box_padding'];
}

// Testimonial Box alignment
if (!empty($element_options['box_alignment'])) {
	$class .= ' '.$element_options['box_alignment'];
}

// Testimonial Box class
if (!empty($element_options['class'])) {
	$class .= ' '.$element_options['class'];
}

// Build Testimonial Box HTML
if (((!empty($element_options['title']) && !empty($title_show)) || (!empty($element_options['subtitle']) && !empty($subtitle_show)) || !empty($element_options['client_avatar']) || !empty($element_options['client_details']) || !empty($element_options['client_name'])) && !empty($element_options['content'])) {
?>

<div class="<?php echo $class;?>"<?php echo RSPageBuilderHelper::buildStyle($style); ?>>
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
	if (!empty($element_options['client_avatar_position'])) {
		if ($element_options['client_avatar_position'] == 'left' || $element_options['client_avatar_position'] == 'right' || $element_options['client_avatar_position'] == 'top') {
	?>
	<div class="rspbld-inner">
		<?php if ($element_options['client_avatar']) { ?>
		<div class="rspbld-avatar<?php echo ($element_options['client_avatar_position'] == 'left' || $element_options['client_avatar_position'] == 'right') ? ' float-'.$element_options['client_avatar_position'] : '' ;?>"<?php echo RSPageBuilderHelper::buildStyle($avatar_style); ?>>
			<?php if (!empty($element_options['client_avatar_url'])) { ?>
			<a href="<?php echo $element_options['client_avatar_url']; ?>"<?php echo $avatar_target; ?>>
			<?php } ?>
			
			<img<?php echo $element_options['client_avatar'].$avatar_alt_text; ?>>
			
			<?php if (!empty($element_options['client_avatar_url'])) { ?>
			</a>
			<?php } ?>
		</div>
		<?php } ?>
		
		<?php if ($element_options['content'] && (!empty($element_options['client_name']) || !empty($element_options['client_details']))) { ?>
		<div class="rspbld-content-container"<?php echo RSPageBuilderHelper::buildStyle($content_style);?>>
			<?php if ($element_options['content']) { ?>
			<div class="rspbld-content">
				<?php echo $element_options['content']; ?>
			</div>
			<?php } ?>
			
			<?php if (!empty($element_options['client_name']) || !empty($element_options['client_details'])) { ?>
			<div class="rspbld-details">
				<?php if (!empty($element_options['client_name'])) { ?>
				<strong>
					<?php
					echo $element_options['client_name'];
					echo (!empty($element_options['client_details'])) ? ', ' : '' ;
					?>
				</strong>
				<?php } ?>
				
				<?php
				if (!empty($element_options['client_details'])) {
					echo $element_options['client_details'];
				}
				?>
			</div>
			<?php } ?>
		</div>
		<?php } ?>
	</div>
	<?php
		} else {
	?>
	<div class="rspbld-inner">
		<?php if ($element_options['content'] && (!empty($element_options['client_name']) || !empty($element_options['client_details']))) { ?>
		<div class="rspbld-content-container"<?php echo RSPageBuilderHelper::buildStyle($content_style);?>>
			<?php if ($element_options['content']) { ?>
			<div class="rspbld-content">
				<?php echo $element_options['content']; ?>
			</div>
			<?php } ?>
			
			<?php if (!empty($element_options['client_name']) || !empty($element_options['client_details'])) { ?>
			<div class="rspbld-details">
				<?php if (!empty($element_options['client_name'])) { ?>
				<strong>
					<?php
					echo $element_options['client_name'];
					echo (!empty($element_options['client_details'])) ? ', ' : '' ;
					?>
				</strong>
				<?php } ?>
				
				<?php
				if (!empty($element_options['client_details'])) {
					echo $element_options['client_details'];
				}
				?>
			</div>
			<?php } ?>
		</div>
		<?php } ?>
		
		<?php if ($element_options['client_avatar']) { ?>
		<div class="rspbld-avatar<?php echo ($element_options['client_avatar_position'] == 'left' || $element_options['client_avatar_position'] == 'right') ? ' float-'.$element_options['client_avatar_position'] : '' ;?>"<?php echo RSPageBuilderHelper::buildStyle($avatar_style); ?>>
			<?php if (!empty($element_options['client_avatar_url'])) { ?>
			<a href="<?php echo $element_options['client_avatar_url']; ?>"<?php echo $avatar_target; ?>>
			<?php } ?>
			
			<img<?php echo $element_options['client_avatar'].$avatar_alt_text; ?>>
			
			<?php if (!empty($element_options['client_avatar_url'])) { ?>
			</a>
			<?php } ?>
		</div>
		<?php } ?>
	</div>
	<?php
		}
	}
	?>
</div>
<?php } ?>