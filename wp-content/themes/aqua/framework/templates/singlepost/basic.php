<?php
/*
Template Name Posts: Basic
*/ 
?>
<?php get_header(); ?>
<?php
global $tb_options;
$tb_show_page_title = isset($tb_options['tb_post_show_page_title']) ? $tb_options['tb_post_show_page_title'] : 1;
$tb_show_page_breadcrumb = isset($tb_options['tb_post_show_page_breadcrumb']) ? $tb_options['tb_post_show_page_breadcrumb'] : 1;
tb_theme_title_bar($tb_show_page_title, $tb_show_page_breadcrumb);
?>
	<div class="main-content">
		<div class="container aloha">
			<!-- Start Content -->
				<?php
				while ( have_posts() ) : the_post();
					$post_id = get_the_ID();
					get_template_part( 'framework/templates/blog/single/entry', 'basic');
				endwhile;
				?>
			<!-- End Content -->
			<div class="tb-blog-related">
				<?php
				$related = get_posts( array( 'category__in' => wp_get_post_categories($post_id), 'numberposts' => 5, 'post__not_in' => array($post_id) ) );
				if( $related ) {
				echo '<div class="row">';
					foreach( $related as $post ) {
					setup_postdata($post); 
						if(has_post_thumbnail()){
							$attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false);
							$image_resize = matthewruddy_image_resize( $attachment_image[0], 600, 400, true, false );
							?>
							<div class="col-md-3 col-sm-6 hidden-xs">
								<a href="<?php the_permalink(); ?>"><img style="width:100%;" class="bt-image-cropped" src="<?php echo esc_attr($image_resize['url']); ?>" alt=""></a>
							</div>
							<?php
						}
					} 
				echo '</div>';
				}
				wp_reset_postdata(); 
				?>
			</div>
		</div>
	</div>
<?php get_footer(); ?>