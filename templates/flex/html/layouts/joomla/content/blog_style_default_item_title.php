<?php
/**
 * Flex @package Helix Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\Component\Content\Site\Helper\RouteHelper;


if (JVERSION < 4) {
	$link = Route::_(ContentHelperRoute::getArticleRoute($displayData->slug, $displayData->catid, $displayData->language));
} else {
	$link = Route::_(RouteHelper::getArticleRoute($displayData->slug, $displayData->catid, $displayData->language));
}

// Create a shortcut for params.
$params  = $displayData->params;
$canEdit = $displayData->params->get('access-edit');

$currentDate = Factory::getDate()->format('Y-m-d H:i:s');
?>
<?php if ($params->get('show_title') || $displayData->state == 0 || ($params->get('show_author') && !empty($displayData->author ))) : ?>
		<?php if ($params->get('show_title')) : ?>
			<h2 itemprop="name">
				<?php if ($params->get('link_titles') && ($params->get('access-view') || $params->get('show_noauth', '0') == '1')) : ?>
					<a href="<?php echo $link; ?>" itemprop="url">
						<?php echo $this->escape($displayData->title); ?>
					</a>
				<?php else : ?>
					<?php echo $this->escape($displayData->title); ?>
				<?php endif; ?>
			</h2>
		<?php endif; ?>

		<?php if (JVERSION < 4) { ?>

			<?php if ($displayData->state == 0) : ?>
					<span class="label label-warning"><?php echo Text::_('JUNPUBLISHED'); ?></span>
				<?php endif; ?>
				<?php if (strtotime($displayData->publish_up) > strtotime(Factory::getDate())) : ?>
					<span class="label label-warning"><?php echo Text::_('JNOTPUBLISHEDYET'); ?></span>
				<?php endif; ?>
				<?php if ((strtotime($displayData->publish_down) < strtotime(Factory::getDate())) && $displayData->publish_down != Factory::getDbo()->getNullDate()) : ?>
					<span class="label label-warning"><?php echo Text::_('JEXPIRED'); ?></span>
			<?php endif; ?>
		<?php } else { ?>

			<?php if ($displayData->state == 0) : ?>
				<span class="badge bg-warning"><?php echo Text::_('JUNPUBLISHED'); ?></span>
			<?php endif; ?>
			<?php if ($displayData->publish_up > $currentDate) : ?>
				<span class="badge bg-warning"><?php echo Text::_('JNOTPUBLISHEDYET'); ?></span>
			<?php endif; ?>
			<?php if ($displayData->publish_down !== null && $displayData->publish_down < $currentDate) : ?>
				<span class="badge bg-warning"><?php echo Text::_('JEXPIRED'); ?></span>
			<?php endif; ?>
		<?php } ?>

<?php endif; ?>
