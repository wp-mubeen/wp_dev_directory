<article id="post_<?php the_ID() ?>" <?php post_class('tb-grid-item'); ?>>
    <div class="tb-grid-item-inner text-center">
		<?php echo ( $show_title || $show_description )? "<div class='tb-info-grid-item'>" : ""; ?>
        <?php if($show_title){ ?>
            <h3 class="tb-grid-title text-ellipsis"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <?php } ?>
        <?php if($show_description){ ?>
            <div class="tb-grid-desc">
                <?php echo tb_custom_excerpt($excerpt_length, $excerpt_more); ?>
            </div>
        <?php } ?>
		<?php echo ( $show_title || $show_description )? "</div>" : ""; ?>
        <?php if(has_post_thumbnail()){ ?>
            <div class="tb-grid-image tbblur">
                <?php
                $attachment_full_image = '';
                $attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full', false);
                $attachment_full_image = $attachment_image[0];
                if($crop_image){
                    $image_resize = matthewruddy_image_resize( $attachment_image[0], $width_image, $height_image, true, false );
                    echo '<img class="cropped" src="'. esc_attr($image_resize['url']) .'" alt="">';
                }else{
                   echo get_the_post_thumbnail(get_the_ID());
                }
                ?>
            </div>
			<div class="colorbox-wrap colorbox-grid-custom">
				<a class="colorbox view-image cboxElement" href="<?php echo esc_attr($image_resize['url']); ?>">
					<i class="fa fa-plus"></i>
				</a>
			</div>
        <?php } ?>
    </div>
</article>
