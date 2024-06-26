
<fieldset style="width:100%!important;margin:0 auto;padding:0;" class="vm-fieldset-pricelist">
<table class="cart-summary table table-condensed">	
<tr>

	<th scope="col" class="vm-cart-item-name"><?php echo vmText::_ ('COM_VIRTUEMART_CART_NAME') ?></th>
	<th scope="col" class="vm-cart-item-sku"><?php echo vmText::_ ('COM_VIRTUEMART_CART_SKU') ?></th>
	<th	scope="col" class="vm-cart-item-basicprice"><?php echo vmText::_ ('COM_VIRTUEMART_CART_PRICE') ?></th>
	<th	scope="col" class="col vm-cart-item-quantity"><?php echo vmText::_ ('COM_VIRTUEMART_CART_QUANTITY') ?></th>

	<?php if (VmConfig::get ('show_tax')) {
		$tax = vmText::_ ('COM_VIRTUEMART_CART_SUBTOTAL_TAX_AMOUNT');
		if(!empty($this->cart->cartData['VatTax'])){
			if(count($this->cart->cartData['VatTax']) < 2) {
				reset($this->cart->cartData['VatTax']);
				$taxd = current($this->cart->cartData['VatTax']);
				$tax = shopFunctionsF::getTaxNameWithValue($taxd['calc_name'],$taxd['calc_value']);
			}
		 }
		?>
	<th scope="col" class="vm-cart-item-tax"><?php echo "<span class='priceColor2'>" . $tax . '</span>' ?></th>
	<?php
	} ?>
	<th scope="col" class="vm-cart-item-discount"><?php echo vmText::_ ('COM_VIRTUEMART_CART_SUBTOTAL_DISCOUNT_AMOUNT'); ?></th>
	<th scope="col" class="vm-cart-item-total" ><?php echo vmText::_ ('COM_VIRTUEMART_CART_TOTAL') ?></th>
