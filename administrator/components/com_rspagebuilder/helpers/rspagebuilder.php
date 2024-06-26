<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

class RSPageBuilderHelper {
	
	public static function getJoomlaVersion() {
        $jversion   = new JVersion();
        $numbers    = explode('.', $jversion->getShortVersion());

        $jversion	= (int) $numbers[0];

        return $jversion;
	}
	
	public static function getGridElement($element, $bootstrap_version = 0) {
		if ($bootstrap_version == 2 || $bootstrap_version == 3 || $bootstrap_version == 4 || $bootstrap_version == 5) {
			if ($element == 'row') {
				if ($bootstrap_version == '2') {
					$element = 'row-fluid';
				}
			} else if (is_numeric($element) && $element > 0) {
				if ($bootstrap_version == 2) {
					$element = 'span' . $element;
				} else {
					$element = 'col-md-' . $element;
				}
			}
		} else {
			$jversion = RSPageBuilderHelper::getJoomlaVersion();
			
			if ($element == 'row') {
				if ($jversion == 3) {
					$element = 'row-fluid';
				}
			} else if (is_numeric($element) && $element > 0) {
				if ($jversion >= 4) {
					$element = 'col-md-' . $element;
				} else {
					$element = 'span' . $element;
				}
			}
		}
		
		return $element;
	}
	
	public static function getBootstrapElement($element, $bootstrap_version, $value) {
		$jversion			= RSPageBuilderHelper::getJoomlaVersion();
		$bootstrap_version	= ($bootstrap_version == 0) ? ($jversion >= 4 ? 5 : 2) : $bootstrap_version;
		
		if ($element == 'data') {
			if ($bootstrap_version == 5) {
				$element = 'data-bs-' . $value;
			} else {
				$element = 'data-' . $value;
			}
		}

		return $element;
	}
	
	public static function getClient($type = 'site') {
		$jversion = RSPageBuilderHelper::getJoomlaVersion();
		
		switch ($type) {
			case 'administrator':
				if ($jversion >= 4) {
					return JFactory::getApplication()->isClient('administrator');
				} else if ($jversion == 3) {
					return JFactory::getApplication()->isAdmin();
				}
			break;
			case 'site':
				if ($jversion >= 4) {
					return JFactory::getApplication()->isClient('site');
				} else if ($jversion == 3) {
					return JFactory::getApplication()->isSite();
				}
			break;
		}
	}
	
	public static function loadAsset($type, $file, $path = false) {
		$ext		= JFile::getExt($file);
		$options	= $path ? array('relative' => true, 'pathOnly' => true) : array('relative' => true, 'version' => 'auto');
		
		switch (true) {
			case ($type == 'component' and $ext == 'css'):
				JHtml::_('stylesheet', 'com_rspagebuilder/'.$file, array('relative' => true));
				if ($path) {
					return JHtml::_('stylesheet', 'com_rspagebuilder/'.$file, $options);
				} else {
					JHtml::_('stylesheet', 'com_rspagebuilder/'.$file, $options);
				}
			break;
			
			case ($type == 'element' and $ext == 'css'):
				JHtml::_('stylesheet', 'com_rspagebuilder/elements/'.$file, array('relative' => true));
				if ($path) {
					return JHtml::_('stylesheet', 'com_rspagebuilder/elements/'.$file, $options);
				} else {
					JHtml::_('stylesheet', 'com_rspagebuilder/elements/'.$file, $options);
				}
			break;
			
			case ($type == 'module' and $ext == 'css'):
				JHtml::_('stylesheet', 'mod_rspagebuilder_elements/'.$file, array('relative' => true));
				if ($path) {
					return JHtml::_('stylesheet', 'mod_rspagebuilder_elements/'.$file, $options);
				} else {
					JHtml::_('stylesheet', 'mod_rspagebuilder_elements/'.$file, $options);
				}
			break;
			
			case ($type == 'component' and $ext == 'js'):
				JHtml::_('script', 'com_rspagebuilder/'.$file, array('relative' => true));
				if ($path) {
					return JHtml::_('script', 'com_rspagebuilder/'.$file, $options);
				} else {
					JHtml::_('script', 'com_rspagebuilder/'.$file, $options);
				}
			break;
			
			case ($type == 'element' and $ext == 'js'):
				JHtml::_('script', 'com_rspagebuilder/elements/'.$file, array('relative' => true));
				if ($path) {
					return JHtml::_('script', 'com_rspagebuilder/elements/'.$file, $options);
				} else {
					JHtml::_('script', 'com_rspagebuilder/elements/'.$file, $options);
				}
			break;
			
			case ($type == 'module' and $ext == 'js'):
				JHtml::_('script', 'mod_rspagebuilder_elements/'.$file, array('relative' => true));
				if ($path) {
					return JHtml::_('script', 'mod_rspagebuilder_elements/'.$file, $options);
				} else {
					JHtml::_('script', 'mod_rspagebuilder_elements/'.$file, $options);
				}
			break;
		}
	}
	
