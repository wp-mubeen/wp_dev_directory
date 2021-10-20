<article <?php post_class( 'tb-product-item' ); ?>>
				
	<div class="tb-product-item-inner"> 
		
		<?php if($show_sale_flash) do_action( 'woocommerce_show_product_loop_sale_flash' ); ?>
		
		<div class="tb-item-content-image">
			<?php do_action( 'woocommerce_template_loop_product_thumbnail' ); ?>
		</div>
		<div class="tb-item-content-info">
			<div class="tb-item-content-info-inner">
				<?php if($show_title){ ?>
					<a href="<?php the_permalink(); ?>"><?php the_title( '<h4 class="text-ellipsis underline">', '</h4>' ); ?></a>
				<?php } ?>
				
				<?php if($show_price) do_action( 'woocommerce_template_loop_price' ); ?>
				
				<?php if($show_rating){ ?>
					<div class="tb-item-rating">
						<?php do_action( 'woocommerce_template_loop_rating' ); ?>
					</div>
				<?php } ?>
				<?php if($show_add_to_cart) do_action( 'woocommerce_template_loop_add_to_cart' ); ?>
			</div>
		</div>
	</div>

</article>