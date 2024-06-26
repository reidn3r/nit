<?php
/**
 *
 * Show the product details page
 * Flex @package VirtueMart
 * Template Name - Flex
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
*/
// no direct access
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Text;

/* Let's see if we found the product */
if (empty($this->product)) {
	echo vmText::_('COM_VIRTUEMART_PRODUCT_NOT_FOUND');
	echo '<br /><br />  ' . $this->continue_link_html;
	return;
}

echo shopFunctionsF::renderVmSubLayout('askrecomjs',array('product'=>$this->product));



if(vRequest::getInt('print',false)){ ?>
<body onload="javascript:print();">
<?php } ?>
<div class="product-container productdetails-view productdetails">

    <div class="vm-product-wrap row">
		<div class="vm-product-media-img col-sm-5">
			<?php
			echo $this->loadTemplate('images');

			$count_images = count ($this->product->images);
			if ($count_images > 1) {
				echo $this->loadTemplate('images_additional');
			}
			
			?>
		</div> <!--/.col-sm-5-->

		<div class="vm-product-details-inner col-sm-7">
			<div class="vm-product-title">
				<div class="pull-left">
					<?php // Product Title   ?>
				    <h2><?php echo $this->product->product_name ?></h2>
				    <?php // Product Title END   ?>
				</div> 
                <div class="vm-rating pull-left">
                
                <?php if (VmConfig::get('display_stock', 1)) { ?>
					<?php if ($this->product->product_in_stock > 0) { ?>
                        <div class="product-in-stock">
                            <i class="pe pe-7s-check"></i>
                            <?php echo Text::_('VM_IN_STOCK'); ?>
                            <span><?php echo $this->product->product_in_stock; ?></span>
                        </div>
                    <?php } else { ?>
                        <div class="product-in-stock">
                            <i class="pe pe-7s-less"></i>
                            <?php echo Text::_('VM_OUT_OF_STOCK'); ?>
                        </div>
                    <?php } ?>
                <?php } ?>
                
                <?php echo shopFunctionsF::renderVmSubLayout('rating',array('showRating'=>$this->showRating,'product'=>$this->product)); ?>
                </div>
           
			</div>

		    <?php echo $this->product->event->afterDisplayTitle ?>

			<?php
			if (is_array($this->productDisplayShipments)) {
				echo '<div class="vm-product-shipments">';
			    foreach ($this->productDisplayShipments as $productDisplayShipment) {
					echo '<div class="vm-product-shipment">';
					echo $productDisplayShipment . '<br />';
					echo '</div>';
			    }
				echo '</div>';
			}
			
			//In case you are not happy using everywhere the same price display fromat, just create your own layout
			//in override /html/fields and use as first parameter the name of your file
			echo shopFunctionsF::renderVmSubLayout('prices',array('product'=>$this->product,'currency'=>$this->currency)); 
			
			echo shopFunctionsF::renderVmSubLayout('customfields',array('product'=>$this->product,'position'=>'ontop'));
			
			echo shopFunctionsF::renderVmSubLayout('customfields',array('product'=>$this->product,'position'=>'normal'));
			
		    ?>
    		<?php if (!empty($this->product->product_s_desc)) { ?>
		        <div class="product-short-description">
			       <h4><i class="pe pe-7s-note"></i><?php echo Text::_('VM_PRODUCT_SHORT_DESC');?></h4>
				    <?php
				    // Removed line because it was generating <br>: echo nl2br($this->product->product_s_desc);
					echo $this->product->product_s_desc;
				    ?>
		        </div>
		    <?php } // Product Short Description END ?>
			<?php
				// Manufacturer of the Product
				if (VmConfig::get('show_manufacturers', 1) && !empty($this->product->virtuemart_manufacturer_id)) {
				    echo '<div class="clear"></div><span class="product-manufacturer">' . vmText::_('COM_VIRTUEMART_PRODUCT_DETAILS_MANUFACTURER_LBL') . ':' . $this->loadTemplate('manufacturer') . '</span><div class="clear"></div>';	
				}
			?>
		    <div class="spacer-buy-area">
				<?php
				echo shopFunctionsF::renderVmSubLayout('addtocart',array('product'=>$this->product));

				echo shopFunctionsF::renderVmSubLayout('stockhandle',array('product'=>$this->product));
				?>
		    </div>
            
            <div class="clear"></div>
				<?php // Ask a question about this product ?>
				<?php if (VmConfig::get('ask_question', 0) == 1) {
					$askquestion_url = Route::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id=' . $this->product->virtuemart_product_id . '&virtuemart_category_id=' . $this->product->virtuemart_category_id . '&tmpl=component', FALSE);
					?>
                    <div class="clear"></div>
					<div class="ask-a-question">
						<a class="ask-a-question" href="<?php echo $askquestion_url ?>" rel="nofollow" ><i class="fas fa-envelope"></i><?php echo vmText::_('COM_VIRTUEMART_PRODUCT_ENQUIRY_LBL') ?></a>
					</div>
				<?php } ?>
                
				<?php // Back To Category Button
				if ($this->product->virtuemart_category_id) {
					$catURL =  Route::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$this->product->virtuemart_category_id, FALSE);
					$categoryName = vmText::_($this->product->category_name) ;
				} else {
					$catURL =  Route::_('index.php?option=com_virtuemart');
					$categoryName = vmText::_('COM_VIRTUEMART_SHOP_HOME');
				}
				?>
				<div class="back-to-category">
			    	<a href="<?php echo $catURL ?>" class="product-details"><i class="fas fa-folder-open"></i><?php echo vmText::sprintf('COM_VIRTUEMART_CATEGORY_BACK_TO',$categoryName) ?></a>
				</div>
                
                
		    <?php
		    // Product Navigation
		    if (VmConfig::get('product_navigation', 1)) { ?>
            
            <hr style="width:100%;" />
            
		        <div class="product-neighbours">
				    <?php if (!empty($this->product->neighbours ['previous'][0])) {
					$prev_link = Route::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['previous'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id, FALSE);
					echo HTMLHelper::_('link', $prev_link, $this->product->neighbours ['previous'][0] ['product_name'], array('rel'=>'prev', 'class' => 'previous-page', 'data-toggle' => 'tooltip', 'title' => $this->product->neighbours ['previous'][0] ['product_name'], 'data-dynamic-update' => '1'));
				    } else {
						echo '<span class="empty-previous-page fas fa-ban"></span> ';
					}
					if (!empty($this->product->neighbours ['next'][0])) {
					$next_link = Route::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['next'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id, FALSE);
					echo HTMLHelper::_('link', $next_link, $this->product->neighbours ['next'][0] ['product_name'], array('rel'=>'next','class' => 'next-page','data-toggle' => 'tooltip', 'title' => $this->product->neighbours ['next'][0] ['product_name'],'data-dynamic-update' => '1'));
				    } else {
						echo '<span class="empty-next-page fas fa-ban"></span>';
					} ?>
                    
			    	
		        </div>
			    <?php } // Product Navigation END
			    ?>

			    <?php
			    // Product Edit Link
			    echo $this->edit_link;
			    // Product Edit Link END
			    ?>

		</div> <!--/.col-sm-7-->
		<div class="clear"></div>
    </div> <!--/.row-->
	

    <div style="margin-top:35px;" class="row">
	    
			<?php
			// event onContentBeforeDisplay
			echo $this->product->event->beforeDisplayContent; ?>
		
			<!--<div class="float-end">-->
          	<?php 
		  		// PDF - Print - Email Icon
			    if (VmConfig::get('show_emailfriend') || VmConfig::get('show_printicon') || VmConfig::get('pdf_icon')) {
				?>
				<div class="float-end">
			        <div class="vm-icons">
				    <?php
				    $link = 'index.php?tmpl=component&option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->virtuemart_product_id;

					echo '<span class="pdf-icon">';
					echo $this->linkIcon($link . '&format=pdf', 'COM_VIRTUEMART_PDF', 'pdf_button', 'pdf_icon', false);
					echo '</span>';
					//echo $this->linkIcon($link . '&print=1', 'COM_VIRTUEMART_PRINT', 'printButton', 'show_printicon');
					echo $this->linkIcon($link . '&print=1', 'COM_VIRTUEMART_PRINT', 'printButton', 'show_printicon',false,true,false,'class="printModal"');
					$MailLink = 'index.php?option=com_virtuemart&view=productdetails&task=recommend&virtuemart_product_id=' . $this->product->virtuemart_product_id . '&virtuemart_category_id=' . $this->product->virtuemart_category_id . '&tmpl=component';
				    echo $this->linkIcon($MailLink, 'COM_VIRTUEMART_EMAIL', 'emailButton', 'show_emailfriend', false,true,false,'class="recommened-to-friend"');
				    ?>
			    	<!--<div class="clear"></div>-->
			        </div>
		</div>
			    <?php } // PDF - Print - Email Icon END
			    ?>
      		 <!--</div> --> 
		
			<div class="products-desc-tab">
			
				
			
				
				<!--<ul id="myTab" class="nav nav-tabs role="tablist">-->
				<div class="nav nav-tabs" id="vm-nav-tab" role="tablist">
					<?php if (!empty($this->product->product_desc)) { ?>
                    <!--
					<li role="presentation" class="active">
						<a href="#desc" aria-controls="desc" role="tab" data-toggle="tab">
							<i class="pe pe-7s-note"></i><?php echo vmText::_('VM_PRODUCT_DESC_TITLE') ?>
						 </a>
					</li>
					-->
					<button class="nav-link active" id="nav-desc-tab" data-bs-toggle="tab" data-bs-target="#nav-desc" type="button" role="tab" aria-controls="nav-desc" aria-selected="true"><i class="pe pe-7s-note"></i><?php echo vmText::_('VM_PRODUCT_DESC_TITLE') ?></button>
				    <?php } // Product Description END 
					if ($this->showReview) { ?>
					<button class="nav-link" id="nav-reviews-tab" data-bs-toggle="tab" data-bs-target="#nav-reviews" type="button" role="tab" aria-controls="nav-reviews" aria-selected="false"><i class="pe pe-7s-like2"></i><?php echo Text::_('VM_PRODUCT_REVIEWS');?></button>
				 	<!--
					<li role="presentation">
					  	<a href="#review" data-toggle="tab" aria-controls="review" role="tab">
						   <i class="pe pe-7s-like2"></i><?php echo Text::_('VM_PRODUCT_REVIEWS');?>
					  </a>
					</li>
					-->
                    <?php } ?>
					
				</div>
				
				<div class="tab-content" id="nav-tabContent">
					<?php if (!empty($this->product->product_desc)) { ?>
					    <?php /** <div role="tabpanel" class="tab-pane desc fade show active" id="desc">*/ ?>
						<div class="tab-pane fade show desc active" id="nav-desc" role="tabpanel" aria-labelledby="nav-desc-tab">
						    <div class="product-description">
								<?php /** @todo Test if content plugins modify the product description */ ?>
								<?php echo $this->product->product_desc; ?>
						    </div>
					    </div>
				    <?php } // Product Description END 
					if ($this->showReview) { ?>
				    <?php /** <div role="tabpanel" class="tab-pane fade review" id="review"> **/ ?>
					<div class="tab-pane fade review" id="nav-reviews" role="tabpanel" aria-labelledby="nav-reviews-tab">
				    	<?php echo $this->loadTemplate('reviews'); ?>
				 	 </div>
                     <?php } ?>
				</div>
			</div>
   
 <?php
		    // Product Packaging
			$product_packaging = '';
			if ($this->product->product_box) {
			?>
				<div class="product-box">
				<?php
					echo vmText::_('COM_VIRTUEMART_PRODUCT_UNITS_IN_BOX') .$this->product->product_box;
				?>
				</div>
			<?php } // Product Packaging END ?>
		
			<?php 
            echo shopFunctionsF::renderVmSubLayout('customfields',array('product'=>$this->product,'position'=>'onbot'));
            
            echo shopFunctionsF::renderVmSubLayout('customfields',array('product'=>$this->product,'position'=>'related_products','class'=> 'related_products'));
            
            echo shopFunctionsF::renderVmSubLayout('customfields',array('product'=>$this->product,'position'=>'related_categories','class'=> 'related_categories'));
            
            ?>
            
            <?php // onContentAfterDisplay event
            echo $this->product->event->afterDisplayContent;
            
            // Show child categories
            if ($this->cat_productdetails)  {
                echo $this->loadTemplate('showcategory');
            } ?>

		
	</div> <!--/.row-->

