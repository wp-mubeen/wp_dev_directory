<?php
/*Header*/
function tb_header_transparent_style_inline() {
	global $post;
	$postid = isset($post->ID)?$post->ID:0;
	$tb_menu_color_header_transparent = get_post_meta($postid, 'tb_menu_color_header_transparent', true);
	$tb_background_color_menu_header_transparent = get_post_meta($postid, 'tb_background_color_menu_header_transparent', true);
	
	$tb_menu_color_header_transparent = ($tb_menu_color_header_transparent)? $tb_menu_color_header_transparent : "#FFF";
	$tb_background_color_menu_header_transparent = ($tb_background_color_menu_header_transparent)? $tb_background_color_menu_header_transparent : "transparent";	
	
	wp_enqueue_style('wp_custom_style', URI_PATH . '/assets/css/wp_custom_style.css',array('style'));
	$custom_style = ".tb-header-transparent.header-transparent-style{}
		.tb-header-transparent.header-transparent-style .menubar{ background: {$tb_background_color_menu_header_transparent}; }
		.tb-header-transparent.header-transparent-style .header-menu .menu-list.menu-tb > ul > li:after{ background: {$tb_menu_color_header_transparent}; }
		.tb-header-transparent.header-transparent-style .header-menu .menu-list.menu-tb > ul > li:last-child:after{ background: transparent; }
		.tb-header-transparent.header-transparent-style .header-menu .menu-list.menu-tb > ul > li > a{ color: {$tb_menu_color_header_transparent}; }
	";
	wp_add_inline_style( 'wp_custom_style', $custom_style );
}
add_action( 'wp_enqueue_scripts', 'tb_header_transparent_style_inline' );
/* Fonts */
function tb_add_style_inline() {
    global $tb_options;
    $custom_style = null;
    if (isset($tb_options['custom_css_code']) && $tb_options['custom_css_code'])  {
		$tb_options['custom_css_code'] = wp_filter_nohtml_kses(esc_attr($tb_options['custom_css_code'])); 
        $custom_style .= "{$tb_options['custom_css_code']}";
    }
    wp_enqueue_style('wp_custom_style', URI_PATH . '/assets/css/wp_custom_style.css',array('style'));
    wp_add_inline_style( 'wp_custom_style', $custom_style );
    /*End Font*/
}
add_action( 'wp_enqueue_scripts', 'tb_add_style_inline' );