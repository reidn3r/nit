<?php
/**
 * Flex @package Layout for the add to cart popup
 * Template Name - Flex
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
*/
// no direct access
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

$media_model 	= VmModel::getModel('media');
$product_model 	= VmModel::getModel('product');

if (!class_exists('CurrencyDisplay')) require(VMPATH_ADMIN . DS . 'helpers' . DS . 'currencydisplay.php');
$currency = CurrencyDisplay::getInstance( );
?>
<!-- popup cart -->
<div class="popup-cart mx-auto"> 

	<?php if($this->products){ ?>
	<h3 class="title"><?php echo Text::_('VM_POPUP_PRODUCT_ADDED_SUCCESS'); ?> 
		<span><?php echo Text::_('VM_POPUP_YOUR_SH0PPING_CART'); ?></span>
	</h3>
	
	<div class="item-wrap mx-auto row">
<?php 
if ($this->products and is_array($this->products) and count($this->products)>0 ) {
	foreach($this->products as $product) {
		if($product->quantity>0){
			$images  = $media_model->createMediaByIds($product->virtuemart_media_id, $product->quantity); 
			$prices  = $product_model->getPrice($product->virtuemart_product_id, 1);
			?>
			<div class="col-12 col-sm-5 col-md-5 px-5 px-sm-2 p-md-1 mb-5 mb-sm-3">
				<?php if(isset($images[0]) && $images[0]) {
					echo $images[0]->displayMediaThumb ('class="ProductImage"', FALSE); 
				} ?>	
			</div>
			<div class="col-12 col-sm-7 col-md-7 mt-0 mt-md-4 px-2">
				<h3 class="item-name"><?php echo $product->product_name; ?></h3>
				<div class="vm-price-box">
					<?php if ( isset($product->allPrices[0]['product_override_price']) && round($product->allPrices[0]['product_override_price']) != 0) { ?>
						<ins>
							<?php echo $currency->createPriceDiv ('salesPrice', '', $prices, FALSE, FALSE, 1.0, TRUE); ?>
							<?php echo $currency->createPriceDiv ('salesPriceTt', '', $prices, FALSE, FALSE, 1.0, TRUE); ?>
						</ins>
						<del>    
							<?php echo $currency->createPriceDiv ('basePriceVariant', '', $prices, FALSE, FALSE, 1.0, TRUE); ?>
						</del>
					<?php } else{ ?>
						<ins>
							<?php echo $currency->createPriceDiv ('salesPrice', '', $prices, FALSE, FALSE, 1.0, TRUE); ?>
							<?php echo $currency->createPriceDiv ('salesPriceTt', '', $prices, FALSE, FALSE, 1.0, TRUE); ?>
						</ins>
					<?php } ?>
				</div>
				<?php 
					if($product->quantity>0){
					$quantity = isset($product->quantityAdded)? $product->quantityAdded: $product->quantity;
				?>
				<p class="popup-cart-product-quantity w-100">
					<span><?php echo Text::_('VM_POPUP_SH0PPING_CART_QUANTITY'); ?> </span>
					<?php 
						if($product->quantity>0){
							$quantity = isset($product->quantityAdded) ? $product->quantityAdded : $product->quantity;
							echo '<span class="badge bg-secondary fs-6 pe-va">'. $quantity .'</span>';
						}
					?>
				</p>
				<?php } ?>
			</div>
		<?php } else { 
			
				if(!empty($product->errorMsg)){
					echo '<div>'.$product->errorMsg.'</div>';
				}
			} // else
		} // END:: foreach
	} // has product 
}
?>
	</div> <!-- //item-wrap -->
    	<div class="clear"></div>
	
	<div class="button-group row">
		<a class="continue_link button" href="<?php echo $this->continue_link; ?>" >
			<?php echo vmText::_('COM_VIRTUEMART_CONTINUE_SHOPPING'); ?> 
		</a>
		<a class="showcart floatright" href="<?php echo  $this->cart_link; ?>">
			<?php echo vmText::_('COM_VIRTUEMART_CART_SHOW'); ?>
		</a>
	</div> <!-- //button-group -->

</div> <!-- //.popup-cart -->
<br style="clear:both">
