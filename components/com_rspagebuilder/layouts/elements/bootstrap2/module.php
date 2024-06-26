<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

$element_options	= RSPageBuilderHelper::escapeHtmlArray($displayData['options']);
$class				= 'rspbld-module';
$title_show			= (!isset($element_options['title_show']) || (isset($element_options['title_show']) && ($element_options['title_show'] == '1'))) ? '1' : '0';
$subtitle_show		= (!isset($element_options['subtitle_show']) || (isset($element_options['subtitle_show']) && ($element_options['subtitle_show'] == '1'))) ? '1' : '0';
$style 				= array();

if (!empty($element_options['module'])) {
	$user			= JFactory::getUser();
	$user_levels	= implode(',', $user->getAuthorisedViewLevels());
	$language		= JFactory::getLanguage()->getTag();
	
	if (RSPageBuilderHelper::getClient('site')) {
		$db			= JFactory::getDbo();
		$query		= $db->getQuery(true);
		$now		= JFactory::getDate()->toSql();
		$null_date	= $db->getNullDate();
		
		$query->select('*');
		$query->from($db->qn('#__modules'));
		$query->where($db->qn('id').' = '.$db->q($element_options['module']));
		$query->where('('.$db->qn('publish_up').' = '.$db->q($null_date).' OR '.$db->qn('publish_up').' <= '.$db->q($now).')');
		$query->where('('.$db->qn('publish_down').' = '.$db->q($null_date).' OR '.$db->qn('publish_down').' >= '.$db->q($now).')');
		$query->where($db->qn('published').'='. $db->q(1));
		$query->where($db->qn('client_id').'=0');
		$query->where($db->qn('access').' IN ('.$user_levels.')');
		
		$db->setQuery($query);
		$module = $db->loadObject();
		
		// Module title
		if (!empty($element_options['title']) && !empty($title_show)) {
			
			// Module title style
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
		
		// Module subtitle
		if (!empty($element_options['subtitle']) && !empty($subtitle_show)) {
			
			// Module subtitle style
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
		
		// Module style
		if (!empty($element_options['margin'])) {
			$style['margin'] = $element_options['margin'];
		}
		if (!empty($element_options['padding'])) {
			$style['padding'] = $element_options['padding'];
		}
		
		// Module class
		if (!empty($element_options['class'])) {
			$class .= ' '.$element_options['class'];
		}
		
		// Build Module HTML
		if ($module) {
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
	
	<?php echo JModuleHelper::renderModule($module); ?>
</div>
<?php
		}
	} else { ?>
<div class="rspbld-alert">
	<div class="alert alert-info fade in">
		<h3 class="alert-heading"><?php echo JText::_('COM_RSPAGEBUILDER_MODULE_NO_PREVIEW'); ?></h3>
		<?php echo JText::_('COM_RSPAGEBUILDER_MODULE_NO_PREVIEW_DESC'); ?>
	</div>
</div>
<?php
	}
}