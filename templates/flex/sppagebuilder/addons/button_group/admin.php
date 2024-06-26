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

//Include Pixeden Icons
require_once dirname(dirname( __DIR__ )) . '/fields/pixeden-icons.php';

SpAddonsConfig::addonConfig(
	array(
		'type'=>'general',
		'addon_name'=>'sp_button_group',
		'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_GROUP'),
		'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_GROUP_DESC'),
		'category'=>'Content',
		'attr'=>array(
			'general' => array(

				'admin_label'=>array(
					'type'=>'text',
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_ADMIN_LABEL'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_ADMIN_LABEL_DESC'),
					'std'=> ''
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

				'margin'=>array(
					'type'=>'slider',
					'title'=>Text::_('COM_SPPAGEBUILDER_BUTTON_GROUP_GUTTER'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_BUTTON_GROUP_GUTTER_DESC'),
					'responsive'=>true,
					'max'=>100,
					'std'=>array('md'=>5),
				),

				'class'=>array(
					'type'=>'text',
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_CLASS'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_CLASS_DESC'),
					'std'=> '',
				),

				// Repeatable Items
				'sp_button_group_item'=>array(
					'title'=> Text::_('COM_SPPAGEBUILDER_ADDON_BUTTONS_ITEM'),
					'attr'=>  array(

						'title'=>array(
							'type'=>'text',
							'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_TEXT'),
							'desc'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_TEXT_DESC'),
							'std'=>'Button',
						),

						'font_family'=>array(
							'type'=>'fonts',
							'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_FONT_FAMILY'),
							'selector'=> array(
								'type'=>'font',
								'font'=>'{{ VALUE }}',
								'css'=>'.sppb-btn { font-family: {{ VALUE }}; }'
							)
						),

						'font_style'=>array(
							'type'=>'fontstyle',
							'title'=> Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_FONT_STYLE'),
							'std'=>''
						),

						'letterspace'=>array(
							'type'=>'select',
							'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_LETTER_SPACING'),
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
							'std'=>'0'
						),

						'url'=>array(
							'type'=>'media',
							'format'=>'attachment',
							'hide_preview'=>true,
							'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_URL'),
							'desc'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_URL_DESC'),
							'placeholder'=>'http://',
							'hide_preview'=>true,
						),

						'type'=>array(
							'type'=>'select',
							'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_STYLE'),
							'desc'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_STYLE_DESC'),
							'values'=>array(
								'default'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_DEFAULT'),
								'flex'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_FLEX'),
								'dark'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_DARK'),
								'light'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_LIGHT'),
								'primary'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_PRIMARY'),
								'secondary'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_SECONDARY'),
								'success'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_SUCCESS'),
								'info'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_INFO'),
								'warning'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_WARNING'),
								'danger'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_DANGER'),
								'link'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_LINK'),
								'custom'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_CUSTOM'),
							),
							'std'=>'primary',
						),

						'appearance'=>array(
							'type'=>'select',
							'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE'),
							'desc'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_DESC'),
							'values'=>array(
								''=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_FLAT'),
								'outline'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_OUTLINE'),
								'3d'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_3D'),
								'gradient'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_GRADIENT'),
							),
							'std'=>'flat',
						),

						'button_status'=>array(
							'type'=>'buttons',
							'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_ENABLE_BACKGROUND_OPTIONS'),
							'std'=>'normal',
							'values'=>array(
								array(
									'label' => 'Normal',
									'value' => 'normal'
								),
								array(
									'label' => 'Hover',
									'value' => 'hover'
								),
							),
							'tabs' => true,
							'depends'=>array(
								array('type', '=', 'custom'),
							)
						),

						'background_color'=>array(
							'type'=>'color',
							'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_BACKGROUND_COLOR'),
							'desc'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_BACKGROUND_COLOR_DESC'),
							'std' => '#dc4a3e',
							'depends'=>array(
								array('appearance', '!=', 'gradient'),
								array('type', '=', 'custom'),
								array('button_status', '=', 'normal'),
							)
						),

						'background_gradient'=>array(
							'type'=>'gradient',
							'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_GRADIENT'),
							'std'=> array(
								"color" => "#fd6f64",
								"color2" => "#dc4a3e",
								"deg" => "45",
								"type" => "linear"
							),
							'depends'=>array(
								array('appearance', '=', 'gradient'),
								array('type', '=', 'custom'),
								array('button_status', '=', 'normal'),
							)
						),

						'color'=>array(
							'type'=>'color',
							'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_COLOR'),
							'desc'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_COLOR_DESC'),
							'std' => '#fff',
							'depends'=>array(
								array('type', '=', 'custom'),
								array('button_status', '=', 'normal'),
							),
						),

						'background_color_hover'=>array(
							'type'=>'color',
							'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_BACKGROUND_COLOR_HOVER'),
							'desc'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_BACKGROUND_COLOR_HOVER_DESC'),
							'std' => '#222',
							'depends'=>array(
								array('appearance', '!=', 'gradient'),
								array('type', '=', 'custom'),
								array('button_status', '=', 'hover'),
							)
						),

						'background_gradient_hover'=>array(
							'type'=>'gradient',
							'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_GRADIENT'),
							'std'=> array(
								"color" => "#f77367",
								"color2" => "#f35546",
								"deg" => "45",
								"type" => "linear"
							),
							'depends'=>array(
								array('appearance', '=', 'gradient'),
								array('type', '=', 'custom'),
								array('button_status', '=', 'hover'),
							)
						),

						'color_hover'=>array(
							'type'=>'color',
							'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_COLOR_HOVER'),
							'desc'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_COLOR_HOVER_DESC'),
							'std' => '#fff',
							'depends'=>array(
								array('type', '=', 'custom'),
								array('button_status', '=', 'hover'),
							),
						),

						'size'=>array(
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
						),

						'button_padding'=>array(
							'type'=>'padding',
							'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_PADDING'),
							'desc'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_PADDING_DESC'),
							'std' => '',
							'depends'=> array(
								array('type', '=', 'custom'),
							),
							'responsive'=>true
						),

						'shape'=>array(
							'type'=>'select',
							'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE'),
							'desc'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE_DESC'),
							'values'=>array(
								'rounded'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE_ROUNDED'),
								'square'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE_SQUARE'),
								'round'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE_ROUND'),
							),
						),

						'block'=>array(
							'type'=>'select',
							'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_BLOCK'),
							'desc'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_BLOCK_DESC'),
							'values'=>array(
								''=>Text::_('JNO'),
								'sppb-btn-block'=>Text::_('JYES'),
							),
						),
						
						'peicon_name'=>array( // Pixeden Icons
							'type'=>'select', 
							'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_PE_ICON_NAME'),
							'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_PE_ICON_NAME_DESC'),
							'values'=> $peicon_list
						),		

						'icon'=>array(
							'type'=>'icon',
							'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_FONTAWESOME_ICON_NAME'),
							'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_FONTAWESOME_ICON_NAME_DESC'),
						),

						'icon_position'=>array(
							'type'=>'select',
							'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_ICON_POSITION'),
							'values'=>array(
								'left'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_LEFT'),
								'right'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_RIGHT'),
							),
						),

						'target'=>array(
							'type'=>'select',
							'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_LINK_NEWTAB'),
							'desc'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_LINK_NEWTAB_DESC'),
							'values'=>array(
								''=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_TARGET_SAME_WINDOW'),
								'_blank'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_TARGET_NEW_WINDOW'),
							),
						),
					),
				),
			),
		),
	)
);
