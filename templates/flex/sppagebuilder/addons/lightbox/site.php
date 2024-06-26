<?php
/**
 * Flex @package SP Page Builder
 * Template Name - Flex
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
// no direct access
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

class SppagebuilderAddonLightbox extends SppagebuilderAddons{

	public function render() {
		
		$class = (isset($this->addon->settings->class) && $this->addon->settings->class) ? $this->addon->settings->class : '';
		$title = (isset($this->addon->settings->title) && $this->addon->settings->title) ? $this->addon->settings->title : '';
		$heading_selector = (isset($this->addon->settings->heading_selector) && $this->addon->settings->heading_selector) ? $this->addon->settings->heading_selector : 'h3';

		//Options
		$width = (isset($this->addon->settings->width) && $this->addon->settings->width) ? $this->addon->settings->width : 200;
		$height = (isset($this->addon->settings->height) && $this->addon->settings->height) ? $this->addon->settings->height : 200;
		$spacing = (isset($this->addon->settings->spacing) && $this->addon->settings->spacing) ? $this->addon->settings->spacing : 0;
		
		$output  = '<div class="sppb-addon sppb-addon-lightbox ' . $class . '">';
		$output .= ($title) ? '<'.$heading_selector.' class="sppb-addon-title">' . $title . '</'.$heading_selector.'>' : '';
		$output .= '<div class="sppb-addon-content">';
		$output .= '<ul id="grid-'.$this->addon->id.'" class="sppb-lightbox clearfix">';
		
		foreach ($this->addon->settings->sp_lightbox_item as $key => $value) {
			
			$class != '' ? $thumb_class = ' class="'.$class.'"' : $thumb_class = '';
			$class == 'small' ? $small = ' small' : $small = '';
			$value->show_caption != 0 ? $caption = $value->title : $caption = '';

			if($value->thumb) {
				$output .= ($spacing !='') ? '<li class="shuffle_sizer'.$small.'" style="margin-bottom:' . $spacing . 'px;">' : '<li class="shuffle_sizer"> ';
				$output .= '';
		
				if($value->full) {
					$output .= '<div class="overlay"><a href="'. $value->full .'" data-imagelightbox="gallery-'.$this->addon->id.'">';
					
					if (($class == 'simple') || ($class == 'small')) {
						$output .= '';
					} else {
						$output .= '<i class="ap-plus-1"></i>';
					}
					$output .= '';
				}
				$output .= '<img'.$thumb_class.' src="'. $value->thumb . '" width="' . $width . '" alt="' . $caption . '" />';
		
				if($value->full) {
					$output .= '</a></div>';
				}
				$output .= '</li>';
			}		
		}
		$output .= '</ul>';
		$output	.= '</div>';
		$output .= '</div>';

		return $output;
	}
	
	public function stylesheets() {
		$app = Factory::getApplication();
		$tmplPath = Uri::base(true) . '/templates/'.$app->getTemplate();
		return array($tmplPath.'/sppagebuilder/addons/lightbox/assets/css/imagelightbox.css');
	}
	

	public function scripts() {
		$app = Factory::getApplication();
		$tmplPath = Uri::base(true) . '/templates/'.$app->getTemplate();
		
		return array(
			$tmplPath.'/sppagebuilder/addons/lightbox/assets/js/imagelightbox.min.js'
		);
	}
	public function css() {
		$gutter = (isset($this->addon->settings->spacing) && $this->addon->settings->spacing) ? $this->addon->settings->spacing : 0;
		$width = (isset($this->addon->settings->width) && $this->addon->settings->width) ? $this->addon->settings->width : 200;
		$css ='#grid-'.$this->addon->id.' li.shuffle_sizer {width:'.$width.'px;margin-bottom:'.$gutter.'px;}';
		//$css = preg_replace(array('/([\s])\1+/', '/[\n\t]+/m'), '', $css); // Removes whitespace
		return $css;
	}
	public function js() {
		$gutter = (isset($this->addon->settings->spacing) && $this->addon->settings->spacing) ? ',gutter:' . $this->addon->settings->spacing : '';
		$width = (isset($this->addon->settings->width) && $this->addon->settings->width) ? $this->addon->settings->width : 200;
		
		// Masonry version (June 2022):
		$js ='
		jQuery(function($){$("#grid-'.$this->addon->id.'").imagesLoaded(function(){$("#grid-'.$this->addon->id.'").masonry({
		  isFitWidth:true,
		  itemSelector:\'.shuffle_sizer\',
		  columnWidth:'. $width .'
		  '. $gutter .'
		})}),
		$(function(){var b=function(){$(\'<div id="imagelightbox-loading"><div></div></div>\').appendTo("body")},c=function(){$("#imagelightbox-loading").remove()},d=function(){$(\'<div id="imagelightbox-overlay"></div>\').appendTo("body")},e=function(){$("#imagelightbox-overlay").remove()},f=function(a){$(\'<button type="button" id="imagelightbox-close" title="Close"></button>\').appendTo("body").on("click touchend",function(){return $(this).remove(),a.quitImageLightbox(),!1})},g=function(){$("#imagelightbox-close").remove()},h=function(){var a=$(\'a[href="\'+$("#imagelightbox").attr("src")+\'"] img\').attr("alt");a.length>0&&$(\'<div id="imagelightbox-caption">\'+a+"</div>").appendTo("body")},i=function(){$("#imagelightbox-caption").remove()},j=function(b,c){var a=$(\'<button type="button" class="imagelightbox-arrow imagelightbox-arrow-left"><i class="ap-left-2"></i></button><button type="button" class="imagelightbox-arrow imagelightbox-arrow-right"><i class="ap-right-2"></i></button>\');a.appendTo("body"),a.on("click touchend",function(d){d.preventDefault();var e=$(this),f=$(c+\'[href="\'+$("#imagelightbox").attr("src")+\'"]\'),a=f.index(c);return e.hasClass("imagelightbox-arrow-left")?(a-=1,$(c).eq(a).length||(a=$(c).length)):(a+=1,$(c).eq(a).length||(a=0)),b.switchImageLightbox(a),!1})},k=function(){$(".imagelightbox-arrow").remove()},a=\'a[data-imagelightbox="gallery-'.$this->addon->id.'"]\',l=$(a).imageLightbox({animationSpeed:300,onStart:function(){d(),f(l),j(l,a)},onEnd:function(){e(),i(),g(),k(),c()},onLoadStart:function(){i(),b()},onLoadEnd:function(){h(),c(),$(".imagelightbox-arrow").css("display","block")}})})});
		';
		$js = preg_replace(array('/([\s])\1+/', '/[\n\t]+/m'), '', $js); // Removes whitespace
		return $js;
	}

}
