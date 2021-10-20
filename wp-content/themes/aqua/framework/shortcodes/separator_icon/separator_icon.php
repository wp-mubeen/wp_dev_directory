<?php
function tb_separator_icon_func($atts) {
    extract(shortcode_atts(array(
        'spr_icon' => '',
		'spr_width' => '',
		'spr_align' => '',
        'animation' => '',
        'el_class' => ''
    ), $atts));

    $style = $class = array();
	$style[] = 'width: '.$spr_width.';' ;
	switch($spr_align){
		case 'left':
			$style[] = 'margin-left: 0;' ;
			break;
		case 'center':
			$style[] = 'margin: auto;' ;
			break;
		case 'right':
			$style[] = 'margin-right: 0;' ;
			break;
	}
	
    $class[] = 'separator-icon text-center';
    $class[] = getCSSAnimation($animation);
    $class[] = $el_class;
	
    ob_start();
    ?>
	<div class="<?php echo esc_attr(implode(' ', $class)); ?>" style="<?php echo esc_attr(implode(' ', $style)); ?>">
		<span><?php if($spr_icon) echo '<i class="'.esc_attr($spr_icon).'"></i>'; ?></span>
	</div>
    <?php
    return ob_get_clean();
}

if(function_exists('insert_shortcode')) { insert_shortcode('tb_separator_icon', 'tb_separator_icon_func'); }
