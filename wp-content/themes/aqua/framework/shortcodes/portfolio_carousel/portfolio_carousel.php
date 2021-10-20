<?php
function tb_portfolio_carousel_render($atts, $content = null) {
	global $post;
	extract(shortcode_atts(array(
		'post_type' => 'portfolio',
		'category' => '',
		'tpl'=> 'default',
		'crop_image' => 0,
		'width_image' => 300,
		'height_image' => 200,
		
		'items' => '5',
		'itemsdesktop' => '[1199,4]',
		'itemsdesktopsmall' => '[979,3]',
		'itemstablet' => '[768,3]',
		'itemstabletsmall' => false,
		'itemsmobile' => '[479,1]',
		'itemscustom' => false,
		'singleitem' => false,
		'itemsscaleup' => true,
		'slidespeed' => 200,
		'paginationspeed' => 800,
		'rewindspeed' => 1000,
		'autoplay' => false,
		'stoponhover' => false,
		'navigation' => false,
		'navigationtext' => '["prev","next"]',
		'rewindnav' => true,
		'scrollperpage' => false,
		'pagination' => true,
		'paginationwrapper' => '',
		'paginationnumbers' => false,
		'responsive' => true,
		'responsiverefreshrate' => 200,
		'responsivebasewidth' => 'window',
		'baseclass' => "owl-carousel",
		'theme' => "owl-theme",
		'lazyload' => false,
		'lazyfollow' => true,
		'lazyeffect' => "fade",
		'autoheight' => false,
		'mousedrag' => true,
		'touchdrag' => true,
		'addclassactive' => true,
		
		'height' => '450px',
		'itemwidth' => '260',
		'itemheight' => '260',
		'gradientoverlayvisible' => true,
		'gradientoverlaycolor' => '#e5e5e5',
		'gradientoverlaysize' => 215,
		'autoslideshow' => false,
		'autoslideshowdelay' => 2.5,
		'reflectionvisible' => false,
		'enablemousewheel' => false,
		'distance' => 15,
		'startindex' => 'auto',
		'selecteditemdistance' => 75,
		'selecteditemzoomfactor' => 1.0,
		'unselecteditemzoomfactor' => 0.6,
		'unselecteditemalpha' => 0.6,
		'topmargin' => 30,
		'slidespeed' => 0.45,
		
		'show_image' => 1,
		'show_title' => 0,
		'show_tooltip' => 0,
		'show_info' => 0,
		'show_description' => 0,
		'excerpt_length' => 20,
		'excerpt_more'  => '...',
		'read_more' => '',
		'rows' => 1,
		'posts_per_page' => 12,
		'orderby' => 'none',
		'order' => 'none',
		'el_class' => ''
	), $atts));
	$data_attr = "";
	$el_class .= " $post_type";
	$not_in_attrs = array("post_type", "category", "tpl", "crop_image", "height", "show_image", "show_title", "show_tooltip", "show_info", "show_description", "excerpt_length", "excerpt_more", "read_more", "rows", "posts_per_page", "orderby", "order", "el_class");
    foreach ($atts as $key => $value) {
        if (!in_array($key,$not_in_attrs)) {
            $data_attr .= ' data-' . $key . '="' . $value . '" ';
        }
    }
	$args = array(
		'posts_per_page' => $posts_per_page,
		'orderby' => $orderby,
		'order' => $order,
		'post_type' => $post_type,
		'post_status' => 'publish');
	if (isset($category) && $category != '') {
		$cats = explode(',', $category);
		$category = array();
		foreach ((array) $cats as $cat) :
		$category[] = trim($cat);
		endforeach;
		$args['tax_query'] = array(
							array(
								'taxonomy' => 'portfolio_category',
								'field' => 'id',
								'terms' => $category
							)
						);
	}
	$wp_query = new WP_Query($args);
	$uniqid = uniqid('carousel'); 
	ob_start();	
	if($tpl=='improved'||$tpl=='default'):
		wp_enqueue_style('owl.carousel', URI_PATH . '/assets/css/owl.carousel.css',array(),'1.0.0',false);
		wp_enqueue_style('owl.transitions', URI_PATH . '/assets/css/owl.transitions.css',array(),'1.0.0',false);
	endif;	
	if($tpl=='default'):
		wp_enqueue_script('owl.carousel.min', URI_PATH . '/assets/js/owl.carousel.min.js');
	endif;
	if($tpl=='improved'):
		wp_enqueue_script('owl.carousel.improved', URI_PATH . '/assets/js/owl.carousel.improved.js');
	endif;
	if($tpl=='sky'):
		wp_enqueue_script('sky.carousel', URI_PATH . '/assets/js/jquery.sky.carousel-1.0.2.min.js');
		wp_enqueue_style('tooltip_skin_variation', URI_PATH . '/assets/css/tooltip_skin_variation.css',array(),'1.0.0',false);
	endif;
	wp_enqueue_script('tb.carousel', URI_PATH . '/assets/js/tb.carousel.js');
	include ABS_PATH."/framework/shortcodes/portfolio_carousel/tpl/{$tpl}.php";
    wp_reset_postdata();
    return ob_get_clean();
}
if(function_exists('insert_shortcode')) {
	insert_shortcode('tb_portfolio_carousel', 'tb_portfolio_carousel_render');
}