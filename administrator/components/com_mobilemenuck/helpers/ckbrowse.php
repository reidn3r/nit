<?php
/**
 * @copyright	Copyright (C) 2017. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Cedric Keiflin - http://www.template-creator.com - http://www.joomlack.fr
 */

defined('_JEXEC') or die;

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

class CKBrowse {

	/*
	 * Get a list of folders and files 
	 */
	public static function getItemsList($type = 'image') {
		$input = \Joomla\CMS\Factory::getApplication()->input;

		$type = $input->get('type', $type, 'string');

		switch ($type) {
			case 'video' :
				$filetypes = array('.mp4', '.ogv', '.webm', '.MP4', '.OGV', '.WEBM');
				break;
			case 'audio' :
				$filetypes = array('.mp3', '.ogg', '.MP3', '.OGG');
				break;
			case 'image' :
			default :
				$filetypes = array('.jpg', '.jpeg', '.png', '.gif', '.tiff', '.JPG', '.JPEG', '.PNG', '.GIF', '.TIFF', '.ico');
				break;
		}

		$folder = $input->get('folder', 'images', 'string');
		$tree = new stdClass();

		// list the files in the root folder
		self::getImagesInFolder(JPATH_SITE . '/' . $folder, $tree, implode('|', $filetypes), 1);

		// look for all folder and files
		self::getSubfolder(JPATH_SITE . '/' . $folder, $tree, implode('|', $filetypes), 2);
		$tree = self::prepareList($tree);

		return $tree;
	}

	/* 
	 * List the subfolders and files according to the filter
	 */
	private static function getSubfolder($folder, &$tree, $filter, $level) {
		$folders = \Joomla\CMS\Filesystem\Folder::folders($folder, '.', $recurse = false, $fullpath = true);
		natcasesort($folders);

		if (! count($folders)) return;

		foreach ($folders as $f) {
			// list all authorized files from the folder
			self::getImagesInFolder($f, $tree, $filter, $level);

			// recursive loop
			self::getSubfolder($f, $tree, $filter, $level+1);
		}
		return;
	}
	
	/* 
	 * List the subfolders and files according to the filter
	 */
	private static function getImagesInFolder($f, &$tree, $filter, $level) {

			// list all authorized files from the folder
			$files = \Joomla\CMS\Filesystem\Folder::files($f, $filter, $recurse = false, $fullpath = false);
			natcasesort($files);
			$fName = \Joomla\CMS\Filesystem\File::makeSafe(str_replace(JPATH_SITE, '', $f));
			$tree->$fName = new stdClass();
			$name = explode('/', $f);
			$name = end($name);
			$tree->$fName->name = $name;
			$tree->$fName->path = $f;
			$tree->$fName->files = $files;
			$tree->$fName->level = $level;
		}

	/* 
	 * Set level diff and check for depth
	 */
	private static function prepareList($items) {
		if (! $items) return $items;

		$lastitem = 0;
		foreach ($items as $i => $item)
		{
			self::prepareItem($item);

			if ($item->level != 0) {
				if (isset($items->$lastitem))
				{
					$items->$lastitem->deeper     = ($item->level > $items->$lastitem->level);
					$items->$lastitem->shallower  = ($item->level < $items->$lastitem->level);
					$items->$lastitem->level_diff = ($items->$lastitem->level - $item->level);
				}
			}
			$lastitem = $i;

			
		}

		// for the last item
		if (isset($items->$lastitem))
		{
			$items->$lastitem->deeper     = (1 > $items->$lastitem->level);
			$items->$lastitem->shallower  = (1 < $items->$lastitem->level);
			$items->$lastitem->level_diff = ($item->level - 1);
		}

		return $items;
	}

	/* 
	 * Set the default values
	 */
	private static function prepareItem(&$item) {
		$item->deeper     = false;
		$item->shallower  = false;
		$item->level_diff = 0;
		$item->basepath = str_replace(JPATH_SITE, '', $item->path);
		$item->basepath = str_replace('\\', '/', $item->basepath);
		$item->basepath = trim($item->basepath, '/');
	}

	/**
	 * Get the file and store it on the server
	 * 
	 * @return mixed, the method return
	 */
	public static function ajaxAddPicture() {
		// check why it does not work
		if (! \Joomla\CMS\Session\Session::checkToken('get')) {
			$msg = \Joomla\CMS\Language\Text::_('JINVALID_TOKEN');
			echo '{"error" : "' . $msg . '"}';
			exit;
		}

		$app = \Joomla\CMS\Factory::getApplication();
		$input = $app->input;
		$file = $input->files->get('file', '', 'array');
		$imgpath = '/' . trim($input->get('path', '', 'string'), '/') . '/';

		if (!is_array($file)) {
			$msg = \Joomla\CMS\Language\Text::_('CK_NO_FILE_RECEIVED');
			echo '{"error" : "' . $msg . '"}';
			exit;
		}

		$filename = \Joomla\CMS\Filesystem\File::makeSafe($file['name']);

		// check the file extension // TODO recup preg_match de local dev
		// if (\Joomla\CMS\Filesystem\File::getExt($filename) != 'jpg') {
			// $msg = \Joomla\CMS\Language\Text::_('CK_NOT_JPG_FILE');
			// echo '{"error" : "'  $msg  '"}';
			// exit;
		// }

		//Set up the source and destination of the file
		$src = $file['tmp_name'];

		// check if the file exists
		if (!$src || !\Joomla\CMS\Filesystem\File::exists($src)) {
			$msg = \Joomla\CMS\Language\Text::_('CK_FILE_NOT_EXISTS');
			echo '{"error" : "' . $msg . '"}';
			exit;
		}

		// check if folder exists, if not then create it
		if (!\Joomla\CMS\Filesystem\Folder::exists(JPATH_SITE . $imgpath)) {
			if (!\Joomla\CMS\Filesystem\Folder::create(JPATH_SITE . $imgpath)) {
				$msg = \Joomla\CMS\Language\Text::_('CK_UNABLE_TO_CREATE_FOLDER') . ' : ' . $imgpath;
				echo '{"error" : "' . $msg . '"}';
				exit;
			}
		}

		// write the file
		if (! \Joomla\CMS\Filesystem\File::copy($src, JPATH_SITE . $imgpath . $filename)) {
			$msg = \Joomla\CMS\Language\Text::_('CK_UNABLE_WRITE_FILE');
			echo '{"error" : "' . $msg . '"}';
			exit;
		}
		echo '{"img" : "' . $imgpath . $filename . '", "filename" : "' . $filename . '"}';
		exit;
	}
}
