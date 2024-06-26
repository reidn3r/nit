<?php
/**
 * Flex @package Helix Ultimate Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Factory;

$doc = Factory::getDocument();
$params = Factory::getApplication()->getTemplate('true')->params;

$app = Factory::getApplication();
$menu = $app->getMenu()->getActive();

//Load Helix
$helix3_path = JPATH_PLUGINS.'/system/helix3/core/helix3.php';

if (file_exists($helix3_path)) {
    require_once($helix3_path);
    $this->helix3 = Helix3::getInstance();
} else {
    die('Please install and activate helix plugin');
}

// Remove the generator meta tag
if($params->get('remove_joomla_generator')) {
  $doc->setGenerator(null);
}

//Favicon
if($favicon = $params->get('favicon')) {
    $doc->addFavicon( Uri::base(true) . '/' .  $favicon);
} else {
    $doc->addFavicon( $this->baseurl . '/templates/' . $this->template . '/images/favicon.ico' );
}
/*
$this->helix3->addCSS('bootstrap.min.css') // CSS Files
		->addCSS('joomla-fontawesome.min.css, font-awesome-v4-shims.min.css')
		->lessInit()->setLessVariables(array(
			'preset' => $this->helix3->Preset(),
			'bg_color' => $this->helix3->PresetParam('_bg'),
			'text_color' => $this->helix3->PresetParam('_text'),
			'major_color' => $this->helix3->PresetParam('_major')
		))
		->addLess('master', 'template')
		->addLess('presets',  'presets/'.$this->helix3->Preset())
		->addJS('bootstrap.min.js, jquery.easing.min.js, main.js, jquery.countdown.min.js');
*/
//Stylesheets
$custom_css_path = JPATH_ROOT . '/templates/' . $this->template . '/css/custom.css';
if (file_exists($custom_css_path)) {
	$doc->addStylesheet( $this->baseurl . '/templates/' . $this->template . '/css/custom.css' );
}
$megabgcolor = ($this->helix3->PresetParam('_megabg')) ? $this->helix3->PresetParam('_megabg') : '#ffffff';
	$megabgtx = ($this->helix3->PresetParam('_megatx')) ? $this->helix3->PresetParam('_megatx') : '#333333';

	$preloader_bg = ($this->helix3->getParam('preloader_bg')) ? $this->helix3->getParam('preloader_bg') : '#f5f5f5';
	$preloader_tx = ($this->helix3->getParam('preloader_tx')) ? $this->helix3->getParam('preloader_tx') : '#f5f5f5';
    $this->helix3->addCSS('bootstrap.min.css, joomla-fontawesome.min.css, font-awesome-v4-shims.min.css')
		->lessInit()->setLessVariables(array(
			'preset' => $this->helix3->Preset(),
			'bg_color' => $this->helix3->PresetParam('_bg'),
			'text_color' => $this->helix3->PresetParam('_text'),
			'major_color' => $this->helix3->PresetParam('_major'),
			'megabg_color' => $megabgcolor,
			'megatx_color' => $megabgtx,
			'preloader_bg' => $preloader_bg,
			'preloader_tx' => $preloader_tx,
		))
        ->addLess('master', 'template')
        ->addLess('presets',  'presets/'.$this->helix3->Preset())
    	->addJS('bootstrap.min.js, jquery.easing.min.js, main.js, jquery.countdown.min.js');


//Stylesheets
/*
$doc->addStylesheet( $this->baseurl . '/templates/' . $this->template . '/css/bootstrap.min.css' );
$doc->addStylesheet( $this->baseurl . '/templates/' . $this->template . '/css/font-awesome.min.css' );
$doc->addStylesheet( $this->baseurl . '/templates/' . $this->template . '/css/template.css' );
*/

$webfonts = array();
if( $params->get('enable_body_font') ) {
    $webfonts['body'] = $params->get('body_font');
}
//Heading1 Font
if( $params->get('enable_h1_font') ) {
    $webfonts['h1'] = $params->get('h1_font');
}
//Heading3 Font
if( $params->get('enable_h3_font') ) {
    $webfonts['h3'] = $params->get('h3_font');
}
$this->helix3->addGoogleFont($webfonts);

