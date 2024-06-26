<?php
/**
 * Flex @package SP Page Builder
 * Template Name - Flex
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
// no direct access
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;

if (JVERSION < 4) {
	// Joomla 3
	HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers/html');
} else {
	// Joomla 4
	$wa = $this->document->getWebAssetManager();
	$wa->useScript('keepalive')
	->useScript('form.validate')
	->useScript('com_content.form-edit');
}

$this->tab_name = 'com-content-form';
$this->ignore_fieldsets = array('image-intro', 'image-full', 'jmetadata', 'sppostformats', 'item_associations');

$this->useCoreUI = true;

// Create shortcut to parameters.
$params = $this->state->get('params');

// This checks if the editor config options have ever been saved. If they haven't they will fall back to the original settings.
$editoroptions = isset($params->show_publishing_options);

if (!$editoroptions)
{
	$params->show_urls_images_frontend = '0';
}
?>
<div class="edit item-page<?php echo $this->pageclass_sfx; ?>">
	<?php if ($params->get('show_page_heading')): ?>
		<div class="page-header">
			<h1>
				<?php echo $this->escape($params->get('page_heading')); ?>
			</h1>
		</div>
	<?php endif ?>		
	<form action="<?php echo Route::_('index.php?option=com_content&a_id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate form-vertical com-content-adminForm">
		<fieldset>
			<?php echo HTMLHelper::_((JVERSION < 4 ? 'bootstrap' : 'uitab') . '.startTabSet', $this->tab_name, ['active' => 'editor', 'recall' => true, 'breakpoint' => 768]); ?>
			<?php echo HTMLHelper::_((JVERSION < 4 ? 'bootstrap' : 'uitab') . '.addTab', $this->tab_name, 'editor', Text::_('COM_CONTENT_ARTICLE_CONTENT')); ?>
			
			<div class="p-2 py-3">
			
				<?php echo $this->form->renderField('title'); ?>
			
				<?php if (is_null($this->item->id)) : ?>
					<?php echo $this->form->renderField('alias'); ?>
				<?php endif; ?>

				<?php echo $this->form->renderField('articletext'); ?>

				<?php if ($this->captchaEnabled) : ?>
					<?php echo $this->form->renderField('captcha'); ?>
				<?php endif; ?>
				
			</div>
			
			<?php echo HTMLHelper::_((JVERSION < 4 ? 'bootstrap' : 'uitab') . '.endTab'); ?>
			
			<?php echo HTMLHelper::_((JVERSION < 4 ? 'bootstrap' : 'uitab') . '.addTab', $this->tab_name, 'sppostformats', Text::_('BLOG_OPTIONS')); ?>
				<?php $attribs = json_decode($this->item->attribs); ?>
			<div class="p-4">
				<?php echo $this->form->renderField('spfeatured_image','attribs', (isset($attribs->spfeatured_image)? $attribs->spfeatured_image: '')); ?>
				<div class="mt-3">
				<?php echo $this->form->renderField('post_format','attribs', (isset($attribs->post_format)? $attribs->post_format: '')); ?>
				<?php echo $this->form->renderField('gallery','attribs', (isset($attribs->gallery)? $attribs->gallery: '')); ?>
				<?php echo $this->form->renderField('audio','attribs', (isset($attribs->audio)? $attribs->audio: '')); ?>
				<?php echo $this->form->renderField('video','attribs', (isset($attribs->video)? $attribs->video: '')); ?>
				<?php echo $this->form->renderField('link_title','attribs', (isset($attribs->link_title)? $attribs->link_title: '')); ?>
				<?php echo $this->form->renderField('link_url','attribs', (isset($attribs->link_url)? $attribs->link_url: '')); ?>
				<?php echo $this->form->renderField('quote_text','attribs',(isset($attribs->quote_text)? $attribs->quote_text: '')); ?>
				<?php echo $this->form->renderField('quote_author','attribs',(isset($attribs->quote_author)? $attribs->quote_author: '')); ?>
				<?php echo $this->form->renderField('post_status','attribs',(isset($attribs->post_status)? $attribs->post_status: '')); ?>
				<?php echo $this->form->renderField('custom_post','attribs',(isset($attribs->custom_post)? $attribs->custom_post: '')); ?>
				</div>
			</div>
			
			
			<?php echo HTMLHelper::_((JVERSION < 4 ? 'bootstrap' : 'uitab') . '.endTab'); ?>
			
			
			<?php if ($params->get('show_urls_images_frontend')) : ?>
			<?php echo HTMLHelper::_((JVERSION < 4 ? 'bootstrap' : 'uitab') . '.addTab', $this->tab_name, 'images', Text::_('COM_CONTENT_IMAGES_AND_URLS')); ?>
			<div class="p-4">
				<?php echo $this->form->renderField('image_intro', 'images'); ?>
				<div class="py-2"><?php echo $this->form->renderField('image_intro_alt', 'images'); ?></div>
				<div class="py-2"><?php echo $this->form->renderField('image_intro_caption', 'images'); ?></div>
				<div class="py-2"><?php echo $this->form->renderField('float_intro', 'images'); ?></div>
				<div class="py-2"><?php echo $this->form->renderField('image_fulltext', 'images'); ?></div>
				<div class="py-2"><?php echo $this->form->renderField('image_fulltext_alt', 'images'); ?></div>
				<div class="py-2"><?php echo $this->form->renderField('image_fulltext_caption', 'images'); ?></div>
				<div class="py-2"><?php echo $this->form->renderField('float_fulltext', 'images'); ?></div>
				<div class="py-2"><?php echo $this->form->renderField('urla', 'urls'); ?></div>
				<div class="py-2"><?php echo $this->form->renderField('urlatext', 'urls'); ?></div>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getInput('targeta', 'urls'); ?>
					</div>
				</div>
				<?php echo $this->form->renderField('urlb', 'urls'); ?>
				<?php echo $this->form->renderField('urlbtext', 'urls'); ?>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getInput('targetb', 'urls'); ?>
					</div>
				</div>
				<?php echo $this->form->renderField('urlc', 'urls'); ?>
				<?php echo $this->form->renderField('urlctext', 'urls'); ?>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getInput('targetc', 'urls'); ?>
					</div>
				</div>
			</div>
			<?php echo HTMLHelper::_((JVERSION < 4 ? 'bootstrap' : 'uitab') . '.endTab'); ?>
			<?php endif; ?>

			<?php //echo JLayoutHelper::render('joomla.edit.params', $this); ?>
			<?php echo LayoutHelper::render('joomla.edit.params', $this); ?>

			<?php echo HTMLHelper::_((JVERSION < 4 ? 'bootstrap' : 'uitab') . '.addTab', $this->tab_name, 'publishing', Text::_('COM_CONTENT_PUBLISHING')); ?>
			
			<div class="p-4">
				<?php echo $this->form->renderField('transition'); ?>
				<?php echo $this->form->renderField('state'); ?>
				<?php echo $this->form->renderField('catid'); ?>
				<?php echo $this->form->renderField('tags'); ?>
				<?php echo $this->form->renderField('note'); ?>
				<?php if ($params->get('save_history', 0)) : ?>
					<?php echo $this->form->renderField('version_note'); ?>
				<?php endif; ?>
				
				<?php if ($params->get('show_publishing_options', 1) == 1) : ?>
					<?php echo $this->form->renderField('created_by_alias'); ?>
				<?php endif; ?>
			
				
				<?php if ($this->item->params->get('access-change')) : ?>
					<?php echo $this->form->renderField('featured'); ?>
					<?php if ($params->get('show_publishing_options', 1) == 1) : ?>
						<?php echo $this->form->renderField('featured_up'); ?>
						<?php echo $this->form->renderField('featured_down'); ?>
						<?php echo $this->form->renderField('publish_up'); ?>
						<?php echo $this->form->renderField('publish_down'); ?>
					<?php endif; ?>
				<?php endif; ?>
				
				<?php echo $this->form->renderField('access'); ?>
				<?php if (is_null($this->item->id)) : ?>
					<div class="control-group">
						<div class="control-label">
						</div>
						<div class="controls">
							<?php echo Text::_('COM_CONTENT_ORDERING'); ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
			<?php echo HTMLHelper::_((JVERSION < 4 ? 'bootstrap' : 'uitab') . '.endTab'); ?>

			<?php if (JVERSION < 4): ?>
				<?php echo HTMLHelper::_('bootstrap.addTab', $this->tab_name, 'language', Text::_('JFIELD_LANGUAGE_LABEL')); ?>
					<?php echo $this->form->renderField('language'); ?>
				<?php echo HTMLHelper::_('bootstrap.endTab'); ?>
			<?php else: ?>
				<?php //if (Joomla\CMS\Language\Multilanguage::isEnabled()) : ?>
				<?php if (Multilanguage::isEnabled()) : ?>
					<?php echo HTMLHelper::_('uitab.addTab', $this->tab_name, 'language', Text::_('JFIELD_LANGUAGE_LABEL')); ?>
						<?php echo $this->form->renderField('language'); ?>
					<?php echo HTMLHelper::_('uitab.endTab'); ?>
				<?php else: ?>
					<?php echo $this->form->renderField('language'); ?>
				<?php endif; ?>
			<?php endif ?>

			<?php if ($params->get('show_publishing_options', 1) == 1) : ?>
				<?php echo HTMLHelper::_((JVERSION < 4 ? 'bootstrap' : 'uitab') . '.addTab', $this->tab_name, 'metadata', Text::_('COM_CONTENT_METADATA')); ?>
				<div class="p-4">
					<?php echo $this->form->renderField('metadesc'); ?>
					<?php echo $this->form->renderField('metakey'); ?>
				</idv>
				<?php echo HTMLHelper::_((JVERSION < 4 ? 'bootstrap' : 'uitab') . '.endTab'); ?>
			<?php endif; ?>

			<?php echo HTMLHelper::_((JVERSION < 4 ? 'bootstrap' : 'uitab') . '.endTabSet'); ?>
	
			<input type="hidden" name="task" value="" />
			<input type="hidden" name="return" value="<?php echo $this->return_page; ?>" />
	
			<?php if ($this->params->get('enable_category', 0) == 1) :?>
				<input type="hidden" name="jform[catid]" value="<?php echo $this->params->get('catid', 1); ?>" />
			<?php endif; ?>

			<?php echo HTMLHelper::_('form.token'); ?>	
		</fieldset>
		
		<div class="btn-toolbar d-flex justify-content-center mt-4 mb2">
			<button type="button" class="btn sppb-btn-3d btn-success" onclick="Joomla.submitbutton('article.save')">
				<span class="fas fa-check" aria-hidden="true"></span> <?php echo Text::_('JSAVE') ?>
			</button>
			
			<?php if ($this->showSaveAsCopy) : ?>
				<button type="button" class="btn sppb-btn-3d btn-primary ms-2" data-submit-task="article.save2copy">
					<span class="icon-copy" aria-hidden="true"></span>
					<?php echo Text::_('JSAVEASCOPY'); ?>
				</button>
			<?php endif; ?>
			
			<button type="button" class="btn sppb-btn-3d btn-danger ms-2" onclick="Joomla.submitbutton('article.cancel')">
				<span class="fas fa-times" aria-hidden="true"></span> <?php echo Text::_('JCANCEL') ?>
			</button>
			<?php if ($params->get('save_history', 0) && $this->item->id) : ?>
				<div class="ms-2">
					<?php $contenthistory = str_replace( 'btn', 'btn sppb-btn-3d btn-secondary', $this->form->getInput('contenthistory') );
					echo ( str_replace('icon-code-branch', 'fas fa-boxes', $contenthistory) ); ?>
				</div>
			<?php endif; ?>
	
		</div>
		
	</form>
</div>		