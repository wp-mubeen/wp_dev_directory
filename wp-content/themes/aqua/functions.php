<?php

/* Define THEME */

if (!defined('URI_PATH')) define('URI_PATH', get_template_directory_uri());

if (!defined('ABS_PATH')) define('ABS_PATH', get_template_directory());

if (!defined('URI_PATH_FR')) define('URI_PATH_FR', URI_PATH.'/framework');

if (!defined('ABS_PATH_FR')) define('ABS_PATH_FR', ABS_PATH.'/framework');

if (!defined('URI_PATH_ADMIN')) define('URI_PATH_ADMIN', URI_PATH_FR.'/admin');

if (!defined('ABS_PATH_ADMIN')) define('ABS_PATH_ADMIN', ABS_PATH_FR.'/admin');

/* Theme Options */

function tb_filtercontent($variable){

	return $variable;

}

if ( !class_exists( 'ReduxFramework' ) ) {

    require_once( ABS_PATH . '/redux-framework/ReduxCore/framework.php' );

}

require_once (ABS_PATH_ADMIN.'/theme-options.php');

require_once (ABS_PATH_ADMIN.'/index.php');

global $tb_options;

/* Template Functions */

require_once ABS_PATH_FR . '/template-functions.php';

/* Template Functions */

require_once ABS_PATH_FR . '/templates/post-favorite.php';

require_once ABS_PATH_FR . '/templates/post-functions.php';

/* Lib resize images */

require_once ABS_PATH_FR.'/includes/resize.php';

require_once ABS_PATH_FR.'/includes/custom-post-templates.php';

/* Post Type */

require_once ABS_PATH_FR.'/post-type/portfolio.php';

require_once ABS_PATH_FR.'/post-type/space.php';

require_once ABS_PATH_FR.'/post-type/testimonial.php';

require_once ABS_PATH_FR.'/post-type/team.php';

require_once ABS_PATH_FR.'/post-type/client.php';

/* Function for Framework */

require_once ABS_PATH_FR . '/includes.php';

/* Register Sidebar */

