<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              austinnchristensen.com
 * @since             1.0.0
 * @package           Fbp_Plug
 *
 * @wordpress-plugin
 * Plugin Name:       FacebookPixelPlugin
 * Plugin URI:        https://github.com/AustinNeil/PixelPlugin
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Austin Christensen
 * Author URI:        austinnchristensen.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       fbp-plug
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-fbp-plug-activator.php
 */
function activate_fbp_plug() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-fbp-plug-activator.php';
	Fbp_Plug_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-fbp-plug-deactivator.php
 */
function deactivate_fbp_plug() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-fbp-plug-deactivator.php';
	Fbp_Plug_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_fbp_plug' );
register_deactivation_hook( __FILE__, 'deactivate_fbp_plug' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-fbp-plug.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_fbp_plug() {

	$plugin = new Fbp_Plug();
	$plugin->run();

}
run_fbp_plug();
