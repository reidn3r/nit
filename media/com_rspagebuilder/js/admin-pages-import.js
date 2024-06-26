jQuery(document).ready(function() {
	
	jQuery('#rspbld-import-pages').on('input', function() {
		var pages			= jQuery(this),
			file_data		= pages.prop('files')[0],
			accepted_type	= 'text/xml',
			form_data		= new FormData();
			
		if (file_data.type != accepted_type) {
			Joomla.renderMessages({'error' : [Joomla.JText._('COM_RSPAGEBUILDER_PAGES_IMPORT_FILE_TYPE_NOT_ACCEPTED')]});
			return false;
		}
		
		form_data.append('import', file_data);
		
		jQuery.ajax({
			type		: 'POST',
			url			: rspbld_root + 'administrator/index.php?option=com_rspagebuilder&task=pages.import',
			data		: form_data,
			dataType	: 'json',
			processData	: false,
			contentType	: false,
			success		: function(data) {
				if (data.isrspbld == 'false') {
					Joomla.renderMessages({'error' : [Joomla.JText._('COM_RSPAGEBUILDER_PAGES_IMPORT_FILE_NOT_GENERATED')]});
				} else {
					Joomla.renderMessages({'success' : [Joomla.JText._('COM_RSPAGEBUILDER_PAGES_IMPORT_SUCCESS')]});
					
					setTimeout(function() {
						document.location.href = rspbld_root + 'administrator/index.php?option=com_rspagebuilder&view=pages';
					}, 1000);
				}
			},
			error		: function() {
				Joomla.renderMessages({'error' : [Joomla.JText._('COM_RSPAGEBUILDER_PAGES_IMPORT_ERROR')]});	
			}
		});
	});
	
	Joomla.submitbutton = function(task) {
		if (task == 'pages.import') {
			jQuery('#rspbld-import-pages').click();
		} else {
			Joomla.submitform(task);
		}
	}
});