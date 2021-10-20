<div class="<?php echo esc_attr(implode(' ', $class)); ?>" <?php if($box_bg) echo 'style="background: '.$box_bg.'"' ?>>
	<div class="feature-block">
		<?php if($box_title){ ?>
			<h3 class="<?php echo esc_attr($cl_align); ?> <?php echo ($cl_align != 'text-center')? esc_attr('tb-border-zigzag') : esc_attr(''); ?>"><?php echo tb_filtercontent($box_title); ?></h3>
		<?php } ?>
		<?php if($box_icon){ ?>
			<div style="width: 70%; margin: auto;" class="separator-icon text-center">
				<span><i class="<?php echo esc_attr($box_icon); ?>"></i></span>
			</div>
		<?php } ?>
		<?php if($content){ ?>
			<div class="<?php echo esc_attr($cl_align); ?>"><?php echo tb_filtercontent($content); ?></div>
		<?php } ?>
	</div>
	<?php if($box_image){ ?>
		<div class="feature-image">
			<?php
				$attachment_image = wp_get_attachment_image_src($box_image, 'full', false);
				if($crop_image == true || $crop_image == 1):
					$image_resize = matthewruddy_image_resize( $attachment_image[0], $width_image, $height_image, true, false );
					$img_src =& $image_resize['url'];
				else :
					$img_src =& $attachment_image[0];
				endif;
				echo '<img style="width:100%;" class="bt-image-cropped" src="'. esc_attr($img_src) .'" alt="">';
			?>
			<?php if($box_colorbox_icon){ ?>
				<div class="colorbox-wrap">
					<a class="colorbox view-image" href="<?php echo esc_url($attachment_image[0]); ?>" title="<?php echo esc_attr($box_title); ?>">
						<i class="<?php echo esc_attr($box_colorbox_icon); ?>"></i>
					</a>
				</div>
			<?php } ?>
		</div>
	<?php } ?> 
</div>