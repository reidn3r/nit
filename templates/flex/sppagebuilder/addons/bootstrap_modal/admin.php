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
		'type'=>'content',
		'addon_name'=>'sp_bootstrap_modal',
		'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_BOOTSTRAP_MODAL'),
		'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_BOOTSTRAP_MODAL_DESC'),
		'category'=>'Flex',
		'attr'=>array(
			'general' => array(

				'admin_label'=>array(
					'type'=>'text',
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_ADMIN_LABEL'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_ADMIN_LABEL_DESC'),
					'std'=> ''
				),

				'modal_selector'=>array(
					'type'=>'select',
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_SELECTOR'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_SELECTOR_DESC'),
					'values'=>array(
						'button'=>Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_SELECTOR_BUTTON'),
						'image'=>Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_SELECTOR_IMAGE'),
						),
					'std'=>'button',
					),
				'button_text'=>array(
					'type'=>'text', 
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_TEXT'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_TEXT_DESC'),
					'std'=>'Button',
					'depends'=>array('modal_selector'=>'button')
					),
				'button_size'=>array(
					'type'=>'select', 
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_SIZE'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_SIZE_DESC'),
					'values'=>array(
						''=>Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_SIZE_DEFAULT'),
						'lg'=>Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_SIZE_LARGE'),
						'sm'=>Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_SIZE_SMALL'),
						'xs'=>Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_SIZE_EXTRA_SAMLL'),
						),
					'depends'=>array('modal_selector'=>'button')
					),
				'button_type'=>array(
					'type'=>'select', 
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_TYPE'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_TYPE_DESC'),
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
					'depends'=>array('modal_selector'=>'button')
					),
				'button_peicon'=>array(
					'type'=>'select', 
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_PIXEDEN_ICON'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_PIXEDEN_ICON_DESC'),
					'std'=> '',
					'depends'=>array('modal_selector'=>'button'),
					'values'=> $peicon_list
					),
				'button_icon'=>array(
					'type'=>'icon', 
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_FONTAWESOME_ICON'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_FONTAWESOME_ICON_DESC'),
					'depends'=>array('modal_selector'=>'button')
					),
				'button_block'=>array(
					'type'=>'select', 
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_BLOCK'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_BLOCK_DESC'),
					'values'=>array(
						''=>Text::_('JNO'),
						'sppb-btn-block'=>Text::_('JYES'),
						),
					'depends'=>array(
						array('modal_selector', '=', 'button')
					),
				),
				'button_icon_position'=>array(
					'type'=>'select',
					'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_ICON_POSITION'),
					'values'=>array(
						'left'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_LEFT'),
						'right'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_RIGHT'),
					),
					'depends'=>array(
						array('modal_selector', '=', 'button')
					),
				),

				'selector_image'=>array(
					'type'=>'media', 
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_SELECTOR_IMAGE'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_SELECT_DESC'),
					'depends'=>array('modal_selector'=>'image')
					),
				'alignment'=>array(
					'type'=>'select',
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_CONTENT_ALIGNMENT'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_CONTENT_ALIGNMENT_DESC'),
					'values'=>array(
						'sppb-text-left'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_LEFT'),
						'sppb-text-center'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_CENTER'),
						'sppb-text-right'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_RIGHT'),
						),
					'std'=>'sppb-text-left',
					),
				//Admin Only
				'separator'=>array(
					'type'=>'separator', 
					'title'=>Text::_('COM_SPPAGEBUILDER_MODAL_CONTENT'),
					),
				'modal_window_title'=>array(
					'type'=>'text', 
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_BOOTSTRAP_MODAL_WINDOW_TITLE'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_BOOTSTRAP_MODAL_WINDOW_TITLE_DESC'),
					'std'=>'Modal'
					),
				'modal_content_text'=>array(
					'type'=>'editor', 
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_TEXT'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_TEXT_DESC'),
					'std'=>'Credibly reintermediate backend ideas for cross-platform models. Continually reintermediate integrated processes through technically sound intellectual capital. Holistically foster superior methodologies without market-driven best practices.&lt;br&gt;&lt;br&gt;Distinctively exploit optimal alignments for intuitive bandwidth. Quickly coordinate e-business applications through revolutionary catalysts for change. Seamlessly underwhelm optimal testing procedures whereas bricks-and-clicks processes. Synergistically evolve 2.0 technologies rather than just in time initiatives. Quickly deploy strategic networks with compelling e-business. Credibly pontificate highly efficient manufactured products and enabled data.',
					),
				'modal_content_image'=>array(
					'type'=>'media', 
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_IMAGE'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_IMAGE_DESC'),
					),
				'modal_content_video_url'=>array(
					'type'=>'text', 
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_VIDEO'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_VIDEO_URL_DESC'),
					),
				'modal_window_size'=>array(
					'type'=>'select',
					'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_WINDOW_SIZE'),
					'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_WINDOW_SIZE_DESC'),
					'values'=>array(
						''=>Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_WINDOW_SIZE_STANDARD'),
						'sppb-modal-lg'=>Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_WINDOW_SIZE_LARGE'),
						'sppb-modal-sm'=>Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_WINDOW_SIZE_SMALL'),
						),
					'std'=>'',
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