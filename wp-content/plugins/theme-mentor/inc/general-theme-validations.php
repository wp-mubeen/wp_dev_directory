<?php

/**
 * Class for all static validations to be covered by regex
 * @author nofearinc
 *
 */
class General_Theme_Validations {
	public $template_validations = array();
	public $include_validations = array();
	public $common_validations = array();
	
	public function __construct() {
		$this->common_validations = array(
			'/<script/' => __( 'Script tags should be included on wp_enqueue_scripts or admin_enqueue_scripts instead of embedded directly', 'dx_theme_mentor' ),
			'/<link(.+)style/' => __( 'Styles should be included on wp_enqueue_scripts or admin_enqueue_scripts instead of embedded directly', 'dx_theme_mentor' ),
			// '/<.id=(.*)>/' => 'id check',
			'/query_posts\(/' => __( 'Usage of query_posts is discouraged, use a WP_Query instance instead. ', 'dx_theme_mentor' ),
			'/Wordpress|WORDPRESS/' => __( 'The only possible spelling of WordPress is with capital W and capital P. ', 'dx_theme_mentor' ),
			'/wp_deregister_script\([\'"\s]+jquery[\'"\s]+\)/' => __('Don\'t you dare to deregister jQuery without a very solid and valid reason.', 'dx_theme_mentor'),
			'/wp_dequeue_script\([\'"\s]+jquery[\'"\s]+\)/' => __('Do not dequeue jQuery without a very solid and valid reason.', 'dx_theme_mentor'),
			'/global \$data/' => __('If you intend to use global variables, use a proper unique naming and prefix them properly.', 'dx_theme_mentor'),
		);
	}
}