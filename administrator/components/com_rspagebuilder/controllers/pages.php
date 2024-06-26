<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

use Joomla\Utilities\ArrayHelper;

/**
 * Pages controller.
 */
class RSPageBuilderControllerPages extends JControllerAdmin {
	
    public function getModel($name = 'Page', $prefix = 'RSPageBuilderModel', $config = array('ignore_request' => true)) {
        return parent::getModel($name, $prefix, $config);
    }
	
	public function export() {
		// Get the input
		$input = JFactory::getApplication()->input;
		$items = $input->post->get('cid', array(), 'array');

		// Sanitize the input
		ArrayHelper::toInteger($items);

		$model = $this->getModel();
		
		$model->export($items);
	}
	
	public function import() {
		$model = $this->getModel();
		
		$model->import();
	}
}