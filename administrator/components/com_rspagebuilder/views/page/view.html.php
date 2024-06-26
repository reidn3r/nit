<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

use Joomla\CMS\Editor\Editor;

class RSPageBuilderViewPage extends JViewLegacy
{
	public function display($tpl = null) {
		include_once (JPATH_COMPONENT_ADMINISTRATOR.'/helpers/config.php');
		include_once (JPATH_COMPONENT_ADMINISTRATOR.'/helpers/rspagebuilder.php');
		
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');
		
		JHtml::_('jquery.framework', true, null, true);

		$doc					= JFactory::getDocument();
		$this->jversion			= RSPageBuilderHelper::getJoomlaVersion();
		$this->form				= $this->get('Form');
		$this->item				= $this->get('Item');
		$this->row_config		= RSPageBuilderConfig::getRowConfig();
		$this->column_config	= RSPageBuilderConfig::getColumnConfig();
		$this->elements			= RSPageBuilderConfig::getElements();
		$this->my_elements		= RSPageBuilderConfig::getMyElements();
		$this->categories		= array();
		$this->categories[]		= JText::_('COM_RSPAGEBUILDER_ALL_ELEMENTS');
		$this->google_api_key   = JComponentHelper::getParams('com_rspagebuilder')->get('google_api_key');
		
		// Set default Bootstrap version
		if (!isset($this->item->bootstrap_version)) {
			if ($this->jversion >= 4) {
				$this->item->bootstrap_version = 5;
			} else {
				$this->item->bootstrap_version = 2;
			}
		}
		
		// Modal and form validation
		if ($this->jversion == 3) {
			JHtml::_('behavior.modal');
			JHtml::_('behavior.formvalidation');
		}
		
		// Load Chosen files
		if ($this->jversion == 3) {
			JHtml::_('formbehavior.chosen', '.element-options select');
		}
		
		// Load Bootstrap files
		if ($this->item->bootstrap_version == 2 || $this->item->bootstrap_version == 5) {
			JHtml::_('bootstrap.framework');
			JHtml::_('bootstrap.loadCss', true, $doc->direction);
		}
		
		// Load CSS files
		if ($this->jversion >= 4) {
			$doc->addStylesheet(JUri::root(true) . '/media/vendor/minicolors/css/jquery.minicolors.css');
		} else {
			$doc->addStylesheet(JUri::root(true) . '/media/jui/css/jquery.minicolors.css');
		}
		
		RSPageBuilderHelper::loadAsset('component', 'font-awesome.min.css');
		RSPageBuilderHelper::loadAsset('component', 'animations.css');
		RSPageBuilderHelper::loadAsset('component', 'jquery.ui.resizable.min.css');
		RSPageBuilderHelper::loadAsset('component', 'jquery.mb.YTPlayer.min.css');
		RSPageBuilderHelper::loadAsset('component', 'fields/iconslist' . ($this->jversion === 3 ? '-j3' : '') . '.css');
		RSPageBuilderHelper::loadAsset('component', 'fields/uploadimage' . ($this->jversion === 3 ? '-j3' : '') . '.css');
		RSPageBuilderHelper::loadAsset('component', 'admin-style' . ($this->jversion === 3 ? '-j3' : '') . '.css');
		
		RSPageBuilderHelper::loadGoogleFonts();
		
		$doc->addStyleSheet(JHtml::_('stylesheet', 'https://unpkg.com/leaflet@1.9.3/dist/leaflet.css', array('pathOnly' => true)));
		
		// Load JS files
		if ($this->jversion >= 4) {
			$doc->addScript(JUri::root(true) . '/media/vendor/minicolors/js/jquery.minicolors.min.js');
		} else {
			$doc->addScript(JUri::root(true) . '/media/jui/js/jquery.minicolors.min.js');
		}
		$doc->addScript('https://www.youtube.com/iframe_api');
		$doc->addScript('https://player.vimeo.com/api/player.js');
		
		// Load Google Map script
        if ($this->google_api_key) {
            $doc->addScript('https://maps.google.com/maps/api/js?key=' . $this->google_api_key . '&callback=RSPageBuilderHelper.initGoogleMap', array(), array("async" => "async", "defer"=> "defer"));
        }
		
		// Load Google Map script
		$doc->addScript(JHtml::script('https://unpkg.com/leaflet@1.9.3/dist/leaflet.js', array('pathOnly' => true)));

		RSPageBuilderHelper::loadAsset('component', 'beautify-html.js');
		RSPageBuilderHelper::loadAsset('component', 'jquery.ui.core.min.js');
		RSPageBuilderHelper::loadAsset('component', 'jquery.ui.sortable.min.js');
		RSPageBuilderHelper::loadAsset('component', 'jquery.ui.resizable.min.js');
		RSPageBuilderHelper::loadAsset('component', 'jquery.visible.min.js');
		RSPageBuilderHelper::loadAsset('component', 'jquery.animateNumber.min.js');
		RSPageBuilderHelper::loadAsset('component', 'jquery.countdownTimer.js');
		RSPageBuilderHelper::loadAsset('component', 'masonry.pkgd.min.js');
		RSPageBuilderHelper::loadAsset('component', 'jquery.mb.YTPlayer.min.js');
		RSPageBuilderHelper::loadAsset('component', 'jquery.videoPlayer.js');
		RSPageBuilderHelper::loadAsset('component', 'jquery.filterizr.js');
		if ($this->jversion == 3) {
			RSPageBuilderHelper::loadAsset('component', 'jquery.touchSwipe.min.js');
		}
		RSPageBuilderHelper::loadAsset('component', 'fields/iconslist.js');
		RSPageBuilderHelper::loadAsset('component', 'fields/uploadimage.js');
		RSPageBuilderHelper::loadAsset('component', 'admin-helper.js');
		RSPageBuilderHelper::loadAsset('component', 'admin-rspagebuilder.js');
		
		$doc->addScriptDeclaration('var rspbld_root = "'.JUri::root().'";');
		$doc->addScriptDeclaration('var rspbld_jversion = '.$this->jversion.';');
		
		// Get elements categories
		foreach ($this->elements as $element) {
			$this->categories[] = strtolower($element['category']);
			
			// Load each element style
			RSPageBuilderHelper::loadAsset('element', 'bootstrap' . $this->item->bootstrap_version . '/' . str_replace('rspbld_', '', $element['type']).'.css');
		}
		
		// Load template rendered elements style
        RSPageBuilderHelper::loadAsset('component', 'admin-elements-style-' . RSPageBuilderHelper::getTemplate(true) . '.css');
		
		foreach ($this->my_elements as $element) {
			$this->categories[] = strtolower($element['category']);
		}
		$this->categories = array_unique($this->categories);
		
		// Check for errors
		if (count($errors = $this->get('Errors'))) {
			throw new \Exception(implode("\n", $errors), 500);
		}
		
		// Load editor
		$editor_type	= JFactory::getConfig()->get('editor');
		$editor			= Editor::getInstance($editor_type);
		
		switch ($editor_type) {
			case 'tinymce':
			
				// Load TinyMCE resources
				if ($this->jversion >= 4) {
					$doc->addScript(JUri::root(true) . '/media/vendor/tinymce/tinymce.min.js');
				} else {
					$doc->addScript(JUri::root(true) . '/media/editors/tinymce/tinymce.min.js');
					$doc->addScript(JUri::root(true) . '/media/editors/tinymce/js/tinymce.min.js');
				}
				
				// Initialize TinyMCE
				$editor->display('tinymce', '', 0, 350, 0, 0);
				
				break;
				
			case 'codemirror':
				
				// Load CodeMirror resources
				if ($this->jversion >= 4) {
					$doc->addScript(JUri::root(true) . '/media/vendor/codemirror/lib/codemirror.min.js');
				} else {
					$doc->addStyleSheet(JUri::root(true) . '/media/editors/codemirror/lib/codemirror.min.css');
					$doc->addScript(JUri::root(true) . '/media/editors/codemirror/lib/codemirror.min.js');
				}
				
				// Initialize CodeMirror
				$editor->display('codemirror', '', 0, 350, 0, 0);
				
				break;
				
			case 'none':
				break;
				
			default:
			
				// Load TinyMCE JS files
				if ($this->jversion >= 4) {
					$doc->addScript(JUri::root(true) . '/media/vendor/tinymce/tinymce.min.js');
				} else {
					$doc->addScript(JUri::root(true) . '/media/editors/tinymce/tinymce.min.js');
					$doc->addScript(JUri::root(true) . '/media/editors/tinymce/js/tinymce.min.js');
				}
		}
		
		// Load language
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true)
			->select($db->qn('template'))
			->from($db->qn('#__template_styles'))
			->where($db->qn('client_id') . ' = ' . $db->q(0))
			->where($db->qn('home') . ' = ' . $db->q(1));
		
