<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

$element_options	= RSPageBuilderHelper::escapeHtmlArray($displayData['options']);
$class				= 'rspbld-spacer';
$style				= array();

// Spacer class
if (!empty($element_options['class'])) {
	$class .= ' '.$element_options['class'];
}

// Spacer visibility
if (!empty($element_options['hidden_desktop'])) {
	$class .= ' hidden-desktop';
}
if (!empty($element_options['hidden_tablet'])) {
	$class .= ' hidden-tablet';
}
if (!empty($element_options['hidden_phone'])) {
	$class .= ' hidden-phone';
}

// Spacer style
if (!empty($element_options['height'])) {
	$style['height'] = $element_options['height'];
}

// Build Spacer HTML
?>

<div class="<?php echo $class; ?>"<?php echo RSPageBuilderHelper::buildStyle($style); ?>></div>