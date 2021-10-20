<?php
	global $tb_options;
	$img_default  =& $tb_options['tb_blog_image_default']['url'];
?>
<div class="woocommerce">
<div id="<?php echo esc_attr($uniqid); ?>" class="tb-carousel owl-carousel owl-theme products <?php echo esc_attr($el_class); ?>" <?php echo tb_filtercontent($data_attr);?>>
	<?php if($wp_query->have_posts()):
			$counter = 0;
			while ($wp_query->have_posts()) : $wp_query->the_post();
			$counter++;
			if($rows == 1){
					echo '<div class="tb-carousel-item-wrap tb-product-items">';
				}else{
					echo($counter % $rows == 1)?'<div class="tb-carousel-item-wrap tb-product-items">':'';
				}
			?>                
			<article <?php post_class( 'tb-product-item' ); ?>>
				
				<div class="tb-product-item-inner"> 
					
					<?php if($tb_options['tb_archive_show_sale_flash_product']) do_action( 'woocommerce_show_product_loop_sale_flash' ); ?>
					
					<div class="tb-item-content-image">
					
						<?php do_action( 'woocommerce_template_loop_product_thumbnail' ); ?>
						
						<?php if($tb_options['tb_archive_show_add_to_cart_product'] || $tb_options['tb_archive_show_btn_read_more_product']){ ?>
							<div class="tb-item-button">
							
								<?php if($tb_options['tb_archive_show_add_to_cart_product']) do_action( 'woocommerce_template_loop_add_to_cart' ); ?>
								
								<?php if($tb_options['tb_archive_show_btn_read_more_product']){ ?>
									<a class="tb-btn tb-readmore" href="<?php the_permalink(); ?>"><i class="fa fa-share"></i></a>
								<?php } ?>
								
							</div>
						<?php } ?>
						
					</div>
					<?php if($tb_options['tb_archive_show_title_product']){ ?>
						<a href="<?php the_permalink(); ?>"><?php the_title( '<h3 class="text-ellipsis">', '</h3>' ); ?></a>
					<?php } ?>
					
					<?php if($tb_options['tb_archive_show_price_product']) do_action( 'woocommerce_template_loop_price' ); ?>
					
					<?php if($tb_options['tb_archive_show_rating_product']){ ?>
						<div class="tb-item-rating primary_color">
							<?php do_action( 'woocommerce_template_loop_rating' ); ?>
						</div>
					<?php } ?>
					
				</div>

			</article>
			<?php
			if($rows == 1){
				echo '</div>';
			}else{
				echo tb_filtercontent($counter % $rows == 0?'</div>':'');
			}
			endwhile;
			wp_reset_postdata();
			?>
			<?php
				else :
						echo 'Post not found!';
				endif;
			?>
</div>
</div>