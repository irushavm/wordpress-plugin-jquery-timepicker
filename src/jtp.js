

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
		},
		time_default_end: function () {
			var time = new Date();
			time.setMinutes(Math.round(time.getMinutes() /15) * 15);
			return time;
		}
	};

	function jtp_set_timepicker_single_listeners() {
		jtp_opts.fields.single.forEach(function (elname) {
			var el = jQuery(elname);
			if (!el.hasClass('timepicker_applied')) {
				el.timepicker({	timeFormat: jtp_opts.format, step: jtp_opts.step });
				el.timepicker('setTime', jtp_opts.time_default());
				el.addClass('timepicker_applied');
			}
		});
	}

	function jtp_set_timepicker_duration_listeners() {
		jtp_opts.fields.duration.forEach(function (elName) {
			var el;
			if (elName.includes(":start")) {
				elName = elName.replace(':start', '');
				el = jQuery(elName);
				if (!el.hasClass('timepicker_applied')) {
					el.addClass("time start");
					el.timepicker({
						timeFormat: jtp_opts.format,
						step: jtp_opts.step,
						showDuration: true,
						appendTo: el.parent(),
						className: 'jtp-full-width'
					});
					el.timepicker('setTime', jtp_opts.time_default());
					el.addClass('timepicker_applied');
				}
				return;
			} else if (elName.includes(":end")) {
				elName = elName.replace(':end', '');
				el = jQuery(elName);
				if (!el.hasClass('timepicker_applied')) {
					el.addClass("time end");
					el.timepicker({
						timeFormat: jtp_opts.format,
						step: jtp_opts.step,
						showDuration: true,
						appendTo: el.parent(),
						className: 'jtp-full-width'
					});
					/* Attached a changeTime event to propegate change event through */
					el.on("changeTime", function () {
						/* push function to next digest cycle */
						setTimeout(function () {
							jQuery(elName).trigger("change");

						}, 0);
					});
					el.timepicker('setTime', jtp_opts.time_default_end());
					el.addClass('timepicker_applied');
				}
			} else {
				return;
			}

			/* Call datepair on the most common element */
			var parentContainer = el.parent().parent().parent().parent();
			if (!parentContainer.hasClass('date_applied')) {
				jQuery(parentContainer).datepair();
				parentContainer.addClass('date_applied');
			}
		});
	}

	function jtp_process_listeners() {
		if (jtp_opts.fields.single && jtp_opts.fields.single.length > 0) {
			jtp_set_timepicker_single_listeners();
		}
		if (jtp_opts.fields.duration && jtp_opts.fields.duration.length > 0) {
			jtp_set_timepicker_duration_listeners();
		}
	}

	document.addEventListener("DOMContentLoaded", function () {
		if (jtp_fields_single || jtp_fields_duration) {
			var el = jQuery('#jtp_fields_single');
			jtp_opts.fields.single = el.val().split(',');
			el.remove();

			el = jQuery('#jtp_fields_duration');
			jtp_opts.fields.duration = el.val().split(',');
			el.remove();
		}
		jtp_process_listeners();
	});

	jQuery(window).change(function () {
		jtp_process_listeners();
	});
})();
