<?php
/**
 * Flex @package Helix Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Factory;

if (JVERSION < 4) {
	HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers');
	HTMLHelper::_('behavior.caption');
	HTMLHelper::_('behavior.core');
	
	Factory::getDocument()->addScriptDeclaration("
	jQuery(function($) {
		$('.categories-list').find('[id^=category-btn-]').each(function(index, btn) {
			var btn = $(btn);
			btn.on('click', function() {
				btn.find('span').toggleClass('icon-plus');
				btn.find('span').toggleClass('icon-minus');
				if (btn.attr('aria-label') === Joomla.JText._('JGLOBAL_EXPAND_CATEGORIES'))
				{
					btn.attr('aria-label', Joomla.JText._('JGLOBAL_COLLAPSE_CATEGORIES'));
				} else {
					btn.attr('aria-label', Joomla.JText._('JGLOBAL_EXPAND_CATEGORIES'));
				}		
			});
		});
	});");
} else {
	// Joomla 4...
	/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
	$wa = $this->document->getWebAssetManager();
	$wa->getRegistry()->addExtensionRegistryFile('com_categories');
	$wa->usePreset('com_categories.shared-categories-accordion');
	//
}

// Add strings for translations in Javascript.
Text::script('JGLOBAL_EXPAND_CATEGORIES');
Text::script('JGLOBAL_COLLAPSE_CATEGORIES');

?>
<div class="categories-list<?php echo $this->pageclass_sfx; ?>">
	<?php
		echo LayoutHelper::render('joomla.content.categories_default', $this);
		echo $this->loadTemplate('items');
	?>
</div>
