<?php
/**
*
* Layout for the shopping cart and the mail
* shows the chosen adresses of the shopper
* taken from the cart in the session
*
* @package	VirtueMart
* @subpackage Cart
* @author Max Milbers
*
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2014 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
?>
<div style="padding:0 0 40px;margin:0 auto;border:none;" class="billto-shipto row g-3 mb-2">
	<div class="col-12 col-sm-6 mt-0 mobile-centered">
		<h6>
			<i class="fas fa-home"></i> 
			<?php echo Text::_ ('COM_VIRTUEMART_USER_FORM_BILLTO_LBL'); ?></span>
			<?php // Output Bill To Address ?>
		</h6>

		<div class="output-billto">	<?php 
			$cartfieldNames = array();
			foreach( $this->userFieldsCart['fields'] as $fields){
				$cartfieldNames[] = $fields['name'];
			}

			foreach ($this->cart->BTaddress['fields'] as $item) {
				if(in_array($item['name'],$cartfieldNames)) continue;
				if (!empty($item['value'])) {
					if ($item['name'] === 'agreed') {
						$item['value'] = ($item['value'] === 0) ? vmText::_ ('COM_VIRTUEMART_USER_FORM_BILLTO_TOS_NO') : vmText::_ ('COM_VIRTUEMART_USER_FORM_BILLTO_TOS_YES');
					}
					?><!-- span class="titles"><?php echo $item['title'] ?></span -->
			<span class="values vm2<?php echo '-' . $item['name'] ?>"><?php echo $item['value'] ?></span>
			<?php if ($item['name'] != 'title' and $item['name'] != 'first_name' and $item['name'] != 'middle_name' and $item['name'] != 'zip') { ?>
				<br />
			<?php
			}
			}
			} ?>
			<div class="clear"></div>
		</div>

		<?php
		if($this->pointAddress){
			$this->pointAddress = 'required invalid';
		}

		?>
        
		<a class="btn sppb-btn-default centered <?php echo $this->pointAddress ?>" href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=user&task=editaddresscart&addrtype=BT', $this->useXHTML, $this->useSSL) ?>" rel="nofollow">
			<?php echo vmText::_ ('COM_VIRTUEMART_USER_FORM_EDIT_BILLTO_LBL'); ?>
		</a>

		<input type="hidden" name="billto" value="<?php echo $this->cart->lists['billTo']; ?>"/>
	</div>
	<div class="col-12 col-sm-6 mt-5 mt-sm-0 mobile-centered">
		<h6>
			<i class="fas fa-truck"></i> 
			<?php echo Text::_ ('COM_VIRTUEMART_USER_FORM_SHIPTO_LBL'); ?></span>
			<?php // Output Bill To Address ?>
		</h6>
		<div class="output-shipto">
			<?php
			if (!class_exists ('VmHtml')) {
				require(VMPATH_ADMIN . DS . 'helpers' . DS . 'html.php');
			}
			if($this->cart->user->virtuemart_user_id==0){

				echo vmText::_ ('COM_VIRTUEMART_USER_FORM_ST_SAME_AS_BT');
				echo VmHtml::checkbox ('STsameAsBT', $this->cart->STsameAsBT,1,0,'id="STsameAsBTjs" data-dynamic-update=1') . '<br />';
			} else if(!empty($this->cart->lists['shipTo'])){
				echo $this->cart->lists['shipTo'];
			}

			if(empty($this->cart->STsameAsBT) and !empty($this->cart->ST) and !empty($this->cart->STaddress['fields'])){ ?>
				<div id="output-shipto-display">
					<?php
					foreach ($this->cart->STaddress['fields'] as $item) {
						if (!empty($item['value'])) {
							?>
							<!-- <span class="titles"><?php echo $item['title'] ?></span> -->
							<?php
							if ($item['name'] == 'first_name' || $item['name'] == 'middle_name' || $item['name'] == 'zip') {
								?>
								<span class="values<?php echo '-' . $item['name'] ?>"><?php echo $item['value'] ?></span>
							<?php } else { ?>
								<span class="values"><?php echo $item['value'] ?></span>
								<div class="clear"></div>
							<?php
							}
						}
					}
					?>
				</div>
			<?php
			}
			?>
			<div class="clear"></div>
		</div>
		<?php if (!isset($this->cart->lists['current_id'])) {
			$this->cart->lists['current_id'] = 0;

		} ?>
		<a class="btn sppb-btn-default centered" href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=user&task=editaddresscart&addrtype=ST&virtuemart_user_id[]=' . $this->cart->lists['current_id'], $this->useXHTML, $this->useSSL) ?>" rel="nofollow">
			<?php echo vmText::_ ('COM_VIRTUEMART_USER_FORM_ADD_SHIPTO_LBL'); ?>
		</a>

	</div>

	<div class="clear"></div>
</div>