if (!function_exists('tb_RegisterSidebar')) {

	function tb_RegisterSidebar(){

		global $tb_options;

		register_sidebar(array(

			'name' => __('Right Sidebar', 'aqua'),

			'id' => 'tbtheme-right-sidebar',

			'before_widget' => '<div id="%1$s" class="widget %2$s">',

			'after_widget' => '</div>',

			'before_title' => '<h3 class="wg-title">',

			'after_title' => '</h3>',

		));

		register_sidebar(array(

			'name' => __('Left Sidebar', 'aqua'),

			'id' => 'tbtheme-left-sidebar',

			'before_widget' => '<div id="%1$s" class="widget %2$s">',

			'after_widget' => '</div>',

			'before_title' => '<h3 class="wg-title">',

			'after_title' => '</h3>',

		));

		register_sidebar(array(

			'name' => __('Single Basic', 'aqua'),

			'id' => 'tbtheme-single-basic',

			'before_widget' => '<div id="%1$s" class="widget %2$s">',

			'after_widget' => '</div>',

			'before_title' => '<h3 class="wg-title">',

			'after_title' => '</h3>',

		));

		register_sidebars(2,array(

			'name' => __('Header Top Widget %d', 'aqua'),

			'id' => 'tbtheme-header-top-widget',

			'before_widget' => '<div id="%1$s" class="widget %2$s">',

			'after_widget' => '<div style="clear:both;"></div></div>',

			'before_title' => '<h3 class="wg-title">',

			'after_title' => '</h3>',

		));

		register_sidebars(2,array(

			'name' => __('Header 2 Top Widget %d', 'aqua'),

			'id' => 'tbtheme-header-2-top-widget',

			'before_widget' => '<div id="%1$s" class="widget %2$s">',

			'after_widget' => '<div style="clear:both;"></div></div>',

			'before_title' => '<h3 class="wg-title">',

			'after_title' => '</h3>',

		));

		register_sidebars(2,array(

			'name' => __('Header 2 Widget %d', 'aqua'),

			'id' => 'tbtheme-header-2-widget',

			'before_widget' => '<div id="%1$s" class="widget %2$s">',

			'after_widget' => '<div style="clear:both;"></div></div>',

			'before_title' => '<h3 class="wg-title">',

			'after_title' => '</h3>',

		));

		register_sidebars(2,array(

			'name' => __('Header 3 Top Widget %d', 'aqua'),

			'id' => 'tbtheme-header-3-top-widget',

			'before_widget' => '<div id="%1$s" class="widget %2$s">',

			'after_widget' => '<div style="clear:both;"></div></div>',

			'before_title' => '<h3 class="wg-title">',

			'after_title' => '</h3>',

		));

		register_sidebars(4,array(

			'name' => __('Footer Top Widget %d', 'aqua'),

			'id' => 'tbtheme-footer-top-widget',

			'before_widget' => '<div id="%1$s" class="widget %2$s">',

			'after_widget' => '<div style="clear:both;"></div></div>',

			'before_title' => '<h3 class="wg-title">',

			'after_title' => '</h3>',

		));

		register_sidebars(2,array(

			'name' => __('Footer Bottom Widget %d', 'aqua'),

			'id' => 'tbtheme-footer-bottom-widget',

			'before_widget' => '<div id="%1$s" class="widget %2$s">',

			'after_widget' => '<div style="clear:both;"></div></div>',

			'before_title' => '<h3 class="wg-title">',

			'after_title' => '</h3>',

		));

		if (class_exists ( 'Woocommerce' )) {

			register_sidebar(array(

				'name' => __('Woocommerce Sidebar', 'aqua'),

				'id' => 'tbtheme-woo-sidebar',

				'before_widget' => '<div id="%1$s" class="widget %2$s">',

				'after_widget' => '</div>',

				'before_title' => '<h3 class="wg-title"><span>',

				'after_title' => '</span></h3>',

			));

			register_sidebar(array(

				'name' => __('Woocommerce Single Sidebar', 'aqua'),

				'id' => 'tbtheme-woo-single-sidebar',

				'before_widget' => '<div id="%1$s" class="widget %2$s">',

				'after_widget' => '</div>',

				'before_title' => '<h3 class="wg-title">',

				'after_title' => '</h3>',

			));

			register_sidebars(2,array(

				'name' => __('Header Shop Top Widget %d', 'aqua'),

				'id' => 'tbtheme-header-shop-top-widget',

				'before_widget' => '<div id="%1$s" class="widget %2$s">',

				'after_widget' => '<div style="clear:both;"></div></div>',

				'before_title' => '<h3 class="wg-title">',

				'after_title' => '</h3>',

			));

			register_sidebars(2,array(

				'name' => __('Header Shop Widget %d', 'aqua'),

				'id' => 'tbtheme-header-shop-widget',

				'before_widget' => '<div id="%1$s" class="widget %2$s">',

				'after_widget' => '<div style="clear:both;"></div></div>',

				'before_title' => '<h3 class="wg-title">',

				'after_title' => '</h3>',

			));

			register_sidebars(4,array(

				'name' => __('Custom Widget %d', 'aqua'),

				'id' => 'tbtheme-custom-widget',

				'before_widget' => '<div id="%1$s" class="widget %2$s">',

				'after_widget' => '<div style="clear:both;"></div></div>',

				'before_title' => '<h3 class="wg-title">',

				'after_title' => '</h3>',

			));

		}

	}

}

add_action( 'init', 'tb_RegisterSidebar' );

/* Add Stylesheet And Script */

function tb_theme_enqueue_style() {

	global $tb_options;

	if ($tb_options["tb_responsive"]) {

		wp_enqueue_style( 'bootstrap.min', URI_PATH.'/assets/css/bootstrap.min.css', false );

	}else{

		wp_enqueue_style( 'bootstrap-no-responsive', URI_PATH.'/assets/css/bootstrap-no-responsive.css', false );

	}

	wp_enqueue_style('flexslider.css', URI_PATH . "/assets/vendors/flexslider/flexslider.css",array(),"");

	wp_enqueue_style('jquery.mCustomScrollbar', URI_PATH . "/assets/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css",array(),"");

	wp_enqueue_style('jquery.fancybox', URI_PATH . "/assets/vendors/FancyBox/jquery.fancybox.css",array(),"");

	wp_enqueue_style('colorbox', URI_PATH . "/assets/css/colorbox.css",array(),"");

	wp_enqueue_style('font-awesome', URI_PATH.'/assets/css/font-awesome.min.css', array(), '4.1.0');

	wp_enqueue_style('font-ionicons', URI_PATH.'/assets/css/ionicons.min.css', array(), '1.5.2');

	wp_enqueue_style('font-aqua', URI_PATH.'/assets/css/font-aqua.css', array(), '');

	wp_enqueue_style('uikit.min', URI_PATH.'/assets/css/uikit.min.css', array(), '2.8.0');

	wp_enqueue_style( 'tb.core.min', URI_PATH.'/assets/css/tb.core.min.css', false );

	if(class_exists('WooCommerce')){

        wp_enqueue_style( 'woocommerce', URI_PATH . '/assets/css/woocommerce.css', array(), '1.0.0');

    }

	wp_enqueue_style( 'shortcodes', URI_PATH_FR.'/shortcodes/shortcodes.css', false );

	wp_enqueue_style( 'main-style', URI_PATH.'/assets/css/main-style.css', false );

	wp_enqueue_style( 'style', URI_PATH.'/style.css', false );	

}

