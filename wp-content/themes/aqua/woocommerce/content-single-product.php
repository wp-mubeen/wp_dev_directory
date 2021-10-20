<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $tb_options;
?>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if($tb_options['tb_single_show_sale_flash_product']) do_action('woocommerce_show_product_sale_flash'); ?>
	<?php do_action('woocommerce_show_product_images'); ?>

	<div class="ro-product-wrapper">
		<div class="summary entry-summary ro-product-information">

			<?php if($tb_options['tb_single_show_title_product']) do_action( 'woocommerce_template_single_title' ); ?>
			
			<?php if($tb_options['tb_single_show_price_product']) do_action( 'woocommerce_template_single_price' ); ?>
			
			<?php if($tb_options['tb_single_show_rating_product']) do_action( 'woocommerce_template_single_rating' ); ?>
			
			<?php if($tb_options['tb_single_show_add_to_cart_product']) do_action( 'woocommerce_template_single_add_to_cart' ); ?>
		
			<?php if($tb_options['tb_single_show_excerpt']) do_action( 'woocommerce_template_single_excerpt' ); ?>
			
			<?php if($tb_options['tb_single_show_meta']) do_action( 'woocommerce_template_single_meta' ); ?>
			
		</div><!-- .summary -->
	</div>
	<div style="clear:both;"></div>
	
	<?php if($tb_options['tb_single_show_data_tabs']) do_action( 'woocommerce_output_product_data_tabs' ); ?>
	
	<?php if($tb_options['tb_single_show_upsell_display']) do_action( 'woocommerce_upsell_display' ); ?>
	
	<?php if($tb_options['tb_single_show_related_products']) do_action( 'woocommerce_output_related_products' ); ?>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
