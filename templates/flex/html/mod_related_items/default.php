<?php
/**
 * Flex @package Helix Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2020 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

// Include template's params
$tpl_params = Factory::getApplication()->getTemplate(true)->params;
$has_lazyload = $tpl_params->get('lazyload', 1);
$doc = Factory::getDocument(); 
?>
<?php //echo count($list); ?>
<!--<div class="container">-->
<div class="relateditems <?php echo $moduleclass_sfx; ?>row d-inline-flex clearfix w-100 pt-2 pb-5">
<?php foreach ($list as $item) :	

	$attrbs = json_decode($item->attribs);
	$images = json_decode($item->images);
	$thumb_image = '';
	
	if(isset($images->image_intro) && !empty($images->image_intro)) {
		if(isset($attrbs->spfeatured_image) && !empty($attrbs->spfeatured_image)) {
			$thumb_image = $attrbs->spfeatured_image;
		} else {
			$thumb_image = $images->image_intro;
		}
	} elseif(isset($attrbs->spfeatured_image) && !empty($attrbs->spfeatured_image)) {
		$thumb_image = $attrbs->spfeatured_image;	
	} 
	

	//$doc->addScriptDeclaration('jQuery(function($){$(".relateditems").imagesLoaded(function(){$(".relateditems").masonry({itemSelector:".relateditem"})})});');


?>
<div class="relateditem col-md-6" itemscope itemtype="http://schema.org/Article">
	<a href="<?php echo $item->route; ?>" itemprop="url">
        <?php if (!empty($thumb_image)) {?>
                <span class="img-responsive article-list-img">
                    <span class="overlay"></span>
                    <?php 
					if(strpos($thumb_image, 'http://') !== false || strpos($thumb_image, 'https://') !== false){
						if($has_lazyload) { ?>
                        	<img class="lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo $thumb_image; ?>" alt="<?php echo $item->title; ?>" data-expand="-20">
                    	<?php } else { ?>
                        	<img src="<?php echo $thumb_image; ?>" alt="<?php echo $item->title; ?>">
                        <?php } 
						} else { 
                        if($has_lazyload) { ?>
                        	<img class="lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo Uri::root() . $thumb_image; ?>" alt="<?php echo $item->title; ?>" data-expand="-20">
                    	<?php } else { ?>
                        	<img src="<?php echo $thumb_image; ?>" alt="<?php echo $item->title; ?>">
                        <?php }
						} ?>  
                </span>
            <?php } ?>
            
		<span class="related-articles-title" itemprop="name">
			<?php echo $item->title; ?>
        </span> 
        <?php // echo $item->introtext; ?>
        <?php if ($showDate) echo '<div class="related_date">'.JHTML::_('date', $item->created, JText::_('d F Y H:i')).'</div>'; ?>
        
        </a>
	</div>
<?php endforeach; ?>
</div>
<!--</div>-->
