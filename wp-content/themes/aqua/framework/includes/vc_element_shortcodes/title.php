<?php

add_action('init', 'title_integrateWithVC');

function title_integrateWithVC() {
    vc_map(array(
        "name" => __("Title", 'aqua'),
        "base" => "title",
        "class" => "title",
        "category" => __('Aqua', 'aqua'),
        "icon" => "tb-icon-for-vc",
        "params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Title", 'aqua'),
                "param_name" => "title",
                "value" => "",
                "description" => __("Content.", 'aqua')
            ),
			array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __("Template", 'aqua'),
                "param_name" => "title_tpl",
                "value" => array(
                    "Default" => "tpl1",
                    "Banner" => "tpl2",
                ),
                "description" => __('Select template for title.', 'aqua')
            ),
			array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Sub Title", 'aqua'),
                "param_name" => "sub_title",
                "value" => "",
				"dependency" => array(
                    "element"=>"title_tpl",
                    "value"=>"tpl2"
                ),
                "description" => __("Input Subtitle.", 'aqua')
            ),
			array(
                "type" => "attach_image",
                "class" => "",
                "heading" => __("Title Background", 'aqua'),
                "param_name" => "title_background",
                "value" => "",
                "dependency" => array(
                    "element"=>"title_tpl",
                    "value"=>"tpl2"
                ),
                "description" => __("Select background image for title.", 'aqua')
            ),
			array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Font Size", 'aqua'),
                "param_name" => "font_size",
                "value" => "",
                "description" => __("Font Size.", 'aqua')
            ),
            array (
                "type" => "colorpicker",
                "heading" => __ ( 'Color', 'aqua' ),
                "param_name" => "color",
                "value" => '',
                "description" => __ ( 'Color', 'aqua' ),
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __("Align", 'aqua'),
                "param_name" => "align",
                "value" => array(
                    "Left" => "text-left",
                    "Right" => "text-right",
                    "Center" => "text-center"
                ),
                "description" => __("Align", 'aqua')
            ),
            array(
                "type" => "checkbox",
                "class" => "",
                "heading" => __("Underline", 'aqua'),
                "param_name" => "underline",
                "value" => array (
                                __ ( "Yes, please", 'aqua' ) => 1
                ),
                "description" => __("Underline.", 'aqua')
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
