<?php

add_action('init', 'tb_plan_integrateWithVC');

function tb_plan_integrateWithVC() {
    vc_map(array(
        "name" => __("Plan", 'aqua'),
        "base" => "tb_plan",
        "class" => "tb_plan",
        "category" => __('Aqua', 'aqua'),
        "icon" => "tb-icon-for-vc",
        "params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Name", 'aqua'),
                "param_name" => "name",
                "value" => "",
                "description" => __("Name.", 'aqua')
            ),
			array(
                "type" => "attach_image",
                "class" => "",
                "heading" => __("Image", 'aqua'),
                "param_name" => "img",
                "value" => "",
                "description" => __("Image.", 'aqua')
            ),
            array(
                "type" => "checkbox",
                "class" => "",
                "heading" => __("Featured", 'aqua'),
                "param_name" => "featured",
                "value" => array (
                    __ ( "Yes, please", 'aqua' ) => true
                ),
                "description" => __("Featured.", 'aqua')
            ),            
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Price", 'aqua'),
                "param_name" => "price",
                "value" => "",
                "description" => __("Price.", 'aqua')
            ),
			array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Currency", 'aqua'),
                "param_name" => "currency",
                "value" => "",
                "description" => __("Currency.", 'aqua')
            ),
			array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Unit", 'aqua'),
                "param_name" => "unit",
                "value" => "",
                "description" => __("Unit.", 'aqua')
            ),
            array(
                "type" => "textarea_html",
                "class" => "",
                "heading" => __("Content", 'aqua'),
                "param_name" => "content",
                "value" => "",
                "description" => __("Content.", 'aqua')
            ),
			array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Lable Button", 'aqua'),
                "param_name" => "btn_label",
                "value" => "",
                "description" => __("Lable Button.", 'aqua')
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Url", 'aqua'),
                "param_name" => "url",
                "value" => "#",
                "description" => __("Url.", 'aqua')
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __("Target", 'aqua'),
                "param_name" => "target",
                "value" => array (
                    "_self" => "_self",
                    "_blank" => "_blank",
                ),
                "description" => __("Target.", 'aqua')
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
