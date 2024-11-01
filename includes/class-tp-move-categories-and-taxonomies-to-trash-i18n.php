<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.tplugins.com/shop
 * @since      1.0.0
 *
 * @package    Tp_Move_Categories_And_Taxonomies_To_Trash
 * @subpackage Tp_Move_Categories_And_Taxonomies_To_Trash/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Tp_Move_Categories_And_Taxonomies_To_Trash
 * @subpackage Tp_Move_Categories_And_Taxonomies_To_Trash/includes
 * @author     TP Plugins <pluginstp@gmail.com>
 */
class Tp_Move_Categories_And_Taxonomies_To_Trash_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'tp-move-categories-and-taxonomies-to-trash',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
