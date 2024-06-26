<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

$element_options	= RSPageBuilderHelper::escapeHtmlArray($displayData['options']);
$class				= 'rspbld-countdown-timer';
$lang_long_days		= (JText::_('COM_RSPAGEBUILDER_LONG_DAYS') == 'COM_RSPAGEBUILDER_LONG_DAYS') ? JText::_('MOD_RSPAGEBUILDER_ELEMENTS_LONG_DAYS') : JText::_('COM_RSPAGEBUILDER_LONG_DAYS');
$lang_long_hours	= (JText::_('COM_RSPAGEBUILDER_LONG_HOURS') == 'COM_RSPAGEBUILDER_LONG_HOURS') ? JText::_('MOD_RSPAGEBUILDER_ELEMENTS_LONG_HOURS') : JText::_('COM_RSPAGEBUILDER_LONG_HOURS');
$lang_long_minutes	= (JText::_('COM_RSPAGEBUILDER_LONG_MINUTES') == 'COM_RSPAGEBUILDER_LONG_MINUTES') ? JText::_('MOD_RSPAGEBUILDER_ELEMENTS_LONG_MINUTES') : JText::_('COM_RSPAGEBUILDER_LONG_MINUTES');
$lang_long_seconds	= (JText::_('COM_RSPAGEBUILDER_LONG_SECONDS') == 'COM_RSPAGEBUILDER_LONG_SECONDS') ? JText::_('MOD_RSPAGEBUILDER_ELEMENTS_LONG_SECONDS') : JText::_('COM_RSPAGEBUILDER_LONG_SECONDS');
$lang_short_days	= (JText::_('COM_RSPAGEBUILDER_SHORT_DAYS') == 'COM_RSPAGEBUILDER_SHORT_DAYS') ? JText::_('MOD_RSPAGEBUILDER_ELEMENTS_SHORT_DAYS') : JText::_('COM_RSPAGEBUILDER_SHORT_DAYS');
$lang_short_hours	= (JText::_('COM_RSPAGEBUILDER_SHORT_HOURS') == 'COM_RSPAGEBUILDER_SHORT_HOURS') ? JText::_('MOD_RSPAGEBUILDER_ELEMENTS_SHORT_HOURS') : JText::_('COM_RSPAGEBUILDER_SHORT_HOURS');
$lang_short_minutes	= (JText::_('COM_RSPAGEBUILDER_SHORT_MINUTES') == 'COM_RSPAGEBUILDER_SHORT_MINUTES') ? JText::_('MOD_RSPAGEBUILDER_ELEMENTS_SHORT_MINUTES') : JText::_('COM_RSPAGEBUILDER_SHORT_MINUTES');
$lang_short_seconds	= (JText::_('COM_RSPAGEBUILDER_SHORT_SECONDS') == 'COM_RSPAGEBUILDER_SHORT_SECONDS') ? JText::_('MOD_RSPAGEBUILDER_ELEMENTS_SHORT_SECONDS') : JText::_('COM_RSPAGEBUILDER_SHORT_SECONDS');
$title_show			= (!isset($element_options['title_show']) || (isset($element_options['title_show']) && ($element_options['title_show'] == '1'))) ? '1' : '0';
$subtitle_show		= (!isset($element_options['subtitle_show']) || (isset($element_options['subtitle_show']) && ($element_options['subtitle_show'] == '1'))) ? '1' : '0';
$wrapper_style		= array();
$countdown_style	= array();
$detail_style 		= array();

