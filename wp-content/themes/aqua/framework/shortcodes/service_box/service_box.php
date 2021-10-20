<?php
function ro_service_box_func($atts, $content = null) {
    extract(shortcode_atts(array(
        'tpl' => 'tpl1',
		'tpl1_style' => 'img_left',
		'tpl1_desc_bg' => '',
		'tpl3_bg' => '',
		'title' => '',
        'image' => '',
        'desc' => '',
        'ex_link' => '#',
        'el_class' => ''
    ), $atts));
	
    $class = array();
	$class[] = 'ro-service-wrap';
	$class[] = $el_class;
    ob_start();
    ?>
		<div class="<?php echo esc_attr(implode(' ', $class)); ?>">
			<?php include "tpl/{$tpl}.php"; ?>
		</div>
		
    <?php
    return ob_get_clean();
}
if(function_exists('insert_shortcode')) { insert_shortcode('service_box', 'ro_service_box_func');}
