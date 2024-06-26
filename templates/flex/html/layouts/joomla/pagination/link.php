<?php
/**
 * Flex @package Helix3 Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('JPATH_BASE') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

$item = $displayData['data'];
$display = $item->text;
$app = Factory::getApplication();

$buttoniconstart = '';
$buttoniconend = '';

switch ((string) $item->text)
{
	// Check for "Start" item
	case Text::_('JLIB_HTML_START') :
		//$icon = $app->getLanguage()->isRtl() ? '' : '';
		$icon = Text::_('JLIB_HTML_START');
		$aria = Text::sprintf('JLIB_HTML_GOTO_POSITION', strtolower($item->text));
		$cls = '';
		$buttoncls = ' class="button btn-previous"';
		$buttoniconstart = '<i>'; 
		$buttoniconend = '</i>';
		break;

	// Check for "Prev" item
	case $item->text === Text::_('JPREV') :
		$item->text = Text::_('JPREVIOUS');
		$icon = $app->getLanguage()->isRtl() ? '<i class="ap-right-2"></i>' : '<i class="ap-left-2"></i>';
		$aria =Text::sprintf('JLIB_HTML_GOTO_POSITION', strtolower($item->text));
		$cls = ' class="previous"';
		break;

	// Check for "Next" item
	case Text::_('JNEXT') :
		$icon = $app->getLanguage()->isRtl() ? '<i class="ap-left-2"></i>' : '<i class="ap-right-2"></i>';
		$aria = Text::sprintf('JLIB_HTML_GOTO_POSITION', strtolower($item->text));
		$cls = ' class="next"';
		break;

	// Check for "End" item
	case Text::_('JLIB_HTML_END') :
		//$icon = $app->getLanguage()->isRtl() ? 'fa fa-angle-double-left' : 'fa fa-angle-double-right';
		$icon = Text::_('JLIB_HTML_END');
		$aria = Text::sprintf('JLIB_HTML_GOTO_POSITION', strtolower($item->text));
		$cls = '';
		$buttoncls = ' class="button btn-next"';
		$buttoniconstart = '<i>'; 
		$buttoniconend = '</i>';
		break;

	default:
		$icon = null;
		$aria = Text::sprintf('JLIB_HTML_GOTO_PAGE', strtolower($item->text));
		$cls = '';
		break;
}

if ($icon !== null)
{
	//$display = '<span class="' . $icon . '" aria-hidden="true"></span>';
	$display = $icon;
}

if ($displayData['active'])
{
	if ($item->base > 0)
	{
		$limit = 'limitstart.value=' . $item->base;
	}
	else
	{
		$limit = 'limitstart.value=0';
	}

	$class = 'active';

	if ($app->isClient('administrator'))
	{
		$link = 'href="#" onclick="document.adminForm.' . $item->prefix . $limit . '; Joomla.submitform();return false;"';
	}
	elseif ($app->isClient('site'))
	{
		$link = 'href="' . $item->link . '"';
	}
}
else
{
	$class = (property_exists($item, 'active') && $item->active) ? 'active' : 'disabled';
}
if ($displayData['active']) : ?>
<a<?php echo $cls; ?> aria-label="<?php echo $aria; ?>" <?php echo $link; ?>><?php echo $buttoniconstart . $display . $buttoniconend; ?></a>
<?php elseif (isset($item->active) && $item->active) : ?>
<?php $aria = Text::sprintf('JLIB_HTML_PAGE_CURRENT', strtolower($item->text)); ?>
<a aria-current="true" aria-label="<?php echo $aria; ?>" class="page-link"><?php echo $buttoniconstart . $display . $buttoniconend; ?></a>
<?php else : 
     // echo '<span class="page-link" aria-hidden="true">'. $display .'</span>'; 
?>
<?php endif; ?>
