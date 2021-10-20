<?php
if ( !function_exists( 'tb_print_form_select_field' ) ) {
	function tb_print_form_select_field( $slug, $title, $value, $args ) {

		$slug = esc_attr( $slug );
		$value = esc_attr( $value );
		$options = is_array( $args['options'] ) ? $args['options'] : array();
		$classes = isset( $args['classes'] ) ? $args['classes'] : array();

		?>

		<div <?php echo rtb_print_element_class( $slug, $classes ); ?>>
			<?php echo rtb_print_form_error( $slug ); ?>
			<select name="rtb-<?php echo esc_attr($slug); ?>" id="rtb-<?php echo esc_attr($slug); ?>">
				<?php foreach ( $options as $opt_value => $opt_label ) : ?>
				<option value="<?php echo esc_attr( $opt_value ); ?>" <?php selected( $opt_value, $value ); ?>><?php echo esc_attr( $opt_label ); ?></option>
				<?php endforeach; ?>
			</select>
		</div>

		<?php

	}
}

if ( !function_exists( 'tb_rtb_print_form_submit_field' ) ) {
	function tb_rtb_print_form_submit_field() {		
		$button = sprintf( 
			'<div class="col-md-6 btn_submit"><button type="submit">%s</button></div>',
			apply_filters( 'rtb_booking_form_submit_label', __( 'Book', 'restaurant-reservations' ) )
		);
		echo apply_filters( 'tb_rtb_booking_form_submit_button', $button );
	}
}
if ( !function_exists( 'tb_print_form_text_field' ) ) {
	function tb_print_form_text_field( $slug, $title, $value, $args = null ) {

		$slug = esc_attr( $slug );
		$value = esc_attr( $value );
		$classes = isset( $args['classes'] ) ? $args['classes'] : array();
		?>	
		<div <?php echo rtb_print_element_class( $slug, $classes ); ?>>
			<?php echo rtb_print_form_error( $slug ); ?>
			<input placeholder="<?php echo $title; ?>" type="text" name="rtb-<?php echo esc_attr($slug); ?>" id="rtb-<?php echo esc_attr($slug); ?>" value="<?php echo esc_attr($value); ?>">
		</div>
		<?php

	}
}
add_filter('the_content','tb_aqua_filter_content',9,1);

function tb_aqua_filter_content($content){
	global $rtb_controller;
	remove_filter('the_content',array( $rtb_controller, 'append_to_content' ));
	return $content;
}
//filter comlum manager
add_filter('rtb_bookings_table_columns','tb_aqua_manager_table_admin',1,1);

function tb_aqua_manager_table_admin($content){
	$columns = array(
		'cb'        => '<input type="checkbox" />', //Render a checkbox instead of text
		'date_custom'     	=> __( 'Date', 'restaurant-reservations' ),
		'custom_time'  	=> __( 'Time', 'restaurant-reservations' ),
		'service'  	=> __( 'Service', 'restaurant-reservations' ),
		'name'  	=> __( 'Name', 'restaurant-reservations' ),
		'email'  	=> __( 'Email', 'restaurant-reservations' ),
		'status'  	=> __( 'Status', 'restaurant-reservations' )
	);
	return $columns;
}
//filter value comlum manager
add_filter('rtb_bookings_table_column','tb_aqua_managet_table_admin_value',1,3);

