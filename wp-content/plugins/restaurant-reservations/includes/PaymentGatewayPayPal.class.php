<?php
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'rtbPaymentGatewayPayPal' ) ) {
/**
 * This class is responsible for payment processing via Paypal
 * 
 * @since 2.3.0
 */
class rtbPaymentGatewayPayPal implements rtbPaymentGateway {

  private static $_instance;

  private final function __construct() {

    $this->register_hooks();

  }

  public static function register_gateway (array $gateway_list )
  {
    return array_merge(
      $gateway_list,
      [
        'paypal' => [
          'label'    => __( 'PayPal', 'restaurant-reservations' ),
          'instance' => self::get_instance()
        ]
      ]
    );
  }

  /**
   * Get singleton instance of the class
   * 
   * @return rtbPaymentGatewayPayPal instance
   */
  public static function get_instance()
  {
    if( ! isset( self::$_instance ) ) {
      self::$_instance = new rtbPaymentGatewayPayPal();
    }
    
    return self::$_instance;
  }

  public function register_hooks() {
    // If there's an IPN request, add our setup function to potentially handle it
    if ( isset($_POST['ipn_track_id']) ) {
      add_action( 'init', [$this, 'handle_ipn'], 11 );

      // add an output buffer layer for the plugin
      add_action( 'init', [$this, 'ob_start'] );
      add_action( 'shutdown', [$this, 'flush_ob_end'] );
    }
  }

  public function print_payment_form( $booking )
  {
    global $rtb_controller;

    // Define the form's action parameter
    $booking_page = $rtb_controller->settings->get_setting( 'booking-page' );
    if ( !empty( $booking_page ) ) {
      $booking_page = get_permalink( $booking_page );
    }

    $item_name = substr(get_bloginfo('name'), 0, 100) . 'Reservation Deposit';
    $amount = $booking->calculate_deposit();
    $business = $rtb_controller->settings->get_setting( 'rtb-paypal-email' );
    $currency = $rtb_controller->settings->get_setting( 'rtb-currency' );
    $notify_url = get_site_url();

    echo "
      <form action='https://www.paypal.com/cgi-bin/webscr' method='post' class='standard-form'>
        <input type='hidden' name='item_name_1' value='{$item_name}' />
        <input type='hidden' name='custom' value='booking_id={$booking->ID}' />
        <input type='hidden' name='quantity_1' value='1' />
        <input type='hidden' name='amount_1' value='{$amount}' />
        <input type='hidden' name='cmd' value='_cart' />
        <input type='hidden' name='upload' value='1' />
        <input type='hidden' name='business' value='{$business}' />
        <input type='hidden' name='currency_code' value='{$currency}' />
        <input type='hidden' name='return' value='{$booking_page}' />
        <input type='hidden' name='notify_url' value='{$notify_url}' />
        <input type='submit' class='submit-button' value='Pay via PayPal' />
      </form>
    ";
  }

  /**
   * Handle PayPal IPN requests
   * 
   * @since 2.1.0
   */
  public function handle_ipn()
  {
    global $rtb_controller;

    if ( ! $rtb_controller->settings->get_setting( 'require-deposit' ) ) {
      return;
    }

    // CONFIG: Enable debug mode. This means we'll log requests into 'ipn.log' in the same directory.
    // Especially useful if you encounter network errors or other intermittent problems with IPN (validation).
    // Set this to 0 once you go live or don't require logging.
    $debug = get_option( 'rtb_enable_payment_debugging' );

    // Set to 0 once you're ready to go live
    define("RTB_USE_SANDBOX", 0);
    define("RTB_LOG_FILE", "ipn.log");

    // Read POST data
    // reading posted data directly from $_POST causes serialization
    // issues with array data in POST. Reading raw POST data from input stream instead.
    $raw_post_data = file_get_contents('php://input');
    $raw_post_array = explode('&', $raw_post_data);
    $myPost = array();
    foreach ($raw_post_array as $keyval) {
      $keyval = explode ('=', $keyval);
      if (count($keyval) == 2)
        $myPost[$keyval[0]] = urldecode($keyval[1]);
    }

    // read the post from PayPal system and add 'cmd'
    $req = 'cmd=_notify-validate';
    if(function_exists('get_magic_quotes_gpc')) {
      $get_magic_quotes_exists = true;
    }

    foreach ($myPost as $key => $value) {
      if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
        $value = urlencode(stripslashes($value));
      } else {
        $value = urlencode($value);
      }
      $req .= "&$key=$value";
    }

    // Post IPN data back to PayPal to validate the IPN data is genuine
    // Without this step anyone can fake IPN data
    if(RTB_USE_SANDBOX == true) {
      $paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
    } else {
      $paypal_url = "https://www.paypal.com/cgi-bin/webscr";
    }

    $response = wp_remote_post($paypal_url, array(
      'method' => 'POST',
      'body' => $req,
      'timeout' => 30
    ));
    
    // Inspect IPN validation result and act accordingly
    // Split response headers and payload, a better way for strcmp
    $tokens = explode("\r\n\r\n", trim($response['body'])); 
    $res = trim(end($tokens));

    if ( $debug ) {
      update_option( 'rtb_debugging', get_option( 'rtb_debugging' ) . print_r( date('[Y-m-d H:i e] '). "IPN response: $res - $req ". PHP_EOL, true ) );
    }

    if (strcmp ($res, "VERIFIED") == 0) {
        
      $paypal_receipt_number = $_POST['txn_id'];
      $payment_amount = $_POST['mc_gross'];
      
      parse_str($_POST['custom'], $custom_vars);
      $booking_id = intval( $custom_vars['booking_id'] );

      require_once( RTB_PLUGIN_DIR . '/includes/Booking.class.php' );
      
      $booking = new rtbBooking();
      $booking->load_post( $booking_id );

      if ( ! $booking ) { return; }
        
      $booking->deposit = sanitize_text_field( $payment_amount );
      $booking->receipt_id = sanitize_text_field( $paypal_receipt_number );

      $booking->payment_paid();
    }
  }

  /**
   * Opens a buffer when handling PayPal IPN requests
   * 
   * @since 2.1.0
   */
  public function ob_start()
  {
    ob_start();
  }

  /**
   * Closes a buffer when handling PayPal IPN requests
   * 
   * @since 2.1.0
   */
  public function flush_ob_end()
  {
    if ( ob_get_length() ) {
      ob_end_clean();
    }
  }
}

}

/**
 * Gateway has to register itself
 */
add_filter(
  'rtb-payment-gateway-register', 
  ['rtbPaymentGatewayPayPal', 'register_gateway']
);