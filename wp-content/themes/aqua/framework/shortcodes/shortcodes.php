<?php
$elements = array(
	'video',
	'title',
	'feature_box',
	'post_carousel',
	'client_carousel',
	'portfolio_carousel',
	'testimonial_carousel',
	'team_carousel',
	'icon',
	'separator_icon',
	'blog',
	'btnplay',
	'grid',
	'menu_item',
	'plan',
	'block-number',
	'block-text',
	'dropcap',
	'bubble',
	'social',
	'maps',
	'booking',
	'countdown',
	'demo_item',
	'service_box',
	'service_list',
	'team',
	'testimonial_slider',
	'membership',
	'blog_grid',
	'image_slider',
	'video_fancybox_button',
	'scroll_button',
);

foreach ($elements as $element) {
	include($element .'/'. $element.'.php');
}

if(class_exists('Woocommerce')){
	$wooshops = array(
		'product_carousel',
		'product_list',
	);
	
	foreach ($wooshops as $wooshop) {
		include($wooshop .'/'. $wooshop.'.php'); 
	}
}
