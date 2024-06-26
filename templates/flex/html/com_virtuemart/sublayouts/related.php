<?php defined('_JEXEC') or die;

$related = $viewData['related'];
$customfield = $viewData['customfield'];
$thumb = $viewData['thumb'];

?>
<div class="related-product-container clearfix">
	<div class="col-xs-12 col-sm-4 col-md-3"><?php echo JHtml::link (JRoute::_ ($related->link), $thumb, array('title' => $related->product_name,'class'=> 'related-productdetails-view'));
?></div>
	<div class="related-product-desc col-xs-12 col-sm-8 col-md-9">
		<?php echo '<h3>'. JHtml::link (JRoute::_ ($related->link), $related->product_name, array('title' => $related->product_name,'class'=> 'related-productdetails-link')) .'</h3>'; ?>
<?php if($customfield->wPrice){?> 
		<div class="col-xs-12 col-sm-12">
<?php
	$currency = calculationHelper::getInstance()->_currencyDisplay;
	echo shopFunctionsF::renderVmSubLayout('prices',array('product'=>$related,'currency'=>$currency,'class'=> 'col-xs-12 col-sm-12'));
	//echo $currency->createPriceDiv ('salesPrice', 'COM_VIRTUEMART_PRODUCT_SALESPRICE', $related->prices);
	?>
	    </div>
	<?php
}
if($customfield->waddtocart){
	?><div class="vm3pr-related" ><?php
	echo shopFunctionsF::renderVmSubLayout('addtocart',array('product'=>$related, 'position' => array('ontop', 'addtocart')));
	?></div><?php
}

if($customfield->wDescr){
	echo '<div class="product_s_desc">'.$related->product_s_desc.'</div>';
}
	?>
	</div>
</div><hr />
