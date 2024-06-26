<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');

class ElementParser {
	
    public static function viewPage ($content, $bootstrap_version, $full_width, $animate, $content_plugins) {
		if (is_array($content)) {
			$doc 		= JFactory::getDocument();
            $html		= '';
			
			if (!$full_width) {
				$html .= '<div class="container">';
			}
            foreach ($content as $row) {
				$row 				= RSPageBuilderHelper::toArray($row);
                $row_options		= RSPageBuilderHelper::escapeHtmlArray($row['options']);
				$row_style			= array();
				$row_title_style	= array();
				$row_subtitle_style = array();
				$row_overlay_style	= array();
				$section_class		= '';
				
				if (!isset($row_options['publish']) || (isset($row_options['publish']) && $row_options['publish'] == '1')) {
					
					// Build row title style
					if (!empty($row_options['title'])) {
						if (!empty($row_options['title_font_size'])) {
							$row_title_style['font-size'] = $row_options['title_font_size'];
						}
						if (!empty($row_options['title_font_weight'])) {
							$row_title_style['font-weight'] = $row_options['title_font_weight'];
						}
						if (!empty($row_options['title_text_color'])) {
							$row_title_style['color'] = $row_options['title_text_color'];
						}
						if (!empty($row_options['title_margin'])) {
							$row_title_style['margin'] = $row_options['title_margin'];
						}
						if (!empty($row_options['title_padding'])) {
							$row_title_style['padding'] = $row_options['title_padding'];
						}
					}
					
					// Build row subtitle style
					if (!empty($row_options['subtitle'])) {
						if (!empty($row_options['subtitle_font_size'])) {
							$row_subtitle_style['font-size'] = $row_options['subtitle_font_size'];
						}
						if (!empty($row_options['subtitle_font_weight'])) {
							$row_subtitle_style['font-weight'] = $row_options['subtitle_font_weight'];
						}
						if (!empty($row_options['subtitle_text_color'])) {
							$row_subtitle_style['color'] = $row_options['subtitle_text_color'];
						}
						if (!empty($row_options['subtitle_margin'])) {
							$row_subtitle_style['margin'] = $row_options['subtitle_margin'];
						}
						if (!empty($row_options['subtitle_padding'])) {
							$row_subtitle_style['padding'] = $row_options['subtitle_padding'];
						}
					}
					
					// Build row style
					if (!empty($row_options['text_color'])) {
						$row_style['color'] = $row_options['text_color'];
					}
					if (!empty($row_options['background_color'])) {
						$row_style['background-color'] = $row_options['background_color'];
					}
					if (!empty($row_options['background_image'])) {
						$row_style['background-image'] = $row_options['background_image'];
					}
					if (!empty($row_options['background_repeat'])) {
						$row_style['background-repeat'] = $row_options['background_repeat'];
					}
					if (!empty($row_options['background_size'])) {
						$row_style['background-size'] = $row_options['background_size'];
					}
					if (!empty($row_options['background_attachment'])) {
						$row_style['background-attachment'] = $row_options['background_attachment'];
					}
					if (!empty($row_options['background_position'])) {
						$row_style['background-position'] = str_replace('-', ' ', $row_options['background_position']);
					}
					if (!empty($row_options['margin'])) {
						$row_style['margin'] = $row_options['margin'];
					}
					if (!empty($row_options['padding'])) {
						$row_style['padding'] = $row_options['padding'];
					}
					if (!empty($row_options['class'])) {
						if ($bootstrap_version == 4 || $bootstrap_version == 5) {
							$section_class = $row_options['class'];
							$row_options['class'] = '';
						} else {
							$row_options['class'] = ' '.$row_options['class'];
						}
					} else {
						$row_options['class'] = '';
					}
					if (!empty($row_options['background_overlay_opacity']) && !empty($row_options['background_overlay_color'])) {
						if ($bootstrap_version == 4 || $bootstrap_version == 5) {
							$section_class .= ' has-overlay';
						} else {
							$row_options['class'] .= ' has-overlay';
						}
					}
					if (!empty($row_options['id'])) {
						$row_options['id'] = ' id="'.$row_options['id'].'"';
					} else {
						$row_options['id'] = '';
					}
					
					$section_class = $section_class ? ' class="'.$section_class.'"' : '';
					
					// Build section HTML
					$html .= '<section'.(($bootstrap_version == 4 || $bootstrap_version == 5) ? $section_class.RSPageBuilderHelper::buildStyle($row_style) : '').'>';

					// Build row HTML
					if (($row_options['row_full_width'] == '0') && $full_width && ($bootstrap_version == 4 || $bootstrap_version == 5)) {
						$html .= '<div class="container">';
					}
					
					$html .= '<div'.$row_options['id'].' class="'.RSPageBuilderHelper::getGridElement('row', $bootstrap_version).' animation-container'.$row_options['class'].'"'.(($bootstrap_version == 2 || $bootstrap_version == 3) ? RSPageBuilderHelper::buildStyle($row_style) : '').'>';
					
					if (($row_options['row_full_width'] == '0') && $full_width && ($bootstrap_version == 2 || $bootstrap_version == 3)) {
						$html .= '<div class="container">';
					}
					
					if (!empty($row_options['title'])) {
						$html .= '<'.$row_options['title_heading'].' class="rspbld-row-title '.$row_options['heading_alignment'].'"'.RSPageBuilderHelper::buildStyle($row_title_style).'>';
						$html .= $row_options['title'];
						$html .= '</'.$row_options['title_heading'].'>';
					}
					if (!empty($row_options['subtitle'])) {
						$html .= '<'.$row_options['subtitle_heading'].' class="rspbld-row-subtitle '.$row_options['heading_alignment'].'"'.RSPageBuilderHelper::buildStyle($row_subtitle_style).'>';
						$html .= $row_options['subtitle'];
						$html .= '</'.$row_options['subtitle_heading'].'>';
					}
					foreach ($row['columns'] as $column) {
						$column_options			= RSPageBuilderHelper::escapeHtmlArray($column['options']);
						$column_style			= array();
						$column_title_style		= array();
						$column_subtitle_style	= array();
						
						if (!isset($column_options['publish']) || (isset($column_options['publish']) && $column_options['publish'] == '1')) {
							// Build column title style
							if (!empty($column_options['title'])) {
								if (!empty($column_options['title_font_size'])) {
									$column_title_style['font-size'] = $column_options['title_font_size'];
								}
								if (!empty($column_options['title_font_weight'])) {
									$column_title_style['font-weight'] = $column_options['title_font_weight'];
								}
								if (!empty($column_options['title_text_color'])) {
									$column_title_style['color'] = $column_options['title_text_color'];
								}
								if (!empty($column_options['title_margin'])) {
									$column_title_style['margin'] = $column_options['title_margin'];
								}
								if (!empty($column_options['title_padding'])) {
									$column_title_style['padding'] = $column_options['title_padding'];
								}
							}
							
							// Build column subtitle style
							if (!empty($column_options['subtitle'])) {
								if (!empty($column_options['subtitle_font_size'])) {
									$column_subtitle_style['font-size'] = $column_options['subtitle_font_size'];
								}
								if (!empty($column_options['subtitle_font_weight'])) {
									$column_subtitle_style['font-weight'] = $column_options['subtitle_font_weight'];
								}
								if (!empty($column_options['subtitle_text_color'])) {
									$column_subtitle_style['color'] = $column_options['subtitle_text_color'];
								}
								if (!empty($column_options['subtitle_margin'])) {
									$column_subtitle_style['margin'] = $column_options['subtitle_margin'];
								}
								if (!empty($column_options['subtitle_padding'])) {
									$column_subtitle_style['padding'] = $column_options['subtitle_padding'];
								}
							}
							
							// Build column style
							if (!empty($column_options['text_color'])) {
								$column_style['color'] = $column_options['text_color'];
							}
							if (!empty($column_options['background_color'])) {
								$column_style['background-color'] = $column_options['background_color'];
							}
							if (!empty($column_options['margin'])) {
								$column_style['margin'] = $column_options['margin'];
							}
							if (!empty($column_options['padding'])) {
								$column_style['padding'] = $column_options['padding'];
							}
							
							// Build column class
							if ($animate) {
								if (!empty($column_options['animation_type'])) {
									$column_options['class'] .= ' animation rspbld-'.$column_options['animation_type'];
									
									// Load column animations style
									RSPageBuilderHelper::loadAsset('component', 'animations.css');
									
									// Load column animations script
									RSPageBuilderHelper::loadAsset('component', 'jquery.visible.min.js');
								}
								if (!empty($column_options['animation_duration'])) {
									$column_options['class'] .= ' duration-'.$column_options['animation_duration'];
								}
								if (!empty($column_options['animation_delay'])) {
									$column_options['class'] .= ' delay-'.$column_options['animation_delay'];
								}
							}
							if (!empty($column_options['class'])) {
								$column_options['class'] = ' '.$column_options['class'];
							}
							if (!empty($column_options['id'])) {
								$column_options['id'] = ' id="'.$column_options['id'].'"';
							} else {
								$column_options['id'] = '';
							}
							
							// Build column HTML
							$html .= '<div'.$column_options['id'].' class="'.RSPageBuilderHelper::getGridElement($column['grid'], $bootstrap_version).$column_options['class'].'"'.RSPageBuilderHelper::buildStyle($column_style).'>';
							if (!empty($column_options['title'])) {
								$html .= '<'.$column_options['title_heading'].' class="rspbld-column-title '.$column_options['heading_alignment'].'"'.RSPageBuilderHelper::buildStyle($column_title_style).'>';
								$html .= $column_options['title'];
								$html .= '</'.$column_options['title_heading'].'>';
							}
							if (!empty($column_options['subtitle'])) {
								$html .= '<'.$column_options['subtitle_heading'].' class="rspbld-column-subtitle '.$column_options['heading_alignment'].'"'.RSPageBuilderHelper::buildStyle($column_subtitle_style).'>';
								$html .= $column_options['subtitle'];
								$html .= '</'.$column_options['subtitle_heading'].'>';
							}
							
							// Build element
							foreach ($column['elements'] as $element) {
								$element_options = RSPageBuilderHelper::escapeHtmlArray($element['options']);
								
								if (!isset($element_options['publish']) || (isset($element_options['publish']) && $element_options['publish'] == '1')) {
									$html .= RSPageBuilderHelper::loadElementLayout($element, $bootstrap_version, $content_plugins);
									
									// Load element style sheet
									RSPageBuilderHelper::loadAsset('element', 'bootstrap' . $bootstrap_version . '/' . str_replace('rspbld_', '', $element['type']).'.css');
								}
							}
							$html .= '</div>'; // end column
						}
					}
					
					// Build row background overlay for Bootstrap 2 and 3
					if (!empty($row_options['background_overlay_opacity']) && ($bootstrap_version == 2 || $bootstrap_version == 3)) {
						$row_overlay_style['opacity'] = $row_options['background_overlay_opacity'];
						
						if (!empty($row_options['background_overlay_color'])) {
							$row_overlay_style['background-color'] = $row_options['background_overlay_color'];
						}
						$html .= '<div class="overlay"'.RSPageBuilderHelper::buildStyle($row_overlay_style).'></div>';
					}
					$html .= '</div>'; // end row
					
					if (($row_options['row_full_width'] == '0') && $full_width) {
						$html .= '</div>';
					}
					
					// Build row (section) background overlay for Bootstrap 4 and 5
					if (!empty($row_options['background_overlay_opacity']) && ($bootstrap_version == 4 || $bootstrap_version == 5)) {
						$row_overlay_style['opacity'] = $row_options['background_overlay_opacity'];
						
						if (!empty($row_options['background_overlay_color'])) {
							$row_overlay_style['background-color'] = $row_options['background_overlay_color'];
						}
						$html .= '<div class="overlay"'.RSPageBuilderHelper::buildStyle($row_overlay_style).'></div>';
					}
					$html .= '</section>'; // end section
				}
            }
			if (!$full_width) {
				$html .= '</div>'; // end container
			}
			
			return $html;
        } else {
			return '<p>'.RSPageBuilderHelper::escapeHtml($content).'</p>';
        }
    }
}