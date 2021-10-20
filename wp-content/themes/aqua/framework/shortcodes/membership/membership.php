<?php
function ro_membership_func($atts) {
    extract(shortcode_atts(array(
        'title' => '',
		'image' => '',
		'price' => '',
		'unit' => '',
		'per_time' => '',
		'option1' => '',
		'option2' => '',
		'option3' => '',
		'option4' => '',
		'option5' => '',
		'option6' => '',
		'option7' => '',
		'option8' => '',
        'btn_text' => '',
        'btn_link' => '#',
		'ex_link' => '#',
        'el_class' => ''
    ), $atts));
	
    $class = array();
    $class[] = 'ro-membership-item';
    $class[] = $el_class;	
	ob_start();
    ?>
	<div class="<?php echo esc_attr(implode(' ', $class)); ?>">
		<a href="<?php echo esc_url($ex_link); ?>">
			<div>
				<?php if($title) echo '<h5>'.esc_html($title).'</h5>'; ?>
				<div class="ro-price">
					<?php echo wp_get_attachment_image($image, 'full'); ?>
					<div class="ro-overlay">
						<div class="ro-cell-vertical-wrapper">
							<div class="ro-cell-middle">
								<?php if($price) echo '<h1><span class="ro-small">'.esc_html($unit).'</span>'.esc_html($price).'</h1>'; ?>
								<?php if($per_time) echo '<h5>'.esc_html($per_time).'</h5>'; ?>
							</div>
						</div>
					</div>
				</div>
				<ul class="ro-option">
					<?php
						if($option1) echo '<li>'.esc_html($option1).'</li>'; 
						if($option2) echo '<li>'.esc_html($option2).'</li>'; 
						if($option3) echo '<li>'.esc_html($option3).'</li>'; 
						if($option4) echo '<li>'.esc_html($option4).'</li>'; 
						if($option5) echo '<li>'.esc_html($option5).'</li>'; 
						if($option6) echo '<li>'.esc_html($option6).'</li>'; 
						if($option7) echo '<li>'.esc_html($option7).'</li>'; 
						if($option8) echo '<li>'.esc_html($option8).'</li>'; 
					?>
				</ul>
				<?php if($btn_text) echo '<a href="'.esc_url($btn_link).'" class="ro-btn-bd-1">'.$btn_text.'</a>'; ?>
			</div>
		</a>
	</div>
    <?php
    return ob_get_clean();
}

if(function_exists('insert_shortcode')) { insert_shortcode('membership', 'ro_membership_func'); }
