<?php
vc_map ( array (
		"name" => 'Team Carousel',
		"base" => "tb_team_carousel",
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
							"type" => "dropdown",
							"class" => "",
							"heading" => __ ( "Template", 'aqua' ),
							"param_name" => "tpl",
							"value" => array (
								"Default" => "default",
								"Improved" => "improved",
								"Sky Carousel" => "sky",
								"Normal" => "normal",
							),
							"description" => __ ( "", 'aqua' )
					),
					array (
							"type" => "checkbox",
							"heading" => __ ( 'Crop image', 'aqua' ),
							"param_name" => "crop_image",
							"value" => array (
									__ ( "Yes, please", 'aqua' ) => true
							),
							"description" => __ ( 'Crop or not crop image on your Post.', 'aqua' )
					),
					array (
							"type" => "textfield",
							"heading" => __ ( 'Width image', 'aqua' ),
							"param_name" => "width_image",
							"description" => __ ( 'Enter the width of image. Default: 300.', 'aqua' )
					),
					array (
							"type" => "textfield",
							"heading" => __ ( 'Height image', 'aqua' ),
							"param_name" => "height_image",
							"description" => __ ( 'Enter the height of image. Default: 200.', 'aqua' )
					),
					/*Start Owl Option*/
					array (
							"type" => "textfield",
							"heading" => __ ( 'Items', 'aqua' ),
							"param_name" => "items",
							"dependency" => array(
								"element"=>"tpl",
								"value"=> array("default")
							),
							"description" => __ ( 'This variable allows you to set the maximum amount of items displayed at a time with the widest browser width.', 'aqua' )
					),
					array (
							"type" => "dropdown",
							"heading" => __ ( 'Single Item', 'aqua' ),
							"param_name" => "singleitem",
							"value" => array (
									__( "Please select", 'aqua' ) => "",
									__( "Yes, please", 'aqua' ) => "true",
									__( "No", 'aqua' ) => "false"
							),
							"dependency" => array(
								"element"=>"tpl",
								"value"=> array("default")
							),
							"description" => __ ( 'Display only one item.', 'aqua' )
					),
					array (
							"type" => "dropdown",
							"class" => "",
							"heading" => __ ( "Items Scale Up", 'aqua' ),
							"param_name" => "itemsscaleup",
							"value" => array (
									__( "Please select", 'aqua' ) => "",
									__( "Yes, please", 'aqua' ) => "true",
									__( "No", 'aqua' ) => "false"
							),
							"dependency" => array(
								"element"=>"tpl",
								"value"=> array("default","improved")
							),
							"description" => __ ( "Option to not stretch items when it is less than the supplied items", 'aqua' )
					),
					array (
							"type" => "textfield",
							"heading" => __ ( 'Slide Speed', 'aqua' ),
							"param_name" => "slidespeed",
							"dependency" => array(
								"element"=>"tpl",
								"value"=> array("default","improved")
							),
							"description" => __ ( 'Slide speed in milliseconds', 'aqua' )
					),
					array (
							"type" => "textfield",
							"heading" => __ ( 'Pagination Speed', 'aqua' ),
							"param_name" => "paginationspeed",
							"dependency" => array(
								"element"=>"tpl",
								"value"=> array("default","improved")
							),
							"description" => __ ( 'Pagination speed in milliseconds', 'aqua' )
					),
					array (
							"type" => "dropdown",
							"heading" => __ ( 'Auto Play', 'aqua' ),
							"param_name" => "autoplay",
							"value" => array (
									__( "Please select", 'aqua' ) => "",
									__( "Yes, please", 'aqua' ) => "true",
									__( "No", 'aqua' ) => "false"
							),
							"dependency" => array(
								"element"=>"tpl",
								"value"=> array("default","improved")
							),
							"description" => __ ( 'If you set autoPlay: true default speed will be 5 seconds.', 'aqua' )
					),
					array (
							"type" => "dropdown",
							"heading" => __ ( 'Stop OnHover', 'aqua' ),
							"param_name" => "stoponhover",
							"value" => array (
									__( "Please select", 'aqua' ) => "",
									__( "Yes, please", 'aqua' ) => "true",
									__( "No", 'aqua' ) => "false"
							),
							"dependency" => array(
								"element"=>"tpl",
								"value"=> array("default","improved")
							),
							"description" => __ ( 'Stop autoplay on mouse hover.', 'aqua' )
					),
					array (
							"type" => "dropdown",
							"heading" => __ ( 'Navigation', 'aqua' ),
							"param_name" => "navigation",
							"value" => array (
									__( "Please select", 'aqua' ) => "",
									__( "Yes, please", 'aqua' ) => "true",
									__( "No", 'aqua' ) => "false"
							),
							"dependency" => array(
								"element"=>"tpl",
								"value"=> array("default","improved")
							),
							"description" => __ ( "Display 'next' and 'prev' buttons", 'aqua' )
					),
					array (
							"type" => "dropdown",
							"heading" => __ ( 'Scroll Per Page', 'aqua' ),
							"param_name" => "scrollperpage",
							"value" => array (
									__( "Please select", 'aqua' ) => "",
									__( "Yes, please", 'aqua' ) => "true",
									__( "No", 'aqua' ) => "false"
							),
							"dependency" => array(
								"element"=>"tpl",
								"value"=> array("default")
							),
							"description" => __ ( "Scroll per page not per item. This affect next/prev buttons and mouse/touch dragging", 'aqua' )
					),
					array (
							"type" => "dropdown",
							"class" => "",
							"heading" => __ ( "Pagination", 'aqua' ),
							"param_name" => "pagination",
							"value" => array (
									__( "Please select", 'aqua' ) => "",
									__( "Yes, please", 'aqua' ) => "true",
									__( "No", 'aqua' ) => "false"
							),
							"dependency" => array(
								"element"=>"tpl",
								"value"=> array("default")
							),
							"description" => __ ( "Show pagination", 'aqua' )
					),
					array (
							"type" => "dropdown",
							"heading" => __ ( 'Pagination Numbers', 'aqua' ),
							"param_name" => "paginationnumbers",
							"value" => array (
									__( "Please select", 'aqua' ) => "",
									__( "Yes, please", 'aqua' ) => "true",
									__( "No", 'aqua' ) => "false"
							),
							"dependency" => array(
								"element"=>"tpl",
								"value"=> array("default")
							),
							"description" => __ ( "Show numbers inside pagination buttons", 'aqua' )
					),
					/*End Owl Option*/
					/*Start Sky Option*/					
					array (
							"type" => "textfield",
							"class" => "",
							"heading" => __ ( "Height", 'aqua' ),
							"param_name" => "height",
							"value" => "450px",
							"dependency" => array(
								"element"=>"tpl",
								"value"=> array("sky")
							),
							"description" => __ ( "Height of carousel", 'aqua' )
					),
					array (
							"type" => "textfield",
							"class" => "",
							"heading" => __ ( "Item width", 'aqua' ),
							"param_name" => "itemwidth",
							"value" => "260",
							"dependency" => array(
								"element"=>"tpl",
								"value"=> array("sky")
							),
							"description" => __ ( "The width of the carousel item images.", 'aqua' )
					),					
					array (
							"type" => "textfield",
							"class" => "",
							"heading" => __ ( "Item height", 'aqua' ),
							"param_name" => "itemheight",
							"value" => "260",
							"dependency" => array(
								"element"=>"tpl",
								"value"=> array("sky")
							),
							"description" => __ ( "The height of the carousel item images.", 'aqua' )
					),					
					array (
							"type" => "dropdown",
							"class" => "",
							"heading" => __ ( "Gradient overlay visible", 'aqua' ),
							"param_name" => "gradientoverlayvisible",
							"value" => array (
									__( "Please select", 'aqua' ) => "",
									__( "Yes, please", 'aqua' ) => 1,
									__( "No", 'aqua' ) => 0
							),
							"dependency" => array(
								"element"=>"tpl",
								"value"=> array("sky")
							),
							"description" => __ ( "Indicates whether the gradient overlays will be visible.", 'aqua' )
					),					
					array (
							"type" => "colorpicker",
							"class" => "",
							"heading" => __ ( "Gradient overlay color", 'aqua' ),
							"param_name" => "gradientoverlaycolor",
							"value" => "#FFFFFF",
							"dependency" => array(
								"element"=>"tpl",
								"value"=> array("sky")
							),
							"description" => __ ( "The color of the gradient overlays", 'aqua' )
					),					
					array (
							"type" => "textfield",
							"class" => "",
							"heading" => __ ( "Gradient overlay size", 'aqua' ),
							"param_name" => "gradientoverlaysize",
							"value" => "215",
							"dependency" => array(
								"element"=>"tpl",
								"value"=> array("sky")
							),
							"description" => __ ( "The width of the gradient overlays.", 'aqua' )
					),				
					array (
							"type" => "dropdown",
							"class" => "",
							"heading" => __ ( "Auto slideshow", 'aqua' ),
							"param_name" => "autoslideshow",
							"value" => array (
									__( "Please select", 'aqua' ) => "",
									__( "Yes, please", 'aqua' ) => 1,
									__( "No", 'aqua' ) => 0
							),
							"dependency" => array(
								"element"=>"tpl",
								"value"=> array("sky")
							),
							"description" => __ ( "Indicates whether to display the items in auto slideshow mode", 'aqua' )
					),				
					array (
							"type" => "dropdown",
							"class" => "",
							"heading" => __ ( "Enable Mouse Wheel", 'aqua' ),
							"param_name" => "enablemousewheel",
							"value" => array (
									__( "No", 'aqua' ) => "false",
									__( "Yes, please", 'aqua' ) => "true",
							),
							"dependency" => array(
								"element"=>"tpl",
								"value"=> array("sky")
							),
							"description" => __ ( "If it's set to Yes, you can use the mouse wheel to switch between the carousel items.Default: false.", 'aqua' )
					),					
					array (
							"type" => "textfield",
							"class" => "",
							"heading" => __ ( "Distance", 'aqua' ),
							"param_name" => "distance",
							"value" => 15,
							"dependency" => array(
								"element"=>"tpl",
								"value"=> array("sky")
							),
							"description" => __ ( "The distance between the carousel items.", 'aqua' )
					),					
					array (
							"type" => "textfield",
							"class" => "",
							"heading" => __ ( "Selected item distance", 'aqua' ),
							"param_name" => "selecteditemdistance",
							"value" => 50,
							"dependency" => array(
								"element"=>"tpl",
								"value"=> array("sky")
							),
							"description" => __ ( "The distance between the currently selected item and other items.", 'aqua' )
					),						
					array (
							"type" => "textfield",
							"class" => "",
							"heading" => __ ( "Start index", 'aqua' ),
							"param_name" => "startindex",
							"value" => 'auto',
							"dependency" => array(
								"element"=>"tpl",
								"value"=> array("sky")
							),
							"description" => __ ( "The index of the carousel item to show at start-up. Use 0 for the first item and 'auto' for the middle.", 'aqua' )
					),							
					array (
							"type" => "textfield",
							"class" => "",
							"heading" => __ ( "Selected item zoom factor", 'aqua' ),
							"param_name" => "selecteditemzoomfactor",
							"value" => 1.0,
							"dependency" => array(
								"element"=>"tpl",
								"value"=> array("sky")
							),
							"description" => __ ( "The scale factor for the currently selected item. It should be equal to or less than 1.0.", 'aqua' )
					),							
					array (
							"type" => "textfield",
							"class" => "",
							"heading" => __ ( "Unselected item zoom factor", 'aqua' ),
							"param_name" => "unselecteditemzoomfactor",
							"value" => 0.6,
							"dependency" => array(
								"element"=>"tpl",
								"value"=> array("sky")
							),
							"description" => __ ( "The scale factor for the unselected items. It should be equal to or less than 1.0.", 'aqua' )
					),								
					array (
							"type" => "textfield",
							"class" => "",
							"heading" => __ ( "Unselected item alpha", 'aqua' ),
							"param_name" => "unselecteditemalpha",
							"value" => 0.6,
							"dependency" => array(
								"element"=>"tpl",
								"value"=> array("sky")
							),
							"description" => __ ( "The opacity of the unselected carousel items.", 'aqua' )
					),									
					array (
							"type" => "textfield",
							"class" => "",
							"heading" => __ ( "Top margin", 'aqua' ),
							"param_name" => "topmargin",
							"value" => 30,
							"dependency" => array(
								"element"=>"tpl",
								"value"=> array("sky")
							),
							"description" => __ ( "The distance between the top of the plugin and the currently selected item.", 'aqua' )
					),									
					array (
							"type" => "textfield",
							"class" => "",
							"heading" => __ ( "Slide speed", 'aqua' ),
							"param_name" => "slidespeed",
							"value" => 0.45,
							"dependency" => array(
								"element"=>"tpl",
								"value"=> array("sky")
							),
							"description" => __ ( "Indicates whether a carousel item can be selected with a single click.", 'aqua' )
					),	
					/*End Sky Option*/
					array (
							"type" => "dropdown",
							"class" => "",
							"heading" => __ ( "Rows", 'aqua' ),
							"param_name" => "rows",
							"value" => array (
									__( "Please select", 'aqua' ) => "",
									__( "1 rows", 'aqua' ) => "1",
									__( "2 rows", 'aqua' ) => "2",
									__( "3 rows", 'aqua' ) => "3",
									__( "4 rows", 'aqua' ) => "4"
							),
							"dependency" => array(
								"element"=>"tpl",
								"value"=> array("default")
							),
							"description" => __ ( "", 'aqua' )
					),
					array (
							"type" => "dropdown",
							"heading" => __ ( 'Show image', 'aqua' ),
							"param_name" => "show_image",
							"value" => array (
									__( "Please select", 'aqua' ) => "",
									__( "Yes, please", 'aqua' ) => 1,
									__( "No", 'aqua' ) => 0
							),
							"description" => __ ( "Show or hide image on your carousel", 'aqua' )
					),
					array (
						"type" => "checkbox",
						"heading" => __ ( 'Show Title', 'aqua' ),
						"param_name" => "show_title",
						"value" => array (
								__ ( "Yes, please", 'aqua' ) => true
						),
						"description" => __ ( 'Show or hide title on your post.', 'aqua' )
					),
					array (
						"type" => "checkbox",
						"heading" => __ ( 'Show Tooltip', 'aqua' ),
						"param_name" => "show_tooltip",
						"value" => array (
								__ ( "Yes, please", 'aqua' ) => true
						),
						"dependency" => array(
							"element"=>"tpl",
							"value"=> array("tooltip")
						),
						"description" => __ ( 'Show or hide tooltip on your post.', 'aqua' )
					),
					array (
						"type" => "checkbox",
						"heading" => __ ( 'Show Information', 'aqua' ),
						"param_name" => "show_info",
						"value" => array (
								__ ( "Yes, please", 'aqua' ) => true
						),
						"description" => __ ( 'Show or hide Information of your post.', 'aqua' )
					),
					array (
						"type" => "checkbox",
						"heading" => __ ( 'Show description', 'aqua' ),
						"param_name" => "show_description",
						"value" => array (
								__ ( "Yes, please", 'aqua' ) => true
						),
						"description" => __ ( 'Show or hide description of your post.', 'aqua' )
					),
					array (
						"type" => "textfield",
						"heading" => __ ( 'Excerpt Length', 'aqua' ),
						"param_name" => "excerpt_length",
						"value" => '',
						"description" => __ ( 'The length of the excerpt, number of words to display. Set to "-1" for no excerpt. Default: 20.', 'aqua' )
					),
					array (
						"type" => "textfield",
						"heading" => __ ( 'Excerpt More', 'aqua' ),
						"param_name" => "excerpt_more",
						"value" => '',
						"description" => __ ( 'The more of the excerpt, character of words to display. Default: "..."', 'aqua' )
					),
					array (
							"type" => "textfield",
							"heading" => __ ( 'Read More', 'aqua' ),
							"param_name" => "read_more",
							"value" => '',
							"description" => __ ( 'Enter desired text for the link or for no link, leave blank or set to \"-1\".', 'aqua' )
					),
					array (
							"type" => "textfield",
							"heading" => __ ( 'Count', 'aqua' ),
							"param_name" => "posts_per_page",
							'value' => '12',
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
					array (
							"type" => "textfield",
							"heading" => __ ( "Extra class name", "js_composer" ),
							"param_name" => "el_class",
							"description" => __ ( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" )
					)
		)
));