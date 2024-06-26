<?php

defined('_JEXEC') or die;

use Joomla\CMS\Router\Route;
//use Joomla\CMS\Factory;
?>
<div class="search<?php echo $moduleclass_sfx ?> flex-search">
	<form action="<?php echo Route::_('index.php');?>" method="post">
		<?php
			$output = '';
			$output .= '<input name="searchword" id="mod-search-searchword-'. $module->id .'" maxlength="' . $maxlength . '"  class="inputbox search-query" type="text" size="' . $width . '" placeholder="' . $text . '" />';
			echo $output;
		?>
		<input type="hidden" name="task" value="search" />
		<input type="hidden" name="option" value="com_search" />
		<input type="hidden" name="Itemid" value="<?php echo $mitemid; ?>" />
	</form>
</div>
