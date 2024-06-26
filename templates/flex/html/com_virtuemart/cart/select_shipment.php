<?php
/**
 *
 * Template for the shipment selection
 *
 * @package	VirtueMart
 * @subpackage Cart
 * @author Max Milbers
 *
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: cart.php 2400 2010-05-11 19:30:47Z milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');


if (VmConfig::get('oncheckout_show_steps', 1)) {
	echo '<div class="checkoutStep" id="checkoutStep2">' . vmText::_('COM_VIRTUEMART_USER_FORM_CART_STEP2') . '</div>';
}

if ($this->layoutName!=$this->cart->layout) {
$headerLevel = 1;
if($this->cart->getInCheckOut()){
	$buttonclass = 'button vm-button-correct';
} else {
	$buttonclass = 'default';
}
?>
<form method="post" id="shipmentForm" name="chooseShipmentRate" action="<?php echo JRoute::_('index.php'); ?>" class="form-validate">
	<?php
	} else {
		$headerLevel = 3;
		$buttonclass = 'vm-button-correct';
	}

	if($this->cart->virtuemart_shipmentmethod_id){
		
		echo '<h5>'.vmText::_('COM_VIRTUEMART_CART_SELECTED_SHIPMENT_SELECT').'</h5>';
		echo '<div style="margin-top:25px;" class="clear"></div><hr /><div style="margin-top:35px;" class="clear"></div>';
		
	} else {
		echo '<h'.$headerLevel.' class="vm-shipment-header-select">'.vmText::_('COM_VIRTUEMART_CART_SELECT_SHIPMENT').'</h'.$headerLevel.'>';
	}

	if ($this->found_shipment_method ) {
		echo '<div class="select_vm_wrap">';
		if (VmConfig::get('oncheckout_opc') == 0) {
			echo '<div class="col-md-offset-2 col-sm-8 col-md-offset-2">';
		}
		echo '<fieldset class="vm-payment-shipment-select vm-shipment-select vm-select">';
		// if only one Shipment , should be checked by default
		foreach ($this->shipments_shipment_rates as $shipment_shipment_rates) {
			if (is_array($shipment_shipment_rates)) {
				foreach ($shipment_shipment_rates as $shipment_shipment_rate) {
					echo '<div class="vm-shipment-plugin-single">'.$shipment_shipment_rate.'</div>';
				}
			}
		}
		echo '</fieldset>';
		if (VmConfig::get('oncheckout_opc') == 0) {
			echo '</div>';
		}
		echo '</div>';
		//echo '<div style="margin-top:35px;" class="clear"></div><hr />';
	} else {
		echo '<h'.$headerLevel.'>'.$this->shipment_not_found_text.'</h'.$headerLevel.'>';
	}
	?>
  
 	<div class="control-buttons">
		<?php
		$dynUpdate = '';
		if( VmConfig::get('oncheckout_ajax',false)) {
			$dynUpdate=' data-dynamic-update="1" ';
		 } ?>
         
          <?php if ((VmConfig::get('oncheckout_opc') == 0) || (VmConfig::get('oncheckout_ajax') == false)) { ?>
         <div style="height:5px;" class="clear"></div><hr style="margin:0 auto 20px;" />
		<button style="margin-left:5px;margin-right:5px;" name="updatecart" class="vm-button-correct" type="submit" <?php echo $dynUpdate ?> ><?php echo vmText::_('COM_VIRTUEMART_SAVE'); ?></button>
        <?php } ?>
        
		<?php if ($this->layoutName!=$this->cart->layout) { ?> 
			<button style="padding:6px 17px;" class="<?php echo $buttonclass ?>" type="reset" onClick="window.location.href='<?php echo JRoute::_('index.php?option=com_virtuemart&view=cart&task=cancel'); ?>'" ><?php echo vmText::_('COM_VIRTUEMART_CANCEL'); ?></button>
		<?php  } ?>
	</div>

<?php if ($this->layoutName!=$this->cart->layout) { ?> 
    <input type="hidden" name="option" value="com_virtuemart" />
	<input type="hidden" name="view" value="cart" />
	<input type="hidden" name="task" value="updatecart" />
	<input type="hidden" name="controller" value="cart" />
</form>
<?php
}
?>

