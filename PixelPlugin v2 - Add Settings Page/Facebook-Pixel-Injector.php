<!-- Required Heading -->
<?php /*
Plugin Name: Facebook Pixel Injector
Plugin URI: http://austinnchristensen.com
Description: Adds Facebook Pixel trascking code to the <head> of your theme, by hooking to wp_head.
Author: Austin Christensen
Version: 0.0.2(Alpha)
 */ ?><?php
// defines function that adds code when it runs into the wp_head hook (should be in the head file)
function inject_facebook_pixel() {?>
	<!-- Facebook Pixel Code -->
	<!-- Pixel ID is embedded here -->
	<script>
		!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
		n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
		n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
		t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
		document,'script','https://connect.facebook.net/en_US/fbevents.js');
		fbq('init', 000000000000000); // Insert your pixel ID here.
		fbq('track', 'PageView');
	</script>
	<!-- The Pixel ID is embedded below as well -->
	<noscript><img height="1" width="1" style="display:none"
		src="https://www.facebook.com/tr?id=000000000000000&ev=PageView&noscript=1"/>
	</noscript>
	<!-- DO NOT MODIFY -->
	<!-- End Facebook Pixel Code -->
<?php }

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
        $settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=injectFBP-settings">Settings</a>';
        // Adds $settings_link to the beginning of the $links array. $links contains "deactivate" and "edit" also
        array_unshift($links, $settings_link);
    }
    // Return the $links array
    return $links;
}
// Renders a settings page link in the Admin Panel under Settings
function injectFBP_admin_menu() {
	// Define what the page title will appear as in the menu
    $page_title = 'Inject Facebook Pixel Settings';
    // Define menu title
    $menu_title = 'Inject Facebook Pixel';
    // define the capability the user must have
    $capability = 'manage_options';
    // This is what will appear in the URL - Must allign with the above functions "$ettings_link"
    $menu_slug = 'injectFBP-settings';
    // Callback function
    $function = 'injectFBP_settings';
    // Render the Page
    add_options_page($page_title, $menu_title, $capability, $menu_slug, $function);
}
// figure out what this functions purpose is
function injectFBP_settings() {
	// Determine if the user has manage / admin rights to change settings
    if (!current_user_can('manage_options')) {
    	// if they do not, die
        wp_die('You do not have sufficient permissions to access this page.');
    }
    // Add HTML/PHP for the Settings Page HERE or Render a Settings Page here
}
// Call inject_facebook_pixel function where wp_head hook appears
add_action( 'wp_head', 'inject_facebook_pixel', 10 );
// Call injectFBP_plugin_action_links in the plugin_action_links area (in the plugin settings, includes deactivate and edit)
add_filter('plugin_action_links', 'injectFBP_plugin_action_links', 10, 2);
// Call injectFBP_admin_menu function in the admin_menu area. Effectively adds the settings page to the admin->settings menu
add_action('admin_menu', 'injectFBP_admin_menu');
?>