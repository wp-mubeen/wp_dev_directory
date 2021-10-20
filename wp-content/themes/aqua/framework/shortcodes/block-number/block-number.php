<?php
function tb_block_number_render($atts) {
    $type = $text = $title = $block_number_content = $color = $background = $el_class = $text_attr = '';
    extract(shortcode_atts(array(
        'type' => '',
        'text' => '',
        'title' => '',
        'block_number_content' => '',
        'color' => '',
        'background' => '',
        'el_class' => ''
    ), $atts));

    $class = array();
    $class[] = 'tb_blocknumber';
    $class[] = $el_class;
    
    if($color != '' || $background != ''){
        $text_attr .= ' style="';
        if($color != ''){ $text_attr .= 'color:'.esc_attr($color).';'; }
        if($background != ''){ $text_attr .= 'background:'.esc_attr($background).';'; }
        $text_attr .= '"';
    }
    ob_start();
    
    ?>
    <div class="<?php echo esc_attr(implode(' ', $class)); ?>">
        <span class="<?php echo esc_attr($type); ?>" <?php echo tb_filtercontent($text_attr); ?>><?php echo tb_filtercontent($text); ?></span>
        <?php if(!empty($title)){ ?>
            <h4 class="box-title"><strong><?php echo tb_filtercontent($title); ?></strong></h4>
        <?php } ?>
        <?php echo tb_filtercontent($block_number_content); ?>
    </div>
    <?php
    
    return ob_get_clean();
}

if(function_exists('insert_shortcode')) { insert_shortcode('tb_block_number', 'tb_block_number_render'); }
