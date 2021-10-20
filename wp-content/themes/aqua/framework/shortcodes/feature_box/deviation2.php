<?php
	global $tb_options;
	$image_default = isset($tb_options['tb_blog_image_default']) ? $tb_options['tb_blog_image_default'] : '';
	$_thumb = '';
	if($box_image){
		$attachment_image = wp_get_attachment_image_src($box_image, 'full', false);
		//print_r($attachment_image);
		$url = !empty($crop_image)? matthewruddy_image_resize( $attachment_image[0], $width_image, $height_image, true, false ) : wp_get_attachment_image_src($box_image, 'full', false);
	}else{
		$url = ($tb_blog_crop_image)? matthewruddy_image_resize( $image_default['url'], $width_image, $height_image, true, false ) : $image_default;
	}
	$_thumb = $url[0];
?>
<div class="<?php echo esc_attr(implode(' ', $class)); ?>">
	<div class="image-bg clearfix" style="background-image: url('<?php echo tb_filtercontent($_thumb); ?>');">
		<div class="row">
			<div class="deviation-feature-box col-md-8<?php echo tb_filtercontent($box_align == 'right'?' col-md-offset-4':''); ?>">		
				<div class="deviation-content-info text-center">
					<?php 
						echo ($box_title)? "<h3 class='feature-box-title blog-title'><a href='$link_redirect'>{$box_title}</a></h3>" : "";
						echo ($content)? $content : "";
						echo ($link_redirect)? "<a class='deviation-link-more' href='$link_redirect'><i class='ion-ios-arrow-thin-right'></i></a>" : "";
					?>
				</div>
			</div>
		</div>
	</div>
</div>