	public static function loadElementLayout($element, $bootstrap_version, $content_plugins = 0) {
		$app = JFactory::getApplication();
		
		if (RSPageBuilderHelper::getClient('site')) {
			$patterns		= array(
				'/[^a-zA-Z0-9\s]/',
				'/\s+/'
			);
			$replaces		= array(
				'',
				' '
			);
			$filter_terms 	= preg_replace($patterns, $replaces, $app->getUserStateFromRequest('rspagebuilder.search', 'search', $app->input->get('search', '', 'string')));
			$filter			= is_array($filter_terms) ? trim(implode($filter_terms)) : trim($filter_terms);
			
			if (!empty($filter)) {
				$searchable = array(
					'title',
					'subtitle',
					'content',
					'caption',
					'client_details',
					'client_name',
					'price',
					'item_title',
					'item_content',
					'marker_title',
					'marker_content'
				);
				$terms		= explode(' ', $filter);
				$terms		= array_unique($terms);
				
				foreach ($terms as $term) {
					
					if (strlen($term) > 1) {
						// Search in element options
						foreach ($element['options'] as $key => $value) {
							if (!empty($element['options'][$key]) && in_array($key, $searchable)) {
								$is_html = preg_match('/<(a|blockquote|br|button|em|h1|h2|h3|h4|h5|h6|i|img|label|legend|li|ol|p|q|small|span|strong|sub|sup|table|tbody|td|tfoot|th|thead|title|tr|tt|u|ul)(.*)="(.*)'.$term.'(.*)"(.*)>/i', $value);
								
								if (!$is_html) {
									$element['options'][$key] = preg_replace('/'.$term.'/i', '<span class="rspbld-search-result">$0</span>', $value);
								}
							}
						}
						
						// Search in element items options
						foreach ($element['items'] as $item_key => $item_value) {
							foreach ($element['items'][$item_key]['options'] as $key => $value) {
								if (!empty($element['items'][$item_key]['options'][$key]) && in_array($key, $searchable)) {
									$is_html = preg_match('/<(a|blockquote|br|button|em|h1|h2|h3|h4|h5|h6|i|img|label|legend|li|ol|p|q|small|span|strong|sub|sup|table|tbody|td|tfoot|th|thead|title|tr|tt|u|ul)(.*)="(.*)'.$term.'(.*)"(.*)>/i', $value);
									
									if (!$is_html) {
										$element['items'][$item_key]['options'][$key] = preg_replace('/'.$term.'/i', '<span class="rspbld-search-result">$0</span>', $value);
									}
								}
							}
						}
					}
				}
			}
			
			// Trigger content plugins
			if ($content_plugins) {
				$content_fields = array(
					'content',
					'item_content',
					'item_text'
				);
				
				foreach ($element['options'] as $key => $value) {
					if (!empty($element['options'][$key]) && in_array($key, $content_fields)) {
						$element['options'][$key] = JHtml::_('content.prepare', $value);
					}
				}
				
				foreach ($element['items'] as $item_key => $item_value) {
					foreach ($element['items'][$item_key]['options'] as $key => $value) {
						if (!empty($element['items'][$item_key]['options'][$key]) && in_array($key, $content_fields)) {
							$element['items'][$item_key]['options'][$key] = JHtml::_('content.prepare', $value);
						}
					}
				}
			}
			
			$layout = new JLayoutFile('elements.bootstrap'.$bootstrap_version.'.'.str_replace('rspbld_', '', $element['type']), null, array('component' => 'com_rspagebuilder'));
		} else {
			if (JFile::exists(JPATH_ROOT . '/templates/'.self::getTemplate().'/html/layouts/com_rspagebuilder/elements/bootstrap'.$bootstrap_version.'/'.str_replace('rspbld_', '', $element['type']).'.php')) {
				$layout = new JLayoutFile(str_replace('rspbld_', '', $element['type']), JPATH_ROOT . '/templates/'.self::getTemplate().'/html/layouts/com_rspagebuilder/elements/bootstrap'.$bootstrap_version);
			} else if (JFile::exists(JPATH_ROOT . '/components/com_rspagebuilder/layouts/elements/bootstrap'.$bootstrap_version.'/'.str_replace('rspbld_', '', $element['type']).'.php')) {
				$layout = new JLayoutFile(str_replace('rspbld_', '', $element['type']), JPATH_ROOT . '/components/com_rspagebuilder/layouts/elements/bootstrap'.$bootstrap_version);
			}
		}
		
		return $layout->render($element);
	}
	