		$db->setQuery($query);
		$defaultemplate = $db->loadResult();
		
		$lang = JFactory::getLanguage();
		$lang->load('tpl_' . $defaultemplate, JPATH_SITE, $lang->getName(), true);
		
		// Messages translations
		JText::script('COM_RSPAGEBUILDER_ERROR');
		JText::script('COM_RSPAGEBUILDER_INVALID_FIELD');
		JText::script('COM_RSPAGEBUILDER_LEAVE_PAGE');
		
		JText::script('COM_RSPAGEBUILDER_SURE_DELETE_ROW');
		JText::script('COM_RSPAGEBUILDER_SURE_REMOVE_ELEMENT');
		JText::script('COM_RSPAGEBUILDER_SURE_REMOVE_ITEM');
		JText::script('COM_RSPAGEBUILDER_REMOVE_LAST_ITEM');
		JText::script('COM_RSPAGEBUILDER_ICON_SEARCH_ICON');
		
		JText::script('COM_RSPAGEBUILDER_COUNTDOWN_TIMER_EXPIRED');
		
		JText::script('WARNING');

		// Actions translations
		JText::script('COM_RSPAGEBUILDER_ADD_ROW');
		JText::script('COM_RSPAGEBUILDER_DELETE_ROW');
		JText::script('COM_RSPAGEBUILDER_DUPLICATE_ROW');
		JText::script('COM_RSPAGEBUILDER_CONFIGURE_ROW');
		JText::script('COM_RSPAGEBUILDER_CONFIGURE_COLUMN');
		JText::script('COM_RSPAGEBUILDER_BUTTON');

