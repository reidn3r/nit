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
use Joomla\CMS\Uri\Uri;

if (JVERSION < 4) {
	// Joomla 3...
	HTMLHelper::_('stylesheet', 'mod_languages/template.css', array(), false);
	
	if ($params->get('dropdown', 1) && !$params->get('dropdownimage', 0)) {
		HTMLHelper::_('formbehavior.chosen');
	}
} else {
	// Joomla 4...
	//$wa = $app->getDocument()->getWebAssetManager();
	//$wa->registerAndUseStyle('mod_languages', 'mod_languages/template.css');
}
?>
<div class="mod-languages<?php echo $moduleclass_sfx ?>">
<?php if ($headerText) : ?>
	<div class="pretext mb-2"><p><?php echo $headerText; ?></p></div>
<?php endif; ?>

<?php if ($params->get('dropdown', 1) && !$params->get('dropdownimage', 0)) : ?>
	<?php //HTMLHelper::_('bootstrap.dropdown', '.dropdown-toggle'); ?>
	<div class="btn-group">
		<?php foreach ($list as $language) : ?>
		<?php
			$lbl = '';
			if ($params->get('full_name') === 0)
			{
				$lbl = ' aria-label="' . $language->title_native . '"';
			}
			?>
			<?php if ($language->active) : ?>
				<?php $flag = ''; ?>
				<?php $flag .=  $language->title_native; ?>
				<a href="#" data-toggle="dropdown" data-bs-toggle="dropdown" class="dropdown-toggle<?php echo ($module->position == 'right' || $module->position == 'left' || $module->position == 'offcanvas') ? ' sppb-btn sppb-btn-dark pe-va px-4 py-2' : ''; ?>"><?php echo $flag; ?><i class="pe pe-7s-angle-down p-0"></i></a>
			<?php endif; ?>
		<?php endforeach;?>
		<ul <?php echo ($params->get('full_name') === 0) ? 'style="min-width:120px;" ' : ''; ?>aria-labelledby="language_picker_des_<?php echo $module->id; ?>"<?php echo ($module->position == 'right' || $module->position == 'left' || $module->position == 'offcanvas') ? ' style="background-color:rgba(255,255,255,0.87);"' : ''; ?> class="lang-block px-2 dropdown-menu<?php echo ($module->position == 'right' || $module->position == 'left' || $module->position == 'offcanvas') ? ' py-2' : ''; ?>" dir="<?php echo Factory::getLanguage()->isRtl() ? 'rtl' : 'ltr'; ?>">
		<?php foreach ($list as $language) : ?>
			<?php if ($params->get('show_active', 0) || !$language->active) : ?>
				<li class="p-0 m-0 <?php echo $language->active ? 'lang-active' : 'no-flag'; ?>">
					<a<?php echo $lbl; ?> class="px-2 m-0" aria-current="true" <?php echo $lbl; ?> href="<?php echo htmlspecialchars_decode(htmlspecialchars($language->link, ENT_QUOTES, 'UTF-8'), ENT_NOQUOTES); ?>">
						<span class="lang p-0 m-0"><?php echo $params->get('full_name', 1) ? $language->title_native : strtoupper($language->sef); ?></span>
					</a>
				</li>
			<?php endif; ?>
		<?php endforeach; ?>
		</ul>
	</div>