add_action( 'wp_enqueue_scripts', 'tb_theme_enqueue_style' );



function tb_theme_enqueue_script() {

	wp_enqueue_script( 'jquery' );

	wp_enqueue_script( 'datepicker.min', URI_PATH.'/assets/js/datepicker.min.js', array('jquery'), '', true  );

	wp_enqueue_script( 'jquery.flexslider-min', URI_PATH.'/assets/vendors/flexslider/jquery.flexslider-min.js', array('jquery') );

	wp_enqueue_script( 'jquery.mCustomScrollbar', URI_PATH.'/assets/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.js', array('jquery') );

	wp_enqueue_script( 'jquery.fancybox', URI_PATH.'/assets/vendors/FancyBox/jquery.fancybox.js', array('jquery') );

	wp_enqueue_script( 'jquery.elevatezoom', URI_PATH.'/assets/vendors/elevatezoom-master/jquery.elevatezoom.js', array('jquery') );

	wp_enqueue_script( 'dotdotdot.min', URI_PATH.'/assets/js/jquery.dotdotdot.min.js', array('jquery') );

	wp_enqueue_script( 'bootstrap.min', URI_PATH.'/assets/js/bootstrap.min.js', array('jquery') );

	wp_enqueue_script('jquery.colorbox', URI_PATH . "/assets/js/jquery.colorbox.js", array('jquery'),"1.5.5");

	wp_enqueue_script( 'tb.shortcodes', URI_PATH_FR.'/shortcodes/shortcodes.js', array('jquery') );

	wp_enqueue_script( 'parallax', URI_PATH.'/assets/js/parallax.js', array('jquery') );

	wp_enqueue_script( 'uikit.min', URI_PATH.'/assets/js/uikit.min.js', array('jquery') );

	wp_enqueue_script( 'main', URI_PATH.'/assets/js/main.js', array('jquery') );

}

add_action( 'wp_enqueue_scripts', 'tb_theme_enqueue_script' );

/*Style Inline*/

require ABS_PATH_FR.'/style-inline.php';

/* Header */

function tb_Header() {

    global $tb_options,$post;

    $header_layout = $tb_options["tb_header_layout"];

    if($post){

        $tb_header = get_post_meta($post->ID, 'tb_header', true)?get_post_meta($post->ID, 'tb_header', true):'global';

        $header_layout = $tb_header=='global'?$header_layout:$tb_header;

    }

    switch ($header_layout) {

        case 'v1':

            get_template_part('framework/headers/header', 'v1');

            break;

        case 'v2':

            get_template_part('framework/headers/header', 'v2');

            break;

        case 'v3':

            get_template_part('framework/headers/header', 'v3');

            break;

        case 'shop':

            get_template_part('framework/headers/header', 'shop');

            break;

		default :

			get_template_part('framework/headers/header', 'v1');

			break;

    }

}

/* Less */

if(isset($tb_options['tb_less'])&&$tb_options['tb_less']){

    require_once ABS_PATH_FR.'/presets.php';

}

/* Widgets */

require_once ABS_PATH_FR.'/widgets/abstract-widget.php';

require_once ABS_PATH_FR.'/widgets/widgets.php';

/* Woo commerce function */

if (class_exists('Woocommerce')) {

    require_once ABS_PATH . '/woocommerce/wc-template-function.php';

    require_once ABS_PATH . '/woocommerce/wc-template-hooks.php';

}

// Hooks add play btn for editor

add_action('admin_init', 'tb_add_button_play');

function tb_add_button_play() {

	add_filter('mce_external_plugins', 'tb_add_plugin_play');

	add_filter('mce_buttons', 'tb_register_button_play');

}

function tb_register_button_play($buttons) {

   array_push($buttons, "btnplay");

   return $buttons;

}

function tb_add_plugin_play($plugin_array) {

   $plugin_array['btnplay'] = URI_PATH .'/assets/js/mce.btn.play.js';

   return $plugin_array;

}

/*-----------------------------------------------------------------------------------*/

/* Remove Unwanted Admin Menu Items */

/*-----------------------------------------------------------------------------------*/



function remove_admin_menu_items() {

	$remove_menu_items = array(__('Portfolios'),__('Portfolio'),__('Space'),__('Team'),__('Client'),__('Comments'),__('Posts'));

	global $menu;

	end ($menu);

	while (prev($menu)){

		$item = explode(' ',$menu[key($menu)][0]);

		if(in_array($item[0] != NULL?$item[0]:"" , $remove_menu_items)){

		unset($menu[key($menu)]);}

	}

}



add_action('admin_menu', 'remove_admin_menu_items');