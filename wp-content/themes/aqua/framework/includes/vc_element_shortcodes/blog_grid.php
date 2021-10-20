<?php
vc_map ( array (
	"name" => 'Blog Grid',
	"base" => "blog_grid",
	"icon" => "tb-icon-for-vc",
	"category" => __ ( 'Aqua', 'aqua' ), 
	'admin_enqueue_js' => array(URI_PATH_FR.'/admin/assets/js/customvc.js'),
	"params" => array (
		array (
				"type" => "tb_taxonomy",
				"taxonomy" => "category",
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
		array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Columns", 'aqua'),
				"param_name" => "columns",
				"value" => array(
					"4 Columns" => "4",
					"3 Columns" => "3",
					"2 Columns" => "2",
					"1 Column" => "1",
				),
				"description" => __('Select columns display in this element.', 'aqua')
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
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Show Image", 'aqua'),
			"param_name" => "show_image",
			"value" => array (
				__ ( "Yes, please", 'aqua' ) => true
			),
			"group" => __("Template", 'aqua'),
			"description" => __("Show or not image of post in this element.", 'aqua')
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
			"heading" => __("Show Info", 'aqua'),
			"param_name" => "show_info",
			"value" => array (
				__ ( "Yes, please", 'aqua' ) => true
			),
			"group" => __("Template", 'aqua'),
			"description" => __("Show or not info of post in this element.", 'aqua')
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
	)
));