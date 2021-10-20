<?php
class WC_Widget_Mini_Cart extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'widget_mini_cart', // Base ID
            __('TB Mini Cart', 'aqua'), // Name
            array('description' => __("Display the user's Cart form in the sidebar.", 'aqua'),) // Args
        );
        add_action('wp_enqueue_scripts', array($this, 'widget_scripts'));
    }
    function widget_scripts() {
    }
    function widget($args, $instance) {
        extract(shortcode_atts($instance,$args));
        if ( is_cart() || is_checkout() ) return;
        $title = apply_filters('widget_title', empty( $instance['title'] ) ?'' : $instance['title'], $instance, $this->id_base );
        $hide_if_empty = empty( $instance['hide_if_empty'] ) ? 0 : 1;
        ob_start();
		echo isset($before_widget)?$before_widget:'';
		$before_title = isset($before_title)?$before_title:'';
		$after_title = isset($after_title)?$after_title:'';
        if ( $title ) echo tb_filtercontent($before_title . $title . $after_title);
        $total = 0;
        global $woocommerce;
		$cart_is_empty = sizeof( $woocommerce->cart->get_cart() ) <= 0;	
        ?>
        <div class="widget_mini_cart_wrap <?php echo tb_filtercontent($cart_is_empty?'tb-cart-empty':'');?>" <?php echo tb_filtercontent($cart_is_empty?'style=""':'');?>>
            <div class="header">
                <a href="<?php echo WC()->cart->get_cart_url(); ?>" class="icon_cart_wrap"><i class="icon-ecommerce-cart-content cart-icon"></i>
					<span class="cart_total" ><?php
						echo tb_filtercontent($woocommerce?' '.$woocommerce->cart->get_cart_contents_count():'');?>
					</span>
				</a>
            </div>
            <div class="shopping_cart_dropdown" id="shopping_cart_dropdown">
                <div class="shopping_cart_dropdown_inner">
				<div class="mini-cart-btn-wrap">
					<button type="button" class="btn btn-default close-mini-cart" data-dismiss="modal">Close</button>
				</div>
					<?php
					$list_class = array( 'cart_list', 'product_list_widget' );
					?>
					<table class="shop_table cart" cellspacing="0">
						<caption><h4><?php _e('My Shopping Cart', 'aqua'); ?></h4></caption>
						<thead>
							<tr>
								<th class="product-remove">Action</th>
								<th class="product-thumbnail">Thumbnail</th>
								<th class="product-name">Product</th>
								<th class="product-price">Quantity & Price</th>
							</tr>
						</thead>
						<tbody class="<?php echo implode(' ', $list_class); ?>">
							<?php if ( !$cart_is_empty ) : ?>
								<?php foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $cart_item ) :
									$_product = $cart_item['data'];
									if ( ! $_product->exists() || $cart_item['quantity'] == 0 ) {
										continue;
									}
									$product_price = get_option( 'woocommerce_tax_display_cart' ) == 'excl' ? $_product->get_price_excluding_tax() : $_product->get_price_including_tax();
									$product_price = apply_filters( 'woocommerce_cart_item_price_html', woocommerce_price( $product_price ), $cart_item, $cart_item_key );
									?>
									<tr class="cart-item">
										<td class="product-remove">
											<a href="<?php echo tb_filtercontent($woocommerce->cart->get_remove_url($cart_item_key)); ?>">x</a>
										</td>
										<td class="product-thumbnail">
											<a href="<?php echo get_permalink( $cart_item['product_id'] ); ?>"><?php echo tb_filtercontent($_product->get_image()); ?></a>
										</td>
										<td class="product-name">
											<a href="<?php echo get_permalink( $cart_item['product_id'] ); ?>"><?php echo apply_filters('woocommerce_widget_cart_product_title', $_product->get_title(), $_product ); ?></a>
										</td>
										<td class="product-price">
											<span class="quantity"><?php echo tb_filtercontent($cart_item['quantity']);?></span> x 
											<span class="price"><?php echo tb_filtercontent($product_price);?></span>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php else : ?>
								<tr class="cart-item"><?php _e( 'No products in the cart.', 'woocommerce' ); ?></tr>
							<?php endif; ?>
						</tbody>
					</table>					
					<div class="mini-cart-footer clearfix">
						<div class="cart-link">
							<a href="<?php echo esc_url($woocommerce->cart->get_cart_url()); ?>" class="ro-btn-bd-2 pull-left wc-forward"><?php _e( 'VIEW CART', 'woocommerce' ); ?></a>
						</div>
						<div class="cart-total">
							<span class="total pull-right"><?php _e( 'Total', 'woocommerce' ); ?>:<span><?php echo tb_filtercontent($woocommerce->cart->get_cart_subtotal()); ?></span></span>
						</div>
					</div>
				</div>
			</div>
        </div>
		<?php
        echo isset($after_widget)?$after_widget:'';
        echo ob_get_clean();
    }
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
		return $instance;
    }
    function form( $instance ) {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e( 'Title:', 'aqua' ); ?></label>
            <input id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
    <?php

    }
}

