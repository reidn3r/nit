<?php
/**
 *
 * Flex @package VirtueMart
 * Template Name - Flex
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
*/
// no direct access
defined('_JEXEC') or die;

$product = $viewData['product'];

if(isset($viewData['rowHeights'])){
	$rowHeights = $viewData['rowHeights'];
} else {
	$rowHeights['customfields'] = TRUE;
}

$init = 1;
if(isset($viewData['init'])){
	$init = $viewData['init'];
}

if(!empty($product->min_order_level) and $init<$product->min_order_level){
	$init = $product->min_order_level;
}

$step=1;
if (!empty($product->step_order_level)){
	$step=$product->step_order_level;
	if(!empty($init)){
		if($init<$step){
			$init = $step;
		} else {
			$init = ceil($init/$step) * $step;

		}
	}
	if(empty($product->min_order_level) and !isset($viewData['init'])){
		$init = $step;
	}
}

$maxOrder= '';
if (!empty($product->max_order_level)){
	$maxOrder = ' max="'.$product->max_order_level.'" ';
}

$addtoCartButton = '';
if(!VmConfig::get('use_as_catalog', 0)){
	if(!$product->addToCartButton and $product->addToCartButton!==''){
		$addtoCartButton = self::renderVmSubLayout('addtocartbtn',array('orderable'=>$product->orderable)); 
	} else {
		$addtoCartButton = $product->addToCartButton;
	}
}
$position = 'addtocart';

if ($product->min_order_level > 0) {
	$minOrderLevel = $product->min_order_level;
}
else {
	$minOrderLevel = 1;
}

if (!VmConfig::get('use_as_catalog', 0)  ) { ?>

	<div class="addtocart-bar mx-auto">
	<?php
	// Display the quantity box
	$stockhandle = VmConfig::get('stockhandle_products', false) && $product->product_stockhandle ? $product->product_stockhandle : VmConfig::get('stockhandle','none');
	if (($stockhandle == 'disableit' or $stockhandle == 'disableadd') and ($product->product_in_stock - $product->product_ordered) < $minOrderLevel) { ?>
        <a href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&layout=notify&virtuemart_product_id=' . $product->virtuemart_product_id); ?>" class="sppb-btn sppb-btn-default btn-sm centered notify"><?php echo vmText::_ ('COM_VIRTUEMART_CART_NOTIFY') ?></a><?php	
	} else {
		$tmpPrice = (float) $product->prices['costPrice'];
		if (!( VmConfig::get('askprice', true) and empty($tmpPrice) ) ) { 
               if ($product->orderable) { ?>
                    <span class="calculate">
                    	<label for="quantity<?php echo $product->virtuemart_product_id; ?>" class="quantity_box"><?php echo vmText::_ ('COM_VIRTUEMART_CART_QUANTITY'); ?>: </label>
                        <span class="quantity-box">
                        <input type="text" class="quantity-input js-recalculate" name="quantity[]"
                            data-errStr="<?php echo vmText::sprintf('COM_VIRTUEMART_WRONG_AMOUNT_ADDED', $step)?>"
                            value="<?php echo $init; ?>" data-init="<?php echo $init; ?>" data-step="<?php echo $step; ?>" <?php echo $maxOrder; ?> />
                        </span>
                        <span class="quantity-controls js-recalculate">
                        <input type="button" class="quantity-controls quantity-plus"/><i class="fas fa-chevron-up"></i>
                        <input type="button" class="quantity-controls quantity-minus"/><i class="fas fa-chevron-down"></i>
                         </span>
                     </span>
            	<?php }  ?>
			<?php if(!empty($addtoCartButton)){ ?>
            	<span class="cd-customization">
					<?php echo $addtoCartButton; ?>
                </span>
			<?php } ?>
			<input type="hidden" name="virtuemart_product_id[]" value="<?php echo $product->virtuemart_product_id ?>"/>
			<noscript><input type="hidden" name="task" value="add"/></noscript><?php
		}
	} ?>
	</div><?php
} ?>
