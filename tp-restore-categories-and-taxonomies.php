<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.tplugins.com/shop
 * @since             1.0.0
 * @package           Tp_Move_Categories_And_Taxonomies_To_Trash
 *
 * @wordpress-plugin
 * Plugin Name:       TP Restore Categories And Taxonomies
 * Plugin URI:        https://www.tplugins.com
 * Description:       Quickly restores deleted or lost categories and taxonomies. It's an essential tool for anyone who wants to save time when restoring lost data on their website.
 * Version:           1.0.0
 * Author:            TP Plugins
 * Author URI:        https://www.tplugins.com/shop
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tp-move-categories-and-taxonomies-to-trash
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
define('TP_MOVE_CATEGORIES_AND_TAXONOMIES_TO_TRASH_VERSION', '1.0.0');
define('TPMCATTT_PLUGIN_NAME', 'TP Restore Categories And Taxonomies PRO');
define('TPMCATTT_PLUGIN_BASENAME', plugin_basename(__FILE__));
//define('TPMCATTT_PLUGIN_API', 'https://www.tplugins.com/tp-services');
define('TPMCATTT_PLUGIN_API', 'https://www.tplugins.com/tp-services');
define('TPMCATTT_PLUGIN_SLUG', 'tp-restore-categories-and-taxonomies');
define('TPMCATTT_PLUGIN_SLUG_PRO', 'tp-restore-categories-and-taxonomies-pro');
define('TPMCATTT_PLUGIN_HOME', 'https://www.tplugins.com/');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-tp-move-categories-and-taxonomies-to-trash-activator.php
 */
function activate_tp_move_categories_and_taxonomies_to_trash() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tp-move-categories-and-taxonomies-to-trash-activator.php';
	Tp_Move_Categories_And_Taxonomies_To_Trash_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-tp-move-categories-and-taxonomies-to-trash-deactivator.php
 */
function deactivate_tp_move_categories_and_taxonomies_to_trash() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tp-move-categories-and-taxonomies-to-trash-deactivator.php';
	Tp_Move_Categories_And_Taxonomies_To_Trash_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_tp_move_categories_and_taxonomies_to_trash' );
register_deactivation_hook( __FILE__, 'deactivate_tp_move_categories_and_taxonomies_to_trash' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-tp-move-categories-and-taxonomies-to-trash.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_tp_move_categories_and_taxonomies_to_trash() {

	$plugin = new Tp_Move_Categories_And_Taxonomies_To_Trash();
	$plugin->run();

}
run_tp_move_categories_and_taxonomies_to_trash();