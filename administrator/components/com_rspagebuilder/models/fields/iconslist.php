<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('JPATH_PLATFORM') or die;

JFormHelper::loadFieldClass('list');

class JFormFieldIconslist extends JFormField {
	protected $type = 'Iconslist';
	
	protected function getInput() {
		$html		= '';
		$icons		= $this::getIconsList();
		$jversion	= RSPageBuilderHelper::getJoomlaVersion();
		
		RSPageBuilderHelper::loadAsset('component', 'fields/iconslist-j' . $jversion . '.css');
		RSPageBuilderHelper::loadAsset('component', 'fields/iconslist.js');
		
		// Initialize field class
		!empty($this->class) ? $this->class = ' '.$this->class : $this->class = '';
		
		// Build field HTML
		$html .= '<input type="hidden" name="' . $this->name . '" class="iconslist' . $this->class . '" value="' . $this->default . '">';
		$html .= '<div class="icons-list">';
		$html .= '<span class="selected">';
		if ($this->default) {
			$html .= '<i class="fa fa-' . $this->default . '"></i>';
			$html .= $this->default;
		} else {
			$html .= '<i class="no-icon">' . JText::_('COM_RSPAGEBUILDER_NO_ICON') . '</i>';
		}
		$html .= '</span>';
		$html .= '<div class="icons">';
		$html .= '<input class="search-filter' . (($jversion >= 4) ? ' form-control' : '') . ' pull-right" name="filter" type="text" placeholder="' . JText::_('COM_RSPAGEBUILDER_ICON_SEARCH_ICON') . '">';
		$html .= '<ul class="list pull-left">';
		$html .= '<li';
		
		if ($this->default == '') {
			$html .= ' class="active"';
		}
		$html .= '>';
		$html .= '<i class="no-icon">' . JText::_('COM_RSPAGEBUILDER_NO_ICON') . '</i>';
		$html .= '</li>';
		
		foreach ($icons as $icon) {
			$html .= '<li';
			
			if ($icon == $this->default) {
				$html .= ' class="active"';
			}
			$html .= '>';
			$html .= '<i class="fa fa-' . $icon . '"></i>';
			$html .= '<span>';
			$html .= $icon;
			$html .= '</span>';
			$html .= '</li>';
		}
		$html .= '</ul>';
		$html .= '</div>';
		$html .= '</div>';
		
		return $html;
	}
	
	protected function getIconsList() {
		$fa_content = file_get_contents(JPATH_ROOT . str_replace(JUri::root(true), '', RSPageBuilderHelper::loadAsset('component', 'font-awesome.min.css', true)));
		
		preg_match_all('/.fa-[a-zA-Z0-9-]+::before/', $fa_content, $matches);
		$fa_icons = $matches[0];
		sort($fa_icons);
		
		foreach($fa_icons as $key => $value) {
			$fa_icons[$key] = str_replace(array('.fa-', '::before'), '', $value);
		}
		
		return $fa_icons;
	}
}