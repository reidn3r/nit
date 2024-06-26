<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

$element_options	= RSPageBuilderHelper::escapeHtmlArray($displayData['options']);
$class				= 'rspbld-personal-box';
$title_show			= (!isset($element_options['title_show']) || (isset($element_options['title_show']) && ($element_options['title_show'] == '1'))) ? '1' : '0';
$subtitle_show		= (!isset($element_options['subtitle_show']) || (isset($element_options['subtitle_show']) && ($element_options['subtitle_show'] == '1'))) ? '1' : '0';
$style				= array();
$image_prefix		= RSPageBuilderHelper::getClient('site') ? '' : '../';

// Personal Box title
if (!empty($element_options['title']) && !empty($title_show)) {
	
	// Personal Box title style
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

// Personal Box subtitle
if (!empty($element_options['subtitle']) && !empty($subtitle_show)) {
	
	// Personal Box subtitle style
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

// Personal Box image
if (!empty($element_options['image'])) {
	$element_options['image'] = ' src="' . $image_prefix . $element_options['image'] . '"';
	
	if (!empty($element_options['image_alt_text'])) {
		$element_options['image_alt_text'] = ' alt="'.$element_options['image_alt_text'].'"';
	}
	
	// Personal Box image style
	$image_style = array();
	
	if (!empty($element_options['image_height'])) {
		$image_style['height'] = $element_options['image_height'];
	}
	if (!empty($element_options['image_width'])) {
		$image_style['width'] = $element_options['image_width'];
	}
	if (!empty($element_options['image_margin'])) {
		$image_style['margin'] = $element_options['image_margin'];
	}
	if (!empty($element_options['image_padding'])) {
		$image_style['padding'] = $element_options['image_padding'];
	}
}

// Personal Box content
if (!empty($element_options['content'])) {
	
	// Personal Box content style
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

// Personal Box social icons
if (!empty($element_options['social_facebook'])) {
	$socials['facebook'] = $element_options['social_facebook'];
}
if (!empty($element_options['social_twitter'])) {
	$socials['twitter'] = $element_options['social_twitter'];
}
if (!empty($element_options['social_instagram'])) {
	$socials['instagram'] = $element_options['social_instagram'];
}
if (!empty($element_options['social_linkedin'])) {
	$socials['linkedin'] = $element_options['social_linkedin'];
}
if (!empty($element_options['social_youtube'])) {
	$socials['youtube'] = $element_options['social_youtube'];
}
if (!empty($element_options['social_tumblr'])) {
	$socials['tumblr'] = $element_options['social_tumblr'];
}
if (!empty($element_options['social_vimeo'])) {
	$socials['vimeo'] = $element_options['social_vimeo'];
}
if (!empty($element_options['social_flickr'])) {
	$socials['flickr'] = $element_options['social_flickr'];
}
if (!empty($element_options['social_pinterest'])) {
	$socials['pinterest'] = $element_options['social_pinterest'];
}

if (!empty($socials)) {
	
	// Personal Box social icons style
	$socials_style = array();
	
	if (!empty($element_options['social_icons_font_size'])) {
		$socials_style['font-size'] = $element_options['social_icons_font_size'];
	}
	if (!empty($element_options['social_icons_color'])) {
		$socials_style['color'] = $element_options['social_icons_color'];
	}
	if (!empty($element_options['social_icons_background_color'])) {
		$socials_style['background-color'] = $element_options['social_icons_background_color'];
	}
	if (!empty($element_options['social_icons_margin'])) {
		$socials_style['margin'] = $element_options['social_icons_margin'];
	}
	if (!empty($element_options['social_icons_padding'])) {
		$socials_style['padding'] = $element_options['social_icons_padding'];
	}
	
	// Personal Box socials target
	$socials_target = '';
	if (!empty($element_options['social_icons_target'])) {
		$socials_target = ' target="' . $element_options['social_icons_target'] . '"';
	}
}

// Personal Box style
if (!empty($element_options['box_background_color'])) {
	$style['background-color'] = $element_options['box_background_color'];
}
if (!empty($element_options['box_margin'])) {
	$style['margin'] = $element_options['box_margin'];
}
if (!empty($element_options['box_padding'])) {
	$style['padding'] = $element_options['box_padding'];
}

// Personal Box alignment
if (!empty($element_options['box_alignment'])) {
	$class .= ' '.$element_options['box_alignment'];
}

// Personal Box class
if (!empty($element_options['class'])) {
	$class .= ' '.$element_options['class'];
}

// Build Personal Box HTML
if ((!empty($element_options['title']) && !empty($title_show)) || (!empty($element_options['subtitle']) && !empty($subtitle_show)) || !empty($element_options['image']) || !empty($element_options['content'])) {
?>

<div class="<?php echo $class; ?>"<?php echo RSPageBuilderHelper::buildStyle($style); ?>>
	<?php
	if (!empty($element_options['social_icons_position'])) {
	?>
	
	<?php if (!empty($element_options['image'])) { ?>
	<div class="rspbld-image"<?php echo RSPageBuilderHelper::buildStyle($image_style); ?>>
		<img<?php echo $element_options['image'].$element_options['image_alt_text']; ?>>
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
		switch ($element_options['social_icons_position']) {
			case 'after-content':
	?>
	
	<?php if (!empty($element_options['content'])) { ?>
	<div class="rspbld-content"<?php echo RSPageBuilderHelper::buildStyle($content_style); ?>>
		<?php echo $element_options['content']; ?>
	</div>
	<?php } ?>
	
	<?php if (!empty($socials)) { ?>
	<ul class="rspbld-social-icons">
		<?php foreach ($socials as $key => $val) { ?>
		<li class="<?php echo $key; ?>">
			<?php
			switch ($key) {
				case 'facebook':
					$key .= '-f';
				break;
				case 'linkedin':
					$key .= '-in';
				break;
				case 'pinterest':
					$key .= '-p';
				break;
				case 'vimeo':
					$key .= '-v';
				break;
				default:
					$key;
				break;
			}
			?>
			<a href="<?php echo $val; ?>"<?php echo $socials_target; ?>>
				<i class="fa fa-<?php echo ($key === 'twitter' ? 'x-' . $key : $key); ?>"<?php echo RSPageBuilderHelper::buildStyle($socials_style); ?>></i>
			</a>
		</li>
		<?php } ?>
	</ul>
	<?php } ?>
	
	<?php
			break;
			case 'before-content':
	?>
	
	<?php if (!empty($socials)) { ?>
	<ul class="rspbld-social-icons">
		<?php foreach ($socials as $key => $val) { ?>
		<li class="<?php echo $key; ?>">
			<a href="<?php echo $val; ?>"<?php echo $socials_target; ?>>
				<i class="fa fa-<?php echo ($key === 'twitter' ? 'x-' . $key : $key); ?>"<?php echo RSPageBuilderHelper::buildStyle($socials_style); ?>></i>
			</a>
		</li>
		<?php } ?>
	</ul>
	<?php } ?>
	
	<?php if (!empty($element_options['content'])) { ?>
	<div class="rspbld-content"<?php echo RSPageBuilderHelper::buildStyle($content_style); ?>>
		<?php echo $element_options['content']; ?>
	</div>
	<?php } ?>
	
	<?php
			break;
		}
	}
	?>
</div>
<?php
}