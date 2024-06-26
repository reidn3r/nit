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
?>
<div class="additional-images col-sm-12">
	<?php
	$start_image = VmConfig::get('add_img_main', 1) ? 0 : 1;
	for ($i = $start_image; $i < count($this->product->images); $i++) {
		$image = $this->product->images[$i];
		$cols = count($this->product->images) - 1;
		
			if(VmConfig::get('add_img_main', 1)) {
				echo $image->displayMediaThumb('class="product-image" style="cursor: pointer"',false,$image->file_description);
				echo '<a href="'. $image->file_url .'"  class="product-image image-'. $i .'" style="display:none;" title="'. $image->file_meta .'" rel="vm-additional-images"></a>';
			} else {
				if (count($this->product->images) < 6) {
					echo '<div class="cols cols-'.$cols.'">';
					echo $image->displayMediaThumb("",true,"rel='vm-additional-images'",true,$image->file_description);
					echo '</div>';
				} else {
					echo '<div class="cols cols-3">';
					echo $image->displayMediaThumb("",true,"rel='vm-additional-images'",true,$image->file_description);
					echo '</div>';
				}
			} ?>
	<?php } ?>	
</div>

