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
		'addon_name'=>'sp_testimonialflex',
		'title'=>Text::_('Testimonials Flex'),
		'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_PRO_DESC'),
		'category'=>'Flex',
		'attr'=>array(
			'general' => array(

				'admin_label'=>array(
					'type'=>'text',
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_ADMIN_LABEL'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_ADMIN_LABEL_DESC'),
					'std'=> ''
				),

				'autoplay'=>array(
					'type'=>'checkbox', 
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_PRO_AUTOPLAY'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_PRO_AUTOPLAY_DESC'),
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
					'std'=>5000
					),	
				

				'arrows'=>array(
					'type'=>'checkbox', 
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_PRO_SHOW_ARROWS'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_PRO_SHOW_ARROWS_DESC'),
					'values'=>array(
						1=>Text::_('JYES'),
						0=>Text::_('JNO'),
						),
					'std'=>1,
				),
				
				'avatar_width'=>array(
					'type'=>'slider',
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_CLIENT_AVATAR_WIDTH'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_CLIENT_AVATAR_WIDTH_DESC'),
					'std'=>32,
					'min'=>16,
					'max'=>128
				),


				'class'=>array(
					'type'=>'text',
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_CLASS'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_CLASS_DESC'),
					'std'=> ''
				),

				// Repeatable Items
				
				'sp_testimonialflex_item'=>array(
					'title'=>Text::_('Testimonials'),

					'attr'=>array(
						'title'=>array(
							'type'=>'text',
							'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_PRO_ITEM_TITLE'),
							'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_PRO_ITEM_TITLE_DESC'),
							'std'=>'John Doe',
						),

						'avatar'=>array(
							'type'=>'media',
							'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_PRO_CLIENT_IMAGE'),
							'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_PRO_CLIENT_IMAGE_DESC'),
							'std'=>array(
								'src'=>'',
							)
						),
						
						'avatar_style'=>array(
							'type'=>'select', 
							'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_PRO_AVATAR_STYLE'),
							'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_PRO_AVATAR_STYLE_DESC'),
							'values'=>array(
								''=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_STANDARD'),
								'sppb-img-rounded'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_ROUNDED'),
								'sppb-img-circle'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_CIRCLE'),
								),
							'std'=>'sppb-img-rounded',
							),
							
						'avatar_position'=>array(
							'type'=>'select', 
							'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_CLIENT_AVATAR_POSITION'),
							'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_CLIENT_AVATAR_POSITION_DESC'),
							'values' =>array(
								'left'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_LEFT'),
								'center'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_CENTER'),
								'right'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_RIGHT'),
								),
							'std' => 'left'
						),

						'message'=>array(
							'type'=>'editor',
							'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_PRO_ITEM_TEXT'),
							'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_PRO_ITEM_TEXT_DESC'),
							'std'=> 'Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et.'
						),
						
					'url'=>array(
						'type'=>'text', 
						'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_PRO_CLIENT_URL'),
						'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_PRO_CLIENT_URL_DESC'),
						),
	
					'link_target'=>array(
						'type'=>'select', 
						'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_TARGET'),
						'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_TARGET_DESC'),
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
