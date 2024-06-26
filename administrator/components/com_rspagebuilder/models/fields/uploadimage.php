<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('JPATH_PLATFORM') or die;

class JFormFieldUploadimage extends JFormField {
	protected $type					= 'Uploadimage';
	protected static $initialized	= false;
	
	protected function getInput() {
		$script		= '';
		$html		= '';
		$src		= '';
		$doc		= JFactory::getDocument();
		$jversion	= RSPageBuilderHelper::getJoomlaVersion();
		
		if (!self::$initialized) {
			RSPageBuilderHelper::loadAsset('component', 'fields/uploadimage-j' . $jversion . '.css');
			RSPageBuilderHelper::loadAsset('component', 'fields/uploadimage.js');
			
			self::$initialized = true;
		}
		
		// Initialize attributes
		if (!empty($this->class)) {
			$this->class = ' ' . $this->class;
		}
		if (!empty($this->default)) {
			$src = ' src="../' . $this->default . '"';
		}
		
		// Build field HTML
		$html .= '<div class="media">';
		$html .= '<div class="media-preview no-height">';
		$html .= '<div class="image-preview">';
		$html .= '<img'. $src .' alt="">';
		$html .= '<a class="remove-media" href="javascript:void(0)"><i class="icon-remove"></i></a>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '<input type="hidden" name="' . $this->name . '" class="input-media' . $this->class . '" value="' . $this->default . '">';
		$html .= '<a class="modal btn btn-primary" title="' . JText::_('COM_RSPAGEBUILDER_BROWSE') . '" rel="{handler: \'iframe\'}">' . JText::_('COM_RSPAGEBUILDER_BROWSE') . '</a>';
		$html .= '</div>';
		
		return $html;
	}
}