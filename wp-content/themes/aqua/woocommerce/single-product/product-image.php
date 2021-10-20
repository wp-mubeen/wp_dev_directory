<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $woocommerce, $product;

$attachment_ids = $product->get_gallery_attachment_ids();

$cl_img = 'col-md-12 col-sm-12 col-xs-12';
if ( $attachment_ids ) $cl_img = 'col-md-9 col-sm-9 col-xs-12';
?>
<div class="images row ro-product-wrapper">
	<div class="<?php echo esc_attr($cl_img); ?>">
		<div class="ro-product-image">
			<div id="Ro_zoom_image" class="ro-image">
			<?php
				if ( has_post_thumbnail() ) {

					$image_title 	= esc_attr( get_the_title( get_post_thumbnail_id() ) );
					$image_caption 	= get_post( get_post_thumbnail_id() )->post_excerpt;
					$image_link  	= wp_get_attachment_url( get_post_thumbnail_id() );
					$image       	= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
						'title'	=> $image_title,
						'alt'	=> $image_title
						) );

					$attachment_count = count( $product->get_gallery_attachment_ids() );

					if ( $attachment_count > 0 ) {
						$gallery = '[product-gallery]';
					} else {
						$gallery = '';
					}
                    echo'<img src="'.esc_url($image_link).'" alt="">';
					//echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '%s', $image ), $post->ID );

				} else {

					echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce' ) ), $post->ID );

				}
			?>
			</div>
		</div>
	</div>
	
	<?php do_action( 'woocommerce_product_thumbnails' ); ?>

</div>
