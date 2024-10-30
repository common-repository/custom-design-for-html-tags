<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://ddzap.com/about
 * @since      1.0.0
 *
 * @package    Ddzap_Custom_Html_Tags
 * @subpackage Ddzap_Custom_Html_Tags/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ddzap_Custom_Html_Tags
 * @subpackage Ddzap_Custom_Html_Tags/public
 * @author     DDZAP <support@ddzap.com>
 */
class Ddzap_Custom_Html_Tags_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
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
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		foreach ( [ 'checkbox', 'radio' ] as $tag ) {
			$this->options[ $tag ] = Ddzap_Custom_Html_Tags_Admin::get_option( $tag );
		}

		add_filter( 'wc_get_template', [ $this, 'wc_get_template' ], 10, 5 );

		add_action( 'wpcf7_init', [ $this, 'wpcf7_add_form_tag_checkbox' ], 10, 10 );

	}

	/**
	 * Add Form Tag Checkbox
	 */
	public function wpcf7_add_form_tag_checkbox() {
		wpcf7_add_form_tag( array( 'checkbox', 'checkbox*', 'radio' ), [
				$this,
				'wpcf7_checkbox_form_tag_handler'
			], array(
				'name-attr'                   => true,
				'selectable-values'           => true,
				'multiple-controls-container' => true,
			) );
	}

	/**
	 * Checkbox Form Tag Handler
	 *
	 * @param $tag
	 *
	 * @return string
	 */
	public function wpcf7_checkbox_form_tag_handler( $tag ) {

		if ( empty( $tag->name ) ) {
			return '';
		}

		$validation_error = wpcf7_get_validation_error( $tag->name );

		$class = wpcf7_form_controls_class( $tag->type );

		if ( $validation_error ) {
			$class .= ' wpcf7-not-valid';
		}

		$label_first       = $tag->has_option( 'label_first' );
		$use_label_element = $tag->has_option( 'use_label_element' );
		$exclusive         = $tag->has_option( 'exclusive' );
		$free_text         = $tag->has_option( 'free_text' );
		$multiple          = false;

		if ( 'checkbox' == $tag->basetype ) {
			$multiple = ! $exclusive;
		} else { // radio
			$exclusive = false;
		}

		if ( $exclusive ) {
			$class .= ' wpcf7-exclusive-checkbox';
		}

		$atts = array();

		$atts[ 'class' ] = $tag->get_class_option( $class );
		$atts[ 'id' ]    = $tag->get_id_option();

		$tabindex = $tag->get_option( 'tabindex', 'signed_int', true );

		if ( false !== $tabindex ) {
			$tabindex = (int) $tabindex;
		}

		$html  = '';
		$count = 0;

		if ( $data = (array) $tag->get_data_option() ) {
			if ( $free_text ) {
				$tag->values = array_merge( array_slice( $tag->values, 0, - 1 ), array_values( $data ), array_slice( $tag->values, - 1 ) );
				$tag->labels = array_merge( array_slice( $tag->labels, 0, - 1 ), array_values( $data ), array_slice( $tag->labels, - 1 ) );
			} else {
				$tag->values = array_merge( $tag->values, array_values( $data ) );
				$tag->labels = array_merge( $tag->labels, array_values( $data ) );
			}
		}

		$values = $tag->values;
		$labels = $tag->labels;

		$default_choice = $tag->get_default_option( null, array(
			'multiple' => $multiple,
		) );

		$hangover = wpcf7_get_hangover( $tag->name, $multiple ? array() : '' );

		foreach ( $values as $key => $value ) {
			if ( $hangover ) {
				$checked = in_array( $value, (array) $hangover, true );
			} else {
				$checked = in_array( $value, (array) $default_choice, true );
			}

			if ( isset( $labels[ $key ] ) ) {
				$label = $labels[ $key ];
			} else {
				$label = $value;
			}

			$item_atts = array(
				'type'     => $tag->basetype,
				'name'     => $tag->name . ( $multiple ? '[]' : '' ),
				'value'    => $value,
				'checked'  => $checked ? 'checked' : '',
				'tabindex' => false !== $tabindex ? $tabindex : '',
			);

			$item_atts = wpcf7_format_atts( $item_atts );

			if ( $this->options[ $tag->basetype ][ "ddzap-setting-form-{$tag->basetype}-contact-form-7-support" ] === 'on' ) {

				if ( $label_first ) { // put label first, input last
					$item = sprintf( '<span class="wpcf7-list-item-label">%1$s</span><span class="ddzap-input-%3$s-container"><input %2$s /><span class="ddzap-input-%3$s"></span></span>', esc_html( $label ), $item_atts, $tag->basetype );
				} else {
					$item = sprintf( '<span class="ddzap-input-%3$s-container"><input %2$s /><span class="ddzap-input-%3$s"></span></span><span class="wpcf7-list-item-label">%1$s</span>', esc_html( $label ), $item_atts, $tag->basetype );
				}

				$item = '<label>' . $item . '</label>';

			} else {

				if ( $label_first ) { // put label first, input last
					$item = sprintf( '<span class="wpcf7-list-item-label">%1$s</span><input %2$s />', esc_html( $label ), $item_atts );
				} else {
					$item = sprintf( '<input %2$s /><span class="wpcf7-list-item-label">%1$s</span>', esc_html( $label ), $item_atts );
				}

				if ( $use_label_element ) {
					$item = '<label>' . $item . '</label>';
				}
			}


			if ( false !== $tabindex and 0 < $tabindex ) {
				$tabindex += 1;
			}

			$class = 'wpcf7-list-item';
			$count += 1;

			if ( 1 == $count ) {
				$class .= ' first';
			}

			if ( count( $values ) == $count ) { // last round
				$class .= ' last';

				if ( $free_text ) {
					$free_text_name = sprintf( '_wpcf7_%1$s_free_text_%2$s', $tag->basetype, $tag->name );

					$free_text_atts = array(
						'name'     => $free_text_name,
						'class'    => 'wpcf7-free-text',
						'tabindex' => false !== $tabindex ? $tabindex : '',
					);

					if ( wpcf7_is_posted() and isset( $_POST[ $free_text_name ] ) ) {
						$free_text_atts[ 'value' ] = wp_unslash( $_POST[ $free_text_name ] );
					}

					$free_text_atts = wpcf7_format_atts( $free_text_atts );

					$item .= sprintf( ' <input type="text" %s />', $free_text_atts );

					$class .= ' has-free-text';
				}
			}

			$item = '<span class="' . esc_attr( $class ) . '">' . $item . '</span>';
			$html .= $item;
		}

		$atts = wpcf7_format_atts( $atts );

		$html = sprintf( '<span class="wpcf7-form-control-wrap %1$s"><span %2$s>%3$s</span>%4$s</span>', sanitize_html_class( $tag->name ), $atts, $html, $validation_error );

		return $html;
	}

	/**
	 * Rewrite templates
	 *
	 * @param $template
	 * @param $template_name
	 * @param $args
	 * @param $template_path
	 * @param $default_path
	 *
	 * @return string
	 */
	public function wc_get_template( $template, $template_name, $args, $template_path, $default_path ) {
		if ( $this->options[ 'radio' ][ "ddzap-setting-form-radio-woocommerce-support" ] === 'on' && $template_name === 'checkout/payment-method.php' ) {
			$template = __DIR__ . '/templates/woocommerce/checkout/payment-method.php';
		}
		if ( $this->options[ 'radio' ][ "ddzap-setting-form-radio-woocommerce-support" ] === 'on' && $template_name === 'cart/cart-shipping.php' ) {
			$template = __DIR__ . '/templates/woocommerce/cart/cart-shipping.php';
		}
		if ( $this->options[ 'radio' ][ "ddzap-setting-form-radio-woocommerce-support" ] === 'on' && $template_name === 'myaccount/form-add-payment-method.php' ) {
			$template = __DIR__ . '/templates/woocommerce/myaccount/form-add-payment-method.php';
		}
		if ( $this->options[ 'checkbox' ][ "ddzap-setting-form-checkbox-woocommerce-support" ] === 'on' && $template_name === 'checkout/form-shipping.php' ) {
			$template = __DIR__ . '/templates/woocommerce/checkout/form-shipping.php';
		}
		if ( $this->options[ 'checkbox' ][ "ddzap-setting-form-checkbox-woocommerce-support" ] === 'on' && $template_name === 'checkout/form-billing.php' ) {
			$template = __DIR__ . '/templates/woocommerce/checkout/form-billing.php';
		}
		if ( $this->options[ 'checkbox' ][ "ddzap-setting-form-checkbox-woocommerce-support" ] === 'on' && $template_name === 'global/form-login.php' ) {
			$template = __DIR__ . '/templates/woocommerce/global/form-login.php';
		}
		if ( $this->options[ 'checkbox' ][ "ddzap-setting-form-checkbox-woocommerce-support" ] === 'on' && $template_name === 'myaccount/form-login.php' ) {
			$template = __DIR__ . '/templates/woocommerce/myaccount/form-login.php';
		}

		return $template;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		/**
		 * if preview page
		 */
		if ( isset( $_GET[ 'ddzap-preview' ] ) && sanitize_key( $_GET[ 'ddzap-preview' ] ) ) {

			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ddzap-custom-html-tags-public.css', array(), $this->version, 'all' );

		} else {

			foreach ( [ 'checkbox', 'radio' ] as $tag ) {

				$settings = $this->options[ $tag ];

				if ( $settings[ "ddzap-setting-form-$tag-enable" ] == 'on' && ! empty( $settings[ "ddzap-setting-form-$tag-css" ] ) ) {
					$handle = "{$this->plugin_name}-{$tag}-style";
					wp_register_style( $handle, false );
					wp_enqueue_style( $handle );
					wp_add_inline_style( $handle, stripslashes( $settings[ "ddzap-setting-form-$tag-css" ] ) );
				}

				if ( $settings[ "ddzap-setting-form-$tag-enable" ] == 'on' && ! empty( $settings[ "ddzap-setting-form-$tag-js" ] ) ) {
					$handle = "{$this->plugin_name}-{$tag}-script";
					wp_register_script( $handle, false, [], false, true );
					wp_enqueue_script( $handle );
					wp_add_inline_script( $handle, stripslashes( $settings[ "ddzap-setting-form-$tag-js" ] ) );
				}

			}

		}

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		if ( isset( $_GET[ 'ddzap-preview' ] ) && sanitize_key( $_GET[ 'ddzap-preview' ] ) ) {

			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ddzap-custom-html-tags-public.js', array( 'jquery' ), $this->version, true );

		}

	}

}
