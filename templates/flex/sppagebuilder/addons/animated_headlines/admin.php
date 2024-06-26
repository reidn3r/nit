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
		'addon_name'=>'sp_animated_headlines',
		'title'=>Text::_('FLEX_ADDON_ANIMATED_HEADLINES'),
		'desc'=>Text::_('FLEX_ADDON_ANIMATED_HEADLINES_DESC'),
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
					'title'=>Text::_('Animation Effects')
				),
				'effect'=>array(
					'type'=>'select',
					'title'=>Text::_('Effect'),
					'desc'=>Text::_('Choose Effect for Animated Headlines Animation'),
					'values'=>array(
						'rotate-1 reset-width'=>Text::_('Rotate 1'),
						'letters rotate-2'=>Text::_('Rotate 2'),
						'letters rotate-3'=>Text::_('Rotate 3'),
						'letters type'=>Text::_('Typing'),
						'loading-bar'=>Text::_('Loading Bar'),
						'slide reset-width'=>Text::_('Slide'),
						'clip is-full-width'=>Text::_('Clip'),
						'zoom reset-width'=>Text::_('Zoom'),
						'letters scale'=>Text::_('Scale'),
						'push reset-width'=>Text::_('Push'),
					),
					'std'=>'slide reset-width',
				),
				'loading_bar'=>array(
					'type'=>'slider',
					'title'=>Text::_('Loading Bar Height'),
					'min'=>1,
					'std'=>3,
					'max'=>10,
					'responsive'=>true,
					'depends'=>array(array('effect', '=', 'loading-bar')),
				),
				
				'loading_bar_color'=>array(
					'type'=>'color',
					'title'=>Text::_('Loading Bar Color'),
					'depends'=>array(array('effect', '=', 'loading-bar')),
				),
				
				'typing_cursor_color'=>array(
					'type'=>'color',
					'title'=>Text::_('Typing Cursor Color'),
					'depends'=>array(array('effect', '=', 'letters type')),
				),
				
				'clip_cursor_color'=>array(
					'type'=>'color',
					'title'=>Text::_('Clip Cursor Color'),
					'depends'=>array(array('effect', '=', 'clip is-full-width')),
				),
				
				'separator2'=>array(
					'type'=>'separator', 
					'title'=>Text::_('Headlines')
				),
				
				'before_text'=>array(
					'type'=>'text',
					'title'=>Text::_('FLEX_ADDON_ANIMATED_HEADLINES_BEFORE_TEXT'),
					'desc'=>Text::_('FLEX_ADDON_ANIMATED_HEADLINES_BEFORE_TEXT_DESC'),
					'std'=> ''
				),
				
				'after_text'=>array(
					'type'=>'text',
					'title'=>Text::_('FLEX_ADDON_ANIMATED_HEADLINES_AFTER_TEXT'),
					'desc'=>Text::_('FLEX_ADDON_ANIMATED_HEADLINES_AFTER_TEXT_DESC'),
					'std'=> ''
				),
				
				'separator3'=>array(
					'type'=>'separator', 
					'title'=>Text::_('Styling')
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
						'span'=> 'span',
						'div'=> 'div'
					),
					'std'=>'h2',
				),

				'title_font_family'=>array(
					'type'=>'fonts',
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_FAMILY'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_FAMILY_DESC'),
					'selector'=> array(
						'type'=>'font',
						'font'=>'{{ VALUE }}',
						'css'=>'.sppb-addon-title { font-family: {{ VALUE }}; }'
					),
				),

				'title_fontsize'=>array(
					'type'=>'slider',
					'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_FONT_SIZE'),
					'std'=>'',
					'max'=>400,
					'responsive'=>true,
				),
				'title_lineheight'=>array(
					'type'=>'slider',
					'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_LINE_HEIGHT'),
					'std'=>'',
					'max'=>400,
					'responsive'=>true,
				),
			
				'title_font_style'=>array(
					'type'=>'fontstyle',
					'title'=> Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_STYLE'),
				),
				
				'title_letterspace'=>array(
					'type'=>'select',
					'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_LETTER_SPACING'),
					'values'=>array(
						'0'=> 'Default',
						'1px'=> '1px',
						'2px'=> '2px',
						'3px'=> '3px',
						'4px'=> '4px',
						'5px'=> '5px',
						'6px'=>	'6px',
						'7px'=>	'7px',
						'8px'=>	'8px',
						'9px'=>	'9px',
						'10px'=> '10px'
					),
					'std'=>'0',
				),
				'title_text_transform'=>array(
					'type'=>'select',
					'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_TEXT_TRANSFORM'),
					'values'=>array(
						'none'=> 'None',
						'capitalize'=> 'Capitalize',
						'uppercase'=> 'Uppercase',
						'lowercase'=> 'Lowercase',
					),
					'std'=>'none',
				),
				
				'title_margin'=>array(
					'type'=>'margin',
					'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_MARGIN'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_MARGIN_DESC'),
					'std' => '',
					'responsive'=>true
				),

				'title_padding'=>array(
					'type'=>'padding',
					'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_PADDING'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_PADDING_DESC'),
					'std' => '',
					'responsive'=>true
				),

				'alignment'=>array(
					'type'=>'select',
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_CONTENT_ALIGNMENT'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_CONTENT_ALIGNMENT_DESC'),
					'values'=>array(
						'sppb-text-left'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_LEFT'),
						'sppb-text-center'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_CENTER'),
						'sppb-text-right'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_RIGHT'),
					),
					'std'=>'sppb-text-center',
				),
				'title_text_shadow'=>array(
					'type'=>'boxshadow',
					'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_TEXT_SHADOW'),
					'std'=>'',
					'config' => array(
						'spread' => false
					)
				),

				'class'=>array(
					'type'=>'text',
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_CLASS'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_CLASS_DESC'),
					'std'=>''
				),

				// Repeatable Items
				'sp_animated_headlines_item'=>array(
					'title'=>Text::_('FLEX_ADDON_ANIMATED_HEADLINES'),
					'attr'=>array(
						'title'=>array(
							'type'=>'text',
							'title'=>Text::_('FLEX_ADDON_ANIMATED_HEADLINE'),
							'desc'=>Text::_('FLEX_ADDON_ANIMATED_HEADLINE_DESC'),
							'std'=>'Animated Headline',
						),
						
						'headline_fontstyle'=>array(
							'type'=>'select',
							'title'=> Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_STYLE'),
							'values'=>array(
								//'underline'=> Text::_('COM_SPPAGEBUILDER_GLOBAL_FONT_STYLE_UNDERLINE'),
								'uppercase'=> Text::_('COM_SPPAGEBUILDER_GLOBAL_FONT_STYLE_UPPERCASE'),
								'italic'=> Text::_('COM_SPPAGEBUILDER_GLOBAL_FONT_STYLE_ITALIC'),
								'lighter'=> Text::_('COM_SPPAGEBUILDER_GLOBAL_FONT_STYLE_LIGHTER'),
								'normal'=> Text::_('COM_SPPAGEBUILDER_GLOBAL_FONT_STYLE_NORMAL'),
								'bold'=> Text::_('COM_SPPAGEBUILDER_GLOBAL_FONT_STYLE_BOLD'),
								'bolder'=> Text::_('COM_SPPAGEBUILDER_GLOBAL_FONT_STYLE_BOLDER'),
							),
							'multiple'=>true,
							'std'=>'',
						),

						'headline_font_family'=>array(
							'type'=>'fonts',
							'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_FONT_FAMILY'),
							'selector'=> array(
								'type'=>'font',
								'font'=>'{{ VALUE }}',
								'css'=>'{ font-family: {{ VALUE }}; }'
							)
						),
						
						'headline_color'=>array(
							'type'=>'color',
							'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ITEM_TITLE_COLOR'),
							'std'=>'#555',
						),
						
						'headline_class'=>array(
							'type'=>'text',
							'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_CLASS'),
							'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_CLASS_DESC'),
							'std'=>''
						),
					),
				),
			),
		),
	)
);
