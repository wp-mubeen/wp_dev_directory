<?php
	global $tb_options;
	$img_default  =& $tb_options['tb_blog_image_default']['url'];
?>
<div id="<?php echo esc_attr($uniqid); ?>" class="row owl-theme <?php echo esc_attr($el_class) . ' ' . esc_attr($tpl); ?>" <?php echo tb_filtercontent($data_attr);?>>
	<?php if($wp_query->have_posts()):
			$counter = 0;
			while ($wp_query->have_posts()) : $wp_query->the_post();
			$counter++;
			if($rows == 1){
					echo '<div class="tb-carousel-item-wrap text-center col-md-4">';
				}else{
					echo($counter % $rows == 1)?'<div class="tb-carousel-item-wrap">':'';
				}
			?>                        
			<div class="item">
				<div class="item-inner">
					<div class="slider-blog">
						<?php if($show_image): ?>
						<div class="tb_carousel_img">
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
							<div class="tb-image">
								<a href="<?php the_permalink();?>"><img class="tb_carousel_attachment" src="<?php echo esc_url($img_src);?>" alt=""></a>
							</div>
						</div>
						<?php endif; ?>
						<div class="tb_carousel_content">
						<?php if ($show_title) : ?>
							<h4 class="tb_carousel_title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h4>
						<?php endif; ?>
						<div class="tb_position">
							<?php $team_position = get_post_meta(get_the_ID(), 'tb_team_position', true); ?>
							<span class="position"><?php echo tb_filtercontent($team_position); ?></span>
						</div>
						<?php if ($show_info) : ?>
							<div class="tb_info_blog">
								<div class="tb_meta_blog">
									<span class="time"><?php echo get_the_time('d M Y'); ?></span>
								</div>
							</div>
						<?php endif; ?>
						<?php if($show_description): ?>
						<div class="tb_introtext">
							 <?php
								if ($excerpt_length != -1) { 
									echo tb_custom_excerpt($excerpt_length, $excerpt_more);
								} else {
									the_content(); 
								}
							?>
						</div>
						<?php endif; ?>
						<?php
							$team_facebook = get_post_meta(get_the_ID(), 'tb_team_facebook', true);
							$team_twitter = get_post_meta(get_the_ID(), 'tb_team_twitter', true);
							$team_google_plus = get_post_meta(get_the_ID(), 'tb_team_google_plus', true);
							$team_linkedin = get_post_meta(get_the_ID(), 'tb_team_linkedin', true);
							
							$links = array();
							$links[] = ($team_facebook!='') ? '<li><a href="'.esc_url($team_facebook).'" title="'.__('Facebook', 'aqua').'" target="_blank"><i class="fa fa-facebook"></i></a></li>' : '';
							$links[] = ($team_twitter!='') ? '<li><a href="'.esc_url($team_twitter).'" title="'.__('Twitter', 'aqua').'" target="_blank"><i class="fa fa-twitter"></i></a></li>' : '';
							$links[] = ($team_google_plus!='') ? '<li><a href="'.esc_url($team_google_plus).'" title="'.__('Google Plus', 'aqua').'" target="_blank"><i class="fa fa-google-plus"></i></a></li>' : '';
							$links[] = ($team_linkedin!='') ? '<li><a href="'.esc_url($team_linkedin).'" title="'.__('Linkedin', 'aqua').'" target="_blank"><i class="fa fa-linkedin"></i></a></li>' : '';
							
							if (!empty($links)) {
								echo '<ul class="tb-social">' . implode('', $links) . '</ul>';
							}
						?>
						<?php if($read_more): ?>
							<div class="tb-links">
								<a class="wpb_button wpb_btn-primary wpb_regularsize" href="<?php the_permalink(); ?>"><?php echo esc_attr($read_more); ?></a>
							</div>
						<?php endif; ?>
						</div>
					</div>
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