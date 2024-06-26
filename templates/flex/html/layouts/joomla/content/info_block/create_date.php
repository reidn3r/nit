<?php
/**
 * Flex @package Helix Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
?>
<dd class="create">
	<i class="far fa-calendar-alt"></i>
	<time datetime="<?php echo HTMLHelper::_('date', $displayData['item']->created, 'c'); ?>" itemprop="dateCreated" data-toggle="tooltip" title="<?php echo Text::_('COM_CONTENT_CREATED_DATE'); ?>">
		<?php echo HTMLHelper::_('date', $displayData['item']->created, Text::_('DATE_FORMAT_LC3')); ?>
	</time>
</dd>