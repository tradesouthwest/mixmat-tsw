<?php

/**
 * Plugin bootstrap file for MixMat TSW
 *
 * @link              https://tradesouthwest.com
 * @since             1.0.0
 * @package           Mixmat_Tsw
 *
 * @wordpress-plugin
 * Plugin Name:       MixMat TSW
 * Plugin URI:        https://http://themes.tradesouthwest.com/wordpress/plugins
 * Description:       Mixmat Page Mixer gives editors an easy way to sectionalize the posts and pages without knowing CSS or HTML.
 * Version:           1.0.2
 * Author:            Tradesouthwest
 * Author URI:        https://tradesouthwest.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mixmat-tsw
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'MIXMAT_TSW_VERSION', '1.0.2' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mixmat-tsw-activator.php
 */
function activate_mixmat_tsw() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mixmat-tsw-activator.php';
	Mixmat_Tsw_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mixmat-tsw-deactivator.php
 */
function deactivate_mixmat_tsw() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mixmat-tsw-deactivator.php';
	Mixmat_Tsw_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_mixmat_tsw' );
register_deactivation_hook( __FILE__, 'deactivate_mixmat_tsw' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mixmat-tsw.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mixmat_tsw() {

	$plugin = new Mixmat_Tsw();
	$plugin->run();

}
run_mixmat_tsw();
