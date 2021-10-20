<div class="<?php echo esc_attr(implode(' ', $class)); ?>">
	<?php if($box_icon || $box_image){ ?>
		<div class="feature-icon-image text-center">
			<?php if($box_type == 'icon'){ ?>
				<i class="<?php echo esc_attr($box_icon); ?>"></i>
			<?php }else{ ?>
				<?php
					echo wp_get_attachment_image( $box_image, 'thumbnail' );
					$attachment_image = wp_get_attachment_image_src($box_image, 'full', false);
				?>
				<?php if($box_colorbox_icon){ ?>
				<div class="colorbox-wrap">
					<a class="colorbox view-image" href="<?php echo esc_url($attachment_image[0]); ?>" title="<?php echo esc_attr($box_title); ?>">
						<i class="<?php echo esc_attr($box_colorbox_icon); ?>"></i>
					</a>
				</div>
			<?php } ?>
			<?php } ?>
		</div>
	<?php } ?>
	<div class="feature-block">
		<?php if($box_title){ ?>
			<h4 class="<?php echo esc_attr($cl_align); ?>"><?php echo tb_filtercontent($box_title); ?></h4>
		<?php } ?>
		<?php if($content){ ?>
			<div class="<?php echo esc_attr($cl_align); ?>"><?php echo tb_filtercontent($content); ?></div>
		<?php } ?>
	</div>
</div>