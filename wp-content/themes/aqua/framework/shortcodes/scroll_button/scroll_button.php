<?php
function ro_scroll_button_func($atts) {
    extract(shortcode_atts(array(
        'scroll_link' => '#',
        'el_class' => ''
    ), $atts));

    $class = array();
	$class[] = 'ro-follow-button-wrap';
	$class[] = $el_class;
    ob_start();
    ?>
		<div class="<?php echo esc_attr(implode(' ', $class)); ?>">
			<a class="ro-follow-button" href="<?php echo esc_url($scroll_link); ?>"></a>
		</div>
    <?php
    return ob_get_clean();
}
if(function_exists('insert_shortcode')) { insert_shortcode('scroll_button', 'ro_scroll_button_func');}
