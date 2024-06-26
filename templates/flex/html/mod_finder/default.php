<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_finder
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\Module\Finder\Site\Helper\FinderHelper;

//JHtml::_('jquery.framework');
//JHtml::_('formbehavior.chosen');
//JHtml::_('bootstrap.tooltip');

// Load the smart search component language file.
//$lang = Factory::getLanguage();
//$lang->load('com_finder', JPATH_SITE);
$lang = $app->getLanguage();
$lang->load('com_finder', JPATH_SITE);

$suffix = $params->get('moduleclass_sfx');

$output = '';

// Input
$input = '<input type="text" name="q" id="mod-finder-searchword' . $module->id . '" class="inputbox search-query rounded" size="' . $params->get('field_size', 20) . '" value="' . htmlspecialchars($app->input->get('q', '', 'string'), ENT_COMPAT, 'UTF-8') . '"' . ' placeholder="' . Text::_('MOD_FINDER_SEARCH_VALUE') . '"/>';

if ($params->get('show_button', 0) == 0) {
	// No need for this
	// $output .= '<input type="submit" class="hidden finder" />';
}

// Label
$showLabel  = $params->get('show_label', 1);
$labelClass = (!$showLabel ? 'element-invisible ' : '') . 'finder' . $suffix;
if ($showLabel) {
	$output .= '<div class="clearfix w-100 mb-2"><label for="mod-finder-searchword' . $module->id . '" class="' . $labelClass . ' mb-2 ">' . $params->get('alt_label', Text::_('JSEARCH_FILTER_SUBMIT')) . '</label><br /></div>';
}

$output .= '<div class="search flex-search">';
if ($params->get('show_button', 0))
{
	//$output .= '<div class="mod-finder__search input-group">';
	$output .= $input;
	$output .= '<button class="btn sppb-btn-default btn-block w-100 py-1 px-0 mt-2 mx-0 rounded" type="submit">';
	//$output .= '<span class="icon-search icon-white" aria-hidden="true"></span>';
	$output .= '<i class="pe pe-7s-search pe-lg pe-va me-1" aria-hidden="true"></i>';
	$output .= Text::_('JSEARCH_FILTER_SUBMIT');
	$output .= '</button>';
	//$output .= '</div>';
}
else
{
	$output .= $input;
}
$output .= '</div>';


/*
HTMLHelper::_('stylesheet', 'com_finder/finder.css', array('version' => 'auto', 'relative' => true));

$script = "
jQuery(document).ready(function() {
	var value, searchword = jQuery('#mod-finder-searchword" . $module->id . "');

		// Get the current value.
		value = searchword.val();

		// If the current value equals the default value, clear it.
		searchword.on('focus', function ()
		{
			var el = jQuery(this);

			if (el.val() === '" . Text::_('MOD_FINDER_SEARCH_VALUE', true) . "')
			{
				el.val('');
			}
		});

		// If the current value is empty, set the previous value.
		searchword.on('blur', function ()
		{
			var el = jQuery(this);

			if (!el.val())
			{
				el.val(value);
			}
		});

		jQuery('#mod-finder-searchform" . $module->id . "').on('submit', function (e)
		{
			e.stopPropagation();
			var advanced = jQuery('#mod-finder-advanced" . $module->id . "');

			// Disable select boxes with no value selected.
			if (advanced.length)
			{
				advanced.find('select').each(function (index, el)
				{
					var el = jQuery(el);

					if (!el.val())
					{
						el.attr('disabled', 'disabled');
					}
				});
			}
		});";

// This segment of code sets up the autocompleter.
if ($params->get('show_autosuggest', 1))
{
	HTMLHelper::_('script', 'jui/jquery.autocomplete.min.js', array('version' => 'auto', 'relative' => true));

	$script .= "
	var suggest = jQuery('#mod-finder-searchword" . $module->id . "').autocomplete({
		serviceUrl: '" . Route::_('index.php?option=com_finder&task=suggestions.suggest&format=json&tmpl=component') . "',
		paramName: 'q',
		minChars: 1,
		maxHeight: 400,
		width: 300,
		zIndex: 9999,
		deferRequestBy: 500
	});";
}

$script .= '});';

Factory::getDocument()->addScriptDeclaration($script);
*/


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
<div class="finder<?php echo $suffix; ?>">
	<form id="mod-finder-searchform<?php echo $module->id; ?>" action="<?php echo Route::_($route); ?>" method="get" class="form-search" role="search">
		<?php
		// Show the form fields.
		echo $output;
		?>
		<?php $show_advanced = $params->get('show_advanced', 0); ?>
		<?php if ($show_advanced == 2) : ?>
			<div class="clearfix" style="margin-top:-10px;"></div><br />
			<a class="btn-block" href="<?php echo JRoute::_($route); ?>"><?php echo JText::_('COM_FINDER_ADVANCED_SEARCH'); ?></a>
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
