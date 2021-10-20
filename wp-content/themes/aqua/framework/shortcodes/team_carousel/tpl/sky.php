<?php
	global $tb_options;
	$img_default  =& $tb_options['tb_blog_image_default']['url'];
	$style = array();
	$style[] = "height: $height"; 
?>
<div id="<?php echo esc_attr($uniqid); ?>" class="sky-carousel <?php echo esc_attr($el_class); ?>" <?php echo tb_filtercontent($data_attr);?> data-addclassactive="true" style="<?php echo implode(';',$style);?>">                        
	<div class="sky-carousel-wrapper">
		<ul class="sky-carousel-container">
	<?php if($wp_query->have_posts()):
			$counter = 0;
			while ($wp_query->have_posts()) : $wp_query->the_post();
			?>
				<li class="slide-item">
				<?php if($show_image): ?>
				<div class="slide-item-image clearfix">
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
				</div>
				<?php endif; ?>
				<div class="tb_carousel_content sc-content">
				<?php if ($show_title) : ?>
					<h2 class="tb_carousel_title">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h2>
				<?php endif; ?>
				<div class="cur_content">
				<?php if ($show_info) : ?>
					<div class="tb_info_blog">
						<div class="tb_meta_blog">
							<span class="time"><?php echo get_the_time('d M Y'); ?></span>
						</div>
					</div>
				<?php endif; ?>
				<?php if($show_description): ?>
				<div class="tb_introtext description">
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
			</li>
			<?php
			endwhile;
			wp_reset_postdata();
			?>
			<?php
				else :
						echo 'Post not found!';
				endif;
			?>
		</ul>
	</div>
</div>