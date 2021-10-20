<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop, $tb_options;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;
//Set columns
$columns = 3;
if (is_active_sidebar('tbtheme-woo-sidebar')) {
	$columns = 2;
}
// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', $columns );

$class_columns = null;
switch ($woocommerce_loop['columns']) {
    case 1: $class_columns = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
        break;
    case 2: $class_columns = 'col-xs-12 col-sm-6 col-md-6 col-lg-6';
        break;
    case 3: $class_columns = 'col-xs-12 col-sm-4 col-md-4 col-lg-4';
        break;
    case 4: $class_columns = 'col-xs-12 col-sm-3 col-md-3 col-lg-3';
        break;
    default: $class_columns = 'col-xs-12 col-sm-3 col-md-3 col-lg-3';
        break;
}
$class_columns .= ' tb-product-item';
// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

$start_row = $end_row = '';

// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] ){
    $classes[] = 'first';
    $start_row = 1;
}

if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] ){
    $classes[] = 'last';
    $end_row = 1;
}
?>
<?php if($start_row) echo '<div class="row tb-product-items">' ?>
	<div class="<?php echo tb_filtercontent($class_columns); ?>">
		<article <?php post_class( $classes ); ?>>
			
			<div class="tb-product-item-inner">
				
				<?php if($tb_options['tb_archive_show_sale_flash_product']) do_action( 'woocommerce_show_product_loop_sale_flash' ); ?>
				
				<div class="tb-item-content-image">
				
					<?php do_action( 'woocommerce_template_loop_product_thumbnail' ); ?>
					
				</div>
				<div class="tb-item-content-info">
					<div class="tb-item-content-info-inner">
						<?php if($tb_options['tb_archive_show_title_product']){ ?>
							<a href="<?php the_permalink(); ?>"><?php the_title( '<h3 class="text-ellipsis">', '</h3>' ); ?></a>
						<?php } ?>
						
						<?php if($tb_options['tb_archive_show_price_product']) do_action( 'woocommerce_template_loop_price' ); ?>
						
						<?php if($tb_options['tb_archive_show_rating_product']){ do_action( 'woocommerce_template_loop_rating' ); } ?>
						
						<?php if($tb_options['tb_archive_show_add_to_cart_product']) do_action( 'woocommerce_template_loop_add_to_cart' ); ?>
					</div>
				</div>
			</div>

		</article>
	</div>
<?php if($end_row) echo '</div>' ?>