<?php
function ro_demo_item($params, $content = null) {
    extract(shortcode_atts(array(
		'type' => 'demo',
        'demo_image' => '',
        'title' => '',
        'btn_label' => '',
        'btn_link' => '#',
        'el_class' => ''
    ), $params));
	$class = array();
    $class[] = 'ro-demo-item';
    $class[] = $el_class;
    ob_start();
    ?>
	<div class="<?php echo esc_attr(implode(' ', $class)); ?>">
		<div class="ro-content">
			<?php $attachment_image = wp_get_attachment_image_src($demo_image, 'full', false); ?>
			<img src="<?php echo esc_url($attachment_image[0]); ?>" alt="demo page" />
			<div class="ro-overlay<?php echo esc_attr(' '.$type); ?>">
				<div class="ro-cell-vertical-wrapper">
					<?php if($type == 'comming') { ?>
						<div class="ro-cell-middle"><h5 class="ro-title"><?php echo $title; ?></h5></div>
					<?php } ?>
					<?php if($type == 'demo') { ?>
						<div class="ro-cell-middle"><a class="ro-btn-bd-2" href="<?php echo esc_url($btn_link); ?>" target="_blank"><?php echo $btn_label; ?></a></div>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php if($type == 'demo') { ?>
			<h5 class="ro-title"><?php echo $title; ?></h5>
		<?php } ?>
	</div>
    <?php
    return ob_get_clean();
}

if(function_exists('insert_shortcode')) { insert_shortcode('demo_item', 'ro_demo_item'); }