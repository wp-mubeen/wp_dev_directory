<?php
global $tb_options;
$image_default = isset($tb_options['tb_blog_image_default']) ? $tb_options['tb_blog_image_default'] : '';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if($show_title) echo tb_theme_title_render(); ?>
    <div class="tb-blog-gallery">
        <?php
        $date = time() . '_' . uniqid(true);
        $gallery_ids = tb_theme_grab_ids_from_gallery()->ids;
        if(!empty($gallery_ids)):
        ?>
            <div id="carousel-generic<?php echo esc_attr($date); ?>" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
					<?php
						$i = 0;
						foreach ($gallery_ids as $image_id){
							$attachment_image = wp_get_attachment_image_src($image_id, 'full', false);
							if($attachment_image[0]){
								if($crop_image){
									$image_resize = matthewruddy_image_resize( $attachment_image[0], $width_image, $height_image, true, false );
									?>
									<div class="item tb-blog-gallery <?php echo tb_filtercontent($i==0?'active':''); ?>">
										<img style="width:100%;" class="bt-image-cropped" src="<?php echo esc_attr($image_resize['url']); ?>" alt="">
									</div>
									<?php
								}else{
									?>
									<div class="item tb-blog-gallery <?php echo tb_filtercontent($i==0?'active':''); ?>">
										<img style="width:100%;" src="<?php echo esc_url($attachment_image[0]);?>" alt="" />
									</div>
									<?php
								}
								$i++;
							}else{
								if(has_post_thumbnail()){
									$attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full', false);
									if($tb_blog_crop_image){
										$image_resize = matthewruddy_image_resize( $attachment_image[0], $width_image, $height_image, true, false );
										echo '<img style="width:100%;" class="bt-image-cropped" src="'. esc_attr($image_resize['url']) .'" alt="">';
									}else{
										the_post_thumbnail();
									}
								}else{
									if($image_default['url']){
										if($tb_blog_crop_image){
											$image_resize = matthewruddy_image_resize( $image_default['url'], $width_image, $height_image, true, false );
											echo '<img style="width:100%;" class="bt-image-cropped" src="'. esc_attr($image_resize['url']) .'" alt="">';
										}else{
											echo '<img alt="Image-Default" class="attachment-thumbnail wp-post-image" src="'. esc_attr($image_default['url']) .'">';
										}
									}
								}
							}
						}
					?>
                </div>
                <a class="left carousel-control" href="#carousel-generic<?php echo esc_attr($date); ?>" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left ion-ios7-arrow-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-generic<?php echo esc_attr($date); ?>" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right ion-ios7-arrow-right"></span>
                </a>
            </div>
        <?php elseif (has_post_thumbnail() && ! post_password_required() && ! is_attachment()): ?>
            <div class="tb-blog-image">
                <?php the_post_thumbnail(); ?>
            </div>
        <?php endif; ?>
    </div>
	<div class="tb-content-block">
		<?php if($show_desc) echo '<div class="blog-desc">'.tb_custom_excerpt($excerpt_length , $excerpt_more).'</div>'; ?>
		<?php if($show_info) echo tb_theme_info_bar_render(); ?>
	</div>
</article>

