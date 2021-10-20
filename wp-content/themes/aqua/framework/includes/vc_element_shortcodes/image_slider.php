<?php
vc_map(array(
	"name" => __("Images Slider", 'aqua'),
	"base" => "image_slider",
	"category" => __('Aqua', 'aqua'),
	"icon" => "tb-icon-for-vc",
	"params" => array(
		array(
			"type" => "attach_images",
			"class" => "",
			"heading" => __("Images", 'aqua'),
			"param_name" => "images",
			"value" => "",
			"description" => __("Select box images in this element.", 'aqua')
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Extra Link", 'aqua'),
			"param_name" => "ex_link",
			"value" => "",
			"description" => __("Please, enter extra link in this element.", 'aqua')
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Extra Class", 'aqua'),
			"param_name" => "el_class",
			"value" => "",
			"description" => __ ( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'aqua' )
		),
	)
));
