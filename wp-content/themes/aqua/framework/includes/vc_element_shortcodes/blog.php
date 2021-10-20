<?php

add_action('init', 'tb_blog_integrateWithVC');

function tb_blog_integrateWithVC() {
    vc_map(array(
        "name" => __("Blog", 'aqua'),
        "base" => "tb_blog",
        "class" => "tb-blog",
        "category" => __('Aqua', 'aqua'),
        'admin_enqueue_js' => array(URI_PATH_ADMIN.'assets/js/customvc.js'),
        "icon" => "tb-icon-for-vc",
        "params" => array(
            array(
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => __("Post Type", 'aqua'),
                "param_name" => "post_type",
                "value" => array(
                    "Post" => "post",
                    "Portfolio" => "portfolio",
                    "Space" => "space",
                    "Testimonial" => "testimonial",
                ),
				"description" => __('Select post type for blog.', 'aqua')
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Post Count", 'aqua'),
                "param_name" => "posts_per_page",
                "value" => "",
				"description" => __('Please, enter number of post per page for blog. Show all: -1.', 'aqua')
            ),
            array (
                "type" => "tb_taxonomy",
                "taxonomy" => "category",
                "dependency" => array(
                    "element"=>"post_type",
                    "value"=>"post"
                    )
                ,
                "heading" => __ ( "Categories", 'aqua' ),
                "param_name" => "category",
                "class" => "",
                "description" => __ ( "Note: By default, all your projects will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed.", 'aqua' )
            ),
            array (
                "type" => "tb_taxonomy",
                "taxonomy" => "portfolio_category",
                "dependency" => array(
                    "element"=>"post_type",
                    "value"=>"portfolio"
                    )
                ,
                "heading" => __ ( "Categories", 'aqua' ),
                "param_name" => "portfolio_category",
                "class" => "",
                "description" => __ ( "Note: By default, all your projects will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed.", 'aqua' )
            ),
            array (
                "type" => "tb_taxonomy",
                "taxonomy" => "space_category",
                "dependency" => array(
                    "element"=>"post_type",
                    "value"=>"space"
                    )
                ,
                "heading" => __ ( "Categories", 'aqua' ),
                "param_name" => "space_category",
                "class" => "",
                "description" => __ ( "Note: By default, all your projects will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed.", 'aqua' )
            ),
			array (
                "type" => "tb_taxonomy",
                "taxonomy" => "testimonial_category",
                "dependency" => array(
                    "element"=>"post_type",
                    "value"=>"testimonial"
                    )
                ,
                "heading" => __ ( "Categories", 'aqua' ),
                "param_name" => "testimonial_category",
                "class" => "",
                "description" => __ ( "Note: By default, all your projects will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed.", 'aqua' )
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __("Columns", 'aqua'),
                "param_name" => "columns",
                "value" => array(
                    "4 Columns" => "4",
                    "3 Columns" => "3",
                    "2 Columns" => "2",
                    "1 Column" => "1",
                ),
				"description" => __('Select columns for blog.', 'aqua')
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __("Style", 'aqua'),
                "param_name" => "style",
                "value" => array(
                    "Blog" => "blog",
                    "Default" => "default",
					"Deviation" => "deviation"
                ),
                "dependency" => array(
                    "element"=>"post_type",
                    "value"=>"post"
				),
				"description" => __('Select style for blog.', 'aqua')
            ),
			array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __("Deviation Text Align", 'aqua'),
                "param_name" => "deviation_text_align",
                "value" => array(
                    "Left" => "left",
                    "Right" => "right",
                    "Bottom" => "bottom",
                ),
                "dependency" => array(
                    "element"=>"style",
                    "value"=>"deviation"
				),
				"description" => __('Select deviation style for blog.', 'aqua')
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __("Style", 'aqua'),
                "param_name" => "portfolio_style",
                "value" => array(
                    "Style 1" => "entry",
                ),
                "dependency" => array(
                    "element"=>"post_type",
                    "value"=>"portfolio"
				),
				"description" => __('Select style for blog.', 'aqua')
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __("Style", 'aqua'),
                "param_name" => "space_style",
                "value" => array(
                    "Style 1" => "entry",
                ),
                "dependency" => array(
                    "element"=>"post_type",
                    "value"=>"space"
				),
				"description" => __('Select style for blog.', 'aqua')
            ),
			array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __("Style", 'aqua'),
                "param_name" => "testimonial_style",
                "value" => array(
                    "Style 1" => "entry",
                ),
                "dependency" => array(
                    "element"=>"post_type",
                    "value"=>"testimonial"
				),
				"description" => __('Select style for blog.', 'aqua')
            ),
            array(
                "type" => "checkbox", 
                "heading" => __('Crop image', 'aqua'),
                "param_name" => "crop_image",
                "value" => array(
                    __("Yes, please", 'aqua') => 1
                ),
                "description" => __('Crop or not crop image on your Post.', 'aqua')
            ),
            array(
                "type" => "textfield",
                "heading" => __('Width image', 'aqua'),
                "param_name" => "width_image",
                "description" => __('Enter the width of image. Default: 300.', 'aqua')
            ),
            array(
                "type" => "textfield",
                "heading" => __('Height image', 'aqua'),
                "param_name" => "height_image",
                "description" => __('Enter the height of image. Default: 200.', 'aqua')
            ),
            array(
                "type" => "checkbox",
                "heading" => __('Show Title', 'aqua'),
                "param_name" => "show_title",
                "value" => array(
                    __("Yes, please", 'aqua') => 1
                ),
                "description" => __('Show or hide title of post on your blog.', 'aqua')
            ),
            array(
                "type" => "checkbox",
                "heading" => __('Show Info', 'aqua'),
                "param_name" => "show_info",
                "value" => array(
                    __("Yes, please", 'aqua') => 1
                ),
				"dependency" => array(
                    "element" => "post_type",
                    "value" => array("post","space"),
                ),
                "description" => __('Show or hide info of post on your blog.', 'aqua')
            ),
            array(
                "type" => "checkbox",
                "heading" => __('Show Description', 'aqua'),
                "param_name" => "show_desc",
                "value" => array(
                    __("Yes, please", 'aqua') => 1
                ),
                "dependency" => array(
                    "element" => "post_type",
                    "value" => array("post","space","testimonial"),
                ),
                "description" => __('Show or hide description of post on your blog.', 'aqua')
            ),
            array(
                "type" => "textfield",
                "heading" => __('Excerpt Length', 'aqua'),
                "param_name" => "excerpt_length",
                "value" => '',
                "dependency" => array(
                    "element" => "post_type",
                    "value" => array("post","space","testimonial"),
                ),
                "description" => __('The length of the excerpt, number of words to display. Set -1 show all words of excerpt.', 'aqua')
            ),
            array(
                "type" => "textfield",
                "heading" => __('Excerpt More', 'aqua'),
                "param_name" => "excerpt_more",
                "value" => "",
                "dependency" => array(
                    "element" => "post_type",
                    "value" => array("post","space","testimonial"),
                ),
				"description" => __('Please enter excerpt more for blog.', 'aqua')
            ),
            array(
                "type" => "dropdown",
                "heading" => __('Order by', 'aqua'),
                "param_name" => "orderby",
                "value" => array(
                    "None" => "none",
                    "Title" => "title",
                    "Date" => "date",
                    "ID" => "ID"
                ),
                "description" => __('Order by ("none", "title", "date", "ID").', 'aqua')
            ),
            array(
                "type" => "dropdown",
                "heading" => __('Order', 'aqua'),
                "param_name" => "order",
                "value" => Array(
                    "None" => "none",
                    "ASC" => "ASC",
                    "DESC" => "DESC"
                ),
                "description" => __('Order ("None", "Asc", "Desc").', 'aqua')
            ),
            array(
                "type" => "dropdown",
                "heading" => __('Show Pagination', 'aqua'),
                "param_name" => "show_pagination",
                "value" => Array(
                    "None" => "none",
                    "Number" => "number",
					"Ajax" => "ajax"
                ),
                "description" => __('Show or hide pagination of post on your blog.', 'aqua')
            ),
			array(
                "type" => "dropdown",
                "heading" => __('Pagination Position', 'aqua'),
                "param_name" => "pos_pagination",
                "value" => Array(
                    "Left" => "text-left",
                    "Center" => "text-center",
					"Right" => "text-right"
                ),
                "description" => __('Select Pagination Position.', 'aqua')
            ),
			array(
                "type" => "dropdown",
                "heading" => __('Object Animation', 'aqua'),
                "param_name" => "ob_animation",
                "value" => Array(
                    "Wrap" => "wrap",
                    "Item" => "item"
                ),
                "description" => __('Select object animation', 'aqua')
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
                "description" => __("Box Animation", 'aqua')
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