// Countdown Timer title
if (!empty($element_options['title']) && !empty($title_show)) {
	
	// Countdown Timer title style
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

// Countdown Timer subtitle
if (!empty($element_options['subtitle']) && !empty($subtitle_show)) {
	
	// Countdown Timer subtitle style
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

// Countdown Timer
if (!empty($element_options['limit']) && !empty($element_options['format'])) {
	RSPageBuilderHelper::loadAsset('component', 'jquery.countdownTimer.js');
	
	$limit						= new JDate($element_options['limit']);
	$element_options['limit']	= $limit->format('Y-m-d H:m:s');
	
	// Countdown Timer style
	if (!empty($element_options['background_color'])) {
		$wrapper_style['background-color'] = $element_options['background_color'];
	}
	if (!empty($element_options['border_radius'])) {
		$wrapper_style['border-radius'] = $element_options['border_radius'];
	}
	if (!empty($element_options['border_style'])) {
		$wrapper_style['border-style'] = $element_options['border_style'];
		
		if (!empty($element_options['border_width'])) {
			$wrapper_style['border-width'] = $element_options['border_width'];
		}
		if (!empty($element_options['border_color'])) {
			$wrapper_style['border-color'] = $element_options['border_color'];
		}
	}
	if (!empty($element_options['width'])) {
		$wrapper_style['width'] = $element_options['width'];
	}
	if (!empty($element_options['margin'])) {
		$wrapper_style['margin'] = $element_options['margin'];
	}
	if (!empty($element_options['padding'])) {
		$wrapper_style['padding'] = $element_options['padding'];
	}
	if (!empty($element_options['countdown_text_color'])) {
		$countdown_style['color'] = $element_options['countdown_text_color'];
	}
	if (!empty($element_options['countdown_font_size'])) {
		$countdown_style['font-size'] = $element_options['countdown_font_size'];
	}
	if (!empty($element_options['countdown_font_weight'])) {
		$countdown_style['font-weight'] = $element_options['countdown_font_weight'];
	}
	if (!empty($element_options['details_text_color'])) {
		$detail_style['color'] = $element_options['details_text_color'];
	}
	if (!empty($element_options['details_font_size'])) {
		$detail_style['font-size'] = $element_options['details_font_size'];
	}
	if (!empty($element_options['details_font_weight'])) {
		$detail_style['font-weight'] = $element_options['details_font_weight'];
	}
}

// Countdown Timer alignment
if (!empty($element_options['alignment'])) {
	$class .= ' '.$element_options['alignment'];
}

// Countdown Timer class
if (!empty($element_options['class'])) {
	$class .= ' '.$element_options['class'];
}

// Build Countdown Timer HTML
if ((!empty($element_options['title']) && !empty($title_show)) || (!empty($element_options['subtitle']) && !empty($subtitle_show)) || (!empty($element_options['limit']) && !empty($element_options['format']))) {
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
	
	<?php if (!empty($element_options['limit']) && !empty($element_options['format'])) { ?>
	<div class="rspbld-inner hidden<?php echo ($element_options['format'] == 'long') ? ' horizontal-details' : '' ; ?>" data-limit="<?php echo $element_options['limit']; ?>">
		<div class="wrapper days"<?php echo RSPageBuilderHelper::buildStyle($wrapper_style); ?>>
			<span class="countdown"<?php echo RSPageBuilderHelper::buildStyle($countdown_style); ?>></span>
			<span class="detail"<?php echo RSPageBuilderHelper::buildStyle($detail_style); ?>>
				<?php echo ($element_options['format'] == 'long') ? $lang_long_days : $lang_short_days; ?>
			</span>
		</div>
		<div class="wrapper hours"<?php echo RSPageBuilderHelper::buildStyle($wrapper_style); ?>>
			<span class="countdown"<?php echo RSPageBuilderHelper::buildStyle($countdown_style); ?>></span>
			<span class="detail"<?php echo RSPageBuilderHelper::buildStyle($detail_style); ?>>
				<?php echo ($element_options['format'] == 'long') ? $lang_long_hours : $lang_short_hours; ?>
			</span>
		</div>
		<div class="wrapper minutes"<?php echo RSPageBuilderHelper::buildStyle($wrapper_style); ?>>
			<span class="countdown"<?php echo RSPageBuilderHelper::buildStyle($countdown_style); ?>></span>
			<span class="detail"<?php echo RSPageBuilderHelper::buildStyle($detail_style); ?>>
				<?php echo ($element_options['format'] == 'long') ? $lang_long_minutes : $lang_short_minutes; ?>
			</span>
		</div>
		<div class="wrapper seconds"<?php echo RSPageBuilderHelper::buildStyle($wrapper_style); ?>>
			<span class="countdown"<?php echo RSPageBuilderHelper::buildStyle($countdown_style); ?>></span>
			<span class="detail"<?php echo RSPageBuilderHelper::buildStyle($detail_style); ?>>
				<?php echo ($element_options['format'] == 'long') ? $lang_long_seconds : $lang_short_seconds; ?>
			</span>
		</div>
	</div>
	<?php } ?>
</div>
<?php } ?>