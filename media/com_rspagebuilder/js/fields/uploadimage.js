jQuery.fn.uploadImage = function() {
	var id = 0;
	
	if (typeof RSPageBuilderHelper != 'undefined') {
		id = RSPageBuilderHelper.randomNumber();
	} else if (typeof RSPageBuilderElementsHelper != 'undefined') {
		id = RSPageBuilderElementsHelper.randomNumber();
	} else {
		return;
	}
	
	jQuery(this).find('.input-media').attr('id', 'media-' + id);
	
	if (jQuery(this).find('.image-preview img').attr('src')) {
		jQuery(this).find('.media-preview').removeClass('no-height');
	}
	mediaRefreshPreview(jQuery(this).find('.input-media'));
	
	jQuery(this).find('a.modal').on('click', function() {
		if (rspbld_jversion >= 4) {
			var media_iframe		= jQuery('<iframe>', {
					id		: 'iframe_id',
					name	: 'modal-upload-image',
					src		: 'index.php?option=com_media&tmpl=component&fieldid=' + 'media-' + id,
					height	: '100%',
					width	: '100%'
				}),
				media_modal			= jQuery('#modal-upload-image'),
				media_modal_body	= media_modal.find('.modal-body');
				
			media_iframe.on('load', function () {
				var save_button			= media_modal.find('.media-save'),
					cancel_button 		= media_modal.find('.media-cancel_button');
				
				save_button.attr('onclick', 'window.parent.mediaInsertImage(\'media-' + id + '\');window.parent.mediaModalClose();');
				
				cancel_button.attr('onclick', 'window.parent.mediaModalClose();');
			});
		} else {
			var media_iframe		= jQuery('<iframe>', {
					name   : 'modal-upload-image',
					src	   : 'index.php?option=com_media&view=images&tmpl=component&fieldid=' + 'media-' + id,
					height : '100%',
					width  : '100%'
				}),
				media_modal			= jQuery('#modal-upload-image'),
				media_modal_body	= media_modal.find('.modal-body');
			
			media_iframe.on('load', function () {
				var insert_button 	= media_iframe.contents().find('#imageForm .pull-right button:first-of-type'),
					cancel_button 	= media_iframe.contents().find('#imageForm .pull-right button:nth-of-type(2)');
					
				insert_button.attr('onclick', 'window.parent.mediaInsertFieldValue(document.getElementById(\'f_url\').value, \'media-' + id + '\');window.parent.mediaModalClose();');
				cancel_button.attr('onclick', 'window.parent.mediaModalClose();');
				insert_button.removeAttr('data-dismiss');
				cancel_button.removeAttr('data-dismiss');
			});
		}
		media_modal_body.empty();
		media_modal_body.append(media_iframe);
		media_modal.modal('show');
	});
	
	jQuery('#modal-upload-image .media-save').on('click', function(e) {
		e.preventDefault();
	});
	
	jQuery('#modal-upload-image .media-close, #modal-upload-image .close').on('click', function(e) {
		e.preventDefault();
		mediaModalClose();
	});
	
	jQuery(this).find('a.remove-media').off();
	jQuery(this).find('a.remove-media').on('click', function() {
		var media_modal			= jQuery('#modal-upload-image'),
			media_modal_body	= media_modal.find('.modal-body');
			
		mediaInsertFieldValue('', 'media-' + id);
		jQuery(this).closest('.media').find('.media-preview').addClass('no-height');
		jQuery(this).closest('.media').find('.image-preview img').attr('src', '');
		media_modal_body.empty();
		return false;
	});
}

function mediaInsertImage(id) {
	var media_iframe		= document.querySelector('#iframe_id').contentDocument,
		selected_image		= media_iframe.querySelector('.media-browser-item.selected .image-cropped'),
		selected_image_url	= '';

	if (selected_image !== null) {
		selected_image_url = selected_image.style.backgroundImage.length ? selected_image.style.backgroundImage.substring(5, selected_image.style.backgroundImage.length - 2) : selected_image.src;
	} else {
		var breadcrumbs = media_iframe.querySelectorAll('.media-breadcrumb ol > li > a');

		for (let i = 0; i < breadcrumbs.length; i++) {
			selected_image_url += breadcrumbs[i].text + '/';
		}
		
		selected_image_url += media_iframe.querySelector('.media-browser-item.selected .media-browser-item-preview').title;
	}

	image_url = selected_image_url.replace(rspbld_root, '').replace('media/cache/com_media/thumbs/', '');

	window.parent.mediaInsertFieldValue(image_url, id);
}

function mediaModalClose() {
	var media_modal			= jQuery('#modal-upload-image'),
		media_modal_body	= media_modal.find('.modal-body');
		
	media_modal.modal('hide');
	setTimeout(function() {
		media_modal_body.empty();
	}, 300);
}

function mediaRefreshPreview(element) {
	element.off();
	element.on('change', function() {
		jQuery(this).closest('.media').find('.image-preview img').attr('src', '../' + jQuery(this).val());
		
		if (jQuery(this).closest('.media').find('.media-preview').hasClass('no-height')) {
			jQuery(this).closest('.media').find('.media-preview').removeClass('no-height');
		}
	});
}

function mediaInsertFieldValue(value, id) {
	var old_value = jQuery('#' + id).val();
	
	if (old_value != value) {
		var jQueryelem = jQuery('#' + id);
		
		jQueryelem.val(value);
		jQueryelem.value = value;
		jQueryelem.trigger('change');
		
		if (typeof(jQueryelem.get(0).onchange) === 'function') {
			jQueryelem.get(0).onchange();
		}
		mediaRefreshPreview(jQuery('#' + id));
	}
}