<?php
/**
 * Flex @package Helix Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;

$doc = Factory::getDocument(); 

$categories = $viewData['categories'];
$categories_per_row = VmConfig::get ( 'categories_per_row', 3 );


if ($categories) {

// Category and Columns Counter
$iCol = 1;
$iCategory = 1;

// Calculating Categories Per Row
$category_cellwidth = ' width'.floor ( 100 / $categories_per_row );

// Separator
$verticalseparator = " vertical-separator";

$ajaxUpdate = '';
if(VmConfig::get ('ajax_category', false)){
	$ajaxUpdate = 'data-dynamic-update="1"';
}
?>
<div class="related-category-view">
<?php 
// Start the Output
    foreach ( $categories as $category ) {
	    // Show the horizontal seperator
	    if ($iCol == 1 && $iCategory > $categories_per_row) { ?>
	    <!--<div class="horizontal-separator"></div>-->
	    <?php }

	    // this is an indicator wether a row needs to be opened or not
	    if ($iCol == 1) { ?>
  <div class="row productwrap">
        <?php }

               // Show the vertical separator
        if ($iCategory == $categories_per_row or $iCategory % $categories_per_row == 0) {
          $show_vertical_separator = ' ';
        } else {
          $show_vertical_separator = $verticalseparator;
        }

        // Category Link
        $caturl = Route::_ ( 'index.php?option=com_virtuemart&view=category&virtuemart_category_id=' . $category->virtuemart_category_id , FALSE);

        // Show Category ?>
		<div class="category product col-sm-6 col-md-<?php echo floor ( 12 / $categories_per_row ) . $show_vertical_separator; ?>">
		  <div class="spacer">
			  <div class="spacer-img">
				<a href="<?php echo $caturl; ?>" title="<?php echo vmText::_($category->category_name) ?>" <?php echo $ajaxUpdate; ?>>
				  <?php echo $category->images[0]->displayMediaThumb('',false);
					//echo $category->images[0]->displayMediaThumb('class="browseCategoryImage"',false);
					echo '<span class="overlay"><h3>'. vmText::_($category->category_name) .'</h3></span>';
				  ?>
				</a>
			  </div>
		  </div>
		</div>
	    <?php
	    $iCategory ++;

	    // Do we need to close the current row now?
        if ($iCol == $categories_per_row) { ?>
		<!--<div class="clear"></div>-->
	</div>
		    <?php
		    $iCol = 1;
	    } else {
		    $iCol ++;
	    }
    }
	// Do we need a final closing row tag?
	if ($iCol != 1) { ?>
		<div class="clear"></div>
	</div>
	<?php
	}
	?></div><?php
 } ?>

