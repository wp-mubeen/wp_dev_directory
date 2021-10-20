<?php

add_action('init', 'tb_demo_item_integrateWithVC');

function tb_demo_item_integrateWithVC() {
    vc_map(array(
        "name" => __("Demo Item", 'aqua'),
        "base" => "demo_item",
        "class" => "tb-demo-item",
        "category" => __('Aqua', 'aqua'),
        "icon" => "tb-icon-for-vc",
        "params" => array(
			array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __("Type", 'aqua'),
                "param_name" => "type",
                "value" => array(
                    "Demo" => "demo",
                    "Comming" => "comming"
                ),
                "description" => __('Select box type for demo item.', 'aqua')
            ),
			array(
                "type" => "attach_image",
                "class" => "",
                "heading" => __("Image", 'aqua'),
                "param_name" => "demo_image",
                "value" => "",
                "description" => __("Select box image for demo item.", 'aqua')
            ),
			array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Title", 'aqua'),
                "param_name" => "title",
                "value" => "",
                "description" => __("Please, enter title for demo item.", 'aqua')
            ),
			array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Button Label", 'aqua'),
                "param_name" => "btn_label",
                "value" => "",
				"dependency" => array(
					"element"=>"type",
					"value"=>"demo"
				),
                "description" => __("Please, enter button label for demo item.", 'aqua')
            ),
			array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Button Link", 'aqua'),
                "param_name" => "btn_link",
                "value" => "",
				"dependency" => array(
					"element"=>"type",
					"value"=>"demo"
				),
                "description" => __("Please, enter button link for demo item.", 'aqua')
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
}
