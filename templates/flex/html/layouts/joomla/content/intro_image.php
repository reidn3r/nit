<?php
/**
 * Flex @package Helix Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Filesystem\File;
use Joomla\Component\Content\Site\Helper\RouteHelper;


$tplParams 		= Factory::getApplication()->getTemplate(true)->params;
$params  		= $displayData->params;
$attribs 		= json_decode($displayData->attribs);
$images 		= json_decode($displayData->images);
$imgsize 		= $tplParams->get('blog_list_image', 'default');

$intro_image 	= '';

if (empty($images->image_intro)) {
    return;
}
// Include lazy load params
$has_lazyload = $tplParams->get('lazyload', 1);

// Global params
$imgfloat = empty($params->get('float_intro')) ? 'centered' : $params->get('float_intro');
// Article params
$imgclass = empty($images->float_intro) ? ' '. $imgfloat : ' '. $images->float_intro;

if(isset($attribs->spfeatured_image) && $attribs->spfeatured_image != '') {

	if($imgsize == 'default') {
		$intro_image = $attribs->spfeatured_image;
	} else {
		$intro_image = $attribs->spfeatured_image;
		$basename = basename($intro_image);
		$list_image = JPATH_ROOT . '/' . dirname($intro_image) . '/' . File::stripExt($basename) . '_'. $imgsize .'.' . File::getExt($basename);
		if(file_exists($list_image)) {
			$intro_image = Uri::root(true) . '/' . dirname($intro_image) . '/' . File::stripExt($basename) . '_'. $imgsize .'.' . File::getExt($basename);
		}
	}
} elseif(isset($images->image_intro) && !empty($images->image_intro)) {
	$intro_image = $images->image_intro;
}

// Image alt (from Flex 3.8.3)
$intro_alt = ($images->image_intro_alt != '') ? $intro_alt = htmlspecialchars($images->image_intro_alt) : $intro_alt = htmlspecialchars($this->escape($displayData->title));

?>
<?php if(!empty($intro_image) || (isset($images->image_intro) && !empty($images->image_intro))) { ?>
<div class="entry-image intro-image mx-auto">
	<?php if ($images->image_intro_caption) : echo '<div class="img-caption-overlay">'. htmlspecialchars($images->image_intro_caption, ENT_COMPAT, 'UTF-8') .'</div>'; endif; ?>
	<?php if ($params->get('link_titles') && $params->get('access-view')) { ?>
		<a href="<?php echo Route::_(ContentHelperRoute::getArticleRoute($displayData->slug, $displayData->catid, $displayData->language)); ?>">
	<?php } ?>
	<?php 
		if(strpos($intro_image, 'http://') !== false || strpos($intro_image, 'https://') !== false){
			if($has_lazyload && ($tplParams->get('blog_layout') != 'masonry')) { ?>
				<img class="lazyload<?php echo $this->escape($imgclass); ?>" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo $intro_image; ?>" alt="<?php echo $intro_alt; ?>">
			<?php } else { ?>
			<img class="<?php echo $this->escape($imgclass); ?>" src="<?php echo htmlspecialchars($intro_image); ?>" alt="<?php echo $intro_alt; ?>" itemprop="thumbnailUrl">
			<?php } 
			} else { 
			if($has_lazyload && ($tplParams->get('blog_layout') != 'masonry')) { ?>
				<img class="lazyload<?php echo $this->escape($imgclass); ?>" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo Uri::root() . $intro_image; ?>" alt="<?php echo $intro_alt; ?>">
			<?php } else { ?>
			<img class="<?php echo $this->escape($imgclass); ?>" src="<?php echo htmlspecialchars($intro_image); ?>" alt="<?php echo $intro_alt; ?>" itemprop="thumbnailUrl">
			<?php }
		} ?>
	<?php if ($params->get('link_titles') && $params->get('access-view')) { ?>
		</a>
	<?php } ?>
</div>
<?php } ?>