		// Elements translations
		JText::script('COM_RSPAGEBUILDER_ACCORDION');
		JText::script('COM_RSPAGEBUILDER_ALERT');
		JText::script('COM_RSPAGEBUILDER_ANIMATED_NUMBER');
		JText::script('COM_RSPAGEBUILDER_BUTTON');
		JText::script('COM_RSPAGEBUILDER_CAROUSEL');
		JText::script('COM_RSPAGEBUILDER_COUNTDOWN_TIMER');
		JText::script('COM_RSPAGEBUILDER_DIVIDER');
		JText::script('COM_RSPAGEBUILDER_GOOGLE_MAP');
		JText::script('COM_RSPAGEBUILDER_HORIZONTAL_ICON_BOX');
		JText::script('COM_RSPAGEBUILDER_HORIZONTAL_IMAGE_BOX');
		JText::script('COM_RSPAGEBUILDER_ICON');
		JText::script('COM_RSPAGEBUILDER_IMAGE');
		JText::script('COM_RSPAGEBUILDER_LIST');
		JText::script('COM_RSPAGEBUILDER_MASONRY_BOXES');
		JText::script('COM_RSPAGEBUILDER_MODULE');
		JText::script('COM_RSPAGEBUILDER_OPENSTREETMAP');
		JText::script('COM_RSPAGEBUILDER_PERSONAL_BOX');
		JText::script('COM_RSPAGEBUILDER_PORTFOLIO_FILTERING');
		JText::script('COM_RSPAGEBUILDER_PRICE_BOX');
		JText::script('COM_RSPAGEBUILDER_PROGRESS_BARS');
		JText::script('COM_RSPAGEBUILDER_PROGRESS_CIRCLES');
		JText::script('COM_RSPAGEBUILDER_SPACER');
		JText::script('COM_RSPAGEBUILDER_TAB');
		JText::script('COM_RSPAGEBUILDER_TESTIMONIAL_BOX');
		JText::script('COM_RSPAGEBUILDER_TEXT_BLOCK');
		JText::script('COM_RSPAGEBUILDER_VERTICAL_ICON_BOX');
		JText::script('COM_RSPAGEBUILDER_VERTICAL_IMAGE_BOX');
		JText::script('COM_RSPAGEBUILDER_VIDEO');
		JText::script('COM_RSPAGEBUILDER_YOUTUBE_BACKGROUND_VIDEO_BOX');

