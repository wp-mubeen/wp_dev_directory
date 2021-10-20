<?php
vc_map ( array (
		"name" => 'Drop Caps',
		"base" => "tb_dropcap",
		"icon" => "tb-icon-for-vc",
		"category" => __ ( 'Aqua', 'aqua' ),
		"params" => array (
				array (
						"type" => "textarea_html",
						"holder" => "div",
						"heading" => __ ( 'Content', 'aqua' ),
						"param_name" => "content",
						"value" => '',
						"description" => __ ( 'Please, enter content for drop caps.', 'aqua' )
				)
		)
) );