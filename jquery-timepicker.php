<?php
/**
Plugin Name: JQuery Timepicker
Plugin URI: https://github.com/irushavm/wordpress-plugin-jquery-timepicker
Description: This plugin allows you to attach the jQuery timepicker and datepair plugins to fields.
Version: 1.0.0
Author: Irusha Vidanamadura
Author URI: irusha@vidanamadura.net
License: MIT
License URI: https://spdx.org/licenses/MIT.html
*/

/*

*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define( 'JTP_VERSION', '1.0.0' );
define( 'JTP__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'JTP__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

function jtp_register_scripts() {
	wp_register_style('jquery-timepicker-css','https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.css');
	wp_register_script('jquery-timepicker-js','https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.js',array('jquery-core','jquery'),'',true);
	wp_register_script('jtp-datepair','https://cdnjs.cloudflare.com/ajax/libs/datepair.js/0.4.16/datepair.min.js',true);
	wp_register_script('jtp-datepair-jquery','https://cdnjs.cloudflare.com/ajax/libs/datepair.js/0.4.16/jquery.datepair.min.js',true);
	wp_register_script('jtp-custom',JTP__PLUGIN_URL.'src/jtp.js',true);

}
add_action('wp_enqueue_scripts', 'jtp_register_scripts');

function jtp_enqueue_scripts() {
	wp_enqueue_style('jquery-timepicker-css');
	wp_enqueue_script('jquery-timepicker-js');
	wp_enqueue_script('jtp-datepair');
	wp_enqueue_script('jtp-datepair-jquery');
	wp_enqueue_script('jtp-custom');

}

function jtp_get_class_listeners_from_admin_option($option_key){
	$field_array = array();
	$jtp_keys = get_option($option_key);
	if(!empty($jtp_keys)){
		foreach(explode(',', $jtp_keys) as $key){
			if(!empty($key)){
				$field_array[] = trim($key);
			}
		}
	}
	return $field_array;
}

add_shortcode('jquery_timepicker_field','jtp_prepare_fields');
function jtp_prepare_fields($attr,$content=""){

	$single_fields = jtp_get_class_listeners_from_admin_option('jtp_field_class_single');
	$duration_fields = jtp_get_class_listeners_from_admin_option('jtp_field_class_duration');


	jtp_enqueue_scripts();
	return 	'<input type="hidden" id="jtp_fields_single" value="'. implode(',', $single_fields).'">'.
			'<input type="hidden" id="jtp_fields_duration" value="'. implode(',', $duration_fields).'">'.
			'<style>.jtp-full-width{width:100% !important;}</style>'.
			$content;
}

if(is_admin()){
	include_once('admin/settings.php');
}
?>