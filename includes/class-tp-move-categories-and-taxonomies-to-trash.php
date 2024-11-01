<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.tplugins.com/shop
 * @since      1.0.0
 *
 * @package    Tp_Move_Categories_And_Taxonomies_To_Trash
 * @subpackage Tp_Move_Categories_And_Taxonomies_To_Trash/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Tp_Move_Categories_And_Taxonomies_To_Trash
 * @subpackage Tp_Move_Categories_And_Taxonomies_To_Trash/includes
 * @author     TP Plugins <pluginstp@gmail.com>
 */
class Tp_Move_Categories_And_Taxonomies_To_Trash {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Tp_Move_Categories_And_Taxonomies_To_Trash_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'TP_MOVE_CATEGORIES_AND_TAXONOMIES_TO_TRASH_VERSION' ) ) {
			$this->version = TP_MOVE_CATEGORIES_AND_TAXONOMIES_TO_TRASH_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'tp-move-categories-and-taxonomies-to-trash';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Tp_Move_Categories_And_Taxonomies_To_Trash_Loader. Orchestrates the hooks of the plugin.
	 * - Tp_Move_Categories_And_Taxonomies_To_Trash_i18n. Defines internationalization functionality.
	 * - Tp_Move_Categories_And_Taxonomies_To_Trash_Admin. Defines all hooks for the admin area.
	 * - Tp_Move_Categories_And_Taxonomies_To_Trash_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tp-move-categories-and-taxonomies-to-trash-loader.php';


		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tp-move-categories-and-taxonomies-to-trash-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-tp-move-categories-and-taxonomies-to-trash-admin.php';


		$this->loader = new Tp_Move_Categories_And_Taxonomies_To_Trash_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Tp_Move_Categories_And_Taxonomies_To_Trash_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Tp_Move_Categories_And_Taxonomies_To_Trash_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Tp_Move_Categories_And_Taxonomies_To_Trash_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_filter( 'plugin_action_links_'.TPMCATTT_PLUGIN_BASENAME, $plugin_admin,'settings_link', 10, 2 );
		//$this->loader->add_filter( 'plugin_row_meta', $plugin_admin, 'get_pro_link', 10, 2 );

		// Hook the function to the admin_menu action to add the page
		$this->loader->add_action('admin_menu', $plugin_admin, 'taxonomies_trash_admin_page');
		$this->loader->add_action('admin_menu', $plugin_admin, 'taxonomies_trash_admin_settings_page');

		//call register settings function
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_plugin_settings' );

		$this->loader->add_action( 'wp_ajax_tpmcattt_restore_term', $plugin_admin, 'restore_term' );

		$this->loader->add_action( 'wp_ajax_tpmcattt_restore_woo_term', $plugin_admin, 'restore_woo_term' );

		$this->loader->add_action( 'wp_ajax_tpmcattt_delete_term', $plugin_admin, 'delete_term' );
		$this->loader->add_action( 'wp_ajax_tpmcattt_delete_woo_term', $plugin_admin, 'delete_woo_term' );

		$this->loader->add_action( 'pre_delete_term', $plugin_admin, 'move_taxonomy_terms_to_trash', 10, 2 );
		$this->loader->add_action( 'pre_delete_term', $plugin_admin, 'move_taxonomy_termmeta_to_trash', 10, 2 );
		$this->loader->add_action( 'pre_delete_term', $plugin_admin, 'move_taxonomy_relationships_to_trash', 10, 2 );

		$this->loader->add_action( 'woocommerce_before_attribute_delete', $plugin_admin, 'move_woocommerce_attribute_to_trash', 10, 3 );

	}


	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Tp_Move_Categories_And_Taxonomies_To_Trash_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
