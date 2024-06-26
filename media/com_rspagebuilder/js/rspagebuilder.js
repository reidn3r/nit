
// Initialize YouTube Video
window.onYouTubeIframeAPIReady = function() {
	if (!RSPageBuilder.isFunction(jQuery.fn.YTPlayer)) {
		var player;
		
		jQuery(document).ready(RSPageBuilder.initYouTubeVideo);
	}
};

!function(jQuery) {
	var timer;
	
	jQuery(document).ready(function() {
		// Fix for Bootstrap Collapse (accordion)
		RSPageBuilder.fixAccordion();
		
		// Fix for Bootstrap Carousel conflict with Mootools
		RSPageBuilder.fixMootoolsCarousel();

		// Animate Sections
		RSPageBuilder.animateSections();
		
		// Animate Numbers
		RSPageBuilder.animateNumbers();
		
		// Animate Progress Bars
		RSPageBuilder.animateProgressBars();
		
		// Animate Progress Circles
		RSPageBuilder.animateProgressCircles();
		
		// Initialize Bootstrap Carousel
		RSPageBuilder.initCarousel();

		// Initialize Countdown Timer
		RSPageBuilder.initCountdownTimer();
		
		// Initialize Magnific Popup
		RSPageBuilder.initMagnificPopup();
		
		// Initialize Video Player
		RSPageBuilder.initVideoPlayer();
		
		// Initialize Vimeo Video
		RSPageBuilder.initVimeoVideo();
		
		// Initialize YouTube Video
		if (RSPageBuilder.isFunction(jQuery.fn.YTPlayer)) {
			jQuery(document).on('YTAPIReady', function() {
				var player;
				
				RSPageBuilder.initYouTubeVideo();
			});
		}
		
		// Initialize YouTube Background Video Boxes
		RSPageBuilder.initYouTubeBackgroundVideoBoxes();
	});
	
	jQuery(window).on('load', function() {
		
		// Initialize Masonry Boxes
		RSPageBuilder.initMasonryBoxes();
		
		// Initialize Portfolio Filtering Box
		RSPageBuilder.initPortfolioFiltering();
		
		if (jQuery('.rspbld-pages .rspbld-page-container .wrapper .preview').length) {
			jQuery('.rspbld-pages .rspbld-page-container .wrapper .preview').on('scroll', function () {
				// Animate Sections
				RSPageBuilder.animateSections();
				
				clearTimeout(timer);
				
				timer = setTimeout(function() {
					
					// Animate Numbers
					RSPageBuilder.animateNumbers();
					
					// Animate Progress Bars
					RSPageBuilder.animateProgressBars();
					
					// Animate Progress Circles
					RSPageBuilder.animateProgressCircles();
				}, 200);
			});
		}
	});
	
	jQuery(window).on('scroll', function() {
		// Animate Sections
		RSPageBuilder.animateSections();
		
		clearTimeout(timer);
		
		timer = setTimeout(function() {
			// Animate Numbers
			RSPageBuilder.animateNumbers();
			
			// Animate Progress Bars
			RSPageBuilder.animateProgressBars();
			
			// Animate Progress Circles
			RSPageBuilder.animateProgressCircles();
		}, 200);
	});
} (window.jQuery);

