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
$app = Factory::getApplication();

//Load Helix
$helix3_path = JPATH_PLUGINS.'/system/helix3/core/helix3.php';

if (file_exists($helix3_path)) {
    require_once($helix3_path);
    $this->helix3 = Helix3::getInstance();
} else {
    die('Please install and activate helix plugin');
}

//custom css file
$custom_css_path = JPATH_ROOT . '/templates/' . $this->template . '/css/custom.css';

// Remove the generator meta tag
if($this->helix3->getParam('remove_joomla_generator')) {
  $doc->setGenerator(null);
}

//Comingsoon Logo
if ($logo_image = $this->params->get('comingsoon_logo'))
{
	$logo = Uri::root() . '/' .  $logo_image;
	$path = JPATH_ROOT . '/' .  $logo_image;
}
else
{
    $logo = $this->baseurl . '/templates/' . $this->template . '/images/presets/preset1/logo.png';
    $path = JPATH_ROOT . '/templates/' . $this->template . '/images/presets/preset1/logo.png';
}

if (file_exists($path))
{
	$image 		 = new JImage( $path );
	$logo_width  = $image->getWidth();
	$logo_height = $image->getHeight();
}
else
{
	$logo_width 	= '';
	$logo_height = '';
}

$comingsoon_title = $this->params->get('comingsoon_title');
if( $comingsoon_title ) {
	$doc->setTitle( $comingsoon_title . ' | ' . $app->get('sitename') );
}

$comingsoon_date = explode('-', $this->params->get("comingsoon_date"));
$custom_logo_class = '';

//Load jQuery
//JHtml::_('jquery.framework');
?>
<!DOCTYPE html>
<html class="sp-comingsoon" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    if($favicon = $this->helix3->getParam('favicon')) {
        $doc->addFavicon( Uri::base(true) . '/' .  $favicon);
    } else {
        $doc->addFavicon( $this->helix3->getTemplateUri() . '/images/favicon.ico' );
    }
    ?>
