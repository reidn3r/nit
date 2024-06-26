<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

$badge		= ($this->bootstrap_version == 5 || $this->bootstrap_version == 4) ? 'badge' : 'label';
$bakground	= ($this->bootstrap_version == 5) ? 'bg' : (($this->bootstrap_version == 4) ? 'badge' : 'label');
?>

<div class="rspbld-pages">
	<?php foreach($this->items as $key=>$page) { ?>
	<div class="rspbld-page-container">
		<div class="<?php echo RSPageBuilderHelper::getGridElement('row', $page->bootstrap_version); ?>">
			<div class="<?php echo RSPageBuilderHelper::getGridElement(4, $page->bootstrap_version); ?> result">
				<h2><?php echo ($key + 1).'. '; ?><a href="<?php echo JRoute::_('index.php?option=com_rspagebuilder&view=page&id='.$page->id); ?>"><?php echo $page->title; ?></a></h2>
			</div>
			<div class="<?php echo RSPageBuilderHelper::getGridElement(8, $page->bootstrap_version); ?> wrapper">
				<div class="details">
					<span class="<?php echo $badge . ' ' . $bakground; ?>-info">
						<span class="fa fa-eye"></span>
						<?php echo JText::_('COM_RSPAGEBUILDER_PAGE_PREVIEW'); ?>
					</span>
					<a class="<?php echo $badge . ' ' . $bakground; ?>-success" href="<?php echo JRoute::_('index.php?option=com_rspagebuilder&view=page&id='.$page->id); ?>">
						<span class="fa fa-share"></span>
						<?php echo $page->title; ?>
					</a>
				</div>
				<div class="preview">
					<?php echo ElementParser::viewPage(json_decode($page->content), $page->bootstrap_version, true, false, (int) $page->content_plugins); ?>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
	<?php if ($this->total > 1) { ?>
	<form action="<?php echo $this->escape(JURI::getInstance()); ?>" method="post" name="adminForm" id="adminForm">
		<div class="pagination">
			<p class="counter pull-right">
				<?php echo $this->pagination->getPagesCounter(); ?>
			</p>
			<?php echo $this->pagination->getPagesLinks(); ?>
		</div>
	</form>
	<?php } ?>
</div>