var RSPageBuilder = {
	fixAccordion: function () {
		jQuery('.accordion').each(function () {
			jQuery(this).find('.accordion-toggle').each(function (i, title) {
				if (jQuery(title).parent().siblings('.accordion-body').hasClass('in') === false)
					jQuery(title).addClass('collapsed');
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
	
	fixMootoolsCarousel: function() {
		if (typeof MooTools != 'undefined' ) {
			Element.implement({
				slide: function(how, mode){
					return this;
				}
			});
		}
	},
	
	animateSections: function() {
		if (RSPageBuilder.isFunction(jQuery.fn.visible)) {
			jQuery('.animation').each(function() {
				
				if (jQuery(this).visible('vertical') && !jQuery(this).hasClass('start')) {
					jQuery(this).addClass('start');
				}
			});
		}
	},
	
	animateNumbers: function() {
		if (RSPageBuilder.isFunction(jQuery.fn.visible) && RSPageBuilder.isFunction(jQuery.fn.animateNumber)) {
			jQuery('.rspbld-animated-number').each(function() {
				var limit		= jQuery(this).find('.rspbld-number').data('limit'),
					separator	= jQuery.animateNumber.numberStepFactories.separator(jQuery(this).find('.rspbld-number').data('separator')),
					duration	= jQuery(this).find('.rspbld-number').data('duration'),
					delay		= jQuery(this).find('.rspbld-number').data('delay');
				
				if (jQuery(this).visible('vertical')) {
					jQuery(this).find('.rspbld-number').delay(parseInt(delay)).animateNumber({	
						number: parseInt(limit),
						numberStep: separator
					}, parseInt(duration));
				}
			});
		}
	},
	
	animateProgressBars: function() {
		if (RSPageBuilder.isFunction(jQuery.fn.visible) && (jQuery('.rspbld-progress-bars.animate .progress .bar, .rspbld-progress-bars.animate .progress .progress-bar').length > 0)) {
			jQuery('.rspbld-progress-bars.animate .progress .bar, .rspbld-progress-bars.animate .progress .progress-bar').each(function(index) {
				if (!jQuery(this).attr('data-animated')) {
					var duration	= jQuery(this).closest('.rspbld-progress-bars.animate').data('duration'),
						delay		= jQuery(this).closest('.rspbld-progress-bars.animate').data('delay');
					
					jQuery(this).css('margin-left', '-' + jQuery(this).css('width'));
					jQuery(this).css('opacity', '1');
					if (jQuery(this).visible('vertical')) {
						jQuery(this).delay(parseInt(index * delay)).animate({
							marginLeft: 0
						}, duration);
						
						jQuery(this).attr('data-animated', '1');
					}
				}
			});
		}
	},
	
	animateProgressCircles: function() {
		if (RSPageBuilder.isFunction(jQuery.fn.visible) && (jQuery('.rspbld-progress-circles.animate .progress-circle').length > 0)) {
			jQuery('.rspbld-progress-circles.animate .progress-circle').each(function(index) {
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
								queue		: false
							}).animate({
								val_counter: (typeof current_circle.find('.item-wrapper').attr('data-max-value') !== 'undefined') ? current_circle.find('.item-wrapper').attr('data-max-value') : current_circle.find('.item-wrapper').attr('data-max-width'),
							}, {
								duration	: duration,
								step		: function(now) {
									var current = Math.ceil(now)
										symbol	= (typeof current_circle.find('.item-wrapper').attr('data-max-value') !== 'undefined' || !show_item_percentage) ? '' : '%';
										
									current += symbol;
									
									current_circle.find('.item-wrapper > span').text(current);
								},
								queue: false
							});
							
							current_circle.attr('data-animated', '1');
						}, index * delay);
					}
				}
			});
		}
	},
	
	// Bootstrap element
	getBootstrapElement: function(element, value) {
		if (element == 'row') {
			if (rspbld_bversion == 2 || rspbld_bversion == 3) {
				element = 'row-fluid';
			}
		} else if (element.match(/^-?\d+$/) && element > 0) {
			if (rspbld_bversion == 4 || rspbld_bversion == 5) {
				element = 'col-md-' . element;
			} else {
				element = 'span' . element;
			}
		} else if (element == 'data') {
			if (rspbld_bversion == 4 || rspbld_bversion == 5) {
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
	
	initCarousel: function() {
		jQuery('.rspbld-carousel .carousel').each(function() {
			var carousel_cycle 	  	= (jQuery(this).attr(RSPageBuilder.getBootstrapElement('data', 'interval')) == 0) ? false : true,
				carousel_interval	= (jQuery(this).attr(RSPageBuilder.getBootstrapElement('data', 'interval')) == 0) ? false : parseInt(jQuery(this).attr(RSPageBuilder.getBootstrapElement('data', 'interval')));
			
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
				if (carousel_swipe && RSPageBuilder.isFunction(jQuery.fn.tswipe)) {
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
	
	initCountdownTimer: function() {
		if (RSPageBuilder.isFunction(jQuery.fn.countdownTimer)) {
			jQuery('.rspbld-countdown-timer').each(function() {
				jQuery(this).countdownTimer();
			});
		}
	},
	
	initGoogleMap: function(id, element) {
		if (jQuery('#' + id).length) {
			var map_container	= document.getElementById(id),
				style			= [];
			
			if (element.options.map_color) {
				style = [
					{
						elementType: "labels",
						stylers    : [
							{saturation: element.options.map_saturation}
						]
					},
					{
						featureType: "poi",
						elementType: "labels",
						stylers    : [
							{visibility: "off"}
						]
					},
					{
						featureType: "road.highway",
						elementType: "labels",
						stylers    : [
							{visibility: "off"}
						]
					},
					{
						featureType: "road.local",
						elementType: "labels.icon",
						stylers    : [
							{visibility: "off"}
						]
					},
					{
						featureType: "road.arterial",
						elementType: "labels.icon",
						stylers    : [
							{visibility: "off"}
						]
					},
					{
						featureType: "road",
						elementType: "geometry.stroke",
						stylers    : [
							{visibility: "off"}
						]
					},
					{
						featureType: "transit",
						elementType: "geometry.fill",
						stylers    : [
							{hue: element.options.map_color},
							{visibility: "on"},
							{lightness: element.options.map_brightness},
							{saturation: element.options.map_saturation}
						]
					},
					{
						featureType: "poi",
						elementType: "geometry.fill",
						stylers    : [
							{hue: element.options.map_color},
							{visibility: "on"},
							{lightness: element.options.map_brightness},
							{saturation: element.options.map_saturation}
						]
					},
					{
						featureType: "poi.government",
						elementType: "geometry.fill",
						stylers    : [
							{hue: element.options.map_color},
							{visibility: "on"},
							{lightness: element.options.map_brightness},
							{saturation: element.options.map_saturation}
						]
					},
					{
						featureType: "poi.sports_complex",
						elementType: "geometry.fill",
						stylers    : [
							{hue: element.options.map_color},
							{visibility: "on"},
							{lightness: element.options.map_brightness},
							{saturation: element.options.map_saturation}
						]
					},
					{
						featureType: "poi.attraction",
						elementType: "geometry.fill",
						stylers    : [
							{hue: element.options.map_color},
							{visibility: "on"},
							{lightness: element.options.map_brightness},
							{saturation: element.options.map_saturation}
						]
					},
					{
						featureType: "poi.business",
						elementType: "geometry.fill",
						stylers    : [
							{hue: element.options.map_color},
							{visibility: "on"},
							{lightness: element.options.map_brightness},
							{saturation: element.options.map_saturation}
						]
					},
					{
						featureType: "transit",
						elementType: "geometry.fill",
						stylers    : [
							{hue: element.options.map_color},
							{visibility: "on"},
							{lightness: element.options.map_brightness},
							{saturation: element.options.map_saturation}
						]
					},
					{
						featureType: "transit.station",
						elementType: "geometry.fill",
						stylers    : [
							{hue: element.options.map_color},
							{visibility: "on"},
							{lightness: element.options.map_brightness},
							{saturation: element.options.map_saturation}
						]
					},
					{
						featureType: "landscape",
						stylers    : [
							{hue: element.options.map_color},
							{visibility: "on"},
							{lightness: element.options.map_brightness},
							{saturation: element.options.map_saturation}
						]

					},
					{
						featureType: "road",
						elementType: "geometry.fill",
						stylers    : [
							{hue: element.options.map_color},
							{visibility: "on"},
							{lightness: element.options.map_brightness},
							{saturation: element.options.map_saturation}
						]
					},
					{
						featureType: "road.highway",
						elementType: "geometry.fill",
						stylers    : [
							{hue: element.options.map_color},
							{visibility: "on"},
							{lightness: element.options.map_brightness},
							{saturation: element.options.map_saturation}
						]
					},
					{
						featureType: "water",
						elementType: "geometry",
						stylers    : [
							{hue: element.options.map_color},
							{visibility: "on"},
							{lightness: element.options.map_brightness},
							{saturation: element.options.map_saturation}
						]
					}
				];
			}
			var	map			= new google.maps.Map(map_container, {
					center		: {
						lat: parseFloat(element.options.map_latitude),
						lng: parseFloat(element.options.map_longitude)
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
					var marker_options = RSPageBuilder.escapeHtmlObject(element.items[i].options);
					
					marker_options.marker_index = i + 1;
					
					if (marker_options.marker_address) {
						geocoder.geocode({
							'address': marker_options.marker_address
						}, RSPageBuilder.onGeocodeComplete(map, marker_options));
					} else if (marker_options.marker_latitude && marker_options.marker_longitude) {
						var position = {
								lat: parseFloat(marker_options.marker_latitude),
								lng: parseFloat(marker_options.marker_longitude)
							};
							
						RSPageBuilder.googleMapMarkers(map, marker_options, position);
					}
				}
			}
		}
	},
	
	// Add Google map markers
	googleMapMarkers: function(map, marker_options, position) {
		
		// Build marker
		var marker_title_show	= 0,
			marker_icon			= {
				path: 'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z M -2,-30 a 2,2 0 1,1 4,0 2,2 0 1,1 -4,0',
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
				infowindow_content += '<' + marker_options.marker_title_heading + ' class="rspbld-title"' + RSPageBuilder.buildStyle(marker_title_style) + '>' + marker_options.marker_title + '</' + marker_options.marker_title_heading + '>';
			}
			if (marker_options.marker_content) {
				infowindow_content += '<div class="rspbld-content"' + RSPageBuilder.buildStyle(marker_content_style) + '>' + marker_options.marker_content + '</div>';
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
	
	// Geocode (address to coordinates)
	onGeocodeComplete: function(map, marker_options) {
		var geocodeCallBack = function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				RSPageBuilder.googleMapMarkers(map, marker_options, results[0].geometry.location);
			} else {
				alert ('Location geocoding failed: ' + status);
			}
		}
		return geocodeCallBack;
	},
	
	initOpenStreetMap: function(id, element) {
		if (jQuery('#' + id).length) {
			
			var map_container = document.getElementById(id);
				
			if (map_container.classList.contains('leaflet-container')) {
				L.map(id).remove();
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
			
			var map				= L.map(id, {
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
					
					marker_options = RSPageBuilder.escapeHtmlObject(element.items[i].options);
					
					if (marker_options.marker_address || (marker_options.marker_longitude && marker_options.marker_latitude)) {
						var marker			= {},
							marker_icon		= RSPageBuilder.getOsmMarkerIcon(marker_options),
							marker_popup	= RSPageBuilder.getOsmMarkerPopup(marker_options),
							marker_lat		= marker_options.marker_latitude,
							marker_lon		= marker_options.marker_longitude;
						
						if (marker_options.marker_address) {
							jQuery.ajax({
								async		: false,
								type		: 'GET',
								dataType	: 'json',
								url			: 'https://nominatim.openstreetmap.org/search?q=' + jQuery.trim(marker_options.marker_address) + '&format=json&limit=10',
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
				iconUrl		: Joomla.getOptions('system.paths').root + '/' + marker_options.marker_image,
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
				html		: '<span class="fa fa-' + marker_options.marker_icon + '" ' + RSPageBuilder.buildStyle(marker_style) + '></span>',
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
				popup_content += '<' + marker_options.marker_title_heading + ' class="rspbld-title"' + RSPageBuilder.buildStyle(marker_title_style) + '>' + marker_options.marker_title + '</' + marker_options.marker_title_heading + '>';
			}
			if (marker_options.marker_content) {
				popup_content += '<div class="rspbld-content"' + RSPageBuilder.buildStyle(marker_content_style) + '>' + marker_options.marker_content + '</div>';
			}
			
			popup_content += '</div>';
			
			return popup_content;
		}
	},
	
	initMagnificPopup: function() {
		if (RSPageBuilder.isFunction(jQuery.fn.magnificPopup)) {
			var tags = [];
			
			jQuery('.rspbld-magnific-popup').each(function() {
				tags.push(jQuery(this).attr('data-tag'));
			});
			
			tags = jQuery.unique(tags);
			
			for (var i = 0; i < tags.length; i++) {
				var enabled_gallery = false;
				
				if (jQuery('.rspbld-magnific-popup[data-tag="' + tags[i] + '"]').length > 1) {
					enabled_gallery = true;
				}
				
				jQuery('.rspbld-magnific-popup[data-tag="' + tags[i] + '"]').magnificPopup({
					type: 'image',
					gallery: {
						enabled: enabled_gallery
					},
					mainClass: 'mfp-with-zoom',
					zoom: {
						enabled: true,

						duration: 300,
						easing: 'ease-in-out',
						opener: function(openerElement) {
						  return openerElement.is('img') ? openerElement : openerElement.find('img');
						}
					}
				});
			}
		}
	},
	
	initVideoPlayer: function() {
		jQuery('.rspbld-video-player').each(function() {
			jQuery(this).videoPlayer();
		});
	},
	
	initVimeoVideo: function() {
		jQuery('.rspbld-vimeo-video').each(function() {
			var video 	= jQuery(this),
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
		});
	},
	
	initYouTubeVideo: function() {
		jQuery('.rspbld-youtube-video').each(function() {
			var video = jQuery(this);
			
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
		});
	},

	initYouTubeBackgroundVideoBoxes: function() {
		if (RSPageBuilder.isFunction(jQuery.fn.YTPlayer)) {
			jQuery('.rspbld-youtube-player').each(function(i, yt_box){
				jQuery.mbYTPlayer.apiKey = jQuery(yt_box).data('apikey');
				jQuery(yt_box).YTPlayer();
			});
		}
	},
	
	initPortfolioFiltering: function() {
		if (RSPageBuilder.isFunction(jQuery.fn.filterizr)) {
			if (jQuery('.rspbld-portfolio-filtering-container').length) {
				jQuery('.rspbld-portfolio-filtering-container').each(function() {
					var layout	= jQuery(this).attr('data-layout'),
						fltr	= jQuery(this).filterizr({layout: layout, setupControls: false}),
						prtfl	= jQuery(this).parent();
					
					prtfl.find('.rspbld-filter li').on('click', function() {
						fltr.filterizr('filter', jQuery(this).attr('data-filter'));
						
						prtfl.find('.rspbld-filter li').removeClass('active');
						jQuery(this).addClass('active');
					});
				});
			}
		}
	},
	
	initMasonryBoxes: function() {
		if (RSPageBuilder.isFunction(jQuery.fn.masonry)) {
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
							itemSelector: '.box',
							columnWidth: min_size,
							gutter: gutter
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
							itemSelector: '.box',
							gutter: gutter
						});
					}
				});
			}
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
				obj[key] = RSPageBuilder.escapeHtml(obj[key]);
			}
		}
		
		return obj;
	},
	
	// Build style
	buildStyle: function(obj) {
		var style = '';
		
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
	}
};