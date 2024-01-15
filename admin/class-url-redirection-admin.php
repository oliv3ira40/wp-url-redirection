<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://#
 * @since      1.0.0
 *
 * @package    Url_Redirection
 * @subpackage Url_Redirection/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Url_Redirection
 * @subpackage Url_Redirection/admin
 * @author     Coopersystem <augusto.oliveira@coopersystem.com.br>
 */
class Url_Redirection_Admin {

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
		// if (is_admin_url_direction()) {
		// 	wp_enqueue_style( 'plugin-'.$this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/css/main-admin.css', array(), $this->version, 'all' );
		// }
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		if (is_admin_url_direction()) {
			wp_enqueue_script('helpers-forms', plugin_dir_url( __FILE__ ) . 'assets/js/helpers.js',
				['jquery'], false, true);

			wp_enqueue_script('plugin-'.$this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/js/main-admin.js',
				['jquery', 'helpers-forms'], false, true);
			wp_localize_script('plugin-'.$this->plugin_name, 'url_directions', array(
				'url_ajax' => admin_url('admin-ajax.php'),
			));
		}
	}

}
