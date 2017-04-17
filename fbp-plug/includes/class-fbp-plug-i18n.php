<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       austinnchristensen.com
 * @since      1.0.0
 *
 * @package    Fbp_Plug
 * @subpackage Fbp_Plug/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Fbp_Plug
 * @subpackage Fbp_Plug/includes
 * @author     Austin Christensen <austinnchristensen@gmail.com>
 */
class Fbp_Plug_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'fbp-plug',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
