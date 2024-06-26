<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

$google_api_key		= JComponentHelper::getParams('com_rspagebuilder')->get('google_api_key');
$element_options	= RSPageBuilderHelper::escapeHtmlArray($displayData['options']);
$class				= 'rspbld-youtube-background-box';
$id 				= RSPageBuilderHelper::randomNumber();
$title_show			= (!isset($element_options['title_show']) || (isset($element_options['title_show']) && ($element_options['title_show'] == '1'))) ? '1' : '0';
$subtitle_show		= (!isset($element_options['subtitle_show']) || (isset($element_options['subtitle_show']) && ($element_options['subtitle_show'] == '1'))) ? '1' : '0';
$style				= array();
$image_prefix		= RSPageBuilderHelper::getClient('site') ? '' : '../';

// YouTube Background Video Box title
if (!empty($element_options['title']) && !empty($title_show)) {
	$id = RSPageBuilderHelper::createId($element_options['title'], $id);
	
	// YouTube Background Video Box title style
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

// YouTube Background Video Box subtitle
if (!empty($element_options['subtitle']) && !empty($subtitle_show)) {
	$id = RSPageBuilderHelper::createId($element_options['subtitle'], $id);
	
	// YouTube Background Video Box subtitle style
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

// YouTube Background Video Box video
if (!empty($google_api_key) && !empty($element_options['video_url'])) {
	
	// YouTube Background Video Box video settings
	$video_settings = '{';
	$video_settings .= 'videoURL:\'' . $element_options['video_url'] . '\',';
	$video_settings .= 'containment:\'#' . $id . '\',';
	
	if (!empty($element_options['video_show_controls'])) {
		$video_settings .= 'showControls:true,';
	} else {
		$video_settings .= 'showControls:false,';
	}
	if (!empty($element_options['video_auto_play'])) {
		$video_settings .= 'autoPlay:true,';
	} else {
		$video_settings .= 'autoPlay:false,';
	}
	if (!empty($element_options['video_loop'])) {
		$video_settings .= 'loop:true,';
	} else {
		$video_settings .= 'loop:false,';
	}
	if (!empty($element_options['video_volume'])) {
		$video_settings .= 'vol:' . $element_options['video_volume'] . ',';
	} else {
		$video_settings .= 'mute:true,';
	}
	if (!empty($element_options['video_start_at'])) {
		$video_settings .= 'startAt:' . $element_options['video_start_at'] . ',';
	}
	if (!empty($element_options['video_stop_at'])) {
		$video_settings .= 'stopAt:' . $element_options['video_stop_at'] . ',';
	}
	$video_settings .= 'opacity:1,';
	$video_settings .= 'addRaster:true,';
	
	if (!empty($element_options['video_quality'])) {
		$video_settings .= 'quality:\'' . $element_options['video_quality'] . '\'';
	}
	$video_settings .= '}';
	
	// Load YouTube Background Video Box style sheet
	RSPageBuilderHelper::loadAsset('component', 'jquery.mb.YTPlayer.min.css');
	
	// Load YouTube Background Video Box script
	RSPageBuilderHelper::loadAsset('component', 'jquery.mb.YTPlayer.min.js');
}

// YouTube Background Video Box content
if (!empty($element_options['content'])) {
	
	// YouTube Background Video Box content style
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

// YouTube Background Video Box style
if (!empty($element_options['box_background_image'])) {
	$style['background-image'] = $element_options['box_background_image'];
	
	if (!empty($element_options['box_background_repeat'])) {
		$style['background-repeat'] = $element_options['box_background_repeat'];
	}
	if (!empty($element_options['box_background_size'])) {
		$style['background-size'] = $element_options['box_background_size'];
	}
	if (!empty($element_options['box_background_attachment'])) {
		$style['background-attachment'] = $element_options['box_background_attachment'];
	}
	if (!empty($element_options['box_background_position'])) {
		$style['background-position'] = str_replace('-', ' ', $element_options['box_background_position']);
	}
}
if (!empty($element_options['box_height'])) {
	$style['height'] = $element_options['box_height'];
}
if (!empty($element_options['box_width'])) {
	$style['width'] = $element_options['box_width'];
}
if (!empty($element_options['box_margin'])) {
	$style['margin'] = $element_options['box_margin'];
}
if (!empty($element_options['box_padding'])) {
	$style['padding'] = $element_options['box_padding'];
}

// YouTube Background Video Box alignment
if (!empty($element_options['box_alignment'])) {
	$class .= ' '.$element_options['box_alignment'];
}

// YouTube Background Video Box class
if (!empty($element_options['class'])) {
	$class .= ' '.$element_options['class'];
}

// Build YouTube Background Video Box HTML
if (!empty($google_api_key)) {
	if ((!empty($element_options['video_url'])) && ((!empty($element_options['title']) && !empty($title_show)) || (!empty($element_options['subtitle']) && !empty($subtitle_show)) || !empty($element_options['content']))) {
?>

	<div id="<?php echo $id; ?>" class="<?php echo $class; ?>"<?php echo RSPageBuilderHelper::buildStyle($style); ?>>
		<div class="rspbld-content-container">
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
			
			<?php if (!empty($element_options['content'])) { ?>
			<div class="rspbld-content"<?php echo RSPageBuilderHelper::buildStyle($content_style); ?>>
				<?php echo $element_options['content']; ?>
			</div>
			<?php } ?>
			
			<?php if (!empty($google_api_key) && !empty($element_options['video_url'])) { ?>
				<div class="rspbld-youtube-player" data-apikey="<?php echo $google_api_key;?>" data-property="<?php echo $video_settings; ?>"></div>
			<?php } ?>
		</div>
	</div>
<?php
	}
} else { ?>
	<div class="rspbld-error alert alert-danger"><?php echo JText::_('COM_RSPAGEBUILDER_GOOGLE_NO_API_KEY_ERROR');?></div>
<?php } ?>