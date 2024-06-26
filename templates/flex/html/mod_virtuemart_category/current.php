<?php
/**
 * Flex @package VM ajax cart
 * Template Name - Flex
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
*/
// no direct access
defined('_JEXEC') or die;

use Joomla\CMS\Router\Route;
use Joomla\CMS\Factory;

$doc = Factory::getDocument();

$ID = str_replace('.', '_', substr(microtime(true), -8, 8));
?>
<ul class="accordion-menu VMmenu<?php echo $class_sfx ?>" id="<?php echo 'VMmenu'. $ID; ?>">
<?php foreach ($categories as $category) {
		$active_menu = '';
		$active_child = '';
		$active_collapse = '';
		$collapsed = ' collapsed';
		$caturl = Route::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$category->virtuemart_category_id);
		$cattext = $category->category_name. ' <span class="nmb_products">'.$categoryModel->countProducts($category->virtuemart_category_id ).'</span>';
		if (in_array( $category->virtuemart_category_id, $parentCategories)) {
			if (!empty($category->childs)) {
				foreach ($category->childs as $children) { 
					if ($children->virtuemart_category_id == $active_category_id) {
						$active_child = ' deeper';
					}
				} 
			}  
			$active_collapse = ' in collapse show'; 
			$active_menu = ' class="active'.$active_child.'"';
			$collapsed = '';
		} 
?>
<li<?php echo $active_menu; ?>>
	<?php echo JHTML::link($caturl, $cattext); ?>
		<?php if (!empty($category->childs)) { ?>
			 <span class="vmmenu-toggler<?php echo $collapsed; ?>" data-toggle="collapse" data-bs-toggle="collapse" data-bs-target="#collapse-vmmenu-<?php echo $category->virtuemart_category_id; ?>" aria-expanded="true" aria-controls="collapse-vmmenu-<?php echo $category->virtuemart_category_id; ?>" data-target="#collapse-vmmenu-<?php echo $category->virtuemart_category_id; ?>"><i style="font-weight:700;" class="open-icon pe pe-7s-angle-down pe-lg pe-va"></i></span>
		<ul class="collapse<?php echo $active_collapse . $class_sfx; ?>" id="collapse-vmmenu-<?php echo $category->virtuemart_category_id; ?>">
		<?php foreach ($category->childs as $child) {
				$active_child_menu = '';
				$catchildurl = Route::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$child->virtuemart_category_id);
				$catchildtext = '<svg style="opacity:.4;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash ms-0 me-1 text_color" viewBox="0 0 16 16"><path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/></svg>'. $child->category_name. '<span class="nmb_products">'.$categoryModel->countProducts($child->virtuemart_category_id ).'</span>';
				if ($child->virtuemart_category_id == $active_category_id) $active_child_menu = ' class="active current"';
				?>
				<li<?php echo $active_child_menu; ?>>
					<?php echo JHTML::link($catchildurl, $catchildtext); ?></li>
				<?php } ?>
		</ul>
		<?php } ?>
	  <?php } ?>
	</li>
</ul>
<?php 
// Add styles
$style = 'ul.VMmenu li ul li a {text-indent:-1px!important;text-align:left;}ul.VMmenu li ul ul li a {text-indent:10px!important;}';		 
$doc->addStyleDeclaration($style);
