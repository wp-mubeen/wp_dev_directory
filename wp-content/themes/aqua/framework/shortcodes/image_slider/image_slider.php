<?php
function ro_image_slider_func($atts, $content = null) {
    extract(shortcode_atts(array(
        'images' => '',
        'ex_link' => '#',
        'el_class' => ''
    ), $atts));
	
    $class = array();
	$class[] = 'ro-images-slider';
	$class[] = $el_class;
	
	$images = explode(",", $images);
    ob_start();
    ?>
		<div id="ro-images-slider" class="<?php echo esc_attr(implode(' ', $class)); ?>">
			<ul class="slides">
				<?php foreach($images as $image) { ?>
					<li class="ro-item">
						<div class="ro-image">
							<a href="<?php echo esc_url($ex_link); ?>">
								<?php echo wp_get_attachment_image($image, 'full'); ?>
							</a>
						</div>
					</li>
				<?php } ?>
			</ul>
		</div>
    <?php
    return ob_get_clean();
}
if(function_exists('insert_shortcode')) { insert_shortcode('image_slider', 'ro_image_slider_func');}
