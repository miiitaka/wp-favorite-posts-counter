<?php
/*
Plugin Name: WordPress Favorite Posts Counter
Plugin URI: https://github.com/miiitaka/wp-favorite-posts-counter
Description: This plug-in adds a favorite flag to posts. It is a function to record favorite registration on a cookie and to count the number for each post.
Version: 1.0.0
Author: Kazuya Takami
Author URI: https://www.terakoya.work/
License: GPLv2 or later
Text Domain: wp-favorite-posts-counter
Domain Path: /languages
*/
require_once( plugin_dir_path( __FILE__ ) . 'includes/wp-favorite-posts-counter-admin-db.php' );

new Favorite_Posts_Counter();

/**
 * Basic Class
 *
 * @author  Kazuya Takami
 * @version 1.0.0
 * @since   1.0.0
 */
class Favorite_Posts_Counter {

	/**
	 * Variable definition.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	private $text_domain = 'wp-favorite-posts-counter';

	/**
	 * Variable definition.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	private $version = '1.0.0';

	/**
	 * Constructor Define.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function __construct () {
		add_shortcode( 'wp-favorite-button',  array( $this, 'short_code_init_button' ) );
		add_shortcode( 'wp-favorite-counter', array( $this, 'short_code_init_counter' ) );
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );

		if ( is_admin() ) {
			add_action( 'admin_init', array( $this, 'admin_init' ) );
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'plugin_action_links' ) );
		} else {
			add_action( 'get_header', array( $this, 'get_header' ) );
		}
	}

	/**
	 * i18n.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function plugins_loaded () {
		//load_plugin_textdomain( $this->text_domain, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	/**
	 * ShortCode Register(Button).
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @param   array  $args short code params
	 * @return  string
	 */
	public function short_code_init_button ( $args ) {
		require_once( plugin_dir_path( __FILE__ ) . 'includes/wp-favorite-posts-counter-admin-short-code.php' );
		$obj = new Favorite_Posts_Counter_ShortCode();
		return $obj->short_code_display_button( $args );
	}

	/**
	 * ShortCode Register(Counter).
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @param   array  $args short code params
	 * @return  string
	 */
	public function short_code_init_counter ( $args ) {
		require_once( plugin_dir_path( __FILE__ ) . 'includes/wp-favorite-posts-counter-admin-short-code.php' );
		$obj = new Favorite_Posts_Counter_ShortCode();
		return $obj->short_code_display_counter( $args );
	}

	/**
	 * admin init.
	 *
	 * @version 1.2.2
	 * @since   1.0.0
	 */
	public function admin_init () {
		wp_register_style( 'wp-favorite-posts-counter-admin-style', plugins_url( 'css/style.css', __FILE__ ), array(), $this->version );
	}

	/**
	 * Add Menu to the Admin Screen.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function admin_menu () {
		add_menu_page(
			esc_html__( 'Favorite Posts Settings', $this->text_domain ),
			esc_html__( 'Favorite Posts Settings', $this->text_domain ),
			'manage_options',
			plugin_basename( __FILE__ ),
			array( $this, 'setting_page_render' )
		);
		$setting_page = add_submenu_page(
			__FILE__,
			esc_html__( 'All Settings', $this->text_domain ),
			esc_html__( 'All Settings', $this->text_domain ),
			'manage_options',
			plugin_basename( __FILE__ ),
			array( $this, 'setting_page_render' )
		);
		add_action( 'admin_print_styles-' . $setting_page, array( $this, 'add_style' ) );
	}

	/**
	 * Add Menu to the Admin Screen.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @param   array  $links
	 * @return  array  $links
	 */
	public function plugin_action_links( $links ) {
		$url = admin_url( 'admin.php?page=' . $this->text_domain . '/' . $this->text_domain . '.php' );
		$url = '<a href="' . esc_url( $url ) . '">' . __( 'Settings' ) . '</a>';
		array_unshift( $links, $url );
		return $links;
	}

	/**
	 * CSS admin add.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function add_style () {
		wp_enqueue_style( 'wp-favorite-posts-counter-admin-style' );
	}

	/**
	 * Admin Setting Page Template Require.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function setting_page_render () {
		require_once( plugin_dir_path( __FILE__ ) . 'includes/wp-favorite-posts-counter-admin-setting.php' );
		new Favorite_Posts_Counter_Admin_Setting( $this->text_domain );
	}

	/**
	 * Set Cookie.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function get_header () {
		global $post;

		$cookie_name = $this->text_domain;
		$args = array();

		if ( $post->post_status === 'publish' ) {

			/** Cookie data read and convert string from array. */
			if ( isset( $_COOKIE[$cookie_name] ) ) {
				$args = explode( ',', esc_html( $_COOKIE[$cookie_name] ) );
			}

			/** Existence check. */
			$position = array_search( $post->ID, $args );
			if ( is_numeric( $position ) ) {
				unset( $args[$position] );
			}

			/** Cookie data add and Array reverse. */
			$args[] = ( string ) $post->ID;

			if ( count( $args ) > $row->save_item ) {
				array_shift( $args );
			}

			setcookie( $cookie_name, implode( ',', $args ), time() + 86400 * $row->save_term, '/', $_SERVER['SERVER_NAME'] );
		}
	}
}