</tr>
<?php
$i = 1;
foreach ($this->cart->products as $pkey => $prow) {
	$prow->prices = array_merge($prow->prices,$this->cart->cartPrices[$pkey]);
?>
<tr style="vertical-align:top" class="sectiontableentry<?php echo $i; if(!empty($prow->class)) echo ' '.$prow->class ?>">
	<input type="hidden" name="cartpos[]" value="<?php echo $pkey ?>">
	<td class="responsive-xs">
    <div class="align-items-center">
		<?php if ($prow->virtuemart_media_id) { ?>
		<div class="cart-images d-flex justify-content-center">
			<?php
            if (!empty($prow->images[0])) {
                echo $prow->images[0]->displayMediaThumb ('class="img-responsive center-block"', FALSE);
            }
            ?>
        </div>
		<?php } ?>
		<?php echo JHtml::link ($prow->url, $prow->product_name);
			echo '<div class="clearfix centered">' . $this->customfieldsModel->CustomsFieldCartDisplay ($prow) . '</div>';
		 ?>
	</div>
	</td>
	<td class="vm-cart-item-sku responsive-sm responsive-xs"><?php  echo $prow->product_sku ?></td>
	<td class="vm-cart-item-basicprice responsive-sm responsive-xs">
		<?php
		if (VmConfig::get ('checkout_show_origprice', 1) && $prow->prices['discountedPriceWithoutTax'] != $prow->prices['priceWithoutTax']) {
			echo '<span class="line-through">' . $this->currencyDisplay->createPriceDiv ('basePriceVariant', '', $prow->prices, TRUE, FALSE) . '</span>';
		}

		if ($prow->prices['discountedPriceWithoutTax']) {
			echo $this->currencyDisplay->createPriceDiv ('discountedPriceWithoutTax', '', $prow->prices, FALSE, FALSE, 1.0, false, true);
		} else {
			echo $this->currencyDisplay->createPriceDiv ('basePriceVariant', '', $prow->prices, FALSE, FALSE, 1.0, false, true);
		}
		?>
	</td>
	<td class="vm-cart-item-quantity responsive-sm responsive-xs"><?php

				if ($prow->step_order_level)
					$step=$prow->step_order_level;
				else
					$step=1;
				if($step==0)
					$step=1;
				?>
           <div class="d-flex justify-content-center input-append">
		   		<input type="text"
				   onblur="Virtuemart.checkQuantity(this,<?php echo $step?>,'<?php echo vmText::_ ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED',true)?>');"
				   onclick="Virtuemart.checkQuantity(this,<?php echo $step?>,'<?php echo vmText::_ ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED',true)?>');"
				   onchange="Virtuemart.checkQuantity(this,<?php echo $step?>,'<?php echo vmText::_ ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED',true)?>');"
				   onsubmit="Virtuemart.checkQuantity(this,<?php echo $step?>,'<?php echo vmText::_ ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED',true)?>');"
				   title="<?php echo  vmText::_('COM_VIRTUEMART_CART_UPDATE') ?>" class="quantity-input js-recalculate xs-cart-btn" size="3" maxlength="4" name="quantity[<?php echo $pkey; ?>]" value="<?php echo $prow->quantity ?>" />
                <button type="submit" class="btn vmicon vm2-add_quantity_cart xs-cart-btn" name="updatecart.<?php echo $pkey ?>" title="<?php echo  vmText::_ ('COM_VIRTUEMART_CART_UPDATE') ?>"><i class="fas fa-sync"></i></button>
				<button type="submit" class="btn vmicon vm2-remove_from_cart xs-cart-btn" name="delete.<?php echo $pkey ?>" title="<?php echo vmText::_ ('COM_VIRTUEMART_CART_DELETE') ?>"><i class="fas fa-times"></i></button>
       </div>
	</td>
	<?php if (VmConfig::get ('show_tax')) { ?>
	<td class="vm-cart-item-tax responsive-sm responsive-xs"><?php echo "<span class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('taxAmount', '', $prow->prices, FALSE, FALSE, $prow->quantity, false, true) . "</span>" ?></td>
	<?php } ?>
	<td class="vm-cart-item-discount responsive-sm responsive-xs"><?php echo "<span class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('discountAmount', '', $prow->prices, FALSE, FALSE, $prow->quantity, false, true) . "</span>" ?></td>
	<td class="vm-cart-item-total responsive-sm responsive-xs">
		<?php //vmdebug('hm',$prow->prices,$this->cart->cartPrices[$pkey]);
		if (VmConfig::get ('checkout_show_origprice', 1) && !empty($prow->prices['basePriceWithTax']) && $prow->prices['basePriceWithTax'] != $prow->prices['salesPrice']) {
			echo '<span class="line-through">' . $this->currencyDisplay->createPriceDiv ('basePriceWithTax', '', $prow->prices, TRUE, FALSE, $prow->quantity) . '</span>';
		}
		elseif (VmConfig::get ('checkout_show_origprice', 1) && empty($prow->prices['basePriceWithTax']) && !empty($prow->prices['basePriceVariant']) && $prow->prices['basePriceVariant'] != $prow->prices['salesPrice']) {
			echo '<span class="line-through">' . $this->currencyDisplay->createPriceDiv ('basePriceVariant', '', $prow->prices, TRUE, FALSE, $prow->quantity) . '</span>';
		}
		echo $this->currencyDisplay->createPriceDiv ('salesPrice', '', $prow->prices, FALSE, FALSE, $prow->quantity) ?></td>
</tr>
	<?php
	$i = ($i==1) ? 2 : 1;
} ?>
<!--Begin of SubTotal, Tax, Shipment, Coupon Discount and Total listing -->
<?php if (VmConfig::get ('show_tax')) {
	$colspan = 3;
} else {
	$colspan = 2;
} ?>

<tr class="sectiontableentry1 responsive-xs">
	<td colspan="4" align="center" class="responsive-sm responsive-xs"><?php echo vmText::_ ('COM_VIRTUEMART_ORDER_PRINT_PRODUCT_PRICES_TOTAL'); ?></td>

	<?php if (VmConfig::get ('show_tax')) { ?>
	<td class="responsive-xs" align="right"><?php echo "<span  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('taxAmount', '', $this->cart->cartPrices, FALSE, false, true) . "</span>" ?></td>
	<?php } ?>
	<td class="responsive-xs" align="right"><?php echo "<span  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('discountAmount', '', $this->cart->cartPrices, FALSE) . "</span>" ?></td>
	<td class="responsive-xs" align="right"><?php echo $this->currencyDisplay->createPriceDiv ('salesPrice', '', $this->cart->cartPrices, FALSE) ?></td>
