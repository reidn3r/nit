<?php
/**
 * Flex @package Helix Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormField;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

class JFormFieldApslide extends FormField {
	protected $type = 'Apslide';

        protected function getInput() {
			
		$doc = Factory::getDocument();
		$plg_path = Uri::root(true) . '/plugins/system/helix3';
		$doc->addScript($plg_path . '/assets/js/simple-slider.min.js');
		$doc->addStyleSheet($plg_path . '/assets/css/simple-slider.css');
		
		$class = $this->element['class'];
		$value = intval(htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8'));
		//$value = (string) $option['value'];
		$fieldID = str_replace(array('jform[params]','[',']'), '', $this->name);
		
		$scripts = '	
		jQuery(document).ready(function() {
			 // Slide options
			 jQuery("#'.$fieldID.'").each(function(){ 
				 jQuery("#'.$fieldID.'").on("slider:ready slider:changed", function (event, data) { 
					 jQuery(".output_'.$fieldID.'").html(data.value.toFixed(0));		 
				 });
			  });
		});
		';
		Factory::getDocument()->addScriptDeclaration($scripts);	
			
			$data_slider_range  = ((string) $this->element['data-slider-range'] != NULL) ? ' data-slider-range="'.$this->element['data-slider-range'].'" data-slider-highlight="true"' : '';

			$data_slider_range_steps  = ((string) $this->element['data-slider-range'] != NULL) ? ' data-slider-step="'.$this->element['data-slider-step'].'"' : '';
			
			$append = Text::_($this->element['append']);

            $input = '
			<div class="slide_wrap '.$class.'">
			<span class="slider input-group-addon mb-1 mr-sm-2">
			<input type="text" name="'.$this->name.'" id="'.$fieldID.'"'
			. ' data-slider="true" value="'.$value.'"'.$data_slider_range.$data_slider_range_steps.
			' /></span>
			<div class="info mx-3"><span class="output_'.$fieldID.'">'.$value.'</span> '.$append.'</div>
			</div><div class="clearfix"></div>
			';
            return $input;
	
	}
}
