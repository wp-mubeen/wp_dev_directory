<?php
vc_map ( array (
	"name" => 'Team',
	"base" => "team",
	"icon" => "tb-icon-for-vc",
	"category" => __ ( 'Aqua', 'aqua' ), 
	'admin_enqueue_js' => array(URI_PATH_FR.'/admin/assets/js/customvc.js'),
	"params" => array (
		array (
			"type" => "tb_taxonomy",
			"taxonomy" => "team_category",
			"heading" => __ ( "Categories", 'aqua' ),
			"param_name" => "category",
			"description" => __ ( "Note: By default, all your projects will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed.", 'aqua' )
		),
		
		array (
			"type" => "textfield",
			"heading" => __ ( 'Count', 'aqua' ),
			"param_name" => "posts_per_page",
			'value' => '',
			"description" => __ ( 'The number of posts to display on each page. Set to "-1" for display all posts on the page.', 'aqua' )
		),
		array (
			"type" => "dropdown",
			"heading" => __ ( 'Order by', 'aqua' ),
			"param_name" => "orderby",
			"value" => array (
					"None" => "none",
					"Title" => "title",
					"Date" => "date",
					"ID" => "ID"
			),
			"description" => __ ( 'Order by ("none", "title", "date", "ID").', 'aqua' )
		),
		array (
			"type" => "dropdown",
			"heading" => __ ( 'Order', 'aqua' ),
			"param_name" => "order",
			"value" => Array (
					"None" => "none",
					"ASC" => "ASC",
					"DESC" => "DESC"
			),
			"description" => __ ( 'Order ("None", "Asc", "Desc").', 'aqua' )
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Extra Class", 'aqua'),
			"param_name" => "el_class",
			"value" => "",
			"description" => __ ( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'aqua' )
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Template", 'aqua'),
			"param_name" => "tpl",
			"value" => array(
				"Template 1" => "tpl1",
				"Template 2" => "tpl2",
			),
			"group" => __("Template", 'aqua'),
			"description" => __('Select template in this element.', 'aqua')
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Show Image", 'aqua'),
			"param_name" => "show_image",
			"value" => array (
				__ ( "Yes, please", 'aqua' ) => true
			),
			"group" => __("Template", 'aqua'),
			"description" => __("Show or not featured image of post in this element.", 'aqua')
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Show Ttile", 'aqua'),
			"param_name" => "show_title",
			"value" => array (
				__ ( "Yes, please", 'aqua' ) => true
			),
			"group" => __("Template", 'aqua'),
			"description" => __("Show or not title of post in this element.", 'aqua')
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Show Excerpt", 'aqua'),
			"param_name" => "show_excerpt",
			"value" => array (
				__ ( "Yes, please", 'aqua' ) => true
			),
			"group" => __("Template", 'aqua'),
			"description" => __("Show or not excerpt of post in this element.", 'aqua')
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Show Position", 'aqua'),
			"param_name" => "show_position",
			"value" => array (
				__ ( "Yes, please", 'aqua' ) => true
			),
			"group" => __("Template", 'aqua'),
			"description" => __("Show or not position of post in this element.", 'aqua')
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Show Social", 'aqua'),
			"param_name" => "show_social",
			"value" => array (
				__ ( "Yes, please", 'aqua' ) => true
			),
			"group" => __("Template", 'aqua'),
			"description" => __("Show or not social of post in this element.", 'aqua')
		),
	)
));