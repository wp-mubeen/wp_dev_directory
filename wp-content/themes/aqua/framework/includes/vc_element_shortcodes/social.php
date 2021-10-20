<?php

add_action('init', 'tb_social_integrateWithVC');

function tb_social_integrateWithVC() {
    vc_map(array(
        "name" => __("Social", 'aqua'),
        "base" => "social",
        "class" => "social",
        "category" => __('Aqua', 'aqua'),
        "icon" => "tb-icon-for-vc",
        "params" => array(
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Title Social 1", 'aqua'),
                "param_name" => "title_social1",
                "value" => "",
                "description" => __("", 'aqua')
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Icon Social 1", 'aqua'),
                "param_name" => "icon_social1",
                "value" => "",
                "description" => __("", 'aqua')
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Link Social 1", 'aqua'),
                "param_name" => "link_social1",
                "value" => "",
                "description" => __("", 'aqua')
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Title Social 2", 'aqua'),
                "param_name" => "title_social2",
                "value" => "",
                "description" => __("", 'aqua')
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Icon Social 2", 'aqua'),
                "param_name" => "icon_social2",
                "value" => "",
                "description" => __("", 'aqua')
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Link Social 2", 'aqua'),
                "param_name" => "link_social2",
                "value" => "",
                "description" => __("", 'aqua')
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Title Social 3", 'aqua'),
                "param_name" => "title_social3",
                "value" => "",
                "description" => __("", 'aqua')
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Icon Social 3", 'aqua'),
                "param_name" => "icon_social3",
                "value" => "",
                "description" => __("", 'aqua')
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Link Social 3", 'aqua'),
                "param_name" => "link_social3",
                "value" => "",
                "description" => __("", 'aqua')
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Title Social 4", 'aqua'),
                "param_name" => "title_social4",
                "value" => "",
                "description" => __("", 'aqua')
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Icon Social 4", 'aqua'),
                "param_name" => "icon_social4",
                "value" => "",
                "description" => __("", 'aqua')
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Link Social 4", 'aqua'),
                "param_name" => "link_social4",
                "value" => "",
                "description" => __("", 'aqua')
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Title Social 5", 'aqua'),
                "param_name" => "title_social5",
                "value" => "",
                "description" => __("", 'aqua')
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Icon Social 5", 'aqua'),
                "param_name" => "icon_social5",
                "value" => "",
                "description" => __("", 'aqua')
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Link Social 5", 'aqua'),
                "param_name" => "link_social5",
                "value" => "",
                "description" => __("", 'aqua')
            ),
             array(
                "type" => "checkbox",
                "class" => "",
                "heading" => __("Show Tooltip", 'aqua'),
                "param_name" => "show_tooltip",
                "value" => array (
                                __ ( "Yes, please", 'aqua' ) => 1
                ),
                "description" => __("", 'aqua')
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __("Tooltip Position", 'aqua'),
                "param_name" => "tooltip_pos",
                "value" => array(
                    "Top" => "top",
                    "Right" => "right",
                    "Bottom" => "bottom",
                    "Left" => "left"
                ),
                "description" => __("", 'aqua')
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
