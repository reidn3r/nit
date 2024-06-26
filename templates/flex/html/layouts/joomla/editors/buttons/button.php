<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Uri\Uri;

$button = $displayData;

?>

<?php 
	if ($button->get('name')) :
		$class   = 'btn btn-secondary';
		$class  .= ($button->get('class')) ? ' ' . $button->get('class') : null;
		$class  .= ($button->get('modal')) ? ' modal-button' : null;
		$href    = '#' . strtolower($button->get('name')) . '_modal';
		$link    = ($button->get('link')) ? Uri::base() . $button->get('link') : null;
		$onclick = ($button->get('onclick')) ? ' onclick="' . $button->get('onclick') . '"' : '';
		$title   = ($button->get('title')) ? $button->get('title') : $button->get('text');
		$icon    = ($button->get('icon')) ? $button->get('icon') : $button->get('name');
	?>
	<button type="button" data-bs-target="<?php echo $href; ?>" class="xtd-button btn sppb-btn-default px-3 mb-2 mb-xl-0  <?php echo $class; ?>" <?php echo $button->get('modal') ? 'data-bs-toggle="modal"' : '' ?> title="<?php echo $title; ?>" <?php echo $onclick; ?>>
		<span class="icon-<?php echo $icon; ?>" aria-hidden="true"></span>
		<?php echo $button->get('text'); ?>
	</button>
<?php endif;