		// Column fields translations
		JText::script('COM_RSPAGEBUILDER_COLUMN_MARGIN');
		JText::script('COM_RSPAGEBUILDER_COLUMN_PADDING');
		JText::script('COM_RSPAGEBUILDER_COLUMN_SUBTITLE_FONT_SIZE');
		JText::script('COM_RSPAGEBUILDER_COLUMN_SUBTITLE_MARGIN');
		JText::script('COM_RSPAGEBUILDER_COLUMN_SUBTITLE_PADDING');
		JText::script('COM_RSPAGEBUILDER_COLUMN_TITLE_FONT_SIZE');
		JText::script('COM_RSPAGEBUILDER_COLUMN_TITLE_MARGIN');
		JText::script('COM_RSPAGEBUILDER_COLUMN_TITLE_PADDING');

		// Row fields translations
		JText::script('COM_RSPAGEBUILDER_ROW_MARGIN');
		JText::script('COM_RSPAGEBUILDER_ROW_PADDING');
		JText::script('COM_RSPAGEBUILDER_ROW_SUBTITLE_FONT_SIZE');
		JText::script('COM_RSPAGEBUILDER_ROW_SUBTITLE_MARGIN');
		JText::script('COM_RSPAGEBUILDER_ROW_SUBTITLE_PADDING');
		JText::script('COM_RSPAGEBUILDER_ROW_TITLE_FONT_SIZE');
		JText::script('COM_RSPAGEBUILDER_ROW_TITLE_MARGIN');
		JText::script('COM_RSPAGEBUILDER_ROW_TITLE_PADDING');

