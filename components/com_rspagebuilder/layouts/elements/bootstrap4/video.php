<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

$doc 				= JFactory::getDocument();
$element_options	= RSPageBuilderHelper::escapeHtmlArray($displayData['options']);
$class				= 'rspbld-video';
$id 				= RSPageBuilderHelper::randomNumber();
$title_show			= (!isset($element_options['title_show']) || (isset($element_options['title_show']) && ($element_options['title_show'] == '1'))) ? '1' : '0';
$subtitle_show		= (!isset($element_options['subtitle_show']) || (isset($element_options['subtitle_show']) && ($element_options['subtitle_show'] == '1'))) ? '1' : '0';
$video_class 		= '';
$video_params		= '';
$video_source		= '';
$container_style	= array();
$video_extensions	= array (
						'asf',
						'avi',
						'flv',
						'm4v',
						'mp4',
						'ogg',
						'ogv',
						'webm'
					);
$video_url			= array();
$video_style		= array();
$style				= array();

// Video title
if (!empty($element_options['title']) && !empty($title_show)) {
	$id = RSPageBuilderHelper::createId($element_options['title'], $id);
	
	// Video title style
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

// Video subtitle
if (!empty($element_options['subtitle']) && !empty($subtitle_show)) {
	
	// Video subtitle style
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

// Video iframe
if (!empty($element_options['url'])) {
	$video_url = parse_url($element_options['url']);
	
	// Video class
	if (!empty($element_options['class'])) {
		$class .= ' '.$element_options['class'];
	}
	
	// Video dimensions
	if (empty($element_options['video_full_width'])) {
		if (!empty($element_options['height'])) {
			$video_style['height'] = $element_options['height'];
			$video_params .= ' data-height="'.$element_options['height'].'"';
		}
		if (!empty($element_options['width'])) {
			$video_style['width'] = $element_options['width'];
			$video_params .= ' data-width="'.$element_options['width'].'"';
		}
	}
	
	// Video iframe source
	if (!empty($element_options['url'])) {
		switch ($video_url['host']) {
			case 'youtube.com':
			case 'www.youtube.com':
				$doc->addScript('https://www.youtube.com/iframe_api');
				parse_str($video_url['query'], $query);
				$video_class = 'rspbld-youtube-video';
				
				// Video source
				$video_params .= 'data-source="'.$query['v'].'"';
				$video_source = $query['v'];
				
				if (empty($element_options['video_full_width'])) {
					$container_style['height'] = $element_options['height'];
				} else {
					$class .= ' responsive';
				}
			break;
			case 'vimeo.com':
			case 'www.vimeo.com':
				$doc->addScript('https://player.vimeo.com/api/player.js');
				$video_class = 'rspbld-vimeo-video';
				
				// Video source
				$video_params .= 'data-source="'.basename($video_url['path']).'"';
				$video_source = basename($video_url['path']);
				
				if (empty($element_options['video_full_width'])) {
					$container_style['height'] = $element_options['height'];
				} else {
					$class .= ' responsive';
				}
			break;
			default:
				RSPageBuilderHelper::loadAsset('component', 'jquery.videoPlayer.js');
				
				if (in_array(JFile::getExt($element_options['url']), $video_extensions)) {
					$video_class = 'rspbld-video-player';
					
					// Video source
					$video_params .= 'data-source="'.$element_options['url'].'"';
				}
			break;
		}
		
		// Video autoplay
		if (!empty($element_options['video_auto_play'])) {
			$video_params .= ' data-autoplay="1"';
		} else {
			$video_params .= ' data-autoplay="0"';
		}
		
		// Video controls
		if (!empty($element_options['video_show_controls'])) {
			$video_params .= ' data-controls="1"';
		} else {
			$video_params .= ' data-controls="0"';
			$class .= ' hidden-controls';
		}
		
		// Video suggestions
		if (!empty($element_options['video_show_suggestions'])) {
			$video_params .= ' data-rel="1"';
		} else {
			$video_params .= ' data-rel="0"';
		}
		
		// Video loop
		if (!empty($element_options['video_loop'])) {
			$video_params .= ' data-loop="1"';
		} else {
			$video_params .= ' data-loop="0"';
		}
		
		// Video volume
		if (!empty($element_options['video_volume'])) {
			$video_params .= ' data-volume="'.$element_options['video_volume'].'"';
		} else {
			$video_params .= ' data-volume="0"';
		}
		
		// Video start at
		if (!empty($element_options['video_start_at'])) {
			$video_params .= ' data-start="'.$element_options['video_start_at'].'"';
		} else {
			$video_params .= ' data-start=""';
		}
		
		// Video stop at
		if (!empty($element_options['video_stop_at'])) {
			$video_params .= ' data-end="'.$element_options['video_stop_at'].'"';
		} else {
			$video_params .= ' data-end=""';
		}
	}
}

// Video style
if (!empty($element_options['margin'])) {
	$style['margin'] = $element_options['margin'];
}
if (!empty($element_options['padding'])) {
	$style['padding'] = $element_options['padding'];
}

// Build Video HTML
if (!empty($element_options['url'])) {
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
	
	<?php if (!empty($element_options['url'])) { ?>
	<div class="rspbld-video-container"<?php echo RSPageBuilderHelper::buildStyle($video_style); ?>>
		<div id="<?php echo $id; ?>" class="<?php echo $video_class; ?>"<?php echo RSPageBuilderHelper::buildStyle($container_style); ?> <?php echo $video_params; ?>></div>
	</div>
	<?php } ?>
</div>
<?php } ?>