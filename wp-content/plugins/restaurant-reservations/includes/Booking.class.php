<?php
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'rtbBooking' ) ) {
/**
 * Class to handle a booking for Restaurant Table Bookings
 *
 * @since 0.0.1
 */
class rtbBooking {

	/**
	 * Whether or not this request has been processed. Used to prevent
	 * duplicate forms on one page from processing a booking form more than
	 * once.
	 * @since 0.0.1
	 */
	public $request_processed = false;

	/**
	 * Whether or not this request was successfully saved to the database.
	 * @since 0.0.1
	 */
	public $request_inserted = false;

	/**
	 * Raw input, clone of $_POST
	 * @var array
	 * @since 2.3.0
	 */
	public $raw_input = array();

	public function __construct() {}

	/**
	 * Load the booking information from a WP_Post object or an ID
	 *
	 * @uses load_wp_post()
	 * @since 0.0.1
	 */
	public function load_post( $post ) {

		if ( is_int( $post ) || is_string( $post ) ) {
			$post = get_post( $post );
		}

		if ( get_class( $post ) == 'WP_Post' && $post->post_type == RTB_BOOKING_POST_TYPE ) {
			$this->load_wp_post( $post );
			return true;
		} else {
			return false;
		}

	}

	/**
	 * Load data from WP post object and retrieve metadata
	 *
	 * @uses load_post_metadata()
	 * @since 0.0.1
	 */
	public function load_wp_post( $post ) {

		// Store post for access to other data if needed by extensions
		$this->post = $post;

		$this->ID = $post->ID;
		$this->name = $post->post_title;
		$this->date = $post->post_date;
		$this->message = $post->post_content;
		$this->post_status = $post->post_status;

		$this->load_post_metadata();

		do_action( 'rtb_booking_load_post_data', $this, $post );
	}

	/**
	 * Store metadata for post
	 * @since 0.0.1
	 */
	public function load_post_metadata() {

		$meta_defaults = array(
			'party' => '',
			'email' => '',
			'phone' => '',
			'date_submission' => '',
			'logs' => array(),
			'ip' => '',
			'consent_acquired' => '',
			'deposit' => '0',
			'table' => array(),
			'payment_failure_message' => '',
			'receipt_id' => '',
			'reminder_sent' => false,
			'late_arrival_sent' => false,
		);

		$meta_defaults = apply_filters( 'rtb_booking_metadata_defaults', $meta_defaults );

		if ( is_array( $meta = get_post_meta( $this->ID, 'rtb', true ) ) ) {
			$meta = array_merge( $meta_defaults, get_post_meta( $this->ID, 'rtb', true ) );
		} else {
			$meta = $meta_defaults;
		}

		$this->party = $meta['party'];
		$this->email = $meta['email'];
		$this->phone = $meta['phone'];
		$this->date_submission = $meta['date_submission'];
		$this->logs = $meta['logs'];
		$this->ip = $meta['ip'];
		$this->consent_acquired = $meta['consent_acquired'];
		$this->deposit = $meta['deposit'];
		$this->table = $meta['table'];
		$this->payment_failure_message = $meta['payment_failure_message'];
		$this->receipt_id = $meta['receipt_id'];
		$this->late_arrival_sent = $meta['late_arrival_sent'];
		$this->reminder_sent = $meta['reminder_sent'];
	}

	/**
	 * Prepare booking data loaded from the database for display in a booking
	 * form as request fields. This is used, eg, for splitting datetime values
	 * into date and time fields.
	 * @since 1.3
	 */
	public function prepare_request_data() {

		// Split $date to $request_date and $request_time
		if ( empty( $this->request_date ) || empty( $this->request_time ) ) {
			$date = new DateTime( $this->date );
			$this->request_date = $date->format( 'Y/m/d' );
			$this->request_time = $date->format( 'h:i A' );
		}
	}

	/**
	 * Format date
	 * @since 0.0.1
	 */
	public function format_date( $date ) {
		$date = mysql2date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $date);
		return apply_filters( 'get_the_date', $date );
	}

	/**
	 * Format a timestamp into a human-readable date
	 *
	 * @since 1.7.1
	 */
	public function format_timestamp( $timestamp ) {
		$time = date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $timestamp );
		return $time;
	}

	/**
	 * Calculates the deposit required for a reservation, if any
	 *
	 * @since 2.1.0
	 */
	public function calculate_deposit(  ) {
		global $rtb_controller;

		$deposit = $rtb_controller->settings->get_setting( 'rtb-deposit-amount' );

		if ( $rtb_controller->settings->get_setting( 'rtb-deposit-type' ) == 'guest' ) { $deposit = $deposit * $this->party; }

		return $deposit;
	}


	/**
	 * Insert a new booking submission into the database
	 *
	 * Validates the data, adds it to the database and executes notifications
	 * @since 0.0.1
	 */
	public function insert_booking($by_admin = false) {

		// Check if this request has already been processed. If multiple forms
		// exist on the same page, this prevents a single submission from
		// being added twice.
		if ( $this->request_processed === true ) {
			return true;
		}

		$this->request_processed = true;

		if ( empty( $this->ID ) ) {
			$action = 'insert';
		} else {
			$action = 'update';
		}

		$this->validate_submission($action, $by_admin);
		if ( $this->is_valid_submission() === false ) {
			return false;
		}

		if ( $this->insert_post_data() === false ) { 
			return false;
		} else {
			$this->request_inserted = true;
		}

		do_action( 'rtb_' . $action . '_booking', $this );

		return true;
	}

	/**
	 * Validate submission data. Expects to find data in $_POST.
	 *
	 * ************************** NOTE **************************
	 * This function also create and assign all the required member variable with 
	 * the acurate values which will be insreted in the DB. One special member, 
	 * raw_input of type array holds the exact copy of $_POST
	 * 
	 * Example:
	 * class a {
	 *     public function a() {
	 *         $this->name = 'John Doe';
	 *     }
	 *     public function b() {
	 *         echo $this->name;
	 *     }
	 * }
	 * 
	 * $a = new a();
	 * 
	 * var_dump($a);
	 * object(a)#1 (0) {
	 * }
	 * 
	 * $a->a();
	 * 
	 * var_dump($a);
	 * object(a)#1 (1) {
	 *     ["name"]=>
	 *     string(8) "John Doe"
	 * }
	 * 
	 * $a->b();
	 * John Doe
	 * 
	 * @since 0.0.1
	 */
	public function validate_submission($action = null, $by_admin = false) {

		global $rtb_controller;

		$this->validation_errors = array();
		/**
		 * Raw, unprocessed value so that it can be used to preselect the form 
		 * field values, eg. table
		 */
		$this->raw_input = $_POST;

		// Date
		$date = empty( $_POST['rtb-date'] ) ? false : stripslashes_deep( $_POST['rtb-date'] );
		if ( $date === false ) {
			$this->validation_errors[] = array(
				'field'		=> 'date',
				'error_msg'	=> 'Booking request missing date',
				'message'	=> __( 'Please enter the date you would like to book.', 'restaurant-reservations' ),
			);

		} else {
			try {
				$date = new DateTime( stripslashes_deep( $_POST['rtb-date'] ) );
			} catch ( Exception $e ) {
				$this->validation_errors[] = array(
					'field'		=> 'date',
					'error_msg'	=> $e->getMessage(),
					'message'	=> __( 'The date you entered is not valid. Please select from one of the dates in the calendar.', 'restaurant-reservations' ),
				);
			}
		}

		// Time
		$time = empty( $_POST['rtb-time'] ) ? false : stripslashes_deep( $_POST['rtb-time'] );
		if ( $time === false ) {
			$this->validation_errors[] = array(
				'field'		=> 'time',
				'error_msg'	=> 'Booking request missing time',
				'message'	=> __( 'Please enter the time you would like to book.', 'restaurant-reservations' ),
			);

		} else {
			try {
				$time = new DateTime( stripslashes_deep( $_POST['rtb-time'] ) );
			} catch ( Exception $e ) {
				$this->validation_errors[] = array(
					'field'		=> 'time',
					'error_msg'	=> $e->getMessage(),
					'message'	=> __( 'The time you entered is not valid. Please select from one of the times provided.', 'restaurant-reservations' ),
				);
			}
		}

		// Check against valid open dates/times
		if ( is_object( $time ) && is_object( $date ) ) {

			$request = new DateTime( $date->format( 'Y-m-d' ) . ' ' . $time->format( 'H:i:s' ) );

			// Exempt Bookings Managers from the early and late bookings restrictions
			if ( !current_user_can( 'manage_bookings' ) ) {

				$early_bookings = $rtb_controller->settings->get_setting( 'early-bookings' );
				if ( !empty( $early_bookings ) ) {
					$uppar_bound = ( new DateTime( 'now' ) )->setTime( 23, 59 );
					$uppar_bound->add( new DateInterval( "P{$early_bookings}D" ) );

					if ( $request > $uppar_bound ) {
						$this->validation_errors[] = array(
							'field'		=> 'time',
							'error_msg'	=> 'Booking request too far in the future',
							'message'	=> sprintf( __( 'Sorry, bookings can not be made more than %s days in advance.', 'restaurant-reservations' ), $early_bookings ),
						);
					}
				}

				$late_bookings = $rtb_controller->settings->get_setting( 'late-bookings' );
				if ( empty( $late_bookings ) ) {
					if ( $request->format( 'U' ) < current_time( 'timestamp' ) ) {
						$this->validation_errors[] = array(
							'field'		=> 'time',
							'error_msg'	=> 'Booking request in the past',
							'message'	=> __( 'Sorry, bookings can not be made in the past.', 'restaurant-reservations' ),
						);
					}

				} elseif ( $late_bookings === 'same_day' ) {
					if ( $request->format( 'Y-m-d' ) == current_time( 'Y-m-d' ) ) {
						$this->validation_errors[] = array(
							'field'		=> 'time',
							'error_msg'	=> 'Booking request made on same day',
							'message'	=> __( 'Sorry, bookings can not be made for the same day.', 'restaurant-reservations' ),
						);
					}

				} else {
					$late_bookings_seconds = $late_bookings * 60; // Late bookings allowance in seconds
					if ( $request->format( 'U' ) < ( current_time( 'timestamp' ) + $late_bookings_seconds ) ) {
						if ( $late_bookings >= 1440 ) {
							$late_bookings_message = sprintf( __( 'Sorry, bookings must be made more than %s days in advance.', 'restaurant-reservations' ), $late_bookings / 1440 );
						} elseif ( $late_bookings >= 60 ) {
							$late_bookings_message = sprintf( __( 'Sorry, bookings must be made more than %s hours in advance.', 'restaurant-reservations' ), $late_bookings / 60 );
						} else {
							$late_bookings_message = sprintf( __( 'Sorry, bookings must be made more than %s minutes in advance.', 'restaurant-reservations' ), $late_bookings );
						}
						$this->validation_errors[] = array(
							'field'		=> 'time',
							'error_msg'	=> 'Booking request made too close to the reserved time',
							'message'	=> $late_bookings_message,
						);
					}
				}
			}

			// Check against scheduling exception rules
			$exceptions = $rtb_controller->settings->get_setting( 'schedule-closed' );
			if ( empty( $this->validation_errors ) && !empty( $exceptions ) && !current_user_can( 'manage_bookings' ) ) {
				$exception_is_active = false;
				$datetime_is_valid = false;
				foreach( $exceptions as $exception ) {
					$excp_date = new DateTime( $exception['date'] );
					if ( $excp_date->format( 'Y-m-d' ) == $request->format( 'Y-m-d' ) ) {
						$exception_is_active = true;

						// Closed all day
						if ( empty( $exception['time'] ) ) {
							continue;
						}

						$excp_start_time = empty( $exception['time']['start'] ) ? $request : new DateTime( $exception['date'] . ' ' . $exception['time']['start'] );
						$excp_end_time = empty( $exception['time']['end'] ) ? $request : new DateTime( $exception['date'] . ' ' . $exception['time']['end'] );

						if ( $request->format( 'U' ) >= $excp_start_time->format( 'U' ) && $request->format( 'U' ) <= $excp_end_time->format( 'U' ) ) {
							$datetime_is_valid = true;
							break;
						}
					}
				}

				if ( $exception_is_active && !$datetime_is_valid ) {
					$this->validation_errors[] = array(
						'field'		=> 'date',
						'error_msg'	=> 'Booking request made on invalid date or time in an exception rule',
						'message'	=> __( 'Sorry, no bookings are being accepted then.', 'restaurant-reservations' ),
					);
				}
			}

			// Check against weekly scheduling rules
			$rules = $rtb_controller->settings->get_setting( 'schedule-open' );
			if ( empty( $exception_is_active ) && empty( $this->validation_errors ) && !empty( $rules ) && !current_user_can( 'manage_bookings' ) ) {
				$request_weekday = strtolower( $request->format( 'l' ) );
				$time_is_valid = null;
				$day_is_valid = null;
				foreach( $rules as $rule ) {

					if ( !empty( $rule['weekdays'][ $request_weekday ] ) ) {
						$day_is_valid = true;

						if ( empty( $rule['time'] ) ) {
							$time_is_valid = true; // Days with no time values are open all day
							break;
						}

						$too_early = true;
						$too_late = true;

						// Too early
						if ( !empty( $rule['time']['start'] ) ) {
							$rule_start_time = new DateTime( $request->format( 'Y-m-d' ) . ' ' . $rule['time']['start'] );
							if ( $rule_start_time->format( 'U' ) <= $request->format( 'U' ) ) {
								$too_early = false;
							}
						}

						// Too late
						if ( !empty( $rule['time']['end'] ) ) {
							$rule_end_time = new DateTime( $request->format( 'Y-m-d' ) . ' ' . $rule['time']['end'] );
							if ( $rule_end_time->format( 'U' ) >= $request->format( 'U' ) ) {
								$too_late = false;
							}
						}

						// Valid time found
						if ( $too_early === false && $too_late === false) {
							$time_is_valid = true;
							break;
						}
					}
				}

				if ( !$day_is_valid ) {
					$this->validation_errors[] = array(
						'field'		=> 'date',
						'error_msg'	=> 'Booking request made on an invalid date',
						'message'	=> __( 'Sorry, no bookings are being accepted on that date.', 'restaurant-reservations' ),
					);
				} elseif ( !$time_is_valid ) {
					$this->validation_errors[] = array(
						'field'		=> 'time',
						'error_msg'	=> 'Booking request made at an invalid time',
						'message'	=> __( 'Sorry, no bookings are being accepted at that time.', 'restaurant-reservations' ),
					);
				}
			}

			// Accept the date if it has passed validation
			if ( empty( $this->validation_errors ) ) {
				$this->date = $request->format( 'Y-m-d H:i:s' );
			}
		}

		// Save requested date/time values in case they need to be
		// printed in the form again
		$this->request_date = empty( $_POST['rtb-date'] ) ? '' : stripslashes_deep( $_POST['rtb-date'] );
		$this->request_time = empty( $_POST['rtb-time'] ) ? '' : stripslashes_deep( $_POST['rtb-time'] );

		// Name
		$this->name = empty( $_POST['rtb-name'] ) ? '' : wp_strip_all_tags( sanitize_text_field( stripslashes_deep( $_POST['rtb-name'] ) ), true ); // @todo should I limit length?
		if ( empty( $this->name ) ) {
			$this->validation_errors[] = array(
				'field'			=> 'name',
				'post_variable'	=> $this->name,
				'message'	=> __( 'Please enter a name for this booking.', 'restaurant-reservations' ),
			);
		}

		// Party
		$this->party = empty( $_POST['rtb-party'] ) ? '' : absint( $_POST['rtb-party'] );
		if ( empty( $this->party ) ) {
			$this->validation_errors[] = array(
				'field'			=> 'party',
				'post_variable'	=> $this->party,
				'message'	=> __( 'Please let us know how many people will be in your party.', 'restaurant-reservations' ),
			);

		// Check party size
		} else {
			$party_size = $rtb_controller->settings->get_setting( 'party-size' );
			if ( ! empty( $party_size ) && $party_size < $this->party ) {
				$this->validation_errors[] = array(
					'field'			=> 'party',
					'post_variable'	=> $this->party,
					'message'	=> sprintf( __( 'We only accept bookings for parties of up to %d people.', 'restaurant-reservations' ), $party_size ),
				);
			}
			$party_size_min = $rtb_controller->settings->get_setting( 'party-size-min' );
			if ( ! empty( $party_size_min ) && $party_size_min > $this->party ) {
				$this->validation_errors[] = array(
					'field'			=> 'party',
					'post_variable'	=> $this->party,
					'message'	=> sprintf( __( 'We only accept bookings for parties of more than %d people.', 'restaurant-reservations' ), $party_size_min ),
				);
			}
		}

		// Email
		$this->email = empty( $_POST['rtb-email'] ) ? '' : sanitize_text_field( stripslashes_deep( $_POST['rtb-email'] ) ); // @todo email validation? send notification back to form on bad email address.
		if ( empty( $this->email ) ) {
			$this->validation_errors[] = array(
				'field'			=> 'email',
				'post_variable'	=> $this->email,
				'message'	=> __( 'Please enter an email address so we can confirm your booking.', 'restaurant-reservations' ),
			);
		} elseif ( !is_email( $this->email ) && apply_filters( 'rtb_require_valid_email', true ) ) {
			$this->validation_errors[] = array(
				'field'			=> 'email',
				'post_variable'	=> $this->email,
				'message'	=> __( 'Please enter a valid email address so we can confirm your booking.', 'restaurant-reservations' ),
			);
		}

		// Phone
		$this->phone = empty( $_POST['rtb-phone'] ) ? '' : sanitize_text_field( stripslashes_deep( $_POST['rtb-phone'] ) );
		$phone_required = $rtb_controller->settings->get_setting( 'require-phone' );
		if ( $phone_required && empty( $this->phone ) ) {
			$this->validation_errors[] = array(
				'field'			=> 'phone',
				'post_variable'	=> $this->phone,
				'message'	=> __( 'Please provide a phone number so we can confirm your booking.', 'restaurant-reservations' ),
			);
		}

		// Table
		$table = empty( $_POST['rtb-table'] ) ? array() : explode( ',', sanitize_text_field( stripslashes_deep( $_POST['rtb-table'] ) ) );
		$this->table = is_array( $table ) ? array_map( 'sanitize_text_field', $table ) : array();

		$table_required = $rtb_controller->settings->get_setting( 'require-table' );
		if ( $table_required && empty( $this->table ) ) {
			$this->validation_errors[] = array(
				'field'			=> 'table',
				'post_variable'	=> $this->table,
				'message'	=> __( 'Please select a table for your booking.', 'restaurant-reservations' ),
			);
		}

		// check whether there is a time conflict for a particular table
		$valid_table = $this->table ? $this->is_valid_table() : true;
		if ( ! $valid_table ) {
			$this->validation_errors[] = array(
				'field'			=> 'table',
				'post_variable'	=> $this->table,
				'message'	=> __( 'Please select a valid table for your booking.', 'restaurant-reservations' ),
			);
		}

		// reCAPTCHA
		if ( $rtb_controller->settings->get_setting( 'enable-captcha' ) && !is_admin() ) {
			if ( ! isset($_POST['g-recaptcha-response']) ) {
				$this->validation_errors[] = array(
					'field'		=> 'recaptcha',
					'error_msg'	=> 'No reCAPTCHA code',
					'message'	=> __( 'Please fill out the reCAPTCHA box  before submitting.', 'restaurant-reservations' ),
				);
			}
			else {
				$secret_key = $rtb_controller->settings->get_setting( 'captcha-secret-key' );
				$captcha = $_POST['g-recaptcha-response'];

				$url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secret_key) .  '&response=' . urlencode($captcha);
				$json_response = file_get_contents( $url );
				$response = json_decode( $json_response );

				$reCaptcha_error = false;
				if(json_last_error() != JSON_ERROR_NONE) {
					$response = new stdClass();
					$response->success = false;
					$reCaptcha_error = true;
					if(defined('WP_DEBUG') && WP_DEBUG) {
						error_log('RTB reCAPTCHA error. Raw respose: '.print_r([$json_response], true));
					}
				}

				if ( ! $response->success ) {
					$message = __( 'Please fill out the reCAPTCHA box again and re-submit.', 'restaurant-reservations' );
					if($reCaptcha_error) {
						$message .= __( ' If you encounter reCAPTCHA error multiple times, please contact us.', 'restaurant-reservations' );
					}
					$this->validation_errors[] = array(
						'field'		=> 'recaptcha',
						'error_msg'	=> 'Invalid reCAPTCHA code',
						'message'	=> $message,
					);
				}
			}
		}

		// Message
		$this->message = empty( $_POST['rtb-message'] ) ? '' : nl2br( wp_kses_post( stripslashes_deep( $_POST['rtb-message'] ) ) );

		// Post Status (define a default post status if none passed)
		$this->determine_status();

		// Consent
		$require_consent = $rtb_controller->settings->get_setting( 'require-consent' );
		$consent_statement = $rtb_controller->settings->get_setting( 'consent-statement' );
		if ( $require_consent && $consent_statement ) {
			// Don't change consent status once initial consent has been collected
			if ( empty( $this->consent_acquired ) ) {
				$this->consent_acquired = !empty( $_POST['rtb-consent-statement'] );
			}
		}

		// Check if any required fields are empty
		$required_fields = $rtb_controller->settings->get_required_fields();
		foreach( $required_fields as $slug => $field ) {
			if ( !$this->field_has_error( $slug ) && $this->is_field_empty( $slug ) ) {
				$this->validation_errors[] = array(
					'field'			=> $slug,
					'post_variable'	=> '',
					'message'	=> __( 'Please complete this field to request a booking.', 'restaurant-reservations' ),
				);
			}
		}

		// Check if the email or IP is banned
		if ( !current_user_can( 'manage_bookings' ) ) {
			$ip = $_SERVER['REMOTE_ADDR'];
			if ( !$this->is_valid_ip( $ip ) || !$this->is_valid_email( $this->email ) ) {
				$this->validation_errors[] = array(
					'field'			=> 'date',
					'post_variable'	=> $ip,
					'message'		=> __( 'Your booking has been rejected. Please call us if you would like to make a booking.', 'restaurant-reservations' ),
				);
			} elseif ( empty( $this->ip ) and ! $rtb_controller->settings->get_setting( 'disable-ip-capture' ) ) {
				$this->ip = sanitize_text_field( $ip );
			}
		} elseif ( empty( $this->ip ) and ! $rtb_controller->settings->get_setting( 'disable-ip-capture' ) ) {
			$this->ip = sanitize_text_field( $_SERVER['REMOTE_ADDR'] );
		}
		
		// Check to make sure that the maximum number of reservations has not already been made
		if ( ! $this->is_under_max_reservations() ){
			$this->validation_errors[] = array(
				'field'		=> 'time',
				'error_msg'	=> 'maximum reservations exceeded',
				'message'	=> __( 'The maximum number of reservations for that timeslot has been reached. Please select a different timeslot.', 'restaurant-reservations' ),
			);
		}

		// Check to make sure that the maximum number of seats has not already been made
		if ( ! $this->is_under_max_seats() ){
			$this->validation_errors[] = array(
				'field'		=> 'time',
				'error_msg'	=> 'maximum seats exceeded',
				'message'	=> __( 'With your party, the maximum number of seats for that timeslot would be exceeded. Please select a different timeslot or reduce your party size.', 'restaurant-reservations' ),
			);
		}

		// Check if there is a booking already made with the exact same information, to prevent double bookings on refresh
		if ( (!$by_admin || $by_admin && $action !== 'update') && $this->is_duplicate_booking() ) {
			$this->validation_errors[] = array(
				'field'		=> 'date',
				'error_msg'	=> 'duplicate booking',
				'message'	=> __( 'Your booking and personal information exactly matches another booking. If this was not caused by refreshing the page, please call us to make a booking.', 'restaurant-reservations' ),
			);
		}

		do_action( 'rtb_validate_booking_submission', $this );

	}

	/**
	 * Check if submission is valid
	 *
	 * @since 0.0.1
	 */
	public function is_valid_submission() {

		if ( !count( $this->validation_errors ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Check if a field already has an error attached to it
	 *
	 * @field string Field slug
	 * @since 1.3
	 */
	public function field_has_error( $field_slug ) {

		foreach( $this->validation_errors as $error ) {
			if ( $error['field'] == $field_slug ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Check if a field is missing
	 *
	 * Checks for empty strings and arrays, but accepts '0'
	 * @since 0.1
	 */
	public function is_field_empty( $slug ) {

		$input = isset( $_POST['rtb-' . $slug ] ) ? $_POST['rtb-' . $slug] : '';

		if ( ( is_string( $input ) && trim( $input ) == '' ) ||
			( is_array( $input ) && empty( $input ) ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Check if an IP address has been banned
	 *
	 * @param string $ip
	 * @return bool
	 * @since 1.7
	 */
	public function is_valid_ip( $ip = null ) {

		if ( is_null( $ip ) ) {
			$ip = isset( $this->ip ) ? $this->ip : null;
			if ( is_null( $ip ) ) {
				return false;
			}
		}

		global $rtb_controller;

		$banned_ips = array_filter( explode( "\n", $rtb_controller->settings->get_setting( 'ban-ips' ) ) );

		foreach( $banned_ips as $banned_ip ) {
			if ( $ip == trim( $banned_ip ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Check if an email address has been banned
	 *
	 * @param string $email
	 * @return bool
	 * @since 1.7
	 */
	public function is_valid_email( $email = null ) {

		if ( is_null( $email ) ) {
			$email = isset( $this->email ) ? $this->email : null;
			if ( is_null( $email ) ) {
				return false;
			}
		}

		global $rtb_controller;

		$banned_emails = array_filter( explode( "\n", $rtb_controller->settings->get_setting( 'ban-emails' ) ) );

		foreach( $banned_emails as $banned_email ) {
			if ( $email == trim( $banned_email ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Check if a table(s) is valid (not already taken during a specific timeslot)
	 *
	 * @return bool
	 * @since 2.1.7
	 */
	public function is_valid_table() {
		global $rtb_controller;

		if ( ! $this->table or ! is_array( $this->table ) ) { return false; }

		$valid_tables = rtb_get_valid_tables( $this->date );

		if ( isset( $this->ID ) ) {
			
			$post_meta = get_post_meta( $this->ID, 'rtb', true );

			if ( isset( $post_meta['table'] ) and is_array( $post_meta['table'] ) ) { $valid_tables = array_merge( $valid_tables, $post_meta['table'] ); }
		}
		
		return $this->table == array_intersect( $this->table, $valid_tables );
	}

	/**
	 * Check if this booking would put the restaurant over the maximum, if set
	 *
	 * @return bool
	 * @since 2.1.20
	 */
	public function is_under_max_reservations() { 
		global $rtb_controller;

		$max_reservations_enabled = $rtb_controller->settings->get_setting( 'rtb-enable-max-tables' );

		if ( ! $max_reservations_enabled ) { return true; }

		$max_reservations_setting = $rtb_controller->settings->get_setting( 'rtb-max-tables-count' );
		$max_reservations = substr( $max_reservations_setting, 0, strpos( $max_reservations_setting, '_' ) );

		if ($max_reservations == 'undefined' or ! $max_reservations ) { return true; }

		$dining_block_setting = $rtb_controller->settings->get_setting( 'rtb-dining-block-length' );
		$dining_block = substr( $dining_block_setting, 0, strpos( $dining_block_setting, '_' ) );
		$dining_block_seconds = ( $dining_block * 60 - 1 ); // Take 1 second off, to avoid bookings that start or end exactly at the beginning of a booking block

		$after_time = strtotime($this->date) - $dining_block_seconds - (3600 * get_option( 'gmt_offset' ) );
		$before_time = strtotime($this->date) + $dining_block_seconds - (3600 * get_option( 'gmt_offset' ) );

    $args = array(
      'posts_per_page' => -1,
      'post_status'    => ['pending', 'payment_pending', 'confirmed', 'arrived'],
      'date_query'     => array(
        'before' => date( 'c', $before_time ),
        'after'  => date( 'c', $after_time )
      )
    );

		require_once( RTB_PLUGIN_DIR . '/includes/Query.class.php' );
		$query = new rtbQuery( $args );
		$query->prepare_args();

		$times = array();
		foreach ( $query->get_bookings() as $booking ) {

			if ( isset( $this->ID ) and $booking->ID == $this->ID ) { continue; }
			
			$times[] = strtotime( $booking->date );
		}
		
		sort( $times );

		$accept_reservation = true;
		$current_times = array();
		foreach ( $times as $time ) {
			
			$current_times[] = $time;
			
			if ( reset( $current_times ) < ($time - $dining_block_seconds) ) { array_shift( $current_times ); }

			// Check if we go above the max confirmation number
			if ( sizeOf( $current_times ) + 1 > $max_reservations ) { $accept_reservation = false; break; } 
		}

		return $accept_reservation;
	}

	/**
	 * Check if this booking would put the restaurant over the maximum number of people, if set
	 *
	 * @return bool
	 * @since 2.1.20
	 */
	public function is_under_max_seats() {
		global $rtb_controller;

		$max_reservations_enabled = $rtb_controller->settings->get_setting( 'rtb-enable-max-tables' );

		if ( ! $max_reservations_enabled ) { return true; }

		$max_seats_setting = $rtb_controller->settings->get_setting( 'rtb-max-people-count' );
		$max_seats = (int) substr( $max_seats_setting, 0, strpos( $max_seats_setting, '_' ) );

		if ( $max_seats == 'undefined' or ! $max_seats ) { return true; } 
		if ( $this->party > $max_seats ) { return false; }

		$dining_block_setting = $rtb_controller->settings->get_setting( 'rtb-dining-block-length' );
		$dining_block = substr( $dining_block_setting, 0, strpos( $dining_block_setting, '_' ) );
		$dining_block_seconds = ( $dining_block * 60 - 1 ); // Take 1 second off, to avoid bookings that start or end exactly at the beginning of a booking block

		$after_time = strtotime($this->date) - $dining_block_seconds - (3600 * get_option( 'gmt_offset' ) );
		$before_time = strtotime($this->date) + $dining_block_seconds - (3600 * get_option( 'gmt_offset' ) );

		$args = array(
			'posts_per_page' => -1,
      'post_status'    => ['pending', 'payment_pending', 'confirmed', 'arrived'],
			'date_query'     => array(
				'before' => date( 'c', $before_time ),
				'after'  => date( 'c', $after_time )
			)
		);

		require_once( RTB_PLUGIN_DIR . '/includes/Query.class.php' );
		$query = new rtbQuery( $args );
		
		$times = array();
		foreach ( $query->get_bookings() as $booking ) {

			if ( isset( $this->ID ) and $booking->ID == $this->ID ) { continue; }

			$booking_time = strtotime( $booking->date );
			if ( isset( $times[$booking_time] ) ) { $times[$booking_time] +=  intval( $booking->party ); }
			else { $times[$booking_time] = (int) $booking->party; }
		}

		ksort( $times );
		
		$accept_reservation = true;
		$current_seats = array();
		foreach ( $times as $time  => $seats ) {
			
			$current_seats[$time] = $seats;

			reset( $current_seats );

			if ( key ( $current_seats ) < $time - $dining_block_seconds ) { array_shift( $current_seats ); }

			// Check if adding the current party puts us above the max confirmation number
			if ( array_sum( $current_seats ) + $this->party > $max_seats ) { $accept_reservation = false; break; } 
		}

		return $accept_reservation;

	}

	/**
	 * Check if the information in a booking exactly matches another booking
	 *
	 * @return bool
	 * @since 2.1.20
	 */
	public function is_duplicate_booking() {
		global $wpdb, $rtb_controller;

		if( 0 < count($this->validation_errors) ) {
			/**
			 * Do not run this check if there is an error already
			 * There could abe a moment when someminfo could be missing, which is required
			 * for this qurey to function.
			 */
			return null;
		}

		$valid_status = ['confirmed', 'pending'];

		// This is an intermediate status when payment is pending
		if ( $rtb_controller->settings->get_setting( 'require-deposit' ) ) {
			$valid_status = array_merge($valid_status, ['payment_pending']);
		}

		$args = array_merge(
			array(
				RTB_BOOKING_POST_TYPE,
				$this->date,
				$this->name
			),
			$valid_status
		);

		$status_placeholder = implode( ',', array_fill( 0, count( $valid_status ), '%s' ) );

		$sql  = "SELECT ID FROM {$wpdb->posts} WHERE post_type=%s AND post_date=%s AND post_title=%s AND post_status IN ({$status_placeholder})";

		if ( isset( $this->ID ) ) {
			$sql 	.= ' AND ID!=%d';
			$args[] = $this->ID;
		}

		$booking_result = $wpdb->get_row( $wpdb->prepare( $sql, $args ) );

		if ( $booking_result ) {
			$meta = get_post_meta( $booking_result->ID, 'rtb', true );
			$meta = is_array( $meta ) ? $meta : array();
			
			if ( $this->party == $meta['party'] and $this->email == $meta['email'] and $this->phone == $meta['phone'] ) {

				return true;
			}
		}

		return false;
	}

	/**
	 * Check whether the number of reservations occurring at the same time is below the threshold
	 * where reservations get automatically confirmed
	 *
	 * @since 2.0.0
	 */
	public function under_max_confirm_reservations() {
		global $rtb_controller;

		$max_reservations_setting = $rtb_controller->settings->get_setting( 'auto-confirm-max-reservations' );
		$max_reservations = substr( $max_reservations_setting, 0, strpos( $max_reservations_setting, '_' ) );

		if ( $max_reservations == 'undefined' or $max_reservations <= 1 ) { return false; }

		$dining_block_setting = $rtb_controller->settings->get_setting( 'rtb-dining-block-length' );
		$dining_block = substr( $dining_block_setting, 0, strpos( $dining_block_setting, '_' ) );
		$dining_block_seconds = ( $dining_block * 60 - 1 ); // Take 1 second off, to avoid bookings that start or end exactly at the beginning of a booking block

		$after_time = strtotime($this->date) - $dining_block_seconds - (3600 * get_option( 'gmt_offset' ) );
		$before_time = strtotime($this->date) + $dining_block_seconds - (3600 * get_option( 'gmt_offset' ) );

		$args = array(
			'posts_per_page' => -1,
      'post_status'    => ['confirmed', 'arrived'],
			'date_query'     => array(
				'before' => date( 'c', $before_time ),
				'after'  => date( 'c', $after_time )
			)
		);

		require_once( RTB_PLUGIN_DIR . '/includes/Query.class.php' );
		$query = new rtbQuery( $args );
		$query->prepare_args();
		
		$times = array();
		foreach ( $query->get_bookings() as $booking ) {
			$times[] = strtotime( $booking->date );
		}
		
		sort( $times );

		$auto_confirm = true;
		$current_times = array();
		foreach ( $times as $time ) {
			$current_times[] = $time;
			
			if ( reset( $current_times ) < ($time - $dining_block_seconds) ) { array_shift( $current_times ); }

			// Check if we've reached 1 below the max confirmation number, since adding the current booking will put us at the threshold
			if ( sizeOf( $current_times ) + 1 >= $max_reservations ) { $auto_confirm = false; break; } 
		}

		return $auto_confirm;
	}

	/**
	 * Check whether the number of seats occurring at the same time is below the threshold
	 * where reservations get automatically confirmed
	 *
	 * @since 2.0.0
	 */
	public function under_max_confirm_seats() {
		global $rtb_controller;

		$max_seats_setting = $rtb_controller->settings->get_setting( 'auto-confirm-max-seats' );
		$max_seats = substr( $max_seats_setting, 0, strpos( $max_seats_setting, '_' ) );

		if ( $max_seats == 'undefined' or $max_seats < 2 or $this->party >= $max_seats ) { return false; }

		$dining_block_setting = $rtb_controller->settings->get_setting( 'rtb-dining-block-length' );
		$dining_block = substr( $dining_block_setting, 0, strpos( $dining_block_setting, '_' ) );
		$dining_block_seconds = ( $dining_block * 60 - 1 ); // Take 1 second off, to avoid bookings that start or end exactly at the beginning of a booking block

		$after_time = strtotime($this->date) - $dining_block_seconds - (3600 * get_option( 'gmt_offset' ) );
		$before_time = strtotime($this->date) + $dining_block_seconds - (3600 * get_option( 'gmt_offset' ) );

		$args = array(
			'posts_per_page' => -1,
      'post_status'    => ['confirmed', 'arrived'],
			'date_query'     => array(
				'before' => date( 'c', $before_time ),
				'after'  => date( 'c', $after_time )
			)
		);

		require_once( RTB_PLUGIN_DIR . '/includes/Query.class.php' );
		$query = new rtbQuery( $args );
		
		$times = array();
		foreach ( $query->get_bookings() as $booking ) {
			$booking_time = strtotime( $booking->date );
			if ( isset( $times[$booking_time] ) ) { $times[$booking_time] += $booking->party; }
			else { $times[$booking_time] = $booking->party; }
		}

		ksort( $times );
		
		$auto_confirm = true;
		$current_seats = array();
		foreach ( $times as $time  => $seats ) {
			$current_seats[$time] = $seats;

			reset( $current_seats );

			if ( key ( $current_seats ) < $time - $dining_block_seconds ) { array_shift( $current_seats ); }

			// Check if adding the current party puts us at or above the max confirmation number
			if ( array_sum( $current_seats ) + $this->party >= $max_seats ) { $auto_confirm = false; break; }
		}

		return $auto_confirm;
	}

	/**
	 * Determine what status a booking should have
	 *
	 * @since 2.1.0
	 */
	public function determine_status( $payment_made = false ) {
		global $rtb_controller;

		if ( !empty( $_POST['rtb-post-status'] ) && array_key_exists( $_POST['rtb-post-status'], $rtb_controller->cpts->booking_statuses ) ) {
			$post_status = sanitize_text_field( stripslashes_deep( $_POST['rtb-post-status'] ) );
		} elseif ( $rtb_controller->settings->get_setting( 'require-deposit' ) and ! $payment_made ) {
			$post_status = 'payment_pending';
		} elseif ( $this->party < $rtb_controller->settings->get_setting( 'auto-confirm-max-party-size' ) ) {
			$post_status = 'confirmed';
		} elseif ($rtb_controller->settings->get_setting( 'auto-confirm-max-reservations' ) and $this->under_max_confirm_reservations() ) {
			$post_status = 'confirmed';
		} elseif ( $rtb_controller->settings->get_setting( 'auto-confirm-max-seats' ) and $this->under_max_confirm_seats() ) {
			$post_status = 'confirmed';
		} else {
			$post_status = 'pending';
		}

		$this->post_status = apply_filters( 'rtb_determine_booking_status', $post_status, $this );
	}

	/**
	 * Add a log entry to the booking
	 *
	 * @since 1.3.1
	 */
	public function add_log( $type, $title, $message = '', $datetime = null ) {

		if ( empty( $datetime ) ) {
			$datetime = date( 'Y-m-d H:i:s');
		}

		if ( empty( $this->logs ) ) {
			$this->logs = array();
		}

		array_push( $this->logs, array( $type, $title, $message, $datetime ) );
	}

	/**
	 * Insert post data for a new booking or update a booking
	 * @since 0.0.1
	 */
	public function insert_post_data() {

		$args = array(
			'post_type'		=> RTB_BOOKING_POST_TYPE,
			'post_title'	=> $this->name,
			'post_content'	=> $this->message,
			'post_date'		=> $this->date,
			'post_date_gmt'	=> get_gmt_from_date( $this->date ), // fix for post_date_gmt not being set for some bookings
			'post_status'	=> $this->post_status,
		);

		if ( !empty( $this->ID ) ) {
			$args['ID'] = $this->ID;
		}

		$args = apply_filters( 'rtb_insert_booking_data', $args, $this );

		// When updating a booking, we need to update the metadata first, so that
		// notifications hooked to the status changes go out with the new metadata.
		// If we're inserting a new booking, we have to insert it before we can
		// add metadata, and the default notifications don't fire until it's all done.
		if ( !empty( $this->ID ) ) {
			$this->insert_post_meta();
			$id = wp_insert_post( $args );
		} else {
			$id = wp_insert_post( $args );
			if ( $id && !is_wp_error( $id ) ) {
				$this->ID = $id;
				$this->insert_post_meta();
			}
		}

		return !is_wp_error( $id ) && $id !== false;
	}

	/**
	 * Insert the post metadata for a new booking or when updating a booking
	 * @since 1.7.7
	 */
	public function insert_post_meta() {

		$meta = array(
			'party' => $this->party,
			'email' => $this->email,
			'phone' => $this->phone,
		);

		if ( !empty( $this->ip ) ) {
			$meta['ip'] = $this->ip;
		}

		if ( empty( $this->date_submission ) ) {
			$meta['date_submission'] = current_time( 'timestamp' );
		} else {
			$meta['date_submission'] = $this->date_submission;
		}

		if ( !empty( $this->consent_acquired ) ) {
			$meta['consent_acquired'] = $this->consent_acquired;
		}

		if ( !empty( $this->logs ) ) {
			$meta['logs'] = $this->logs;
		}

		if ( !empty( $this->table ) ) {
			$meta['table'] = $this->table;
		}

		if ( !empty( $this->deposit ) ) {
			$meta['deposit'] = $this->deposit;
		}

		if ( !empty( $this->payment_failure_message ) ) {
			$meta['payment_failure_message'] = $this->payment_failure_message;
		}

		if ( !empty( $this->receipt_id ) ) {
			$meta['receipt_id'] = $this->receipt_id;
		}

		if ( !empty( $this->reminder_sent ) ) {
			$meta['reminder_sent'] = $this->reminder_sent;
		}

		if ( !empty( $this->late_arrival_sent ) ) {
			$meta['late_arrival_sent'] = $this->late_arrival_sent;
		}

		$meta = apply_filters( 'rtb_insert_booking_metadata', $meta, $this );

		return update_post_meta( $this->ID, 'rtb', $meta );
	}

	public function payment_paid()
	{
		if( isset( $this->ID ) ) {
			$this->determine_status( true );

			$this->insert_post_data();

			do_action( 'rtb_booking_paid', $this );
		}
	}

	public function payment_failed( $message = '' )
	{
		$this->post_status = 'payment_failed';
		$this->payment_failure_message = $message;

		$this->insert_post_data();

		do_action( 'rtb_booking_paid', $this );
	}

}
} // endif;
