<?php
/**
 * Flex @package Helix Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
defined('_JEXEC') or die;

use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Text;

if (JVERSION < 4) {
	// Joomla 3...
	JLoader::register('TagsHelperRoute', JPATH_BASE . '/components/com_tags/helpers/route.php');
} 
?>
<div class="tagssimilar<?php echo $moduleclass_sfx; ?>">
<?php if ($list) : ?>
	<ul>
	<?php foreach ($list as $i => $item) : ?>
		<li>
			<?php if (JVERSION < 4) {
				// Joomla 3...
				$item->route = new JHelperRoute; ?>
				<a href="<?php echo Route::_(TagsHelperRoute::getItemRoute($item->content_item_id, $item->core_alias, $item->core_catid, $item->core_language, $item->type_alias, $item->router)); ?>">
					<?php if (!empty($item->core_title)) :
						echo htmlspecialchars($item->core_title);
					endif; ?>
				</a>
			<?php } else {
				// Joomla 4...
				if (($item->type_alias === 'com_users.category') || ($item->type_alias === 'com_banners.category')) : ?>
				<?php if (!empty($item->core_title)) : ?>
					<?php echo htmlspecialchars($item->core_title, ENT_COMPAT, 'UTF-8'); ?>
				<?php endif; ?>
				<?php else : ?>
					<a href="<?php echo Route::_($item->link); ?>">
						<?php if (!empty($item->core_title)) : ?>
							<?php echo htmlspecialchars($item->core_title, ENT_COMPAT, 'UTF-8'); ?>
						<?php endif; ?>
					</a>
				<?php endif; ?>
			<?php } ?>
		</li>
	<?php endforeach; ?>
	</ul>
<?php else : ?>
	<span><?php echo Text::_('MOD_TAGS_SIMILAR_NO_MATCHING_TAGS'); ?></span>
<?php endif; ?>
</div>