function tb_aqua_managet_table_admin_value($value, $booking, $column_name){
	$service = array('spa'=>'Spa','massage'=>'Massage','yoga'=>'Yoga');
	$time_custom = array('morning'=>'Morning','afernoon'=>'Afernoon','evening'=>'Evening');
	$date_custom = 'Date';
	switch ( $column_name ) {
		case 'service' :
			$value = $service[$booking->service];
			break;
		case 'custom_time' :
			$value = $time_custom[$booking->time_custom];
			break;
		case 'date_custom' :
			$value = $booking->date_custom;
			break;
	}	
	return $value;
}
add_filter('rtb_booking_load_post_data','tb_rtb_booking_load_post_data',10, 2);
function tb_rtb_booking_load_post_data($book, $item){
	$meta_defaults = array(
		'service' => '',
		'time_custom' => '',
		'date_custom' => '',
	);
	if ( is_array( $meta = get_post_meta( $item->ID, 'rtb', true ) ) ) {
		$meta = array_merge( $meta_defaults, get_post_meta( $item->ID, 'rtb', true ) );
	} else {
		$meta = $meta_defaults;
	}

	$book->service = $meta['service'];
	$book->time_custom = $meta['time_custom'];
	$book->date_custom = $meta['date_custom'];
	return $book;
}
add_filter('rtb_booking_form_fields','tb_rtb_booking_form_fields',10, 2);
function tb_rtb_booking_form_fields($fields, $request){
	require_once( RTB_PLUGIN_DIR . '/includes/Settings.class.php' );
	$rtbSettings = new rtbSettings();
	$fields = array(
		// Contact details fieldset
		'contact'	=> array(
			'legend'	=> __( 'Contact Details', 'restaurant-reservations' ),
			'fields'	=> array(
				'name'		=> array(
					'title'			=> __( 'Name', 'restaurant-reservations' ),
					'request_input'	=> empty( $request->name ) ? '' : $request->name,
					'callback'		=> 'tb_print_form_text_field',
					'callback_args'	=> array(
						'classes' => array('col-md-12'),
					),
					'required'		=> true,
				),
				'email'		=> array(
					'title'			=> __( 'Email', 'restaurant-reservations' ),
					'request_input'	=> empty( $request->email ) ? '' : $request->email,
					'callback'		=> 'tb_print_form_text_field',
					'callback_args'	=> array(
						'input_type'	=> 'email',
						'classes' => array('col-md-12'),
					),
					'required'		=> true,
				),
			),
		),
		// Reservation details fieldset
		'reservation'	=> array(
			'legend'	=> __( 'Book a table', 'restaurant-reservations' ),
			'fields'	=> array(
				'time_custom'		=> array(
					'title'			=> __( 'Time', 'restaurant-reservations' ),
					'request_input'	=> empty( $request->time_custom ) ? '' : $request->time_custom,
					'callback'		=> 'tb_print_form_select_field',
					'callback_args'	=> array(
						'options'	=> array('morning'=>'Morning','afernoon'=>'Afernoon','evening'=>'Evening'),
						'classes' => array('col-md-6'),
					),
					'required'		=> true,
				),
				'date_custom'		=> array(
					'title'			=> __( 'Date', 'restaurant-reservations' ),
					'request_input'	=> empty( $request->request_date ) ? '' : $request->request_date,
					'callback'		=> 'tb_print_form_text_field',
					'callback_args'	=> array(
						'classes' => array('col-md-6'),
					),
					'required'		=> true,
				),
				'service'		=> array(
					'title'			=> __( 'Service', 'restaurant-reservations' ),
					'request_input'	=> empty( $request->service ) ? '' : $request->service,
					'callback'		=> 'tb_print_form_select_field',
					'callback_args'	=> array(
						'options'	=> array('intake'=>'Intake-gesprek','refresh'=>'Refresh', 'uithalen' => 'Uithalen'),
						'classes' => array('col-md-6 clear'),
					),
					'required'		=> true,
				),
				'button'		=> array(
					'title'			=> __( 'Book', 'restaurant-reservations' ),
					'request_input'	=> '',
					'callback'		=> 'tb_rtb_print_form_submit_field',
					'callback_args'	=> array(
						'classes' => array('col-md-6'),
					),
				),
			),
		),
	);
	return $fields;
}

add_filter('rtb_insert_booking_metadata','tb_aqua_insert_booking_metadata',10,2);
function tb_aqua_insert_booking_metadata($meta, $book){
    $meta = array(
		'email' 			=> $book->email,
		'service' 			=> $book->service,
		'time_custom' 		=> $book->time_custom,
        'date_custom' 		=> $book->date_custom,
		'date_submission' 	=> current_time( 'timestamp' ),
	);
	//print_r($meta);die;
	return $meta;
}
add_filter('rtb_insert_booking_data','tb_rtb_insert_booking_data',10,2);
function tb_rtb_insert_booking_data($args, $book){
	$args['post_content'] = '';
	return $args;
}

add_filter('rtb_booking_form_submit_button','tb_rtb_booking_form_submit_button',10,1);
function tb_rtb_booking_form_submit_button($button){
	return null;
}

