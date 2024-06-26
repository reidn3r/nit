<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

class JFormFieldModal_Page extends JFormField
{
	
	protected $type = 'Modal_Page';
	
	protected function getInput() {
		require_once(JPATH_ADMINISTRATOR . '/components/com_rspagebuilder/helpers/rspagebuilder.php');
		
		$allowClear = ((string) $this->element['clear'] != 'false') ? true : false;
		$jversion	= RSPageBuilderHelper::getJoomlaVersion();

		// Load language
		JFactory::getLanguage()->load('com_rspagebuilder', JPATH_ADMINISTRATOR);

		// Build the script.
		$script = array();

		// Select button script
		$script[] = '	function jSelectPage_' . $this->id . '(id, title, catid, object) {';
		$script[] = '		document.getElementById("' . $this->id . '_id").value = id;';
		$script[] = '		document.getElementById("' . $this->id . '_name").value = title;';

		if ($allowClear) {
			$script[] = '		document.getElementById("' . $this->id . '_clear").removeClass("hidden");';
		}

		if ($jversion == 3) {
			$script[] = '		jQuery("#modalPage' . $this->id . '").modal("hide");';
		}

		if ($this->required) {
			$script[] = '		document.formvalidator.validate(document.getElementById("' . $this->id . '_id"));';
			$script[] = '		document.formvalidator.validate(document.getElementById("' . $this->id . '_name"));';
		}

		$script[] = '	}';

		// Clear button script
		static $scriptClear;

		if ($allowClear && !$scriptClear) {
			$scriptClear = true;

			$script[] = '	function jClearPage(id) {';
			$script[] = '		document.getElementById(id + "_id").value = "";';
			$script[] = '		document.getElementById(id + "_name").value = "' .
				htmlspecialchars(JText::_('COM_RSPAGEBUILDER_SELECT_PAGE', true), ENT_COMPAT, 'UTF-8') . '";';
			$script[] = '		document.getElementById(id + "_clear").addClass("hidden");';
			$script[] = '		if (document.getElementById(id + "_edit")) {';
			$script[] = '			document.getElementById(id + "_edit").addClass("hidden");';
			$script[] = '		}';
			$script[] = '		return false;';
			$script[] = '	}';
		}

		// Add the script to the document head.
		JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));

		// Setup variables for display.
		$html = array();
		$link = 'index.php?option=com_rspagebuilder&amp;view=pages&amp;layout=modal&amp;tmpl=component&amp;function=jSelectPage_' . $this->id;

		if (isset($this->element['language'])) {
			$link .= '&amp;forcedLanguage=' . $this->element['language'];
		}

		if ((int) $this->value > 0) {
			$db    = JFactory::getDbo();
			$query = $db->getQuery(true)
				->select($db->qn('title'))
				->from($db->qn('#__rspagebuilder'))
				->where($db->qn('id') . ' = ' . (int) $this->value);
			$db->setQuery($query);

			try {
				$title = $db->loadResult();
			}
			catch (RuntimeException $e) {
				throw new \Exception($e->getMessage(), 500);
			}
		}

		if (empty($title)) {
			$title = JText::_('COM_RSPAGEBUILDER_SELECT_PAGE');
		}
		$title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');

		// The active page id field.
		if (0 == (int) $this->value) {
			$value = '';
		} else {
			$value = (int) $this->value;
		}

		$url = $link . '&amp;' . JSession::getFormToken() . '=1';

		$group_class		= ($jversion >= 4) ? 'input-group' : 'input-append';
		$input_class		= ($jversion >= 4) ? 'form-control' : 'input-medium';
		$button_class		= ($jversion >= 4) ? 'btn btn-primary' : 'btn';
		$close_button_class	= ($jversion >= 4) ? 'btn btn-secondary' : 'btn';
		
		// The current page display field.
		$html[] = '<span class="' . $group_class . '">';
		$html[] = '<input type="text" class="' . $input_class . '" id="' . $this->id . '_name" value="' . $title . '" disabled="disabled" size="35" />';
		$html[] = '<a href="#modalPage' . $this->id . '" class="' . $button_class . '" role="button"  ' . RSPageBuilderHelper::getBootstrapElement('data', 0, 'toggle') . '="modal" title="'
			. JHtml::tooltipText('COM_RSPAGEBUILDER_CHANGE_PAGE') . '">'
			. '<span class="icon-file"></span> '
			. JText::_('JSELECT') . '</a>';

		// Clear page button
		if ($allowClear) {
			$html[] = '<button id="' . $this->id . '_clear" class="btn' . ($value ? '' : ' hidden') . '" onclick="return jClearPage(\'' .
				$this->id . '\')"><span class="icon-remove"></span>' . JText::_('JCLEAR') . '</button>';
		}

		$html[] = '</span>';

		// The class='required' for client side validation
		$class = '';

		if ($this->required) {
			$class = ' class="required modal-value"';
		}

		$html[] = '<input type="hidden" id="' . $this->id . '_id"' . $class . ' name="' . $this->name . '" value="' . $value . '" />';

		$html[] = JHtml::_(
			'bootstrap.renderModal',
			'modalPage' . $this->id,
			array(
				'url'			=> $url,
				'title'			=> JText::_('COM_RSPAGEBUILDER_CHANGE_PAGE'),
				'height'		=> '400px',
				'width'			=> '800px',
				'bodyHeight'	=> 70,
				'modalWidth'	=> 80,
				'footer'		=> '<button type="button" class="' . $close_button_class . '" ' . RSPageBuilderHelper::getBootstrapElement('data', 0, 'dismiss') . '="modal" aria-hidden="true">' . JText::_("JLIB_HTML_BEHAVIOR_CLOSE") . '</button>'
			)
		);
		return implode("\n", $html);
	}
	
	protected function getLabel() {
		return str_replace($this->id, $this->id . '_id', parent::getLabel());
	}
}