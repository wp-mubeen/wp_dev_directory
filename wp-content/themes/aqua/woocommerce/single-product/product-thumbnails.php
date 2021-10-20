<?php
/**
 * Single Product Thumbnails
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product, $woocommerce;

$attachment_ids = $product->get_gallery_attachment_ids();

if ( $attachment_ids ) {
	?>
	<div class="col-md-3 col-sm-3 col-xs-12 ro-product-option-wrapper">
		<div data-mcs-theme="minimal-dark" id="Ro_gallery_0" class="ro-product-option mCustomScrollbar"><?php
			
			foreach ( $attachment_ids as $attachment_id ) {

				$image_link = wp_get_attachment_url( $attachment_id );

				if ( ! $image_link )
					continue;

				$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'thumbnail' ) );
				
				echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="#" data-image="%s" data-zoom-image="%s">%s</a>', $image_link, $image_link, $image ), $attachment_id, $post->ID, $image_class );

			}

		?></div>
	</div>
	<?php
}
