<?php
/**
 * Flex @package Helix Ultimate Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

class Helix3FeatureMenu {

	private $helix3;

	public function __construct($helix3){
		$this->helix3 = $helix3;
		$this->position = 'menu';
	}

	public function renderFeature() {

		$menu_type = $this->helix3->getParam('menu_type');
		$this->helix3->getParam('offcanvas_icon') != '2' ? $offcanvas_icon_class = 'fas fa-bars' : $offcanvas_icon_class = 'pe pe-7s-menu';

		ob_start();
		
		if($menu_type == 'mega_offcanvas') { ?>
			<div class="sp-megamenu-wrapper">
				<a id="offcanvas-toggler" href="#" aria-label="<?php echo Text::_('HELIX_MENU'); ?>"><i class="<?php echo $offcanvas_icon_class; ?>" aria-hidden="true" title="<?php echo Text::_('HELIX_MENU'); ?>"></i></a>
				<?php $this->helix3->loadMegaMenu('d-none d-lg-flex'); ?>
			</div>
		<?php } else if ($menu_type == 'mega') { ?>
			<div class="sp-megamenu-wrapper">
				<a id="offcanvas-toggler" class="d-block d-lg-none" href="#" aria-label="<?php echo Text::_('HELIX_MENU'); ?>"><i class="<?php echo $offcanvas_icon_class; ?>" aria-hidden="true" title="<?php echo Text::_('HELIX_MENU'); ?>"></i></a>
				<?php $this->helix3->loadMegaMenu('d-none d-lg-flex'); ?>
			</div>
		<?php } else { ?>
			<div class="sp-megamenu-wrapper">
                <a id="offcanvas-toggler" href="#" aria-label="<?php echo Text::_('HELIX_MENU'); ?>"><i style="font-size:28px;width:80px;" class="<?php echo $offcanvas_icon_class; ?>" aria-hidden="true" title="<?php echo Text::_('HELIX_MENU'); ?>"></i></a>
            </div>
		<?php }

		return ob_get_clean();
	}    
}