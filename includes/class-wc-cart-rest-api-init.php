<?php
/**
 * Cart REST API for WooCommerce
 *
 * Handles cart endpoints requests for WC-API.
 *
 * @author   Sébastien Dumont
 * @category API
 * @package  Cart REST API for WooCommerce/API
 * @since    1.0.0
 * @version  1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Cart REST API class.
 */
class WC_Cart_Rest_API {

  protected static $_instance = null;

  protected $controller;

  /**
	 * Setup class.
	 *
	 * @access public
	 */
	public function __construct() {
		// WC Cart REST API.
		$this->cart_rest_api_init();
	} // END __construct()

  public static function instance() {
    if ( is_null( self::$_instance ) ) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }

	/**
	 * Init WC Cart REST API.
	 *
	 * @access  private
	 * @since   1.0.0
	 * @version 1.0.3
	 */
	private function cart_rest_api_init() {
		// REST API was included starting WordPress 4.4.
		if ( ! class_exists( 'WP_REST_Server' ) ) {
			return;
		}

		$this->include_cart_controller();

		// Init Cart REST API route.
		add_action( 'rest_api_init', array( $this, 'register_cart_routes' ), 0 );
	} // cart_rest_api_init()

	/**
	 * Include Cart REST API controller.
	 *
	 * @access private
	 * @since  1.0.0
	 */
	private function include_cart_controller() {
		// REST API v2 controller.
		include_once( dirname( __FILE__ ) . '/api/class-wc-rest-cart-controller.php' );
    $this->controller = new WC_REST_Cart_Controller();
	} // include()

	/**
	 * Register Cart REST API routes.
	 *
	 * @access public
	 * @since  1.0.0
	 */
	public function register_cart_routes() {

		$this->controller->register_routes();
	} // END register_cart_route

  public function get_controller() {
	  return $this->controller;
  }

} // END class

return new WC_Cart_Rest_API();
