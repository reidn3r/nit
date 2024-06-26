<?php
/**
 * Flex @package Helix Framework
 * Template Name - Flex
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
//no direct accees
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Text;

//Load the method jquery script.
//HTMLHelper::_('jquery.framework');

$doc = Factory::getDocument();
$app = Factory::getApplication();
$menu = $app->getMenu()->getActive();

//Load Helix
$helix3_path = JPATH_PLUGINS . '/system/helix3/core/helix3.php';

if (file_exists($helix3_path))
{
	require_once($helix3_path);
	$this->helix3 = helix3::getInstance();
}
else
{
	die('Please install and activate helix plugin');
}

// Remove the generator meta tag
if($this->params->get('remove_joomla_generator')) {
  $this->setGenerator(null);
}

//$doc->getWebAssetManager()->disableScript('jquery-noconflict');
//$doc->getWebAssetManager()->disableScript('jquery-migrate');

//Coming Soon
if ($this->helix3->getParam('comingsoon_mode'))
{
	header("Location: " . Route::_(Uri::root(true) . "/index.php?tmpl=comingsoon", false));
	exit();
}

//Class Classes
$body_classes = '';
if ($this->helix3->getParam('sticky_header'))
{
	$body_classes .= ' sticky-header';
}

$body_classes .= ($this->helix3->getParam('boxed_layout', 0)) ? ' layout-boxed' : ' layout-fluid';

if (isset($menu) && $menu)
{
	if ($menu->getParams()->get('pageclass_sfx'))
	{
		$body_classes .= ' ' . $menu->getParams()->get('pageclass_sfx');
	}
}

$body_classes .= ' off-canvas-menu-init';

//Body Background Image
if ($bg_image = $this->helix3->getParam('body_bg_image'))
{
	$body_style = 'background-image: url(' . JURI::base(true) . '/' . $bg_image . ');';
	$body_style .= 'background-repeat: ' . $this->helix3->getParam('body_bg_repeat') . ';';
	$body_style .= 'background-size: ' . $this->helix3->getParam('body_bg_size') . ';';
	$body_style .= 'background-attachment: ' . $this->helix3->getParam('body_bg_attachment') . ';';
	$body_style .= 'background-position: ' . $this->helix3->getParam('body_bg_position') . ';';
	$body_style = 'body.site {' . $body_style . '}';
	
	$doc->addStyledeclaration($body_style);
} else {
	$body_style = 'body.site {background-color:'.$this->helix3->PresetParam('_bg').';}';
	$doc->addStyledeclaration($body_style);
}

//Boxed Layout Width (Flex) 
if ($this->params->get('boxed_layout') == 1) { 
	$boxed_background_color = '';
	
	$boxed_sticky_header = '
	.layout-boxed .sticky,
	.layout-boxed .sticky .sticky__wrapper,
	.layout-boxed .sticky .sticky__wrapper .sp-megamenu-parent .sp-dropdown{
		max-width:'.$this->helix3->getParam('boxed_layout_width').'px;
		margin:0 auto;
	}';

	if ($this->params->get('boxed_background_color') != '') { 
		$boxed_background_color = 'background-color:'.$this->helix3->getParam('boxed_background_color').';box-shadow:0 0 7px rgba(0,0,0,0.2);';
	} 
	$body_innerwrapper_overflow = '';
	
	if ($this->helix3->getParam('boxed_layout_spacing') != 0) { 
		$boxed_layout_spacing = 'margin:' . $this->helix3->getParam('boxed_layout_spacing') . 'px auto;';
		$boxed_layout_spacing .= $boxed_background_color;
		$boxed_layout_spacing .= 'max-width:'.$this->helix3->getParam('boxed_layout_width').'px;';
		$boxed_layout_spacing = 'body.layout-boxed .body-wrapper {margin:-' . $this->helix3->getParam('boxed_layout_spacing') . 'px auto 0;padding:' . $this->helix3->getParam('boxed_layout_spacing') . 'px 0 0;}body.layout-boxed .body-innerwrapper {' . $boxed_layout_spacing . '}
		';
		$doc->addStyledeclaration($boxed_layout_spacing);
	} else {
		$boxed_layout_spacing = $boxed_background_color;
		$boxed_layout_spacing .= 'max-width:'.$this->helix3->getParam('boxed_layout_width').'px;';
		$boxed_layout_spacing = 'body.layout-boxed .body-innerwrapper {' . $boxed_layout_spacing . '}
		';
		$doc->addStyledeclaration($boxed_layout_spacing);
	}
} else { 
	$body_innerwrapper_overflow = ' body_innerwrapper_overflow';
	$boxed_sticky_header = '';
}

// SmoothScroll.js (Flex)
if ($this->params->get('smooth_scroll_version') == '0') { 
	$smooth_scroll_js = '';
} else if ($this->params->get('smooth_scroll_version') == '2') { 
	$smooth_scroll_js = 'SmoothScroll-1.4.9.js, ';
} else if ($this->params->get('smooth_scroll_version') == '3') { 
	$smooth_scroll_js = 'SmoothScroll-1.4.10.js, ';
} else {
	$smooth_scroll_js = 'SmoothScroll.js, ';
}

// Variables JS (Flex)
$js_vars = '
var sp_preloader = "' . $this->params->get('preloader') . '";
var sp_offanimation = "' . $this->params->get('offcanvas_animation') . '";
var stickyHeaderVar = "' . $this->params->get('sticky_header') . '";

';

// Sticky Header appear point (Flex)
if ($this->params->get('sticky_header') == 1) {
	$stickyHeaderAppearVar = ($this->helix3->getParam('sticky_header_appear_point')) ? 'var stickyHeaderAppearPoint = ' . $this->params->get('sticky_header_appear_point') . ';' : 'var stickyHeaderAppearPoint = 250;';
} else {
	$stickyHeaderAppearVar = '';
}

$all_js_vars = $js_vars . $stickyHeaderAppearVar;
$all_js_vars = preg_replace(array('/([\s])\1+/', '/[\n\t]+/m'), '', $all_js_vars); // Remove whitespace
$doc->addScriptdeclaration($all_js_vars);

//Custom CSS
if ($custom_css = $this->helix3->getParam('custom_css'))
{
	$doc->addStyledeclaration($custom_css);
}

//Custom JS
if ($custom_js = $this->helix3->getParam('custom_js'))
{
	$doc->addScriptdeclaration($custom_js);
}

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php $this->helix3->loadHead(); ?>
		<?php
			$megabgcolor = ($this->helix3->PresetParam('_megabg')) ? $this->helix3->PresetParam('_megabg') : '#ffffff';
			$megabgtx = ($this->helix3->PresetParam('_megatx')) ? $this->helix3->PresetParam('_megatx') : '#333333';

			$preloader_bg = ($this->helix3->getParam('preloader_bg')) ? $this->helix3->getParam('preloader_bg') : '#f5f5f5';
			$preloader_tx = ($this->helix3->getParam('preloader_tx')) ? $this->helix3->getParam('preloader_tx') : '#4a4a4a';
		

			// load css, less and js (Flex)
			$this->helix3->addCSS('bootstrap.min.css') // CSS Files
			->addCSS('joomla-fontawesome.min.css, font-awesome-v4-shims.min.css')
			->addJS('bootstrap.min.js, jquery.easing.min.js, main.js') // JS Files
			->lessInit()->setLessVariables(array(
				'preset' => $this->helix3->Preset(),
				'bg_color' => $this->helix3->PresetParam('_bg'),
				'text_color' => $this->helix3->PresetParam('_text'),
				'major_color' => $this->helix3->PresetParam('_major'),
				'preloader_bg' => $preloader_bg,
				'preloader_tx' => $preloader_tx,
			))
			->addLess('master', 'template');
		
				
			//RTL
			if ($this->direction == 'rtl')
			{
				$this->helix3->addCSS('bootstrap-rtl.min.css')
					->addLess('rtl', 'rtl');
			}
			
			$this->helix3->addLess('presets', 'presets/' . $this->helix3->Preset(), array('class' => 'preset'));
			
			//Before Head
			if ($before_head = $this->helix3->getParam('before_head')) {
				echo $before_head . "\n";
			}
		?>
	</head>
	
	<body class="<?php echo $this->helix3->bodyClass($body_classes); ?>">
	
		<?php // added class "body-wrapper". It was only "off-canvas-menu-wrap" before.(Flex) ?>
        <div class="body-wrapper off-canvas-menu-wrap">
            <div class="body-innerwrapper<?php echo $body_innerwrapper_overflow; ?>">
				<?php $this->helix3->generatelayout(); ?>
			</div>
		</div>
		
		<!-- Off Canvas Menu -->
		<div class="offcanvas-menu">
			<a href="#" class="close-offcanvas" aria-label="Close"><i class="fas fa-times" aria-hidden="true" title="<?php echo Text::_('HELIX_CLOSE_MENU'); ?>"></i></a>
			<div class="offcanvas-inner">
				<?php if ($this->helix3->countModules('offcanvas')) : ?>
					<jdoc:include type="modules" name="offcanvas" style="sp_xhtml" />
				<?php else : ?>
					<p class="alert alert-warning">
						<?php echo Text::_('HELIX_NO_MODULE_OFFCANVAS'); ?>
					</p>
				<?php endif; ?>
			</div>
		</div>
		<?php
		// Header (Flex)
		$header_height = ($this->helix3->getParam('header_height')) ? $this->helix3->getParam('header_height') : '90';
		$sticky_header_height = ($this->helix3->getParam('sticky_header_height')) ? $this->helix3->getParam('sticky_header_height') : '75';
		$header_link_color = ($this->helix3->getParam('header_link_color')) ? 'color:'. $this->helix3->getParam('header_link_color') : '';
		$header_active_link_color = ($this->helix3->getParam('header_active_link_color')) ? $this->helix3->getParam('header_active_link_color') : '';
		$headerbgcolor = ($this->helix3->getParam('headerbg')) ? 'background:'. $this->helix3->getParam('headerbg') .';' : '';
		$stickybgcolor = ($this->helix3->getParam('stickybg')) ? 'background:'. $this->helix3->getParam('stickybg') .';' : '';
		$mega_dropdown_bg = ($this->helix3->getParam('mega_dropdown_bg')) ? 'background:'. $this->helix3->getParam('mega_dropdown_bg') : '';
		$mega_dropdown_color = ($this->helix3->getParam('mega_dropdown_color')) ? 'color:'. $this->helix3->getParam('mega_dropdown_color') : '';
		$sticky_appearance_animation = ($this->helix3->getParam('sticky_appearance_animation')) ? '-webkit-animation-name:'. $this->helix3->getParam('sticky_appearance_animation') .';animation-name:'. $this->helix3->getParam('sticky_appearance_animation') .';' : '-webkit-animation-name:fade-in-down;animation-name:fade-in-down;';
		$sticky_appearance_none = ($this->helix3->getParam('sticky_appearance_animation') == 'none') ? '-webkit-transition:none;-moz-transition:none;-o-transition:none;transition:none;' : '';
		
		$sticky_header_link_color = ($this->helix3->getParam('sticky_header_link_color')) ? 'color:'. $this->helix3->getParam('sticky_header_link_color') : '';
		$sticky_header_active_link_color = ($this->helix3->getParam('sticky_header_active_link_color')) ? $this->helix3->getParam('sticky_header_active_link_color') : '';
		
		// Off-canvas
		$offcanvas_bg = ($this->helix3->getParam('offcanvas_bg')) ? 'background:'. $this->helix3->getParam('offcanvas_bg') : '';
		$offcanvas_color = ($this->helix3->getParam('offcanvas_color')) ? $this->helix3->getParam('offcanvas_color') : '';
		$offcanvas = '.offcanvas-menu{'. $offcanvas_bg .'}.offcanvas-menu ul li a{color: '. $offcanvas_color .'}.offcanvas-menu .offcanvas-inner .search input.inputbox{border-color: '. $offcanvas_color .'}';
		$doc->addStyledeclaration($offcanvas);
		
		$header_styling = '
		#sp-header .top-search-wrapper .icon-top-wrapper,
		#sp-header .top-search-wrapper .icon-top-wrapper >i:before,
		.sp-megamenu-wrapper > .sp-megamenu-parent >li >a,
		.sp-megamenu-wrapper #offcanvas-toggler,
		#sp-header .modal-login-wrapper span,
		#sp-header .ap-my-account i.pe-7s-user,
		#sp-header .ap-my-account .info-text,
		#sp-header .mod-languages,
		#sp-header .logo,
		#cart-menu,
		#cd-menu-trigger,
		.cd-cart,
		.cd-cart > i{  
			height:' . $header_height . 'px;
			line-height:' . $header_height . 'px;
		}
		.total_products{top:calc('. $header_height .'px / 2 - 22px);}
		#sp-header,
		.transparent-wrapper{
			height:' . $header_height . 'px;
			'.$headerbgcolor.'
		}
		.transparent,
		.sticky-top{
			'.$headerbgcolor.'
		}
		#sp-header #sp-menu .sp-megamenu-parent >li >a,
		#sp-header #sp-menu .sp-megamenu-parent li .sp-dropdown >li >a,
		#sp-header .top-search-wrapper .icon-top-wrapper i,
		#sp-header #cd-menu-trigger i,
		#sp-header .cd-cart i,
		#sp-header .top-search-wrapper{'. $header_link_color .'}
		#sp-header #sp-menu .sp-dropdown .sp-dropdown-inner{'. $mega_dropdown_bg .'}
		#sp-header #sp-menu .sp-dropdown .sp-dropdown-inner li.sp-menu-item >a,
		#sp-header #sp-menu .sp-dropdown .sp-dropdown-inner li.sp-menu-item.separator >a,
		#sp-header #sp-menu .sp-dropdown .sp-dropdown-inner li.sp-menu-item.separator >a:hover,
		#sp-header .sp-module-content ul li a,
		#sp-header .vm-menu .vm-title{'. $mega_dropdown_color .'}		
		';
		// Onepage
		if ($this->helix3->getParam('header_active_link_color') != '') { 
			$active_link_color = '
			#sp-header #sp-menu .sp-megamenu-parent >li.active a,
			#sp-header #sp-menu .sp-megamenu-parent >li.current-item >a,
            #sp-header #sp-menu .sp-megamenu-parent >li.current-item.active>a,
			#sp-header #sp-menu .sp-megamenu-parent >li.sp-has-child.active >a,	
			#offcanvas-toggler >i,
			#offcanvas-toggler >i:hover{color:'. $header_active_link_color .'}
			#sp-header #sp-menu .sp-megamenu-parent .sp-dropdown li.sp-menu-item.current-item>a,
			#sp-header #sp-menu .sp-megamenu-parent .sp-dropdown li.sp-menu-item.current-item.active>a,
			#sp-header #sp-menu .sp-megamenu-parent .sp-dropdown li.sp-menu-item.current-item.active:hover>a,
			#sp-header #sp-menu .sp-megamenu-parent .sp-dropdown li.sp-menu-item a:hover{
			  color: #fff;
			  background-color:'. $header_active_link_color .';
			}
			#sp-header.onepage .sp-megamenu-parent li.active a,
			#sp-header.onepage .sp-megamenu-parent li.active:first-child >a.page-scroll{
				color:'. $header_active_link_color .';
				border-bottom-color:'. $header_active_link_color .';
			}
			';
		} else {
			$active_link_color = '';
		}
		
		if ($this->params->get('sticky_header') == 1) { 
			$sticky_header_styling = '
			.sticky .logo,
			.sticky #cart-menu,
			.sticky #cd-menu-trigger,
			.sticky .cd-cart,
			.sticky .cd-cart >i,
			.sticky .menu-is-open >i,
			#sp-header.sticky .modal-login-wrapper span,
			#sp-header.sticky .ap-my-account i.pe-7s-user,
			#sp-header.sticky .ap-my-account .info-text,
			#sp-header.sticky .mod-languages,
			#sp-header.sticky .top-search-wrapper .icon-top-wrapper,
			#sp-header.sticky .top-search-wrapper .icon-top-wrapper >i:before,
			.sticky .sp-megamenu-wrapper > .sp-megamenu-parent >li >a,
			.sticky .sp-megamenu-wrapper #offcanvas-toggler,
			.sticky #sp-logo a.logo{ 
				height:'.$sticky_header_height.'px;
				line-height:'.$sticky_header_height.'px;
			 }
			 .sticky .total_products{top: calc('. $sticky_header_height .'px / 2 - 22px);}
			 .sticky .sticky__wrapper{
				'.$stickybgcolor.'
				 height:'.$sticky_header_height.'px;
				 '. $sticky_appearance_none . $sticky_appearance_animation .'
			}
			'. $boxed_sticky_header .'
			.sticky .sticky__wrapper .sp-sticky-logo {
				height:'.$sticky_header_height.'px;
			}
			.sticky.onepage .sticky__wrapper,
			.sticky.white .sticky__wrapper,
			.sticky.transparent .sticky__wrapper{
				'.$stickybgcolor.'
			} 
			#sp-header.sticky #sp-menu .sp-megamenu-wrapper .sp-megamenu-parent >li >a,
			#sp-header.sticky .top-search-wrapper,
			#sp-header.sticky .top-search-wrapper .icon-top-wrapper i,
			#sp-header.sticky #cd-menu-trigger i,
			#sp-header.sticky .cd-cart i{
				'. $sticky_header_link_color .';
			}	
			#sp-header.sticky #sp-menu .sp-megamenu-wrapper .sp-megamenu-parent >li.active>a,
			#sp-header.sticky #sp-menu .sp-megamenu-wrapper .sp-megamenu-parent >li.current-item>a,
			#sp-header.sticky #sp-menu .sp-megamenu-wrapper .sp-megamenu-parent >li.sp-has-child.active>a,
			.sticky #offcanvas-toggler >i,
			.sticky #offcanvas-toggler >i:hover{
				color:'. $sticky_header_active_link_color .';
			}
			 ';
			 
			$header_css = $header_styling . $active_link_color . $sticky_header_styling;
			$header_css = preg_replace(array('/([\s])\1+/', '/[\n\t]+/m'), '', $header_css); // Remove whitespace
			$doc->addStyledeclaration($header_css);
		} else { 
			$header_css = $header_styling . $active_link_color;
			$header_css = preg_replace(array('/([\s])\1+/', '/[\n\t]+/m'), '', $header_css); // Remove whitespace
			$doc->addStyledeclaration($header_css);
		}

		
			if ($this->params->get('compress_css'))
			{
				$this->helix3->compressCSS();
			}
			
			$tempOption = $app->input->get('option');
			
			if ($this->params->get('compress_js') && $tempOption != 'com_config')
			{
				$this->helix3->compressJS($this->params->get('exclude_js'));
			}
			
			//before body
			if ($before_body = $this->helix3->getParam('before_body'))
			{
				echo $before_body . "\n";
			}
		
			// Removes: jQuery(window).on('load', function() {new JCaption('img.caption');});
			if (isset($this->_script['text/javascript'])) {
				$this->_script['text/javascript'] = preg_replace('%jQuery\(\window\)\.on\(\'load\',\s*function\(\)\s*{\s*new\s*JCaption\(\'img.caption\'\);\s*}\);\s*%', '', $this->_script['text/javascript']);
				if (empty($this->_script['text/javascript']))
					unset($this->_script['text/javascript']);
			}

			// Removes Mootools library	
			if($this->params->get('remove_mootools')) {
				unset($doc->_scripts[$this->baseurl . '/media/system/js/mootools-core.js']);
				unset($doc->_scripts[$this->baseurl . '/media/system/js/core.js']);
				unset($doc->_scripts[$this->baseurl . '/media/system/js/mootools-more.js']);
				unset($doc->_scripts[$this->baseurl . '/media/system/js/caption.js']);
			}
		?>
				
		<jdoc:include type="modules" name="debug" />
		<jdoc:include type="modules" name="helixpreloader" />
				
		<!-- Go to top -->
		<?php if ($this->params->get('goto_top')) : ?>
			<a href="javascript:void(0)" class="scrollup" aria-label="<?php echo Text::_('HELIX_GOTO_TOP'); ?>">&nbsp;</a>
		<?php endif; ?>
	</body>
</html>