<?php
function tb_bubble_render($params, $content = null) {
    extract(shortcode_atts(array(
        'author' => '',
        'color' => '',
        'background' => '',
        'border_width' => '',
        'border_style' => '',
        'border_color' => '',
        'padding' => '10px',
    ), $params));
    $style = array();
    $style[] = "margin-bottom: 40px;";
    $cite = null;
    $style_content = null;
    if($border_color){
        $cite="border:15px solid {$border_color}";
    }else if($background){
        $cite="border:15px solid {$background}";
    }
    if($color) $style_content = "color:{$color}";
    if($background) $style[] = "background:{$background}";
    if($border_width) $style[] = "border-width:{$border_width}";
    if($border_style) $style[] = "border-style:{$border_style}";
    if($border_color) $style[] = "border-color:{$border_color}";
    if($padding||$padding==0) $style[] = "padding:{$padding}";
    ob_start();
    ?>
    <div style="<?php echo implode(';',$style);?>" class="tb_bubble">
        <div style="<?php echo tb_filtercontent($style_content);?>"><?php echo tb_filtercontent($content); ?></div>
        <p><cite><span style="<?php echo tb_filtercontent($cite);?>"></span><?php echo tb_filtercontent($author);?></cite></p>
    </div>
    <?php
    return ob_get_clean();
}

if(function_exists('insert_shortcode')) { insert_shortcode('tb_bubble', 'tb_bubble_render'); }
