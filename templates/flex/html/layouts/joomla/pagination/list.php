<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('JPATH_BASE') or die;

$list = $displayData['list'];

$startDisabled = $list['start']['active'] ? '' : ' disabled'; 
$prevDisabled  = $list['previous']['active'] ? '' : ' disabled'; 
$nextDisabled  = $list['next']['active'] ? '' : ' disabled'; 
$endDisabled   = $list['end']['active'] ? '' : ' disabled'; 

$cls = "";
$buttoncls = "";
$buttoniconstart = "";
$buttoniconend = "";
?>
<nav role="pagination">
<ul class="cd-pagination no-space animated-buttons custom-icons ms-0 mb-4">
<li class="button btn-previous<?php echo $startDisabled; ?>"><?php echo $list['start']['data']; ?></li>
<li class="prev<?php echo $prevDisabled; ?>"><?php echo $list['previous']['data']; ?></li><?php foreach ($list['pages'] as $page) : ?>
<?php $active = $page['active'] ? '' : 'active '; ?>
<?php echo '<li class="' . $active . 'nmbr-item">' . $page['data'] . '</li>'; ?>
<?php endforeach; ?><li class="next<?php echo $nextDisabled; ?>"><?php echo $list['next']['data']; ?></li>
<li class="button btn-next<?php echo $endDisabled; ?>"><?php echo $list['end']['data']; ?></li>
</ul>
</nav>