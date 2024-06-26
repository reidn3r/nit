<?php
/**
*
* Orderlist
* NOTE: This is a copy of the edit_orderlist template from the user-view (which in turn is a slighly
*       modified copy from the backend)
*
* @package	VirtueMart
* @subpackage Orders
* @author Oscar van Eijk, Andrew Hutson
* @link https://virtuemart.net
* @copyright Copyright (c) 2004 - 2016 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: list.php 10573 2022-01-19 11:33:57Z Milbo $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die;

$ajaxUpdate = '';
if(VmConfig::get ('ajax_order', TRUE)){
	$ajaxUpdate = 'data-dynamic-update="1"';
} 
?>
<div class="vm-wrap">
    <div class="vm-orders-information"></div>
	<div class="vm-orders-list">
<h1 class="mt-4 mb-4"><svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" fill="currentColor" class="bi bi-list-check mx-2 me-3 major_color-lighten-10" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3.854 2.146a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 3.293l1.146-1.147a.5.5 0 0 1 .708 0zm0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 7.293l1.146-1.147a.5.5 0 0 1 .708 0zm0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z"/></svg><?php echo vmText::_('COM_VIRTUEMART_ORDERS_VIEW_DEFAULT_TITLE'); ?></h1><hr />
<?php
		// jviewport-height50
if (count($this->orderlist) == 0) {
	echo '<div class="row px-3 px-sm-2 px-md-1 my-5">' . shopFunctionsF::getLoginForm(false,$this->trackingByOrderPass) . '</div>';
} else { ?>	
<div id="editcell">
	<table class="table adminlist" width="80%">
	<thead>
	<tr>
		<th>
			<?php echo vmText::_('COM_VIRTUEMART_ORDER_LIST_ORDER_NUMBER'); ?>
		</th>
		<th>
			<?php echo vmText::_('COM_VIRTUEMART_ORDER_LIST_CDATE'); ?>
		</th>
		<!--th>
			<?php //echo vmText::_('COM_VIRTUEMART_ORDER_LIST_MDATE'); ?>
		</th -->
		<th>
			<?php echo vmText::_('COM_VIRTUEMART_ORDER_LIST_STATUS'); ?>
		</th>
		<th>
			<?php echo vmText::_('COM_VIRTUEMART_ORDER_LIST_TOTAL'); ?>
		</th>
	</tr>
	</thead>
	<?php
		$k = 0;
		foreach ($this->orderlist as $row) {
			$editlink = JRoute::_('index.php?option=com_virtuemart&view=orders&layout=details&order_number=' . $row->order_number, FALSE);
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td align="left">
					<a href="<?php echo $editlink; ?>" rel="nofollow" <?php echo $ajaxUpdate?> ><?php echo $row->order_number; ?></a>
					<?php echo shopFunctionsF::getInvoiceDownloadButton($row) ?>
				</td>
				<td align="left">
					<?php echo vmJsApi::date($row->created_on,'LC4',true); ?>
				</td>
				<!--td align="left">
					<?php //echo vmJsApi::date($row->modified_on,'LC3',true); ?>
				</td -->
				<td align="left">
					<?php echo shopFunctionsF::getOrderStatusName($row->order_status); ?>
				</td>
				<td align="left">
					<?php echo $row->currency->priceDisplay($row->order_total, $row->currency); ?>
				</td>
			</tr>
	<?php
			$k = 1 - $k;
		}
	?>
	</table>
</div>
<?php } ?>
	</div>
</div>
<?php
if(VmConfig::get ('ajax_order', TRUE)){
/*$j = "Virtuemart.containerSelector = '.vm-orders-information';
Virtuemart.container = jQuery(Virtuemart.containerSelector);";

vmJsApi::addJScript('ajax_order',$j);*/
vmJsApi::jDynUpdate('.vm-orders-information');
}
?>
