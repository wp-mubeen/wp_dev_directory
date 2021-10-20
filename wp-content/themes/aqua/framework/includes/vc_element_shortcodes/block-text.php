<?php
vc_map ( array (
		"name" => 'Block Text',
		"base" => "tb_block_text",
		"icon" => "tb-icon-for-vc",
		"category" => __ ( 'Aqua', 'aqua' ),
		"params" => array (
				array (
						"type" => "dropdown",
						"heading" => __ ( 'Type', 'aqua' ),
						"param_name" => "type",
						"value" => array(
							"Default" => "default",
							"Rounded" => "rounded",
						),
						"description" =>  __ ( 'Select type for block text.', 'aqua' )
				),
				array (
						"type" => "colorpicker",
						"heading" => __ ( 'Color', 'aqua' ),
						"param_name" => "color",
						"value" => '',
						"description" => __ ( 'Select color for block text.', 'aqua' )
				),
				array (
						"type" => "colorpicker",
						"heading" => __ ( 'Background', 'aqua' ),
						"param_name" => "background",
						"value" => '',
						"description" => __ ( 'Select background for block text.', 'aqua' )
				),
				array (
						"type" => "textfield",
						"heading" => __ ( 'Border Width', 'aqua' ),
						"param_name" => "border_width",
						"value" => '',
						"description" => __( 'Please, enter number with "px" of border for block text.', 'aqua' )
				),
				array (
						"type" => "colorpicker",
						"heading" => __ ( 'Border Color', 'aqua' ),
						"param_name" => "border_color",
						"value" => '',
						"description" => __ ( 'select color of border for block text.', 'aqua' )
				),
				array (
						"type" => "dropdown",
						"heading" => __ ( 'Border Style', 'aqua' ),
						"param_name" => "border_style",
						"value" => array('none','hidden','dotted','dashed','solid','double','groove','ridge','inset','outset','initial','inherit'),
						"description" => __ ( 'Select style of border for block text.', 'aqua' )
				),
				array (
						"type" => "textfield",
						"heading" => __ ( 'Padding', 'aqua' ),
						"param_name" => "padding",
						"value" => '',
						"description" =>  __ ( 'Please, enter number with "px" of padding for block text.', 'aqua' )
				),
				array (
						"type" => "textarea_html",
						"holder" => "div",
						"heading" => __ ( 'Content', 'aqua' ),
						"param_name" => "content",
						"value" => '',
						"description" => __ ( 'Please, enter content for block text.', 'aqua' )
				)
		)
) );