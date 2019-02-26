

(function () {
	var jtp_opts = {
		format: 'g:i a',
		step: 15, // 15 minute steps,
		fields: {
			single: [],
			duration: [],
		},
		time_default: function () {
			var time = new Date();
			time.setMinutes(Math.round(time.getMinutes() /15) * 15);
			return time;
		}
	};

	function jtp_set_timepicker_single_listeners() {
		jQuery(jtp_opts.fields.single).each(function(){
			if(!this.timepicker_applied) {
				jQuery(this).timepicker({
					timeFormat: jtp_opts.format,
					step: jtp_opts.step,
				});
				jQuery(this).timepicker('setTime', jtp_opts.time_default());
				this.timepicker_applied = true;
			}
		});
	}

	function jtp_set_timepicker_duration_listeners(){
		jQuery(jtp_opts.fields.duration).each(function(){
			if(!this.timepicker_applied) {
				jQuery(this).timepicker({
					timeFormat: jtp_opts.format,
					step: jtp_opts.step,
					showDuration: true,
				});
				jQuery(this).timepicker('setTime', jtp_opts.time_default());
				this.timepicker_applied = true;
			}
			if(!jQuery(this).parent().datepair_applied) {
				jQuery(this).parent().datepair();
				jQuery(this).parent().datepair_applied = true;
			}
		});
	}

	function jtp_process_listeners(){
		if(jtp_opts.fields.single && jtp_opts.fields.single.length > 0) {
			jtp_set_timepicker_single_listeners();
		}
		if(jtp_opts.fields.duration && jtp_opts.fields.duration.length > 0) {
			jtp_set_timepicker_duration_listeners();
		}
	}

	jQuery(window).load(function() {
		if(jtp_fields_single || jtp_fields_duration) {
			var el = jQuery('#jtp_fields_single');
			jtp_opts.fields.single = el.val(); 
			el.remove();

			el = jQuery('#jtp_fields_duration');
			jtp_opts.fields.duration = el.val(); 
			el.remove();
		}
		jtp_process_listeners();
	});
	
	jQuery(window).change(function() {
		jtp_process_listeners();
	});
})();
