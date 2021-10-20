<?php
	global $tb_options;
	$img_default  =& $tb_options['tb_blog_image_default']['url'];
?>
<div id="<?php echo esc_attr($uniqid); ?>" class="owl-carousel tb-carousel-improved owl-theme <?php echo esc_attr($el_class); ?>" <?php echo tb_filtercontent($data_attr);?> data-addclassactive="true">
	<?php if($wp_query->have_posts()):
			$counter = 0;
			while ($wp_query->have_posts()) : $wp_query->the_post();
			$counter++;
			if($rows == 1){
					echo '<div class="tb-carousel-item-wrap">';
				}else{
					echo($counter % $rows == 1)?'<div class="tb-carousel-item-wrap">':'';
				}
			?>                        
			<div class="carousel-block">
				<?php if($show_image): ?>
					<?php if (has_post_thumbnail()) :
							$attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full', false);
							$attachment_full_image =& $attachment_image[0];
						else :
							$attachment_full_image =& $img_default;
						endif;
							if($crop_image == true || $crop_image == 1):
								$image_resize = matthewruddy_image_resize( $attachment_full_image, $width_image, $height_image, true, false );
								$img_src =& $image_resize['url'];
							else :
								$img_src =& $attachment_full_image;
							endif;
							?>
						<a href="<?php the_permalink();?>"><img class="tb_carousel_attachment" src="<?php echo esc_url($img_src);?>" alt=""></a>
				<?php endif; ?>
				<div class="tb_carousel_content carousel-content">
				<?php if ($show_title) : ?>
					<h3 class="tb_carousel_title text-ellipsis">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h3>
				<?php endif; ?>
				<?php if ($show_info) : ?>
					<div class="tb_info_blog">
						<div class="tb_meta_blog">
							<span class="time"><?php echo get_the_time('d M Y'); ?></span>
						</div>
					</div>
				<?php endif; ?>
				<?php if($show_description): ?>
				<div class="tb_introtext description text-ellipsis">
					 <?php
						if ($excerpt_length != -1) { 
							echo tb_custom_excerpt($excerpt_length, $excerpt_more);
						} else {
							the_content(); 
						}
					?>
				</div>
				<?php endif; ?>
				<?php if($read_more): ?>
					<div class="tb-links">
						<a class="wpb_button wpb_btn-primary wpb_regularsize" href="<?php the_permalink(); ?>"><?php echo esc_attr($read_more); ?></a>
					</div>
				<?php endif; ?>
				</div>
			</div>
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