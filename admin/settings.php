<?php

add_action( 'admin_menu', 'jtp_admin_setting_tab_submenu' );
function jtp_admin_setting_tab_submenu() {
    add_submenu_page(
        'options-general.php',
        'Jquery Timepicker Settings',
		'Jquery Timepicker',
        'manage_options',
        'jquery_timepicker',
		'jtp_admin_setting_tab'
	);
		
}

	function jtp_admin_setting_tab(){
	
	if(isset($_POST['jtp_admin_setting'])){
		update_option('jtp_field_class_duration',esc_attr(str_replace(' ','',$_POST['jtp_field_class_duration'])));
		update_option('jtp_field_class_single',esc_attr(str_replace(' ','',$_POST['jtp_field_class_single'])));
	}
	?>
		<div>
			<h2>Jquery Timepicker Settings</h2>
			<form method="post">
				<table>
					<tr><td>&nbsp;</td></tr>
					<tr><td><h3><strong>ID for single timepickers (i.e. must have 2 elements with additional classes 'start' and 'end')</strong></h3></td></tr>
					<tr>  
						<td><div id="titlediv">
								<div id="titlewrap">
									<textarea name="jtp_field_class_single" class="large-text code" id="jtp_single_class" ><?php echo stripslashes(get_option('jtp_field_class_single'));?></textarea><br>
									<b>Note:</b> Pick the id of textbox from markup &lt;input type="text" id="field1" /> and enter them in above field as comma separated. e.g. field1, field2 etc.
								</div>
							</div>
						</td>
					</tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td><h3><strong>ID for duration-based timepickers </strong></h3></td></tr>
					<tr>  
						<td><div id="titlediv">
								<p>
									<b>REQUIREMENTS:</b> <br>
									1. Must have the two input fields with these additional classes: 'time start' and 'time end'<br>
									2. Must have the same parent container"<br>
									For example:<br>
									&lt;div class="jtp-duration-container"><br>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;input id="YOUR_ID_HERE_1" class="time start"><br>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;input id="YOUR_ID_HERE_2" class="time end"><br>
									&lt;div>
								</p>
								<div id="titlewrap">
									<textarea name="jtp_field_class_duration" class="large-text code" id="jtp_duration_class" ><?php echo stripslashes(get_option('jtp_field_class_duration'));?></textarea><br>
									<b>Note:</b> Pick the id of textbox from markup and enter them in above field as comma separated. e.g. field1, field2 etc.
								</div>
							</div>
						</td>
					</tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td><input class="button button-primary button-large" type="submit" name="jtp_admin_setting" value="Save"/> </td></tr>
				</table>
			</form>
		</div>

	<?php
}
?>