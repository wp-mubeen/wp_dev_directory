<?php
global $tb_options;
$image_default = isset($tb_options['tb_blog_image_default']) ? $tb_options['tb_blog_image_default'] : '';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if($show_title) echo tb_theme_title_render(); ?>
    <?php if (has_post_thumbnail() || $image_default) { ?>
        <div class="tb-blog-image">
            <?php
			$image_full = '';
			if(has_post_thumbnail()){
				$attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full', false);
				$image_full = $attachment_image[0];
				if($crop_image){
					$image_resize = matthewruddy_image_resize( $attachment_image[0], $width_image, $height_image, true, false );
					echo '<img style="width:100%;" class="bt-image-cropped" src="'. esc_attr($image_resize['url']) .'" alt="">';
				}else{
					the_post_thumbnail();
				}
			}else{
				if($image_default['url']){
					$image_full = $image_default['url'];
					if($tb_blog_crop_image){
						$image_resize = matthewruddy_image_resize( $image_default['url'], $width_image, $height_image, true, false );
						echo '<img style="width:100%;" class="bt-image-cropped" src="'. esc_attr($image_resize['url']) .'" alt="">';
					}else{
						echo '<img alt="Image-Default" class="attachment-thumbnail wp-post-image" src="'. esc_attr($image_default['url']) .'">';
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
        </div>
    <?php } ?>
	<div class="tb-content-block">
		<?php if($show_desc) echo '<div class="blog-desc">'.tb_custom_excerpt($excerpt_length , $excerpt_more).'</div>'; ?>
		<?php if($show_info) echo tb_theme_info_bar_render(); ?>
	</div>
</article>