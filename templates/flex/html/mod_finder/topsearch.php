<?php
/**
 * Flex @package Mod Finder (Smart Search)
 * Template Name - Flex
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
*/
// no direct access
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\Module\Finder\Site\Helper\FinderHelper;

$lang = $app->getLanguage();
$lang->load('com_finder', JPATH_SITE);

$moduleclass_sfx = $params->get('moduleclass_sfx');

$output = '';
$input = '';

// Input
$input .= '<div class="top-search-wrapper gx-0 px-0 mx-0"><div class="sp_search_input">';
$input .= '<input type="text" name="q" id="mod-finder-searchword' . $module->id . '" class="inputbox search-query rounded" size="' . $params->get('field_size', 20) . '" value="' . htmlspecialchars($app->input->get('q', '', 'string'), ENT_COMPAT, 'UTF-8') . '"' . ' placeholder="' . Text::_('MOD_FINDER_SEARCH_VALUE') . '"/>';
$input .= '</div></div>';

// Label
$showLabel  = $params->get('show_label', 1);
$labelClass = (!$showLabel ? 'element-invisible ' : '') . 'finder' . $moduleclass_sfx;
if ($showLabel) {
	$output .= '<div class="clearfix w-100 mb-2"><label for="mod-finder-searchword' . $module->id . '" class="' . $labelClass . ' mb-2 ">' . $params->get('alt_label', Text::_('JSEARCH_FILTER_SUBMIT')) . '</label><br /></div>';
}

$output .= '<div class="search flex-search">';
if ($params->get('show_button', 0))
{
	$output .= $input;
	$output .= '<button class="btn sppb-btn-default btn-block w-100 py-1 px-0 mt-2 mx-0 rounded" type="submit">';
	//$output .= '<span class="icon-search icon-white" aria-hidden="true"></span>';
	$output .= '<i class="pe pe-7s-search pe-lg pe-va me-1" aria-hidden="true"></i>';
	$output .= Text::_('JSEARCH_FILTER_SUBMIT');
	$output .= '</button>';
}
else
{
	$output .= $input;
}
$output .= '</div>';

$wa = $app->getDocument()->getWebAssetManager();
$wa->getRegistry()->addExtensionRegistryFile('com_finder');

// This segment of code sets up the autocompleter.

if ($params->get('show_autosuggest', 1))
{
	$wa->usePreset('awesomplete');
	$app->getDocument()->addScriptOptions('finder-search', array('url' => Route::_('index.php?option=com_finder&task=suggestions.suggest&format=json&tmpl=component', false)));
}
$wa->useScript('com_finder.finder');

?>
<div style="display:inline-block;" class="top-search-wrapper">
	<div class="icon-top-wrapper">
        <i class="pe pe-7s-search search-open-icon" aria-hidden="true"></i>
		<i class="pe pe-7s-close search-close-icon" aria-hidden="true"></i>
	</div>
	<div class="top-search-input-wrap" id="top-search-input-wrap">
		<div class="top-search-wrap">
			<div class="searchwrapper">		
				<div class="finder search<?php echo $moduleclass_sfx; ?>">
					<form id="mod-finder-searchform<?php echo $module->id; ?>" action="<?php echo Route::_($route); ?>" method="get" class="form-search" role="search">
						<?php
						// Show the form fields.
						echo $output;
						?>
						<?php $show_advanced = $params->get('show_advanced', 0); ?>
						<?php if ($show_advanced == 2) : ?>
							<div class="clearfix" style="margin-top:-10px;"></div><br />
							<a class="btn-block" href="<?php echo Route::_($route); ?>"><?php echo JText::_('COM_FINDER_ADVANCED_SEARCH'); ?></a>
						<?php elseif ($show_advanced == 1) : ?>
							<div style="margin:15px auto;" class="mod-finder-advanced clearfix" id="mod-finder-advanced<?php echo $module->id; ?>">
								<?php //echo JHtml::_('filter.select', $query, $params); ?>
								<?php echo HTMLHelper::_('filter.select', $query, $params); ?>
							</div>
						<?php endif; ?>
						<?php //echo modFinderHelper::getGetFields($route, (int) $params->get('set_itemid', 0)); ?>
						<?php echo FinderHelper::getGetFields($route, (int) $params->get('set_itemid', 0)); ?>
					</form>
				</div>
			</div>
		</div>
	</div> 
</div>	
