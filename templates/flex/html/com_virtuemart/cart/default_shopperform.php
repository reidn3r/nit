<?php
/**
 * Flex @package Helix Ultimate Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

vmJsApi::chosenDropDowns();
?>
<hr style="margin:20px auto 30px;" />
<h4 style="margin:20px 0 10px;"><?php echo vmText::_ ('COM_VIRTUEMART_CART_CHANGE_SHOPPER'); ?></h4>
<form action="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=cart'); ?>" method="post" class="form-inline" style="margin:0;">

	
		<!--<div class="form-group">-->
		<div class="row g-3 mb-3 align-items-center">
			<div class="col-3"><input class="form-control" type="text" name="usersearch" size="20" maxlength="50" placeholder="<?php echo vmText::_('COM_VIRTUEMART_SEARCH'); ?>..."></div>
			<div class="col-6"><input class="btn btn-primary px-3" type="submit" name="searchShopper" title="<?php echo vmText::_('COM_VIRTUEMART_SEARCH'); ?>" value="<?php echo vmText::_('COM_VIRTUEMART_SEARCH'); ?>" class="button" /></div>
		</div>
	
	
		<!--<div class="form-group" style="margin:22px 0 0;">-->
		<div class="row g-3 align-items-center">
			<?php 
			$currentUser = $this->cart->user->virtuemart_user_id;
			echo '<div class="col-auto m-0">'.JHtml::_('Select.genericlist', $this->userList, 'userID', 'class="vm-chzn-select" style="width:170px;"', 'id', 'displayedName', $currentUser,'userIDcart').'</div>';
			?>
			<div class="col-auto">
				<input type="submit" name="changeShopper" title="<?php echo vmText::_('COM_VIRTUEMART_SAVE'); ?>" value="<?php echo vmText::_('COM_VIRTUEMART_SAVE'); ?>" class="px-4 mt-3 mx-0 btn btn-primary" />
			</div>
			<input type="hidden" name="view" value="cart"/>
			<input type="hidden" name="task" value="changeShopper"/>
		</div>
		<div class="row clearfix">
			<?php if($this->adminID && $currentUser != $this->adminID) { ?>
				<hr /><b class="centered"><?php echo vmText::_('COM_VIRTUEMART_CART_ACTIVE_ADMIN') .' '.JFactory::getUser($this->adminID)->name; ?></b><hr />
			<?php } ?>
			<?php echo JHtml::_( 'form.token' ); ?>
		</div>
	
</form>
<div class="clear w-100"></div>	<hr />
<h4 style="margin:30px 0 10px;"><?php echo vmText::_ ('COM_VIRTUEMART_CART_CHANGE_SHOPPERGROUP'); ?></h4>

<form action="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=cart'); ?>" method="post" class="form-inline m-0">
	<div class="form-group row g-3 align-items-center">
		<div class="col-auto mt-3"><?php 
		if ($this->shopperGroupList) {
			echo $this->shopperGroupList;
		}
		?></div>
		 <div class="col-auto"><input type="submit" name="changeShopperGroup" title="<?php echo vmText::_('COM_VIRTUEMART_SAVE'); ?>" value="<?php echo vmText::_('COM_VIRTUEMART_SAVE'); ?>" class="px-4 py-1 btn btn-primary" /></div>
		<input type="hidden" name="view" value="cart"/>
		<input type="hidden" name="task" value="changeShopperGroup"/>
		<?php echo JHtml::_( 'form.token' ); ?>

		<?php if (JFactory::getSession()->get('tempShopperGroups', FALSE, 'vm')) { ?>
			<div class="col-auto">
				<input type="reset" title="<?php echo vmText::_('COM_VIRTUEMART_RESET'); ?>" value="<?php echo vmText::_('COM_VIRTUEMART_RESET'); ?>" class="px-4 btn btn-dark" onclick="window.location.href='<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=cart&task=resetShopperGroup'); ?>'"/>
			</div>
		<?php } ?>
	</div>
</form>
<hr style="margin:30px auto;" />
