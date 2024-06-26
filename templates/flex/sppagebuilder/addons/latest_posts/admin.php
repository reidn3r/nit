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
		'type'=>'content',
		'addon_name'=>'sp_latest_posts',
		'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_LATEST_POSTS'),
		'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_LATEST_POSTS_DESC'),
		'category'=>'Flex',
		'attr'=>array(
			'general' => array(

				'admin_label'=>array(
					'type'=>'text',
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_ADMIN_LABEL'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_ADMIN_LABEL_DESC'),
					'std'=> ''
				),
	
				'title'=>array(
					'type'=>'text', 
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_DESC'),
					'std'=>'',
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
				),
				'show_image'=>array(
					'type'=>'checkbox', 
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_LATEST_POSTS_IMG'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_LATEST_POSTS_IMG_DESC'),
					'values'=>array(
						1=>Text::_('JYES'),
						0=>Text::_('JNO'),
					),
					'std'=>1,
					),
				'show_date'=>array(
					'type'=>'checkbox', 
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_LATEST_POSTS_DATE'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_LATEST_POSTS_DATE_DESC'),
					'values'=>array(
						1=>Text::_('JYES'),
						0=>Text::_('JNO'),
					),
					'std'=>1,
					),	
				'date_format'=>array(
					'type'=>'select',
					'title'=>Text::_('FLEX_GLOBAL_DATE_FORMAT'),
					'desc'=>Text::_('FLEX_GLOBAL_DATE_FORMAT_DESC'),
					'values'=>array(
						'DATE_FORMAT_LC1'=>Text::_('DATE_FORMAT_LC1: Tuesday, 07 October 2019 (l, d F Y)'),
						'DATE_FORMAT_LC2'=>Text::_('DATE_FORMAT_LC2: Tuesday, 07 October 2009 14:15 (l, d F Y H:i)'),
						'DATE_FORMAT_LC3'=>Text::_('DATE_FORMAT_LC3: 07 October 2019 (d F Y)'),
						'DATE_FORMAT_LC4'=>Text::_('DATE_FORMAT_LC4: 2019-10-07 (Y-m-d)'),
						'DATE_FORMAT_JS1'=>Text::_('DATE_FORMAT_JS1: 19-10-07 (y-m-d)'),
					),
					'std'=>'DATE_FORMAT_LC1',
					'depends'=> array(
						array('show_date', '=', '1'),
					)
				),
		
				'show_intro_text'=>array(
					'type'=>'checkbox', 
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_LATEST_POSTS_INTROTEXT'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_LATEST_POSTS_INTROTEXT_DESC'),
					'values'=>array(
						1=>Text::_('JYES'),
						0=>Text::_('JNO'),
					),
					'std'=>1,
				),
				'intro_text_limit'=>array(
					'type'=>'number', 
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_LATEST_POSTS_INTROTEXT_LIMIT'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_LATEST_POSTS_INTROTEXT_LIMIT_DESC'),
					'std'=>'100',
					'depends'=>array('show_intro_text'=>'1')
					),
				'show_author'=>array(
					'type'=>'checkbox', 
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_LATEST_POSTS_AUTHOR'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_LATEST_POSTS_AUTHOR_DESC'),
					'values'=>array(
						1=>Text::_('JYES'),
						0=>Text::_('JNO'),
					),
					'std'=>1,
				),
					
				'show_readmore'=>array(
					'type'=>'checkbox', 
					'title'=>Text::_('FLEX_ADDON_READMORE'),
					'desc'=>Text::_('FLEX_ADDON_READMORE_DESC'),
					'values'=>array(
						1=>Text::_('JYES'),
						0=>Text::_('JNO'),
					),
					'std'=>0,
					),
								
				//Readmore Button
				'readmore_button'=>array(
					'type'=>'text',
					'title'=>Text::_('FLEX_ADDON_READMORE_BUTTON_TEXT'),
					'desc'=>Text::_('FLEX_ADDON_READMORE_BUTTON_TEXT_DESC'),
					'std'=>'Read More',
					'depends'=>array('show_readmore'=>'1')
				),
				'readmore_button_position'=>array(
					'type'=>'select',
					'title'=>Text::_('FLEX_ADDON_READMORE_BUTTON_POSITION'),
					'values'=>array(
						'left'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_LEFT'),
						'right'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_RIGHT'),
					),
					'depends'=>array('show_readmore'=>'1')
				),
		
				'button_type'=>array(
					'type'=>'select',
					'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_STYLE'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_STYLE_DESC'),
					'values'=>array(
						'default'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_DEFAULT'),
						'flex'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_FLEX'),
						'dark'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_DARK'),
						'light'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_LIGHT'),
						'primary'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_PRIMARY'),
						'success'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_SUCCESS'),
						'info'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_INFO'),
						'warning'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_WARNING'),
						'danger'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_DANGER'),
						'link'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_LINK'),
					),
					'std'=>'default',
					'depends'=> array(
						array('show_readmore', '=', '1'),
						array('button_text', '!=', ''),
					)
				),
	
				'button_appearance'=>array(
					'type'=>'select',
					'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_DESC'),
					'values'=>array(
						''=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_FLAT'),
						'outline'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_OUTLINE'),
						'3d'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_3D'),
					),
					'std'=>'flat',
					'depends'=> array(
						array('show_readmore', '=', '1'),
						array('button_text', '!=', ''),
					)
				),
	
				'button_size'=>array(
					'type'=>'select',
					'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_DESC'),
					'values'=>array(
						''=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_DEFAULT'),
						'lg'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_LARGE'),
						'xlg'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_XLARGE'),
						'sm'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_SMALL'),
						'xs'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_EXTRA_SAMLL'),
					),
					'depends'=> array(
						array('show_readmore', '=', '1'),
						array('button_text', '!=', ''),
					)
				),
	
				'button_shape'=>array(
					'type'=>'select',
					'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE_DESC'),
					'values'=>array(
						'rounded'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE_ROUNDED'),
						'square'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE_SQUARE'),
						'round'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE_ROUND'),
					),
					'depends'=> array(
						array('show_readmore', '=', '1'),
						array('button_text', '!=', ''),
					)
				),
	
				'button_block'=>array(
					'type'=>'checkbox',
					'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_BLOCK'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_BLOCK_DESC'),
					'values'=>array(
						''=>Text::_('JNO'),
						'sppb-btn-block'=>Text::_('JYES'),
					),
					'depends'=> array(
						array('show_readmore', '=', '1'),
						array('button_text', '!=', ''),
					)
				),
		
				'show_category'=>array(
					'type'=>'checkbox', 
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_LATEST_POSTS_CATEGORY'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_LATEST_POSTS_CATEGORY_DESC'),
					'values'=>array(
						1=>Text::_('JYES'),
						0=>Text::_('JNO'),
					),
					'std'=>1,
					),
				'item_limit'=>array(
					'type'=>'number', 
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_LATEST_POSTS_LIMIT'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_LATEST_POSTS_LIMIT_DESC'),
					'std'=>'6'
					),	
				'column_no'=>array(
					'type'=>'select', 
					'title'=>Text::_('FLEX_LATEST_POSTS_COLUMN_NO'),
					'desc'=>Text::_('FLEX_LATEST_POSTS_COLUMN_NO_DESC'),
					'values'=>array(
						'1'=>Text::_('1'),
						'2'=>Text::_('2'),
						'3'=>Text::_('3'),
						'4'=>Text::_('4'),
						'5'=>Text::_('5'),
						'6'=>Text::_('6'),
						),
					'std'=>'3',
				),
				'image_alignment'=>array(
					'type'=>'select',
					'title'=>Text::_('FLEX_LATEST_POSTS_IMAGE_ALIGNMENT'),
					'desc'=>Text::_('FLEX_LATEST_POSTS_IMAGE_ALIGNMENT_DESC'),
					'values'=>array(
						'left'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_LEFT'),
						'right'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_RIGHT'),
						),
					'std'=>'left',
					'depends'=>array('column_no'=>'1')
				),
				'category'=>array(
					'type'=>'category',
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_LATEST_POSTS_SELECT_CATEGORY'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_LATEST_POSTS_SELECT_CATEGORY_DESC'),
					'std'=>''
					),
					
				'enable_masonry'=>array(
					'type'=>'checkbox', 
					'title'=>Text::_('FLEX_ADDON_ENABLE_MASONRY'),
					'desc'=>Text::_('FLEX_ADDON_ENABLE_MASONRY_DESC'),
					'values'=>array(
						1=>Text::_('JYES'),
						0=>Text::_('JNO'),
					),
					'std'=>0,
					'depends'=>array(array('column_no', '!=', '1')),
				),
				/*
				'masonry_gutter'=>array(
					'type'=>'number', 
					'title'=>Text::_('FLEX_ADDON_MASONRY_GUTTER'),
					'desc'=>Text::_('FLEX_ADDON_MASONRY_GUTTER_DESC'),
					'std'=>0,
					'depends'=> array(
						array('column_no', '!=', '1'),
						array('enable_masonry', '=', '1'),
					)
				),
				*/
			
				'style'=>array(
					'type'=>'select', 
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_PROGRESS_BAR_TYPE'),
					'desc'=>Text::_(''),
					'values'=>array(
						'default'=>Text::_('Default'),
						'blog'=>Text::_('Blog'),
						'flex'=>Text::_('Flex'),
						),
					'std'=>'Default',
				),
				'class'=>array(
						'type'=>'text',
						'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_CLASS'),
						'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_CLASS_DESC'),
						'std'=>''
				),
			),
		),
	)
);