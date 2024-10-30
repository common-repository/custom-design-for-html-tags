<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://ddzap.com/about
 * @since      1.0.0
 *
 * @package    Ddzap_Custom_Html_Tags
 * @subpackage Ddzap_Custom_Html_Tags/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ddzap_Custom_Html_Tags
 * @subpackage Ddzap_Custom_Html_Tags/admin
 * @author     DDZAP <support@ddzap.com>
 */
class Ddzap_Custom_Html_Tags_Admin {

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
	 * Plugin Options
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array $options
	 */
	private $options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    string    $plugin_name       The name of this plugin.
	 * @param    string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		foreach ( [ 'checkbox', 'radio' ] as $tag ) {
			$this->options[ $tag ] = Ddzap_Custom_Html_Tags_Admin::get_option( $tag );
		}

	}

	/**
	 * Add Setting Link on Plugins page
	 *
	 * @since    1.0.1
	 */
	public function plugin_action_links( $links ) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ddzap_Custom_Html_Tags_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ddzap_Custom_Html_Tags_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		return array_merge( array(
			'<a href="' . esc_url( admin_url( '/themes.php?page=ddzap-custom-html-tags-admin-menu' ) ) . '">' . __( 'Settings', DDZAP_TEXT_DOMAIN ) . '</a>'
		), $links );

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ddzap_Custom_Html_Tags_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ddzap_Custom_Html_Tags_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'bootstrap-grid', plugin_dir_url( __FILE__ ) . 'css/bootstrap-grid.min.css', array(), '4.3.1', 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ddzap-custom-html-tags-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ddzap_Custom_Html_Tags_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ddzap_Custom_Html_Tags_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ddzap-custom-html-tags-admin.js', array( 'jquery', 'wp-color-picker' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'wc', ['active' => $this->options[ 'radio' ][ "ddzap-setting-form-radio-woocommerce-support" ] === 'on']);

	}

	/**
	 * Add Admin Menu.
	 *
	 * @since    1.0.0
	 */
	public function admin_menu() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ddzap_Custom_Html_Tags_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ddzap_Custom_Html_Tags_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		add_submenu_page( 'themes.php', 'Custom HTML Tags', 'Custom HTML Tags', 'manage_options', 'ddzap-custom-html-tags-admin-menu', array( $this, 'admin_display' ) );

	}

	/**
	 * Register Admin Menu Callback.
	 *
	 * @since    1.0.0
	 */
	public function admin_display() {
		require_once plugin_dir_path( __FILE__ ) . 'partials/ddzap-custom-html-tags-admin-display.php';
	}

	/**
	 * @param string $tag
	 *
	 * @return array
	 */
	private function get_defaults_options( $tag = 'checkbox' ) {
		$defaults = [
			'checkbox' => [
				'ddzap-setting-form-checkbox-enable'                    => 'off',
				'ddzap-setting-form-checkbox-woocommerce-support'       => 'off',
				'ddzap-setting-form-checkbox-contact-form-7-support'    => 'off',
				'ddzap-setting-form-checkbox-wpforms-support'           => 'off',
				'ddzap-setting-form-checkbox-text-offset'               => 5,
				'ddzap-setting-form-checkbox-width'                     => 20,
				'ddzap-setting-form-checkbox-height'                    => 20,
				'ddzap-setting-form-checkbox-offset-top'                => 5,
				'ddzap-setting-form-checkbox-offset-left'               => 0,
				'ddzap-setting-form-checkbox-border-width'              => 1,
				'ddzap-setting-form-checkbox-border-radius'             => 0,
				'ddzap-setting-form-checkbox-border-color'              => '#000000',
				'ddzap-setting-form-checkbox-flag-width'                => 10,
				'ddzap-setting-form-checkbox-flag-height'               => 10,
				'ddzap-setting-form-checkbox-flag-border-radius'        => 0,
				'ddzap-setting-form-checkbox-flag-color'                => '#000000',
                'ddzap-setting-form-checkbox-exclude-classes'           => '',
				'ddzap-setting-form-checkbox-css'                       => '',
				'ddzap-setting-form-checkbox-js'                        => '',
			],
			'radio' => [
				'ddzap-setting-form-radio-enable'                       => 'off',
				'ddzap-setting-form-radio-woocommerce-support'          => 'off',
				'ddzap-setting-form-radio-contact-form-7-support'       => 'off',
				'ddzap-setting-form-radio-wpforms-support'              => 'off',
				'ddzap-setting-form-radio-text-offset'                  => 5,
				'ddzap-setting-form-radio-width'                        => 20,
				'ddzap-setting-form-radio-height'                       => 20,
				'ddzap-setting-form-radio-offset-top'                   => 5,
				'ddzap-setting-form-radio-offset-left'                  => 0,
				'ddzap-setting-form-radio-border-width'                 => 1,
				'ddzap-setting-form-radio-border-radius'                => 10,
				'ddzap-setting-form-radio-border-color'                 => '#000000',
				'ddzap-setting-form-radio-flag-width'                   => 10,
				'ddzap-setting-form-radio-flag-height'                  => 10,
				'ddzap-setting-form-radio-flag-border-radius'           => 5,
				'ddzap-setting-form-radio-flag-color'                   => '#000000',
                'ddzap-setting-form-radio-exclude-classes'              => '',
				'ddzap-setting-form-radio-css'                          => '',
				'ddzap-setting-form-radio-js'                           => '',
			]
		];

		return $defaults[$tag];
	}

	/**
	 * Update Option
	 *
	 * @param string $tag
	 *
	 * @since    1.0.0
	 */
	public static function update_option( $tag = 'checkbox' ) {

		if ( is_array( $_POST ) && !empty( $_POST ) ) {

			$options = wp_parse_args( $_POST, self::get_defaults_options($tag) );

			update_option( "ddzap-custom-html-tags-options-$tag", $options );
		}
	}

	/**
	 * Get Option
	 *
	 * @param string $tag
	 *
	 * @return array
	 * @since    1.0.0
	 */
	public static function get_option( $tag = 'checkbox' ) {
		return wp_parse_args(get_option("ddzap-custom-html-tags-options-$tag"), self::get_defaults_options($tag) );
	}

}
