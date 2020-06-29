<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.alexisvillegas.com/
 * @since             1.0.0
 * @package           Vagabond_Core
 *
 * @wordpress-plugin
 * Plugin Name:       Vagabond Core Functionality
 * Plugin URI:        https://www.alexisvillegas.com/
 * Description:       This plugin contains all of the website's core functionality so that it is theme independent.
 * Version:           1.0.0
 * Author:            Alexis J. Villegas
 * Author URI:        https://www.alexisvillegas.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       vagabond-core
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
define( 'VAGABOND_CORE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-vagabond-core-activator.php
 */
function activate_vagabond_core() {

	require_once plugin_dir_path( __FILE__ ) . 'includes/class-vagabond-core-activator.php';
	Vagabond_Core_Activator::activate();

}

register_activation_hook( __FILE__, 'activate_vagabond_core' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-vagabond-core.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since 1.0.0
 */
function run_vagabond_core() {

	$plugin = new Vagabond_Core();
	$plugin->run();

}

run_vagabond_core();
