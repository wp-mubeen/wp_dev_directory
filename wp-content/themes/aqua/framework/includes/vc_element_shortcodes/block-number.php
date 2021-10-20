<?php

add_action('init', 'tb_block_number_integrateWithVC');

function tb_block_number_integrateWithVC() {
    vc_map(array(
        "name" => __("Block Number", 'aqua'),
        "base" => "tb_block_number",
        "category" => __('Aqua', 'aqua'),
        "icon" => "tb-icon-for-vc",
        "params" => array(
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __("Type", 'aqua'),
                "param_name" => "type",
                "value" => array(
                    "Square" => "square",
                    "Circle" => "circle",
                    "Rounded" => "rounded",
                ),
                "description" => __('Select type for block number', 'aqua')
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Text", 'aqua'),
                "param_name" => "text",
                "value" => "",
                "description" => __("Please, enter text for block number.", 'aqua')
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Title", 'aqua'),
                "param_name" => "title",
                "value" => "",
                "description" => __("Please, enter title for block number.", 'aqua')
            ),
            array(
                "type" => "textarea",
                "class" => "",
                "heading" => __("Content", 'aqua'),
                "param_name" => "block_number_content",
                "value" => "",
                "description" => __("Please, enter Content for block number.", 'aqua')
            ),          
            array(
                "type" => "colorpicker",
                "class" => "",
                "heading" => __("Color", 'aqua'),
                "param_name" => "color",
                "value" => "",
                "description" => __("Select color for block number.", 'aqua')
            ),
            array(
                "type" => "colorpicker",
                "class" => "",
                "heading" => __("Background", 'aqua'),
                "param_name" => "background",
                "value" => "",
                "description" => __("Select background color for block number.", 'aqua')
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
