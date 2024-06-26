<?php
/**
 * Flex @package Helix3 Framework
 * Template Name - Flex
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
defined('_JEXEC') or die('Restricted Access');

//Helix3
helix3::addLess('frontend-edit', 'frontend-edit');
helix3::addJS('frontend-edit.js');

//Add Helix to include "above-component" and "below-component" module positions
$this->helix3 = helix3::getInstance();

$data = $displayData;

$output ='';

$output .= '<div id="sp-component" class="' . $data->className . '">';

$output .= '<div class="sp-column ' . ($data->settings->custom_class) . '">';
$output .= '<jdoc:include type="message" />';

if ($this->helix3->countModules('above-component')) {
$output .= '<div class="above-component"><jdoc:include type="modules" name="above-component" /></div>';
}
$output .= '<jdoc:include type="component" />';
if ($this->helix3->countModules('below-component')) {
$output .= '<div class="below-component"><jdoc:include type="modules" name="below-component" /></div>';
}
$output .= '</div>';

$output .= '</div>';


echo $output;

