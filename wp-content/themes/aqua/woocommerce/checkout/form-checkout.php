<?php
/**
 * Checkout Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

// filter hook for include new pages inside the payment method
$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', WC()->cart->get_checkout_url() ); ?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( $get_checkout_url ); ?>" enctype="multipart/form-data">
	<div class="row">
		<div class="col-md-7 col-xs-12">
			<div class="ro-checkout-process ro-process-1">
				<div class="ro-hr-line">
					<a class="ro-tab-1" href="#!"><div></div></a><span>Address</span>
					<a class="ro-tab-2" href="#!"><div></div></a><span>Payment</span>
					<a class="ro-tab-3" href="#!"><div></div></a><span>Complet</span>
				</div>
			</div>
			<div class="ro-checkout-panel">
				<div class ="ro-panel-1">
					<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>

						<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

						<div class="col2-set" id="customer_details">
							<div class="col2-set-1">
								<?php do_action( 'woocommerce_checkout_billing' ); ?>
							</div>

							<div class="col2-set-2">
								<?php do_action( 'woocommerce_checkout_shipping' ); ?>
							</div>
						</div>

						<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

					<?php endif; ?>
					<div class="text-center"><a class="ro-btn-2" href="#!">CONTINUE</a></div>
				</div>
				<div class ="ro-panel-2">
					<div class="ro-checkout-information-2">
						<div class="woocommerce-billing-fields ro-customer-info">
							<div class="ro-title">
								<h4><?php _e( 'INFORMATION', 'woocommerce' ); ?></h4>
								<span><a class="ro-edit-customer-info" href="#!"><?php _e( 'Edit', 'woocommerce' ); ?></a></span>
							</div>
							<div class="ro-content">
								<?php foreach ( $checkout->checkout_fields['billing'] as $key => $field ) : ?>
									
									<?php  if($checkout->get_value( $key )) echo '<div class="ro-info"><p><span>'.$field['label'].': </span>'.$checkout->get_value( $key ).'</p></div>'; ?>

								<?php endforeach; ?>
							</div>
						</div>
					</div>
					
					<?php do_action( 'woocommerce_checkout_payment' ); ?>
			
				</div>
			</div>
		</div>
		<div class="col-md-5 col-xs-12">
			<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
			
			<div id="order_review" class="woocommerce-checkout-review-order">
				<?php do_action( 'woocommerce_order_review' ); ?>
			</div>

			<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
			
		</div>
	</div>
	
</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
