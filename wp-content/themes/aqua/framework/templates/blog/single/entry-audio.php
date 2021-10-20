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
$audio_type = get_post_meta(get_the_ID(), 'tb_post_audio_type', true);
$audio_url = get_post_meta(get_the_ID(), 'tb_post_audio_url', true);
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="blog-audio">
		<?php
		if(!is_home()){
			if ($audio_type == 'post'){
				$shortcode = tb_theme_get_shortcode_from_content('audio');
				if($shortcode) echo do_shortcode($shortcode);
			} elseif ($audio_type == 'ogg' || $audio_type == 'mp3' || $audio_type == 'wav'){
				if($audio_url) echo do_shortcode('[audio '.$audio_type.'="'.$audio_url.'"][/audio]');
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