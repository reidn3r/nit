<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Content.pagenavigation
 *
 * Flex @package Helix Framework
 * Template Name - Flex
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
*/

defined('_JEXEC') or die;

use Joomla\CMS\Factory;

$lang = Factory::getLanguage(); ?>

<nav role="pagination">
    <ul class="cd-pagination no-space animated-buttons custom-icons">
		<?php if ($row->prev) :
			$direction = $lang->isRTL() ? 'right' : 'left'; ?>
            <li class="button btn-previous">
                <a href="<?php echo $row->prev; ?>" rel="prev"><i><?php echo JText::_('JPREV'); ?></i></a>
            </li>
        <?php endif; ?>
        
       <?php if ($row->next) :
			$direction = $lang->isRTL() ? 'left' : 'right'; ?>
            <li class="button btn-next">
                <a href="<?php echo $row->next; ?>" rel="next"><i><?php echo JText::_('JNEXT'); ?></i></a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
