<!-- Required Heading -->
<?php /*
Plugin Name: Alternate Plugin
Plugin URI: http://austinnchristensen.com
Description: Adds Facebook Pixel trascking code to the <head> of your theme, by hooking to wp_head.
Author: Austin Christensen
Version: 0.0.3(Alpha)
 */ ?>
<?php

// function FBPInject_activate() {
// 	register_uninstall_hook(__FILE__, 'FBPInject_uninstall');
// }

// register_activation_hook(__FILE__, 'FBPInject_activate');

// function FBPInject_uninstall() {
// 	// Unregister the new settings
// 	unregister_setting('FBPInject-general-settings-group', 'PixelID', 'FBInject_validate_input');
// 	unregister_setting('FBPInject-general-settings-group', 'Option2', 'FBInject_validate_input');
// 	unregister_setting('FBPInject-general-settings-group', 'Option3', 'FBInject_validate_input');
// 	unregister_setting('FBPInject-general-settings-group', 'Option4', 'FBInject_validate_input');
// 	unregister_setting('FBPInject-general-settings-group', 'Option5', 'FBInject_validate_input');
// }

// Create a top level settings admin page
add_action('admin_menu', 'FBPInject_create_menu');

function FBPInject_create_menu() {
	// Create top level menu
	add_menu_page('Facebook Pixel Settings', 'Manage Pixel Settings', 'administrator', 'Facebook-Pixel-Settings',
	'FBPInject_render_settings_page');
	// Register the settings function
	add_action('admin_init', 'register_FBPInject_settings');
}

function register_FBPInject_settings() {
	// Register the new settings
	register_setting('FBPInject-general-settings-group', 'PixelID', 'FBInject_validate_pixelID_input');
	register_setting('FBPInject-general-settings-group', 'Option2');
	register_setting('FBPInject-general-settings-group', 'Option3');
	register_setting('FBPInject-general-settings-group', 'Option4');
	register_setting('FBPInject-general-settings-group', 'Option5');
}

function FBPInject_render_settings_page() { ?>
	<div class="wrap">
		<h1>Facebook Pixel Settings</h1>
		<form method="POST" action="options.php">
			<?php settings_fields('FBPInject-general-settings-group'); ?>
			<?php do_settings_sections('FBPInject-general-settings-group'); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">PixelID</th>
					<td><input type="number" id="PixelID" name="PixelID" maxlength="15" minlength="15" value="<?php echo esc_attr(get_option('PixelID')); ?>"></td>
				</tr>
				<tr valign="top">
					<th scope="row">Option2</th>
					<td><input type="text" name="Option2" value="<?php echo esc_attr(get_option('Option2')); ?>"></td>
				</tr>
				<tr valign="top">
					<th scope="row">Option3</th>
					<td><input type="text" name="Option3" value="<?php echo esc_attr(get_option('Option3')); ?>"></td>
				</tr>				
				<tr valign="top">
					<th scope="row">Option4</th>
					<td><input type="text" name="Option4" value="<?php echo esc_attr(get_option('Option4')); ?>"></td>
				</tr>				
				<tr valign="top">
					<th scope="row">Option5</th>
					<td><input type="text" name="Option5" value="<?php echo esc_attr(get_option('Option5')); ?>"></td>
				</tr>
			</table>
			<!-- NEED TO CLEAN, SANITIZE, AND CONFIRM DATA HERE FOR UPDATING -->
			<?php submit_button('Update'); ?>
		</form>
	</div>
<?php }

function FBInject_validate_pixelID_input($input, inject_facebook_pixel()) {
	$correctFormat = intval($_POST['PixelID']);
	if(!$correctFormat) {
		$correctFormat = 000000000000000;
	}
	if(!strlen($correctFormat) == 15) {
		$correctFormat = substr($corr, 0,15);
	}
	update_post_meta($post->ID, 'PixelID', $correctFormat);

}

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