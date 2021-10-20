<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
if (!defined('ABSPATH')) exit; // Exit if accessed directly
global $tb_options;
get_header('shop');
?>
<?php require('title-bar-shop.php'); ?>
<?php
	$cl_content = 'col-sx-12 col-sm-12 col-md-12 col-lg-12';
	$cl_sidebar = '';
	if (is_active_sidebar('tbtheme-woo-sidebar')) {
		
		$cl_content = 'col-sx-12 col-sm-12 col-md-9 col-lg-9 tb-content';
		$cl_sidebar = 'col-sx-12 col-sm-12 col-md-3 col-lg-3 tb-sidebar';
	}
	$tb_sidebar_pos = !empty($tb_options['tb_archive_sidebar_pos_shop'])?$tb_options['tb_archive_sidebar_pos_shop']:'tb-sidebar-right';
?>
<div class="archive-products">
	<div class="container">
		<div class="row <?php echo esc_attr($tb_sidebar_pos); ?>">
			<div class="<?php echo esc_attr($cl_content); ?>">

				<?php do_action('woocommerce_archive_description'); ?>

				<?php if (have_posts()) : ?>
					
					<?php if($tb_options['tb_archive_show_result_count']) woocommerce_result_count(); ?>
					
					<?php if($tb_options['tb_archive_show_catalog_ordering']) woocommerce_catalog_ordering(); ?>
					
					<?php woocommerce_product_loop_start(); ?>

					<?php woocommerce_product_subcategories(); ?>

					<?php while (have_posts()) : the_post(); ?>

						<?php wc_get_template_part('content', 'product'); ?>

					<?php endwhile; ?>

					<?php woocommerce_product_loop_end(); ?>

					<?php
					/**
					 * woocommerce_after_shop_loop hook
					 *
					 * @hooked woocommerce_pagination - 10
					 */
					if($tb_options['tb_archive_show_pagination_shop']) do_action('woocommerce_after_shop_loop');
					?>

				<?php elseif (!woocommerce_product_subcategories(array('before' => woocommerce_product_loop_start(false), 'after' => woocommerce_product_loop_end(false)))) : ?>

					<?php wc_get_template('loop/no-products-found.php'); ?>

				<?php endif; ?>

			</div>
			<?php if ($cl_sidebar) { ?>
				<div class="<?php echo esc_attr($cl_sidebar); ?>">
					<div id="secondary" class="widget-area" role="complementary">
						<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
							<?php dynamic_sidebar( 'tbtheme-woo-sidebar' ); ?>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</div>

<?php get_footer('shop'); ?>
