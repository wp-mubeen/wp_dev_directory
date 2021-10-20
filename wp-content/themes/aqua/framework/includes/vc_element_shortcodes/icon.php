<?php

add_action('init', 'tb_icon_integrateWithVC');

function tb_icon_integrateWithVC() {
    vc_map(array(
        "name" => __("Icon", 'aqua'),
        "base" => "icon",
        "class" => "icon",
        "category" => __('Aqua', 'aqua'),
        "icon" => "tb-icon-for-vc",
        "params" => array(
            array(
                "type" => "colorpicker",
                "class" => "",
                "heading" => __("Color", 'aqua'),
                "param_name" => "color",
                "value" => "",
                "description" => __("Color.", 'aqua')
            ),        
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Font size", 'aqua'),
                "param_name" => "fontsize",
                "value" => "",
                "description" => __("Font size.", 'aqua')
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Link", 'aqua'),
                "param_name" => "link",
                "value" => "",
                "description" => __("Link.", 'aqua')
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Class", 'aqua'),
                "param_name" => "class",
                "value" => "",
                "description" => __("Class.", 'aqua')
            ),
            array(
                "type" => "textarea",
                "holder" => "div",
                "class" => "",
                "heading" => __("Text", 'aqua'),
                "param_name" => "content",
                "value" => "",
                "description" => __("Text.", 'aqua')
            )
        )
    ));
}
