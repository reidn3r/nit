<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

class com_rspagebuilderInstallerScript
{
	public function preflight($type, $parent) {
		try {
			$minJoomla = '3.9.27';

			if (!class_exists('\\Joomla\\CMS\\Version')) {
				throw new Exception(sprintf('Please upgrade to at least Joomla! %s before continuing!', $minJoomla));
			}

			$jversion = new \Joomla\CMS\Version;
			
			if (!$jversion->isCompatible($minJoomla)) {
				throw new Exception(sprintf('Please upgrade to at least Joomla! %s before continuing!', $minJoomla));
			}

			if ($jversion->isCompatible('5.0')) {
				if (!\Joomla\CMS\Plugin\PluginHelper::isEnabled('behaviour', 'compat')) {
					throw new Exception('To install RSPageBuilder! in Joomla! 5 you need to enable the Behaviour - Backward Compatibility plugin. Keep this plugin enabled at all times!');
				}
			}
		} catch (Exception $e) {
			if (class_exists('\Joomla\CMS\Factory')) {
				$app = \Joomla\CMS\Factory::getApplication();
			} elseif (class_exists('JFactory')) {
				$app = JFactory::getApplication();
			}

			if (!empty($app)) {
				$app->enqueueMessage($e->getMessage(), 'error');
			}
			
			return false;
		}
		
		return true;
	}
	
	public function postflight($type, $parent) {
		
		if ($type == 'update') {
			$db = JFactory::getDbo();
			
			// Check for the 'animate' column
			$db->setQuery("SHOW COLUMNS FROM `#__rspagebuilder` LIKE 'animate'");
			
			if (!$db->loadResult()) {
				$db->setQuery("ALTER TABLE `#__rspagebuilder` ADD `animate` tinyint(3) NOT NULL DEFAULT '1' AFTER `full_width`");
				$db->execute();
			}
			
			// Check for the 'content_plugins' column
			$db->setQuery("SHOW COLUMNS FROM `#__rspagebuilder` LIKE 'content_plugins'");
			
			if (!$db->loadResult()) {
				$db->setQuery("ALTER TABLE `#__rspagebuilder` ADD `content_plugins` tinyint(3) NOT NULL DEFAULT '0' AFTER `animate`");
				$db->execute();
			}
			
			// Check for mb4 UTF8 support
			$hasUTF8mb4Support = $db->hasUTF8mb4Support();
			
			$db->setQuery("SHOW TABLE STATUS WHERE name='".$db->getPrefix()."rspagebuilder'");
			
			if ($tableDetails = $db->loadObject()) {
				
				// Change table collation
				if ($hasUTF8mb4Support) {						
					if (strpos(strtolower($tableDetails->Collation), 'utf8_general') !== false) {
						$db->setQuery("ALTER TABLE `#__rspagebuilder` DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci");
						$db->execute();
					}
					
					if ($fields = $db->getTableColumns($db->getPrefix().'rspagebuilder', false)) {
						foreach ($fields as $field) {
							$field_type	= strtolower($field->Type);
							$collation	= $field->Collation ? strtolower($field->Collation) : '';
							
							if ($hasUTF8mb4Support && strpos($collation, 'utf8_general') !== false && (strpos($field_type, 'varchar') !== false || strpos($field_type, 'text') !== false)) {
								$db->setQuery("ALTER TABLE `#__rspagebuilder` CHANGE ".$db->qn($field->Field)." ".$db->qn($field->Field)." ".$field->Type." CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
								$db->execute();
							}
						}
					}
				}
			}
			
			// Change Open Graph description type
			$db->setQuery("SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '" . $db->getPrefix() . "rspagebuilder' AND COLUMN_NAME = 'open_graph_description'");
			
			if ($db->loadResult() != 'text') {
				$db->setQuery("ALTER TABLE `#__rspagebuilder` MODIFY `open_graph_description` TEXT");
				$db->execute();
			}
		} else if ($type == 'uninstall') {
			return true;
		}
?>

<style type="text/css">
.j-main-container > .container-fluid > .col-md-12 > strong {
	display: block;
	margin-top: 15px;
}
.version-history {
	margin: 0 0 2em 0;
	padding: 0;
	list-style-type: none;
}
.version-history > li {
	margin: 0 0 0.5em 0;
	padding: 0 0 0 4em;
}
.version,
.version-new,
.version-fixed,
.version-upgraded {
	float: left;
	font-size: 0.8em;
	margin-left: -4.9em;
	width: 4.5em;
	color: white;
	text-align: center;
	font-weight: bold;
	text-transform: uppercase;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
}
.version {
	background: #000;
}
.version-new {
	background: #7dc35b;
}
.version-fixed {
	background: #e9a130;
}
.version-upgraded {
	background: #61b3de;
}
.installer-left {
	margin: 30px 30px 30px 0px;
	width: 230px;
}
.installer-right {
	margin: 30px 0;
}
.installer-left img, .installer-right img {
	width: 100%;
}
.col-md-12 .installer-left, .col-md-12 .installer-right {
	display: inline-block;
	vertical-align: top;
}
.span12 .installer-left, .span12 .installer-right {
	float: left;
}
@media (max-width: 979px) {
	.installer-left {
		margin: 30px 0px 30px 0px;
		text-align: center;
		width: 100%;
	}
	.installer-right {
		margin: 0px 0px 30px 0px;
		width: 100%;
	}
	.col-md-12 .installer-left, .col-md-12 .installer-right {
		display: block;
	}
	.span12 .installer-left, .span12 .installer-right {
		float: none;
	}
}
</style>
	<div class="installer-left">
		<img src="../media/com_rspagebuilder/images/rspagebuilder.png" alt="RSPageBuilder!" />
	</div>
	<div class="installer-right">
		<h2>RSPageBuilder! v2.0.15 Changelog</h2>
		<ul class="version-history">
			<li><span class="version-fixed">Fix</span> Image upload field did not work properly when using cache for Media Manager.</li>
		</ul>
		<a class="btn btn-success" href="index.php?option=com_rspagebuilder">Start using RSPageBuilder!</a>
		<a class="btn btn-info" href="https://www.rsjoomla.com/support/documentation/rspagebuilder.html" target="_blank">Read the RSPageBuilder! User Guide</a>
		<a class="btn btn-warning" href="http://www.rsjoomla.com/customer-support/tickets.html" target="_blank">Get Support!</a>
	</div>
<?php
	}
}