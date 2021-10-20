<?php
/**
 * Review order table
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="ro-checkout-summary">
	<div class="ro-title">
	  <h4>ORDER SUMMARY</h4>
	</div>
	<div class="ro-body">
		<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					?>
					<div class="ro-item">
						<div class="ro-image">
							<?php
							$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

							if ( ! $_product->is_visible() )
								echo do_shortcode( $thumbnail );
							else
								printf( '<a href="%s">%s</a>', $_product->get_permalink( $cart_item ), $thumbnail );
							?>
						</div>
						<div>
							<div class="ro-name"> 
								<?php
									if ( ! $_product->is_visible() )
										echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;';
									else
										echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s </a>', $_product->get_permalink( $cart_item ), $_product->get_title() ), $cart_item, $cart_item_key );

									// Meta data
									echo WC()->cart->get_item_data( $cart_item );

									// Backorder notification
									if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) )
										echo '<p class="backorder_notification">' . __( 'Available on backorder', 'woocommerce' ) . '</p>';
								?>
							</div>
						</div>
						<div>
							<div class="ro-price">
								<?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); ?>
							</div>
							<div class="ro-quantity">
								<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times; %s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); ?>
							</div>
							<div class="product-total">
								<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
							</div>
						</div>
					</div>
					<?php
				}
			}
		?>
		
	</div>
	<div class="ro-footer">
		<div>
			<p><?php _e('Subtotal', 'woocommerce'); ?><span><?php wc_cart_totals_subtotal_html(); ?></span></p>
			<div class="ro-divide"></div>
		</div>
		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<div class="cart-discount coupon-<?php echo esc_attr( $code ); ?>">
				<p><?php wc_cart_totals_coupon_label( $coupon ); ?><span><?php wc_cart_totals_coupon_html( $coupon ); ?></span></p>
				<div class="ro-divide"></div>
			</div>
		<?php endforeach; ?>
		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<div class="shipping">
				<p>
					<?php
						if ( $show_package_details ) {
							printf( __( 'Shipping #%d', 'woocommerce' ), $index + 1 );
						} else {
							_e( 'Shipping', 'woocommerce' );
						}
					?>
					<div class="ro-shipping-method">
						<?php if ( ! empty( $available_methods ) ) : ?>

							<?php if ( 1 === count( $available_methods ) ) :
								$method = current( $available_methods );

								echo wp_kses_post( wc_cart_totals_shipping_method_label( $method ) ); ?>
								<input type="hidden" name="shipping_method[<?php echo $index; ?>]" data-index="<?php echo $index; ?>" id="shipping_method_<?php echo $index; ?>" value="<?php echo esc_attr( $method->id ); ?>" class="shipping_method" />

							<?php elseif ( get_option( 'woocommerce_shipping_method_format' ) === 'select' ) : ?>

								<select name="shipping_method[<?php echo $index; ?>]" data-index="<?php echo $index; ?>" id="shipping_method_<?php echo $index; ?>" class="shipping_method">
									<?php foreach ( $available_methods as $method ) : ?>
										<option value="<?php echo esc_attr( $method->id ); ?>" <?php selected( $method->id, $chosen_method ); ?>><?php echo wp_kses_post( wc_cart_totals_shipping_method_label( $method ) ); ?></option>
									<?php endforeach; ?>
								</select>

							<?php else : ?>

								<ul id="shipping_method">
									<?php foreach ( $available_methods as $method ) : ?>
										<li>
											<input type="radio" name="shipping_method[<?php echo $index; ?>]" data-index="<?php echo $index; ?>" id="shipping_method_<?php echo $index; ?>_<?php echo sanitize_title( $method->id ); ?>" value="<?php echo esc_attr( $method->id ); ?>" <?php checked( $method->id, $chosen_method ); ?> class="shipping_method" />
											<label for="shipping_method_<?php echo $index; ?>_<?php echo sanitize_title( $method->id ); ?>"><?php echo wp_kses_post( wc_cart_totals_shipping_method_label( $method ) ); ?></label>
										</li>
									<?php endforeach; ?>
								</ul>

							<?php endif; ?>

						<?php elseif ( ! WC()->customer->get_shipping_state() || ! WC()->customer->get_shipping_postcode() ) : ?>

							<?php if ( is_cart() && get_option( 'woocommerce_enable_shipping_calc' ) === 'yes' ) : ?>

								<p><?php _e( 'Please use the shipping calculator to see available shipping methods.', 'woocommerce' ); ?></p>

							<?php elseif ( is_cart() ) : ?>

								<p><?php _e( 'Please continue to the checkout and enter your full address to see if there are any available shipping methods.', 'woocommerce' ); ?></p>

							<?php else : ?>

								<p><?php _e( 'Please fill in your details to see available shipping methods.', 'woocommerce' ); ?></p>

							<?php endif; ?>

						<?php else : ?>

							<?php if ( is_cart() ) : ?>

								<?php echo apply_filters( 'woocommerce_cart_no_shipping_available_html',
									'<p>' . __( 'There are no shipping methods available. Please double check your address, or contact us if you need any help.', 'woocommerce' ) . '</p>'
								); ?>

							<?php else : ?>

								<?php echo apply_filters( 'woocommerce_no_shipping_available_html',
									'<p>' . __( 'There are no shipping methods available. Please double check your address, or contact us if you need any help.', 'woocommerce' ) . '</p>'
								); ?>

							<?php endif; ?>

						<?php endif; ?>

						<?php if ( $show_package_details ) : ?>
							<?php
								foreach ( $package['contents'] as $item_id => $values ) {
									if ( $values['data']->needs_shipping() ) {
										$product_names[] = $values['data']->get_title() . ' &times;' . $values['quantity'];
									}
								}

								echo '<p class="woocommerce-shipping-contents"><small>' . __( 'Shipping', 'woocommerce' ) . ': ' . implode( ', ', $product_names ) . '</small></p>';
							?>
						<?php endif; ?>

						<?php if ( is_cart() ) : ?>
							<?php woocommerce_shipping_calculator(); ?>
						<?php endif; ?>
					</div>
				</p>
				<div class="clearfix"></div>
				<div class="ro-divide"></div>
			</div>

		<?php endif; ?>
		
		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<div class="fee">
				<p><?php echo esc_html( $fee->name ); ?><span><?php wc_cart_totals_fee_html( $fee ); ?></span></p>
				<div class="ro-divide"></div>
			</div>
		<?php endforeach; ?>
		
		<?php if ( WC()->cart->tax_display_cart === 'excl' ) : ?>
			<?php if ( get_option( 'woocommerce_tax_total_display' ) === 'itemized' ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
					<div class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
						<p><?php echo esc_html( $tax->label ); ?><span><?php echo wp_kses_post( $tax->formatted_amount ); ?></span></p>
						<div class="ro-divide"></div>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<div class="tax-total">
					<p><?php echo esc_html( WC()->countries->tax_or_vat() ); ?><span><?php echo wc_price( WC()->cart->get_taxes_total() ); ?></span></p>
					<div class="ro-divide"></div>
				</div>
			<?php endif; ?>
		<?php endif; ?>
		
		<div class="order-total">
			<p><?php _e( 'Total', 'woocommerce' ); ?><span><?php wc_cart_totals_order_total_html(); ?></span></p>
		</div>
		<div>
			<p><?php _e( 'Payment Due', 'woocommerce' ); ?><span><?php wc_cart_totals_order_total_html(); ?></span></p>
		</div>
	</div>
</div>
<!--table class="shop_table woocommerce-checkout-review-order-table">
	<thead>
		<tr>
			<th class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
			<th class="product-total"><?php _e( 'Total', 'woocommerce' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
			do_action( 'woocommerce_review_order_before_cart_contents' );

			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					?>
					<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
						<td class="product-name">
							<?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;'; ?>
							<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times; %s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); ?>
							<?php echo WC()->cart->get_item_data( $cart_item ); ?>
						</td>
						<td class="product-total">
							<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
						</td>
					</tr>
					<?php
				}
			}

			do_action( 'woocommerce_review_order_after_cart_contents' );
		?>
	</tbody>
	<tfoot>

		<tr class="cart-subtotal">
			<th><?php _e( 'Subtotal', 'woocommerce' ); ?></th>
			<td><?php wc_cart_totals_subtotal_html(); ?></td>
		</tr>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr( $code ); ?>">
				<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
				<td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

			<?php wc_cart_totals_shipping_html(); ?>

			<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<tr class="fee">
				<th><?php echo esc_html( $fee->name ); ?></th>
				<td><?php wc_cart_totals_fee_html( $fee ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( WC()->cart->tax_display_cart === 'excl' ) : ?>
			<?php if ( get_option( 'woocommerce_tax_total_display' ) === 'itemized' ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
					<tr class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
						<th><?php echo esc_html( $tax->label ); ?></th>
						<td><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr class="tax-total">
					<th><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
					<td><?php echo wc_price( WC()->cart->get_taxes_total() ); ?></td>
				</tr>
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

		<tr class="order-total">
			<th><?php _e( 'Total', 'woocommerce' ); ?></th>
			<td><?php wc_cart_totals_order_total_html(); ?></td>
		</tr>

		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

	</tfoot>
</table-->