<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

use Joomla\String\StringHelper;
use Joomla\CMS\Log\Log;

class RSPageBuilderModelPage extends JModelAdmin
{
	
	/**
	 * Returns a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 *
	 * @return	JTable	A database object
	*/
    public function getTable($type = 'Page', $prefix = 'RSPageBuilderTable', $config = array()) {
        return JTable::getInstance($type, $prefix, $config);
    }

	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 *
	 * @return	mixed	A JForm object on success, false on failure
	 */
    public function getForm($data = array(), $loadData = true) {
        $form = $this->loadForm('com_rspagebuilder.page', 'page', array('control' => 'jform', 'load_data' => $loadData));
		
        if (empty($form)) {
			return false;
		}
		
        return $form;
    }
	
	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 */
    protected function loadFormData() {
        $data = JFactory::getApplication()->getUserState('com_rspagebuilder.edit.page.data', array());
		
        if (empty($data)) {
			$data = $this->getItem();
		}
        if (isset($data->alias)) {
			if ($data->alias) {
                $data->alias = JFilterOutput::stringURLSafe($data->alias);
            } else {
                $data->alias = JFilterOutput::stringURLSafe($data->title);
            }
        }
        $this->preprocessData('com_rspagebuilder.page', $data);
		
        return $data;
    }
	
	/**
	 * Method to save the form data.
	 *
	 * @param   array  $data  The form data.
	 *
	 * @return  boolean  True on success.
	 */
    public function save($data) {
        if (JFactory::getApplication()->input->get('task') == 'save2copy') {
			$table = clone $this->getTable();
			$table->load(array('alias' => $data['alias']));
			
			list($title, $alias)	= $this->generateNewTitle(null, $data['alias'], $data['title']);
			$data['alias']			= $alias;
			$data['title']			= $title;
        }
		
		if ($data['created'] == '') {
			$data['created'] = '0000-00-00 00:00:00';
		}
		
		if ($data['modified'] == '') {
			$data['modified'] = '0000-00-00 00:00:00';
		}
		
        parent::save($data);
		
        return true;
    }
	
	protected function generateNewTitle($cat, $alias, $title) {
		// Alter the title & alias
		$table = $this->getTable();
		
		while ($table->load(array('alias' => $alias))) {
			$title = StringHelper::increment($title);
			$alias = StringHelper::increment($alias, 'dash');
		}
		
		return array($title, $alias);
	}
	
	// Export pages
	public function export($pages) {
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select('*')
			->from($db->qn('#__rspagebuilder'))
			->where($db->qn('id') . ' IN ' . ' (' . implode(',', $pages) . ')');
		$db->setQuery($query);
		$result = $db->loadObjectList();
		
		$this->formatTableData($result);
	}
	
	protected function formatTableData($data) {
		$layout = '';
		$layout .= '<?xml version="1.0" encoding="utf-8"?><items><extension>com_rspagebuilder</extension>';

		foreach ($data as $item) {
			$layout .= '<item>';
			
			foreach ($item as $name => $property) {
				$layout .= $this->createXmlNode($name, $property);
			}
			
			$layout .= '</item>';
		}

		$layout .= '</items>';
		
		$this->downloadXMlFile($layout);
	}
	
	protected function createXmlNode($cell_name, $cell_value) {
		$cell			= '';

		$text_columns	= array('content', 'open_graph_title', 'open_graph_image', 'open_graph_description', 'metakey', 'metadesc', 'robots', 'language');
		$ignore_cells	= array('id', 'created', 'created_by', 'modified', 'modified_by');
		
		if (in_array($cell_name, $ignore_cells)) {
			$cell = '';
		} else if (in_array($cell_name, $text_columns)) {
			$cell .= '<' . $cell_name . '><![CDATA[' . $cell_value . ']]></' . $cell_name . '>';
		} else {
			$cell .= '<' . $cell_name . '>' . $cell_value . '</' . $cell_name . '>';
		}

		return $cell;
	}
	
	protected function downloadXMlFile($data) {
		$sanitized = self::sanitiseString($data);
		
		header('Content-disposition: attachment; filename=rspagebuilder_pages.xml');
		header('Content-Type:text/xml');
		//output the XML data
		echo $sanitized;
		// if you want to directly download then set expires time
		header('Expires: 0');
		exit();
	}
	
	public static function sanitiseString($content) {
		$re1 = '(src)';
		$re2 = '(=)';
		$re3 = '(")';
		$re4 = '(\\/)';
		$re5 = '((?:[a-z][a-z0-9_]*))';
		$re6 = '(\\/)';

		$replace = 'src="';

		if ($c = preg_match_all("/" . $re1 . $re2 . $re3 . $re4 . $re5 . $re6 . "/is", $content, $matches)) {
			$word1 = $matches[1][0];
			$c1    = $matches[2][0];
			$c2    = $matches[3][0];
			$c3    = $matches[4][0];
			$var1  = $matches[5][0];
			$c4    = $matches[6][0];
			$str   = $word1 . $c1 . $c2 . $c3 . $var1 . $c4;

			return str_replace($str, $replace, $content);
		} else {
			return $content;
		}
	}
	
	public function import() {
		require_once(JPATH_ADMINISTRATOR . '/components/com_rspagebuilder/helpers/import.php');
		
		$app			= JFactory::getApplication();
		$doc			= $app->getDocument();
		$import_file	= $app->input->files->get('import');
		$tmp_file		= JPATH_SITE . '/tmp/rspagebuilder_pages.xml';
		$xmlParser		= new RSPageBuilderXMLParser();
		
		jimport('joomla.filesystem.file');
		
		JFile::upload($import_file['tmp_name'], $tmp_file);
		
		// Load XML file
		$xmlData = simplexml_load_file($tmp_file);
		
		if ((!isset($xmlData->extension)) || ($xmlData->extension != 'com_rspagebuilder')) {
			$app->input->set('isrspbld', 'false');
		}
		
		foreach ($xmlData->item as $item) {
			$xmlParser->saveItem($item);
			$xmlParser->addModulesIds($item->alias);
		}
		
		JFile::delete($tmp_file);
		
		echo json_encode($app->input->getArray());
		
		JExit();
	}
}