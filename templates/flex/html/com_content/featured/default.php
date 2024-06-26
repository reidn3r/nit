<?php
/**
 * Flex @package Helix Framework
 * Template Name - Flex
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Factory;

$tpl_params = Factory::getApplication()->getTemplate(true)->params;
$doc = Factory::getDocument(); 

HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers');

// If the page class is defined, add to class as suffix.
// It will be a separate class if the user starts it with a space

	$num_columns = '';
	$col_md_Class = '';
	$num_columns = (int) $this->params->get('num_columns');
?>
<div class="blog-featured<?php echo $this->pageclass_sfx;?>" itemscope itemtype="http://schema.org/Blog">
<?php if ($this->params->get('show_page_heading') != 0) : ?>
<div class="page-header">
	<h1>
	<?php echo $this->escape($this->params->get('page_heading')); ?>
	</h1>
</div>
<?php endif; ?>
	
	
	<?php $leadingcount = 0; ?>
	<?php if (!empty($this->lead_items)) : ?>
		<div class="items-leading w-100 clearfix<?php echo ($num_columns > 1) ? ' mb-5' : ' mb-4'; ?> <?php echo $this->params->get('blog_class_leading'); ?>">
			<?php foreach ($this->lead_items as &$item) : ?>
				<article class="item leading-<?php echo $leadingcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?> clearfix" 
			itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">
						<?php
						$this->item = & $item;
						echo $this->loadTemplate('item');
						?>
				</article>
				<?php $leadingcount++; ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	
	<?php if (!empty($this->intro_items)) : ?>
		<?php $blogClass = $this->params->get('blog_class', ''); ?>
		<?php if ((int) $this->params->get('num_columns') > 1) { ?>
			<?php $blogClass .= (int) $this->params->get('multi_column_order', 0) === 0 ? ' masonry-' : ' columns-'; ?>
			<?php $blogClass .= (int) $this->params->get('num_columns'); 
	
			$col_md_Class = 'col-md-6 '; 
	
			if ($tpl_params->get('blog_layout') == 'masonry') { 
				// Masonry
				$doc->addScriptDeclaration('function r(f){/in/.test(document.readyState)?setTimeout(\'r(\'+f+\')\',9):f()}r(function(){jQuery(".featured-items").imagesLoaded(function(){jQuery(".featured-items").masonry({transitionDuration:0,itemSelector:".featured-item"})})});');
			}
			?>
		<?php } else { 
			$col_md_Class = ''; ?>
		<?php } ?>

		<div class="featured-items row clearfix<?php echo $blogClass; ?><?php echo ($num_columns > 1) ? ' mb-1' : ' mb-5'; ?> <?php echo $this->params->get('blog_class_leading'); ?>">
			<?php foreach ($this->intro_items as $key => &$item) : ?>
			
				<article class="<?php echo $col_md_Class; ?>col-lg-<?php echo round(12 / $num_columns); ?> featured-item mb-4 column-<?php echo $key; ?>" itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
						<?php
						$this->item = & $item;
						echo $this->loadTemplate('item');
						?>
				</article>
				
			<?php endforeach; ?>

		</div>
	<?php endif; ?>

	<?php if (!empty($this->link_items)) : ?>
		<div class="items-more w-100 clearfix mt-5 mb-4">
		<?php echo $this->loadTemplate('links'); ?>
		</div>
	<?php endif; ?>

	<?php if ($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2 && $this->pagination->pagesTotal > 1)) : ?>
		<div class="pagination w-100 clearfix mt-4">

			<?php if ($this->params->def('show_pagination_results', 1)) : ?>
				<p class="counter centered my-1">
					<?php echo $this->pagination->getPagesCounter(); ?>
				</p>
			<?php  endif; ?>
			<?php echo $this->pagination->getPagesLinks(); ?>
		</div>
	<?php endif; ?>

</div>
