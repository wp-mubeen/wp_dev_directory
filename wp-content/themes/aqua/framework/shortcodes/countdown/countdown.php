<?php
function tb_countdown_render($params, $content = null) {
    extract(shortcode_atts(array(
        'date_end' => '2016/20/20 12:34:56',
		'el_class' => '',
    ), $params));
	wp_enqueue_script('jq.countdown.min', URI_PATH . '/assets/js/jquery.countdown.min.js');
    ob_start();
    ?>
	<div class="tb-countdown-js <?php echo esc_attr($el_class); ?>" data-countdown="<?php echo esc_attr($date_end); ?>"><?php _e('Countdown Element','aqua'); ?></div>
    <?php
    return ob_get_clean();
}

if(function_exists('insert_shortcode')) { insert_shortcode('tb_countdown', 'tb_countdown_render'); }
?>