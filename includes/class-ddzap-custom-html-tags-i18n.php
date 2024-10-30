<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://ddzap.com/about
 * @since      1.0.0
 *
 * @package    Ddzap_Custom_Html_Tags
 * @subpackage Ddzap_Custom_Html_Tags/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Ddzap_Custom_Html_Tags
 * @subpackage Ddzap_Custom_Html_Tags/includes
 * @author     DDZAP <support@ddzap.com>
 */
class Ddzap_Custom_Html_Tags_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'ddzap-custom-html-tags',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
