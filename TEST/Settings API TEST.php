<?php /*
Plugin Name: Alternate Plugin
Plugin URI: http://austinnchristensen.com
Description: Adds Facebook Pixel tracking code to the <head> of your theme, by hooking to wp_head.
Author: Austin Christensen
Version: 0.0.6(Alpha)
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

http://www.presscoders.com/wordpress-settings-api-explained/
function FBInject_AddOptionsPage_fn() {
	add_options_page('Facebook Pixel Settings', 'Manage Pixel Settings', 'administrator', __FILE__,
	'options_page_fn');
}

// Create a top level settings admin page
add_action('admin_menu', 'FBPInject_AddOptionsPage_fn');
// Renders the options page
function options_page_fn() {
?>
	<div class="wrap">
		<h1>Facebook Pixel Settings</h1>
		This page allows you to enter your custom settings and unique PixelID
		<form action="options.php" method="post">
		<?php settings_fields('plugin_options'); ?>
		<?php do_settings_sections(__FILE__); ?>
		<p class="submit">
			<input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
		</p>
		</form>
	</div>
<?php
}





//Settings API Variables
$option_group = "FBPInject-general-settings-group";
$option_name = array("PixelID","Option2","Option3","Option4");

// Turn this into a sub-level menu
function FBPInject_create_menu() {
	// Create top level menu
	add_options_page('Facebook Pixel Settings', 'Manage Pixel Settings', 'administrator', 'Facebook-Pixel-Settings',
	'FBPInject_render_settings_page');
	// Register the settings function
	add_action('admin_init', 'register_FBPInject_settings');
}

// Get datavalidation added
function register_FBPInject_settings() {
	// Register the new settings
	register_setting($option_group, $option_name);
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
					<!-- Add back after finished with php validation: pattern="[0-9]{15}"  -->
					<td><input required autofocus placeholder="Enter your 15 digit PixelID" type="text" id="PixelID" name="PixelID" value="<?php echo esc_attr(get_option('PixelID')); ?>"></td>
					<span><h3>Error</h3><?php echo $pixelErr;?></span>
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
function FBInject_validate_pixelID_input() {
	// defines empty variables
	$pixelErr = "";
	$pixel = "";
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
				$pixelErr = "Must contain exactly 15 digits";
			} else {
				echo "The number was a match for the format and has been validated! WOO!!";
				return $pixel;
			}
		}
	}
	return $pixel;
}
// Takes data from the input, sanitizes completely
// used within the validate_input function
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
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

if(isset($_POST['submit']) || ($_SERVER["REQUEST_METHOD"] = "POST")) {
	FBInject_validate_pixelID_input();
}
//When Update button is pressed
// THIS NEEDS TO BE DONE AFTER THE USER UPDATES THE SETTINGS
// Call inject_facebook_pixel function where wp_head hook appears
// add_action('wp_head', 'inject_facebook_pixel');
?>