<?php elseif ($params->get('dropdown', 1) && $params->get('dropdownimage', 0)) : ?>
	<?php //HTMLHelper::_('bootstrap.dropdown', '.dropdown-toggle'); ?>
	<div class="btn-group">
		<?php foreach ($list as $language) : ?>
		<?php
			$lbl = '';
			if ((($params->get('full_name') === 0) && ($params->get('image') === 0)) || (!$language->image))
			{
				$lbl = ' aria-label="' . $language->title_native . '"';
			}
			?>
			<?php if ($language->active) : ?>
				<?php $flag = ''; ?>
				<?php $flag .= HTMLHelper::_('image', 'mod_languages/' . $language->image . '.gif', $language->title_native, array('title' => $language->title_native), true); ?>
				<?php $flag .=  $language->title_native; ?>
				<a<?php echo $lbl; ?> href="#" data-toggle="dropdown" data-bs-toggle="dropdown" class="dropdown-toggle<?php echo ($module->position == 'right' || $module->position == 'left' || $module->position == 'offcanvas') ? ' sppb-btn sppb-btn-dark pe-va px-4 py-2' : ''; ?>"><?php echo $flag; ?><i class="pe pe-7s-angle-down p-0"></i></a>
			<?php endif; ?>
		<?php endforeach;?>
		<ul <?php echo ($params->get('full_name') === 0) ? 'style="min-width:120px;" ' : ''; ?>aria-labelledby="language_picker_des_<?php echo $module->id; ?>"<?php echo ($module->position == 'right' || $module->position == 'left' || $module->position == 'offcanvas') ? ' style="background-color:rgba(255,255,255,0.87);"' : ''; ?> class="lang-block px-2 dropdown-menu<?php echo ($module->position == 'right' || $module->position == 'left' || $module->position == 'offcanvas') ? ' py-2' : ''; ?>" dir="<?php echo Factory::getLanguage()->isRtl() ? 'rtl' : 'ltr'; ?>">
		<?php foreach ($list as $language) : ?>
			<?php if ($params->get('show_active', 0) || !$language->active) : ?>
				<li class="p-0 m-0 <?php echo $language->active ? 'lang-active' : ''; ?><?php echo $module->id; ?><?php echo ($module->position == 'right' || $module->position == 'left' || $module->position == 'offcanvas') ? ' bg-body' : ''; ?>">
					<a<?php echo $lbl; ?> class="px-2 py-1 m-0" aria-current="true" href="<?php echo htmlspecialchars_decode(htmlspecialchars($language->link, ENT_QUOTES, 'UTF-8'), ENT_NOQUOTES); ?>">
						<?php if ($params->get('dropdownimage', 1) && ($language->image)) :
							echo '<span class="flag-img p-0 m-0">'. HTMLHelper::_('image', 'mod_languages/' . $language->image . '.gif', $params->get('full_name') ? '' : $language->title_native, null, true) .'</span>';
						endif; ?><span class="lang p-0 m-0"><?php echo $params->get('full_name', 1) ? $language->title_native : strtoupper($language->sef); ?></span>
					</a>
				</li>
			<?php endif; ?>
		<?php endforeach; ?>
		</ul>
	</div>
<?php else : ?>
	<ul<?php echo ($module->position == 'right' || $module->position == 'left' || $module->position == 'offcanvas') ? ' style="border:none;margin:0;padding:0;"' : '';?> class="<?php echo $params->get('inline', 1) ? 'lang-inline m-0' : 'lang-block vertical m-0';?>">
	<?php foreach ($list as $language) : ?>
		<?php
			$lbl = '';
			if ((($params->get('full_name') === 0) && ($params->get('image') === 0)) || (!$language->image))
			{
				$lbl = ' aria-label="' . $language->title_native . '"';
			}
			?>
		<?php if ($params->get('show_active', 0) || !$language->active):?>
			<li class="<?php echo $language->active ? 'lang-active py-1 px-2 ' : '';?>mx-0" dir="<?php echo Factory::getLanguage()->isRtl() ? 'rtl' : 'ltr'; ?>"<?php echo ($module->position == 'right' || $module->position == 'left' || $module->position == 'offcanvas') ? ' style="background-color:transparent;"' : '';?>>
				<a<?php echo $lbl; ?><?php echo ($module->position == 'right' || $module->position == 'left' || $module->position == 'offcanvas') ? ' class="btn sppb-btn-default d-flex justify-content-start align-items-start clearfix p-2 m-0"' : ''; ?> href="<?php echo $language->link;?>">
				<?php if ($params->get('image', 1)):?>
					<?php if ($params->get('inline') == 0) { ?>
						<?php echo HTMLHelper::_('image', 'mod_languages/' . $language->image . '.gif', $language->title_native, array('title' => $language->title_native), true);?>
						<span class="lang px-2"><?php echo ($params->get('full_name', 1)) ? $language->title_native : '' ;?></span>
						<?php echo $language->active ? '<i class="fas fa-check"></i>' : '';?>
					<?php } else {?>
					<img <?php echo ($module->position == 'right' || $module->position == 'left' || $module->position == 'offcanvas') ? ' class="p-2 mx-0"' : '';?> src="<?php echo 'media/mod_languages/images/' . $language->image . '.gif' ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo $language->title_native; ?>" alt="<?php echo $language->title_native; ?>" />
					 <?php } ?>
				<?php else : ?>
					
					<?php if($module->position == 'right' || $module->position == 'left' || $module->position == 'offcanvas') { ?>
						<span class="py-2 px-3 btn sppb-btn-default border-0">
					<?php } else { ?>
						<span class="lang px-2">
					<?php } ?>
							
						<?php echo ($params->get('full_name', 1)) ? $language->title_native : $language->image; ?>
					</span>
				<?php endif; ?>
				</a>
			</li>
		<?php endif;?>
	<?php endforeach;?>
	</ul>
<?php endif; ?>

<?php if ($footerText) : ?>
	<div class="posttext mt-2"><p><?php echo $footerText; ?></p></div>
<?php endif; ?>
</div>