function register_cart_search_widget() {
    register_widget('WC_Widget_Mini_Cart');
}
if (class_exists ( 'Woocommerce' )) {
	add_action('widgets_init', 'register_cart_search_widget');
}
?>
<?php
add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');
add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_content');
if(!function_exists('woocommerce_header_add_to_cart_fragment')){
	function woocommerce_header_add_to_cart_fragment( $fragments ) {
		global $woocommerce;
		ob_start();
		?>
		<span class="cart_total"><?php echo tb_filtercontent($woocommerce->cart->cart_contents_count); ?></span>
		<?php
		$fragments['span.cart_total'] = ob_get_clean();
		return $fragments;
	}
}
if(!function_exists('woocommerce_header_add_to_cart_content')){
	function woocommerce_header_add_to_cart_content( $fragments ) {
		global $woocommerce;
		ob_start();
		?>
		<div class="shopping_cart_dropdown" id="shopping_cart_dropdown">
			<div class="shopping_cart_dropdown_inner">
				<div class="mini-cart-btn-wrap">
					<button type="button" class="btn btn-default close-mini-cart" data-dismiss="modal">Close</button>
				</div>
				<?php
				$cart_is_empty = sizeof( $woocommerce->cart->get_cart() ) <= 0;
				$list_class = array( 'cart_list', 'product_list_widget' );
				?>
				<table class="shop_table cart" cellspacing="0">
					<caption><h4><?php _e('My Shopping Cart', 'aqua'); ?></h4></caption>
					<thead>
						<tr>
							<th class="product-remove">Action</th>
							<th class="product-thumbnail">Thumbnail</th>
							<th class="product-name">Product</th>
							<th class="product-price">Quantity & Price</th>
						</tr>
					</thead>
					<tbody class="<?php echo implode(' ', $list_class); ?>">
						<?php if ( !$cart_is_empty ) : ?>
							<?php foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $cart_item ) :
								$_product = $cart_item['data'];
								if ( ! $_product->exists() || $cart_item['quantity'] == 0 ) {
									continue;
								}
								$product_price = get_option( 'woocommerce_tax_display_cart' ) == 'excl' ? $_product->get_price_excluding_tax() : $_product->get_price_including_tax();
								$product_price = apply_filters( 'woocommerce_cart_item_price_html', woocommerce_price( $product_price ), $cart_item, $cart_item_key );
								?>
								<tr class="cart-item">
									<td class="product-remove">
										<a href="<?php echo tb_filtercontent($woocommerce->cart->get_remove_url($cart_item_key)); ?>">x</a>
									</td>
									<td class="product-thumbnail">
										<a href="<?php echo get_permalink( $cart_item['product_id'] ); ?>"><?php echo tb_filtercontent($_product->get_image()); ?></a>
									</td>
									<td class="product-name">
										<a href="<?php echo get_permalink( $cart_item['product_id'] ); ?>"><?php echo apply_filters('woocommerce_widget_cart_product_title', $_product->get_title(), $_product ); ?></a>
									</td>
									<td class="product-price">
										<span class="quantity"><?php echo tb_filtercontent($cart_item['quantity']);?></span> x 
										<span class="price"><?php echo tb_filtercontent($product_price);?></span>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else : ?>
							<tr class="cart-item"><?php _e( 'No products in the cart.', 'woocommerce' ); ?></tr>
						<?php endif; ?>
					</tbody>
				</table>
				<div class="mini-cart-footer clearfix">
					<div class="cart-link pull-left">
						<a href="<?php echo esc_url($woocommerce->cart->get_cart_url()); ?>" class="ro-btn-bd-2 wc-forward"><?php _e( 'VIEW CART', 'woocommerce' ); ?></a>
					</div>
					<div class="cart-total pull-right">
						<span class="total"><?php _e( 'Total', 'woocommerce' ); ?>:<span><?php echo tb_filtercontent($woocommerce->cart->get_cart_subtotal()); ?></span></span>
					</div>
				</div>
			</div>
		</div>
		<?php
		$fragments['div.shopping_cart_dropdown'] = ob_get_clean();
		return $fragments;
	}
}
?>