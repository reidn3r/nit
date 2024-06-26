<?php

defined('_JEXEC') or die('Restricted access');
/*
	preflight which is executed before install and update
	install
	update
	uninstall
	postflight which is executed after install and update
	*/

class com_imageeffectckInstallerScript {

	function install($parent) {
		
	}
	
	function update($parent) {
		
	}
	
	function uninstall($parent) {
		jimport('joomla.installer.installer');
		$db = \Joomla\CMS\Factory::getDbo();
		// Check first that the plugin exist
		$db->setQuery('SELECT `extension_id` FROM #__extensions WHERE `element` = "imageeffectck" AND `type` = "plugin"');
		$id = $db->loadResult();

		if($id)
		{
			$installer = new \Joomla\CMS\Installer\Installer;
			$result = $installer->uninstall('plugin', $id);
		}
	}

	function preflight($type, $parent) {
		// disable the install on Joomla 3 after 3.1.0
		if (version_compare(JVERSION, '4') === -1) {
			throw new RuntimeException('This version of Image Effect CK can not be installed on Joomla 3.');
		}

		// check if a pro version already installed
		$xmlPath = JPATH_ROOT . '/administrator/components/com_imageeffectck/imageeffectck.xml';
		
		// if no file already exists
		if (! file_exists($xmlPath)) return true;

		$xmlData = $this->getXmlData($xmlPath);
		$isProInstalled = ((int)$xmlData->ckpro);

		if ($isProInstalled) {
			throw new RuntimeException('Image Effect CK Light cannot be installed over Image Effect CK Pro. Please install Image Effect CK Pro. To downgrade, please first uninstall Image Effect CK Pro.');
			// return false;
		}
		return true;
	}

	public function getXmlData($file) {
		if ( ! is_file($file))
		{
			return '';
		}

		$xml = simplexml_load_file($file);

		if ( ! $xml || ! isset($xml['version']))
		{
			return '';
		}

		return $xml;
	}

	// run on install and update
	function postflight($type, $parent) {
		// install modules and plugins
		jimport('joomla.installer.installer');
		$db = \Joomla\CMS\Factory::getDbo();
		$status = array();
		$src_ext = dirname(__FILE__).'/administrator/extensions';
		$installer = new \Joomla\CMS\Installer\Installer;

		// install the plugin
		$result = $installer->install($src_ext.'/imageeffectck');
		// auto enable the plugin
		$db->setQuery("UPDATE #__extensions SET enabled = '1' WHERE `element` = 'imageeffectck' AND `type` = 'plugin'");
		$result = $db->execute();
		$status[] = array('name'=>'Image Effect CK System - Plugin','type'=>'plugin', 'result'=>$result);

		// disable the old update site
		$db->setQuery("UPDATE #__update_sites SET enabled = '0' WHERE `location` = 'http://update.joomlack.fr/com_imageeffectck_update.xml'");
		$result3 = $db->execute();
		// disable the old update site
		$db->setQuery("UPDATE #__update_sites SET enabled = '0' WHERE `location` = 'http://update.joomlack.fr/plg_imageeffectck_update.xml'");
		$result3 = $db->execute();

		foreach ($status as $statu) {
			if ($statu['result'] == true) {
				$alert = 'success';
				$icon = 'icon-ok';
				$text = 'Successful';
			} else {
				$alert = 'warning';
				$icon = 'icon-cancel';
				$text = 'Failed';
			}
			echo '<div class="alert alert-' . $alert . '"><i class="icon ' . $icon . '"></i>Installation and activation of the <b>' . $statu['type'] . ' ' . $statu['name'] . '</b> : ' . $text . '</div>';
		}

		return true;
	}
}