	public static function getElementIcon($element_type) {
		$element_type 			= str_replace('rspbld_', '', $element_type);
		$icon_template_path		= JPATH_ROOT . '/templates/' . self::getTemplate() . '/images/com_rspagebuilder/icons/' . $element_type . '.png';
		$icon_component_path	= JPATH_ROOT . '/media/com_rspagebuilder/images/icons/' . $element_type . '.png';
		
		if (file_exists($icon_template_path)) {
			$icon = JUri::root(true) . '/templates/' . self::getTemplate() . '/images/com_rspagebuilder/icons/' . $element_type . '.png';
		} else if (file_exists($icon_component_path)) {
			$icon = JUri::root(true) . '/media/com_rspagebuilder/images/icons/' . $element_type . '.png';
		} else {
			$icon = JUri::root(true) . '/media/com_rspagebuilder/images/icons/default.png';
		}
		
		return $icon;
	}

	public static function getTemplate($return_id = false) {
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true)
			->select($db->qn(array('id', 'template')))
			->from($db->qn('#__template_styles'))
			->where($db->qn('client_id') . ' = 0')
			->where($db->qn('home') . ' = 1');
		$db->setQuery($query);

        $tmpl = $db->loadObject();

		return ($return_id ? $tmpl->id : $tmpl->template);
	}
	
	public static function loadGoogleFonts() {
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true)
			->select($db->qn('params'))
			->from($db->qn('#__template_styles'))
			->where($db->qn('client_id') . ' = 0')
			->where($db->qn('home') . ' = 1');
		$db->setQuery($query);
		
		$doc				= JFactory::getDocument();
		$params				= json_decode($db->loadObject()->params);
		$sufix				= '';
		$fonts				= array();

        if (!empty($params->googleContentFont)) {
            $fonts['content'] = $params->googleContentFont;
        }

		if (!empty($params->googleTitleFont)) {
			$fonts['title'] = $params->googleTitleFont;
		}
		
		if (!empty($params->googleFontSubset)) {
			$sufix = '&amp;subset=' . $params->googleFontSubset;
		}
		
		$fonts = array_unique($fonts);
		
		foreach ($fonts as $font) {
			$doc->addCustomTag('<link href="https://fonts.googleapis.com/css?family=' . $font . $sufix . '" rel="stylesheet" type="text/css" />');
		}

        // Content selectors with Google Font
        if (!empty($params->addGoogleContentClasses)) {
            $extra_content_selectors = trim($params->addGoogleContentClasses, ',');
            $doc->addStyleDeclaration(
                $extra_content_selectors . "{
					font-family: " . current(explode(":", $params->googleContentFont)) . "
				}"
            );
        }

		// Title selectors with Google Font
		if (!empty($params->addGoogleTitleClasses)) {
			$extra_title_selectors = trim($params->addGoogleTitleClasses, ',');
			$doc->addStyleDeclaration(
				$extra_title_selectors . "{
					font-family: " . current(explode(":", $params->googleTitleFont)) . "
				}"
			);
		}
	}
	
	public static function randomNumber() {
		return rand(1000, 9999);
	}
	
	public static function createId($text, $number) {
		$id = '';

		if ($text) {
			$id .= preg_replace('/[^\da-z]/i', '', strtolower($text));
		}

		$id .= $number;

		if (is_numeric($id[0])) {
			$id = 'id_' . $id;
		}

		return $id;
	}
	
	public static function renderFormFields($form, $fields, $type) {
		$html		= '';
		$jversion	= RSPageBuilderHelper::getJoomlaVersion();
		
		foreach ($fields as $field) {
			$control_group_class	= 'control-group';
			$control_group_class	.= ($form->getFieldAttribute($field, 'type') == 'hidden') ? ' hidden' : '';
			$control_group_showon	= $form->getFieldAttribute($field, 'showon') ? ' data-showon="' . $form->getFieldAttribute($field, 'showon') . '"' : '';
			
			$html .= '<div class="' . $control_group_class . '"' . $control_group_showon . '>';
			$html .= '<div class="control-label">';
			
			$field_label = $form->getLabel($field);
			
			// Add field label popover on Joomla 4
			if ($jversion >= 4) {
				$field_label = RSPageBuilderHelper::addFieldLabelPopover($field_label, JText::_($form->getFieldAttribute($field, 'label')), JText::_($form->getFieldAttribute($field, 'description')));
			}
			$html .= $field_label;
			$html .= '</div>';
			$html .= '<div class="controls">';
			$html .= $form->getInput($field);
			$html .= '</div>';
			$html .= '</div>';
		}
		
		return $html;
	}
	
	public static function escapeHtml($string) {
		if ($string) {
			$string = htmlentities($string, ENT_QUOTES, 'UTF-8');
			$string = preg_replace('/&lt;span class=&quot;rspbld-search-result&quot;&gt;(.*?)&lt;\/span&gt;/', '<span class="rspbld-search-result">$1</span>', $string);
		}
		
		return $string;
	}
	
	public static function escapeHtmlArray($array) {
		$not_escapable = array(
			'content',
			'item_content',
			'marker_content'
		);
		
		foreach ($array as $key => $val) {
			if (!in_array($key, $not_escapable)) {
				$array[$key] = RSPageBuilderHelper::escapeHtml($val);
			} else if (strpos($val, 'src="' . JUri::root(true) . '/') == false) {
                $val            = preg_replace('/src="(?!http(s)*:\/\/)/', 'src="' . JUri::root(true) . '/$1', $val);
                $array[$key]    = $val;
			}
		}
		
		return $array;
	}
	
	public static function escapeSearch($string) {
		return preg_replace('/<span class="rspbld-search-result">(.*?)<\/span>/', '$1', $string);
	}
	
	public static function buildStyle($array) {
		$style				= '';
		
		if (count($array)) {
			$style .= ' style="';
			
			foreach ($array as $key => $val) {
				if ($key == 'background-image') {
					$style .= $key.': url('.JUri::root('true').'/'.$val.');';
				} else {
					$style .= $key.': '.$val.';';
				}
			}
			$style .= '"';
		}
		
		return $style;
	}
	
	public static function elementTypeToTitle($element_type) {
		return JText::_('COM_RSPAGEBUILDER_' . strtoupper(str_replace('rspbld_', '', $element_type)));
	}
	
	public static function toArray($obj) {
		if (is_object($obj)) {
			$obj = (array)$obj;
		}
		if (is_array($obj)) {
			$new_array = array();
			foreach ($obj as $key => $val) {
				$new_array[$key] = RSPageBuilderHelper::toArray($val);
			}
		} else {
			$new_array = $obj;
		}
		
		return $new_array;
	}
	
	public static function arrayFlatten($array) {
		$new_array = array();
		
		for ($i = 0; $i < count($array); $i++) {
			if (is_array($array[$i])) {
				foreach ($array[$i] as $key => $val) {
					array_push($new_array, $val);
				}
			} else {
				array_push($new_array, $array[$i]);
			}
		}
		
		return $new_array;
	}
	
	public static function addFieldLabelPopover($field_label, $title, $content) {
		$field_label = JHtml::_('content.prepare', $field_label);
		
		return preg_replace('/<label([^>]*)>/', '<label$1 data-bs-toggle="popover" title="' . $title . '" data-bs-content="' . $content . '">', $field_label);
	}
	
	public static function init() {
		
	}
}