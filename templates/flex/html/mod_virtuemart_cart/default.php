<?php
/**
 * Flex @package VM ajax cart
 * Template Name - Flex
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
*/
// no direct access
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;


//if ($data->totalProduct>1) $data->totalProductTxt = vmText::sprintf('', $data->totalProduct);

	if ((int) $data->totalProduct == 0) {
		$basket = 'total_products empty_basket';
		$empty_cart = 'EMPTY CART';
	} else {
		$basket = 'total_products items-added';
		$empty_cart = '';
	}
	//Add js and css files
	$doc = Factory::getDocument();
	$doc->addScript( Uri::root(true) . '/templates/flex/js/vm-cart.js' );

	if ($data->totalProduct>1) $data->totalProductTxt = $data->totalProduct;
	else if ($data->totalProduct == 1) $data->totalProductTxt = vmText::_('COM_VIRTUEMART_CART_ONE_PRODUCT');
	else $data->totalProductTxt = vmText::_('COM_VIRTUEMART_EMPTY_CART');

	$data->cart_show = '<a class="btn btn-primary sppb-btn-3d" href="'.$data->cart_show_link.'" rel="nofollow" ><i class="fas fa-shopping-cart"></i>'.$data->linkName.'</a>';
?>
  
<!-- Virtuemart Ajax Cart -->
<div class="vmCartModule <?php echo $params->get('moduleclass_sfx'); ?> d-flex float-start px-0 mx-0" id="vmCartModule<?php echo $params->get('moduleid_sfx'); ?>" >
     <div id="cart-menu">
        <a id="cd-menu-trigger" href="#0" class="cd-cart">
        <i class="pe pe-7s-cart"></i>
            <?php if ((int) $data->totalProduct == 0) { ?>
                <div class="<?php echo $basket; ?>">0</div>
            <?php } else { ?>
            	<div class="total_products <?php echo $basket; ?>">
				   <?php //echo $data->totalProductTxt; ?>
				   <?php echo $data->totalProduct; ?>
				</div>
            <?php } ?>
        </a>
    </div>
	<nav id="cd-lateral-nav">
		<div class="cd-navigation">
          <h5 style="text-align:center;"><?php echo vmText::_('VM_RECENTLY_ADDED_ITEMS') ?></h5><hr />
      
			<?php if ($show_product_list) { ?>
				<div id="hiddencontainer" class="hiddencontainer" style="display:none;">
					<div class="vmcontainer">
						<div class="product_row">
							<div class="quantity"></div>
							<div class="image cart-image pull-left float-start"></div>                
							<div class="cart-item">
							   <div class="product_name"></div>
								<?php if ($show_price and $currencyDisplay->_priceConfig['salesPrice'][0]) { ?>
									<div class="subtotal_with_tax"></div>  
								<?php } ?>
								<div class="customProductData"></div>                    
							  </div>  
						   <hr style="width:100%;clear:both;" /> 
						</div>
					</div>
				</div>
				<div class="vm_cart_products">
					<div class="vmcontainer">
						<?php  foreach ($data->products as $i=>$product){ ?>  
							 <div class="cd-single-item">   
								<div class="quantity"><?php echo $product['quantity']; ?></div>
								<div class="image cart-image pull-left float-start">
									<?php //echo $product['image']; ?>
									<?php
										if (VmConfig::get('oncheckout_show_images')) {
										echo !empty($cart->products[$i]->images[0]) ? $cart->products[$i]->images[0]->displayMediaThumb ('', FALSE) : '';
										} ?>
								</div>
								<div class="cart-item">
									<div class="product_name"><?php echo $product['product_name'] ?></div>                
									<?php if ($show_price and $currencyDisplay->_priceConfig['salesPrice'][0]) { ?>
									  <div class="subtotal_with_tax"><?php echo $product['subtotal_with_tax'] ?></div>
									<?php } ?>
									<?php if ( !empty($product['customProductData']) ) { ?>
										<div class="customProductData"><?php echo $product['customProductData'] ?></div>
									<?php } ?>
								</div>
							  <hr style="width:100%;clear:both;display:block;" />
							</div>
						<?php } ?>

						<?php if(empty($data->products)){ ?>
							<div class="empty_cart"><h3><?php echo vmText::_('VM_EMPTY_CART'); ?></h3>
							<i class="pe pe-7s-cart">
							<span class="fas fa-ban"></span>
							</i>
							</div>
						<?php } ?>   

				 </div>    
				</div>
			<?php } ?>
            <div class="total">
                <?php if ($data->totalProduct and $show_price and $currencyDisplay->_priceConfig['salesPrice'][0]) { ?>
                <?php echo $data->billTotal; ?>
                <?php } ?>
            </div>

            <div style="clear:both;display:block;" class="show_cart">
                <?php if ($data->totalProduct) echo $data->cart_show; ?>
            </div>
			
        
		</div><?php // END div class="cd-navigation"; ?>
	</nav>
<?php
$view = vRequest::getCmd('view');
if($view!='cart' and $view!='user'){
	?><div class="payments-signin-button" ></div><?php
}
?>
<noscript>
<?php echo vmText::_('MOD_VIRTUEMART_CART_AJAX_CART_PLZ_JAVASCRIPT') ?>
</noscript>
</div>
