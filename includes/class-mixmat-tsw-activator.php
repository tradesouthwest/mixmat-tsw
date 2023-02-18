<?php

/**
 * Fired during plugin activation
 *
 * @link       https://tradesouthwest.com
 * @since      1.0.0
 *
 * @package    Mixmat_Tsw
 * @subpackage Mixmat_Tsw/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Mixmat_Tsw
 * @subpackage Mixmat_Tsw/includes
 * @author     Tradesouthwest <tradesouthwest@gmail.com>
 */
class Mixmat_Tsw_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		$format    = get_option('date_format');
		$timestamp = get_the_time();
		$time      = date_i18n($format, $timestamp, true);
		add_option( 'mixmat_tsw_date_plugin_activated' );
		update_option( 'mixmat_tsw_date_plugin_activated', $time );
	}

}
