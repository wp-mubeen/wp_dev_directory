<?php

add_action('init', 'tb_separator_icon_integrateWithVC');

function tb_separator_icon_integrateWithVC() {
    vc_map(array(
        "name" => __("Separator Icon", 'aqua'),
        "base" => "tb_separator_icon",
        "class" => "tb-separator-icon",
        "category" => __('Aqua', 'aqua'),
        "icon" => "tb-icon-for-vc",
        "params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Icon", 'aqua'),
                "param_name" => "spr_icon",
                "value" => "",
                "description" => __("Separator Icon.", 'aqua')
            ),
			array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __("Width", 'aqua'),
                "param_name" => "spr_width",
                "value" => array(
                    "100%" => "100%",
                    "90%" => "90%",
                    "80%" => "80%",
                    "70%" => "70%",
                    "60%" => "60%",
                    "50%" => "50%",
                    "40%" => "40%",
                    "30%" => "30%",
                    "20%" => "20%",
                    "10%" => "10%"
                ),
                "description" => __("Separator Width.", 'aqua')
            ),
			array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __("Align", 'aqua'),
                "param_name" => "spr_align",
                "value" => array(
                    "Left" => "left",
                    "Center" => "center",
					"Right" => "right"
                ),
                "description" => __('Separator Align.', 'aqua')
            ),
			array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __("Animation", 'aqua'),
                "param_name" => "animation",
                "value" => array(
                    "No" => "",
                    "Top to bottom" => "top-to-bottom",
                    "Bottom to top" => "bottom-to-top",
                    "Left to right" => "left-to-right",
                    "Right to left" => "right-to-left",
                    "Appear from center" => "appear"
                ),
                "description" => __("Animation", 'aqua')
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Extra Class", 'aqua'),
                "param_name" => "el_class",
                "value" => "",
                "description" => __("Extra Class.", 'aqua')
            ),
        )
    ));
}
