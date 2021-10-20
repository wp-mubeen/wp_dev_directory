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
if(is_home()){
	$image_default = '';
	$tb_blog_crop_image = 0;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="tb-blog-gallery">
        <?php
        $date = time() . '_' . uniqid(true);
        $gallery_ids = tb_theme_grab_ids_from_gallery()->ids;
        if(!empty($gallery_ids)):
        ?>
            <div id="carousel-generic<?php echo tb_filtercontent($date); ?>" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
					<?php
					if(!is_home()){
						$i = 0;
						foreach ($gallery_ids as $image_id){
							$attachment_image = wp_get_attachment_image_src($image_id, 'full', false);
							if($attachment_image[0]){
								if($tb_blog_crop_image){
									$image_resize = matthewruddy_image_resize( $attachment_image[0], $tb_blog_image_width, $tb_blog_image_height, true, false );
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
										$image_resize = matthewruddy_image_resize( $attachment_image[0], $tb_blog_image_width, $tb_blog_image_height, true, false );
										echo '<img style="width:100%;" class="bt-image-cropped" src="'. esc_attr($image_resize['url']) .'" alt="">';
									}else{
										the_post_thumbnail();
									}
								}else{
									if($image_default['url']){
										if($tb_blog_crop_image){
											$image_resize = matthewruddy_image_resize( $image_default['url'], $tb_blog_image_width, $tb_blog_image_height, true, false );
											echo '<img style="width:100%;" class="bt-image-cropped" src="'. esc_attr($image_resize['url']) .'" alt="">';
										}else{
											echo '<img alt="Image-Default" class="attachment-thumbnail wp-post-image" src="'. esc_attr($image_default['url']) .'">';
										}
									}
								}
							}
						}
					}
					?>
                </div>
                <a class="left carousel-control" href="#carousel-generic<?php echo tb_filtercontent($date); ?>" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left ion-ios7-arrow-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-generic<?php echo tb_filtercontent($date); ?>" role="button" data-slide="next">
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
		<?php if($tb_show_post_title) echo tb_theme_title_render(); ?>
		<?php if($tb_show_post_desc) echo tb_theme_content_render(); ?>
		<div style="clear: both"></div>
		<?php if($tb_show_post_info) echo tb_theme_info_bar_render(); ?>
		<?php if(is_single() && $tb_post_show_social_share) echo tb_theme_social_share_post_render(); ?>
		<?php if(is_single() && $tb_post_show_post_tags) echo tb_theme_tags_render(); ?>
		<?php if(is_single() && $tb_post_show_post_author) echo tb_theme_author_render(); ?>
	</div>
</article>

