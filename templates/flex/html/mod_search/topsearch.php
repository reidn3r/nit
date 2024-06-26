<?php
/**
 * Flex @package SP Page Builder
 * Template Name - Flex
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
*/
// no direct access
defined('_JEXEC') or die;

use Joomla\CMS\Router\Route;
?>
<div style="display:inline-block;" class="top-search-wrapper">

	<div class="icon-top-wrapper">
        <i class="pe pe-7s-search search-open-icon" aria-hidden="true"></i>
		<i class="pe pe-7s-close search-close-icon" aria-hidden="true"></i>
	</div>

	<div class="top-search-input-wrap" id="top-search-input-wrap">
		<div class="top-search-wrap">
			<div class="searchwrapper">
				<form action="<?php echo Route::_('index.php');?>" method="post">
					<div class="search<?php echo $moduleclass_sfx ?>">
						<?php
							$output = '<div class="top-search-wrapper"><div class="sp_search_input"><input name="searchword" maxlength="'.$maxlength.'"  class="mod-search-searchword inputbox'.$moduleclass_sfx.'" type="text" size="'.$width.'" value="'.$text.'"  onblur="if (this.value==\'\') this.value=\''.$text.'\';" onfocus="if (this.value==\''.$text.'\') this.value=\'\';" /></div></div>';

							if ($button) :
								if ($imagebutton) :
									$button = '<input type="image" value="'.$button_text.'" class="button'.$moduleclass_sfx.'" src="'.$img.'" onclick="this.form.searchword.focus();"/>';
								else :
									$button = '<input type="submit" value="'.$button_text.'" class="button'.$moduleclass_sfx.'" onclick="this.form.searchword.focus();"/>';
								endif;
							endif;

							switch ($button_pos) :
								case 'top' :
									$button = $button.'<br />';
									$output = $button;
									break;

								case 'bottom' :
									$button = '<br />'.$button;
									$output = $output;
									break;

								case 'right' :
									$output = $output;
									break;

								case 'left' :
								default :
									$output = $button;
									break;
							endswitch;

							echo $output;
						?>
						<input type="hidden" name="task" value="search" />
						<input type="hidden" name="option" value="com_search" />
						<input type="hidden" name="Itemid" value="<?php echo $mitemid; ?>" />
					</div>
				</form>
			</div>
		</div>
	</div> 
</div>	