<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $tb_options;
get_header( 'shop' ); ?>
<?php require('title-bar-shop.php'); ?>
<?php
	$cl_content = 'col-sx-12 col-sm-12 col-md-12 col-lg-12';
	$cl_sidebar = '';
	if(is_active_sidebar( 'tbtheme-woo-single-sidebar' )){
		$cl_content = 'col-sx-12 col-sm-12 col-md-9 col-lg-9 tb-content';
		$cl_sidebar = 'col-sx-12 col-sm-12 col-md-3 col-lg-3 tb-sidebar';
	}
	$tb_sidebar_pos = !empty($tb_options['tb_single_sidebar_pos_shop'])?$tb_options['tb_single_sidebar_pos_shop']:'tb-sidebar-right';
?>
<div class="single-product">
	<div class="container">
		<div class="row <?php echo esc_attr($tb_sidebar_pos); ?>">
			<div class="<?php echo esc_attr($cl_content); ?>">
				
				<?php while ( have_posts() ) : the_post(); ?>

				<?php wc_get_template_part( 'content', 'single-product' ); ?>

				<?php endwhile; // end of the loop. ?>
				
			</div>
			<?php if($cl_sidebar) { ?>
			<div class="<?php echo esc_attr($cl_sidebar); ?>">
				<div id="secondary" class="widget-area" role="complementary">
					<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
						<?php dynamic_sidebar( 'tbtheme-woo-single-sidebar' ); ?>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>

<?php get_footer( 'shop' ); ?>