<jdoc:include type="head" />
    <?php
	
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

    	// has exist custom.css then load it
    	if (file_exists($custom_css_path))
		{
			$this->helix3->addCSS('custom.css');
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
		
		//Custom CSS
		if ($custom_css = $this->helix3->getParam('custom_css')) {
			$doc->addStyledeclaration($custom_css);
		}
		
		//Custom JS
		if ($custom_js = $this->helix3->getParam('custom_js')) {
			$doc->addScriptdeclaration($custom_js);
		}
		
//Custom background image
if($comingsoon_bg_image = $this->helix3->getParam('comingsoon_bg_image')) {
	
	$comingsoon_bg = 'background-color: transparent!important;';
    $comingsoon_bg .= 'background-image: url(' . Uri::base(true ) . '/' . $comingsoon_bg_image . ');';
    $comingsoon_bg .= 'background-repeat: no-repeat;';
    $comingsoon_bg .= 'background-size: cover;';
    $comingsoon_bg .= 'background-attachment: fixed;';
    $comingsoon_bg .= 'background-position: 50% 50%;';
    $comingsoon_bg = '.sp-comingsoon body {' . $comingsoon_bg . '}.sp-comingsoon body a.logo{background: rgba(0,0,0,0.6);}.sp-comingsoon body a.logo + .fa-clock{ opacity:0.57;}.sp-comingsoon body a.logo:hover + .fa-clock{opacity: 0.85}'; 

    $doc->addStyledeclaration( $comingsoon_bg );
}

//Body Font
$webfonts = array();

if( $this->params->get('enable_body_font') ) {
    $webfonts['body'] = $this->params->get('body_font');
}

//Heading1 Font
if( $this->params->get('enable_h1_font') ) {
    $webfonts['h1'] = $this->params->get('h1_font');
}

$this->helix3->addGoogleFont($webfonts);

$comingsoon_bg_image != '' ? $comingsoon_bg_image_class = ' class="with-bckg-img text-shadow"' : $comingsoon_bg_image_class = '';

?>
</head>
<body<?php echo $comingsoon_bg_image_class; ?>>
           <?php if( $this->helix3->getParam('comingsoon_logo') ) { ?>
           		<a class="logo" href="<?php echo $this->baseurl; ?>/"><div class="backhome hidden-xs hidden-sm"><i class="fas fa-angle-left"></i> <?php echo Text::_('HELIX_GO_BACK'); ?></div>
				<img style="max-height:150px;" class="sp-default-logo<?php echo $custom_logo_class ?>" src="<?php echo $this->helix3->getParam('comingsoon_logo') ?>" alt="<?php echo $app->get('sitename'); ?>">
                </a>
			<?php } else { ?>
				<?php if( $this->helix3->getParam('logo_image') ) { ?>
                    <a class="logo" href="<?php echo $this->baseurl; ?>/"><div class="backhome hidden-xs hidden-sm"><i class="fas fa-angle-left"></i> <?php echo Text::_('HELIX_GO_BACK'); ?></div>
                    <img style="max-height:150px;" class="sp-default-logo<?php echo $custom_logo_class ?>" src="<?php echo $this->helix3->getParam('logo_image') ?>" alt="<?php echo $app->get('sitename'); ?>">
                    </a>
                <?php } else { ?>
                    <a class="logo" href="<?php echo $this->baseurl; ?>/"><div class="backhome hidden-xs hidden-sm"><i class="fas fa-angle-left"></i> <?php echo Text::_('HELIX_GO_BACK'); ?></div><img style="width:150px;height:50%;" class="sp-default-logo<?php echo $custom_logo_class ?>" src="<?php echo $this->helix3->getTemplateUri() ?>/images/presets/<?php echo $this->helix3->Preset() ?>/logo@2x.png" alt="<?php echo $app->get('sitename'); ?>"></a>          
                <?php } ?>         
			<?php } ?>
            <div class="far fa-clock"></div>
<div class="sp-comingsoon-wrap">	
	<div class="container">
		<div class="text-center">
			<div id="sp-comingsoon">
                
				<?php if( $comingsoon_title ) { ?>
					<h1 class="sp-comingsoon-title">
						<?php echo $comingsoon_title; ?>
					</h1>
				<?php } ?>

				<?php if( $this->params->get('comingsoon_content') ) { ?>
					<div class="sp-comingsoon-content">
						<?php echo $this->params->get('comingsoon_content'); ?>
					</div>
				<?php } ?>

				<div id="sp-comingsoon-countdown" class="sp-comingsoon-countdown">
					
				</div>

				<?php if($this->countModules('comingsoon')) { ?>
				<div class="sp-position-comingsoon">
					<jdoc:include type="modules" name="comingsoon" style="sp_xhtml" />
				</div>
				<?php } ?>

				<?php
				//Social Icons
				$facebook 	= $this->helix3->getParam('facebook');
				$twitter  	= $this->helix3->getParam('twitter');
				$googleplus = $this->helix3->getParam('googleplus');
				$instagram  = $this->helix3->getParam('instagram');
				$pinterest 	= $this->helix3->getParam('pinterest');
				$youtube 	= $this->helix3->getParam('youtube');
				$linkedin 	= $this->helix3->getParam('linkedin');
				$dribbble 	= $this->helix3->getParam('dribbble');
				$behance 	= $this->helix3->getParam('behance');
				$skype 		= $this->helix3->getParam('skype');
				$whatsapp 	= $this->helix3->getParam('whatsapp');
				$flickr 	= $this->helix3->getParam('flickr');
				$vk 		= $this->helix3->getParam('vk');

				if( $this->helix3->getParam('show_social_icons') && ( $facebook || $twitter || $googleplus || $instagram || $pinterest || $youtube || $linkedin || $dribbble || $behance || $skype || $whatsapp || $flickr || $vk ) ) {
					$html  = '<ul class="social-icons">';

					if( $facebook ) {
						$html .= '<li><a target="_blank" href="'. $facebook .'" aria-label="facebook"><i class="fab fa-facebook-f" aria-hidden="true"></i></a></li>';
					}
					if( $twitter ) {
						$html .= '<li><a target="_blank" href="'. $twitter .'" aria-label="twitter"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>';
					}
					if( $googleplus ) {
						$html .= '<li><a target="_blank" href="'. $googleplus .'" aria-label="GooglePlus"><i class="fab fa-google-plus-g" aria-hidden="true"></i></a></li>';
					}
					if( $instagram ) {
						$html .= '<li ><a target="_blank" href="'. $instagram .'" aria-label="Instagram"><i class="fab fa-instagram" aria-hidden="true"></i></a></li>';
					}
					if( $pinterest ) {
						$html .= '<li><a target="_blank" href="'. $pinterest .'" aria-label="Pinterest"><i class="fab fa-pinterest" aria-hidden="true"></i></a></li>';
					}
					if( $youtube ) {
						$html .= '<li><a target="_blank" href="'. $youtube .'" aria-label="Youtube"><i class="fab fa-youtube" aria-hidden="true"></i></a></li>';
					}
					if( $linkedin ) {
						$html .= '<li><a target="_blank" href="'. $linkedin .'" aria-label="LinkedIn"><i class="fab fa-linkedin" aria-hidden="true"></i></a></li>';
					}
					if( $dribbble ) {
						$html .= '<li><a target="_blank" href="'. $dribbble .'" aria-label="Dribbble"><i class="fab fa-dribbble" aria-hidden="true"></i></a></li>';
					}
					if( $behance ) {
						$html .= '<li><a target="_blank" href="'. $behance .'" aria-label="Behance"><i class="fab fa-behance" aria-hidden="true"></i></a></li>';
					}
					if( $flickr ) {
						$html .= '<li><a target="_blank" href="'. $flickr .'" aria-label="Flickr"><i class="fab fa-flickr" aria-hidden="true"></i></a></li>';
					}
					if( $vk ) {
						$html .= '<li><a target="_blank" href="'. $vk .'" aria-label="VK"><i class="fab fa-vk" aria-hidden="true"></i></a></li>';
					}
					if( $skype ) {
						$html .= '<li><a href="skype:'. $skype .'?chat" aria-label="Skype"><i class="fab fa-skype" aria-hidden="true"></i></a></li>';
					}
					if( $whatsapp ) {
						$html .= '<li><a href="whatsapp://send?abid='. $whatsapp .'&text=Hi" aria-label="WhatsApp"><i class="fab fa-whatsapp" aria-hidden="true"></i></a></li>';
					}

					$html .= '<ul>';

					echo $html;
				}
				?>
			</div>
		</div>
	</div>
</div>
<?php 
// Add JS and minify
	$countdown_js = 'jQuery(function($){
		$(\'#sp-comingsoon-countdown\').countdown(\''.trim($comingsoon_date[2]).'/'.trim($comingsoon_date[1]).'/'.trim($comingsoon_date[0]).'\', function(event) {$(this).html(event.strftime(\'<div class="days"><span class="number">%-D</span><span class="string">%!D:'.Text::_("HELIX_DAY").','.Text::_("HELIX_DAYS").';</span></div><div class="hours"><span class="number">%H</span><span class="string">%!H:'.Text::_("HELIX_HOUR").','.Text::_("HELIX_HOURS").';</span></div><div class="minutes"><span class="number">%M</span><span class="string">%!M:'.Text::_("HELIX_MINUTE").','.Text::_("HELIX_MINUTES").';</span></div><div class="seconds"><span class="number">%S</span><span class="string">%!S:'.Text::_("HELIX_SECOND").','.Text::_("HELIX_SECONDS").';</span></div>\'));
		});
	});'; 
	$countdown_js = preg_replace(array('/([\s])\1+/', '/[\n\t]+/m'), '', $countdown_js); // Remove whitespace
	$doc->addScriptdeclaration($countdown_js);	
?>
</body>
</html>