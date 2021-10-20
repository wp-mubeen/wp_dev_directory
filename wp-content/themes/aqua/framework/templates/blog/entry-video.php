<?php
global $tb_options;
if(is_home()){
	$tb_show_post_title = 1;
	$tb_show_post_desc = 1;
	$tb_show_post_info = 1;
}elseif (is_single()) {
	$tb_show_post_title = (int) isset($tb_options['tb_post_show_post_title']) ? $tb_options['tb_post_show_post_title'] : 1;
	$tb_show_post_info = (int) isset($tb_options['tb_post_show_post_info']) ? $tb_options['tb_post_show_post_title'] : 1;
	$tb_post_show_social_share = (int) isset($tb_options['tb_post_show_social_share']) ? $tb_options['tb_post_show_social_share'] : 1;
	$tb_post_show_post_tags = (int) isset($tb_options['tb_post_show_post_tags']) ? $tb_options['tb_post_show_post_tags'] : 1;
	$tb_post_show_post_author = (int) isset($tb_options['tb_post_show_post_author']) ? $tb_options['tb_post_show_post_author'] : 1;
	$tb_show_post_desc = 1;
}else{
	$tb_show_post_title = (int) isset($tb_options['tb_blog_show_post_title']) ? $tb_options['tb_blog_show_post_title'] : 1;
	$tb_show_post_info = (int) isset($tb_options['tb_blog_show_post_info']) ? $tb_options['tb_blog_show_post_title'] : 1;
	$tb_show_post_desc = (int) isset($tb_options['tb_blog_show_post_desc']) ? $tb_options['tb_blog_show_post_desc'] : 1;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <div class="tb-blog-video">
            <?php
			if(!is_home()){
				$video_source = get_post_meta(get_the_ID(), 'tb_post_video_source', true);
				if(empty($video_source)) $video_source = 'post';
				$video_height = get_post_meta(get_the_ID(), 'tb_post_video_height', true);
				if(is_single()){
				$video_height = $video_height * 2;
				}
				switch ($video_source) {
					case 'post':
						$shortcode = tb_theme_get_shortcode_from_content('wpvideo');
						if(!$shortcode){
							the_content();
						}
						if($shortcode):
							echo do_shortcode('[wpvideo tFnqC9XQ w=680]');
						endif;
						break;
					case 'youtube':
						$video_youtube = get_post_meta(get_the_ID(), 'tb_post_video_youtube', true);
						if($video_youtube){
							echo do_shortcode('[tb-video height="'.$video_height.'"]'.$video_youtube.'[/tb-video]');
						}
						break;
					case 'vimeo':
						$video_vimeo = get_post_meta(get_the_ID(), 'tb_post_video_vimeo', true);
						if($video_vimeo){
							echo do_shortcode('[tb-video height="'.$video_height.'"]'.$video_vimeo.'[/tb-video]');
						}
						break;
					case 'media':
						$video_type = get_post_meta(get_the_ID(), 'tb_post_video_type', true);
						$preview_image = get_post_meta(get_the_ID(), 'tb_post_preview_image', true);
						$video_file = get_post_meta(get_the_ID(), 'tb_post_video_url', true);
						if($video_file){
							echo do_shortcode('[video height="'.$video_height.'" '.$video_type.'="'.$video_file.'" poster="'.$preview_image.'"][/video]');
						}
						break;
				}
			}
			?>
        </div>
	<div class="tb-content-block">
		<?php if($tb_show_post_title) echo tb_theme_title_render(); ?>
		<?php if($tb_show_post_desc) echo tb_theme_content_render(); ?>
		<div style="clear: both"></div>
		<?php if($tb_show_post_info) echo tb_theme_info_bar_render(); ?>
		<?php if(is_single() && $tb_post_show_social_share) echo tb_theme_social_share_post_render(); ?>
		<?php if(is_single() && $tb_post_show_post_tags) echo tb_theme_tags_render(); ?>
		<?php if(is_single() && $tb_post_show_post_author) echo tb_theme_author_render(); ?>
	</div>
</article>