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
if (!empty($element_options['hidden_phone'])) {
	$class .= ' d-none d-md-block';
}
if (!empty($element_options['hidden_tablet'])) {
	$class .= ' d-md-none d-xl-block';
}
if (!empty($element_options['hidden_desktop'])) {
	$class .= ' d-xl-none';
}

// Spacer style
if (!empty($element_options['height'])) {
	$style['height'] = $element_options['height'];
}

// Build Spacer HTML
?>

<div class="<?php echo $class; ?>"<?php echo RSPageBuilderHelper::buildStyle($style); ?>></div>