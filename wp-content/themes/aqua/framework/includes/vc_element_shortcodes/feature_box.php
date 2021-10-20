<?php

add_action('init', 'tb_feature_box_integrateWithVC');

function tb_feature_box_integrateWithVC() {
    vc_map(array(
        "name" => __("Feature Box", 'aqua'),
        "base" => "tb_feature_box",
        "class" => "tb-feature-box",
        "category" => __('Aqua', 'aqua'),
        "icon" => "tb-icon-for-vc",
        "params" => array(
			array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __("Type", 'aqua'),
                "param_name" => "box_type",
                "value" => array(
                    "Icon" => "icon",
                    "Image" => "image"
                ),
                "description" => __('Select box type for feature box.', 'aqua')
            ),
			array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __("Template", 'aqua'),
                "param_name" => "box_tpl",
                "value" => array(
                    "Template 1" => "tpl1",
                    "Template 2" => "tpl2",
                    "Template 3" => "tpl3",
					"Deviation (only type Image)" => "deviation",
					"Deviation 2 (only type Image)" => "deviation2",
                ),
                "description" => __('Select template for feature box.', 'aqua')
            ),
			array(
                "type" => "colorpicker",
                "class" => "",
                "heading" => __("Background", 'aqua'),
                "param_name" => "box_bg",
                "value" => "",
				"dependency" => array(
					"element"=>"box_tpl",
					"value"=>"tpl2"
				),
                "description" => __('Select background color for feature box.', 'aqua')
            ),
			array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __("Box Arrow", 'aqua'),
                "param_name" => "box_arrow",
                "value" => array(
					"No" => "",
                    "Left Arrow" => "left-arrow",
					"Right Arrow" => "right-arrow",
                ),
				"dependency" => array(
					"element"=>"box_tpl",
					"value"=>"tpl2"
				),
                "description" => __('Select box arrow for feature box.', 'aqua')
            ),
			array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Color Box Icon", 'aqua'),
                "param_name" => "box_colorbox_icon",
                "value" => "",
				"dependency" => array(
                    "element"=>"box_type",
                    "value"=>"image"
                ),
                "description" => __("Please enter icon font awesome from http://fortawesome.github.io/Font-Awesome/icons/.EX: fa fa-search", 'aqua')
            ),
			array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __("Align", 'aqua'),
                "param_name" => "box_align",
                "value" => array(
                    "Left" => "left",
                    "Center" => "center",
					"Right" => "right",
					"Bottom (only template deviaton)" => "bottom"
                ),
                "description" => __('Select box align for feature box.', 'aqua')
            ),
			array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Link Redirect", 'aqua'),
                "param_name" => "link_redirect",
                "value" => "#",
				"dependency" => array(
                    "element"=>"box_tpl",
                    "value"=>"deviation"
                ),
                "description" => __("Please enter link", 'aqua')
            ),
			array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __("Style", 'aqua'),
                "param_name" => "box_style",
                "value" => array(
                    "Circle" => "circle",
                    "Square" => "square"
                ),
				"dependency" => array(
					"element"=>"box_tpl",
					"value"=>"tpl1"
				),
                "description" => __('Select box style for feature box.', 'aqua')
            ),
			array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Icon", 'aqua'),
                "param_name" => "box_icon",
                "value" => "",
                "dependency" => array(
                    "element"=>"box_type",
                    "value"=>"icon"
                ),
                "description" => __("Please enter icon font awesome from http://fortawesome.github.io/Font-Awesome/icons/.EX: fa fa-search", 'aqua')
            ),
			array(
                "type" => "attach_image",
                "class" => "",
                "heading" => __("Image", 'aqua'),
                "param_name" => "box_image",
                "value" => "",
                "dependency" => array(
                    "element"=>"box_type",
                    "value"=>"image"
                ),
                "description" => __("Select box image for feature box.", 'aqua')
            ),
			array (
				"type" => "checkbox",
				"heading" => __ ( 'Crop image', 'aqua' ),
				"param_name" => "crop_image",
				"value" => array (
						__ ( "Yes, please", 'aqua' ) => true
				),
                "dependency" => array(
                    "element"=>"box_type",
                    "value"=>"image"
                ),
				"description" => __ ( 'Crop or not crop image on your Post.', 'aqua' )
			),
			array (
				"type" => "textfield",
				"heading" => __ ( 'Width image', 'aqua' ),
				"param_name" => "width_image",
                "dependency" => array(
                    "element"=>"box_type",
                    "value"=>"image"
                ),
				"description" => __ ( 'Enter the width of image. Default: 300.', 'aqua' )
			),
			array (
				"type" => "textfield",
				"heading" => __ ( 'Height image', 'aqua' ),
				"param_name" => "height_image",
                "dependency" => array(
                    "element"=>"box_type",
                    "value"=>"image"
                ),
				"description" => __ ( 'Enter the height of image. Default: 200.', 'aqua' )
			),
			array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Title", 'aqua'),
                "param_name" => "box_title",
                "value" => "",
                "description" => __("Please, enter box title for feature box.", 'aqua')
            ),
			array(
                "type" => "textarea_html",
                "class" => "",
                "heading" => __("Content", 'aqua'),
                "param_name" => "content",
                "value" => "",
                "description" => __("Please, enter content for feature box.", 'aqua')
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
                "description" => __("Select animation for feature box.", 'aqua')
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
