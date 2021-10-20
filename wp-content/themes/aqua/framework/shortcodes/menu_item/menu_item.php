<?php
function tb_menu_item_func($atts) {
    extract(shortcode_atts(array(
        'title' => '',
		'price' => '',
        'animation' => '',
        'el_class' => ''
    ), $atts));

    $class = array();
    $class[] = 'tb-menu-text-item';      
    $class[] = getCSSAnimation($animation);
    $class[] = $el_class;
    ob_start();
    ?>
		<div class="<?php echo esc_attr(implode(' ', $class)); ?>">
			<div class="menu-item-inner">
				<span class="title"><?php echo tb_filtercontent($title);?></span>
				<span class="solid"></span>
				<span class="price"><?php echo tb_filtercontent($price);?></span>
			</div>
		</div>
    <?php
    return ob_get_clean();
}

if(function_exists('insert_shortcode')) { insert_shortcode('menu_item', 'tb_menu_item_func'); }
