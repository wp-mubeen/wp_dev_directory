<?php
/**
 * Breadcrumbs
 *
 * @see woocommerce_breadcrumb()
 */
add_action( 'woocommerce_breadcrumb', 'woocommerce_breadcrumb', 20, 0 );
/**
 * Product Loop Items
 *
 * @see woocommerce_template_loop_add_to_cart()
 * @see woocommerce_template_loop_product_thumbnail()
 * @see woocommerce_template_loop_price()
 * @see woocommerce_template_loop_rating()
 */
add_action( 'woocommerce_template_loop_add_to_cart', 'woocommerce_template_loop_add_to_cart', 10 );
add_action( 'woocommerce_template_loop_add_to_cart_2', 'woocommerce_template_loop_add_to_cart_2', 10 );
add_action( 'woocommerce_template_loop_product_thumbnail', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_template_loop_price', 'woocommerce_template_loop_price', 10 );
add_action( 'woocommerce_template_loop_rating', 'woocommerce_template_loop_rating', 5 );
/**
 * Sale flashes
 *
 * @see woocommerce_show_product_loop_sale_flash()
 * @see woocommerce_show_product_sale_flash()
 */
add_action( 'woocommerce_show_product_loop_sale_flash', 'woocommerce_show_product_loop_sale_flash', 10 );
add_action( 'woocommerce_show_product_sale_flash', 'woocommerce_show_product_sale_flash', 10 );
/**
 * Breadcrumbs
 *
 * @see tb_woocommerce_breadcrumb()
 */
add_filter( 'woocommerce_breadcrumb_defaults', 'tb_woocommerce_breadcrumb_defaults', 20, 1 );
/**
 * Products Loop
 *
 * @see woocommerce_result_count()
 * @see woocommerce_catalog_ordering()
 * @see woocommerce_reset_loop()
 */
add_action( 'woocommerce_result_count', 'woocommerce_result_count', 20 );
add_action( 'woocommerce_catalog_ordering', 'woocommerce_catalog_ordering', 30 );
/**
 * Before Single Products Summary Div
 *
 * @see woocommerce_show_product_images()
 * @see woocommerce_show_product_thumbnails()
 */
add_action( 'woocommerce_show_product_images', 'woocommerce_show_product_images', 20 );
add_action( 'woocommerce_show_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
/**
 * Product Summary Box
 *
 * @see woocommerce_template_single_title()
 * @see woocommerce_template_single_price()
 * @see woocommerce_template_single_excerpt()
 * @see woocommerce_template_single_meta()
 * @see woocommerce_template_single_sharing()
 */
add_action( 'woocommerce_template_single_title', 'woocommerce_template_single_title', 5 );
add_action( 'woocommerce_template_single_rating', 'woocommerce_template_single_rating', 10 );
add_action( 'woocommerce_template_single_price', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_template_single_excerpt', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_template_single_meta', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_template_single_sharing', 'woocommerce_template_single_sharing', 50 );
/**
 * Product Add to cart
 *
 * @see woocommerce_template_single_add_to_cart()
 * @see woocommerce_simple_add_to_cart()
 * @see woocommerce_grouped_add_to_cart()
 * @see woocommerce_variable_add_to_cart()
 * @see woocommerce_external_add_to_cart()
 */
add_action( 'woocommerce_template_single_add_to_cart', 'woocommerce_template_single_add_to_cart', 30 );
add_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
add_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
add_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );
add_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );
/**
 * After Single Products Summary Div
 *
 * @see woocommerce_output_product_data_tabs()
 * @see woocommerce_upsell_display()
 * @see woocommerce_output_related_products()
 */
add_action( 'woocommerce_output_product_data_tabs', 'woocommerce_output_product_data_tabs', 10 );
add_action( 'woocommerce_upsell_display', 'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_output_related_products', 'woocommerce_output_related_products', 20 );

/**
 * Checkout
 *
 * @see woocommerce_checkout_login_form()
 * @see woocommerce_checkout_coupon_form()
 * @see woocommerce_order_review()
 */
add_action( 'woocommerce_checkout_login_form', 'woocommerce_checkout_login_form', 10 );
add_action( 'woocommerce_checkout_coupon_form', 'woocommerce_checkout_coupon_form', 10 );
add_action( 'woocommerce_order_review', 'woocommerce_order_review', 10 );
add_action( 'woocommerce_checkout_payment', 'woocommerce_checkout_payment', 20 );

