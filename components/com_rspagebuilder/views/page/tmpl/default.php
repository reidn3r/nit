<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');
?>

<div id="rspbld" class="rspbld-page<?php echo $this->pageclass_sfx; ?>">
	<?php if ($this->show_page_heading) { ?>
	<div class="page-header">
		<h1 itemprop="name">
			<?php
			if ($this->page_heading) {
				echo $this->escape($this->page_heading);
			} else {
				echo $this->page->title;
			}
			?>
		</h1>
	</div>
	<?php } ?>
	<div class="page-content">
		<?php echo ElementParser::viewPage(json_decode($this->page->content), $this->page->bootstrap_version, $this->page->full_width, $this->page->animate, (int) $this->page->content_plugins); ?>
	</div>
</div>