<?php
vc_map(array(
	"name" => __("Service Box", 'aqua'),
	"base" => "service_box",
	"category" => __('Aqua', 'aqua'),
	"icon" => "tb-icon-for-vc",
	"params" => array(
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Template", 'aqua'),
			"param_name" => "tpl",
			"value" => array(
				"Template 1" => "tpl1",
				"Template 2" => "tpl2",
				"Template 3" => "tpl3",
				"Template 4" => "tpl4",
				"Template 5" => "tpl5",
			),
			"description" => __('Select template in this element.', 'aqua')
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Background", 'aqua'),
			"param_name" => "tpl3_bg",
			"value" => "",
			"dependency" => array(
				"element"=>"tpl",
				"value"=>"tpl3"
			),
			"description" => __('Select background color in this element.', 'aqua')
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Template Style", 'aqua'),
			"param_name" => "tpl1_style",
			"value" => array(
				"Image Left" => "img_left",
				"Image Right" => "img_right",
				"Image Top" => "img_top",
			),
			"dependency" => array(
				"element"=>"tpl",
				"value"=> array("tpl1")
			),
			"description" => __('Select template style in this element.', 'aqua')
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Title", 'aqua'),
			"param_name" => "title",
			"value" => "",
			"description" => __("Please, enter title in this element.", 'aqua')
		),
		array(
			"type" => "attach_image",
			"class" => "",
			"heading" => __("Image", 'aqua'),
			"param_name" => "image",
			"value" => "",
			"description" => __("Select box image in this element.", 'aqua')
		),
		array(
			"type" => "textarea",
			"class" => "",
			"heading" => __("Description", 'aqua'),
			"param_name" => "desc",
			"value" => "",
			"description" => __("Please, enter description in this element.", 'aqua')
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Description Background", 'aqua'),
			"param_name" => "tpl1_desc_bg",
			"value" => "",
			"dependency" => array(
				"element"=>"tpl",
				"value"=>"tpl1"
			),
			"description" => __('Select background color for description.', 'aqua')
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
