<?php
vc_map(array(
	"name" => __("Scroll Button", 'aqua'),
	"base" => "scroll_button",
	"category" => __('Aqua', 'aqua'),
	"icon" => "tb-icon-for-vc",
	"params" => array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Scroll Link", 'aqua'),
			"param_name" => "scroll_link",
			"value" => "",
			"description" => __("Please, enter scroll link in this element. Ex: #about.", 'aqua')
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
