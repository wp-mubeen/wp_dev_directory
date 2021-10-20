<?php

add_action('init', 'tb_grid_integrateWithVC');

function tb_grid_integrateWithVC() {
    vc_map(array(
        "name" => __("Grid", 'aqua'),
        "base" => "tb_grid",
        "class" => "tb-grid",
        "category" => __('Aqua', 'aqua'),
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
                ),
				"description" => __('Select post type on your grid.', 'aqua')
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
				"class" => "post_category",
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
				"class" => "post_category",
				"description" => __ ( "Note: By default, all your projects will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed.", 'aqua' )
			),
			array (
				"type" => "textfield",
				"heading" => __ ( 'Number of posts to show', 'aqua' ),
				"param_name" => "posts_per_page",
				'value' => '-1',
				"description" => __ ( 'The number of posts to display. Set to "-1" for display all posts on the page.', 'aqua' )
			),
            array(
                "type" => "checkbox",
                "heading" => __('Show Filter', 'aqua'),
                "param_name" => "show_filter",
                "value" => array(
                    __("Yes, please", 'aqua') => 1
                ),
                "description" => __('Show or hide filter on your grid.', 'aqua')
            ),
			array(
                "type" => "checkbox",
                "heading" => __('Show Sorter', 'aqua'),
                "param_name" => "show_sorter",
                "value" => array(
                    __("Yes, please", 'aqua') => 1
                ),
                "description" => __('Show or hide sorter on your grid.', 'aqua')
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
				"description" => __('Select columns of grid.', 'aqua')
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __("Template", 'aqua'),
                "param_name" => "tpl",
                "value" => array(
                    "Template 1" => "tpl1",
                ),
                "description" => __('Select template on your grid.', 'aqua')
            ),
			array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Padding Item", 'aqua'),
                "param_name" => "padding_item",
                "value" => "",
                "description" => __("Please, Enter number width 'px' for padding item on your grid. Ex: 5px;", 'aqua')
            ),
            array(
                "type" => "checkbox",
                "heading" => __('Crop image', 'aqua'),
                "param_name" => "crop_image",
                "value" => array(
                    __("Yes, please", 'aqua') => true
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
                    __("Yes, please", 'aqua') => true
                ),
                "description" => __('Show or hide title of post on your grid.', 'aqua')
            ),
            array(
                "type" => "checkbox",
                "heading" => __('Show Description', 'aqua'),
                "param_name" => "show_description",
                "value" => array(
                    __("Yes, please", 'aqua') => true
                ),
                "description" => __('Show or hide description of post on your grid.', 'aqua')
            ),
            array(
                "type" => "textfield",
                "heading" => __('Excerpt Length', 'aqua'),
                "param_name" => "excerpt_length",
                "value" => '',
                "description" => __('The length of the excerpt, number of words to display.', 'aqua')
            ),
            array(
                "type" => "textfield",
                "heading" => __('Excerpt More', 'aqua'),
                "param_name" => "excerpt_more",
                "value" => "",
                "description" => __('Excerpt More', 'aqua')
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
