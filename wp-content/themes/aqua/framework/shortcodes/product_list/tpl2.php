<article <?php post_class( 'tb-product-item' ); ?>>
				
	<div class="tb-product-item-inner"> 
		
		<?php if($show_sale_flash) do_action( 'woocommerce_show_product_loop_sale_flash' ); ?>
		
		<div class="tb-item-content-image">
		
			<?php do_action( 'woocommerce_template_loop_product_thumbnail' ); ?>
			
			<?php if($show_add_to_cart || $show_btn_read_more){ ?>
				<div class="tb-item-button-content">
					<div class="tb-item-button">
						
						<?php if($show_add_to_cart) do_action( 'woocommerce_template_loop_add_to_cart_2' ); ?>
						<?php post_favorite(); ?>
						<!--
						<?php if($show_btn_read_more){ ?>
							<a class="tb-btn tb-readmore" href="<?php the_permalink(); ?>"><i class="fa fa-share"></i></a>
						<?php } ?>
						-->
						
					</div>
				</div>
			<?php } ?>
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
			</div>
		</div>
	</div>

</article>