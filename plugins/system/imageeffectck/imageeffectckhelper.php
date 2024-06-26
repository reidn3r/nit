<?php

/**
 * @copyright	Copyright (C) 2016 Cédric KEIFLIN alias ced1870
 * http://www.joomlack.fr
 * http://www.template-creator.com
 * @license		GNU/GPL
 * */

defined('_JEXEC') or die('Restricted access');

class ImageeffectckHelper {

	private static $effectsList;

	public static $minParamsVersion = '2.0.0';
	/**
	 * 
	 * @param type $version (force to 1 for B/C)
	 * @return type
	 */
	public static function getEffectsList($version = 1) {
//		if (empty(self::$effectsList)) {
			if ($version == 1) {
				// B/C list
				self::$effectsList = array(
					 "effectck-lily"
					,"effectck-oscar" 
					,"effectck-sadie"
					,"effectck-honey"
					,"effectck-layla"
					,"effectck-zoe"
					,"effectck-marley"
					,"effectck-ruby"
					,"effectck-roxy"
					,"effectck-bubba"
					,"effectck-romeo"
					,"effectck-dexter"
					,"effectck-sarah"
					,"effectck-chico"
					,"effectck-milo"
					,"effectck-julia"
					,"effectck-goliath"
					,"effectck-selena"
					,"effectck-apollo"
					,"effectck-steve"
					,"effectck-moses"
					,"effectck-jazz"
					,"effectck-ming"
					,"effectck-duke"
					,"effectck-fadeck"
					,"effectck-edafck"
					,"effectck-puffck"
					);
			} else {
				self::$effectsList = array(
				"lily" => "effectck-lily"
				, "oscar" => "effectck-oscar" 
				, "sadie" => "effectck-sadie"
				, "honey" => "effectck-honey"
				, "layla" => "effectck-layla"
				, "zoe" => "effectck-zoe"
				, "marley" => "effectck-marley"
				, "ruby" => "effectck-ruby"
				, "roxy" => "effectck-roxy"
				, "bubba" => "effectck-bubba"
				, "romeo" => "effectck-romeo"
				, "dexter" => "effectck-dexter"
				, "sarah" => "effectck-sarah"
				, "chico" => "effectck-chico"
				, "milo" => "effectck-milo"
				, "julia" => "effectck-julia"
				, "goliath" => "effectck-goliath"
				, "selena" => "effectck-selena"
				, "apollo" => "effectck-apollo"
				, "steve" => "effectck-steve"
				, "moses" => "effectck-moses"
				, "jazz" => "effectck-jazz"
				, "ming" => "effectck-ming"
				, "duke" => "effectck-duke"
				, "fadeck" => "effectck-fadeck"
				, "edafck" => "effectck-edafck"
				, "puffck" => "effectck-puffck"
				, "flip-left" => "effectck-flip-left"
				, "flip-right" => "effectck-flip-right"
				, "flip-top" => "effectck-flip-top"
				, "flip-bottom" => "effectck-flip-bottom"
				, "circle" => "effectck-circle"
				, "circle-b" => "effectck-circle-b"
				, "circle-2" => "effectck-circle-2"
				, "circle-3" => "effectck-circle-3"
				, "circle-4" => "effectck-circle-4"
				, "circle-5" => "effectck-circle-5"
				, "circle-6" => "effectck-circle-6"
				, "circle-7" => "effectck-circle-7"
				, "circle-8" => "effectck-circle-8"
				, "circle-9" => "effectck-circle-9"
				, "circle-10" => "effectck-circle-10"
				, "circle-11" => "effectck-circle-11"
				, "circle-12" => "effectck-circle-12"
				, "circle-13" => "effectck-circle-13"
				, "circle-14" => "effectck-circle-14"
				, "circle-15" => "effectck-circle-15"
				, "circle-16" => "effectck-circle-16"
				, "circle-17" => "effectck-circle-17"
				, "circle-18" => "effectck-circle-18"
				, "circle-19" => "effectck-circle-19"
				, "circle-20" => "effectck-circle-20"
				, "circle-21" => "effectck-circle-21"
				, "circle-22" => "effectck-circle-22"
				, "circle-23" => "effectck-circle-23"
				, "circle-24" => "effectck-circle-24"
				, "circle-25" => "effectck-circle-25"
				, "circle-26" => "effectck-circle-26"
				, "circle-27" => "effectck-circle-27"
				, "circle-28" => "effectck-circle-28"
				, "circle-29" => "effectck-circle-29"
				, "circle-30" => "effectck-circle-30"
				, "circle-31" => "effectck-circle-31"
				, "circle-32" => "effectck-circle-32"
				, "circle-33" => "effectck-circle-33"
				, "circle-34" => "effectck-circle-34"
				, "circle-35" => "effectck-circle-35"
				, "circle-36" => "effectck-circle-36"
				, "circle-37" => "effectck-circle-37"
				, "circle-38" => "effectck-circle-38"
				, "circle-39" => "effectck-circle-39"
				);
			}
			// new feature introduced in V2
			if ($version > 2) {
				if ($override = self::getOverrideList()) {
					if ($override->onlythislist == "true") {
						self::$effectsList = $override->effectscklist;
					} else {
						self::$effectsList = array_merge(self::$effectsList, (array)$override->effectscklist);
					}
				}
				if ($customList = self::getCustomStylesList()) {
					if (\Joomla\CMS\Component\ComponentHelper::getParams('com_imageeffectck')->get('customlistonly', '0') == '1') {
						self::$effectsList = $customList;
					} else {
						self::$effectsList = array_merge(self::$effectsList, $customList);
					}
					if (file_exists(JPATH_SITE . '/administrator/components/com_imageeffectck/helpers/helper.php')) {
						include_once JPATH_SITE . '/administrator/components/com_imageeffectck/helpers/helper.php';
						ImageeffectckHelper2::loadAssets();
					}
				}
			}
//		}

		return self::$effectsList;
	}

	private static function getOverrideList() {
		$overridelistsrc = JPATH_ROOT . '/templates/' . self::getDefaultTemplate() . '/css/plg_system_imageeffectck/imageeffectck.json';
		if (file_exists($overridelistsrc)) {
			$overridelistjson = @file_get_contents($overridelistsrc);
			if ($overridelistjson) {
				try {
					$tmp = json_decode($overridelistjson);
					return $tmp;
				} catch (Exception $e) {
					echo 'Error when getting the Override list from Image Effect CK : ',  $e->getMessage(), "\n";
				}
			}
		}
		return false;
	}

	// TODO : à intégrer pour récupérer liste des custom styles
	private static function getCustomStylesList() {
		$db = \Joomla\CMS\Factory::getDBO();
		$query = "SELECT id,name FROM #__imageeffectck_styles WHERE state = 1";
		$db->setQuery($query);
		$styles = $db->loadObjectList();
		$list = array();
		foreach ($styles as $style) {
			$list[$style->name] = 'effectck-' . $style->id;
		}
		return $list;
	}

	private static function getDefaultTemplate() {
		$db = \Joomla\CMS\Factory::getDBO();
		$query = "SELECT template FROM #__template_styles WHERE client_id = 0 AND home = 1";
		$db->setQuery($query);
		return $db->loadResult();
	}
}