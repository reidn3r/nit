<?php
/**
 * sublayout products
 * Flex @package VirtueMart
 * Template Name - Flex
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
*/
// no direct access
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

$doc = Factory::getDocument(); 

$products_per_row = empty($viewData['products_per_row'])? 1:$viewData['products_per_row'] ;
$currency = $viewData['currency'];
$showRating = $viewData['showRating'];
$verticalseparator = " vertical-separator";
echo shopFunctionsF::renderVmSubLayout('askrecomjs');

$ItemidStr = '';
$Itemid = shopFunctionsF::getLastVisitedItemId();
if(!empty($Itemid)){
	$ItemidStr = '&Itemid='.$Itemid;
}

$dynamic = false;
if (vRequest::getInt('dynamic',false) and vRequest::getInt('virtuemart_product_id',false)) {
	$dynamic = true;
}

foreach ($viewData['products'] as $type => $products ) {

	$col = 1;
	$nb = 1;
	$row = 1;

	if($dynamic){
		$rowsHeight[$row]['product_s_desc'] = 1;
		$rowsHeight[$row]['price'] = 1;
		$rowsHeight[$row]['customfields'] = 1;
		$col = 2;
		$nb = 2;
	} else {
	$rowsHeight = shopFunctionsF::calculateProductRowsHeights($products,$currency,$products_per_row);

		if( (!empty($type) and count($products)>0) or (count($viewData['products'])>1 and count($products)>0)){
			$productTitle = vmText::_('COM_VIRTUEMART_'.strtoupper($type).'_PRODUCT'); ?>
	<div class="<?php echo $type ?>-view">
	  <h4><?php echo $productTitle ?></h4>
			<?php // Start the Output
		}
	}

	// Calculating Products Per Row
	$cellwidth = ' width'.floor ( 100 / $products_per_row );

	$BrowseTotalProducts = count($products);

	// Masonry
	?><div class="masonry-products"><?php
	
	
foreach ( $products as $product ) {
		if(!is_object($product) or empty($product->link)) {
			vmdebug('$product is not object or link empty',$product);
			continue;
		}
		// Show the horizontal seperator
		if ($col == 1 && $nb > $products_per_row) { ?>
	<div class="horizontal-separator"></div>
		<?php }

		// this is an indicator wether a row needs to be opened or not
		if ($col == 1) { ?>
	<div class="row productwrap">
		<?php }

		// Show the vertical seperator
		if ($nb == $products_per_row or $nb % $products_per_row == 0) {
			$show_vertical_separator = ' ';
		} else {
			$show_vertical_separator = $verticalseparator;
		}

    // Show Products ?>
	<div class="products masonry-product col-sm-6 col-md-<?php echo floor ( 12 / $products_per_row ) . $show_vertical_separator; ?>">
		<div class="spacer product-container" data-vm="product-container">
			<div class="spacer-img">
				<a title="<?php echo $product->product_name ?>" href="<?php echo $product->link.$ItemidStr; ?>">
					<?php echo $product->images[0]->displayMediaThumb('class="browseProductImage"', false); ?>
                </a> 
			</div><!--spacer-img-->
			<div class="spacer-inner">
				<div class="vm-product-rating-container centered">
					<?php if (VmConfig::get('display_stock', 1)) { ?>
                        <?php if ($product->product_in_stock > 0) { ?>
                            <div class="product-in-stock">
                            <span data-toggle="tooltip" title="<?php echo $product->stock->stock_tip ?>">
                                <i class="pe pe-7s-check"></i>
                                <span class="stock"><?php echo Text::_('VM_IN_STOCK'); ?>
                                <?php echo $product->product_in_stock; ?></span>
                                </span>
                            </div>
                        <?php } else { ?>
                            <div class="product-in-stock">
                            <span data-toggle="tooltip" title="<?php echo $product->stock->stock_tip ?>">
                                <i class="pe pe-7s-less"></i>
                                <span class="stock"><?php echo Text::_('VM_OUT_OF_STOCK'); ?></span>
                                </span>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    <?php // echo shopFunctionsF::renderVmSubLayout('rating',array('showRating'=>$showRating, 'product'=>$product)); ?>
                </div>
					<h2><?php echo HTMLHelper::link ($product->link.$ItemidStr, $product->product_name); ?></h2>
					<div class="main_price"><?php echo shopFunctionsF::renderVmSubLayout('prices',array('product'=>$product,'currency'=>$currency)); ?></div>
                
					<?php if(!empty($rowsHeight[$row]['product_s_desc'])){ ?>
                    
                        <div class="product_s_desc">
							<?php // Product Short Description
                            if (!empty($product->product_s_desc)) {
                                echo '<div class="clear"></div><hr />' . shopFunctionsF::limitStringByWord ($product->product_s_desc, 60, ' ...') ?>
                            <?php } ?>
                        </div>
                    
					<?php  } ?>
                    
                <div class="clear"></div>

				<div class="vm3pr-<?php // echo $rowsHeight[$row]['customfields'] ?>"> <?php
				echo '<hr /><span style="margin:0 auto;display:table;" class="centered">'.shopFunctionsF::renderVmSubLayout('stockhandle',array('product'=>$product)).'</span>';
				echo shopFunctionsF::renderVmSubLayout('addtocart',array('product'=>$product,'rowHeights'=>$rowsHeight[$row], 'position' => array('ontop', 'addtocart'))); 
				
				?>
				</div>
               <div class="clear"></div>

				<div class="vm-details-button">
					<?php // Product Details Button
					$link = empty($product->link)? $product->canonical:$product->link;
				echo HTMLHelper::link($link.$ItemidStr,vmText::_ ( 'COM_VIRTUEMART_PRODUCT_DETAILS' ), array ('title' => $product->product_name, 'class' => 'product-details' ) );
					?>
				</div>
                <?php //if(vRequest::getInt('dynamic')){echo vmJsApi::writeJS();} ?>
				<?php if($dynamic){
					echo vmJsApi::writeJS();
				} ?>
			</div> <!--spacer-inner-->
		</div> <!--spacer-->
	</div>

	<?php
    $nb ++;
	
      // Do we need to close the current row now?
      if ($col == $products_per_row || $nb>$BrowseTotalProducts) { ?>
  </div>
      <?php
      	$col = 1;
		$row++;
    } else {
      $col ++;
    }
  }
      if( (!empty($type) and count($products)>0) or (count($viewData['products'])>1 and count($products)>0) ){ ?>
  </div>
    <?php
    // }
    }
  }

// Masonry Ends
?></div><?php $doc->addScriptDeclaration('function r(f){/in/.test(document.readyState)?setTimeout(\'r(\'+f+\')\',9):f()}r(function(){jQuery(".masonry-products").imagesLoaded(function(){jQuery(".masonry-products").masonry({itemSelector:".masonry-product"})})});'); ?>

