<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://tradesouthwest.com
 * @since      1.0.0
 *
 * @package    Mixmat_Tsw
 * @subpackage Mixmat_Tsw/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Mixmat_Tsw
 * @subpackage Mixmat_Tsw/includes
 * @author     Tradesouthwest <tradesouthwest@gmail.com>
 */
class Mixmat_Tsw_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

		delete_option( 'mixmar_tsw_date_plugin_activated' );
		return false;
	}

}
