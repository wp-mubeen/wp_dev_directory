<?php
add_theme_support( 'woocommerce' );

/** Template pages ********************************************************/

if (!function_exists('tb_woocommerce_content')) {
    
    function tb_woocommerce_content() {

        if (is_singular('product')) {
            wc_get_template_part('single', 'product');
        } else {
            wc_get_template_part('archive', 'product');
        }
    }

}
/**
* Change number of related products on product page
* Set your own value for 'posts_per_page'
*/ 
add_filter( 'woocommerce_output_related_products_args', 'tb_related_products_args' );
function tb_related_products_args( $args ) {
    $columns = 6;
    if (is_active_sidebar('tbtheme-woo-single-sidebar'))
        $columns = 4;
    $args['posts_per_page'] = $columns; // 4 related products
    $args['columns'] = $columns; // arranged in 4 columns
    return $args;
}
/**
* Change number of upsell display products on product page
* Set your own value for 'posts_per_page'
*/ 
function woocommerce_upsell_display( $posts_per_page = 4, $columns = 4, $orderby = 'rand' ) {
    if (is_active_sidebar('tbtheme-woo-single-sidebar'))
        $columns = 3;
	$posts_per_page = $columns;
	woocommerce_get_template( 'single-product/up-sells.php', array(
		'posts_per_page' => $posts_per_page,
		'orderby' => $orderby,
		'columns' => $columns
	) );
}
if ( ! function_exists( 'tb_woocommerce_page_title' ) ) {

	/**
	 * woocommerce_page_title function.
	 *
	 * @param  boolean $echo
	 * @return string
	 */
	function tb_woocommerce_page_title() {

		if ( is_search() ) {
			$page_title = sprintf( __( 'Search Results: &ldquo;%s&rdquo;', 'woocommerce' ), get_search_query() );

			if ( get_query_var( 'paged' ) )
				$page_title .= sprintf( __( '&nbsp;&ndash; Page %s', 'woocommerce' ), get_query_var( 'paged' ) );

		} elseif ( is_tax() ) {

			$page_title = single_term_title( "", false );

		} elseif ( is_archive() ) {

			$page_title = __( 'Archives Products', 'woocommerce' );

		} elseif ( is_single() ) {

			$page_title = __( 'Single Product', 'woocommerce' );

		} else {

			$shop_page_id = wc_get_page_id( 'shop' );
			$page_title   = get_the_title( $shop_page_id );

		}
		
		return $page_title;
	}
}
if ( ! function_exists( 'tb_woocommerce_breadcrumb_defaults' ) ) {

	/**
	 * Output the WooCommerce Breadcrumb
	 *
	 * @access public
	 * @return void
	 */
	function tb_woocommerce_breadcrumb_defaults( $args = array() ) {
		global $tb_options;
		$delimiter = isset($tb_options['tb_page_breadcrumb_delimiter']) ? $tb_options['tb_page_breadcrumb_delimiter'] : '/';
		$args['delimiter']   = ' '.$delimiter.' ';
		return $args;
	}
}
if ( ! function_exists( 'tb_woocommerce_sharing' ) ) {

	function tb_woocommerce_sharing() {
		global $product;
		$permalink = $product->post->guid;
		$title = $product->post->post_title;
		
		$content = '<div class="tb-social-buttons"> 
						<a class="icon-fb" href="https://www.facebook.com/sharer/sharer.php?u='.$permalink.'"
							 onclick="window.open(this.href, \'facebook-share\',\'width=580,height=296\');return false;">
							<span>Facebook</span>
						</a> 
						<a class="icon-twitter" href="http://twitter.com/share?text='.$title.'&url='.$permalink.'"
							onclick="window.open(this.href, \'twitter-share\', \'width=550,height=235\');return false;">
							<span>Twitter</span>
						</a>
						<a class="icon-gplus" href="https://plus.google.com/share?url='.$permalink.'"
						   onclick="window.open(this.href, \'google-plus-share\', \'width=490,height=530\');return false;">
							<span>Google+</span>
						</a>
					</div>';

		echo tb_filtercontent($content);
	}
}
/*Custom add to cart style 2*/
if ( ! function_exists( 'woocommerce_template_loop_add_to_cart_2' ) ) {

	/**
	 * Get the add to cart template for the loop.
	 *
	 * @subpackage	Loop
	 */
	function woocommerce_template_loop_add_to_cart_2( $args = array() ) {
		wc_get_template( 'loop/add-to-cart_2.php' , $args );
	}
}
