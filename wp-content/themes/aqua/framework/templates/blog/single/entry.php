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
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if($tb_show_post_title) echo tb_theme_title_render(); ?>
	<?php if($tb_show_post_info) echo tb_theme_info_bar_render(); ?>
    <?php if (has_post_thumbnail() || $image_default['url']) { ?>
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
	<div class="tb-content-block">
		<?php if($tb_show_post_desc) echo tb_theme_content_render(); ?>
		<div style="clear: both"></div>
		<?php if(is_single() && $tb_post_show_social_share) echo tb_theme_social_share_post_render(); ?>
		<?php if(is_single() && $tb_post_show_post_tags) echo tb_theme_tags_render(); ?>
		<?php if(is_single() && $tb_post_show_post_author) echo tb_theme_author_render(); ?>
	</div>
</article>