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
    static $this_plugin;
    if (!$this_plugin) {
        $this_plugin = plugin_basename(__FILE__);
    }
    if ($file == $this_plugin) {
        // The "page" query string value must be equal to the slug
        // of the Settings admin page we defined earlier, which in
        // this case equals "injectFBP-settings".
        $settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=injectFBP-settings">Settings</a>';
        array_unshift($links, $settings_link);
    }
    return $links;
}
function injectFBP_admin_menu() {
    $page_title = 'Inject Facebook Pixel Settings';
    $menu_title = 'Inject Facebook Pixel';
    $capability = 'manage_options';
    $menu_slug = 'injectFBP-settings';
    $function = 'injectFBP_settings';
    add_options_page($page_title, $menu_title, $capability, $menu_slug, $function);
}
function injectFBP_settings() {
    if (!current_user_can('manage_options')) {
        wp_die('You do not have sufficient permissions to access this page.');
    }
    // Here is where you could start displaying the HTML needed for the settings
    // page, or you could include a file that handles the HTML output for you.
}
add_action( 'wp_head', 'inject_facebook_pixel', 10 );
add_filter('plugin_action_links', 'injectFBP_plugin_action_links', 10, 2);
add_action('admin_menu', 'injectFBP_admin_menu');
?>