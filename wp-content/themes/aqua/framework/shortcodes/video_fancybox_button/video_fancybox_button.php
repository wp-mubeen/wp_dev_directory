<?php
function ro_video_fancybox_button_func($atts) {
    extract(shortcode_atts(array(
        'image' => '',
        'video_link' => '#',
        'el_class' => ''
    ), $atts));

    $class = array();
	$class[] = 'ro-fancybox-wrap';
	$class[] = $el_class;
    ob_start();
    ?>
		<div class="<?php echo esc_attr(implode(' ', $class)); ?>">
			<a id="ro-play-button" class="fancybox fancybox.iframe" href="<?php echo esc_url($video_link); ?>">
				<?php echo wp_get_attachment_image($image, 'full'); ?>
			</a>
		</div>
    <?php
    return ob_get_clean();
}
if(function_exists('insert_shortcode')) { insert_shortcode('video_fancybox_button', 'ro_video_fancybox_button_func');}