<?php
$j = 'function r(f){/in/.test(document.readyState)?setTimeout(\'r(\'+f+\')\',9):f()}r(function(){
	jQuery("form.js-recalculate").each(function(){
		if (jQuery(this).find(".product-fields").length && !jQuery(this).find(".no-vm-bind").length) {
			var id= jQuery(this).find(\'input[name="virtuemart_product_id[]"]\').val();
			Virtuemart.setproducttype(jQuery(this),id);
		}
	});
});';
//vmJsApi::addJScript('recalcReady',$j);

if(VmConfig::get ('jdynupdate', TRUE)){

	/** GALT
	 * Notice for Template Developers!
	 * Templates must set a Virtuemart.container variable as it takes part in
	 * dynamic content update.
	 * This variable points to a topmost element that holds other content.
	 */
	$j = "Virtuemart.container = jQuery('.productdetails-view');
Virtuemart.containerSelector = '.productdetails-view';
//Virtuemart.recalculate = true;
";

vmJsApi::addJScript('ajaxContent',$j);

$j = "jQuery(function($) {
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-toggle=\"tooltip\"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {return new bootstrap.Tooltip(tooltipTriggerEl)});	
Virtuemart.stopVmLoading();var msg = '';$('a[data-dynamic-update=\"1\"]').off('click', Virtuemart.startVmLoading).on('click', {msg:msg}, Virtuemart.startVmLoading);$('[data-dynamic-update=\"1\"]').off('change', Virtuemart.startVmLoading).on('change', {msg:msg}, Virtuemart.startVmLoading);var productCustomization=$('.cd-customization'),cart=$('.cd-cart'),animating=false;initCustomization(productCustomization);$('body').on('click',function(event){if($(event.target).is('body')||$(event.target).is('.cd-gallery')){deactivateCustomization()}});function initCustomization(items){items.each(function(){var actual=$(this),addToCartBtn=actual.find('.add-to-cart'),touchSettings=actual.next('.cd-customization-trigger');addToCartBtn.on('click',function(){if(!animating){animating=true;resetCustomization(addToCartBtn);addToCartBtn.addClass('is-added').find('path').eq(0).animate({'stroke-dashoffset':0},300,function(){setTimeout(function(){updateCart();addToCartBtn.removeClass('is-added').find('.addtocart-button').on('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend',function(){addToCartBtn.find('path').eq(0).css('stroke-dashoffset','19.79');animating=false});if($('.no-csstransitions').length>0){addToCartBtn.find('path').eq(0).css('stroke-dashoffset','19.79');animating=false}},600)})}});touchSettings.on('click',function(event){event.preventDefault();resetCustomization(addToCartBtn)})})}function resetCustomization(selectOptions){selectOptions.siblings('[data-type=\"select\"]').removeClass('is-open').end().parents('.cd-single-item').addClass('hover').parent('li').siblings('li').find('.cd-single-item').removeClass('hover').end().find('[data-type=\"select\"]').removeClass('is-open')}function deactivateCustomization(){productCustomization.parent('.cd-single-item').removeClass('hover').end().find('[data-type=\"select\"]').removeClass('is-open')}function updateCart(){(!cart.find('.total_products').hasClass('items-added'))&&cart.find('.total_products').addClass('items-added').removeClass('empty_basket');var cartItems=cart.find('span'),text=parseInt(cartItems.text())+1;cartItems.text(text)}});";
vmJsApi::addJScript('vmPreloader',$j);
}

echo vmJsApi::writeJS();

if ($this->product->prices['salesPrice'] > 0) {
  echo shopFunctionsF::renderVmSubLayout('snippets',array('product'=>$this->product, 'currency'=>$this->currency, 'showRating'=>$this->showRating));
}

?>
</div>