//Custom background image
if($error_bg_image = $this->helix3->getParam('error_bg_image')) {
	
	$error_bg = 'background-color: transparent;';
    $error_bg .= 'background-image: url(' . Uri::base(true ) . '/' . $error_bg_image . ');';
    $error_bg .= 'background-repeat: no-repeat;';
    $error_bg .= 'background-size: cover;';
    $error_bg .= 'background-attachment: fixed;';
    $error_bg .= 'background-position: 50% 50%;';
    $error_bg = '.error-page body .container {' . $error_bg . '}'; 

    $doc->addStyledeclaration( $error_bg );
}

$error_bg_image != '' ? $error_bg_image_class = ' with-bckg-img' : $error_bg_image_class = '';


$doc->setTitle($this->error->getCode() . ' - '.$this->title);
$header_contents = '';
if(!class_exists('JDocumentRendererHead')) {
  $head = JPATH_LIBRARIES . '/joomla/document/html/renderer/head.php';
  if(file_exists($head)) {
    require_once($head);
  }
}
$header_renderer = new JDocumentRendererHead($doc);
$header_contents = $header_renderer->render(null);

//background image
$error_bg = '';
$hascs_bg = '';
if ($err_bg = $params->get('error_bg')) {
	$error_bg 	= Uri::root() . $err_bg;
	$hascs_bg 	= 'has-background';
}

?>
<!DOCTYPE html>
<html class="error-page" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
	<head>
	    <meta name="viewport" content="width=device-width, initial-scale=1">
		<?php echo $header_contents; ?>
	</head>
	<body>
		<div class="error-page-inner<?php echo $error_bg_image_class; ?>">
            <div class="container">
            	<?php if ($error_bg_image) { ?>
				<p class="py-4"><i class="pe-7s-compass pe-va"></i></p>
                <?php } else { ?>
                <p><i class="fas fa-exclamation-triangle"></i></p>
                <?php } ?>
                <h1 class="error-code"> <?php echo $this->error->getCode(); ?></h1>
                <h3 class="error-code-message"><?php echo Text::_('HELIX_404'); ?></h3>
                <p class="error-message"><?php echo Text::_('HELIX_404_MESSAGE'); ?></p>
				<?php if ($this->debug) : ?>
					<div style="background:#fff;" class="my-5">
						<h3 class="py-5"><?php echo $this->error->getMessage(); ?></h3>
						<?php echo $this->renderBacktrace(); ?>
						<?php // Check if there are more Exceptions and render their data as well ?>
						<?php if ($this->error->getPrevious()) : ?>
							<?php $loop = true; ?>
							<?php // Reference $this->_error here and in the loop as setError() assigns errors to this property and we need this for the backtrace to work correctly ?>
							<?php // Make the first assignment to setError() outside the loop so the loop does not skip Exceptions ?>
							<?php $this->setError($this->_error->getPrevious()); ?>
							<?php while ($loop === true) : ?>
								<p><strong><?php echo Text::_('JERROR_LAYOUT_PREVIOUS_ERROR'); ?></strong></p>
								<p><?php echo htmlspecialchars($this->_error->getMessage(), ENT_QUOTES, 'UTF-8'); ?></p>
								<?php echo $this->renderBacktrace(); ?>
								<?php $loop = $this->setError($this->_error->getPrevious()); ?>
							<?php endwhile; ?>
							<?php // Reset the main error object to the base error ?>
							<?php $this->setError($this->error); ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>
                <a class="btn btn-error sppb-btn-3d btn-lg mt-2 mb-5" href="<?php echo $this->baseurl; ?>/"><i class="fas fa-angle-left"></i> <?php echo Text::_('HELIX_GO_BACK'); ?></a>
                <?php echo $doc->getBuffer('modules', '404', array('style' => 'sp_xhtml')); ?>
            </div>
		</div>
	</body>
</html>