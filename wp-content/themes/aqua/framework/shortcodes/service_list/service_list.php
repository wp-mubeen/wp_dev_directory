<?php
function ro_service_list_func($atts) {
    extract(shortcode_atts(array(
		'title1' => '',
        'price1' => '',
		'title2' => '',
        'price2' => '',
		'title3' => '',
        'price3' => '',
		'title4' => '',
        'price4' => '',
		'title5' => '',
        'price5' => '',
		'title6' => '',
        'price6' => '',
		'title7' => '',
        'price7' => '',
		'title8' => '',
        'price8' => '',
		'title9' => '',
        'price9' => '',
		'title10' => '',
        'price10' => '',
        'el_class' => ''
    ), $atts));

    $class = array();
	$class[] = 'ro-service-list-wrap';
	$class[] = $el_class;
    ob_start();
    ?>
		<div class="<?php echo esc_attr(implode(' ', $class)); ?>">
			<div class="panel-body mCustomScrollbar" data-mcs-theme="minimal-dark">
				<div class="ro-service-list">
					<ul>
						<?php if($title1 && $price1) { ?>
							<li>
								<div class="ro-service"><?php echo esc_html($title1); ?></div>
								<div class="ro-separator"></div>
								<div class="ro-price"><?php echo esc_html($price1); ?></div>
							</li>
						<?php } ?>
						<?php if($title2 && $price2) { ?>
							<li>
								<div class="ro-service"><?php echo esc_html($title2); ?></div>
								<div class="ro-separator"></div>
								<div class="ro-price"><?php echo esc_html($price2); ?></div>
							</li>
						<?php } ?>
						<?php if($title3 && $price3) { ?>
							<li>
								<div class="ro-service"><?php echo esc_html($title3); ?></div>
								<div class="ro-separator"></div>
								<div class="ro-price"><?php echo esc_html($price3); ?></div>
							</li>
						<?php } ?>
						<?php if($title4 && $price4) { ?>
							<li>
								<div class="ro-service"><?php echo esc_html($title4); ?></div>
								<div class="ro-separator"></div>
								<div class="ro-price"><?php echo esc_html($price4); ?></div>
							</li>
						<?php } ?>
						<?php if($title5 && $price5) { ?>
							<li>
								<div class="ro-service"><?php echo esc_html($title5); ?></div>
								<div class="ro-separator"></div>
								<div class="ro-price"><?php echo esc_html($price5); ?></div>
							</li>
						<?php } ?>
						<?php if($title6 && $price6) { ?>
							<li>
								<div class="ro-service"><?php echo esc_html($title6); ?></div>
								<div class="ro-separator"></div>
								<div class="ro-price"><?php echo esc_html($price6); ?></div>
							</li>
						<?php } ?>
						<?php if($title7 && $price7) { ?>
							<li>
								<div class="ro-service"><?php echo esc_html($title7); ?></div>
								<div class="ro-separator"></div>
								<div class="ro-price"><?php echo esc_html($price7); ?></div>
							</li>
						<?php } ?>
						<?php if($title8 && $price8) { ?>
							<li>
								<div class="ro-service"><?php echo esc_html($title8); ?></div>
								<div class="ro-separator"></div>
								<div class="ro-price"><?php echo esc_html($price8); ?></div>
							</li>
						<?php } ?>
						<?php if($title9 && $price9) { ?>
							<li>
								<div class="ro-service"><?php echo esc_html($title9); ?></div>
								<div class="ro-separator"></div>
								<div class="ro-price"><?php echo esc_html($price9); ?></div>
							</li>
						<?php } ?>
						<?php if($title10 && $price10) { ?>
							<li>
								<div class="ro-service"><?php echo esc_html($title10); ?></div>
								<div class="ro-separator"></div>
								<div class="ro-price"><?php echo esc_html($price10); ?></div>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
    <?php
    return ob_get_clean();
}
if(function_exists('insert_shortcode')) { insert_shortcode('service_list', 'ro_service_list_func'); }