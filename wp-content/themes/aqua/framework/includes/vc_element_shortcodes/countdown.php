<?php

add_action('init', 'tb_countdown_integrateWithVC');

function tb_countdown_integrateWithVC() {
    vc_map(array(
        "name" => __("Countdown", 'aqua'),
        "base" => "tb_countdown",
        "class" => "tb_countdown",
        "category" => __('Aqua', 'aqua'),
        "icon" => "tb-icon-for-vc",
        "params" => array(
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Date end", 'aqua'),
                "param_name" => "date_end",
                "value" => "",
                "description" => __("Ex: 2015/10/20 12:34:56.", 'aqua')
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

?>