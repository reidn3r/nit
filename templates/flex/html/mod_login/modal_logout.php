<?php
/**
 * Flex @package Helix Ultimate Framework
 * Template Name - Flex
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
*/

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Factory;

HTMLHelper::_('behavior.keepalive');
?>
<!-- <span class="top-divider"></span> -->
<div class="ap-modal-login sp-mod-login">
	<div class="ap-my-account-menu dropdown">
		<ul class="ap-my-account">
			<li>
				<button class="border-0 centered dropdown-button ps-1" type="button" id="dropdownMenuButton_<?php echo $module->id; ?>" data-bs-toggle="dropdown" aria-expanded="false" data-toggle="dropdown" aria-haspopup="true">
				  <div class="ap-signin logged-in">
					<div class="signin-img-wrap">
                        <i class="pe pe-7s-user"></i>	
					</div>
					<div class="info-wrap">
						<span class="info-text">
                          <?php if ($params->get('greeting')) : ?>
                            <?php if ($params->get('name') == 0) : ?>
                                <?php echo Text::_('FLEX_LOGIN_HI'); ?>
                                <?php echo htmlspecialchars($user->get('name')); ?>
                            <?php else : ?>
                                <?php echo Text::_('FLEX_LOGIN_HI'); ?>
                                <?php echo htmlspecialchars($user->get('username')); ?>
                            <?php endif; ?>
							<i class="pe pe-7s-angle-down pe-lg pe-va"></i>
                          <?php endif; ?>
						</span>
					 </div>
				   </div>
                </button>
                <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="dropdownMenuButton_<?php echo $module->id; ?>">	
                <?php echo Factory::getDocument()->getBuffer('modules', 'myaccount', array('style' => 'none')); ?>
                </div>
			</li>
		</ul>
	</div>
</div>
