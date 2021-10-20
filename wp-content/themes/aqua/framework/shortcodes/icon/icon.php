<?php
function tb_icon($params, $content = null) {
    extract(shortcode_atts(array(
        'type' => '',
        'color'=>'',
        'link' => '',
        'class' => '',
        'fontsize'=>''
    ), $params));
    if($color!=''){
        $color='color:'.$color.';';
    }
    if($fontsize!=''){
        $fontsize=' font-size:'.$fontsize.';';
    }
    if($content){
    	$content = '<span class="tb_icon"> '.esc_attr($content).'</span>';
    }
    ob_start();
    ?>
    <?php if($link): ?>
    	<a class="tb_icon" target="_blank" href="<?php echo esc_url($link); ?>">
    		<i class=" <?php echo esc_attr($type) . ' ' . esc_attr($class);?>" style="<?php echo esc_attr($color).esc_attr($fontsize);?>">
    			<?php echo tb_filtercontent($content); ?>
    		</i>
    	</a>
    <?php else : ?>
        <i class=" <?php echo esc_attr($type) . ' ' . esc_attr($class);?>" style="<?php echo esc_attr($color).esc_attr($fontsize);?>">
            <?php echo tb_filtercontent($content); ?>
    	</i>
    <?php endif; ?>
    <?php
    return ob_get_clean();
}

if(function_exists('insert_shortcode')) { insert_shortcode('icon', 'tb_icon'); }