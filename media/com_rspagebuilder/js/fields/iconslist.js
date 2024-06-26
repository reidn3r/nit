jQuery.fn.iconsList = function() {
	var helper				= {},
		current_select		= jQuery(this),
		current_container	= current_select.closest('.controls');
		
	if (typeof RSPageBuilderHelper != 'undefined') {
		helper = RSPageBuilderHelper;
	} else if (typeof RSPageBuilderElementsHelper != 'undefined') {
		helper = RSPageBuilderElementsHelper;
	} else {
		return;
	}

	// Open / close icons list
	current_container.find('.icons-list .selected').off();
	current_container.find('.icons-list .selected').on('click', function() {
		jQuery(this).next('.icons').toggleClass('in');
	});

	// Filter icons by search
	current_container.find('.icons-list .search-filter').off();
	current_container.find('.icons-list .search-filter').on('input', function() {
		var searched	= jQuery(this).val(),
			list		= jQuery(this).siblings('.list');

		list.find(' > li').each(function() {
			if (jQuery(this).find(' > span').text().toLowerCase().indexOf(searched.toLowerCase()) >= 0) {
				if (jQuery(this).hasClass('search-hidden')) {
					jQuery(this).removeClass('search-hidden');
				}
			} else {
				if (!jQuery(this).hasClass('search-hidden')) {
					jQuery(this).addClass('search-hidden');
				}
			}
		});
	});
	
	// Change icon
	current_container.find('.icons-list .list > li').off();
	current_container.find('.icons-list .list > li').on('click', function() {
		if (jQuery(this).hasClass('active')) {
			return;
		} else {
			var selected_icon		= current_container.find('.icons-list .selected'),
				element_container	= jQuery('#modal-element-settings .element-container');

			selected_icon.empty();
			selected_icon.append(jQuery(this).html());
			current_container.find('.icons-list .list > li').removeAttr('class');
			jQuery(this).addClass('active');
			
			if (selected_icon.find('i').length) {
				if (selected_icon.find('i').hasClass('no-icon')) {
					current_container.find('.iconslist').val('');
				} else {
					current_container.find('.iconslist').val(selected_icon.find('i').attr('class').replace('fa fa-', '').replace('fab fa-', '').replace('fas fa-', ''));
				}
			}
			
			helper.changeElement();
		}
		current_container.find('.icons').removeClass('in');
	});
};