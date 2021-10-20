<?php
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
$tb_show_post_comment = (int) isset($tb_options['tb_post_show_post_comment']) ?  $tb_options['tb_post_show_post_comment']: 1;
$tb_show_post_nav = (int) isset($tb_options['tb_post_show_post_nav']) ?  $tb_options['tb_post_show_post_nav']: 1;
?>
<div class="row tb-blog">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 content tb-blog-thumb">
		<?php if($tb_show_post_title) echo tb_theme_title_render(); ?>
		<?php if($tb_show_post_info) echo tb_theme_info_bar_render(); ?>
		<div class="tb-blog-image">
			<?php
			if (has_post_thumbnail() || $image_default) {
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
		</div>
	</div>
</div>
<div class="row tb-blog-content-outer">
	<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 content tb-blog-basic-widget">
		<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("tbtheme-single-basic")): endif; ?>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 content tb-blog-content-wrap">		
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
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
		if ( (comments_open() && $tb_show_post_comment) || (get_comments_number() && $tb_show_post_comment) ) comments_template(); ?>
	</div>
</div>