</tr>

<?php
// Coupon
if (VmConfig::get ('coupons_enable')) { ?>
	
<tr class="sectiontableentry2">
	<td colspan="5" style="text-align: left;">
		<?php if (!empty($this->layoutName) && $this->layoutName == $this->cart->layout) {
		echo $this->loadTemplate ('coupon');
		} ?>
		<?php if (!empty($this->cart->cartData['couponCode'])) { ?>
		<?php
		echo $this->cart->cartData['couponCode'];
		echo $this->cart->cartData['couponDescr'] ? (' (' . $this->cart->cartData['couponDescr'] . ')') : '';
		?>
	</td>
	<?php if (VmConfig::get ('show_tax')) { ?>
	<td class="responsive-xs" align="right"><?php echo $this->currencyDisplay->createPriceDiv ('couponTax', '', $this->cart->cartPrices['couponTax'], FALSE); ?> </td>
	<?php } ?>
	<td class="responsive-xs" align="right">&nbsp;</td>
	<td class="responsive-xs" align="right"><?php echo $this->currencyDisplay->createPriceDiv ('salesPriceCoupon', '', $this->cart->cartPrices['salesPriceCoupon'], FALSE); ?> </td>
	<?php } else { ?>
	&nbsp;</td>
	<td class="responsive-xs" colspan="<?php echo $colspan ?>">&nbsp;</td>
	<?php }	?>
</tr></div>
<?php } 
foreach ($this->cart->cartData['DBTaxRulesBill'] as $rule) {
	?>
<tr class="sectiontableentry<?php echo $i ?>">
	<td class="responsive-xs" colspan="6" align="right"><?php echo $rule['calc_name'] ?> </td>

	<?php if (VmConfig::get ('show_tax')) { ?>
	<td class="responsive-xs" align="right"></td>
	<?php } ?>
	<td class="responsive-xs" align="right"><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->cartPrices[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?></td>
	<td class="responsive-xs" align="right"><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->cartPrices[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?> </td>
</tr>
	<?php
	if ($i) {
		$i = 1;
	} else {
		$i = 0;
	}
} ?>

<?php

foreach ($this->cart->cartData['taxRulesBill'] as $rule) {
	if($rule['calc_value_mathop']=='avalara') continue;
	?>
<tr class="sectiontableentry<?php echo $i ?>">
	<td class="responsive-xs" colspan="4" align="right"><?php echo $rule['calc_name'] ?> </td>
	<?php if (VmConfig::get ('show_tax')) { ?>
	<td class="responsive-xs" align="right"><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->cartPrices[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?> </td>
	<?php } ?>
	<td class="responsive-xs" align="right"><?php ?> </td>
	<td class="responsive-xs" align="right"><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->cartPrices[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?> </td>
</tr>
	<?php
	if ($i) {
		$i = 1;
	} else {
		$i = 0;
	}
}

foreach ($this->cart->cartData['DATaxRulesBill'] as $rule) {
	?>
<tr class="sectiontableentry<?php echo $i ?>">
	<td class="responsive-xs" colspan="4" align="right"><?php echo   $rule['calc_name'] ?> </td>

	<?php if (VmConfig::get ('show_tax')) { ?>
	<td align="right"></td>

	<?php } ?>
	<td class="responsive-xs" align="right"><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->cartPrices[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?>  </td>
	<td class="responsive-xs" align="right"><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->cartPrices[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?> </td>
</tr>
	<?php
	if ($i) {
		$i = 1;
	} else {
		$i = 0;
	}
}

if (VmConfig::get('oncheckout_opc',true) or
	!VmConfig::get('oncheckout_show_steps',false) or
	(!VmConfig::get('oncheckout_opc',true) and VmConfig::get('oncheckout_show_steps',false) and
	!empty($this->cart->virtuemart_shipmentmethod_id) )
) { ?>
<tr class="sectiontableentry1" style="vertical-align:top;">
	<?php if (!$this->cart->automaticSelectedShipment) { ?>
		<td class="responsive-xs" colspan="4" style="vertical-align:top;">
			<?php
				echo '<h4>'.vmText::_ ('COM_VIRTUEMART_CART_SELECTED_SHIPMENT').'</h4>';
				echo '<div class="selected_shipment d-flex justify-content-center">'.$this->cart->cartData['shipmentName'].'</div><hr />';

		if (!empty($this->layoutName) and $this->layoutName == $this->cart->layout) {
			if (VmConfig::get('oncheckout_opc', 0)) {
				$previouslayout = $this->setLayout('select');
				echo '<div class="w-100 align-items-center">'.$this->loadTemplate('shipment').'</div>';
				$this->setLayout($previouslayout);
			} else {
				echo JHtml::_('link', JRoute::_('index.php?option=com_virtuemart&view=cart&task=edit_shipment', $this->useXHTML, $this->useSSL), $this->select_shipment_text, 'class="centered"');
			}
		} else {
			echo vmText::_ ('COM_VIRTUEMART_CART_SHIPPING');
		}
		echo '</td>';
	} else {
	?>
	<td class="responsive-xs" colspan="4" style="vertical-align:top;">
		<?php echo '<h4>'.vmText::_ ('COM_VIRTUEMART_CART_SELECTED_SHIPMENT').'</h4>'; ?>
		<?php echo $this->cart->cartData['shipmentName'];
		echo '<span class="floatright">' . $this->currencyDisplay->createPriceDiv ('shipmentValue', '', $this->cart->cartPrices['shipmentValue'], FALSE) . '</span>';
		?>
	</td>
	<?php } ?>

	<?php if (VmConfig::get ('show_tax')) { ?>
	<td class="responsive-xs" align="right"><?php

	echo "<span class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('shipmentTax', '', $this->cart->cartPrices['shipmentTax'], FALSE) . "</span>"; ?> </td>
	<?php } ?>
	<td class="responsive-xs" align="right"><?php if($this->cart->cartPrices['salesPriceShipment'] < 0) echo $this->currencyDisplay->createPriceDiv ('salesPriceShipment', '', $this->cart->cartPrices['salesPriceShipment'], FALSE); ?></td>
	<td class="responsive-xs" align="right"><?php echo $this->currencyDisplay->createPriceDiv ('salesPriceShipment', '', $this->cart->cartPrices['salesPriceShipment'], FALSE); ?> </td>
</tr>
<?php } ?>
<?php if ($this->cart->pricesUnformatted['salesPrice']>0.0 and
	( 	VmConfig::get('oncheckout_opc',true) or
		!VmConfig::get('oncheckout_show_steps',false) or
		( (!VmConfig::get('oncheckout_opc',true) and VmConfig::get('oncheckout_show_steps',false) ) and !empty($this->cart->virtuemart_paymentmethod_id))
	)
) { ?>
<tr class="sectiontableentry1" style="vertical-align:top;">
	<?php if (!$this->cart->automaticSelectedPayment) { ?>
		<td class="responsive-xs" colspan="4" style="align:left;vertical-align:top;">
			<?php
				echo '<h4 class="select_payment">'.vmText::_ ('COM_VIRTUEMART_CART_SELECTED_PAYMENT').'</h4>';
				echo '<div class="selected_payment">'.$this->cart->cartData['paymentName'].'</div>';
				echo '<hr />';

		if (!empty($this->layoutName) && $this->layoutName == 'default') {
			if (VmConfig::get('oncheckout_opc', 0)) {
				$previouslayout = $this->setLayout('select');
				echo $this->loadTemplate('payment');
				//echo '<div class="col-md-offset-2 col-sm-8 col-md-offset-2">'.$this->loadTemplate('payment').'</div>';
				$this->setLayout($previouslayout);
			} else {
				echo JHtml::_('link', JRoute::_('index.php?option=com_virtuemart&view=cart&task=editpayment', $this->useXHTML, $this->useSSL), $this->select_payment_text, 'class=""');
			}
		} else {
		echo vmText::_ ('COM_VIRTUEMART_CART_PAYMENT');
	} ?> </td>

	<?php } else { ?>
		<td class="responsive-xs" colspan="4" style="align:left;vertical-align:top;" >
			<?php echo '<h4>'.vmText::_ ('COM_VIRTUEMART_CART_SELECTED_PAYMENT').'</h4>'; ?>
			<?php echo $this->cart->cartData['paymentName']; ?> </td>
	<?php } ?>
	<?php if (VmConfig::get ('show_tax')) { ?>
	<td class="responsive-xs" align="right"><?php echo "<span  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('paymentTax', '', $this->cart->cartPrices['paymentTax'], FALSE) . "</span>"; ?> </td>
	<?php } ?>
	<td class="responsive-xs" align="right" ><?php if($this->cart->cartPrices['salesPricePayment'] < 0) echo $this->currencyDisplay->createPriceDiv ('salesPricePayment', '', $this->cart->cartPrices['salesPricePayment'], FALSE); ?></td>
	<td class="responsive-xs" align="right" ><?php  echo $this->currencyDisplay->createPriceDiv ('salesPricePayment', '', $this->cart->cartPrices['salesPricePayment'], FALSE); ?> </td>
</tr>
<?php  } ?>

<tr class="sectiontableentry2 svgwhite">
	<td class="responsive-xs" colspan="4" align="right"><?php echo vmText::_ ('COM_VIRTUEMART_CART_TOTAL') ?>:</td>

	<?php if (VmConfig::get ('show_tax')) { ?>
	<td class="responsive-xs" align="right"> <?php echo "<span  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('billTaxAmount', '', $this->cart->cartPrices['billTaxAmount'], FALSE) . "</span>" ?> </td>
	<?php } ?>
	<td class="responsive-xs" align="right"> <?php echo "<span  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('billDiscountAmount', '', $this->cart->cartPrices['billDiscountAmount'], FALSE) . "</span>" ?> </td>
	<td class="responsive-xs" align="right"><strong><?php echo $this->currencyDisplay->createPriceDiv ('billTotal', '', $this->cart->cartPrices['billTotal'], FALSE); ?></strong></td>
</tr>
<?php
if ($this->totalInPaymentCurrency) {
?>

<tr class="sectiontableentry2">
	<td colspan="4" align="right"><?php echo vmText::_ ('COM_VIRTUEMART_CART_TOTAL_PAYMENT') ?>:</td>

	<?php if (VmConfig::get ('show_tax')) { ?>
	<td></td>
	<?php } ?>
	<td class="responsive-xs" align="right"></td>
	<td class="responsive-xs" align="right"><strong><?php echo $this->totalInPaymentCurrency; ?></strong></td>
</tr>
	<?php
}

//Show VAT tax seperated
if(!empty($this->cart->cartData)){
	if(!empty($this->cart->cartData['VatTax'])){
		$c = count($this->cart->cartData['VatTax']);
		if (!VmConfig::get ('show_tax') or $c>1) {
			if($c>0){
				?><tr class="sectiontableentry2">
				<td class="responsive-xs" colspan="5" align="right"><?php echo vmText::_ ('COM_VIRTUEMART_TOTAL_INCL_TAX') ?></td>

				<?php if (VmConfig::get ('show_tax')) { ?>
					<td class="responsive-xs"></td>
				<?php } ?>
				<td class="responsive-xs"></td>
				</tr><?php
			}
			foreach( $this->cart->cartData['VatTax'] as $vatTax ) {
				if(!empty($vatTax['result'])) {
					echo '<tr class="responsive-xs sectiontableentry'.$i.'">';
					echo '<td class="responsive-xs" colspan="4" align="right">'.shopFunctionsF::getTaxNameWithValue($vatTax['calc_name'],$vatTax['calc_value']). '</td>';
					echo '<td class="responsive-xs" align="right"><span class="priceColor2">'.$this->currencyDisplay->createPriceDiv( 'taxAmount', '', $vatTax['result'], FALSE, false, 1.0,false,true ).'</span></td>';
					echo '<td></td><td></td>';
					echo '</tr>';
				}
			}
		}
	}
}
?>
 </table>
</fieldset>