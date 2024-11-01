<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.tplugins.com/shop
 * @since      1.0.0
 *
 * @package    Tp_Move_Categories_And_Taxonomies_To_Trash
 * @subpackage Tp_Move_Categories_And_Taxonomies_To_Trash/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Tp_Move_Categories_And_Taxonomies_To_Trash
 * @subpackage Tp_Move_Categories_And_Taxonomies_To_Trash/admin
 * @author     TP Plugins <pluginstp@gmail.com>
 */
class Tp_Move_Categories_And_Taxonomies_To_Trash_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( 'datatables.min', plugin_dir_url( __FILE__ ) . 'css/datatables.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/tp-move-categories-and-taxonomies-to-trash-admin.css', array(), $this->version, 'all' );
		
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( 'datatables.min', plugin_dir_url( __FILE__ ) . 'js/datatables.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/tp-move-categories-and-taxonomies-to-trash-admin.js', array( 'jquery','jquery-ui-core','jquery-ui-tabs' ), $this->version, false );

		$ajax_nonce = wp_create_nonce('tpmcattt_nonce');
		
		wp_localize_script( $this->plugin_name, 'tpmcattt',
			array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'ajax_nonce' => $ajax_nonce
			)
		);

	}

	//add_action( 'pre_delete_term', 'move_taxonomy_termmeta_to_trash', 10, 2 );
	public function move_taxonomy_terms_to_trash( $term_id, $taxonomy ) {

		global $wpdb;
  
		$term = get_term($term_id);

		//-----------------------------------------------
		$wpdb->insert(
			'tpmcattt_terms',
			array(
				'term_id'          => $term->term_id,
				'name'             => $term->name,
				'slug'             => $term->slug,
				'term_group'       => $term->term_group,
				'term_status'      => 'trash'
			)
		);
		//-----------------------------------------------
		$wpdb->insert(
			'tpmcattt_term_taxonomy',
			array(
				'term_taxonomy_id' => $term->term_taxonomy_id,
				'term_id'          => $term->term_id,
				'taxonomy'         => $term->taxonomy,
				'description'      => $term->description,
				'parent'           => $term->parent,
				'count'            => $term->count
			)
		);
		//-----------------------------------------------
		// $wpdb->insert(
		// 	'tpmcattt_term_relationships',
		// 	array(
		// 		'object_id'        => $term->object_id,
		// 		'term_taxonomy_id' => $term->term_taxonomy_id,
		// 		'term_order'       => $term->term_order
		// 	)
		// );
		//-----------------------------------------------
		// $wpdb->insert(
		// 	'tpmcattt_termmeta',
		// 	array(
		// 		'meta_id'          => $term->meta_id,
		// 		'term_id'          => $term->term_id,
		// 		'meta_key'         => $term->meta_key,
		// 		'meta_value'       => $term->meta_value
		// 	)
		// );
		//-----------------------------------------------
	}

	public function move_taxonomy_termmeta_to_trash( $term_id, $taxonomy ) {

		global $wpdb;
  
		// $term = get_term($term_id);

		$results = $wpdb->get_results(
			$wpdb->prepare("
				SELECT *
				FROM {$wpdb->prefix}termmeta
				WHERE term_id = %d
			", $term_id)
		);

		if($results) {

			foreach ($results as $result) {
				// Access the metadata using $result->meta_key and $result->meta_value
				// echo $result->meta_key . ': ' . $result->meta_value . '<br>';
		
				//-----------------------------------------------
				$wpdb->insert(
					'tpmcattt_termmeta',
					array(
						'meta_id'    => $result->meta_id,
						'term_id'    => $result->term_id,
						'meta_key'   => $result->meta_key,
						'meta_value' => $result->meta_value
					)
				);
				//-----------------------------------------------

			}

		}

	}

	public function move_taxonomy_relationships_to_trash( $term_id, $taxonomy ) {

		global $wpdb;
  
		// $term = get_term($term_id);

		$results = $wpdb->get_results(
			$wpdb->prepare("
				SELECT *
				FROM {$wpdb->prefix}term_relationships
				WHERE term_taxonomy_id = %d
			", $term_id)
		);

		if($results) {

			foreach ($results as $result) {
				// Access the metadata using $result->meta_key and $result->meta_value
				// echo $result->meta_key . ': ' . $result->meta_value . '<br>';
		
				//-----------------------------------------------
				$wpdb->insert(
					'tpmcattt_term_relationships',
					array(
						'object_id'        => $result->object_id,
						'term_taxonomy_id' => $result->term_taxonomy_id,
						'term_order'       => $result->term_order
					)
				);
				//-----------------------------------------------

			}

		}

	}

	//--------------------------------------------
	/**
	 * Function for `woocommerce_before_attribute_delete` action-hook.
	 * 
	 * @param int    $id       Attribute ID.
	 * @param string $name     Attribute name.
	 * @param string $taxonomy Attribute taxonomy name.
	 *
	 * @return void
	 */
	// add_action( 'woocommerce_before_attribute_delete', 'wp_kama_woocommerce_before_attribute_delete_action', 10, 3 );
	public function move_woocommerce_attribute_to_trash( $attribute_id, $name, $taxonomy ) {

		global $wpdb;
  
		// $term = get_term($term_id);

		$results = $wpdb->get_results(
			$wpdb->prepare("
				SELECT *
				FROM {$wpdb->prefix}woocommerce_attribute_taxonomies
				WHERE attribute_id = %d
			", $attribute_id)
		);

		if($results) {

			foreach ($results as $result) {
				// Access the metadata using $result->meta_key and $result->meta_value
				// echo $result->meta_key . ': ' . $result->meta_value . '<br>';
		
				//-----------------------------------------------
				$wpdb->insert(
					'tpmcattt_woocommerce_attribute_taxonomies',
					array(
						'attribute_id'    => $result->attribute_id,
						'attribute_name'    => $result->attribute_name,
						'attribute_label'   => $result->attribute_label,
						'attribute_type' => $result->attribute_type,
						'attribute_orderby' => $result->attribute_orderby,
						'attribute_public' => $result->attribute_public
					)
				);
				//-----------------------------------------------

			}

		}

	}
	//--------------------------------------------

	public function taxonomies_trash_admin_page() {
		add_menu_page(
			'Taxonomies Trash',                                  // Page title
			'Taxonomies Trash',                                  // Menu title
			'manage_options',                                    // Capability required to access the page
			'tpmcattt-admin-page',                               // Page slug
			array($this,'taxonomies_trash_admin_page_callback'), // Callback function to display the page content
			'dashicons-trash',                                   // Icon URL or dashicon class for the menu item
			10                                                   // Position of the menu item in the menu
		);
	}
	
	public function taxonomies_trash_admin_page_callback() {
		// Code to display the page content goes here

		global $wpdb;
		//$query = 'SELECT * FROM tpmcattt_terms WHERE term_status = "trash"';
		//$results = $wpdb->get_results($query,ARRAY_A);

		$results = $wpdb->get_results(
			$wpdb->prepare("
				SELECT tpmcattt_terms.*, tpmcattt_term_taxonomy.description, tpmcattt_term_taxonomy.taxonomy, tpmcattt_term_taxonomy.parent, tpmcattt_term_taxonomy.count
				FROM tpmcattt_terms
				JOIN tpmcattt_term_taxonomy
				ON tpmcattt_terms.term_id = tpmcattt_term_taxonomy.term_id
			" )
		);

		// wp_dbug($results);

		$results_woo = $wpdb->get_results(
			$wpdb->prepare("
				SELECT *
				FROM tpmcattt_woocommerce_attribute_taxonomies
			")
		);

		//wp_dbug($results_woo);

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/tp-move-categories-and-taxonomies-to-trash-admin-display.php';
	}
	
	public function restore_term() {

		check_ajax_referer('tpmcattt_nonce', 'nonce');

		global $wpdb;

		// wp_dbug($_POST);

		$term_id = isset($_POST['term_id']) ? absint($_POST['term_id']) : 0;
		
		$table1 = "tpmcattt_terms";
		$table2 = "tpmcattt_term_taxonomy";
		$table3 = "tpmcattt_term_relationships";
		$table4 = "tpmcattt_termmeta";

		$terms = $wpdb->get_results(
			$wpdb->prepare("
				SELECT *
				FROM {$table1} 
				WHERE term_id = %d
			", $term_id)
		);

		$term_taxonomy = $wpdb->get_results(
			$wpdb->prepare("
				SELECT *
				FROM {$table2} 
				WHERE term_id = %d
			", $term_id)
		);

		$term_relationships = $wpdb->get_results(
			$wpdb->prepare("
				SELECT *
				FROM {$table3} 
				WHERE term_taxonomy_id = %d
			", $term_id)
		);

		$termmeta = $wpdb->get_results(
			$wpdb->prepare("
				SELECT *
				FROM {$table4} 
				WHERE term_id = %d
			", $term_id)
		);

		// wp_dbug($terms);
		// wp_dbug($term_taxonomy);
		// wp_dbug($term_taxonomy[0]->taxonomy);
		// wp_dbug($term_relationships);
		// wp_dbug($termmeta);
		// wp_die();

		if($term_taxonomy[0]->taxonomy == 'category' || $term_taxonomy[0]->taxonomy == 'post_tag') {
			
			if($terms) {

				foreach ($terms as $term) {
					$wpdb->insert(
						"{$wpdb->prefix}terms",
						array(
							'term_id'    => $term->term_id,
							'name'       => $term->name,
							'slug'       => $term->slug,
							'term_group' => $term->term_group
						)
					);
				}

			}
			
			if($term_taxonomy) {

				foreach ($term_taxonomy as $term_tax) {
					$wpdb->insert(
						"{$wpdb->prefix}term_taxonomy",
						array(
							'term_taxonomy_id' => $term_tax->term_taxonomy_id,
							'term_id'          => $term_tax->term_id,
							'taxonomy'         => $term_tax->taxonomy,
							'description'      => $term_tax->description,
							'parent'           => $term_tax->parent,
							'count'            => $term_tax->count
						)
					);
				}

			}

			if($term_relationships) {

				foreach ($term_relationships as $term_relationship) {
					$wpdb->insert(
						"{$wpdb->prefix}term_relationships",
						array(
							'object_id'        => $term_relationship->object_id,
							'term_taxonomy_id' => $term_relationship->term_taxonomy_id,
							'term_order'       => $term_relationship->term_order
						)
					);
				}

			}

			if($termmeta) {

				// PRO 

			}

			$wpdb->delete( $table1, array( 'term_id' => $term_id ), array( '%d' ) );
			$wpdb->delete( $table2, array( 'term_id' => $term_id ), array( '%d' ) );
			$wpdb->delete( $table3, array( 'term_taxonomy_id' => $term_id ), array( '%d' ) );
			$wpdb->delete( $table4, array( 'term_id' => $term_id ), array( '%d' ) );

			wp_die();
			
		}
		else {
			echo 'pro';

			wp_die();
		}
	}

	public function restore_woo_term() {

		check_ajax_referer('tpmcattt_nonce', 'nonce');

		global $wpdb;

		// wp_dbug($_POST);

		$term_id = isset($_POST['term_id']) ? absint($_POST['term_id']) : 0;
	}

	public function taxonomies_trash_admin_settings_page() {
		add_submenu_page(
			'tpmcattt-admin-page',          // the slug of your custom settings page
			'Settings',                     // the title of the submenu page
			'Settings',                     // the menu title
			'manage_options',               // the required capability to access the submenu page
			'tpmcattt-admin-settings-page', // the slug of the submenu page
			array($this,'taxonomies_trash_admin_settings_page_callback') // the callback function to display the submenu page
		);
	}

	//--------------------------------------------

	public function taxonomies_trash_admin_settings_page_callback() {
		// code to display the submenu page
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/tp-move-categories-and-taxonomies-to-trash-admin-settings-display.php';
	}

	public function register_plugin_settings() {
		//register our settings
		//register_setting('tpmcattt-plugin-settings-group','xxx');
		//register_setting('tpmcattt-plugin-settings-group','xxx');
	}

	//--------------------------------------------

	public function delete_term() {

		check_ajax_referer('tpmcattt_nonce', 'nonce');

		global $wpdb;

		// wp_dbug($_POST);

		$term_id = isset($_POST['term_id']) ? absint($_POST['term_id']) : 0;
				
		$table1 = 'tpmcattt_terms';
		$table2 = 'tpmcattt_term_taxonomy';
		$table3 = 'tpmcattt_term_relationships';
		$table4 = 'tpmcattt_termmeta';

		$wpdb->delete( $table1, array( 'term_id' => $term_id ), array( '%d' ) );
		$wpdb->delete( $table2, array( 'term_id' => $term_id ), array( '%d' ) );
		$wpdb->delete( $table3, array( 'term_taxonomy_id' => $term_id ), array( '%d' ) );
		$wpdb->delete( $table4, array( 'term_id' => $term_id ), array( '%d' ) );

		wp_die();
		
	}

	public function delete_woo_term() {

		check_ajax_referer('tpmcattt_nonce', 'nonce');

		global $wpdb;

		// wp_dbug($_POST);

		$term_id = isset($_POST['term_id']) ? absint($_POST['term_id']) : 0;
		
		$table5 = 'tpmcattt_woocommerce_attribute_taxonomies';

		$wpdb->delete( $table5, array( 'attribute_id' => $term_id ), array( '%d' ) );

		wp_die();
		
	}

	//-------------------------------------------------------

	public function settings_link( $links ) {
		$settings_link = '<a href="admin.php?page=tpmcattt-admin-page">Settings</a>';
		$pro_link = '<a href="'.TPMCATTT_PLUGIN_HOME.'product/'.TPMCATTT_PLUGIN_SLUG_PRO.'" class="tpc_get_pro" target="_blank">Go Premium!</a>';
		array_push( $links, $settings_link, $pro_link );
		return $links;
	} //function tpwpg_settings_link( $links )

	public function get_pro_link( $links, $file ) {

		if ( TPMCATTT_PLUGIN_BASENAME == $file ) {
	
			$row_meta = array(
				'docs' => '<a href="' . esc_url( 'https://www.tplugins.com/demos/product/v-neck-t-shirt/' ) . '" target="_blank" aria-label="' . esc_attr__( 'Live Demo', 'wtppcs' ) . '" class="tpc_live_demo">&#128073; ' . esc_html__( 'Live Demo', 'wtppcs' ) . '</a>'
			);
	
			return array_merge( $links, $row_meta );
		}
		
		return (array) $links;
	}
	

}
