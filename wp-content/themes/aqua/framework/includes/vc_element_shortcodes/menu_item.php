<?php

add_action('init', 'menu_item_integrateWithVC');

function menu_item_integrateWithVC() {
    vc_map(array(
        "name" => __("Menu Item", 'aqua'),
        "base" => "menu_item",
        "class" => "menu-item",
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
                "description" => __("Title menu item.", 'aqua')
            ),
			array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Price", 'aqua'),
                "param_name" => "price",
                "value" => "",
                "description" => __("Price menu item.", 'aqua')
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
                "description" => __ ( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'aqua' )
            ),
        )
    ));
}
