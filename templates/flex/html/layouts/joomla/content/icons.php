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
use Joomla\CMS\Language\Text;

$canEdit   = $displayData['params']->get('access-edit');
$articleId = $displayData['item']->id;

if (JVERSION < 4) { 
	// Joomla 3... 
	//JHtml::_('bootstrap.framework');
	?>
	<div class="icons">
		<?php if (empty($displayData['print'])) : ?>
			<?php if ($canEdit || $displayData['params']->get('show_print_icon') || $displayData['params']->get('show_email_icon')) : ?>
				<div class="btn-group pull-right float-end">
					<button class="btn dropdown-toggle" type="button" id="dropdownMenuButton-<?php echo $articleId; ?>" aria-label="<?php echo Text::_('JUSER_TOOLS'); ?>" data-toggle="dropdown" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
					</button>
					<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-<?php echo $articleId; ?>">
						<?php if ($displayData['params']->get('show_print_icon')) : ?>
							<li class="print-icon dropdown-item"><?php echo HTMLHelper::_('icon.print_popup', $displayData['item'], $displayData['params']); ?> </li>
						<?php endif; ?>
						<?php if ($displayData['params']->get('show_email_icon')) : ?>
							<li class="email-icon dropdown-item"><?php echo HTMLHelper::_('icon.email', $displayData['item'], $displayData['params']); ?> </li>
						<?php endif; ?>
						<?php if ($canEdit) : ?>
							<li class="edit-icon dropdown-item"><?php echo HTMLHelper::_('icon.edit', $displayData['item'], $displayData['params']); ?> </li>
						<?php endif; ?>
					</ul>
				</div>
			<?php endif; ?>
		<?php else : ?>
			<div class="pull-right float-end">
				<?php echo HTMLHelper::_('icon.print_screen', $displayData['item'], $displayData['params']); ?>
			</div>
		<?php endif; ?>
	</div>
<?php } else {  
	// Joomla 4...
	if ($canEdit) : ?>
	<div class="icons">
		<div class="float-end">
			<?php echo HTMLHelper::_('icon.edit', $displayData['item'], $displayData['params']); ?>
		</div>
	</div>
	<?php endif; ?>
<?php } ?>
		


