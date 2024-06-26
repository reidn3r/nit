<?php
/**
 * Flex @package Helix Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Tags\Site\Helper\RouteHelper;

// Include template's params
$tpl_params = Factory::getApplication()->getTemplate(true)->params;
$has_lazyload = $tpl_params->get('lazyload', 1);

if (JVERSION < 4) {
	// Joomla 3...
	JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

	JHtml::_('behavior.core');
	JHtml::_('formbehavior.chosen', 'select');
} else {
	// Joomla 4...
	/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
	$wa = $this->document->getWebAssetManager();
	$wa->useScript('com_tags.tag-default');
}

// Get the user object.
$user = Factory::getUser();

// Check if user is allowed to add/edit based on tags permissions.
// Do we really have to make it so people can see unpublished tags?
$canEdit = $user->authorise('core.edit', 'com_tags');
$canCreate = $user->authorise('core.create', 'com_tags');
$canEditState = $user->authorise('core.edit.state', 'com_tags');

$columns = $this->params->get('tag_columns', 1);

// Avoid division by 0 and negative columns.
if ($columns < 1)
{
	$columns = 1;
}

$bsspans = floor(12 / $columns);

if ($bsspans < 1)
{
	$bsspans = 1;
}

$bscolumns = min($columns, floor(12 / $bsspans));
$n = count($this->items);

?>
<div class="com-tags__items">
<form action="<?php echo htmlspecialchars(Uri::getInstance()->toString()); ?>" method="post" name="adminForm" id="adminForm" class="form-inline">
	<?php if ($this->params->get('show_headings') || $this->params->get('filter_field') || $this->params->get('show_pagination_limit')) : ?>
	<fieldset class="filters btn-toolbar w-100 pb-2" role="toolbar">
		
		<?php if ($this->params->get('filter_field')) :?>
			<div class="com-tags-tags__filter btn-group" role="group">
				<label class="filter-search-lbl visually-hidden" for="filter-search">
					<?php echo Text::_('COM_TAGS_TITLE_FILTER_LABEL') . '&#160;'; ?>
				</label>
				
				<div class="input-group">
					<div class="input-group-text" id="btnGroupAddon">
						<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><circle cx="15" cy="15" r="4"></circle><path d="M18.5 18.5l2.5 2.5"></path><path d="M4 6h16"></path><path d="M4 12h4"></path><path d="M4 18h4"></path></svg>
					</div>
					<input style="min-height:40px;" type="text" name="filter-search" id="filter-search" value="<?php echo $this->escape($this->state->get('list.filter')); ?>" class="inputbox px-2 py-3" onchange="document.adminForm.submit();" title="<?php echo Text::_('COM_TAGS_FILTER_SEARCH_DESC'); ?>" placeholder="<?php echo Text::_('COM_TAGS_TITLE_FILTER_LABEL'); ?>" placeholder="Input group example" aria-label="Input group example" aria-describedby="btnGroupAddon" />
				</div>
				<button type="submit" name="filter_submit" class="btn sppb-btn-dark px-3 btn-sm"><i class="fas fa-sort pe-2"></i><?php echo Text::_('JGLOBAL_FILTER_BUTTON'); ?></button>
				<button type="reset" name="filter-clear-button" class="btn sppb-btn-default px-3 btn-sm"><i class="fas fa-times pe-1"></i><?php echo Text::_('JSEARCH_FILTER_CLEAR'); ?></button>
			</div>
		<?php endif; ?>
		<?php if ($this->params->get('show_pagination_limit')) : ?>
			<div class="float-end">
				<label for="limit" class="visually-hidden">
					<?php echo Text::_('JGLOBAL_DISPLAY_NUM'); ?>
				</label>
				<?php echo $this->pagination->getLimitBox(); ?>
			</div>
		<?php endif; ?>
		<input type="hidden" name="limitstart" value="">
		<input type="hidden" name="task" value="">
	</fieldset>
	<?php endif; ?>
</form>
	
	<?php if ($this->items == false || $n === 0) : ?>
		<div class="alert alert-info">
			<span class="icon-info-circle" aria-hidden="true"></span><span class="visually-hidden"><?php echo Text::_('INFO'); ?></span>
			<?php echo Text::_('COM_TAGS_NO_TAGS'); ?>
		</div>
	<?php else : ?>
		<ul class="com-tags__category category list-striped px-4 px-sm-0">
		<?php foreach ($this->items as $i => $item) : 
			
			
			if (JVERSION < 4) {
				// Joomla 3...
				$link = Route::_(TagsHelperRoute::getItemRoute($item->content_item_id, $item->core_alias, $item->core_catid, $item->core_language, $item->type_alias, $item->router));
			} else {
				// Joomla 4...
				$link = Route::_(RouteHelper::getItemRoute($item->content_item_id, $item->core_alias, $item->core_catid, $item->core_language, $item->type_alias, $item->router));
			}
			
			
			if ($item->core_state == 0) : ?>
				<li class="system-unpublished cat-list-row-<?php echo $i % 2; ?>">
			<?php else: ?>
				<li class="cat-list-row-<?php echo $i % 2; ?> clearfix" >
                <div class="sp-module">
                <h3 class="sp-module-title">
					<a href="<?php echo $link; ?>">
						<?php echo $this->escape($item->core_title); ?>
					</a>
                <div class="divider"></div>
				</h3><div class="divider"></div>
                </div>
			<?php endif; ?>
			<?php echo $item->event->afterDisplayTitle; ?>
			<?php $images = json_decode($item->core_images);?>			
			<?php if ($this->params->get('tag_list_show_item_image', 1) == 1 && !empty($images->image_intro)) :?>	
				<?php if (JVERSION < 4) { ?>
					<a class="tag-img pull-left" href="<?php echo Route::_(TagsHelperRoute::getItemRoute($item->content_item_id, $item->core_alias, $item->core_catid, $item->core_language, $item->type_alias, $item->router)); ?>">
				<?php } else { ?>		
					<a class="tag-img pull-left" href="<?php echo Route::_(RouteHelper::getItemRoute($item->content_item_id, $item->core_alias, $item->core_catid, $item->core_language, $item->type_alias, $item->router)); ?>">
				<?php } ?>
					<div class="overlay">
					<?php 
					if(strpos($images->image_intro, 'http://') !== false || strpos($images->image_intro, 'https://') !== false){
						if($has_lazyload) { ?>
							<img class="lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo $images->image_intro; ?>" alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>" data-expand="-10">
						<?php } else { ?>
							<img src="<?php echo htmlspecialchars($images->image_intro);?>" alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>">
						<?php } 
						} else { 
						if($has_lazyload) { ?>
							<img class="lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo Uri::root() . $images->image_intro; ?>" alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>" data-expand="-10">
						<?php } else { ?>
							<img src="<?php echo htmlspecialchars($images->image_intro);?>" alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>">
						<?php }
					} ?>
						<i class="fas fa-link"></i>
                	</div>
                </a>   
			<?php endif; ?>
				<?php if ($this->params->get('tag_list_show_item_description', 1)) : ?>
					<?php echo $item->event->beforeDisplayContent; ?>
					<span class="tag-body">
						<?php echo HTMLHelper::_('string.truncate', $item->core_body, $this->params->get('tag_list_item_maximum_characters')); ?>
					</span>
					<?php echo $item->event->afterDisplayContent; ?>
				<?php endif; ?>
					</li>    
			   <?php if ($n > 1 && $this->params->get('tag_list_show_item_image', 1) == 1 || $this->params->get('tag_list_show_item_description', 1) ) { ?>
				<div style="height:40px;width:100%;clear:both;"></div>
				<?php } ?>    
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</div>
