<?php
/**
* sublayout products
*
* @package	VirtueMart
* @author Max Milbers
* @link https://virtuemart.net
* @copyright Copyright (c) 2014 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL2, see LICENSE.php
* @version $Id: cart.php 7682 2014-02-26 17:07:20Z Milbo $
*/

defined('_JEXEC') or die('Restricted access');

$product = $viewData['product'];
$position = $viewData['position'];
$customTitle = isset($viewData['customTitle'])? $viewData['customTitle']: false;
if(isset($viewData['class'])){
	$class = $viewData['class'];
} else {
	$class = 'product-fields';
}

if (!empty($product->customfieldsSorted[$position])) {
	?>
	<div class="<?php echo $class?>">
		<?php
		if($customTitle and isset($product->customfieldsSorted[$position][0])){
			$field = $product->customfieldsSorted[$position][0]; ?>
		<div class="product-fields-title-wrapper">
			<h3 class="product-fields-title"><?php echo vmText::_ ($field->custom_title) ?></h3>
		</div> 
		<?php
		}
		$custom_title = null;
	
		// Title
		$field = $product->customfieldsSorted[$position][0]; 
		$related_categories_bts_columns = '';
		// Flex 3.9.5 added fix to show (or not) the custom title
		if (!$customTitle and $field->custom_title != $custom_title and $field->show_title) {
			echo '<div class="sp-module"><h3 class="product-fields-title sp-module-title">'. vmText::_ ($field->custom_title) .'</h3></div>';
		}
		
		if ($position == 'related_categories') {
			$related_categories_bts_columns = ' col-xs-6 col-sm-4 col-md-3';
		}
		?>	
		<div class="product-field-wrapper row">																			   
		<?php foreach ($product->customfieldsSorted[$position] as $field) {
			if ( $field->is_hidden || empty($field->display)) continue; //OSP http://forum.virtuemart.net/index.php?topic=99320.0
				if (!empty($field->display)){ ?>
					<div class="product-field-display px-0 mx-0<?php echo $related_categories_bts_columns; ?>"><?php echo $field->display; ?></div>	
				<?php } 
			
			$custom_title = $field->custom_title;
		} ?>
		</div>
		<?php // <div class="clear"></div> ?>
	</div>
<?php } ?>