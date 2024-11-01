<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.tplugins.com/shop
 * @since      1.0.0
 *
 * @package    Tp_Move_Categories_And_Taxonomies_To_Trash
 * @subpackage Tp_Move_Categories_And_Taxonomies_To_Trash/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Tp_Move_Categories_And_Taxonomies_To_Trash
 * @subpackage Tp_Move_Categories_And_Taxonomies_To_Trash/includes
 * @author     TP Plugins <pluginstp@gmail.com>
 */
class Tp_Move_Categories_And_Taxonomies_To_Trash_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		self::tpmcattt_terms();
		self::tpmcattt_termmeta();
		self::tpmcattt_term_relationships();
		self::tpmcattt_term_taxonomy();
		self::tpmcattt_woocommerce_attribute_taxonomies();
		  
	}

	public static function tpmcattt_terms() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name = 'tpmcattt_terms';
		$query = $wpdb->prepare("SHOW TABLES LIKE %s", $table_name);
		if( $wpdb->get_var($query) != $table_name ) {

			$sql = "CREATE TABLE $table_name (
				id bigint(20) NOT NULL AUTO_INCREMENT,
				term_id bigint(20) NOT NULL,
				name varchar(200) NOT NULL,
				slug varchar(200) NOT NULL,
				term_group bigint(20) NOT NULL,
				term_status varchar(200) NOT NULL,
				PRIMARY KEY  (id)
			) $charset_collate;";
		
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}
	}

	public static function tpmcattt_termmeta() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name = 'tpmcattt_termmeta';
		$query = $wpdb->prepare("SHOW TABLES LIKE %s", $table_name);
		if( $wpdb->get_var($query) != $table_name ) {

			$sql = "CREATE TABLE $table_name (
				id bigint(20) NOT NULL AUTO_INCREMENT,
				meta_id bigint(20) NOT NULL,
				term_id bigint(20) NOT NULL,
				meta_key varchar(255),
				meta_value longtext,
				PRIMARY KEY  (id)
			) $charset_collate;";
		
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}
	}

	public static function tpmcattt_term_relationships() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name = 'tpmcattt_term_relationships';
		$query = $wpdb->prepare("SHOW TABLES LIKE %s", $table_name);
		if( $wpdb->get_var($query) != $table_name ) {

			$sql = "CREATE TABLE $table_name (
				id bigint(20) NOT NULL AUTO_INCREMENT,
				object_id bigint(20) NOT NULL,
				term_taxonomy_id bigint(20) NOT NULL,
				term_order int(11) NOT NULL,
				PRIMARY KEY  (id)
			) $charset_collate;";
		
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}
	}

	public static function tpmcattt_term_taxonomy() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name = 'tpmcattt_term_taxonomy';
		$query = $wpdb->prepare("SHOW TABLES LIKE %s", $table_name);
		if( $wpdb->get_var($query) != $table_name ) {

			$sql = "CREATE TABLE $table_name (
				id bigint(20) NOT NULL AUTO_INCREMENT,
				term_taxonomy_id bigint(20) NOT NULL,
				term_id bigint(20) NOT NULL,
				taxonomy varchar(32),
				description longtext,
				parent bigint(20) NOT NULL,
				count bigint(20) NOT NULL,
				PRIMARY KEY  (id)
			) $charset_collate;";
		
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}
	}

	//tp_woocommerce_attribute_taxonomies
	public static function tpmcattt_woocommerce_attribute_taxonomies() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name = 'tpmcattt_woocommerce_attribute_taxonomies';
		$query = $wpdb->prepare("SHOW TABLES LIKE %s", $table_name);
		if( $wpdb->get_var($query) != $table_name ) {

			$sql = "CREATE TABLE $table_name (
				id bigint(20) NOT NULL AUTO_INCREMENT,
				attribute_id bigint(20) NOT NULL,
				attribute_name varchar(200) NOT NULL,
				attribute_label varchar(200),
				attribute_type varchar(20) NOT NULL,
				attribute_orderby varchar(20) NOT NULL,
				attribute_public int(1),
				PRIMARY KEY  (id)
			) $charset_collate;";
		
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}
	}

}
