jQuery.fn.videoPlayer = function() {
	var player = jQuery(this);
	
	// Info
	if (player.data('showinfo')) {
		player.append('<div class="video-title">' + player.data('source').substr(player.data('source').lastIndexOf('/') + 1).replace(/\.[^/.]+$/, '') + '</div>');
	}
	
	// Autoplay
	if (player.data('autoplay')) {
		player.append('<div class="video-wrapper playing"><video id="video' + player.attr('id').replace(/[^0-9]/g, '') + '" autoplay="autoplay"><source src="' + player.data('source') + '"></source></video></div>');
	} else {
		player.append('<div class="video-wrapper"><video id="video' + player.attr('id').replace(/[^0-9]/g, '') + '"><source src="' + player.data('source') + '"></source></video></div>');
	}
	
	// Volume
	if (player.data('volume')) {
		setVolume(player, parseInt(player.data('volume')) / 100);
	} else {
		setVolume(player, 0);
	}
	
	// Controls
	if (player.data('controls')) {
		player.append('<div class="video-controls"></div>');
		
		if (player.data('autoplay')) {
			player.find('.video-controls').append('<div class="play-pause"><span class="fa fa-pause"></span></div>');
		} else {
			player.find('.video-controls').append('<div class="play-pause"><span class="fa fa-play"></span></div>');
		}
		player.find('.video-controls').append('<div class="seek-container"><div class="seek-bar"><div class="seek-fill"></div></div><span class="timer">0:00</span></div>');
		player.find('.video-controls').append('<div class="volume-container"><span class="fa fa-volume-up"></span><div class="volume-bar"><div class="volume-fill"></div></div></div>');
		
		// Seek bar
		seekBar(player);
		
		// Volume bar
		volumeBar(player);
	}
	
	// Play / pause button
	playPause(player);
	
	// Loop
	if (player.data('loop')) {
		player.find('.video-wrapper video').attr('loop', 'loop');
	}
	
	// Start / end time
	src = player.data('source');
	
	if (player.data('start')) {
		src += '#t=' + player.data('start');
	} else {
		src += '#t=0';
	}
	
	if (player.data('end')) {
		src += ',' + player.data('end');
	}
	player.find('.video-wrapper video source').attr('src', src);
	
	// Set video object height
	if (player.data('height') && /^[0-9]+\.?[0-9]*px$/.test(player.data('height'))) {
		player.find('.video-wrapper video').attr('height', player.data('height').match(/^[0-9]+\.?[0-9]*/)[0]);
	}
	
	// Set video object width
	if (player.data('width') && /^[0-9]+\.?[0-9]*px$/.test(player.data('width'))) {
		player.find('.video-wrapper video').attr('width', player.data('width').match(/^[0-9]+\.?[0-9]*/)[0]);
	}
	
	function playPause(player_container) {
		var current_player = document.getElementById(player_container.find('video').attr('id'));
		
		player_container.find('.video-wrapper video').on('play', function() {
			if (player_container.data('controls')) {
				player_container.find('.video-controls .play-pause span').attr('class', 'fa fa-pause');
			}
			player_container.find('.video-wrapper').addClass('playing');
		});
		
		player_container.find('.video-wrapper video').on('pause', function() {
			if (player_container.data('controls')) {
				player_container.find('.video-controls .play-pause span').attr('class', 'fa fa-play');
			}
			player_container.find('.video-wrapper').removeClass('playing');
		});
		
		if (player_container.data('controls')) {
			player_container.find('.video-controls .play-pause span').on('click', function() {
				if (current_player.paused) {
					current_player.play();
				} else {
					current_player.pause();
				}
			});
		}
		
		player_container.find('.video-wrapper').on('click', function() {
			if (current_player.paused) {
				current_player.play();
			} else {
				current_player.pause();
			}
		});
	}
	
	function setVolume(player_container, player_volume) {
		var current_player = document.getElementById(player_container.find('video').attr('id'));
		
		current_player.volume = player_volume;
	}
	
	function seekBar(player_container) {
		var current_player = document.getElementById(player_container.find('video').attr('id'));
		
		player_container.find('.video-controls .seek-bar').on('click', function(e) {
			var event_obj		= window.event ? event : e,
				click_offset	= event_obj.clientX - jQuery(this).offset().left,
				percentage		= click_offset / jQuery(this).width();
				
			current_player.currentTime = current_player.duration * percentage;
			
			jQuery(this).find('.video-controls .seek-fill').css('width', Math.round(percentage * 100) + '%');
		});
		
		current_player.ontimeupdate = function() {
			var current_seconds	= (Math.floor(current_player.currentTime % 60) < 10 ? '0' : '') + Math.floor(current_player.currentTime % 60),
				current_minutes	= Math.floor(current_player.currentTime / 60);
				percentage		= current_player.currentTime / current_player.duration;
			
			player_container.find('.video-controls .timer').empty();
			player_container.find('.video-controls .timer').append(current_minutes + ':' + current_seconds);
			player_container.find('.video-controls .seek-fill').css('width', Math.round(percentage * 100) + '%');
		};
	}
	
	function volumeBar(player_container) {
		var current_player 		= document.getElementById(player_container.find('video').attr('id')),
			initial_percentage	= current_player.volume;
			
		player_container.find('.video-controls .volume-bar .volume-fill').css('width', Math.round(initial_percentage * 100) + '%');
		
		if (Math.round(initial_percentage * 100) == 0) {
			player_container.find('.volume-container span').attr('class', 'fa fa-volume-off');
		} else if (Math.round(initial_percentage * 100) < 50) {
			player_container.find('.volume-container span').attr('class', 'fa fa-volume-down');
		} else {
			player_container.find('.volume-container span').attr('class', 'fa fa-volume-up');
		}
		
		player_container.find('.video-controls .volume-bar').on('click', function(e) {
			var event_obj		= window.event ? event : e,
				click_offset	= event_obj.clientX - jQuery(this).offset().left,
				percentage		= click_offset / jQuery(this).width();
				
			current_player.volume	= percentage;
			initial_percentage		= percentage;
			
			jQuery(this).find('.volume-fill').css('width', Math.round(percentage * 100) + '%');
			
			if (Math.round(percentage * 100) == 0) {
				jQuery(this).parent().find('span').attr('class', 'fa fa-volume-off');
			} else if (Math.round(percentage * 100) < 50) {
				jQuery(this).parent().find('span').attr('class', 'fa fa-volume-down');
			} else {
				jQuery(this).parent().find('span').attr('class', 'fa fa-volume-up');
			}
		});
		
		player_container.find('.volume-container span').on('click', function(e) {
			if (jQuery(this).attr('class') == 'fa fa-volume-off') {
				if (initial_percentage == 0) {
					initial_percentage = 1;
				}
				current_player.volume = initial_percentage;
				
				if (Math.round(initial_percentage * 100) > 50) {
					jQuery(this).attr('class', 'fa fa-volume-up');
				} else {
					jQuery(this).attr('class', 'fa fa-volume-down');
				}
				jQuery(this).parent().find('.volume-fill').css('width', Math.round(initial_percentage * 100) + '%');
			} else {
				current_player.volume = 0;
				jQuery(this).attr('class', 'fa fa-volume-off');
				jQuery(this).parent().find('.volume-fill').css('width', '0');
			}
		});
	}
}