		// Elements fields translations
		JText::script('COM_RSPAGEBUILDER_BORDER_RADIUS');
		JText::script('COM_RSPAGEBUILDER_BORDER_WIDTH');
		JText::script('COM_RSPAGEBUILDER_BOX_MARGIN');
		JText::script('COM_RSPAGEBUILDER_BOX_PADDING');
		JText::script('COM_RSPAGEBUILDER_CLIENT_AVATAR_HEIGHT');
		JText::script('COM_RSPAGEBUILDER_CLIENT_AVATAR_MARGIN');
		JText::script('COM_RSPAGEBUILDER_CLIENT_AVATAR_PADDING');
		JText::script('COM_RSPAGEBUILDER_CLIENT_AVATAR_WIDTH');
		JText::script('COM_RSPAGEBUILDER_CONTENT_BORDER_RADIUS');
		JText::script('COM_RSPAGEBUILDER_CONTENT_BORDER_WIDTH');
		JText::script('COM_RSPAGEBUILDER_CONTENT_MARGIN');
		JText::script('COM_RSPAGEBUILDER_CONTENT_PADDING');
		JText::script('COM_RSPAGEBUILDER_CONTROLS_FONT_SIZE');
		JText::script('COM_RSPAGEBUILDER_CONTROLS_SIZE');
		JText::script('COM_RSPAGEBUILDER_COUNTDOWN_FONT_SIZE');
		JText::script('COM_RSPAGEBUILDER_COUNTDOWN_FONT_WEIGHT');
		JText::script('COM_RSPAGEBUILDER_COUNTDOWN_TEXT_COLOR');
		JText::script('COM_RSPAGEBUILDER_DETAILS_FONT_SIZE');
		JText::script('COM_RSPAGEBUILDER_DETAILS_FONT_WEIGHT');
		JText::script('COM_RSPAGEBUILDER_DETAILS_TEXT_COLOR');
		JText::script('COM_RSPAGEBUILDER_FONT_SIZE');
		JText::script('COM_RSPAGEBUILDER_FONT_WEIGHT');
		JText::script('COM_RSPAGEBUILDER_FORMAT');
		JText::script('COM_RSPAGEBUILDER_HEIGHT');
		JText::script('COM_RSPAGEBUILDER_ICON_FONT_SIZE');
		JText::script('COM_RSPAGEBUILDER_ICON_MARGIN');
		JText::script('COM_RSPAGEBUILDER_ICON_PADDING');
		JText::script('COM_RSPAGEBUILDER_IMAGE_HEIGHT');
		JText::script('COM_RSPAGEBUILDER_IMAGE_MARGIN');
		JText::script('COM_RSPAGEBUILDER_IMAGE_PADDING');
		JText::script('COM_RSPAGEBUILDER_IMAGE_WIDTH');
		JText::script('COM_RSPAGEBUILDER_INDICATORS_SIZE');
		JText::script('COM_RSPAGEBUILDER_ITEM_BAR_HEIGHT');
		JText::script('COM_RSPAGEBUILDER_ITEM_BAR_WIDTH');
		JText::script('COM_RSPAGEBUILDER_ITEM_CSS_CLASS');
		JText::script('COM_RSPAGEBUILDER_ITEM_CONTENT_MARGIN');
		JText::script('COM_RSPAGEBUILDER_ITEM_CONTENT_PADDING');
		JText::script('COM_RSPAGEBUILDER_ITEM_FONT_SIZE');
		JText::script('COM_RSPAGEBUILDER_ITEM_HEIGHT');
		JText::script('COM_RSPAGEBUILDER_ITEM_IMAGE_HEIGHT');
		JText::script('COM_RSPAGEBUILDER_ITEM_IMAGE_WIDTH');
		JText::script('COM_RSPAGEBUILDER_ITEM_MARGIN');
		JText::script('COM_RSPAGEBUILDER_ITEM_PADDING');
		JText::script('COM_RSPAGEBUILDER_ITEM_PERCENTAGE_FONT_SIZE');
		JText::script('COM_RSPAGEBUILDER_ITEM_SIZE');
		JText::script('COM_RSPAGEBUILDER_ITEM_TITLE_FONT_SIZE');
		JText::script('COM_RSPAGEBUILDER_ITEM_TITLE_ICON_FONT_SIZE');
		JText::script('COM_RSPAGEBUILDER_ITEM_TITLE_MARGIN');
		JText::script('COM_RSPAGEBUILDER_ITEM_TITLE_PADDING');
		JText::script('COM_RSPAGEBUILDER_ITEM_WIDTH');
		JText::script('COM_RSPAGEBUILDER_LONG');
		JText::script('COM_RSPAGEBUILDER_LONG_DAY');
		JText::script('COM_RSPAGEBUILDER_LONG_DAYS');
		JText::script('COM_RSPAGEBUILDER_LONG_HOURS');
		JText::script('COM_RSPAGEBUILDER_LONG_HOUR');
		JText::script('COM_RSPAGEBUILDER_LONG_MINUTE');
		JText::script('COM_RSPAGEBUILDER_LONG_MINUTES');
		JText::script('COM_RSPAGEBUILDER_LONG_SECOND');
		JText::script('COM_RSPAGEBUILDER_LONG_SECONDS');
		JText::script('COM_RSPAGEBUILDER_MARGIN');
		JText::script('COM_RSPAGEBUILDER_MARKER_TITLE_FONT_SIZE');
		JText::script('COM_RSPAGEBUILDER_NUMBER_BACKGROUND_COLOR');
		JText::script('COM_RSPAGEBUILDER_NUMBER_FONT_SIZE');
		JText::script('COM_RSPAGEBUILDER_NUMBER_FONT_WEIGHT');
		JText::script('COM_RSPAGEBUILDER_NUMBER_MARGIN');
		JText::script('COM_RSPAGEBUILDER_NUMBER_PADDING');
		JText::script('COM_RSPAGEBUILDER_NUMBER_POISTION');
		JText::script('COM_RSPAGEBUILDER_NUMBER_TEXT_COLOR');
		JText::script('COM_RSPAGEBUILDER_PADDING');
		JText::script('COM_RSPAGEBUILDER_PRICE_FONT_SIZE');
		JText::script('COM_RSPAGEBUILDER_SHORT');
		JText::script('COM_RSPAGEBUILDER_SHORT_DAYS');
		JText::script('COM_RSPAGEBUILDER_SHORT_HOURS');
		JText::script('COM_RSPAGEBUILDER_SHORT_MINUTES');
		JText::script('COM_RSPAGEBUILDER_SHORT_SECONDS');
		JText::script('COM_RSPAGEBUILDER_SOCIAL_ICONS_FONT_SIZE');
		JText::script('COM_RSPAGEBUILDER_SOCIAL_ICONS_MARGIN');
		JText::script('COM_RSPAGEBUILDER_SOCIAL_ICONS_PADDING');
		JText::script('COM_RSPAGEBUILDER_SUBTITLE_FONT_SIZE');
		JText::script('COM_RSPAGEBUILDER_SUBTITLE_MARGIN');
		JText::script('COM_RSPAGEBUILDER_SUBTITLE_PADDING');
		JText::script('COM_RSPAGEBUILDER_TEXT_FONT_SIZE');
		JText::script('COM_RSPAGEBUILDER_TAG_FONT_SIZE');
		JText::script('COM_RSPAGEBUILDER_TAG_MARGIN');
		JText::script('COM_RSPAGEBUILDER_TAG_PADDING');
		JText::script('COM_RSPAGEBUILDER_TAGS_MARGIN');
		JText::script('COM_RSPAGEBUILDER_TAGS_PADDING');
		JText::script('COM_RSPAGEBUILDER_TITLE_FONT_SIZE');
		JText::script('COM_RSPAGEBUILDER_TITLE_MARGIN');
		JText::script('COM_RSPAGEBUILDER_TITLE_PADDING');
		JText::script('COM_RSPAGEBUILDER_URL');
		JText::script('COM_RSPAGEBUILDER_WIDTH');
		
		$this->addToolBar();
		
		parent::display($tpl);
	}

	protected function addToolBar() {
		
        // Set title
        if (JFactory::getApplication()->input->getInt('id')) {
            JToolBarHelper::title(JText::sprintf('COM_RSPAGEBUILDER_EDIT_PAGE', $this->item->title), 'rspagebuilder');
        } else {
            JToolBarHelper::title(JText::_('COM_RSPAGEBUILDER_ADD_PAGE'), 'rspagebuilder');
        }
		
		// Add toolbar buttons
		JToolBarHelper::apply('page.apply');
        JToolBarHelper::save('page.save');
        JToolBarHelper::save2new('page.save2new');
        JToolBarHelper::save2copy('page.save2copy');
        JToolBarHelper::cancel('page.cancel');
	}
}