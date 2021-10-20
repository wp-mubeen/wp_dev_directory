<?php
function tb_feature_box_func($atts, $content = null) {
    extract(shortcode_atts(array(
        'box_type' => '',
		'box_tpl' => 'tpl1',
		'box_colorbox_icon' => '',
		'box_bg' => '',
		'box_arrow' => '',
		'box_align' => 'left',
		'link_redirect' => '',
        'box_style' => '',
        'box_icon' => '',
        'box_image' => '',
		'crop_image' => 0,
		'width_image' => 300,
		'height_image' => 200,
        'box_title' => '',
        'headding_size' => '',
        'animation' => '',
        'el_class' => ''
    ), $atts));
	
    $class = array();
    $class[] = 'feature-box';
    $class[] = $box_type;
	$class[] = $box_tpl;
	$class[] = $box_align;
	// if($box_tpl == 'tpl3' && $box_arrow)$class[] = $box_arrow;
	if($box_tpl == 'tpl2' && $box_arrow)$class[] = $box_arrow;
	if($box_tpl == 'tpl1')$class[] = $box_style;
    $class[] = getCSSAnimation($animation);
    $class[] = $el_class;
	
	$cl_align = '';
	switch ($box_align){
		case 'left':
			$cl_align = 'text-left';
			break;
		case 'center':
			$cl_align = 'text-center';
			break;
		case 'right':
			$cl_align = 'text-right';
			break;
	}
	
    ob_start();
    
	include "$box_tpl.php";
    
    
    return ob_get_clean();
}

if(function_exists('insert_shortcode')) { insert_shortcode('tb_feature_box', 'tb_feature_box_func'); }
