<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://#
 * @since             1.0.0
 * @package           Url_Redirection
 *
 * @wordpress-plugin
 * Plugin Name:       Redirecionamento de URLS (DIMEP - Coopersystem)
 * Plugin URI:        https://#
 * Description:       O plugin permite a criação e gerenciamento de redirecionamentos no site, por meio da definição de uma URL de origem e uma URL de destino.
 * Version:           1.0.0
 * Author:            Coopersystem
 * Author URI:        https://#
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       url-redirection
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
define( 'URL_REDIRECTION_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-url-redirection-activator.php
 */
function activate_url_redirection() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-url-redirection-activator.php';
	Url_Redirection_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-url-redirection-deactivator.php
 */
function deactivate_url_redirection() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-url-redirection-deactivator.php';
	Url_Redirection_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_url_redirection' );
register_deactivation_hook( __FILE__, 'deactivate_url_redirection' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-url-redirection.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_url_redirection() {

	$plugin = new Url_Redirection();
	$plugin->run();

}
run_url_redirection();
