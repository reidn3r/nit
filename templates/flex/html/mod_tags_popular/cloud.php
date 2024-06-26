<?php
/**
 * Flex @package Helix Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\Component\Tags\Site\Helper\RouteHelper;

if (JVERSION < 4) {
	// Joomla 3...
	JLoader::register('TagsHelperRoute', JPATH_BASE . '/components/com_tags/helpers/route.php');
} 

$moduleclass_sfx = '';
?>
<div class="tagspopular<?php echo $moduleclass_sfx; ?> tagscloud<?php echo $moduleclass_sfx; ?>">
<?php
if (!count($list)) : ?>
	<div class="alert alert-warning"><?php echo Text::_('MOD_TAGS_POPULAR_NO_ITEMS_FOUND'); ?></div>
<?php else :
	foreach ($list as $item) :
		if (JVERSION < 4) {
			// Joomla 3...
			$link = Route::_(TagsHelperRoute::getTagRoute($item->tag_id . ':' . $item->alias));
		} else {
			// Joomla 4...
			$link = Route::_(RouteHelper::getTagRoute($item->tag_id . ':' . $item->alias));
		}
		?><a class="tag-name" href="<?php echo $link; ?>">
			<?php echo htmlspecialchars($item->title, ENT_COMPAT, 'UTF-8'); ?>
			<?php if ($display_count) : ?>
				<span><?php echo $item->count; ?></span>
			<?php endif; ?>
		</a>	
	<?php endforeach; ?>
<?php endif; ?>
</div>
