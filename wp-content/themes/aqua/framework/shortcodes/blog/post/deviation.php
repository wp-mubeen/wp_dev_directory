<?php
global $tb_options;
$image_default = isset($tb_options['tb_blog_image_default']) ? $tb_options['tb_blog_image_default'] : '';
$_thumb = '';
if(has_post_thumbnail()){
	$attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full', false);
	$url = isset($crop_image)? matthewruddy_image_resize( $attachment_image[0], $width_image, $height_image, true, false ) : wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full', false);
}else{
	$url = ($tb_blog_crop_image)? matthewruddy_image_resize( $image_default['url'], $width_image, $height_image, true, false ) : $image_default;
}
$_thumb = ($url['url'])? $url['url'] : $url[0];
?> 
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="deviation-blog deviation-align-<?php echo tb_filtercontent($deviation_text_align); ?>">
		<div class="deviation-content-image">
			<img src="<?php echo tb_filtercontent($_thumb); ?>" alt="<?php the_title(); ?>"/>
		</div>
		<div class="deviation-content-info text-center">
			<?php if($show_title) echo tb_theme_title_render(); ?>
			<?php if($show_desc) echo '<div class="blog-desc">'.tb_custom_excerpt($excerpt_length , $excerpt_more).'</div>'; ?>
			<?php if($show_info) echo tb_theme_info_bar_render(); ?>
			<a class="deviation-link-more" href="<?php echo get_permalink( get_the_ID() ); ?>"><i class="ion-ios-arrow-thin-right"></i></a>
		</div>
	</div>
</article>