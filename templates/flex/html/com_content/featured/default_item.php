<?php
/**
 * Flex @package Helix Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Registry\Registry;
use Joomla\Component\Content\Administrator\Extension\ContentComponent;
use Joomla\Component\Content\Site\Helper\RouteHelper;

$doc = Factory::getDocument(); 

// Create a shortcut for params.
$params = $this->item->params;
$tpl_params = Factory::getApplication()->getTemplate(true)->params;

$canEdit = $this->item->params->get('access-edit');
$info = $params->get('info_block_position', 0);

// Post Format
$post_attribs = new Registry(json_decode( $this->item->attribs ));
$post_format = $post_attribs->get('post_format', 'standard');
$has_post_format = $tpl_params->get('show_post_format');

// Check if associations are implemented. If they are, define the parameter.
$assocParam = (Associations::isEnabled() && $params->get('show_associations'));

if (JVERSION < 4) {
	// Joomla 3...
	$currentDate   = Factory::getDate()->format('Y-m-d H:i:s');
	$isUnpublished = ($this->item->state == 0 || $this->item->publish_up > $currentDate)
	|| ($this->item->publish_down < $currentDate && $this->item->publish_down !== JFactory::getDbo()->getNullDate());
} else {
	// Joomla 4...
	$currentDate   = Factory::getDate()->format('Y-m-d H:i:s');
	$isUnpublished = ($this->item->state == ContentComponent::CONDITION_UNPUBLISHED || $this->item->publish_up > $currentDate)
	|| ($this->item->publish_down < $currentDate && $this->item->publish_down !== null);
}


// Group the params
$useDefList = ($params->get('show_title') || $params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date') || $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author') || $assocParam);

?>
<?php if ($isUnpublished) : ?>
	<div class="system-unpublished">
<?php endif; ?>
		
<?php $show_icons = LayoutHelper::render('joomla.content.post_formats.icons',  $post_format); ?>
<?php $show_images = LayoutHelper::render('joomla.content.intro_image', $this->item); ?>
<?php $show_images_post_format = LayoutHelper::render('joomla.content.post_formats.post_' . $post_format, array('params' => $post_attribs, 'item' => $this->item)); ?>

<?php if ($tpl_params->get('blog_layout') == 'masonry') { ?>
<div class="<?php echo $has_post_format ? ' has-post-format-masonry': ''; ?>">
	<?php if ($has_post_format && $show_images || $show_images_post_format) { ?>
    <span class="post-format-masonry"><?php echo $show_icons; ?></span>
    <?php } ?> 
</div>
<?php } ?>
		
<?php
	if($post_format=='standard') {
		echo LayoutHelper::render('joomla.content.intro_image', $this->item);
	} else {
		echo LayoutHelper::render('joomla.content.post_formats.post_' . $post_format, array('params' => $post_attribs, 'item' => $this->item));
	}
?>
<?php //if ($tpl_params->get('blog_layout') == 'masonry') { ?>
	<!-- START Post-intro --><div class="post_intro">
	<div class="entry-header">
		<?php if ($useDefList && ($info == 0 || $info == 2)) : ?>	
			<?php echo LayoutHelper::render('joomla.content.blog_style_default_item_title', $this->item); ?>
			<?php echo LayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'above')); ?>
		
		<?php endif; ?>
	</div>
<?php // } ?>

<?php if ($canEdit || $params->get('show_print_icon') || $params->get('show_email_icon')) : ?>
	<div class="edit-article pull-right"><?php echo LayoutHelper::render('joomla.content.icons', array('params' => $params, 'item' => $this->item)); ?></div>
<?php endif; ?>

<?php if ($useDefList && ($info == 1 || $info == 2)) : ?>
<div class="entry-header<?php echo $has_post_format ? ' has-post-format': ''; ?>">
	<?php if ($has_post_format && $show_images || $show_images_post_format) { ?>
    <span class="post-format"><?php echo $show_icons; ?></span>
    <?php } ?> 
    <?php echo LayoutHelper::render('joomla.content.blog_style_default_item_title', $this->item); ?>
	<?php echo LayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'below')); ?>
</div>
<?php endif; ?>
<?php if (!$params->get('show_intro')) : ?>
	<?php echo $this->item->event->afterDisplayTitle; ?>
<?php endif; ?>
<?php echo $this->item->event->beforeDisplayContent; ?>	
<?php echo $this->item->introtext; ?>
		
<?php if ($params->get('show_readmore') && $this->item->readmore) :
	if ($params->get('access-view')) :
		
		if (JVERSION < 4) {
			// Joomla 3...
			$link = Route::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language));
		} else {
			// Joomla 4...
			$link = Route::_(RouteHelper::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language));
		}
	else :
		$menu = Factory::getApplication()->getMenu();
		$active = $menu->getActive();
		$itemId = $active->id;
		$link = new Uri(Route::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false));
		if (JVERSION < 4) {
			// Joomla 3...
			$link->setVar('return', base64_encode(RouteHelper::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language)));
		} else {
			// Joomla 4...	
			$link->setVar('return', base64_encode(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language)));
		}		
	endif; ?>
 
	<?php echo LayoutHelper::render('joomla.content.readmore', array('item' => $this->item, 'params' => $params, 'link' => $link)); ?>
	<?php echo LayoutHelper::render('joomla.content.social_share.entrylist_share', $this->item); //Social Share ?>
    
<?php endif; ?>	
	<?php if ($params->get('show_tags') && !empty($this->item->tags->itemTags)) : ?>	
        <?php echo LayoutHelper::render('joomla.content.tags', $this->item->tags->itemTags); ?>
    <?php endif; ?>
    <?php if ($params->get('show_readmore') && $this->item->readmore) {  ?>
    <?php } else {   ?>
	   <?php echo LayoutHelper::render('joomla.content.social_share.entrylist_share', $this->item); //Social Share ?>
	<?php } ?>
  	<div class="clearfix mb-4"></div>
	<?php //if ($tpl_params->get('blog_layout') == 'masonry') { ?>
        </div><!-- END Post-intro -->
    <?php // } ?>
 
<?php if ($isUnpublished) : ?>
	</div>
<?php endif; ?>

<?php echo $this->item->event->afterDisplayContent; ?>