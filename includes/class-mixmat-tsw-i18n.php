<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://tradesouthwest.com
 * @since      1.0.0
 *
 * @package    Mixmat_Tsw
 * @subpackage Mixmat_Tsw/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Mixmat_Tsw
 * @subpackage Mixmat_Tsw/includes
 * @author     Tradesouthwest <tradesouthwest@gmail.com>
 */
class Mixmat_Tsw_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'mixmat-tsw',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
