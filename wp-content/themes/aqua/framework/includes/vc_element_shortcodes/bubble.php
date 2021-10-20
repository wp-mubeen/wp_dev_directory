<?php
vc_map ( array (
		"name" => 'Bubble',
		"base" => "tb_bubble",
		"icon" => "tb-icon-for-vc",
		"category" => __ ( 'Aqua', 'aqua' ),
		"params" => array (
				array (
						"type" => "textfield",
						"holder" => "div",
						"heading" => __ ( 'Author', 'aqua' ),
						"param_name" => "author",
						"value" => '',
						"description" => __ ( 'Please, enter author for bubble.', 'aqua' )
				),
				array (
						"type" => "colorpicker",
						"heading" => __ ( 'Color', 'aqua' ),
						"param_name" => "color",
						"value" => '',
						"description" => __ ( 'Select color for bubble.', 'aqua' )
				),
				array (
						"type" => "colorpicker",
						"heading" => __ ( 'Background', 'aqua' ),
						"param_name" => "background",
						"value" => '',
						"description" => __ ( 'Select background color for bubble.', 'aqua' )
				),
				array (
						"type" => "textfield",
						"heading" => __ ( 'Border Width', 'aqua' ),
						"param_name" => "border_width",
						"value" => '',
						"description" => __ ( 'Please, enter number with "px" of border for bubble.', 'aqua' )
				),
				array (
						"type" => "colorpicker",
						"heading" => __ ( 'Border Color', 'aqua' ),
						"param_name" => "border_color",
						"value" => '',
						"description" => __ ( 'Select color of border for bubble.', 'aqua' )
				),
				array (
						"type" => "dropdown",
						"heading" => __ ( 'Border Style', 'aqua' ),
						"param_name" => "border_style",
						"value" => array('none','hidden','dotted','dashed','solid','double','groove','ridge','inset','outset','initial','inherit'),
						"description" => __ ( 'Select style of border for bubble.', 'aqua' )
				),
				array (
						"type" => "textfield",
						"heading" => __ ( 'Padding', 'aqua' ),
						"param_name" => "padding",
						"value" => '',
						"description" => __ ( 'Please, enter number with "px" of padding for bubble.', 'aqua' )
				),
				array (
						"type" => "textarea_html",
						"heading" => __ ( 'Content', 'aqua' ),
						"param_name" => "content",
						"value" => '',
						"description" => __ ( 'Please, enter content for bubble.', 'aqua' )
				)
		)
) );