add_filter( 'rtb_validate_booking_submission', 'tb_custom_load', 10, 1 );
function tb_custom_load( $book ) {
	global $rtb_controller;
	$book->validation_errors = array();

	// Date
	$date = empty( $_POST['rtb-date_custom'] ) ? false : stripslashes_deep( $_POST['rtb-date_custom'] );
	if ( $date === false ) {
		$book->validation_errors[] = array(
			'field'		=> 'date',
			'error_msg'	=> 'Booking request missing date',
			'message'	=> __( 'Please enter the date you would like to book.', 'restaurant-reservations' ),
		);

	} else {
		try {
			$date = new DateTime( stripslashes_deep( $_POST['rtb-date_custom'] ) );
		} catch ( Exception $e ) {
			$book->validation_errors[] = array(
				'field'		=> 'date',
				'error_msg'	=> $e->getMessage(),
				'message'	=> __( 'The date you entered is not valid. Please select from one of the dates in the calendar.', 'restaurant-reservations' ),
			);
		}
	}

	// Check against valid open dates/times
	if (is_object( $date ) ) {

		$request = new DateTime( $date->format( 'Y-m-d' ));
		
		// Check against scheduling exception rules
		$exceptions = $rtb_controller->settings->get_setting( 'schedule-closed' );
		if ( empty( $book->validation_errors ) && !empty( $exceptions ) ) {
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
				$book->validation_errors[] = array(
					'field'		=> 'date',
					'error_msg'	=> 'Booking request made on invalid date or time in an exception rule',
					'message'	=> __( 'Sorry, no bookings are being accepted then.', 'restaurant-reservations' ),
				);
			}
		}

		// Check against weekly scheduling rules
		$rules = $rtb_controller->settings->get_setting( 'schedule-open' );
		if ( empty( $exception_is_active ) && empty( $book->validation_errors ) && !empty( $rules ) ) {
			$request_weekday = strtolower( $request->format( 'l' ) );
			$time_is_valid = true;
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
				$book->validation_errors[] = array(
					'field'		=> 'date',
					'error_msg'	=> 'Booking request made on an invalid date',
					'message'	=> __( 'Sorry, no bookings are being accepted on that date.', 'restaurant-reservations' ),
				);
			} elseif ( !$time_is_valid ) {
				$book->validation_errors[] = array(
					'field'		=> 'time',
					'error_msg'	=> 'Booking request made at an invalid time',
					'message'	=> __( 'Sorry, no bookings are being accepted at that time.', 'restaurant-reservations' ),
				);
			}
		}

		// Accept the date if it has passed validation
		if ( empty( $book->validation_errors ) ) {
			$book->date = $request->format( 'Y-m-d H:i:s' );
		}
	}

	// Save requested date/time values in case they need to be
	// printed in the form again
	$book->request_date = empty( $_POST['rtb-date_custom'] ) ? '' : stripslashes_deep( $_POST['rtb-date_custom'] );
	$book->service = empty( $_POST['rtb-service'] ) ? '' : stripslashes_deep( $_POST['rtb-service'] );
	$book->time_custom = empty( $_POST['rtb-time_custom'] ) ? '' : stripslashes_deep( $_POST['rtb-time_custom'] );	
    $book->date_custom = empty( $_POST['rtb-date_custom'] ) ? '' : stripslashes_deep( $_POST['rtb-date_custom'] );
	// Name
	$book->name = empty( $_POST['rtb-name'] ) ? '' : wp_strip_all_tags( sanitize_text_field( stripslashes_deep( $_POST['rtb-name'] ) ), true ); // @todo should I limit length?
	if ( empty( $book->name ) ) {
		$book->validation_errors[] = array(
			'field'			=> 'name',
			'post_variable'	=> $book->name,
			'message'	=> __( 'Please enter a name for this booking.', 'restaurant-reservations' ),
		);
	}

	// Email/Phone
	$book->email = empty( $_POST['rtb-email'] ) ? '' : sanitize_text_field( stripslashes_deep( $_POST['rtb-email'] ) ); // @todo email validation? send notification back to form on bad email address.
	if ( empty( $book->email ) ) {
		$book->validation_errors[] = array(
			'field'			=> 'email',
			'post_variable'	=> $book->email,
			'message'	=> __( 'Please enter an email address so we can confirm your booking.', 'restaurant-reservations' ),
		);
	}// Post Status (define a default post status is none passed)
	if ( !empty( $_POST['rtb-post-status'] ) && array_key_exists( $_POST['rtb-post-status'], $rtb_controller->cpts->booking_statuses ) ) {
		$book->post_status = sanitize_text_field( stripslashes_deep( $_POST['rtb-post-status'] ) );
	} else {
		$book->post_status = 'pending';
	}

	// Check if any required fields are empty
	$required_fields = $rtb_controller->settings->get_required_fields();
	foreach( $required_fields as $slug => $field ) {
		if ( !$book->field_has_error( $slug ) && $book->is_field_empty( $slug ) ) {
			$book->validation_errors[] = array(
				'field'			=> $slug,
				'post_variable'	=> '',
				'message'	=> __( 'Please complete this field to request a booking.', 'restaurant-reservations' ),
			);
		}
	}
    
	return $book;
}
