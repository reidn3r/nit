<?php
/**
 * Flex @package Helix Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

vmJsApi::vmValidator();

?>
<div id="cart-view" class="cart-view">
	<div class="vm-cart-header-container">
		<div class="width50 floatleft vm-cart-header">
			<h1><?php echo vmText::_ ('COM_VIRTUEMART_CART_TITLE'); ?></h1>
			<div class="payments-signin-button"></div>
		</div>
		<?php if (VmConfig::get ('oncheckout_show_steps', 1) ){
            if($this->checkout_task == 'checkout') {
                echo '<div class="checkoutStep" id="checkoutStep1">' . vmText::_ ('COM_VIRTUEMART_USER_FORM_CART_STEP1') . '</div>';
            } else { //if($this->checkout_task == 'confirm') {
                echo '<div class="checkoutStep" id="checkoutStep4">' . vmText::_ ('COM_VIRTUEMART_USER_FORM_CART_STEP4') . '</div>';
            }
        }  ?>
        <div class="width50 floatleft right vm-continue-shopping">
                <?php // Continue Shopping Button
                if (!empty($this->continue_link_html)) { ?>
                    <span class="btn-continue"><i class="pe pe-7s-refresh"></i><?php echo $this->continue_link_html; ?> </span>
                <?php } ?>
        </div>
        <div class="clear"></div>
	</div>


	<?php
	$uri = vmUri::getCurrentUrlBy('get');
	$uri = str_replace(array('?tmpl=component','&tmpl=component'),'',$uri);
	echo '<hr class="mb-4" />' . shopFunctionsF::getLoginForm ($this->cart, FALSE,$uri) . '<div class="clear"></div>'; 
	
	if (VmConfig::get ('oncheckout_show_register', 1) && !$this->cart->user->virtuemart_user_id) {
		echo '<hr class="mt-4" /><div class="jumbotron rounded p-4 d-flex flex-row black_bckg-50 my-4 svgwhite"><h5 style="font-size:130%;" class="pe-va mt-2 mb-lg-3 mx-3 mb-sm-3">'. vmText::_('MOD_NEW_REGISTER') .'</h5>
		<a class="btn btn-primary sppb-btn-3d" href="'. JRoute::_('index.php?option=com_virtuemart&view=user') . '"><i style="font-size:145%;" class="pe pe-7s-user pe-va"></i>'. vmText::_('COM_VIRTUEMART_ORDER_REGISTER') .'</a></div><div style="margin:0;padding:0;" class="clear"></div>';
	}

	// This displays the form to change the current shopper
	if ($this->allowChangeShopper and !$this->isPdf){
		echo $this->loadTemplate ('shopperform');
	}


	$taskRoute = '';
	?><form method="post" id="checkoutForm" name="checkoutForm" action="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=cart' . $taskRoute, $this->useXHTML, $this->useSSL); ?>">
		<?php
		if(!$this->isPdf and VmConfig::get('multixcart')=='byselection'){
			if (!class_exists('ShopFunctions')) require(VMPATH_ADMIN . DS . 'helpers' . DS . 'shopfunctions.php');
			echo shopFunctions::renderVendorFullVendorList($this->cart->vendorId);
			?><input type="submit" name="updatecart" title="<?php echo vmText::_('COM_VIRTUEMART_SAVE'); ?>" value="<?php echo vmText::_('COM_VIRTUEMART_SAVE'); ?>" class="button"  style="margin-left: 10px;"/><?php
		}
		echo $this->loadTemplate ('address');
		// This displays the pricelist MUST be done with tables, because it is also used for the emails
		echo $this->loadTemplate ('pricelist');

		if (!empty($this->checkoutAdvertise)) {
			?> <div id="checkout-advertise-box"> <?php
			foreach ($this->checkoutAdvertise as $checkoutAdvertise) {
				?>
				<div class="checkout-advertise">
					<?php echo $checkoutAdvertise; ?>
				</div>
			<?php
			}
			?></div><?php
		}

		echo $this->loadTemplate ('cartfields');

		?> <div class="checkout-button-top"> <?php
			echo $this->checkout_link_html;
			?></div><div class="clear"></div>

		<?php // Continue and Checkout Button END ?>
		<input type='hidden' name='order_language' value='<?php echo $this->order_language; ?>'/>
		<input type='hidden' name='task' value='updatecart'/>
		<input type='hidden' name='option' value='com_virtuemart'/>
		<input type='hidden' name='view' value='cart'/>
	</form>


<?php

if(VmConfig::get('oncheckout_ajax',false)){
	vmJsApi::addJScript('updDynamicListeners',"
if (typeof Virtuemart.containerSelector === 'undefined') Virtuemart.containerSelector = '#cart-view';
if (typeof Virtuemart.container === 'undefined') Virtuemart.container = jQuery(Virtuemart.containerSelector);

function r(f){/in/.test(document.readyState)?setTimeout(\'r(\'+f+\')\',9):f()}r(function(){
	if (Virtuemart.container)
		Virtuemart.updDynFormListeners();
}); ");
}


vmJsApi::addJScript('vm.checkoutFormSubmit',"
Virtuemart.bCheckoutButton = function(e) {
	e.preventDefault();
	jQuery(this).vm2front('startVmLoading');
	jQuery(this).attr('disabled', 'true');
	jQuery(this).removeClass( 'vm-button-correct' );
	jQuery(this).addClass( 'vm-button' );
	jQuery(this).fadeIn( 400 );
	var name = jQuery(this).attr('name');
	var div = '<input name=\"'+name+'\" value=\"1\" type=\"hidden\">';

	jQuery('#checkoutForm').append(div);
	//Virtuemart.updForm();
	jQuery('#checkoutForm').submit();
}
function r(f){/in/.test(document.readyState)?setTimeout(\'r(\'+f+\')\',9):f()}r(function(){
	jQuery(this).vm2front('stopVmLoading');
	var el = jQuery('#checkoutFormSubmit');
	el.unbind('click dblclick');
	el.on('click dblclick',Virtuemart.bCheckoutButton);
});
	");

if( !VmConfig::get('oncheckout_ajax',false)) {
	vmJsApi::addJScript('vm.STisBT',"
		function r(f){/in/.test(document.readyState)?setTimeout(\'r(\'+f+\')\',9):f()}r(function(){

			if ( jQuery('#STsameAsBTjs').is(':checked') ) {
				jQuery('#output-shipto-display').hide();
			} else {
				jQuery('#output-shipto-display').show();
			}
			jQuery('#STsameAsBTjs').click(function(event) {
				if(jQuery(this).is(':checked')){
					jQuery('#STsameAsBT').val('1') ;
					jQuery('#output-shipto-display').hide();
				} else {
					jQuery('#STsameAsBT').val('0') ;
					jQuery('#output-shipto-display').show();
				}
				var form = jQuery('#checkoutFormSubmit');
				form.submit();
			});
		});
	");
}

$this->addCheckRequiredJs();
?><div style="display:none;" id="cart-js">
<?php echo vmJsApi::writeJS(); ?>
</div>
</div><br class="row hidden-sm hidden-md hidden-lg" />