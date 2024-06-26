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
//use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

//JFormHelper::loadFieldClass('color');

class JFormFieldColorpicker extends FormField {

  protected $type = 'Colorpicker';


  protected function getInput() {
	
    $class = ' ' . $this->class;
	
	$default_hint = $this->element['default'] != '' ? $default_hint = $this->element['default'] : $default_hint = 'transparent';
 
	$value = strtolower($this->value);

    $doc = Factory::getDocument();
	$plg_path = Uri::root(true) . '/plugins/system/helix3';
	$doc->addScript($plg_path . '/assets/js/bootstrap-colorpicker.js');
	$doc->addStyleSheet($plg_path . '/assets/css/bootstrap-colorpicker.css');
	
	Factory::getDocument()->addScriptDeclaration('
	  jQuery(function () {
		 jQuery("#' . $this->id . '").colorpicker({
			customClass: \'colorpicker-flex\',
			sliders: {
				saturation: {
					maxLeft: 137,
					maxTop: 137
				},
				hue: {
					maxTop: 137
				},
				alpha: {
					maxTop: 137
				}
			 }	
		  });  
	  });
	');

    return '
	<div id="' . $this->id . '" class="colorpicker-component">
		<span class="input-group-addon"><span class="transparent"></span><i></i>
			<input type="text" name="' . $this->name . '"' . ' class="form-control mb-1 mr-sm-1'.$class.'" value="'.$value.'" placeholder="'.$default_hint.'" />
		</span>
	</div>
	<div class="clearfix"></div>
	';
  }
}