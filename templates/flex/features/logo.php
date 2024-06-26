<?php
/**
 * Flex @package Helix Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Factory;
 
class Helix3FeatureLogo {

	private $helix3;
	public $position;

	public function __construct( $helix3 ){
		$this->helix3 = $helix3;
		$this->position = $this->helix3->getParam('logo_position', 'logo');
		$this->load_pos = $this->helix3->getParam('logo_load_pos');
	}

	public function renderFeature()
	{

		$doc = Factory::getDocument();
		$app = Factory::getApplication();

		$html  = '';
		$custom_logo_class = '';

		if( $this->helix3->getParam('mobile_logo') ) {
			$custom_logo_class = ' d-none d-md-block';
		}
		
		// Hiding Sticky logo from Default and Retina
		$sticky_logo_class = ($this->helix3->getParam('sticky_logo')) ? ' has-sticky-logo' : '';
		
		//$sitename = Factory::getApplication()->get('sitename');
		$sitename = htmlspecialchars($app->get('sitename'), ENT_QUOTES, 'UTF-8');
		$default_logo = Uri::root(true) . '/' . htmlspecialchars((string)$this->helix3->getParam('logo_image'), ENT_QUOTES);
		$retina_logo = Uri::root(true) . '/' . htmlspecialchars((string)$this->helix3->getParam('logo_image_2x'), ENT_QUOTES);
		$mobile_logo = Uri::root(true) . '/' . htmlspecialchars((string)$this->helix3->getParam('mobile_logo'), ENT_QUOTES);
		$sticky_logo = Uri::root(true) . '/' . htmlspecialchars((string)$this->helix3->getParam('sticky_logo'), ENT_QUOTES);
		$logo_text =  htmlspecialchars((string)$this->helix3->getParam('logo_text'), ENT_COMPAT, 'UTF-8');
		
		if( $this->helix3->getParam('logo_type') == 'image' ) {
			if( $this->helix3->getParam('logo_image') ) {
				$html .= '<a class="logo p-0" href="' . Uri::base(true) . '/">';
					$html .= '<img class="sp-default-logo'. $custom_logo_class . $sticky_logo_class .'" src="' . $default_logo . '" '. ($this->helix3->getParam('logo_image_2x') ? 'srcset="' . $retina_logo . ' 2x" ' : '') .'alt="'. $sitename .'">';
				
					/* Sticky Logo */
					if ($this->helix3->getParam('sticky_header') == 1) {
						if ($this->helix3->getParam('sticky_logo')) {
							$html .= '<img class="sp-sticky-logo'. $custom_logo_class .'" src="' . $sticky_logo . '" alt="'. $sitename .'">';
						}
					}
					
					if( $this->helix3->getParam('mobile_logo') ) {
						$html .= '<img class="sp-default-logo d-block d-sm-block d-md-none'. $sticky_logo_class .'" src="' . $mobile_logo . '" alt="'. $sitename .'">';
					}

				$html .= '</a>';
				
			} else {
				$html .= '<a class="logo" href="' . Uri::base(true) . '/">';
					$html .= '<img class="sp-default-logo'. $custom_logo_class .'" src="' . $this->helix3->getTemplateUri() . '/images/presets/' . $this->helix3->Preset() . '/logo.png" alt="'. $sitename .'">';

					if( $this->helix3->getParam('mobile_logo') ) {
						$html .= '<img class="sp-default-logo d-block d-lg-none p-1" src="' . $mobile_logo . '" alt="'. $sitename .'">';
					}
				$html .= '</a>';
			}

		} else {
			if( $this->helix3->getParam('logo_text') ) {
				$html .= '<h1 class="logo"> <a href="' . Uri::base(true) . '/">' . $logo_text . '</a></h1>';
			} else {
				$html .= '<h1 class="logo"> <a href="' . Uri::base(true) . '/">' . $sitename . '</a></h1>';
			}

			if( $this->helix3->getParam('logo_slogan') ) {
				$html .= '<p class="logo-slogan">' . htmlspecialchars($this->helix3->getParam('logo_slogan')) . '</p>';
			}
		}

		return $html;
	}
}
