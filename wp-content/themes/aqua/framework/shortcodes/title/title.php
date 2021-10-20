<?php
function tb_title_func($atts) {
    $title = $color = $align = $underline =$animation = $el_class = '';
    extract(shortcode_atts(array(
        'title' => '',
		'title_tpl' => 'tpl1',
		'sub_title' => '',
		'title_background' => '',
		'font_size' => '',
        'color' => '',
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
	$layout = "";
	if ($title_tpl == 'tpl1'){
		ob_start();
		?>
			<h3 class="<?php echo esc_attr(implode(' ', $class)); ?>" <?php if($style)echo 'style="'.esc_attr(implode('; ', $style)).'"'; ?>>
				<?php echo tb_filtercontent($title);?>
			</h3>
		<?php
		$layout = ob_get_clean();
	} elseif ($title_tpl == 'tpl2'){
		$bg_title = wp_get_attachment_image_src($title_background, 'full');
		ob_start();
		?>
			<div class="wbp-title <?php echo tb_filtercontent($title_tpl). ' ' .tb_filtercontent($el_class); ?>">
				<div class="wbp-title-content" style="background: url('<?php echo tb_filtercontent($bg_title[0]); ?>') center center; background-size: cover;">
					<h1 class="<?php echo esc_attr(implode(' ', $class)); ?>" <?php if($style)echo 'style="'.esc_attr(implode('; ', $style)).'"'; ?>>
						<?php echo tb_filtercontent($title);?>
					</h1>
					<p class="<?php echo tb_filtercontent($align); ?>"><?php echo tb_filtercontent($sub_title); ?></p>
				</div>
			</div>
		<?php
		$layout = ob_get_clean();
	}
	
	return $layout;
}

if(function_exists('insert_shortcode')) { insert_shortcode('title', 'tb_title_func'); }
