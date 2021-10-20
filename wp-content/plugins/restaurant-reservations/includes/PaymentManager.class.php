<?php
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'rtbPaymentManager' ) ) {
/**
 * This class to handle the Payment options for Restaurant Reservations
 *
 * This class sets up the payment options, register all the payment gateways and
 * acts as a bridge between Rest of the plugin and payment gateways like
 * rendering forms, processing payments, handling IPNs etc
 *
 * @since 2.3.0
 */
class rtbPaymentManager {

  /**
   * Default values for Payment manager settings
   */
  public $defaults = array();

  /**
   * Should a premium setting be disabled or not
   */
  public $premium_permissions = array();

  /**
   * All the available payment processing gateway with their internal name, 
   * display name and the PHP Class
   * 
   * @var array [
   *        'paypal' => [
   *          'name' => 'PayPal', 
   *          'instance' => 'new rtbPaymentGatewayPayPal()'
   *        ]
   *      ]
   */
  public $available_gateway_list = array();

  /**
   * List of enabled gateway list from admin
   * 
   * @var array ['paypal']
   */
  public $enabled_gateway_list = array();

  /**
   * Gateway selected for the current booking
   * @var string
   */
  public $in_use_gateway = '';

  /**
   * Booking object. ID property does not exist when no booking loaded
   * @var rtbBooking
   */
  public $booking;

  public $booking_form_field_slug = 'payment-gateway';

  /**
   * Currencies accepted for deposits
   */
  public $currency_options = array(
    'AUD' => 'Australian Dollar',
    'BRL' => 'Brazilian Real',
    'CAD' => 'Canadian Dollar',
    'CZK' => 'Czech Koruna',
    'DKK' => 'Danish Krone',
    'EUR' => 'Euro',
    'HKD' => 'Hong Kong Dollar',
    'HUF' => 'Hungarian Forint',
    'ILS' => 'Israeli New Sheqel',
    'JPY' => 'Japanese Yen',
    'MYR' => 'Malaysian Ringgit',
    'MXN' => 'Mexican Peso',
    'NOK' => 'Norwegian Krone',
    'NZD' => 'New Zealand Dollar',
    'PHP' => 'Philippine Peso',
    'PLN' => 'Polish Zloty',
    'GBP' => 'Pound Sterling',
    'RUB' => 'Russian Ruble',
    'SGD' => 'Singapore Dollar',
    'SEK' => 'Swedish Krona',
    'CHF' => 'Swiss Franc',
    'TWD' => 'Taiwan New Dollar',
    'THB' => 'Thai Baht',
    'TRY' => 'Turkish Lira',
    'USD' => 'U.S. Dollar'
  );

  /**
   * Constructor
   */
  public function __construct()
  {
    $this->load_basics();

    add_filter( 'rtb_settings_check_permissions', [$this, 'check_permissions'] );

    add_filter( 'rtb_settings_defaults', [$this, 'set_defaults'] );

    $this->currency_options = apply_filters( 'rtb_payments_currency_options', $this->currency_options );

    add_filter( 'rtb_settings_page', [$this, 'load_payment_settings'] );

    do_action( 'rtb_payment_manager_init' );
  }

  /**
   * Pre-check the permissions to enable/disable Payment Manager's settings
   * as per the current license type
   * 
   * @param  array checked permissions array from Main settings class
   * 
   * @return array checked permissions array amended with payment related permissions
   */
  public function check_permissions( $premium_permissions )
  {
    global $rtb_controller;

    $this->premium_permissions['payments'] = array();
    if ( ! $rtb_controller->permissions->check_permission('payments') ) {
      $this->premium_permissions['payments'] = array(
        'disabled'        => true,
        'disabled_image'  => 'https://www.etoilewebdesign.com/wp-content/uploads/2018/06/Logo-White-Filled40-px.png',
        'purchase_link'   => 'https://www.fivestarplugins.com/plugins/five-star-restaurant-reservations/',
        'ultimate_needed' => 'Yes'
      );
    }

    $this->premium_permissions = array_merge( $premium_permissions, $this->premium_permissions );

    return $this->premium_permissions;
  }

  /**
   * Load the Payment Manager's default values in global default values
   * 
   * @param array $defaults default values of Payment Gateway settings
   * 
   * @return array $defaults
   */
  public function set_defaults( $defaults )
  {
    $this->defaults = array(
      'rtb-paypal-email'             => get_option( 'admin_email' ),
      'rtb-stripe-mode'              => 'test',
      'rtb-currency'                 => 'USD',
      'rtb-stripe-currency-symbol'   => '$',
      'rtb-currency-symbol-location' => 'before',
      'rtb-payment-gateway'          => array()
    );

    return array_merge( $defaults, $this->defaults );
  }

  /**
   * Add Payment Manager settings in global settings page
   * 
   * @param  sapLibrary_2_2_1 $settings_page An object of Simple Admin Pages page
   * 
   * @return sapLibrary_2_2_1
   */
  public function load_payment_settings( $settings_page )
  {
    // Add Payment settings tab
    $settings_page->add_section(
      'rtb-settings',
      array(
        'id'       => 'rtb-payments-tab',
        'title'    => __( 'Payments', 'restaurant-reservations' ),
        'is_tab'   => true,
        'rank' => 5
      )
    );

    // Add settings group in Payment settings tab
    $settings_page->add_section(
      'rtb-settings',
      array_merge(
        array(
          'id'    => 'rtb-general-payment',
          'title' => __( 'General', 'restaurant-reservations' ),
          'tab'   => 'rtb-payments-tab',
        ),
        $this->premium_permissions['payments']
      )
    );

    // Add settings in General settings group
    $settings_page->add_setting(
      'rtb-settings',
      'rtb-general-payment',
      'toggle',
      array(
        'id'          => 'require-deposit',
        'title'       => __( 'Require Deposit', 'restaurant-reservations' ),
        'description' => __( 'Require guests to make a deposit when making a reservation.', 'restaurant-reservations' )
      )
    );
    $settings_page->add_setting(
      'rtb-settings',
      'rtb-general-payment',
      'checkbox',
      array(
        'id'          => 'rtb-payment-gateway',
        'title'       => __( 'Payment Gateway', 'restaurant-reservations' ),
        'description' => __( 'Which payment gateway should be used to accept deposits.', 'restaurant-reservations' ),
        'options'     => $this->get_available_gateway_list()
      )
    );
    $settings_page->add_setting(
      'rtb-settings',
      'rtb-general-payment',
      'radio',
      array(
        'id'          => 'rtb-deposit-type',
        'title'       => __( 'Deposit Type', 'restaurant-reservations' ),
        'description' => __( 'What type of deposit should be required, per reservation or per guest?', 'restaurant-reservations' ),
        'options'     => array(
          'reservation' => 'Per Reservation',
          'guest'       => 'Per Guest'
        )
      )
    );
    $settings_page->add_setting(
      'rtb-settings',
      'rtb-general-payment',
      'text',
      array(
        'id'          => 'rtb-deposit-amount',
        'title'       => __( 'Deposit Amount', 'restaurant-reservations' ),
        'description' => __( 'What deposit amount is required (either per reservation or per guest, depending on the setting above)? Minimum is $0.50 in most currencies.', 'restaurant-reservations' )
      )
    );
    $settings_page->add_setting(
      'rtb-settings',
      'rtb-general-payment',
      'select',
      array(
        'id'           => 'rtb-currency',
        'title'        => __( 'Currency', 'restaurant-reservations' ),
        'description'  => __( 'Select the currency you accept for your deposits.', 'restaurant-reservations' ),
        'blank_option' => false,
        'options'      => $this->currency_options
      )
    );

    // Add settings group in Payment settings tab
    $settings_page->add_section(
      'rtb-settings',
      array_merge(
        array(
          'id'    => 'rtb-paypal-payment',
          'title' => __( 'PayPal', 'restaurant-reservations' ),
          'tab'   => 'rtb-payments-tab',
        ),
        $this->premium_permissions['payments']
      )
    );

    // Add settings in PayPal settings group
    $settings_page->add_setting(
      'rtb-settings',
      'rtb-paypal-payment',
      'text',
      array(
        'id'            => 'rtb-paypal-email',
        'title'         => __( 'PayPal Email Address', 'restaurant-reservations' ),
        'description'   => __( 'The email address you\'ll be using to accept PayPal payments.', 'restaurant-reservations' ),
        'placeholder'   =>$this->defaults['rtb-paypal-email']
      )
    );

    // Add settings group in Payment settings tab
    $settings_page->add_section(
      'rtb-settings',
      array_merge(
        array(
          'id'    => 'rtb-stripe-payment',
          'title' => __( 'Stripe', 'restaurant-reservations' ),
          'tab'   => 'rtb-payments-tab',
        ),
        $this->premium_permissions['payments']
      )
    );

    // Add settings in Stripe settings group
    $settings_page->add_setting(
      'rtb-settings',
      'rtb-stripe-payment',
      'toggle',
      array(
        'id'          => 'rtb-stripe-sca',
        'title'       => __( 'Strong Customer Authorization (SCA)', 'restaurant-reservations' ),
        'description' => __( 'User will be redirected to Stripe and presented with 3D secure or bank redirect for payment authentication. (May be necessary for certain EU compliance.)', 'restaurant-reservations' )
      )
    );
    $settings_page->add_setting(
      'rtb-settings',
      'rtb-stripe-payment',
      'text',
      array(
        'id'            => 'rtb-stripe-currency-symbol',
        'title'         => __( 'Stripe Currency Symbol', 'restaurant-reservations' ),
        'description'   => __( 'The currency symbol you\'d like displayed before or after the required deposit amount.', 'restaurant-reservations' ),
        'placeholder'   => $this->defaults['rtb-stripe-currency-symbol']
      )
    );
    $settings_page->add_setting(
      'rtb-settings',
      'rtb-stripe-payment',
      'toggle',
      array(
        'id'          => 'rtb-expiration-field-single',
        'title'       => __( 'CC Expiration Single Field', 'restaurant-reservations' ),
        'description' => __( 'Should the field for card expiry details be a single field with a mask or two separate fields for month and year?', 'restaurant-reservations' )
      )
    );
    $settings_page->add_setting(
      'rtb-settings',
      'rtb-stripe-payment',
      'radio',
      array(
        'id'          => 'rtb-currency-symbol-location',
        'title'       => __( 'Currency Symbol Location', 'restaurant-reservations' ),
        'description' => __( 'Should the currency symbol be placed before or after the deposit amount?', 'restaurant-reservations' ),
        'options'     => array(
          'before' => 'Before',
          'after'  => 'After'
        )
      )
    );
    $settings_page->add_setting(
      'rtb-settings',
      'rtb-stripe-payment',
      'radio',
      array(
        'id'          => 'rtb-stripe-mode',
        'title'       => __( 'Test/Live Mode', 'restaurant-reservations' ),
        'description' => __( 'Should the system use test or live mode? Test mode should only be used for testing, no deposits will actually be processed while turned on.', 'restaurant-reservations' ),
        'options'     => array(
          'test' => 'Test',
          'live' => 'Live'
        )
      )
    );
    $settings_page->add_setting(
      'rtb-settings',
      'rtb-stripe-payment',
      'text',
      array(
        'id'          => 'rtb-stripe-live-secret',
        'title'       => __( 'Stripe Live Secret', 'restaurant-reservations' ),
        'description' => __( 'The live secret that you have set up for your Stripe account.', 'restaurant-reservations' )
      )
    );
    $settings_page->add_setting(
      'rtb-settings',
      'rtb-stripe-payment',
      'text',
      array(
        'id'          => 'rtb-stripe-live-publishable',
        'title'       => __( 'Stripe Live Publishable', 'restaurant-reservations' ),
        'description' => __( 'The live publishable that you have set up for your Stripe account.', 'restaurant-reservations' )
      )
    );
    $settings_page->add_setting(
      'rtb-settings',
      'rtb-stripe-payment',
      'text',
      array(
        'id'          => 'rtb-stripe-test-secret',
        'title'       => __( 'Stripe Test Secret', 'restaurant-reservations' ),
        'description' => __( 'The test secret that you have set up for your Stripe account. Only needed for testing payments.', 'restaurant-reservations' )
      )
    );
    $settings_page->add_setting(
      'rtb-settings',
      'rtb-stripe-payment',
      'text',
      array(
        'id'          => 'rtb-stripe-test-publishable',
        'title'       => __( 'Stripe Test Publishable', 'restaurant-reservations' ),
        'description' => __( 'The test publishable that you have set up for your Stripe account. Only needed for testing payments.', 'restaurant-reservations' )
      )
    );

    do_action( 'rtb_settings_payment_manager', $settings_page );

    return $settings_page;
  }

  /**
   * Acts like a constructor
   */
  public function load_basics()
  {
    global $rtb_controller;

    require_once RTB_PLUGIN_DIR . "/includes/PaymentGateway.interface.php";
    require_once RTB_PLUGIN_DIR . "/includes/PaymentGatewayPayPal.class.php";
    require_once RTB_PLUGIN_DIR . "/includes/PaymentGatewayStripe.class.php";

    do_action( 'rtb_payment_manager_load_gateways' );

    $this->available_gateway_list = apply_filters(
      'rtb-payment-gateway-register', 
      $this->available_gateway_list
    );

    $this->strip_invalid_gateway();

    $this->enabled_gateway_list = $rtb_controller->settings->get_setting( 'rtb-payment-gateway' );

    // Temporary, because migration function do not work on automatic plugin updates
    $this->enabled_gateway_list = is_array( $this->enabled_gateway_list ) 
      ? $this->enabled_gateway_list
      : [ $this->enabled_gateway_list ];

    $this->enabled_gateway_list = apply_filters(
      'rtb-payment-active-gateway', 
      $this->enabled_gateway_list, 
      $this->available_gateway_list
    );

    // if multiple gateways enabled, print list to ask for one gateway
    if ( is_array( $this->enabled_gateway_list ) and 1 < count( $this->enabled_gateway_list ) ) {
      add_filter( 'rtb_booking_form_fields', [$this, 'add_field_booking_form_gateway'], 30, 3 );
    }

    // Determine $in_use_gateway
    add_action( 'rtb_validate_booking_submission', [$this, 'validate_booking_form_gateway'] );

    // Save gateway selected/used for booking as booking meta
    add_filter( 'rtb_insert_booking_metadata', [$this, 'save_booking_gateway_used'], 30, 2 );

    // Repopulate gateway information
    add_action( 'rtb_booking_load_post_data', [$this, 'populate_booking_gateway_used'], 30, 2 );
  }

  /**
   * Get available gateway list with gateway slug as key and label as value
   * 
   * @return array 
   */
  public function get_available_gateway_list()
  {
    $list = [];

    foreach ($this->available_gateway_list as $key => $value) {
      $list[$key] = $value['label'];
    }

    return $list;
  }

  /**
   * Get enabled gateway list with gateway slug as key and label as value
   * 
   * @return array 
   */
  public function get_enabled_gateway_list()
  {
    $list = [];

    foreach ($this->enabled_gateway_list as $key) {
      $list[$key] = $this->available_gateway_list[$key]['label'];
    }

    return $list;
  }

  /**
   * Is Payments functionality enabled?
   * 
   * @return boolean
   */
  public function is_payment_enabled()
  {
    global $rtb_controller;

    return (
      $rtb_controller->settings->get_setting( 'require-deposit' ) 
      && 
      0 < count( $this->get_enabled_gateway_list() )
    );
  }

  /**
   * Add the payment gateway selector field in the bookgin form
   * 
   * @param  array $fields  Booking form field array. For more info, refer to 
   *                        rtbSettings::get_booking_form_fields()
   * @param  stdObject $request
   * @param  array $args 
   */
  public function add_field_booking_form_gateway( $fields, $request, $args )
  {
    if ( ! $this->is_payment_enabled() ) {
      return $fields;
    }

    /**
     * This is different from admin setting, that is why, to reduce the confusion
     * we use variabel instead of direct field name
     * 
     * @var string rtb-payment-gateway
     */
    $prefixed_field_slug = "rtb-{$this->booking_form_field_slug}";

    $payment_gateway_field = [
      $this->booking_form_field_slug => [
        // 'legend' => __( 'Payment', 'restaurant-reservations' ),
        'fields' => [
          // Field names are prefixed with "rtb-" while rendering field's HTML
          'payment-gateway' => [
            'required'      => true,
            'title'         => __( 'Payment Gateway', 'restaurant-reservations' ),
            'callback'      => 'rtb_print_form_select_field',
            'callback_args' => [
              'options'      => $this->get_enabled_gateway_list(),
              'empty_option' => true
            ],
            'request_input' => isset( $request->raw_input[$prefixed_field_slug] ) 
              ? $request->raw_input[$prefixed_field_slug] 
              : (
                  property_exists($request, $this->booking_form_field_slug) 
                    ? $request->{$this->booking_form_field_slug} 
                    : ''
                )
          ]
        ]
      ]
    ];

    return array_merge( $fields, $payment_gateway_field );
  }

  /**
   * Validate the payment gateway option
   * 
   * $booking is not set yet
   * 
   * @param  stdObject $request
   */
  public function validate_booking_form_gateway( $request )
  {
    if ( ! $this->is_payment_enabled() ) {
      return;
    }

    $prefixed_field_slug = "rtb-{$this->booking_form_field_slug}";

    // Do not validate if only one gateway enabled
    if ( 1 === count( $this->enabled_gateway_list ) ) {
      $this->in_use_gateway = $this->enabled_gateway_list[0];
    }
    elseif (
      array_key_exists( $prefixed_field_slug, $_POST ) 
      && 
      ! empty( $_POST[$prefixed_field_slug] ) 
      && 
      in_array( $_POST[$prefixed_field_slug], $this->enabled_gateway_list )
    )
    {
      $this->in_use_gateway = $_POST[$prefixed_field_slug];
    }
    else {
      $request->validation_errors[] = array(
        'field'   => $prefixed_field_slug,
        'message' => __( 'Please select a valid payment gateway.', 'restaurant-reservations' )
      );
    }

    if ( $this->isset_gateway_in_use() ) {
      $request->{$this->booking_form_field_slug} = $this->in_use_gateway;
    }
  }

  /**
   * Attach payment gateway information with the booking
   * 
   * @param  array $meta
   * @param  rtbBooking $booking
   * 
   * @return array
   */
  public function save_booking_gateway_used( $meta, rtbBooking $booking )
  {
    if ( isset( $booking->{$this->booking_form_field_slug} ) ) {
      $meta[$this->booking_form_field_slug] = $booking->{$this->booking_form_field_slug};
    }

    return $meta;
  }

  /**
   * Repopulate $booking with gateway information
   * 
   * @param  rtbBooking $booking
   * @param  WP_Post $wp_post
   */
  public function populate_booking_gateway_used( rtbBooking $booking, $wp_post )
  {
    if ( is_array( $meta = get_post_meta( $booking->ID, 'rtb', true ) ) ) {
      $booking->{$this->booking_form_field_slug} = isset( $meta[$this->booking_form_field_slug] )
        ? $meta[$this->booking_form_field_slug]
        : '';
    }
  }

  /**
   * Print the payment form's HTML code, after a new booking has been inserted 
   * notices.
   * 
   * $booking must be set before this.
   */
  public function print_payment_form()
  {
    global $rtb_controller;

    require_once( RTB_PLUGIN_DIR . '/includes/Booking.class.php' );

    if ( ! $this->isset_gateway_in_use() ) {
      $this->set_gateway_in_use( $this->booking->{$this->booking_form_field_slug} );
    }

    if (
      in_array( $this->in_use_gateway, $this->enabled_gateway_list )
      &&
      property_exists($this->booking, 'ID')
    )
    {
      $gateway = $this->available_gateway_list[$this->in_use_gateway]['instance'];

      $gateway->print_payment_form( $this->booking );
    }
    else {
      $this->print_invalid_gateway();
    }
  }

  public function print_invalid_gateway()
  {
    echo __(
      'Invalid gateweay selected. Please contact us for the confirmation.', 
      'restaurant-reservations'
    );
  }

  public function process_payment()
  {
    // code...
  }

  public function is_payment_processed()
  {
    // code...
  }

  public function payment_processing_status()
  {
    // code...
  }

  /**
   * Set booking object
   * 
   * @param rtbBooking $booking
   */
  public function set_booking(rtbBooking $booking)
  {
    $this->booking = $booking;

    return $this;
  }

  public function set_gateway_in_use( $gateway )
  {
    $this->in_use_gateway = $gateway;
  }

  public function get_gateway_in_use()
  {
    if ( $this->isset_gateway_in_use() ) {
      return $this->in_use_gateway;
    }

    return '';
  }

  public function isset_gateway_in_use()
  {
    return in_array( $this->in_use_gateway, $this->enabled_gateway_list );
  }

  /**
   * Remove any class registered as payment gateway without implementing the 
   * payment gateway interface
   */
  public function strip_invalid_gateway()
  {
    $new_list = [];

    foreach ( $this->available_gateway_list as $gateway => $data ) {
      if ( $data['instance'] instanceof rtbPaymentGateway ) {
        $new_list[$gateway] = $data;
      }
    }

    $this->available_gateway_list = $new_list;
  }
}

}