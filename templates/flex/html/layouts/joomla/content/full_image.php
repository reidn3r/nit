<?php
/**
 * Flex @package Helix Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

$params = $displayData->params;
$tplParams = Factory::getApplication()->getTemplate(true)->params; // Template's params
$attribs = json_decode($displayData->attribs);
$images = json_decode($displayData->images);

// Include lazy load params
$has_lazyload = $tplParams->get('lazyload', 1);
$full_image = '';

if (empty($images->image_fulltext)) {
    return;
}

// Global params
$imgfloat = empty($params->get('float_fulltext')) ? 'centered' : $params->get('float_fulltext');
// Article params
$imgclass = empty($images->float_fulltext) ? ' '. $imgfloat : ' '. $images->float_fulltext;

if(isset($attribs->spfeatured_image) && $attribs->spfeatured_image != '') {
	$full_image = $attribs->spfeatured_image;
} elseif(isset($images->image_fulltext) && !empty($images->image_fulltext)) {
	$full_image = $images->image_fulltext;
}

// Image alt (from Flex 3.8.3)
$intro_alt = ($images->image_fulltext_alt != '') ? $intro_alt = htmlspecialchars($images->image_fulltext_alt) : $intro_alt = htmlspecialchars($this->escape($displayData->title));
?>
<?php if(!empty($full_image) || (isset($images->image_fulltext) && !empty($images->image_fulltext))) { ?>
	<div class="entry-image full-image mx-auto">
		<?php if ($images->image_fulltext_caption) : echo '<div class="img-caption-overlay">'. htmlspecialchars($images->image_fulltext_caption) .'</div>'; endif; ?>
		<?php if(strpos($full_image, 'http://') !== false || strpos($full_image, 'https://') !== false){
			if($has_lazyload) { ?>
				<img class="lazyload<?php echo $this->escape($imgclass); ?>" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo htmlspecialchars($full_image); ?>" alt="<?php echo $intro_alt; ?>">
			<?php } else { ?>
			<img class="<?php echo $this->escape($imgclass); ?>" src="<?php echo htmlspecialchars($full_image); ?>" alt="<?php echo $intro_alt; ?>" itemprop="image">
			<?php } 
			} else { 
			if($has_lazyload) { ?>
				<img class="lazyload<?php echo $this->escape($imgclass); ?>" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo Uri::root() . htmlspecialchars($full_image); ?>" alt="<?php echo $intro_alt; ?>">
			<?php } else { ?>
			<img class="<?php echo $this->escape($imgclass); ?>" src="<?php echo htmlspecialchars($full_image); ?>" alt="<?php echo $intro_alt; ?>" itemprop="image">
			<?php }
		} ?>
     </div>
<?php } ?>
