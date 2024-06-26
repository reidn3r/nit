<?php
/**
 * Flex @package Helix Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
//vmJsApi::jQuery();
//vmJsApi::chosenDropDowns();
HTMLHelper::_('formbehavior.chosen', 'select');
$currentLanguage = Factory::getLanguage();
$currentLanguageName = $currentLanguage->getName();
$isRTL = $currentLanguage->isRtl();
// Check of current language is RTL
if($isRTL) {
	$class = 'inputbox';
} else {
	$class = 'inputbox vm-chzn-select';
}
?>
<div class="currency-selector-module container-fluid px-0 mx-0 gx-0">
<!-- Currency Selector Module -->
<?php if ($text_before != '') { ?><p><?php echo $text_before ?></p><?php } ?>
<form action="<?php echo vmURI::getCleanUrl() ?>" method="post">
    <button class="btn btn-default py-1 mx-0 gx-0 col-1 col-lg-2" type="submit" name="submit" data-toggle="tooltip" title="<?php echo vmText::_('MOD_VIRTUEMART_CURRENCIES_CHANGE_CURRENCIES') ?>">
		<!--<i class="fa fa-refresh"></i>-->
		<i class="fas fa-sync"></i>
	</button>
    <?php echo HTMLHelper::_('select.genericlist', $currencies, 'virtuemart_currency_id', 'class="'.$class.' col-9 col-sm-10 col-lg-9 mx-0"', 'virtuemart_currency_id', 'currency_txt', $virtuemart_currency_id) ; ?>
</form>
</div>

