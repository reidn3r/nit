jQuery.fn.countdownTimer = function() {
	var countdown		= jQuery(this).find('.rspbld-inner'),
		lang_day		= Joomla.JText._('COM_RSPAGEBUILDER_LONG_DAY') === 'COM_RSPAGEBUILDER_LONG_DAY' ? Joomla.JText._('MOD_RSPAGEBUILDER_ELEMENTS_LONG_DAY') : Joomla.JText._('COM_RSPAGEBUILDER_LONG_DAY'),
		lang_days		= Joomla.JText._('COM_RSPAGEBUILDER_LONG_DAYS') === 'COM_RSPAGEBUILDER_LONG_DAYS' ? Joomla.JText._('MOD_RSPAGEBUILDER_ELEMENTS_LONG_DAYS') : Joomla.JText._('COM_RSPAGEBUILDER_LONG_DAYS'),
		lang_hour		= Joomla.JText._('COM_RSPAGEBUILDER_LONG_HOUR') === 'COM_RSPAGEBUILDER_LONG_HOUR' ? Joomla.JText._('MOD_RSPAGEBUILDER_ELEMENTS_LONG_HOUR') : Joomla.JText._('COM_RSPAGEBUILDER_LONG_HOUR'),
		lang_hours		= Joomla.JText._('COM_RSPAGEBUILDER_LONG_HOURS') === 'COM_RSPAGEBUILDER_LONG_HOURS' ? Joomla.JText._('MOD_RSPAGEBUILDER_ELEMENTS_LONG_HOURS') : Joomla.JText._('COM_RSPAGEBUILDER_LONG_HOURS'),
		lang_minute		= Joomla.JText._('COM_RSPAGEBUILDER_LONG_MINUTE') === 'COM_RSPAGEBUILDER_LONG_MINUTE' ? Joomla.JText._('MOD_RSPAGEBUILDER_ELEMENTS_LONG_MINUTE') : Joomla.JText._('COM_RSPAGEBUILDER_LONG_MINUTE'),
		lang_minutes	= Joomla.JText._('COM_RSPAGEBUILDER_LONG_MINUTES') === 'COM_RSPAGEBUILDER_LONG_MINUTES' ? Joomla.JText._('MOD_RSPAGEBUILDER_ELEMENTS_LONG_MINUTES') : Joomla.JText._('COM_RSPAGEBUILDER_LONG_MINUTES'),
		lang_second		= Joomla.JText._('COM_RSPAGEBUILDER_LONG_SECOND') === 'COM_RSPAGEBUILDER_LONG_SECOND' ? Joomla.JText._('MOD_RSPAGEBUILDER_ELEMENTS_LONG_SECOND') : Joomla.JText._('COM_RSPAGEBUILDER_LONG_SECOND'),
		lang_seconds	= Joomla.JText._('COM_RSPAGEBUILDER_LONG_SECONDS') === 'COM_RSPAGEBUILDER_LONG_SECONDS' ? Joomla.JText._('MOD_RSPAGEBUILDER_ELEMENTS_LONG_SECONDS') : Joomla.JText._('COM_RSPAGEBUILDER_LONG_SECONDS'),
		lang_expired	= Joomla.JText._('COM_RSPAGEBUILDER_COUNTDOWN_TIMER_EXPIRED') === 'COM_RSPAGEBUILDER_COUNTDOWN_TIMER_EXPIRED' ? Joomla.JText._('MOD_RSPAGEBUILDER_ELEMENTS_COUNTDOWN_TIMER_EXPIRED') : Joomla.JText._('COM_RSPAGEBUILDER_COUNTDOWN_TIMER_EXPIRED');
		
	if (countdown.length) {
		var data_limit = countdown.attr('data-limit');
		if (!data_limit.length)
		{
			return;
		}

		data_limit = data_limit.split(' ').join('T') + 'Z';

		var countdown_limit		= new Date(data_limit).getTime(),
			countdown_format	= countdown.attr('data-format');
			update				= setInterval(function() {
				var now				= new Date().getTime(),
					eta				= countdown_limit - now,
					days_wrapper	= countdown.find('.wrapper.days'),
					hours_wrapper	= countdown.find('.wrapper.hours'),
					minutes_wrapper	= countdown.find('.wrapper.minutes'),
					seconds_wrapper	= countdown.find('.wrapper.seconds');
					
				if (eta > 0) {
					var days		= Math.floor(eta / (1000 * 60 * 60 * 24)),
						hours		= Math.floor((eta % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)),
						minutes		= Math.floor((eta % (1000 * 60 * 60)) / (1000 * 60)),
						seconds		= Math.floor((eta % (1000 * 60)) / 1000);
						
					days_wrapper.find('.countdown').text(days);
					hours_wrapper.find('.countdown').text(hours);
					minutes_wrapper.find('.countdown').text(minutes);
					seconds_wrapper.find('.countdown').text(seconds);
					
					if (countdown.hasClass('horizontal-details')) {
						
						// Days or Day
						if (days == 1) {
							days_wrapper.find('.detail').text(lang_day);
						} else if (days >= 0) {
							days_wrapper.find('.detail').text(lang_days);
						}
						
						// Hours or Hour
						if (hours == 1) {
							hours_wrapper.find('.detail').text(lang_hour);
						} else if (hours >= 0) {
							hours_wrapper.find('.detail').text(lang_hours);
						}
						
						// Minutes or Minute
						if (minutes == 1) {
							minutes_wrapper.find('.detail').text(lang_minute);
						} else if (minutes >= 0) {
							minutes_wrapper.find('.detail').text(lang_minutes);
						}
						
						// Seconds or Second
						if (seconds == 1) {
							seconds_wrapper.find('.detail').text(lang_second);
						} else if (seconds >= 0) {
							seconds_wrapper.find('.detail').text(lang_seconds);
						}
					}
				} else {
					clearInterval(update);
					countdown.parent().prepend('<div class="alert text-left"><h4>' + Joomla.JText._('WARNING') + '!</h4>' + lang_expired + '</div>');
					days_wrapper.find('.countdown').text(0);
					hours_wrapper.find('.countdown').text(0);
					minutes_wrapper.find('.countdown').text(0);
					seconds_wrapper.find('.countdown').text(0);
				}
				
				if (countdown.hasClass('hidden')) {
					countdown.removeClass('hidden');
				}
			}, 1000);
	}
}