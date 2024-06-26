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
use Joomla\CMS\Language\Text;

SpAddonsConfig::addonConfig(
	array(
		'type'=>'repeatable',
		'addon_name'=>'sp_slick_carousel',
		'title'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL'),
		'desc'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_DESC'),
		'category'=>'Flex',
		'attr'=>array(
			'general' => array(

				'admin_label'=>array(
					'type'=>'text',
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_ADMIN_LABEL'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_ADMIN_LABEL_DESC'),
					'std'=> ''
				),

			'separator1'=>array(
				'type'=>'separator', 
				'title'=>Text::_('FLEX_ADDON_SETTINGS')
				),
			'infiniteloop'=>array(
				'type'=>'checkbox', 
				'title'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_LOOP'),
				'desc'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_LOOP_DESC'),
				'values'=>array(
					1=>Text::_('JYES'),
					0=>Text::_('JNO'),
				),
				'std'=>1,
			    ),
			'lazyloading'=>array(
				'type'=>'checkbox', 
				'title'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_LAZYLOAD'),
				'desc'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_LAZYLOAD_DESC'),
				'values'=>array(
					1=>Text::_('JYES'),
					0=>Text::_('JNO'),
				),
				'std'=>1,
			    ),
			'slidestoshow'=>array(
				'type'=>'number', 
				'title'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_SLIDES_TO_SHOW'),
				'desc'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_SLIDES_TO_SHOW_DESC'),
				'placeholder'=>'1',
				'std'=>'1'
				),
			'slidestoscroll'=>array(
				'type'=>'number', 
				'title'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_SLIDES_TO_SCROLL'),
				'desc'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_SLIDES_TO_SCROLL_DESC'),
				'placeholder'=>'1',
				'std'=>'1'
				),
			'spacing'=>array(
				'type'=>'number', 
				'title'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_SPACE_BETWEEN_IMG'),
				'desc'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_SPACE_BETWEEN_IMG_DESC'),
				'std'=>0
				),		
			'fade_effect'=>array(
				'type'=>'checkbox', 
				'title'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_FADE_EFFECT'),
				'desc'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_FADE_EFFECT_DESC'),
				'values'=>array(
					1=>Text::_('JYES'),
					0=>Text::_('JNO'),
				),
				'std'=>0,
			 ),
			'autoplay'=>array(
				'type'=>'checkbox', 
				'title'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_AUTOPLAY'),
				'desc'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_AUTOPLAY_DESC'),
				'values'=>array(
					1=>Text::_('JYES'),
					0=>Text::_('JNO'),
				),
				'std'=>1,
			),
			'autoplay_pause_onhover'=>array(
				'type'=>'checkbox', 
				'title'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_AUTOPLAY_STOP_ON_HOVER'),
				'desc'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_AUTOPLAY_STOP_ON_HOVER_DESC'),
				'values'=>array(
					1=>Text::_('JYES'),
					0=>Text::_('JNO'),
				),
				'std'=>1,
			),
			'autoplay_pause_onfocus'=>array(
				'type'=>'checkbox', 
				'title'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_AUTOPLAY_STOP_ON_FOCUS'),
				'desc'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_AUTOPLAY_STOP_ON_FOCUS_DESC'),
				'values'=>array(
					1=>Text::_('JYES'),
					0=>Text::_('JNO'),
				),
				'std'=>1,
			),
			'autoplay_interval'=>array(
				'type'=>'text', 
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_AUTOPLAY_INTERVAL'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_AUTOPLAY_INTERVAL_DESC'),
				'placeholder'=>'5000',
				'std'=>5000,
				'depends'=>array(array('autoplay', '=', '1')),
				),	
			
			'speed'=>array(
				'type'=>'text', 
				'title'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_AUTOPLAY_SPEED'),
				'desc'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_AUTOPLAY_SPEED_DESC'),
				'placeholder'=>'500',
				'std'=>500
				),
			'arrows'=>array(
				'type'=>'checkbox', 
				'title'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_ARROWS'),
				'desc'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_ARROWS_DESC'),
				'values'=>array(
					1=>Text::_('JYES'),
					0=>Text::_('JNO'),
				),
				'std'=>1,
			    ),
			'arrows_size'=>array(
				'type'=>'number', 
				'title'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_ARROWS_SIZE'),
				'desc'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_ARROWS_SIZE_DESC'),
				'placeholder'=>'44',
				'std'=>44,
				'depends'=>array(array('arrows', '=', '1')),
				),
			'arrows_color'=>array(
				'type'=>'color',
				'title'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_ARROWS_COLOR'),
				'desc'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_ARROWS_COLOR_DESC'),
				'depends'=>array(array('arrows', '=', '1')),
				),
			'arrows_background_color'=>array(
				'type'=>'color',
				'title'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_ARROWS_BACKGROUND_COLOR'),
				'desc'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_ARROWS_BACKGROUND_COLOR_DESC'),
				'depends'=>array(array('arrows', '=', '1')),
				),
			'arrows_class'=>array(
				'type'=>'text', 
				'title'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_ARROWS_CLASS'),
				'desc'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_ARROWS_CLASS_DESC'),
				'std'=>'',
				'depends'=>array(array('arrows', '=', '1')),
				),		
			'counter'=>array(
				'type'=>'checkbox', 
				'title'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_COUNTER'),
				'desc'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_COUNTER_DESC'),
				'values'=>array(
					1=>Text::_('JYES'),
					0=>Text::_('JNO'),
				),
				'std'=>0,
				'depends'=>array(array('arrows', '=', '1')),
				),
			'counter_color'=>array(
				'type'=>'color',
				'title'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_COUNTER_COLOR'),
				'desc'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_COUNTER_COLOR_DESC'),
				'depends'=>array(
							array('arrows', '=', '1'),
							array('counter', '=', '1')
						),
				),
			'dots'=>array(
				'type'=>'checkbox', 
				'title'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_DOTS'),
				'desc'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_DOTS_DESC'),
				'values'=>array(
					1=>Text::_('JYES'),
					0=>Text::_('JNO'),
				),
				'std'=>1,
			    ),
			'dots_color'=>array(
				'type'=>'color',
				'title'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_DOTS_COLOR'),
				'desc'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_DOTS_COLOR_DESC'),
				'depends'=>array(array('dots', '=', '1')),
				),
			'autoheight'=>array(
				'type'=>'checkbox', 
				'title'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_AUTOHEIGHT'),
				'desc'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_AUTOHEIGHT_DESC'),
				'values'=>array(
					1=>Text::_('JYES'),
					0=>Text::_('JNO'),
				),
				'std'=>1,
			    ),
			'separatorRTL'=>array(
				'type'=>'separator', 
				'title'=>Text::_('FLEX_ADDON_RTL_DIR_SEPARATOR')
				),
			'rtl_support'=>array(
				'type'=>'checkbox', 
				'title'=>Text::_('FLEX_ADDON_RTL_DIR'),
				'desc'=>Text::_('FLEX_ADDON_RTL_DIR_DESC'),
				'values'=>array(
					1=>Text::_('JYES'),
					0=>Text::_('JNO'),
				),
				'std'=>0,
			 ),
					
			'separator2'=>array(
				'type'=>'separator', 
				'title'=>Text::_('FLEX_ADDON_BREAKPOINTS')
				),	
			'breakpoint1'=>array(
				'type'=>'number', 
				'title'=>Text::_('FLEX_ADDON_BREAKPOINTS_MEDIUM_DEVICES'),
				'desc'=>Text::_('FLEX_ADDON_BREAKPOINTS_MEDIUM_DEVICES_DESC'),
				'placeholder'=>'992',
				'std'=>992
				),
			'slidestoshow_break1'=>array(
				'type'=>'number', 
				'title'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_SLIDES_TO_SHOW'),
				'desc'=>Text::_('FLEX_ADDON_BREAKPOINTS_MEDIUM_DEVICES_SLIDES_TO_SHOW'),
				'placeholder'=>'3',
				'std'=>3
				),
			'breakpoint2'=>array(
				'type'=>'number', 
				'title'=>Text::_('FLEX_ADDON_BREAKPOINTS_SMALL_DEVICES'),
				'desc'=>Text::_('FLEX_ADDON_BREAKPOINTS_SMALL_DEVICES_DESC'),
				'placeholder'=>'768',
				'std'=>768
				),
			'slidestoshow_break2'=>array(
				'type'=>'number', 
				'title'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_SLIDES_TO_SHOW'),
				'desc'=>Text::_('FLEX_ADDON_BREAKPOINTS_SMALL_DEVICES_SLIDES_TO_SHOW'),
				'placeholder'=>'2',
				'std'=>2
				),
			'breakpoint3'=>array(
				'type'=>'number', 
				'title'=>Text::_('FLEX_ADDON_BREAKPOINTS_EXTRASMALL_DEVICES'),
				'desc'=>Text::_('FLEX_ADDON_BREAKPOINTS_EXTRASMALL_DEVICES_DESC'),
				'placeholder'=>'480',
				'std'=>480
				),
			'slidestoshow_break3'=>array(
				'type'=>'number', 
				'title'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_SLIDES_TO_SHOW'),
				'desc'=>Text::_('FLEX_ADDON_BREAKPOINTS_EXTRASMALL_DEVICES_SLIDES_TO_SHOW'),
				'placeholder'=>'1',
				'std'=>1
				),
				
			'separator3'=>array(
				'type'=>'separator', 
				'title'=>Text::_('FLEX_ADDON_TITLE')
				),	
			'title'=>array(
				'type'=>'text', 
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_DESC'),
				'std'=> ''
				),
			'heading_selector'=>array(
				'type'=>'select',
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_HEADINGS'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_DESC'),
				'values'=>array(
					'h1'=>Text::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H1'),
					'h2'=>Text::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H2'),
					'h3'=>Text::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H3'),
					'h4'=>Text::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H4'),
					'h5'=>Text::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H5'),
					'h6'=>Text::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H6'),
				),
				'std'=>'h3',
				'depends'=>array(array('title', '!=', '')),
			),

			'title_fontsize'=>array(
				'type'=>'number',
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_SIZE'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_SIZE_DESC'),
				'std'=>'',
				'depends'=>array(array('title', '!=', '')),
			),

			'title_fontweight'=>array(
				'type'=>'text',
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_WEIGHT'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_WEIGHT_DESC'),
				'std'=>'',
				'depends'=>array(array('title', '!=', '')),
			),

			'title_text_color'=>array(
				'type'=>'color',
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_TEXT_COLOR'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_TEXT_COLOR_DESC'),
				'depends'=>array(array('title', '!=', '')),
			),

			'title_margin_top'=>array(
				'type'=>'number',
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_TOP'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_TOP_DESC'),
				'placeholder'=>'10',
				'depends'=>array(array('title', '!=', '')),
			),

			'title_margin_bottom'=>array(
				'type'=>'number',
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_BOTTOM'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_BOTTOM_DESC'),
				'placeholder'=>'10',
				'depends'=>array(array('title', '!=', '')),
			),

			'class'=>array(
				'type'=>'text', 
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_CLASS'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_CLASS_DESC'),
				'std'=>''
				),
			'separator4'=>array(
				'type'=>'separator', 
				'title'=>Text::_('FLEX_ADDON_IMAGES')
				),

			// Repeatable Items
			'sp_slick_carousel_item'=>array(
				'title'=> 'Slides', 
				'type'=>'repeatable',
				'attr'=>array(
					'item_title'=>array(
						'type'=>'text', 
						'title'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_ITEM_TITLE'),
						'desc'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_ITEM_TITLE_DESC'),
						'std'=>''
						),
					'thumb'=>array(
						'type'=>'media', 
						'title'=>Text::_('FLEX_ADDON_IMAGE'),
						'desc'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_IMAGE'),
						'std'=>'https://source.unsplash.com/aAd6zv2rdBI/800x480',
					),
					
					'alt_text'=>array(
						'type'=>'text',
						'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_ALT_TEXT'),
						'desc'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_ALT_TEXT_DESC'),
						'std'=>'Image',
						'depends'=>array(
							array('thumb', '!=', ''),
						),
					),
					'thumb_url'=>array(
						'type'=>'text', 
						'title'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_THUMB_URL'),
						'desc'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_THUMB_URL_DESC'),
						'std'=>''
					),
					'url_target'=>array(
						'type'=>'select',
						'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_TARGET'),
						'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_TARGET_DESC'),
						'values'=>array(
							''=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_TARGET_SAME_WINDOW'),
							'_blank'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_TARGET_NEW_WINDOW'),
						),
						'depends'=>array(
							array('thumb', '!=', ''),
							array('thumb_url', '!=', '')
						),
					),
					'description'=>array(
						'type'=>'editor', 
						'title'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_ITEM_DESCRIPTION'),
						'desc'=>Text::_('FLEX_ADDON_SLICK_CAROUSEL_ITEM_DESCRIPTION_DESC'),
						'std'=> ''
						),
					),
				),
			),
		),
	)
);
