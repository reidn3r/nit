<?php
/**
 * Flex @package Helix Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Content\Site\Helper\RouteHelper;

if ($this->maxLevelcat != 0 && count($this->items[$this->parent->id]) > 0) :

if (JVERSION < 4) {
	$link = Route::_(ContentHelperRoute::getCategoryRoute($item->id, $item->language));
} else {
	$link = Route::_(RouteHelper::getCategoryRoute($item->id, $item->language));
}

foreach ($this->items[$this->parent->id] as $id => $item) : 
	if ($this->params->get('show_empty_categories_cat') || $item->numitems || count($item->getChildren())) :
		if (!isset($this->items[$this->parent->id][$id + 1]))
		{
			$class = ' class="last"';
		}
		?>
		<div <?php echo $class; ?> >
		<?php $class = ''; ?>
			<h3 class="page-header item-title">
				<a href="<?php echo $link; ?>">
				<?php echo $this->escape($item->title); ?></a>
					<?php if ($this->params->get('show_cat_num_articles_cat') == 1) :?>
						<span style="font-size:0.5em;" class="badge bg-secondary mx-2 pe-va">
							<?php echo Text::_('COM_CONTENT_NUM_ITEMS'); ?>&nbsp;
							<?php echo $item->numitems; ?>
						</span>
					<?php endif; ?>
			
				<?php if (count($item->getChildren()) > 0 && $this->maxLevelcat > 1) : ?>
					<a id="category-btn-<?php echo $item->id; ?>" href="#category-<?php echo $item->id; ?>"
						data-toggle="collapse" data-toggle="button" class="btn btn-mini pull-right" aria-label="<?php echo Text::_('JGLOBAL_EXPAND_CATEGORIES'); ?>"><span class="icon-plus" aria-hidden="true"></span></a>
				<?php endif; ?>
			</h3>
			<?php if ($this->params->get('show_description_image') && $item->getParams()->get('image')) : ?>
            <?php 
			$cat_image = $item->getParams()->get('image');
			if(strpos($cat_image, 'http://') !== false || strpos($cat_image, 'https://') !== false){
				if($has_lazyload) { ?>
					<img class="lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo $cat_image; ?>" alt="<?php echo htmlspecialchars($item->getParams()->get('image_alt'), ENT_COMPAT, 'UTF-8'); ?>" data-expand="-10">
				<?php } else { ?>
					<img src="<?php echo $cat_image; ?>" alt="<?php echo htmlspecialchars($item->getParams()->get('image_alt'), ENT_COMPAT, 'UTF-8'); ?>" />
				<?php } 
				} else { 
				if($has_lazyload) { ?>
					<img class="lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo Uri::root() . $cat_image; ?>" alt="<?php echo htmlspecialchars($item->getParams()->get('image_alt'), ENT_COMPAT, 'UTF-8'); ?>" data-expand="-10">
				<?php } else { ?>
					<img src="<?php echo $cat_image; ?>" alt="<?php echo htmlspecialchars($item->getParams()->get('image_alt'), ENT_COMPAT, 'UTF-8'); ?>" />
				<?php }
			} ?>
			<?php endif; ?>
			<?php if ($this->params->get('show_subcat_desc_cat') == 1) : ?>
				<?php if ($item->description) : ?>
					<div class="category-desc">
						<?php echo HTMLHelper::_('content.prepare', $item->description, '', 'com_content.categories'); ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>

			<?php if (count($item->getChildren()) > 0 && $this->maxLevelcat > 1) : ?>
				<div class="collapse fade" id="category-<?php echo $item->id; ?>">
				<?php
				$this->items[$item->id] = $item->getChildren();
				$this->parent = $item;
				$this->maxLevelcat--;
				echo $this->loadTemplate('items');
				$this->parent = $item->getParent();
				$this->maxLevelcat++;
				?>
				</div>
			<?php endif; ?>
		</div>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>
