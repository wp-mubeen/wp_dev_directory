<?php
function tb_btnplay($params, $content = null) {
    extract(shortcode_atts(array(
        'icon' => 'fa fa-play',
        'style' => 'circle',
        'el_class' => '',		
        'text' => '',		
    ), $params));
	$class = "tb-videobg-control-btn";
	$class .= " control-btn-".$style;
	if($el_class) $class .= ' '.$el_class;
	ob_start();
    ?>
		<div class="<?php echo esc_attr($class);?>">
			<?php if($text):?>
			<div class="tb-fonts-giant"><?php echo tb_filtercontent($text);?>&nbsp; <i class="<?php echo esc_attr($icon);?>"></i></div>
			<?php else: ?>
			<i class="<?php echo esc_attr($icon);?>"></i>
			<?php endif;?>
			
		</div>
	<?php
    return ob_get_clean();
}
if(function_exists('insert_shortcode')) { insert_shortcode('btnplay', 'tb_btnplay'); }
