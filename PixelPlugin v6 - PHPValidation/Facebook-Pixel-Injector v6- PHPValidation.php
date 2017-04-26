<?php /*
Plugin Name: Alternate Plugin
Plugin URI: http://austinnchristensen.com
Description: Adds Facebook Pixel trascking code to the <head> of your theme, by hooking to wp_head.
Author: Austin Christensen
Version: 0.0.5(Alpha)
 */ ?>
<?php

// On Activation - Creates default values in the database
// On Uninstall - Removes the custom options saved within the options.php
// UNINSTALL CURRENTLY DOES NOT WORK CURRECTLY
// register_uninstall_hook(__FILE__, 'FBPInject_uninstall');

// function FBPInject_uninstall(){
// 	delete_option('PixelID');
// 	delete_option('Option2');
// 	delete_option('Option3');
// 	delete_option('Option4');
// 	delete_option('Option5');
// }

// Create a top level settings admin page
add_action('admin_menu', 'FBPInject_create_menu');

// Turn this into a sub-level menu
function FBPInject_create_menu() {
	// Create top level menu
	add_menu_page('Facebook Pixel Settings', 'Manage Pixel Settings', 'administrator', 'Facebook-Pixel-Settings',
	'FBPInject_render_settings_page');
	// Register the settings function
	add_action('admin_init', 'register_FBPInject_settings');
}

// Get datavalidation added
function register_FBPInject_settings() {
	// Register the new settings
	register_setting('FBPInject-general-settings-group', 'PixelID');
	register_setting('FBPInject-general-settings-group', 'Option2');
	register_setting('FBPInject-general-settings-group', 'Option3');
	register_setting('FBPInject-general-settings-group', 'Option4');
	register_setting('FBPInject-general-settings-group', 'Option5');
}

// Validate these inputs within the browser first
function FBPInject_render_settings_page() { ?>
	<div class="wrap">
		<h1>Facebook Pixel Settings</h1>
		<!-- SUBMIT TO OWN PAGE FOR TESTING -->
		<form method="POST" action="options.php">
			<?php settings_fields('FBPInject-general-settings-group'); ?>
			<?php do_settings_sections('FBPInject-general-settings-group'); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">PixelID</th>
					<td><input required autofocus placeholder="Enter your 15 digit PixelID" type="text" id="PixelID" name="PixelID" pattern="[0-9]{15}" value="<?php echo esc_attr(get_option('PixelID')); ?>"></td>
				</tr>
				<tr valign="top">
					<th scope="row">Option2</th>
					<td><input disabled type="text" name="Option2" value="<?php echo esc_attr(get_option('Option2')); ?>"></td>
				</tr>
				<tr valign="top">
					<th scope="row">Option3</th>
					<td><input disabled="text" name="Option3" value="<?php echo esc_attr(get_option('Option3')); ?>"></td>
				</tr>				
				<tr valign="top">
					<th scope="row">Option4</th>
					<td><input disabled="text" name="Option4" value="<?php echo esc_attr(get_option('Option4')); ?>"></td>
				</tr>				
			</table>
			<!-- NEED TO CLEAN, SANITIZE, AND CONFIRM DATA HERE FOR UPDATING -->
			<?php submit_button('Update'); ?>
		</form>
	</div>
<?php } 

// Validate the inputs on the server side
function FBInject_validate_pixelID_input($input) {
	// defines empty variables
	$pixelErr = $option2Err = $option3Err = $option4Err = '';
	$pixel = $option2 = $option3 = $option4 = '';
	// testing
	echo 'Validation Called!';
	// make sure a post request is being made
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// testing
		echo "METHOD IS POST";
		// make sure the field is filled
		if(empty($_POST["PixelID"])) {
			// if not filled, have an error
			echo "ID not entered!";
			$pixelErr = "PixelID is required";
			// if field is filled continue to validate
		} else {
			echo "ID WAS entered!";
			$pixel = test_input($_POST["PixelID"]);
			// check with a regex
			if(!preg_match("^[0-9]{15}$", $pixel)) {
				$nameErr = "Must contain exactly 15 digits";
			} else {
				echo "The number was a match and has been validated! WOO!!";
			}
		}
	}
}

// Called once the form has been submitted
function inject_facebook_pixel() {?>
	<!-- Facebook Pixel Code -->
	<script>
		!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
		n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
		n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
		t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
		document,'script','https://connect.facebook.net/en_US/fbevents.js');
		fbq('init', <?php echo esc_attr(get_option('PixelID')); ?>);
		fbq('track', 'PageView');
	</script>
	<!-- The Pixel ID is embedded below as well -->
	<noscript><img height="1" width="1" style="display:none"
		src="https://www.facebook.com/tr?id=<?php echo esc_attr(get_option('PixelID')); ?>&ev=PageView&noscript=1"/>
	</noscript>
	<!-- DO NOT MODIFY -->
	<!-- End Facebook Pixel Code -->
<?php }

// THIS NEEDS TO BE DONE AFTER THE USER UPDATES THE SETTINGS
// Call inject_facebook_pixel function where wp_head hook appears
// add_action('wp_head', 'inject_facebook_pixel');
?>