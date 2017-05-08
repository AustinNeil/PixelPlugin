<?php /*
Plugin Name: Serious Social Media
Plugin URI: http://austinnchristensen.com
Description: Adds Facebook Pixel tracking code to the <head> of your theme, allowing for general Facebook Pixel integration. The Pixel ID can be updated within the settings page on the left admin bar.
Author: Austin Christensen
Version: 1.0.1(Beta)
 */ ?>
<?php
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
	// register_setting('FBPInject-general-settings-group', 'Option2');
	// register_setting('FBPInject-general-settings-group', 'Option3');
	// register_setting('FBPInject-general-settings-group', 'Option4');
	// register_setting('FBPInject-general-settings-group', 'Option5');
}

// Validate these inputs within the browser first
function FBPInject_render_settings_page() {
	// Determine if the user has manage / admin rights to change settings
    if (!current_user_can('manage_options')) {
    	// if they do not, die
        wp_die('You do not have sufficient permissions to access this page.');
    } ?>
	<div class="wrap">
		<h1>Facebook Pixel Settings</h1>
		<!-- SUBMIT TO OWN PAGE FOR TESTING -->
		<form method="POST" action="options.php">
			<?php settings_fields('FBPInject-general-settings-group'); ?>
			<?php do_settings_sections('FBPInject-general-settings-group'); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">PixelID</th>
					<td><input required autofocus placeholder="15 Digit PixelID" type="text" id="PixelID" name="PixelID" pattern="[0-9]{15}" value="<?php echo esc_attr(get_option('PixelID')); ?>"></td>
				</tr>
				<tr valign="top">
					<th scope="row">Disable</th>
					<td><input type="hidden" name="Option2" value="<?php echo esc_attr(get_option('Option2')); ?>"></td>
				</tr>
				<tr valign="top">
					<th scope="row">Option3</th>
					<td><input disabled type="hidden" name="Option3" value="<?php echo esc_attr(get_option('Option3')); ?>"></td>
				</tr>				
				<tr valign="top">
					<th scope="row">Option4</th>
					<td><input disabled type="hidden" name="Option4" value="<?php echo esc_attr(get_option('Option4')); ?>"></td>
				</tr>				
			</table>
			<!-- NEED TO CLEAN, SANITIZE, AND CONFIRM DATA HERE FOR UPDATING -->
			<?php submit_button('Update'); ?>
		</form>
	</div>
<?php } 

// Called on the head hook everytime after the plugin is activated
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

// Call injectFBP_plugin_action_links in the plugin_action_links area (in the plugin settings, includes deactivate and edit)
add_filter('plugin_action_links', 'injectFBP_plugin_action_links', 10, 2);

// Defines a function that adds a link to the settings page next to the plugin options
function injectFBP_plugin_action_links($links, $file) {
	// Creates a constant of the plugin
    static $this_plugin;
    if (!$this_plugin) {
    	// if the plugin isn't correct, it find the absolute path to the file and corrects it
        $this_plugin = plugin_basename(__FILE__);
    }
    if ($file == $this_plugin) {
    	// Build the $settings_link variable- wpurl is better than just url in every case!
        $settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=Facebook-Pixel-Settings">Settings</a>';
        // Adds $settings_link to the beginning of the $links array. $links contains "deactivate" and "edit" also
        array_unshift($links, $settings_link);
    }
    // Return the $links array
    return $links;
}

// Only inject pixel ID if it isn't set to the default value
if(!(esc_attr(get_option('PixelID'))) == 000000000000000) {
	// Call inject_facebook_pixel function where wp_head hook appears
	add_action('wp_head', 'inject_facebook_pixel');
}








// For Later Release
// Validate the inputs on the server side
// function FBInject_validate_pixelID_input($input) {
// 	// defines empty variables
// 	$pixelErr = $option2Err = $option3Err = $option4Err = '';
// 	$pixel = $option2 = $option3 = $option4 = '';
// 	// testing
// 	echo 'Validation Called!';
// 	// make sure a post request is being made
// 	if ($_SERVER["REQUEST_METHOD"] == "POST") {
// 		// testing
// 		echo "METHOD IS POST";
// 		// make sure the field is filled
// 		if(empty($_POST["PixelID"])) {
// 			// if not filled, have an error
// 			echo "ID not entered!";
// 			$pixelErr = "PixelID is required";
// 			// if field is filled continue to validate
// 		} else {
// 			echo "ID WAS entered!";
// 			$pixel = test_input($_POST["PixelID"]);
// 			// check with a regex
// 			if(!preg_match("^[0-9]{15}$", $pixel)) {
// 				$nameErr = "Must contain exactly 15 digits";
// 			} else {
// 				echo "The number was a match and has been validated! WOO!!";
// 			}
// 		}
// 	}
// }

?>