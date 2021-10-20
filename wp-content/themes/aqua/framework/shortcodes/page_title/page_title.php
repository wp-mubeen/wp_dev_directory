<?php
function tb_title_func($atts) {
    $title = $color = $align = $underline =$animation = $el_class = '';
    extract(shortcode_atts(array(
        'title' => '',
		'font_size' => '34px',
        'color' => '#666666',
        'align' => '',
        'underline' => '',
        'animation' => '',
        'el_class' => ''
    ), $atts));

    $class = $style = array();
    $class[] = 'headline';
    $class[] = $align;
    if($underline == 1){
        $class[] = 'underline';
    }  
	if($font_size){
        $style[] = "font-size: $font_size";
    }
    if($color){
        $style[] = "color: $color";
    }       
    $class[] = getCSSAnimation($animation);
    $class[] = $el_class;
    ob_start();
    ?>
		<h3 class="<?php echo esc_attr(implode(' ', $class)); ?>" <?php if($style)echo 'style="'.esc_attr(implode('; ', $style)).'"'; ?>>
			<?php echo tb_filtercontent($title);?>
			<span class="line"></span>
		</h3>
    <?php
    return ob_get_clean();
}

if(function_exists('insert_shortcode')) { insert_shortcode('title', 'tb_title_func'); }
