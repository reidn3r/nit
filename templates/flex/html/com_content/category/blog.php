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
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Layout\LayoutHelper;

$app = Factory::getApplication();

if (JVERSION < 4) { 
	// Joomla 3... 
	JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
	//JHtml::_('behavior.caption');
	$dispatcher = JEventDispatcher::getInstance();
}

$doc = Factory::getDocument(); 
$config = Factory::getConfig();
$sitename = $config->get('sitename');

/* Load template's parameters */
$tpl_params = Factory::getApplication()->getTemplate(true)->params;

//opengraph
$doc->addCustomTag('<meta property="og:url" content="'. Uri::current() . '" />');
$doc->addCustomTag('<meta property="og:site_name" content="'. htmlspecialchars($sitename) .'" />');
$doc->addCustomTag('<meta property="og:type" content="blog" />');
if (isset($this->category->title)) {
$doc->addCustomTag('<meta property="og:title" content="'. $this->category->title .'" />');
}

if (!empty($this->category->getParams()->get('image'))) {
	$doc->addCustomTag('<meta property="og:image" content="'. Uri::root().ltrim($this->category->getParams()->get('image'), '/') .'" />');
	$doc->addCustomTag('<meta property="og:image:width" content="900" />');
	$doc->addCustomTag('<meta property="og:image:height" content="600" />');
}
// Twitter
$doc->addCustomTag('<meta name="twitter:card" content="summary" />');
$doc->addCustomTag('<meta name="twitter:site" content="'. htmlspecialchars($sitename) .'" />');
$doc->addCustomTag('<meta name="twitter:title" content="'. $this->category->title .'" />');
if (!empty($this->category->getParams()->get('image'))) {
    $doc->addCustomTag('<meta name="twitter:image:src" content="'. Uri::root().ltrim($this->category->getParams()->get('image'), '/') .'" />');
}

$masonry_item_spacing = $tpl_params->get('blog_item_spacing', 0);
$masonry_item_img_margin = '';

if ($masonry_item_spacing == 0) {
	$masonry_item_padding = 'padding:0;';
	$blog_hr = 'hr.blog_hr {margin-bottom:0}';
	$masonry_item_img_margin = '.masonry_item .intro-image {margin-bottom:25px;}';
} else {
	$masonry_item_padding = 'padding:0 '. $masonry_item_spacing . 'px '. $masonry_item_spacing . 'px;';
	$blog_hr = '';
	$masonry_item_img_margin = '.masonry_item .intro-image {margin-bottom:'. $masonry_item_spacing . 'px;}';
}
$tpl_params->get('blog_item_bg') != '' ? $blog_item_bg = 'background-color:' . $tpl_params->get('blog_item_bg') . ';' : $blog_item_bg = '';

if ($tpl_params->get('blog_layout') == 'masonry') :
// Add styles for Masonry
$post_style = '.masonry_item .item .post_intro {'
		. $masonry_item_padding
		. $blog_item_bg
		. '}'
		. $blog_hr
		. $masonry_item_img_margin;
$doc->addStyleDeclaration($post_style);
endif;

