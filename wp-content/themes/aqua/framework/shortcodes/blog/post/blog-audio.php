<?php
$audio_type = get_post_meta(get_the_ID(), 'tb_post_audio_type', true);
$audio_url = get_post_meta(get_the_ID(), 'tb_post_audio_url', true);
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if($show_title) echo tb_theme_title_render(); ?>
	<div class="blog-audio">
		<?php
		if ($audio_type == 'post'){
			$shortcode = tb_theme_get_shortcode_from_content('audio');
			if($shortcode) echo do_shortcode($shortcode);
		} elseif ($audio_type == 'ogg' || $audio_type == 'mp3' || $audio_type == 'wav'){
			if($audio_url) echo do_shortcode('[audio '.$audio_type.'="'.$audio_url.'"][/audio]');
		}
		?>
	</div>
	<div class="tb-content-block">
		<?php if($show_desc) echo '<div class="blog-desc">'.tb_custom_excerpt($excerpt_length , $excerpt_more).'</div>'; ?>
		<?php if($show_info) echo tb_theme_info_bar_render(); ?>
	</div>
</article>