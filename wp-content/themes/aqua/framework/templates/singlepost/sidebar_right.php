<?php
/*
Template Name Posts: Sidebar Right
*/
?>
<?php get_header(); ?>
<?php
global $tb_options;
$tb_show_page_title = isset($tb_options['tb_post_show_page_title']) ? $tb_options['tb_post_show_page_title'] : 1;
$tb_show_page_breadcrumb = isset($tb_options['tb_post_show_page_breadcrumb']) ? $tb_options['tb_post_show_page_breadcrumb'] : 1;
tb_theme_title_bar($tb_show_page_title, $tb_show_page_breadcrumb);

$tb_show_post_nav = (int) isset($tb_options['tb_post_show_post_nav']) ?  $tb_options['tb_post_show_post_nav']: 1;
$tb_show_post_comment = (int) isset($tb_options['tb_post_show_post_comment']) ?  $tb_options['tb_post_show_post_comment']: 1;
?>
	<div class="main-content">
		<div class="container aloha">
			<div class="row">
				<?php
				$tb_blog_layout = isset($tb_options['tb_post_layout']) ? $tb_options['tb_post_layout'] : '3cm';
				
				$cl_content = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
				$cl_sb_left = '';
				$cl_sb_right = '';
				
				switch ($tb_blog_layout) {
					case '1col':
						$cl_content = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
						$cl_sb_left = '';
						$cl_sb_right = '';
						break;
					case '2cl':
						if(is_active_sidebar( 'tbtheme-left-sidebar' )){
							$cl_content = 'col-xs-12 col-sm-12 col-md-9 col-lg-9';
							$cl_sb_left = 'col-xs-12 col-sm-3 col-md-3 col-lg-3 hidden-sm hidden-xs';
						}
						break;
					case '2cr':
						if(is_active_sidebar( 'tbtheme-right-sidebar' )){
							$cl_content = 'col-xs-12 col-sm-12 col-md-9 col-lg-9';
							$cl_sb_right = 'col-xs-12 col-sm-3 col-md-3 col-lg-3 hidden-sm hidden-xs';
						}
						break;
					case '3cm':
						if(is_active_sidebar( 'tbtheme-left-sidebar' ) && is_active_sidebar( 'tbtheme-right-sidebar' )){
							$cl_content = 'col-xs-12 col-sm-3 col-md-3 col-lg-3';
							$cl_sb_left = 'col-xs-12 col-sm-6 col-md-6 col-lg-6';
							$cl_sb_right = 'col-xs-12 col-sm-3 col-md-3 col-lg-3';
						}else{
							if(is_active_sidebar( 'tbtheme-left-sidebar' )){
								$cl_content = 'col-xs-12 col-sm-9 col-md-9 col-lg-9';
								$cl_sb_left = 'col-xs-12 col-sm-3 col-md-3 col-lg-3';
							}
							if(is_active_sidebar( 'tbtheme-right-sidebar' )){
								$cl_content = 'col-xs-12 col-sm-9 col-md-9 col-lg-9';
								$cl_sb_right = 'col-xs-12 col-sm-3 col-md-3 col-lg-3';
							}
						}
						break;
				}
				?>
				<!-- Start Left Sidebar -->
				<?php if($tb_blog_layout == '2cl' && is_active_sidebar( 'tbtheme-left-sidebar' ) || ($tb_blog_layout == '3cm' && is_active_sidebar( 'tbtheme-left-sidebar' ))){ ?>
					<div class="<?php echo esc_attr($cl_sb_left) ?> sidebar-left">
						<?php get_sidebar('left'); ?>
					</div>
				<?php } ?>
				<!-- End Left Sidebar -->
				<!-- Start Content -->
				<div class="<?php echo esc_attr($cl_content) ?> content tb-blog">
					<?php
					while ( have_posts() ) : the_post();
						$post_id = get_the_ID();
						//get_template_part( 'framework/templates/blog/single/entry', get_post_format());
						
						global $tb_options;
						$image_default = isset($tb_options['tb_blog_image_default']) ? $tb_options['tb_blog_image_default'] : '';
						if(is_home()){
							$tb_show_post_title = 1;
							$tb_show_post_desc = 1;
							$tb_show_post_info = 1;
						}elseif (is_single()) {
							$tb_blog_crop_image = isset($tb_options['tb_post_crop_image']) ? $tb_options['tb_post_crop_image'] : 0;
							$tb_blog_image_width = (int) isset($tb_options['tb_post_image_width']) ? $tb_options['tb_post_image_width'] : 800;
							$tb_blog_image_height = (int) isset($tb_options['tb_post_image_height']) ? $tb_options['tb_post_image_height'] : 400;
							$tb_show_post_title = (int) isset($tb_options['tb_post_show_post_title']) ? $tb_options['tb_post_show_post_title'] : 1;
							$tb_show_post_info = (int) isset($tb_options['tb_post_show_post_info']) ? $tb_options['tb_post_show_post_title'] : 1;
							$tb_post_show_social_share = (int) isset($tb_options['tb_post_show_social_share']) ? $tb_options['tb_post_show_social_share'] : 1;
							$tb_post_show_post_tags = (int) isset($tb_options['tb_post_show_post_tags']) ? $tb_options['tb_post_show_post_tags'] : 1;
							$tb_post_show_post_author = (int) isset($tb_options['tb_post_show_post_author']) ? $tb_options['tb_post_show_post_author'] : 1;
							$tb_show_post_desc = 1;
						}else{
							$tb_blog_crop_image = isset($tb_options['tb_blog_crop_image']) ? $tb_options['tb_blog_crop_image'] : 0;
							$tb_blog_image_width = (int) isset($tb_options['tb_blog_image_width']) ? $tb_options['tb_blog_image_width'] : 600;
							$tb_blog_image_height = (int) isset($tb_options['tb_blog_image_height']) ? $tb_options['tb_blog_image_height'] : 400;
							$tb_show_post_title = (int) isset($tb_options['tb_blog_show_post_title']) ? $tb_options['tb_blog_show_post_title'] : 1;
							$tb_show_post_info = (int) isset($tb_options['tb_blog_show_post_info']) ? $tb_options['tb_blog_show_post_title'] : 1;
							$tb_show_post_desc = (int) isset($tb_options['tb_blog_show_post_desc']) ? $tb_options['tb_blog_show_post_desc'] : 1;
						}
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<?php if (has_post_thumbnail() || $image_default) { ?>
								<div class="tb-blog-image">
									<?php
									if(!is_home()){
										$image_full = '';
										if(has_post_thumbnail()){
											$attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full', false);
											$image_full = $attachment_image[0];
											if($tb_blog_crop_image){
												$image_resize = matthewruddy_image_resize( $attachment_image[0], $tb_blog_image_width, $tb_blog_image_height, true, false );
												echo '<img style="width:100%;" class="bt-image-cropped" src="'. esc_attr($image_resize['url']) .'" alt="">';
											}else{
												the_post_thumbnail();
											}
										}else{
											if($image_default['url']){
												$image_full = $image_default['url'];
												if($tb_blog_crop_image){
													$image_resize = matthewruddy_image_resize( $image_default['url'], $tb_blog_image_width, $tb_blog_image_height, true, false );
													echo '<img style="width:100%;" class="bt-image-cropped" src="'. esc_attr($image_resize['url']) .'" alt="">';
												}else{
													echo '<img alt="Image-Default" class="attachment-thumbnail wp-post-image" src="'. esc_attr($image_default['url']) .'">';
												}
											}
										}
									}
									?>
									<?php
									$post_note_text = get_post_meta(get_the_ID(), 'tb_post_note_text', true);
									$post_note_extra_link = get_post_meta(get_the_ID(), 'tb_post_note_extra_link', true);
									?>
									<?php if($post_note_text) { ?>
									<div class="blog-note">
										<a class="blog-note-top" href="#"><i class="icon-wrong6"></i></a>
										<p class="blog-note-texts"><?php echo tb_filtercontent($post_note_text); ?></p>
										<a class="blog-note-bottom" href="<?php echo esc_url($post_note_extra_link); ?>"><i class="icon-arrow413"></i></a>
									</div>
									<?php } ?>
									<?php if(is_archive()){ ?>
										<div class="colorbox-wrap">
											<div class="colorbox-inner">
												<a class="cb-popup view-image" title="<?php the_title() ?>" href="<?php echo esc_url($image_full); ?>">
													<i class="fa fa-search-plus"></i>
												</a>
												<a class="cb-link" title="<?php the_title() ?>" href="<?php the_permalink(); ?>">
													<i class="fa fa-link"></i>
												</a>
											</div>
										</div>
									<?php } ?>
								</div>
							<?php } ?>
							<?php if($tb_show_post_title) echo tb_theme_title_render(); ?>
							<?php if($tb_show_post_info) echo tb_theme_info_bar_render(); ?>
							<div class="tb-content-block">
								<?php if($tb_show_post_desc) echo the_content(); ?>
								<div style="clear: both"></div>
								<?php if(is_single() && $tb_post_show_social_share) echo tb_theme_social_share_post_render(); ?>
								<?php if(is_single() && $tb_post_show_post_tags) echo tb_theme_tags_render(); ?>
								<?php if(is_single() && $tb_post_show_post_author) echo tb_theme_author_render(); ?>
							</div>
						</article>
						
						<?php
						// Previous/next post navigation.
						if($tb_show_post_nav) tb_theme_post_nav();
						// If comments are open or we have at least one comment, load up the comment template.
						if ( (comments_open() && $tb_show_post_comment) || (get_comments_number() && $tb_show_post_comment) ) comments_template();
					endwhile;
					?>
				</div>
				<!-- End Content -->
				<!-- Start Right Sidebar -->
				<?php if(($tb_blog_layout == '2cr' && is_active_sidebar( 'tbtheme-right-sidebar' )) || ($tb_blog_layout == '3cm' && is_active_sidebar( 'tbtheme-right-sidebar' ))){ ?>
					<div class="<?php echo esc_attr($cl_sb_right) ?> sidebar-right">
						<?php get_sidebar('right'); ?>
					</div>
				<?php } ?>
				<!-- End Right Sidebar -->
			</div>
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