var RSPageBuilderHelper = {
	timer: null,
	
	// Make rows sortable
	sortableRows: function(obj) {
		obj.sortable({
			placeholder				: 'ui-state-highlight',
			forcePlaceholderSize	: true,
			axis					: 'y',
			opacity					: 0.8,
			tolerance				: 'pointer',
			start					: function(event, ui) {
				ui.item.css({
					'left'				: '50%',
					'-webkit-transform' : 'translateX(-50%)',
					'-moz-transform' 	: 'translateX(-50%)',
					'transform' 		: 'translateX(-50%)'
				});
				ui.item.closest('.rspbld-wrapper').find('.ui-state-highlight').css({
					'margin-left'	: 'auto',
					'margin-right'	: 'auto',
					'height'		: ui.item.outerHeight(),
					'width'			: ui.item.width()
				});
			},
			stop: function(event, ui) {
				ui.item.removeAttr('style');
			}
		}).disableSelection();
	},
	
	// Make columns resizable
	resizableColumns: function(obj) {
		obj.each(function() {
			var columns			= 12,
				full_width		= jQuery(this).width(),
				column_width	= full_width / columns,
				total_columns,
				update_column	= function(column, size) {
					column.css('width', '');
					column.removeClass(function(index, className) {
					  return (className.match(/(^|\s)span\S+/g) || []).join(' ');
					});
					column.addClass('span' + size);
					
					// Update column size
					column.find('.column-size').empty();
					column.find('.column-size').append('<sup>' + size + '</sup>/<sub>12</sub>');
					
					// Update column grid
					column_attributes		= JSON.parse(JSON.stringify(eval('(' + column.find('.column-json').val() + ')')));
					column_attributes.grid	= size;
					column.find('.column-json').val(JSON.stringify(column_attributes));
					
					// Update row grid
					row						= column.closest('.row');
					row_attributes			= JSON.parse(JSON.stringify(eval('(' + row.find('.row-json').val() + ')')));
					row_grid				= '';
					row.find('.column').each(function() {
						row_grid += JSON.parse(JSON.stringify(eval('(' + jQuery(this).find('.column-json').val() + ')'))).grid;
					});
					row_attributes.grid		= row_grid;
					row.find('.row-json').val(JSON.stringify(row_attributes));
				};
				
			jQuery(this).find('.column').not(':last-child').resizable({
				handles: 'e',
				start: function(event, ui) {
					var target			= ui.element,
						next			= target.next(),
						target_column	= Math.round(target.width() / column_width),
						next_column		= Math.round(next.width() / column_width);
						
					total_columns = target_column + next_column;
					target.resizable('option', 'minWidth', column_width);
					target.resizable('option', 'maxWidth', (total_columns - 1) * column_width);
				},
				resize: function(event, ui) {
					var target				= ui.element,
						next				= target.next(),
						target_column_count	= Math.round(target.width() / column_width),
						next_column_count	= Math.round(next.width() / column_width),
						target_set			= total_columns - next_column_count,
						next_set			= total_columns - target_column_count;
						
					update_column(target, target_set);
					update_column(next, next_set);
				}
			});
		});
	},
	
	// Make elements sortable
	sortableElements: function(obj) {
		obj.sortable({
			connectWith				: obj,
			items					: '.element-container',
			placeholder				: 'ui-state-highlight',
			forcePlaceholderSize	: true,
			opacity					: 0.8,
			tolerance				: 'pointer',
			start					: function(event, ui) {
				ui.item.parent().find('.ui-state-highlight').css({
					'height'	: ui.item.outerHeight()
				});
			},
			stop					: function(event, ui) {
				ui.item.removeAttr('style');
			}
		}).disableSelection();
	},
	
	// Make items sortable
	sortableItems: function(obj) {
		obj.sortable({
			handle			: '.move-item',
			placeholder		: 'ui-state-highlight',
			axis			: 'y',
			opacity			: 0.8,
			tolerance		: 'pointer',
			start			: function(event, ui) {
				RSPageBuilderHelper.removeComponents(ui.item);
				ui.item.closest('.iterative-items.accordion').find('.ui-state-highlight').css({
					'height'	: ui.item.outerHeight(),
					'width'		: ui.item.width()
				});
			},
	        stop			: function(event, ui) {
				RSPageBuilderHelper.initComponents(ui.item);
				RSPageBuilderHelper.changeElement();
	    	}
		});
	},
	
	// Initialize jQuery UI
	initjQueryUI: function() {
		RSPageBuilderHelper.sortableRows(jQuery('.rspbld-wrapper'));
		RSPageBuilderHelper.sortableElements(jQuery('.rspbld-container .column-content'));
		RSPageBuilderHelper.resizableColumns(jQuery('.rspbld-container .row .columns'));
	},
	
	// Edit element
	editElement: function(obj) {
		var clone = obj.clone();
		
		clone.find('.element-options').removeClass('hidden');
		clone.find('.element-json').val(JSON.stringify(RSPageBuilderHelper.buildElementJson(clone)));
		
		if (rspbld_jversion >= 4) {
			jQuery('#modal-element-settings .modal-body .col-md-6:first').empty();
			jQuery('#modal-element-settings .modal-body .col-md-6:first').append(clone);
		} else {
			jQuery('#modal-element-settings .modal-body .span6:first').empty();
			jQuery('#modal-element-settings .modal-body .span6:first').append(clone);
		}
		
		RSPageBuilderHelper.elementHtmlAjax(clone.find('.edit-element'), clone.find('.element-json').val(), RSPageBuilderHelper.getBootstrapVersion());
		RSPageBuilderHelper.initComponents(jQuery('#modal-element-settings .element'));
		setTimeout(function() {
			RSPageBuilderHelper.fixAccordion();
			RSPageBuilderHelper.initGoogleMap(jQuery('#modal-element-settings .element-container'));
			RSPageBuilderHelper.initOpenStreetMap(jQuery('#modal-element-settings .element-container'));
		}, 1000);
		RSPageBuilderHelper.fixMooToolsCarousel();
		RSPageBuilderHelper.sortableItems(jQuery('#modal-element-settings .accordion'));
		RSPageBuilderHelper.initOptionsTab();
		
		jQuery('#modal-element-settings .loader').fadeOut(200);
		jQuery('#modal-element-settings .row-fluid').fadeIn(200);
	},
	
	// Duplicate iterative item
	duplicateItem: function(obj) {
		RSPageBuilderHelper.removeComponents(jQuery('#modal-element-settings .accordion'));
		
		var clone			= obj.clone(),
			new_id			= RSPageBuilderHelper.randomNumber(),
			items_number	= jQuery('#modal-element-settings .iterative-items .accordion-group, #modal-element-settings .iterative-items .accordion-item').length;
			
		if (rspbld_jversion >= 4) {
			clone.find('.accordion-header .accordion-button').attr('href', '#' + new_id).attr('data-target', '#' + new_id).attr('aria-controls', new_id).attr('aria-expanded', 'false');
			clone.find('.collapse').attr('id', new_id).removeClass('show');
			clone.find('.rspbld-input, .js-editor-tinymce > .joomla-editor-tinymce, joomla-editor-codemirror > textarea, .codemirror-source, joomla-editor-none > textarea, .js-editor-none > textarea').each(function() {
				var item_segments = jQuery(this).attr('data-name').split('-');
					
				jQuery(this).attr('data-name', item_segments[0] + '-' + (items_number + 1));
				jQuery(this).attr('id', jQuery(this).attr('data-name').replace('-', '_'));
			});
			obj.closest('.accordion').append(clone);
		} else {
			clone.find('.accordion-heading .accordion-toggle').attr('href', '#' + new_id);
			clone.find('.accordion-body').attr('id', new_id);
			clone.find('.collapse').removeClass('in');
			clone.find('.rspbld-input, .js-editor-tinymce > .joomla-editor-tinymce, joomla-editor-codemirror > textarea, .codemirror-source, joomla-editor-none > textarea, .js-editor-none > textarea').each(function() {
				var item_segments = jQuery(this).attr('data-name').split('-');
					
				jQuery(this).attr('data-name', item_segments[0] + '-' + (items_number + 1));
				jQuery(this).attr('id', jQuery(this).attr('data-name').replace('-', '_'));
			});
			obj.closest('.accordion').append(clone);
		}
		
		RSPageBuilderHelper.initComponents(jQuery('#modal-element-settings .accordion'));
		RSPageBuilderHelper.sortableItems(jQuery('#modal-element-settings .accordion'));
	},
	
	// Initialize tooltip
	initTooltip: function() {
		if (rspbld_jversion >= 4) {
			jQuery('*[data-bs-toggle="tooltip"]').tooltip({
				trigger		: 'hover',
				html		: true,
				placement	: 'top'
			});
		} else {
			jQuery('*[data-toggle="tooltip"]').tooltip({
				trigger		: 'hover',
				html		: true,
				placement	: 'top'
			});
		}
	},
	
	// Destroy tooltip
	destroyThisTooltip: function(obj) {
		if (rspbld_jversion >= 4) {
			obj.find('*[data-bs-toggle="tooltip"]').tooltip('dispose');
		} else {
			obj.find('*[data-toggle="tooltip"]').tooltip('destroy');
		}
	},

	// Remove tooltip
	removeTooltip: function() {
		if (rspbld_jversion >= 4) {
			jQuery('*[data-bs-toggle="tooltip"]').tooltip('dispose');
		} else {
			jQuery('*[data-toggle="tooltip"]').tooltip('destroy');
		}
	},
	
	// Initialize popover
	initPopover: function() {
		if (rspbld_jversion >= 4) {
			jQuery('*[data-bs-toggle="popover"]').popover({
				trigger		: 'hover',
				html		: true,
				placement	: 'right'
			});
		} else {
			jQuery('*[data-toggle="popover"]').popover({
				trigger		: 'hover',
				html		: true,
				placement	: 'right'
			});
		}
	},
	
	// Destroy popover
	destroyThisPopover: function(obj) {
		if (rspbld_jversion >= 4) {
			obj.find('*[data-bs-toggle="popover"]').popover('dispose');
		} else {
			obj.find('*[data-toggle="popover"]').popover('destroy');
		}
	},

	// Remove popover
	removePopover: function() {
		if (rspbld_jversion >= 4) {
			jQuery('*[data-bs-toggle="popover"]').popover('dispose');
		} else {
			jQuery('*[data-toggle="popover"]').popover('destroy');
		}
	},
	
	// Remove videos
	removeVideos: function() {
		var video_container = jQuery('.rspbld-video .rspbld-video-player, .rspbld-video .rspbld-vimeo-video, .rspbld-video .rspbld-youtube-video');
		
		if (video_container.length) {
			video_container.remove();
		}
	},
	
	// Initialize Joomla/Bootstrap components
	initComponents: function(obj) {
		
		// Initialize radio btn-group
		obj.find('.btn-group.radio').each(function() {
			var field		= jQuery(this),
				field_id	= (rspbld_jversion >= 4) ? jQuery(this).closest('fieldset').attr('id') : jQuery(this).attr('id');
			
			if (field.closest('.tab-pane').attr('id') != 'items') {
				field.find('input[checked="checked"]').attr('data-name', field_id);
			} else {
				field.find('input[checked="checked"]').attr('data-name', field_id.replace(/_(\d+)$/, '-$1'));
			}
			field.find('input[checked="checked"]').addClass('rspbld-input');
			
			if (rspbld_jversion == 3) {
				field.find('label').addClass('btn');
				field.find('label[for="' + field.find('input[checked="checked"]').attr('id') + '"]').addClass('active');
				
				if (field.find('input[checked="checked"]').val() == 0) {
					field.find('label[for="' + field.find('input[checked="checked"]').attr('id') + '"]').addClass('btn-danger');
				} else {
					field.find('label[for="' + field.find('input[checked="checked"]').attr('id') + '"]').addClass('btn-success');
				}
			}
			
			field.find('label').on('click', function() {
				if (jQuery(this).hasClass('active') || field.find('#' + jQuery(this).attr('for')).prop('checked')) {
					return true;
				} else {
					var danger_class	= (rspbld_jversion >= 4) ? 'btn-outline-danger' : 'btn-danger',
						success_class	= (rspbld_jversion >= 4) ? 'btn-outline-success' : 'btn-success';
					
					field.find('input').removeAttr('checked');
					field.find('input').prop('checked', false);
					field.find('input').checked = false;
					field.find('input').removeAttr('data-name');
					field.find('input').removeClass('rspbld-input');
					field.find('label').removeClass('active');
					field.find('label').removeClass(danger_class);
					field.find('label').removeClass(success_class);
					field.find('#' + jQuery(this).attr('for')).attr('checked', '');
					field.find('#' + jQuery(this).attr('for')).prop('checked', true);
					field.find('#' + jQuery(this).attr('for')).checked = true;
					
					if (field.closest('.tab-pane').attr('id') != 'items') {
						field.find('#' + jQuery(this).attr('for')).attr('data-name', field_id);
					} else {
						field.find('#' + jQuery(this).attr('for')).attr('data-name', field_id.replace(/_(\d+)$/, '-$1'));
					}
					field.find('#' + jQuery(this).attr('for')).addClass('rspbld-input');
					
					if (jQuery('#' + jQuery(this).attr('for')).val() == 0) {
						jQuery(this).addClass(danger_class);
					} else {
						jQuery(this).addClass(success_class);
					}
					jQuery(this).addClass('active');
					
					// Showon
					field.closest('.tab-pane').find('[data-showon^="' + field.find('input').attr('name') + ':"]').each(function() {
						var showon		= jQuery(this).attr('data-showon').split(':'),
							showon_val	= field.find('input:checked').val();
							
						if (showon[1] == showon_val) {
							jQuery(this).slideDown();
						} else {
							jQuery(this).slideUp();
						}
					});
					
					// Dynamically change element
					if (field.closest('#modal-element-settings .element-options').length) {
						RSPageBuilderHelper.changeElement();
					}
				}
			});
		});
		
		// Initialize iterative items accordion
		if (rspbld_jversion >= 4) {
			obj.find('.accordion-item').each(function() {
				var id = RSPageBuilderHelper.randomNumber();
				
				jQuery(this).find('.accordion-header .accordion-button').attr('href', '#item' + id).attr(RSPageBuilderHelper.getBootstrapElement('data', 'target'), '#item' + id).attr('aria-controls', 'item' + id);
				jQuery(this).find('.accordion-collapse').attr('id', 'item' + id);
			});
			
			// Fix for CodeMirror display
			jQuery('.iterative-items.accordion').on('shown.bs.collapse', function() {
				jQuery(this).find('joomla-editor-codemirror').each(function () {
					var textarea_id = jQuery(this).find('> textarea').attr('id');
					
					if (typeof Joomla.editors.instances[textarea_id] !== 'undefined') {
						Joomla.editors.instances[textarea_id].refresh();
					}
				});
			});
		} else {
			obj.find('.accordion-group').each(function() {
				var id = RSPageBuilderHelper.randomNumber();
				
				jQuery(this).find('.accordion-toggle').attr('href', '#item' + id);
				jQuery(this).find('.accordion-body').attr('id', 'item' + id);
			});
		}
		
		// Initialize element / item Joomla! calendar
		var calendar_fields = obj.find('.field-calendar');
		
		for (i = 0; i < calendar_fields.length; i++) {
			JoomlaCalendar.init(calendar_fields[i]);
		}
		
		// Initialize element / item chosen
		if (rspbld_jversion == 3) {
			jQuery('.element-options select').chosen();
		}
		
		// Initialize element / item color picker
		obj.find('.color').each(function() {
			jQuery(this).minicolors({
				control		: jQuery(this).attr('data-control') || 'hue',
				position	: jQuery(this).attr('data-position') || 'bottom',
				theme		: 'bootstrap',
				changeDelay	: 200,
				change		: function() {
					RSPageBuilderHelper.changeElement();
				}
			});
		});
		
		// Initialize element / item TinyMCE editor
		obj.find('.js-editor-tinymce > .joomla-editor-tinymce').each(function () {
			var id				= 'editor-' + RSPageBuilderHelper.randomNumber(),
				name			= jQuery(this).attr('name').replace(/\[\]|\]/g, '').split('[').pop();
				pluginOptions	= Joomla.getOptions ? Joomla.getOptions('plg_editor_tinymce', {}) : (Joomla.optionsStorage.plg_editor_tinymce || {});
				
			jQuery(this).attr('id', id);
			
			if (typeof pluginOptions.tinyMCE == 'undefined') {
				pluginOptions.tinyMCE = {};
			}
			if (typeof pluginOptions.tinyMCE.tinymce == 'undefined') {
				pluginOptions.tinyMCE.tinymce = {};
			}
			
			if (typeof pluginOptions.tinyMCE.default == 'undefined') {
				var tinymce_base	= (rspbld_jversion >= 4) ? rspbld_root + 'media/editors/tinymce' : rspbld_root + 'media/vendor/tinymce',
					theme			= (rspbld_jversion >= 4) ? 'silver' : 'modern',
					skin			= (rspbld_jversion >= 4) ? 'oxide' : 'lightgray';
				
				pluginOptions.tinyMCE.default = {
					setCustomDir				: rspbld_root,
					suffix						: '.min',
					baseURL						: tinymce_base,
					directionality				: jQuery('html').attr('dir'),
					language					: jQuery('html').attr('lang').substr(0, 2),
					autosave_restore_when_empty	: false,
					skin						: skin,
					theme						: theme,
					schema						: 'html5',
					menubar						: 'edit insert view format table tools',
					toolbar1					: 'bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect | formatselect fontselect fontsizeselect | searchreplace | bullist numlist | outdent indent | undo redo | link unlink anchor image | code | forecolor backcolor | fullscreen | table | subscript superscript | charmap emoticons media hr ltr rtl | cut copy paste pastetext | visualchars visualblocks nonbreaking blockquote template | print preview codesample insertdatetime removeformat',
					toolbar2					: null,
					plugins						: 'autolink,lists,save,colorpicker,importcss,searchreplace,link,anchor,image,code,textcolor,fullscreen,table,charmap,emoticons,media,hr,directionality,paste,visualchars,visualblocks,nonbreaking,template,print,preview,codesample,insertdatetime,advlist,autosave,contextmenu',
					inline_styles				: true,
					gecko_spellcheck			: true,
					entity_encoding				: 'raw',
					verify_html					: true,
					valid_elements				: '',
					extended_valid_elements		: 'hr[id|title|alt|class|width|size|noshade]',
					invalid_elements			: 'script,applet',
					relative_urls				: true,
					remove_script_host			: false,
					content_css					: rspbld_root + 'templates/system/css/editor.css',
					document_base_url			: rspbld_root,
					paste_data_images			: true,
					importcss_append			: true,
					image_title					: true,
					width						: '',
					resize						: 'both',
					templates					: [
					{
					  title			: 'Layout',
					  description	: 'HTML layout.',
					  url			: rspbld_root + 'media/editors/tinymce/templates/layout1.html'
					},
					{
					  title			: 'Simple Snippet',
					  description	: 'Simple HTML snippet.',
					  url			: rspbld_root + 'media/editors/tinymce/templates/snippet1.html'
					}
					],
					image_advtab	: true,
					'force_br_newlines'		: false,
					'force_p_newlines'		: true,
					'forced_root_block'		: 'p',
					'toolbar_items_size'	: 'small'
				}
			}
			
			pluginOptions.tinyMCE.tinymce.joomlaExtButtons			= {};
			pluginOptions.tinyMCE[name]								= pluginOptions.tinyMCE.tinymce;
			pluginOptions.tinyMCE.default.height					= '500px';
			pluginOptions.tinyMCE.default.init_instance_callback	= function(mce_editor) {
				mce_editor.on('change', function(e) {
					jQuery('#' + mce_editor.id).text(mce_editor.getContent());
					jQuery('#' + mce_editor.id).val(mce_editor.getContent());
					
					RSPageBuilderHelper.changeElement();
				});
			};
			
			if (jQuery(this).next('.toggle-editor').length) {
				jQuery(this).next('.toggle-editor').remove();
			}
			
			var rspbld_mce = new tinyMCE.Editor(id, pluginOptions.tinyMCE.default, tinymce.EditorManager);
			rspbld_mce.render();
			
			// Normally we should use this instead, but it overrides the init_instance_callback method
			// Joomla.JoomlaTinyMCE.setupEditor(document.getElementById(id), pluginOptions);
		});
		
		// Initialize element / item CodeMirror editor
		if (rspbld_jversion >= 4) {
			setTimeout(function() {
				obj.find('joomla-editor-codemirror').each(function () {
					jQuery(this).append('<div class="loader"></div>');
				});
			}, 200);
			setTimeout(function() {
				obj.find('joomla-editor-codemirror').each(function () {
					var id			= 'editor-' + RSPageBuilderHelper.randomNumber(),
						textarea	= jQuery(this).find('> textarea'),
						options		= JSON.parse(jQuery(this).attr('options')),
						old_id		= textarea.attr('id'),
						fs_combo	= jQuery(this).attr('fs-combo').toString();
					
					if (typeof Joomla.editors.instances[old_id] !== 'undefined') {
						Joomla.editors.instances[old_id].toTextArea();
					}
					
					// Fix for duplicate CodeMirror editor on Chrome browser
					if (jQuery(this).find('.CodeMirror').length) {
						jQuery(this).find('.CodeMirror').remove();
					}
					
					textarea.attr('id', id);
					
					if (typeof Joomla.editors.instances[id] == 'undefined') {
						Joomla.editors.instances[id] = window.CodeMirror.fromTextArea(document.getElementById(id), options);
						
						// Full Screen
						var toggleFullScreen	= function toggleFullScreen() {
								Joomla.editors.instances[id].setOption('fullScreen', !Joomla.editors.instances[id].getOption('fullScreen'));
							},
							closeFullScreen		= function closeFullScreen() {
								Joomla.editors.instances[id].getOption('fullScreen');
								Joomla.editors.instances[id].setOption('fullScreen', false);
							},
							map					= {};
						
						map[fs_combo]	= toggleFullScreen;
						map['Esc']		= closeFullScreen;
						
						Joomla.editors.instances[id].addKeyMap(map);
						Joomla.editors.instances[id].setSize('100%', 350);
						Joomla.editors.instances[id].on('blur', function() {
							textarea.text(Joomla.editors.instances[id].getValue());
							
							RSPageBuilderHelper.changeElement();
						});
					}
					
					jQuery(this).find('.loader').remove();
				});
			}, 1000);
		} else {
			obj.find('.codemirror-source').each(function () {
				var id			= 'editor-' + RSPageBuilderHelper.randomNumber(),
					textarea	= jQuery(this);
					
				textarea.attr('id', id);
				
				if (typeof Joomla.editors.instances[id] == 'undefined') {
					Joomla.editors.instances[id] = CodeMirror.fromTextArea(this, textarea.data('options'));
					Joomla.editors.instances[id].setSize('100%', 350);
					Joomla.editors.instances[id].on('blur', function() {
						textarea.text(Joomla.editors.instances[id].getValue());
						
						RSPageBuilderHelper.changeElement();
					});
				}
			});
		}
		
		// Initialize tooltip
		obj.find('.hasTooltip').tooltip({
			trigger		: 'hover',
			html		: true,
			placement	: 'top'
		});
		
		// Initialize popover
		obj.find('.hasPopover, *[data-bs-toggle="popover"]').popover({
			trigger		: 'hover',
			html		: true,
			placement	: 'right'
		});
		
		// Initialize icons list
		obj.find('.iconslist').each(function() {
			jQuery(this).iconsList();
		});
		obj.find('.icons-list').removeClass('hidden');
		
		// Initialize image upload
		obj.find('.media').each(function() {
			jQuery(this).uploadImage();
		});
		
		// Initialize Showon
		obj.find('[data-showon*=":"]').each(function() {
			var showon	= jQuery(this).attr('data-showon').split(':'),
				field	= obj.find('#' + showon[0]);
			
			if (field.length > 0) {
				if (showon[1] == field.find('input:checked').val()) {
					jQuery(this).show();
				} else {
					jQuery(this).hide();
				}
			}
		});
	},
	
	// Remove Joomla / Bootstrap components
	removeComponents: function(obj) {
		
		// Remove iterative items accordion
		obj.find('.accordion-group').each(function() {
			jQuery(this).find('.accordion-toggle').removeAttr('href');
			jQuery(this).find('.accordion-body').removeAttr('id');
		});
		
		// Remove element / item chosen
		if (rspbld_jversion == 3) {
			obj.find('select').chosen('destroy');
		}
		
		// Remove element / item color picker
		obj.find('.minicolors-input').each(function() {
			jQuery(this).minicolors('destroy');
		});
		
		// Remove element / item TinyMCE editor
		obj.find('.js-editor-tinymce > .joomla-editor-tinymce').each(function () {
			var id			= jQuery(this).attr('id'),
				mce_content	= tinyMCE.get(id).getContent();
				
			jQuery(this).text(mce_content);
			tinyMCE.execCommand('mceRemoveEditor', false, id);
		});
		
		// Remove element / item CodeMirror editor
		obj.find('.codemirror-source, joomla-editor-codemirror > textarea').each(function () {
			var id = jQuery(this).attr('id');
			
			if (typeof Joomla.editors.instances[id] !== 'undefined') {
				Joomla.editors.instances[id].toTextArea();
			}
			
			// Fix for duplicate CodeMirror editor on Chrome browser
			if (jQuery(this).find('.CodeMirror').length) {
				jQuery(this).find('.CodeMirror').remove();
			}
		});
		
		// Remove element / item media
		obj.find('.media').each(function() {
			jQuery(this).find('.input-media').removeAttr('id');
			
			// Element / item image preview
			jQuery(this).find('.image-preview').removeAttr('id');
			jQuery(this).find('.image-preview').find('img').removeAttr('id');
			jQuery(this).find('a.modal').removeAttr('href');
			jQuery(this).find('a.remove-media').removeAttr('onClick');
		});
		
		// Remove tooltip
		if (rspbld_jversion >= 4) {
			obj.find('.hasTooltip').tooltip('dispose');
		} else {
			obj.find('.hasTooltip').tooltip('destroy');
		}
		
		// Remove popover
		if (rspbld_jversion >= 4) {
			obj.find('.hasPopover').popover('dispose');
		} else {
			obj.find('.hasPopover').popover('destroy');
		}
		
		// Remove icons list
		obj.find('.iconslist').removeAttr('style');
		obj.find('.icons-list').addClass('hidden');
	},
	
	// Initialize Google maps
	initGoogleMap: function(obj = jQuery('#modal-element-settings .element-container')) {
		if (obj.closest('.rspbld').find('.map').length) {
			var map_container	= document.getElementById(obj.closest('.rspbld').find('.map').attr('id')),
				element			= JSON.parse(JSON.stringify(eval('(' + obj.find('.element-json').val() + ')'))),
				style			= [];
			
			if (element.options.map_color) {
				style = [
					{
						elementType	: "labels",
						stylers		: [
							{saturation: element.options.map_saturation}
						]
					},
					{
						featureType	: "poi",
						elementType	: "labels",
						stylers		: [
							{visibility: "off"}
						]
					},
					{
						featureType	: "road.highway",
						elementType	: "labels",
						stylers		: [
							{visibility: "off"}
						]
					},
					{
						featureType	: "road.local",
						elementType	: "labels.icon",
						stylers		: [
							{visibility: "off"}
						]
					},
					{
						featureType	: "road.arterial",
						elementType	: "labels.icon",
						stylers    	: [
							{visibility: "off"}
						]
					},
					{
						featureType	: "road",
						elementType	: "geometry.stroke",
						stylers    	: [
							{visibility: "off"}
						]
					},
					{
						featureType	: "transit",
						elementType	: "geometry.fill",
						stylers    	: [
							{hue		: element.options.map_color},
							{visibility	: "on"},
							{lightness	: element.options.map_brightness},
							{saturation	: element.options.map_saturation}
						]
					},
					{
						featureType	: "poi",
						elementType	: "geometry.fill",
						stylers    	: [
							{hue		: element.options.map_color},
							{visibility	: "on"},
							{lightness	: element.options.map_brightness},
							{saturation	: element.options.map_saturation}
						]
					},
					{
						featureType	: "poi.government",
						elementType	: "geometry.fill",
						stylers    	: [
							{hue		: element.options.map_color},
							{visibility	: "on"},
							{lightness	: element.options.map_brightness},
							{saturation	: element.options.map_saturation}
						]
					},
					{
						featureType	: "poi.sports_complex",
						elementType	: "geometry.fill",
						stylers    	: [
							{hue		: element.options.map_color},
							{visibility	: "on"},
							{lightness	: element.options.map_brightness},
							{saturation	: element.options.map_saturation}
						]
					},
					{
						featureType	: "poi.attraction",
						elementType	: "geometry.fill",
						stylers    	: [
							{hue		: element.options.map_color},
							{visibility	: "on"},
							{lightness	: element.options.map_brightness},
							{saturation	: element.options.map_saturation}
						]
					},
					{
						featureType	: "poi.business",
						elementType	: "geometry.fill",
						stylers    	: [
							{hue		: element.options.map_color},
							{visibility	: "on"},
							{lightness	: element.options.map_brightness},
							{saturation	: element.options.map_saturation}
						]
					},
					{
						featureType	: "transit",
						elementType	: "geometry.fill",
						stylers    	: [
							{hue		: element.options.map_color},
							{visibility	: "on"},
							{lightness	: element.options.map_brightness},
							{saturation	: element.options.map_saturation}
						]
					},
					{
						featureType	: "transit.station",
						elementType	: "geometry.fill",
						stylers    	: [
							{hue		: element.options.map_color},
							{visibility	: "on"},
							{lightness	: element.options.map_brightness},
							{saturation	: element.options.map_saturation}
						]
					},
					{
						featureType	: "landscape",
						stylers    	: [
							{hue		: element.options.map_color},
							{visibility	: "on"},
							{lightness	: element.options.map_brightness},
							{saturation	: element.options.map_saturation}
						]

					},
					{
						featureType	: "road",
						elementType	: "geometry.fill",
						stylers    	: [
							{hue		: element.options.map_color},
							{visibility	: "on"},
							{lightness	: element.options.map_brightness},
							{saturation	: element.options.map_saturation}
						]
					},
					{
						featureType	: "road.highway",
						elementType	: "geometry.fill",
						stylers    	: [
							{hue		: element.options.map_color},
							{visibility	: "on"},
							{lightness	: element.options.map_brightness},
							{saturation	: element.options.map_saturation}
						]
					},
					{
						featureType	: "water",
						elementType	: "geometry",
						stylers    	: [
							{hue		: element.options.map_color},
							{visibility	: "on"},
							{lightness	: element.options.map_brightness},
							{saturation	: element.options.map_saturation}
						]
					}
				];
			}
			var	map			= new google.maps.Map(map_container, {
					center				: {
						lat : parseFloat(element.options.map_latitude),
						lng : parseFloat(element.options.map_longitude)
					},
					styles				: style,
					zoom				: parseInt(element.options.map_zoom),
					scrollwheel			: parseInt(element.options.map_scrollwheel) ? true : false,
					draggable			: parseInt(element.options.map_draggable) ? true : false,
					zoomControl			: parseInt(element.options.map_zoomcontrol) ? true : false,
					streetViewControl	: parseInt(element.options.map_streetviewcontrol) ? true : false,
					mapTypeControl		: parseInt(element.options.map_maptypecontrol) ? true : false
				}),
				geocoder	= new google.maps.Geocoder();
				
			if (element.items.length) {
				for (var i = 0; i < element.items.length; i++) {
					var marker_options = RSPageBuilderHelper.escapeHtmlObject(element.items[i].options);
					
					marker_options.marker_index = i + 1;
					
					if (marker_options.marker_address) {
						var address_input = obj.find('#marker_address_' + (i + 1));
						
						address_input.attr('autocomplete', 'off');
						RSPageBuilderHelper.aucompleteLocation(map, address_input);
						
						geocoder.geocode({
							'address' : marker_options.marker_address
						}, RSPageBuilderHelper.onGeocodeComplete(map, marker_options));
					} else if (marker_options.marker_latitude && marker_options.marker_longitude) {
						var position = {
								lat : parseFloat(marker_options.marker_latitude),
								lng : parseFloat(marker_options.marker_longitude)
							};
							
						RSPageBuilderHelper.googleMapMarkers(map, marker_options, position);
					}
				}
			}
		}
	},
	
	// Geocode (address to coordinates)
	onGeocodeComplete: function(map, marker_options) {
		var geocodeCallBack = function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				RSPageBuilderHelper.googleMapMarkers(map, marker_options, results[0].geometry.location);
			} else {
				alert('Location geocoding failed: ' + status);
			}
		};

		return geocodeCallBack;
	},
	
	aucompleteLocation: function(map, location) {
		var geocoder = new google.maps.Geocoder();
		
		location.on('input', function(e) {
			
			// Disable event on 'Shift' key press
			if ( e.which == 16) {
				return true;
			}
			if (RSPageBuilderHelper.timer != null) {
				clearTimeout(RSPageBuilderHelper.timer);
			}
			
			RSPageBuilderHelper.timer = setTimeout(function() {
				location.nextAll('.location-results').remove();
				
				if (jQuery.trim(location.val())) {
					geocoder.geocode({
						'address' : jQuery.trim(location.val())
					}, function(results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
							results_wrapper = '<div class="location-results"><ul></ul></div>';
							
							location.after(results_wrapper);
							
							location_results = location.next('.location-results');
							
							if (results.length) {
								jQuery(results).each(function(index, item) {
									li = jQuery('<li>' + item.formatted_address + '</li>');
									
									li.on('click', function() {
										location.val(item.formatted_address);
										map.setCenter(item.geometry.location);
										
										location_results.remove();
									});
									
									location_results.find('ul').append(li);
								});
							} else {
								location_results.remove();
							}
							jQuery(document).on('click', function(event) {
								if (jQuery(event.target).parents().index(results) == -1) {
									location_results.remove();
								}
							});
						}
					});
				}
			}, 10);
		});
	},
	
	// Add Google maps markers
	googleMapMarkers: function(map, marker_options, position) {
		
		// Build marker
		var marker_title_show	= 0,
			marker_icon			= {
				path			: 'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z M -2,-30 a 2,2 0 1,1 4,0 2,2 0 1,1 -4,0',
				fillColor		: marker_options.marker_color,
				fillOpacity		: parseFloat(marker_options.marker_opacity),
				scale			: parseFloat(marker_options.marker_scale),
				strokeColor		: marker_options.marker_stroke_color,
				strokeWeight	: parseInt(marker_options.marker_stroke_weight)
			},
			marker				= {};
			
		// Marker show title
		if (typeof marker_options.marker_title_show == 'undefined' || (typeof marker_options.marker_title_show !== 'undefined' && marker_options.marker_title_show == 1)) {
			marker_title_show = 1;
		}
		
		// Marker icon 
		if (typeof marker_options.marker_icon !== 'undefined' && marker_options.marker_icon) {
			var regexp = /^http(s)?:\/\//;
			
			if (!regexp.test(marker_options.marker_icon)) {
				marker_icon = Joomla.getOptions('system.paths').root + '/' + marker_options.marker_icon;
			}
		}
		
		// Initialize marker
		marker = new google.maps.Marker({
			id			: 'marker_' + marker_options.marker_index,
			position	: position,
			map			: map,
			icon		: marker_icon
		});
		
		// Build infowindow
		var infowindow_content		= '',
			marker_title_style		= {},
			marker_content_style	= {};
			
		if ((marker_options.marker_title && marker_title_show) || marker_options.marker_content) {
			if (marker_options.marker_title && marker_title_show) {
				if (marker_options.marker_title_font_size) {
					marker_title_style['font-size'] = marker_options.marker_title_font_size;
				}
				if (marker_options.marker_title_text_color && marker_options.marker_title_text_color != 'none') {
					marker_title_style['color'] = marker_options.marker_title_text_color;
				}
			}
			if (marker_options.marker_content) {
				if (marker_options.marker_content_text_color) {
					marker_content_style['color'] = marker_options.marker_content_text_color;
				}
			}
			infowindow_content += '<div class="rspbld-infowindow">';
			
			if (marker_options.marker_title && marker_title_show) {
				infowindow_content += '<' + marker_options.marker_title_heading + ' class="rspbld-title"' + RSPageBuilderHelper.buildStyle(marker_title_style) + '>' + marker_options.marker_title + '</' + marker_options.marker_title_heading + '>';
			}
			if (marker_options.marker_content) {
				infowindow_content += '<div class="rspbld-content"' + RSPageBuilderHelper.buildStyle(marker_content_style) + '>' + marker_options.marker_content + '</div>';
			}
			infowindow_content += '</div>';
			
			var infowindow = new google.maps.InfoWindow({
				content: infowindow_content,
				maxWidth: 250
			});
		}
		
		// Add infowindow listener
		if (marker && infowindow) {
			google.maps.event.addListener(marker, 'click', function() {
				infowindow.open(map, marker);
			});
		}
	},
	
	// Initialize OpenStreetMap
	initOpenStreetMap: function(obj = jQuery('#modal-element-settings .element-container')) {
		if (obj.closest('.rspbld').find('.osmap').length) {
			var	element			= JSON.parse(JSON.stringify(eval('(' + obj.find('.element-json').val() + ')'))),
				map_id			= obj.closest('.rspbld').find('.osmap').attr('id'),
				map_container	= document.getElementById(map_id);
				
			if (map_container.classList.contains('leaflet-container')) {
				L.map(map_id).remove();
			}
			
			var street_layer = {};
			
			switch(element.options.map_theme) {
				case 'normal':
					street_layer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
						attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>'
					});
					break;
				case 'light':
					street_layer = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
						attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, Tiles &copy; <a href="https://carto.com/">CARTO</a>'
					});
					break;
				case 'dark':
					street_layer = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
						attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, Tiles &copy; <a href="https://carto.com/">CARTO</a>'
					});
					break;
				case 'black-white':
					street_layer = L.tileLayer('https://stamen-tiles-{s}.a.ssl.fastly.net/toner/{z}/{x}/{y}.png', {
						attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, Tiles &copy; <a href="https://stamen.com">Stamen</a>'
					});
					break;
			}
			
			var map				= L.map(map_id, {
					layers			: [street_layer],
					scrollWheelZoom	: parseInt(element.options.map_scrollwheel) ? true : false,
					dragging		: parseInt(element.options.map_draggable) ? true : false,
					zoomControl		: parseInt(element.options.map_zoomcontrol) ? true : false
				}).setView([parseFloat(element.options.map_latitude), parseFloat(element.options.map_longitude)], parseInt(element.options.map_zoom)),
				marker_options	= {};
				
			if (parseInt(element.options.map_maptypecontrol)) {
				var satellite_layer		= L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
						attribution: 'Map data &copy; <a href="https://www.esri.com/">Esri</a>'
					}),
					layer_control		= L.control({
						position: 'topright'
					}),
					controls_wrapper	= jQuery('<div>', {class: 'maptype-control'});
					
				jQuery('<button>', {
					id		: 'street-btn',
					class	: 'active',
					text	: 'Street'
				}).appendTo(controls_wrapper);
				jQuery('<button>', {
					id		: 'satellite-btn',
					text	: 'Satellite'
				}).appendTo(controls_wrapper);
				
				controls_wrapper.on('click', '#street-btn', function(e) {
					e.preventDefault();
					map.removeLayer(satellite_layer);
					map.addLayer(street_layer);
					jQuery('#street-btn').addClass('active');
					jQuery('#satellite-btn').removeClass('active');
				});
				controls_wrapper.on('click', '#satellite-btn', function(e) {
					e.preventDefault();
					map.removeLayer(street_layer);
					map.addLayer(satellite_layer);
					jQuery('#satellite-btn').addClass('active');
					jQuery('#street-btn').removeClass('active');
				});
				
				layer_control.onAdd = function() {
					return controls_wrapper[0];
				};
				
				layer_control.addTo(map);
			}
			
			if (element.items.length) {
				for (var i = 0; i < element.items.length; i++) {
					var address_input = obj.find('#marker_address_' + (i + 1));
					
					marker_options = RSPageBuilderHelper.escapeHtmlObject(element.items[i].options);
					
					if (marker_options.marker_address || (marker_options.marker_longitude && marker_options.marker_latitude)) {
						var marker			= {},
							marker_icon		= RSPageBuilderHelper.getOsmMarkerIcon(marker_options),
							marker_popup	= RSPageBuilderHelper.getOsmMarkerPopup(marker_options),
							marker_lat		= marker_options.marker_latitude,
							marker_lon		= marker_options.marker_longitude;
						
						if (marker_options.marker_address) {
							jQuery.ajax({
								async		: false,
								type		: 'GET',
								dataType	: 'json',
								url			: 'https://nominatim.openstreetmap.org/search?q=' + jQuery.trim(address_input.val()) + '&format=json&limit=10',
								success		: function(data) {
									marker_lat = data[0].lat;
									marker_lon = data[0].lon;
								},
								error: function (error) {
									console.log('error: ' + eval(error));
								}
							});
						}
						
						marker = L.marker([parseFloat(marker_lat), parseFloat(marker_lon)]);
						marker.addTo(map);
						
						if (marker_icon) {
							marker.setIcon(marker_icon);
						}
						if (marker_popup) {
							marker.bindPopup(marker_popup);
						}
						
						// Autocomplete
						address_input.on('input', function() {
							var location = jQuery(this);
							
							if (RSPageBuilderHelper.timer != null) {
								clearTimeout(RSPageBuilderHelper.timer);
							}
							
							RSPageBuilderHelper.timer = setTimeout(function() {
								location.nextAll('.location-results').remove();
								
								if (jQuery.trim(location.val())) {
									jQuery.ajax({
										async		: false,
										type		: 'GET',
										dataType	: 'json',
										url			: 'https://nominatim.openstreetmap.org/search?q=' + jQuery.trim(location.val()) + '&format=json',
										success		: function(results) {
											var results_wrapper = '<div class="location-results"><ul></ul></div>';
											
											location.after(results_wrapper);
											
											location_results = location.next('.location-results');
											
											if (results.length) {
												jQuery(results).each(function(index, item) {
													li = jQuery('<li>' + item.display_name + '</li>');
													
													li.on('click', function() {
														location.val(item.display_name);
														map.setView([parseFloat(item.lat), parseFloat(item.lon)], parseInt(element.options.map_zoom));
														
														location_results.remove();
													});
													
													location_results.find('ul').append(li);
												});
											} else {
												location_results.remove();
											}
											
											jQuery(document).on('click', function(event) {
												if (jQuery(event.target).parents().index(results) == -1) {
													location_results.remove();
												}
											});
										},
										error: function (error) {
											console.log('error: ' + eval(error));
										}
									});
								}
							}, 10);
						});
					}
				}
			}
		}
	},
	
	// Build OpenStreetMap Marker Icon
	getOsmMarkerIcon: function(marker_options) {
		var marker_icon = '';
		
		if (marker_options.marker_image !== '') {
			marker_icon = L.icon({
				iconUrl		: rspbld_root + marker_options.marker_image,
				iconSize	: [parseInt(marker_options.marker_font_size), parseInt(marker_options.marker_font_size)],
				iconAnchor	: [Math.round(parseInt(marker_options.marker_font_size) / 2), parseInt(marker_options.marker_font_size)],
				popupAnchor	: [0, (-1) * parseInt(marker_options.marker_font_size)]
			});
		} else if (marker_options.marker_icon !== '') {
			var marker_style = {};
			
			if (marker_options.marker_font_size) {
				marker_style['font-size'] = marker_options.marker_font_size + 'px';
			}
			if (marker_options.marker_color) {
				marker_style['color'] = marker_options.marker_color;
			}
			
			marker_icon	= L.divIcon({
				html		: '<span class="fa fa-' + marker_options.marker_icon + '" ' + RSPageBuilderHelper.buildStyle(marker_style) + '></span>',
				iconSize	: [marker_options.marker_font_size, marker_options.marker_font_size],
				iconAnchor	: [Math.round(marker_options.marker_font_size / 2), marker_options.marker_font_size],
				popupAnchor	: [0, (-1) * parseInt(marker_options.marker_font_size)]
			});
		}
		
		return marker_icon;
	},
	
	// Build OpenStreetMap Marker Popup
	getOsmMarkerPopup: function(marker_options) {
		var marker_title_show		= 0,
			marker_title_style		= {},
			marker_content_style	= {},
			popup_content			= '';
			
		// Marker show title
		if (typeof marker_options.marker_title_show == 'undefined' || (typeof marker_options.marker_title_show !== 'undefined' && marker_options.marker_title_show == 1)) {
			marker_title_show = 1;
		}
		
		if ((marker_options.marker_title && marker_title_show) || marker_options.marker_content) {
			if (marker_options.marker_title && marker_title_show) {
				if (marker_options.marker_title_font_size) {
					marker_title_style['font-size'] = marker_options.marker_title_font_size;
				}
				if (marker_options.marker_title_text_color && marker_options.marker_title_text_color != 'none') {
					marker_title_style['color'] = marker_options.marker_title_text_color;
				}
			}
			if (marker_options.marker_content) {
				if (marker_options.marker_content_text_color) {
					marker_content_style['color'] = marker_options.marker_content_text_color;
				}
			}
			
			popup_content += '<div class="rspbld-os-">';
			
			if (marker_options.marker_title && marker_title_show) {
				popup_content += '<' + marker_options.marker_title_heading + ' class="rspbld-title"' + RSPageBuilderHelper.buildStyle(marker_title_style) + '>' + marker_options.marker_title + '</' + marker_options.marker_title_heading + '>';
			}
			if (marker_options.marker_content) {
				popup_content += '<div class="rspbld-content"' + RSPageBuilderHelper.buildStyle(marker_content_style) + '>' + marker_options.marker_content + '</div>';
			}
			
			popup_content += '</div>';
			
			return popup_content;
		}
	},
	
	// Bootstrap version
	getBootstrapVersion: function() {
		return parseInt(jQuery('input[name="jform[bootstrap_version]"]:checked', '#jform_bootstrap_version').val());
	},
	
	// Bootstrap element
	getBootstrapElement: function(element, value) {
		var bootstrap_version = RSPageBuilderHelper.getBootstrapVersion();
		
		if (element == 'row') {
			if (bootstrap_version == 2 || bootstrap_version == 3) {
				element = 'row-fluid';
			}
		} else if (element.match(/^-?\d+$/) && element > 0) {
			if (bootstrap_version == 4 || bootstrap_version == 5) {
				element = 'col-md-' . element;
			} else {
				element = 'span' . element;
			}
		} else if (element == 'data') {
			if (bootstrap_version == 4 || bootstrap_version == 5) {
				element = 'data-bs-' + value;
			} else {
				element = 'data-' + value;
			}
		}
		
		return element;
	},
	
	isFunction: function(function_name) {
		return typeof function_name === 'function';
	},
	
	// Initialize Animated Number
	initAnimatedNumber: function() {
		if (RSPageBuilderHelper.isFunction(jQuery.fn.visible) && RSPageBuilderHelper.isFunction(jQuery.fn.animateNumber)) {
			jQuery('#modal-element-settings .element-preview .rspbld-animated-number').each(function() {
				var limit		= jQuery(this).find('.rspbld-number').data('limit'),
					separator	= jQuery.animateNumber.numberStepFactories.separator(jQuery(this).find('.rspbld-number').data('separator')),
					duration	= jQuery(this).find('.rspbld-number').data('duration'),
					delay		= jQuery(this).find('.rspbld-number').data('delay');
					
				if (jQuery(this).visible('vertical')) {
					jQuery(this).find('.rspbld-number').delay(parseInt(delay)).animateNumber({	
						number		: parseInt(limit),
						numberStep	: separator
					}, parseInt(duration));
				}
			});
		}
	},
	
	// Initialize Animate Progress Bars
	initAnimateProgressBars: function() {
		if (RSPageBuilderHelper.isFunction(jQuery.fn.visible) && (jQuery('#modal-element-settings .element-preview .rspbld-progress-bars.animate .progress .bar, #modal-element-settings .element-preview .rspbld-progress-bars.animate .progress .progress-bar').length > 0)) {
			jQuery('#modal-element-settings .element-preview .rspbld-progress-bars.animate .progress .bar, #modal-element-settings .element-preview .rspbld-progress-bars.animate .progress .progress-bar').each(function(index) {
				if (!jQuery(this).attr('data-animated')) {
					var duration	= jQuery(this).closest('.rspbld-progress-bars.animate').data('duration'),
						delay		= jQuery(this).closest('.rspbld-progress-bars.animate').data('delay');
					
					jQuery(this).css('margin-left', '-' + jQuery(this).css('width'));
					jQuery(this).css('opacity', '1');
					
					if (jQuery(this).visible('vertical')) {
						jQuery(this).delay(parseInt(index * delay)).animate({
							marginLeft : 0
						}, duration);
						
						jQuery(this).attr('data-animated', '1');
					}
				}
			});
		}
	},
	
	// Initialize Animate Progress Circles
	initAnimateProgressCircles: function() {
		if (RSPageBuilderHelper.isFunction(jQuery.fn.visible) && (jQuery('.rspbld-progress-circles.animate .progress-circle').length > 0)) {
			jQuery('#modal-element-settings .element-preview .rspbld-progress-circles.animate .progress-circle').each(function(index) {
				var current_circle = jQuery(this);
				
				if (!current_circle.attr('data-animated')) {
					var duration				= current_circle.closest('.rspbld-progress-circles.animate').data('duration'),
						delay					= current_circle.closest('.rspbld-progress-circles.animate').data('delay'),
						item_size				= current_circle.find('.item-wrapper').width(),
						show_item_percentage	= false;
						
					if (current_circle.find('.item-wrapper > span').text().indexOf('%') >= 0) {
						show_item_percentage = true;
					}
					
					if (current_circle.visible('vertical')) {
						current_circle.prop('counter', 0);
						
						setTimeout(function() {
							current_circle.animate({
							   counter		: current_circle.find('.item-wrapper').attr('data-max-width'),
							}, {
								duration	: duration,
								step		: function(now) {
									var current = Math.ceil(now);
										
									if (current < 50) {
										current_circle.find('.item-wrapper .bar-wrapper').css('clip', 'rect(0, ' + item_size + 'px, ' + item_size + 'px, ' + item_size / 2 + 'px)');
									} else {
										current_circle.find('.item-wrapper .bar-wrapper').css('clip', 'rect(auto, auto, auto, auto)');
									}
									current_circle.find('.item-wrapper').attr('data-width', current);
								},
								queue: false
							}).animate({
								val_counter	: (typeof current_circle.find('.item-wrapper').attr('data-max-value') !== 'undefined') ? current_circle.find('.item-wrapper').attr('data-max-value') : current_circle.find('.item-wrapper').attr('data-max-width'),
							}, {
								duration	: duration,
								step		: function(now) {
									var current = Math.ceil(now)
										symbol	= (typeof current_circle.find('.item-wrapper').attr('data-max-value') !== 'undefined' || !show_item_percentage) ? '' : '%';
										
									current += symbol;
									
									current_circle.find('.item-wrapper > span').text(current);
								},
								queue		: false
							});
							
							current_circle.attr('data-animated', '1');
						}, index * delay);
					}
				}
			});
		}
	},
	
	// Initialize Countdown Timer
	initCountdownTimer: function() {
		if (RSPageBuilderHelper.isFunction(jQuery.fn.countdownTimer) && (jQuery('.rspbld-countdown-timer').length > 0)) {
			jQuery('.rspbld-countdown-timer').each(function() {
				jQuery(this).countdownTimer();
			});
		}
	},
	
	// Initialize Masonry Boxes
	initMasonryBoxes: function() {
		if (RSPageBuilderHelper.isFunction(jQuery.fn.masonry)) {
			if (jQuery('.rspbld-masonry-boxes').length) {
				jQuery('.rspbld-masonry-boxes').each(function() {
					var	boxes_container = jQuery(this).find('.boxes-container'),
						min_size		= parseInt(boxes_container.attr('data-min-size')),
						gutter			= parseInt(boxes_container.attr('data-gutter'));
					
					if (min_size) {
						boxes_container.find('.box').each(function() {
							var sizes		= parseInt(jQuery(this).attr('class').replace(/^.*size([0-9]+).*$/, '$1')).toString().split(''),
								row_size	= (jQuery.isNumeric(sizes[1])) ? parseInt(sizes[1]) : 1,
								column_size	= (jQuery.isNumeric(sizes[0])) ? parseInt(sizes[0]) : 1,
								box_height	= (gutter > 0) ? parseInt(min_size * row_size + gutter * (row_size - 1)) : parseInt(min_size * row_size);
								box_width	= (gutter > 0) ? parseInt(min_size * column_size + gutter * (column_size - 1)) : parseInt(min_size * column_size);
							
							jQuery(this).css('height', box_height);
							jQuery(this).css('width', box_width);
							jQuery(this).css('margin-bottom', gutter);
						});
						
						boxes_container.masonry({
							itemSelector	: '.box',
							columnWidth		: min_size,
							gutter			: gutter
						});
					} else {
						if (gutter) {
							boxes_container.find('.box').each(function(index) {
								var size = parseInt(jQuery(this).attr('class').replace(/^.*cols-([0-9]+).*$/, '$1')).toString();
								
								jQuery(this).css('width', 'calc(' + (100 / size) + '% - ' + ((size - 1) * gutter / size) + 'px)');
								jQuery(this).css('margin-bottom', gutter + 'px');
							});
						}
						
						boxes_container.masonry({
							itemSelector	: '.box',
							gutter			: gutter
						});
					}
				});
			}
		}
	},
	
	// Initialize Portfolio Filtering Box
	initPortfolioFiltering: function() {
		var layout	= jQuery('#modal-element-settings .element-preview .rspbld-portfolio-filtering-container').attr('data-layout'),
			fltr	= jQuery('#modal-element-settings .element-preview .rspbld-portfolio-filtering-container').filterizr({layout: layout, setupControls: false}),
			prtfl	= jQuery('#modal-element-settings .element-preview .rspbld-portfolio-filtering-container').parent();
		
		prtfl.find('.rspbld-filter li').on('click', function() {
			fltr.filterizr('filter', jQuery(this).attr('data-filter'));
			
			prtfl.find('.rspbld-filter li').removeClass('active');
			jQuery(this).addClass('active');
		});
	},
	
	// Initialize Vimeo video
	initVimeoVideo: function() {
		if (jQuery('#modal-element-settings .element-preview .rspbld-vimeo-video').length) {
			var video 	= jQuery('#modal-element-settings .element-preview .rspbld-vimeo-video'),
				options	= {
					id			: video.data('source'),
					autoplay	: (video.data('autoplay') == 1) ? true : false,
					loop		: (video.data('loop') == 1) ? true : false
				},
				player	= new Vimeo.Player(video.attr('id'), options);
				
			player.setVolume(video.data('volume') / 100);
			
			if (video.data('start') != 0 || video.data('end') != 0) {
				if (video.data('end') > video.data('start')) {
					player.setCurrentTime(video.data('start')).then(function(seconds) {
						player.addCuePoint(parseInt(video.data('end')));
						
						player.on('cuepoint', function() {
							player.pause();
						})
					});
				} else if (video.data('end') == 0) {
					player.setCurrentTime(video.data('start')).then(function(seconds) {
						player.getDuration().then(function(duration) {
							player.addCuePoint(parseInt(duration));
							
							player.on('cuepoint', function() {
								player.pause();
							})
						}).catch(function(error) {});
					}).catch(function(error) {});
				}
			}
		}
	},
	
	// Initialize YouTube video
	initYouTubeVideo: function() {
		if (jQuery('#modal-element-settings .element-preview .rspbld-youtube-video').length) {
			var player,
				video = jQuery('#modal-element-settings .element-preview .rspbld-youtube-video');
			
			player = new YT.Player(video.attr('id'), {
				videoId		: video.data('source'),
				playerVars	: {
					'autoplay'		: video.data('autoplay'),
					'controls'		: video.data('controls'),
					'rel'			: video.data('rel'),
					'loop'			: video.data('loop'),
					'playlist'		: video.data('source'),
					'start'			: video.data('start'),
					'end'			: video.data('end'),
					'playsinline'	: 1,
					'origin'		: window.location.origin
				},
				events		: {
					'onReady' : onPlayerReady
				}
			});
			
			function onPlayerReady(event) {
				event.target.setVolume(video.data('volume'));
			}
		}
	},
	
	// Initialize video player
	initVideoPlayer: function() {
		if (jQuery('#modal-element-settings .element-preview .rspbld-video-player').length) {
			jQuery('#modal-element-settings .element-preview .rspbld-video-player').videoPlayer();
		}
	},

	// Initialize YouTube Background Video Boxes
	initYouTubeBackgroundVideoBoxes: function() {
		jQuery.mbYTPlayer.apiKey = jQuery('#modal-element-settings .element-preview .rspbld-youtube-player').data('apikey');
		jQuery('#modal-element-settings .element-preview .rspbld-youtube-player').YTPlayer();
	},
	
	// Random number
	randomNumber: function() {
		return Math.floor(Math.random() * (9999 - 1000 + 1) + 1000);
	},
	
	// Create id
	createId: function(string, number) {
		return string.replace(/\W/g, '').toLowerCase() + number;
	},
	
	// Check if a string contains exclusively spaces, tabs or newlines
	checkSpaces: function(string) {
		if (string.trim().length) {
			return string;
		} else {
			return '';
		}
	},
	
	// Escape HTML
	escapeHtml: function(str) {
		return str.replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/&/g, '&amp;');
	},
	
	// Escape HTML
	escapeHtmlObject: function(obj) {
		for (var key in obj) {
			if (key != 'item_content' && key != 'marker_content') {
				obj[key] = RSPageBuilderHelper.escapeHtml(obj[key]);
			}
		}
		
		return obj;
	},
	
	// Get location
	getLocation: function(href) {
		var new_element = document.createElement('a');
		
		new_element.href = href;
		
		return new_element;
	},
	
	// Build style
	buildStyle: function(obj) {
		var style				= '';
		
		if (Object.keys(obj).length) {
			style += ' style="';
			
			for (var key in obj) {
				if (key == 'background-image') {
					style += key + ':url(' + obj[key] + ');';
				} else {
					style += key + ':' + obj[key] + ';';
				}
			}
			style += '"';
		}
		return style;
	},
	
	// Fix for Bootstrap collapse (accordion)
	fixAccordion: function() {
		jQuery('.accordion').each(function () {
			jQuery(this).find('.accordion-toggle').each(function (i, title) {
				if (jQuery(title).parent().siblings('.accordion-body').hasClass('in') === false) {
					jQuery(title).addClass('collapsed');
				}
			});
		});
		jQuery('.accordion-toggle').on('click', function () {
			jQuery(this).parents('.accordion').each(function () {
				jQuery(this).find('.accordion-toggle').each(function (i, title) {
					jQuery(title).addClass('collapsed');
				});
			});
		});
	},
	
	// Fix for Bootstrap conflict with MooTools
	fixMooTools: function() {
		if (typeof MooTools != 'undefined' ) {
			Element.implement({
				hide: function() {
					return;
				}
			});
		}
	},
	
	// Fix for Bootstrap carousel conflict with MooTools
	fixMooToolsCarousel: function() {
		if (typeof MooTools != 'undefined' ) {
			Element.implement({
				slide : function(how, mode) {
					return this;
				}
			});
		}
	},
	
	// Initialize Bootstrap carousel
	initCarousel: function() {
		jQuery('#modal-element-settings .element-preview .rspbld-carousel .carousel').each(function() {
			var carousel_cycle		= (jQuery(this).attr(RSPageBuilderHelper.getBootstrapElement('data', 'interval')) == 0) ? false : true,
				carousel_interval	= (jQuery(this).attr(RSPageBuilderHelper.getBootstrapElement('data', 'interval')) == 0) ? false : parseInt(jQuery(this).attr(RSPageBuilderHelper.getBootstrapElement('data', 'interval')));
			
			if (rspbld_jversion >= 4) {
				var carousel_selector = document.querySelector('#' + jQuery(this).attr('id'));
				
				new bootstrap.Carousel(carousel_selector, {
					interval	: carousel_interval,
					cycle		: carousel_cycle,
					ride		: 'carousel'
				});
			} else {
				jQuery(this).carousel({
					interval	: carousel_interval,
					cycle		: carousel_cycle
				});
				
				var carousel_swipe = (jQuery(this).attr('data-swipe')) ? true : false;
				
				// Initialize slide on swipe
				if (carousel_swipe && RSPageBuilderHelper.isFunction(jQuery.fn.tswipe)) {
					jQuery(this).tswipe({
						allowPageScroll	: 'auto',
						tswipe			: function(event, direction, distance, duration, fingerCount, fingerData) {
							if (direction === 'left') {
								jQuery(this).carousel('next');
							} else if (direction === 'right') {
								jQuery(this).carousel('prev');
							}
						},
						threshold		: 0
					});
				}
			}
		});
	},
	
	// Initialize options tab navigation
	initOptionsTab: function() {
		jQuery(document).on('click', '.options-tab .nav-tabs > li > a', function() {
			var id = jQuery(this).attr('href').replace('#', '');
			
			jQuery(this).closest('.tab').find('.tab-pane').each(function() {
				if (jQuery(this).attr('id') == id) {
					jQuery(this).addClass('active');
				} else {
					jQuery(this).removeClass('active');
				}
			});
		});
	},
	
	elementFieldToTitle: function(container_id, element_field) {
		var field_parts = element_field.split('-'),
			prefix		= '';
			
		switch(container_id) {
			case 'modal-column-settings':
				prefix = 'COLUMN_';
			break;
			case 'modal-row-settings':
				prefix = 'ROW_';
			break;
		}
		
		return Joomla.JText._('COM_RSPAGEBUILDER_' + prefix + field_parts[0].toUpperCase());
	},
	
	elementTypeToTitle: function(element_type) {
		return Joomla.JText._('COM_RSPAGEBUILDER_' + element_type.replace('rspbld_', '').toUpperCase());
	},
	
	renderRowAjax: function(row) {
		if (typeof row != 'undefined') {
			var regexp = /^<div class="\options-tab tab"\>/;
			
			jQuery.ajax({
				type		: 'POST',
				dataType	: 'html',
				url			: rspbld_root + 'administrator/index.php?option=com_rspagebuilder&task=page.renderRow',
				data		: JSON.parse(JSON.stringify(eval('(' + row + ')'))),
				success		: function(html) {
					if (regexp.test(html)) {
						jQuery('#modal-row-settings .row-options').empty();
						jQuery('#modal-row-settings .row-options').append(html);
						jQuery('#modal-row-settings .row-options .rspbld-input').each(function() {
							jQuery(this).attr('data-name', jQuery(this).attr('name'));
							jQuery(this).removeAttr('name');
						});
						jQuery('#modal-row-settings .row-options .rspbld-field.btn-group.radio').each(function() {
							if (!jQuery(this).find('.rspbld-input').length) {
								jQuery(this).find('input[checked="checked"]').addClass('rspbld-input');
								jQuery(this).find('input[checked="checked"]').attr('data-name', jQuery(this).attr('id'));
							}
						});
						RSPageBuilderHelper.initOptionsTab();
						RSPageBuilderHelper.initComponents(jQuery('#modal-row-settings .row-options'));
						jQuery('#modal-row-settings').modal('show');
						setTimeout(function() {
							jQuery('#modal-row-settings .loader').fadeOut(200);
							jQuery('#modal-row-settings .row-fluid').fadeIn(200);
						}, 500);
					} else {
						window.location.reload();
					}
				}
			});
		}
	},
	
	renderColumnAjax: function(column) {
		if (typeof column != 'undefined') {
			var regexp = /^<div class="\options-tab tab"\>/;
			
			jQuery.ajax({
				type		: 'POST',
				dataType	: 'html',
				url			: rspbld_root + 'administrator/index.php?option=com_rspagebuilder&task=page.renderColumn',
				data		: JSON.parse(JSON.stringify(eval('(' + column + ')'))),
				success		: function(html) {
					if (regexp.test(html)) {
						jQuery('#modal-column-settings .column-options').empty();
						jQuery('#modal-column-settings .column-options').append(html);
						jQuery('#modal-column-settings .column-options .rspbld-input').each(function() {
							jQuery(this).attr('data-name', jQuery(this).attr('name'));
							jQuery(this).removeAttr('name');
						});
						jQuery('#modal-column-settings .column-options .rspbld-field.btn-group.radio').each(function() {
							if (!jQuery(this).find('.rspbld-input').length) {
								jQuery(this).find('input[checked="checked"]').addClass('rspbld-input');
								jQuery(this).find('input[checked="checked"]').attr('data-name', jQuery(this).attr('id'));
							}
						});
						RSPageBuilderHelper.initOptionsTab();
						RSPageBuilderHelper.initComponents(jQuery('#modal-column-settings .column-options'));
						jQuery('#modal-column-settings').modal('show');
						setTimeout(function() {
							jQuery('#modal-column-settings .loader').fadeOut(200);
							jQuery('#modal-column-settings .row-fluid').fadeIn(200);
						}, 500);
					} else {
						window.location.reload();
					}
				}
			});
		}
	},
	
	renderElementAjax: function(container, element) {
		if (typeof element != 'undefined') {
			var regexp = /^<div class="\options-tab tab"\>/;
			
			jQuery.ajax({
				type		: 'POST',
				dataType	: 'html',
				url			: rspbld_root + 'administrator/index.php?option=com_rspagebuilder&task=page.renderElement',
				data		: JSON.parse(JSON.stringify(eval('(' + element + ')'))),
				success		: function(html) {
					if (regexp.test(html)) {
						container.empty();
						container.append(html);
						
						container.find('.editor').each(function () {
							var editor_parent	= jQuery(this).closest('.controls'),
								editor_clone	= jQuery(this).clone();
							
							editor_clone.attr('class', 'js-editor-tinymce');
							editor_clone.find('> textarea').attr('class', 'mce_editable joomla-editor-tinymce');
							editor_clone.children(':not(textarea)').remove();
							
							editor_parent.empty();
							editor_parent.append(editor_clone);
						});
						container.find('.js-editor-tinymce > .joomla-editor-tinymce, joomla-editor-codemirror > textarea, .codemirror-source, joomla-editor-none > textarea, .js-editor-none > textarea').each(function() {
							jQuery(this).attr('data-name', jQuery(this).attr('name'));
							if (!jQuery(this).hasClass('joomla-editor-tinymce')) {
								jQuery(this).removeAttr('name');
							}
						});
						container.find('.rspbld-input').each(function() {
							jQuery(this).attr('data-name', jQuery(this).attr('name'));
							jQuery(this).removeAttr('name');
						});
						container.find('.rspbld-field.btn-group.radio').each(function() {
							if (!jQuery(this).find('.rspbld-input').length) {
								var field_id = (rspbld_jversion >= 4) ? jQuery(this).closest('fieldset').attr('id') : jQuery(this).attr('id');
								
								jQuery(this).find('input[checked="checked"]').addClass('rspbld-input');
								
								if (jQuery(this).closest('.tab-pane').attr('id') != 'items') {
									jQuery(this).find('input[checked="checked"]').attr('data-name', field_id);
								} else {
									jQuery(this).find('input[checked="checked"]').attr('data-name', field_id.replace(/_(\d+)$/, '-$1'));
								}
							}
						});
						RSPageBuilderHelper.editElement(container.closest('.element-container'));
					} else {
						window.location.reload();
					}
				}
			});
		}
	},
	
	elementHtmlAjax: function(trigger, element, bootstrap_version) {
		var regexp = /class="rspbld-/;
		
		element						= JSON.parse(JSON.stringify(eval('(' + element + ')')));
		element.bootstrap_version	= bootstrap_version;

		if (trigger.hasClass('edit-element')) {
			jQuery('#modal-element-settings .modal-body .element-preview').append('<div class="preview-loader"></div>');
		}
		
		jQuery.ajax({
			type		: 'POST',
			dataType	: 'html',
			url			: rspbld_root + 'administrator/index.php?option=com_rspagebuilder&task=page.elementHtml',
			data		: element,
			success		: function(html) {
				if (regexp.test(html) || html == '') {
					if (trigger.hasClass('view-element-html')) {
						var title		= '',
							subtitle	= '';
							
						if (element.options.title) {
							title = element.options.title;
						} else if (element.options.text) {
							title = element.options.text;
						} else {
							title = RSPageBuilderHelper.elementTypeToTitle(element.type);
						}
						subtitle = RSPageBuilderHelper.elementTypeToTitle(element.type);
						
						if (title != subtitle) {
							jQuery('#modal-element-view-html .modal-title, #modal-element-view-html .modal-header > h3').text(title + ' (' + subtitle + ')');
						} else {
							jQuery('#modal-element-view-html .modal-title, #modal-element-view-html .modal-header > h3').text(title);
						}
						jQuery('#modal-element-view-html .modal-body > textarea').empty();
						jQuery('#modal-element-view-html .modal-body > textarea').text(style_html(html));
						jQuery('#modal-element-view-html').modal('show');
					} else if (trigger.hasClass('edit-element')) {
						setTimeout(function() {
							jQuery('#modal-element-settings .modal-body .element-preview').empty();
							jQuery('#modal-element-settings .modal-body .element-preview').append(html);
						}, 200);
						
						setTimeout(function() {
							if (element.type == 'rspbld_animated_number') {
								RSPageBuilderHelper.initAnimatedNumber();
							} else if (element.type == 'rspbld_carousel') {
								RSPageBuilderHelper.initCarousel();
							} else if (element.type == 'rspbld_countdown_timer') {
								RSPageBuilderHelper.initCountdownTimer();
							} else if (element.type == 'rspbld_masonry_boxes') {
								RSPageBuilderHelper.initMasonryBoxes();
							} else if (element.type == 'rspbld_progress_bars') {
								RSPageBuilderHelper.initAnimateProgressBars();
							} else if (element.type == 'rspbld_progress_circles') {
								RSPageBuilderHelper.initAnimateProgressCircles();
							} else if ((element.type == 'rspbld_video')) {
								RSPageBuilderHelper.initVideoPlayer();
								RSPageBuilderHelper.initVimeoVideo();
								RSPageBuilderHelper.initYouTubeVideo();
							} else if (element.type == 'rspbld_youtube_background_video_box') {
								RSPageBuilderHelper.initYouTubeBackgroundVideoBoxes();
							} else if (element.type == 'rspbld_portfolio_filtering') {
								RSPageBuilderHelper.initPortfolioFiltering();
							}
						}, 500);
					}
				} else {
					window.location.reload();
				}
			}
		});
	},
	
	buildElementJson: function(element_container) {
		var element_type		= '',
			element_category	= '',
			element_options		= {};
		
		// Add title
		if (element_container.find('[data-name="title"]').length) {
			element_container.find('.element-title').text(element_container.find('[data-name="title"]').val());
		} else if (element_container.find('[data-name="text"]').length) {
			element_container.find('.element-title').text(element_container.find('[data-name="text"]').val());
		}
		
		// Add type
		element_container.find('.element-type').text(Joomla.JText._('COM_RSPAGEBUILDER_' + element_container.find('[data-name="type"]').val().replace('rspbld_', '').toUpperCase()));
		
		if (!element_container.find('.element-title').text()) {
			element_container.find('.element-title').text(element_container.find('.element-type').text());
			element_container.find('.element-type').addClass('hidden');
		}
		if (element_container.find('.element-title').text() == element_container.find('.element-type').text()) {
			element_container.find('.element-type').addClass('hidden');
		} else {
			element_container.find('.element-type').removeClass('hidden');
		}
		
		element_container.find('.element-options .tab-content > div:not(#items) .rspbld-input, .element-options .tab-content > div:not(#items) .js-editor-tinymce > .joomla-editor-tinymce, .element-options .tab-content > div:not(#items) joomla-editor-codemirror > textarea, .element-options .tab-content > div:not(#items) .codemirror-source, .element-options .tab-content > div:not(#items) joomla-editor-none > textarea, .element-options .tab-content > div:not(#items) .js-editor-none > textarea').each(function() {
			if (jQuery(this).data('name') == 'type') {
				element_type = jQuery(this).val();
			} else if (jQuery(this).data('name') == 'category') {
				element_category = jQuery(this).val();
			} else {
				element_options[jQuery(this).data('name')] = jQuery(this).is('.codemirror-source, joomla-editor-codemirror > textarea') ? RSPageBuilderHelper.checkSpaces(jQuery(this).text()) : RSPageBuilderHelper.checkSpaces(jQuery(this).val());
			}
		});
		
		element = {
			'type'		: element_type,
			'category'	: element_category,
			'options'	: element_options,
			'items'		: []
		};
		
		element_container.find('.element-options .iterative-items .accordion-body').each(function(index) {
			var item_options = {};
			
			jQuery(this).find('.rspbld-input, .js-editor-tinymce > .joomla-editor-tinymce, joomla-editor-codemirror > textarea, .codemirror-source, joomla-editor-none > textarea, .js-editor-none > textarea').each(function() {
				var input	= jQuery(this),
					field	= input.data('name').split('-');
					
				item_options[field[0]] = input.is('.codemirror-source, joomla-editor-codemirror > textarea') ? RSPageBuilderHelper.checkSpaces(input.text()) : RSPageBuilderHelper.checkSpaces(input.val());
			});
			
			element.items[index] = {
				'type'		: element_type + '_item',
				'options'	: item_options
			};
		});
		
		return element;
	},
	
	changeElement: function () {
		var element_container = jQuery('#modal-element-settings .element-container');
		
		if (element_container.length) {
			element_container.find('.element-json').val(JSON.stringify(RSPageBuilderHelper.buildElementJson(element_container)));
			RSPageBuilderHelper.elementHtmlAjax(element_container.find('.edit-element'), element_container.find('.element-json').val(), RSPageBuilderHelper.getBootstrapVersion());
			setTimeout(function() {
				RSPageBuilderHelper.fixAccordion();
				RSPageBuilderHelper.initGoogleMap(element_container);
				RSPageBuilderHelper.initOpenStreetMap(element_container);
			}, 1000);
			RSPageBuilderHelper.fixMooToolsCarousel();
		} else {
			return;
		}
	},
	
	sortNegativeFields: function(fields) {
		var neg_fields = [];
		
		for (var i = 0; i < fields.length; i++) {
			if (fields[i].match(/margin/)) {
				neg_fields.push(fields[i]);
			}
		}
		
		return neg_fields;
	},
	
	validateSizeInput: function(container, pixel_fields, em_fields, rem_fields, percentage_fields, multiple_mixed_fields) {
		var invalid_fields		= [],
			invalid_fields_html	= '',
			
			neg_pixel_fields			= RSPageBuilderHelper.sortNegativeFields(pixel_fields),
			neg_em_fields				= RSPageBuilderHelper.sortNegativeFields(em_fields),
			neg_rem_fields				= RSPageBuilderHelper.sortNegativeFields(rem_fields),
			neg_percentage_fields		= RSPageBuilderHelper.sortNegativeFields(percentage_fields),
			neg_multiple_mixed_fields	= RSPageBuilderHelper.sortNegativeFields(multiple_mixed_fields);
			
		container.find('.rspbld-input').each(function() {
			var pixel_regexp				= new RegExp('^(' + pixel_fields.join('|') + ')', 'i'),
				neg_pixel_regexp			= new RegExp('^(' + neg_pixel_fields.join('|') + ')', 'i'),
				
				em_regexp					= new RegExp('^(' + em_fields.join('|') + ')', 'i'),
				neg_em_regexp				= new RegExp('^(' + neg_em_fields.join('|') + ')', 'i'),
				
				rem_regexp					= new RegExp('^(' + rem_fields.join('|') + ')', 'i'),
				neg_rem_regexp				= new RegExp('^(' + neg_rem_fields.join('|') + ')', 'i'),
				
				percentage_regexp			= new RegExp('^(' + percentage_fields.join('|') + ')', 'i'),
				neg_percentage_regexp		= new RegExp('^(' + neg_percentage_fields.join('|') + ')', 'i'),
				
				multiple_mixed_regexp		= new RegExp('^(' + multiple_mixed_fields.join('|') + ')', 'i'),
				neg_multiple_mixed_regexp	= new RegExp('^(' + neg_multiple_mixed_fields.join('|') + ')', 'i'),
				
				all_regexp					= new RegExp(pixel_regexp.source + '|' + em_regexp.source + '|' + rem_regexp.source + '|' + percentage_regexp.source + '|' + multiple_mixed_regexp.source),
				
				pixel_value					= /^[0-9]+\.?[0-9]*px$/,
				neg_pixel_value				= /^-[0-9]+\.?[0-9]*px$/,
				
				em_value					= /^[0-9]+\.?[0-9]*em$/,
				neg_em_value				= /^-[0-9]+\.?[0-9]*em$/,
				
				rem_value					= /^[0-9]+\.?[0-9]*rem$/,
				neg_rem_value				= /^-[0-9]+\.?[0-9]*rem$/,
				
				percentage_value			= /^[0-9]+\.?[0-9]*\%$/,
				neg_percentage_value		= /^-[0-9]+\.?[0-9]*\%$/,
				
				multiple_mixed_values		= /^((auto)|([0-9]+\.?[0-9]*(px|em|rem|\%)))?((( )+(auto))|(( )+([0-9]+\.?[0-9]*(px|em|rem|\%))))?((( )+(auto))|(( )+([0-9]+\.?[0-9]*(px|em|rem|\%))))?((( )+(auto))|(( )+([0-9]+\.?[0-9]*(px|em|rem|\%))))?$/,
				neg_multiple_mixed_values	= /^((auto)|(-?[0-9]+\.?[0-9]*(px|em|rem|\%)))?((( )+(auto))|(( )+(-?[0-9]+\.?[0-9]*(px|em|rem|\%))))?((( )+(auto))|(( )+(-?[0-9]+\.?[0-9]*(px|em|rem|\%))))?((( )+(auto))|(( )+(-?[0-9]+\.?[0-9]*(px|em|rem|\%))))?$/,
				
				invalid					= true;
				
			if (jQuery(this).val() && all_regexp.test(jQuery(this).attr('data-name'))) {
				if (pixel_regexp.test(jQuery(this).attr('data-name')) && pixel_value.test(jQuery(this).val())) {
					invalid = false;
				} else if (neg_pixel_regexp.test(jQuery(this).attr('data-name')) && neg_pixel_value.test(jQuery(this).val())) {
					invalid = false;
				} else if (em_regexp.test(jQuery(this).attr('data-name')) && em_value.test(jQuery(this).val())) {
					invalid = false;
				} else if (neg_em_regexp.test(jQuery(this).attr('data-name')) && neg_em_value.test(jQuery(this).val())) {
					invalid = false;
				} else if (rem_regexp.test(jQuery(this).attr('data-name')) && rem_value.test(jQuery(this).val())) {
					invalid = false;
				} else if (neg_rem_regexp.test(jQuery(this).attr('data-name')) && neg_rem_value.test(jQuery(this).val())) {
					invalid = false;
				} else if (percentage_regexp.test(jQuery(this).attr('data-name')) && percentage_value.test(jQuery(this).val())) {
					invalid = false;
				} else if (neg_percentage_regexp.test(jQuery(this).attr('data-name')) && neg_percentage_value.test(jQuery(this).val())) {
					invalid = false;
				} else if (multiple_mixed_regexp.test(jQuery(this).attr('data-name')) && multiple_mixed_values.test(jQuery(this).val())) {
					invalid = false;
				} else if (neg_multiple_mixed_regexp.test(jQuery(this).attr('data-name')) && neg_multiple_mixed_values.test(jQuery(this).val())) {
					invalid = false;
				}
				
				if (invalid) {
					jQuery(this).addClass('invalid');
					jQuery(this).closest('.control-group').find('label').addClass('invalid');
					invalid_fields.push(jQuery(this));
					invalid_fields_html += '<p>' + Joomla.JText._('COM_RSPAGEBUILDER_INVALID_FIELD') + ': ' + RSPageBuilderHelper.elementFieldToTitle(container.attr('id'), jQuery(this).attr('data-name')) + '</p>';
				} else {
					jQuery(this).removeClass('invalid');
					jQuery(this).closest('.control-group').find('label').removeClass('invalid');
				}
			}
		});
		
		if (invalid_fields_html) {
			container.find('.alert.message').remove();
			container.find('.options-tab').before('<div class="alert alert-danger message"><h4>' + Joomla.JText._('COM_RSPAGEBUILDER_ERROR') + '</h4>' + invalid_fields_html + '</div>');
		} else {
			container.find('.alert.message').remove();
		}
		
		container.find('.options-tab .nav-tabs li a').removeClass('invalid');
		container.find('.iterative-items .accordion-heading > a, .iterative-items .card-header > a').removeClass('invalid');
		
		if (invalid_fields.length) {
			for (var i = 0; i < invalid_fields.length; i++) {
				if (!container.find('.options-tab .nav-tabs li a[href="#' + invalid_fields[i].closest('.tab-pane').attr('id') + '"]').hasClass('invalid')) {
					container.find('.options-tab .nav-tabs li a[href="#' + invalid_fields[i].closest('.tab-pane').attr('id') + '"]').addClass('invalid');
				}
				if (rspbld_jversion >= 4) {
					if (container.find('.iterative-items').length) {
						if (!container.find('.iterative-items .card-header > a[href="#' + invalid_fields[i].closest('.collapse').attr('id') + '"]').hasClass('invalid')) {
							container.find('.iterative-items .card-header > a[href="#' + invalid_fields[i].closest('.collapse').attr('id') + '"]').addClass('invalid');
						}
					}
				} else {
					if (container.find('.iterative-items').length) {
						if (!container.find('.iterative-items .accordion-heading > a[href="#' + invalid_fields[i].closest('.accordion-body').attr('id') + '"]').hasClass('invalid')) {
							container.find('.iterative-items .accordion-heading > a[href="#' + invalid_fields[i].closest('.accordion-body').attr('id') + '"]').addClass('invalid');
						}
					}
				}
			}
		}
		
		return invalid_fields.length;
	},
	
	validateFormatInput: function(container, video_fields) {
		var invalid_fields		= [],
			invalid_fields_html	= '';
			
		if (container.find('.element-preview .rspbld-video .rspbld-video-player').length) {
			container.find('.rspbld-input').each(function() {
				var video_regexp	= new RegExp('^(' + video_fields.join('|') + ')', 'i'),
					video_value		= /\.(asf|avi|flv|m4v|mp4|ogg|ogv|webm)$/,
					invalid			= true;
					
				if (jQuery(this).val() && video_regexp.test(jQuery(this).attr('data-name'))) {
					if (video_value.test(jQuery(this).val())) {
						invalid = false;
					}
					
					if (invalid) {
						jQuery(this).addClass('invalid');
						jQuery(this).closest('.control-group').find('label').addClass('invalid');
						invalid_fields.push(jQuery(this));
						invalid_fields_html += '<p>' + Joomla.JText._('COM_RSPAGEBUILDER_INVALID_FIELD') + ': ' + RSPageBuilderHelper.elementFieldToTitle(container.attr('id'), jQuery(this).attr('data-name')) + '</p>';
					} else {
						jQuery(this).removeClass('invalid');
						jQuery(this).closest('.control-group').find('label').removeClass('invalid');
					}
				}
			});
		}
		
		if (invalid_fields_html) {
			container.find('.alert.message').remove();
			container.find('.options-tab').before('<div class="alert alert-danger message"><h4>' + Joomla.JText._('COM_RSPAGEBUILDER_ERROR') + '</h4>' + invalid_fields_html + '</div>');
		} else {
			container.find('.alert.message').remove();
		}
		
		container.find('.options-tab .nav-tabs li a').removeClass('invalid');
		container.find('.iterative-items .accordion-heading > a, .iterative-items .card-header > a').removeClass('invalid');
		
		if (invalid_fields.length) {
			for (var i = 0; i < invalid_fields.length; i++) {
				if (!container.find('.options-tab .nav-tabs li a[href="#' + invalid_fields[i].closest('.tab-pane').attr('id') + '"]').hasClass('invalid')) {
					container.find('.options-tab .nav-tabs li a[href="#' + invalid_fields[i].closest('.tab-pane').attr('id') + '"]').addClass('invalid');
				}
				if (rspbld_jversion >= 4) {
					if (container.find('.iterative-items').length) {
						if (!container.find('.iterative-items .card-header > a[href="#' + invalid_fields[i].closest('.collapse').attr('id') + '"]').hasClass('invalid')) {
							container.find('.iterative-items .card-header > a[href="#' + invalid_fields[i].closest('.collapse').attr('id') + '"]').addClass('invalid');
						}
					}
				} else {
					if (container.find('.iterative-items').length) {
						if (!container.find('.iterative-items .accordion-heading > a[href="#' + invalid_fields[i].closest('.accordion-body').attr('id') + '"]').hasClass('invalid')) {
							container.find('.iterative-items .accordion-heading > a[href="#' + invalid_fields[i].closest('.accordion-body').attr('id') + '"]').addClass('invalid');
						}
					}
				}
			}
		}
		
		return invalid_fields.length;
	},
	
	pageToJson: function() {
		var page = [];
		
		jQuery('.rspbld-wrapper .rspbld-container').each(function(index) {
			var row				= jQuery(this),
				row_index		= index,
				row_attributes	= JSON.parse(JSON.stringify(eval('(' + jQuery(this).find('.row-json').val() + ')')));
			
			page[row_index] = {
				'type'		: row_attributes.type,
				'grid'		: row_attributes.grid,
				'options'	: row_attributes.options,
				'columns'	: []
			};
			
			row.find('.column').each(function(index) {
				var	column				= jQuery(this),
					column_index		= index,
					column_attributes	= JSON.parse(JSON.stringify(eval('(' + jQuery(this).find('.column-json').val() + ')')));
					
				page[row_index].columns[column_index] = {
					'type' 		: column_attributes.type,
					'grid'		: column_attributes.grid,
					'options'	: column_attributes.options,
					'elements'	: []
				};
				
				column.find('.element-container').each(function(index) {
					var element				= jQuery(this),
						element_index		= index,
						element_attributes	= JSON.parse(JSON.stringify(eval('(' + jQuery(this).find('.element-json').val() + ')')));
					
					page[row_index].columns[column_index].elements[element_index] = {
						'type' 		: element_attributes.type,
						'category'	: element_attributes.category,
						'options'	: element_attributes.options,
						'items'		: element_attributes.items
					};
				});
			});
		});
		
		return JSON.stringify(page);
	},
	
	preventUnsaved: function(initialPage) {
		jQuery(window).on('beforeunload', function() {
			
			if (initialPage != RSPageBuilderHelper.pageToJson()) {
				setTimeout(function() {
					jQuery(window).off('beforeunload');
				}, 50);
				
				return Joomla.JText._('COM_RSPAGEBUILDER_LEAVE_PAGE');
			}
		});
	}
};