$this->category->text = $this->category->description;
$app->triggerEvent('onContentPrepare', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$this->category->description = $this->category->text;

$results = $app->triggerEvent('onContentAfterTitle', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$afterDisplayTitle = trim(implode("\n", $results));

$results = $app->triggerEvent('onContentBeforeDisplay', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$beforeDisplayContent = trim(implode("\n", $results));

$results = $app->triggerEvent('onContentAfterDisplay', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$afterDisplayContent = trim(implode("\n", $results));

$htag = $this->params->get('show_page_heading') ? 'h2' : 'h1';

?>
<div class="blog<?php echo $this->pageclass_sfx; ?>" itemscope itemtype="http://schema.org/Blog">
	<?php if ($this->params->get('show_page_heading', 1)) : ?>
		<div class="page-header">
			<h1> <?php echo $this->escape($this->params->get('page_heading')); ?> </h1>
		</div>
	<?php endif; ?>

	<?php if ($this->params->get('show_category_title', 1) or $this->params->get('page_subheading')) : ?>
		<h2><?php echo $this->escape($this->params->get('page_subheading')); ?>
			<?php if ($this->params->get('show_category_title')) : ?>
				<span class="subheading-category"><?php echo $this->category->title; ?></span>
			<?php endif; ?>
		</h2>
	<?php endif; ?>
	
	<?php if ($this->params->get('show_cat_tags', 1) && !empty($this->category->tags->itemTags)) : ?>
		<?php $this->category->tagLayout = new FileLayout('joomla.content.tags'); ?>
		<?php echo $this->category->tagLayout->render($this->category->tags->itemTags); ?>
	<?php endif; ?>

	<?php if ($this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
		<div class="category-desc clearfix">
			
			<?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
				<?php echo LayoutHelper::render(
					'joomla.html.image',
					[
						'src' => $this->category->getParams()->get('image'),
						'alt' => empty($this->category->getParams()->get('image_alt')) && empty($this->category->getParams()->get('image_alt_empty')) ? false : $this->category->getParams()->get('image_alt'),
					]
				); ?>
			<?php endif; ?>
			
			<?php if ($this->params->get('show_description') && $this->category->description) : ?>
				<?php echo HTMLHelper::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	
	<?php if (empty($this->lead_items) && empty($this->link_items) && empty($this->intro_items)) : ?>
		<?php if ($this->params->get('show_no_articles', 1)) : ?>
			<div class="alert alert-info">
				<span class="icon-info-circle" aria-hidden="true"></span><span class="visually-hidden"><?php echo Text::_('INFO'); ?></span>
					<?php echo Text::_('COM_CONTENT_NO_ARTICLES'); ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<?php $leadingcount = 0; ?>
	<?php if (!empty($this->lead_items)) : ?>
		<div class="items-leading clearfix mb-4">
			<?php foreach ($this->lead_items as &$item) : ?>
				<article class="item leading-<?php echo $leadingcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?><?php echo $item->featured ? ' item-featured' : ''; ?>"
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
	
	<?php
	$introcount = (count($this->intro_items));
	$counter = 0;
	
	// Masonry or Classic grid:
	if (!empty($this->intro_items)) : ?>
		<?php $blogClass = $this->params->get('blog_class', ''); ?>
		<?php if ((int) $this->params->get('num_columns') > 1) : ?>
			<?php $masonryItemsClass = ($tpl_params->get('blog_layout') == 'masonry') ? ' items-masonry masonry-'.$this->category->id.'' : ''; ?>
			<?php $masonryItemClass = ($tpl_params->get('blog_layout') == 'masonry') ? ' masonry_item' : ' mb-4'; ?>
			<?php $blogClass .= 'cols-' . (int) $this->params->get('num_columns'); ?>
		<?php endif; ?>
			<div class="items-row<?php echo $masonryItemsClass; ?> row row-<?php echo $counter + 1; ?> <?php echo $blogClass; ?>">
			<?php foreach ($this->intro_items as $key => &$item) : ?>
				<div class="col-lg-<?php echo round(12 / $this->params->get('num_columns')); ?><?php echo $masonryItemClass; ?>">
					<article class="item column-<?php //echo $rowcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?><?php echo $item->featured ? ' item-featured' : ''; ?>"
						itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
						<?php
						$this->item = & $item;
						echo $this->loadTemplate('item');
						?>
					</article>
					<?php $counter++; ?>
				</div>
			<?php endforeach; ?>
			</div>
	<?php endif; ?>
</div>

<?php if (!empty($this->link_items)) : ?>
	<div class="items-more w-100 clearfix mt-5 mb-4">
		<?php echo $this->loadTemplate('links'); ?>
	</div>
<?php endif; ?>
<?php if (!empty($this->children[$this->category->id]) && $this->maxLevel != 0) : ?>
	<div class="cat-children clearfix">
		<?php if ($this->params->get('show_category_heading_title_text', 1) == 1) : ?>
			<h3><?php echo Text::_('JGLOBAL_SUBCATEGORIES'); ?></h3>
		<?php endif; ?>
		<?php echo $this->loadTemplate('children'); ?></div>
<?php endif; ?>

<?php if (($this->params->def('show_pagination', 1) == 1 || ($this->params->get('show_pagination') == 2)) && ($this->pagination->pagesTotal > 1)) : ?>
	<div class="pagination-wrapper pagination w-100 clearfix mt-4 mt-5">
		<?php if ($this->params->def('show_pagination_results', 1)) : ?>
			<p class="counter centered clearfix pt-3 pe-2">
				<?php echo $this->pagination->getPagesCounter(); ?>
			</p>
		<?php endif; ?>
		<div class="com-content-category-blog__pagination w-100 clearfix d-block">
			<?php echo $this->pagination->getPagesLinks(); ?>
		</div>
	</div>
<?php endif; 
// Fixed Masonry
if ($tpl_params->get('blog_layout') == 'masonry') {$doc->addScriptDeclaration('function r(f){/in/.test(document.readyState)?setTimeout(\'r(\'+f+\')\',9):f()}r(function(){jQuery(".masonry-'.$this->category->id.'").imagesLoaded(function(){jQuery(".masonry-'.$this->category->id.'").masonry({transitionDuration:0,itemSelector:".masonry_item"})})});');
} ?>