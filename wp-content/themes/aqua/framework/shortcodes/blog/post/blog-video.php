<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if($show_title) echo tb_theme_title_render(); ?>
	<div class="tb-blog-video">
		<?php
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
		?>
	</div>
	<div class="tb-content-block">
		<?php if($show_desc) echo '<div class="blog-desc">'.tb_custom_excerpt($excerpt_length , $excerpt_more).'</div>'; ?>
		<?php if($show_info) echo tb_theme_info_bar_render(); ?>
	</div>
</article>