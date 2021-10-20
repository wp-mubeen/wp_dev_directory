<?php
function tb_products_carousel_render($atts) {
    extract(shortcode_atts(array(
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
		
		'post_type' 		=> 'product',
		'tpl'				=> 'default',
		'product_cat'       => '',
        'show'              => 'all_products',
        'number'            => -1,
		'rows'				=> 1,
        'show_title'        => 0,
        'show_price'        => 0,
        'show_rating'       => 0,
        'show_category'     => 0,
        'show_add_to_cart'  => 0,
        'orderby'           => 'none',
        'order'             => 'none',
        'hide_free'         => 0,
        'show_hidden'       => 0,
		'el_class' => ''
    ), $atts));

	$data_attr = "";
	$el_class .= " $post_type";
	$not_in_attrs = array("height", "post_type", "tpl", "product_cat", "show", "number", "rows", "show_title", "show_price", "show_rating", "show_category", "show_add_to_cart", "orderby", "order", "hide_free", "show_hidden", "el_class");
    foreach ($atts as $key => $value) {
        if (!in_array($key,$not_in_attrs)) {
            $data_attr .= ' data-' . $key . '="' . $value . '" ';
        }
    }
	
    $query_args = array(
            'posts_per_page' => $number,
            'post_status' 	 => 'publish',
            'post_type' 	 => $post_type,
            'no_found_rows'  => 1,
            'order'          => $order == 'asc' ? 'asc' : 'desc'
    );

    $query_args['meta_query'] = array();

    if ( empty( $show_hidden ) ) {
                    $query_args['meta_query'][] = WC()->query->visibility_meta_query();
                    $query_args['post_parent']  = 0;
            }

            if ( ! empty( $hide_free ) ) {
            $query_args['meta_query'][] = array(
                        'key'     => '_price',
                        'value'   => 0,
                        'compare' => '>',
                        'type'    => 'DECIMAL',
                    );
    }

    $query_args['meta_query'][] = WC()->query->stock_status_meta_query();
    $query_args['meta_query']   = array_filter( $query_args['meta_query'] );

    if (isset($product_cat) && $product_cat != '') {
        $cats = explode(',', $product_cat);
        $product_cat = array();
        foreach ((array) $cats as $cat) :
        $category[] = trim($cat);
        endforeach;

        $args['tax_query'] = array(
                    array(
                            'taxonomy' 		=> 'product_cat',
                            'terms' 		=> $category,
                            'field' 		=> 'id',
                            'operator' 		=> 'IN'
                    )
        );
    }
    switch ( $show ) {
            case 'featured' :
                    $query_args['meta_query'][] = array(
                                    'key'   => '_featured',
                                    'value' => 'yes'
                            );
                    break;
            case 'onsale' :
                    $product_ids_on_sale = wc_get_product_ids_on_sale();
                            $product_ids_on_sale[] = 0;
                            $query_args['post__in'] = $product_ids_on_sale;
                    break;
    }

    switch ( $orderby ) {
			case 'price' :
					$query_args['meta_key'] = '_price';
			$query_args['orderby']  = 'meta_value_num';
					break;
			case 'rand' :
			$query_args['orderby']  = 'rand';
					break;
			case 'sales' :
					$query_args['meta_key'] = 'total_sales';
			$query_args['orderby']  = 'meta_value_num';
					break;
			default :
					$query_args['orderby']  = 'date';
    }

    $wp_query = new WP_Query( $query_args );
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
	include ABS_PATH."/framework/shortcodes/product_carousel/tpl/{$tpl}.php";
    wp_reset_postdata();
    return ob_get_clean();
}

if(function_exists('insert_shortcode')) { insert_shortcode('tb-products-carousel', 'tb_products_carousel_render'); }
