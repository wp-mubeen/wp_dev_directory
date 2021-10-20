<?php
function tb_plan_render($atts, $content = null) {
    global $post;
    extract(shortcode_atts(array(
            'name' => '',
			'img' => '',
            'featured' => 0,
            'price' => '',
			'currency' => '',
			'unit' => '',
			'btn_label' => '',
            'url' => '#',
            'target' => '_self',
            'el_class' => ''
    ), $atts));
    $plan_class = 'plan';
    $featured_text = $featured==1?'<span class="uk-badge uk-badge-danger">'.__('Popular', 'aqua').'</span>':'';
    $plan_class .= $featured==1?' featured':'';
    $plan_class .= $el_class!=''?' '.$el_class:'';
    ob_start();
    ?>
        <ul class="<?php echo esc_attr($plan_class);?>"><li class="plan-name"><h5><?php echo tb_filtercontent($name);?></h5> <?php echo tb_filtercontent($featured_text);?></li>
            <li class="plan-price">
				<?php echo wp_get_attachment_image( $img, 'full' ); ?>
				<?php echo '<div class="tb-overlay"><div class="tb-cell-vertical-wrapper"><div class="tb-cell-middle"><h1><span class="tb-small">'.$currency.'</span>'.$price.'</h1><h5>'.$unit.'</h5></div></div></div>';?>
			</li>
            <?php echo tb_filtercontent($content);?>
            <li><a target="<?php echo tb_filtercontent($target);?>" href="<?php echo tb_filtercontent($url);?>" class="tb-btn-bd-1"><?php echo tb_filtercontent($btn_label); ?></a></li>
        </ul>
    <?php
    return ob_get_clean();
}
if(function_exists('insert_shortcode')) {
	insert_shortcode('tb_plan', 'tb_plan_render');
}