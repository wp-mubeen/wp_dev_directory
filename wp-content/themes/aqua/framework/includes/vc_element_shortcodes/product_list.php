<?php
if(class_exists('Woocommerce')){
    vc_map(array(
        "name" => __("Product List", 'aqua'),
        "base" => "tb-products-list",
        "class" => "tb-products-list",
        "category" => __('Aqua', 'aqua'),
        'admin_enqueue_js' => array(URI_PATH_ADMIN.'assets/js/customvc.js'),
        "icon" => "tb-icon-for-vc",
        "params" => array(
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
			array (
					"type" => "dropdown",
					"class" => "",
					"heading" => __ ( "Template", 'aqua' ),
					"param_name" => "tpl",
					"value" => array (
						"Template 1" => "tpl1",
						"Template 2" => "tpl2",
					),
					"description" => __ ( "", 'aqua' )
			),
			array (
                "type" => "tb_taxonomy",
                "taxonomy" => "product_cat",
                "heading" => __ ( "Categories", 'aqua' ),
                "param_name" => "product_cat",
                "class" => "",
                "description" => __ ( "Note: By default, all your projects will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed.", 'aqua' )
            ),
			array (
					"type" => "dropdown",
					"class" => "",
					"heading" => __ ( "Show", 'aqua' ),
					"param_name" => "show",
					"value" => array (
							"All Products" => "all_products",
							"Featured Products" => "featured",
							"On-sale Products" => "onsale",
					),
					"description" => __ ( "", 'aqua' )
			),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Post Count", 'aqua'),
                "param_name" => "number",
                "value" => "",
				"description" => __('Please, enter number of post per page. Show all: -1.', 'aqua')
            ),
            array(
                "type" => "checkbox",
                "heading" => __('Show Sale Flash', 'aqua'),
                "param_name" => "show_sale_flash",
                "value" => array(
                    __("Yes, please", 'aqua') => 1
                ),
                "description" => __('Show or hide sale flash of product.', 'aqua')
            ),
			array(
                "type" => "checkbox",
                "heading" => __('Show Title', 'aqua'),
                "param_name" => "show_title",
                "value" => array(
                    __("Yes, please", 'aqua') => 1
                ),
                "description" => __('Show or hide title of product.', 'aqua')
            ),
			array(
                "type" => "checkbox",
                "heading" => __('Show Price', 'aqua'),
                "param_name" => "show_price",
                "value" => array(
                    __("Yes, please", 'aqua') => 1
                ),
                "description" => __('Show or hide price of product.', 'aqua')
            ),
			array(
                "type" => "checkbox",
                "heading" => __('Show Rating', 'aqua'),
                "param_name" => "show_rating",
                "value" => array(
                    __("Yes, please", 'aqua') => 1
                ),
                "description" => __('Show or hide rating of product.', 'aqua')
            ),
			array(
                "type" => "checkbox",
                "heading" => __('Show Add To Cart', 'aqua'),
                "param_name" => "show_add_to_cart",
                "value" => array(
                    __("Yes, please", 'aqua') => 1
                ),
                "description" => __('Show or hide add to cart of product.', 'aqua')
            ),
			array(
                "type" => "checkbox",
                "heading" => __('Show Button Read More', 'aqua'),
                "param_name" => "show_btn_read_more",
                "value" => array(
                    __("Yes, please", 'aqua') => 1
                ),
                "description" => __('Show or hide button read more of product.', 'aqua')
            ),
			array(
                "type" => "checkbox",
                "heading" => __('Hide Free', 'aqua'),
                "param_name" => "hide_free",
                "value" => array(
                    __("Yes, please", 'aqua') => 1
                ),
                "description" => __('Hide free product.', 'aqua')
            ),
			array(
                "type" => "checkbox",
                "heading" => __('Show Hidden', 'aqua'),
                "param_name" => "show_hidden",
                "value" => array(
                    __("Yes, please", 'aqua') => 1
                ),
                "description" => __('Show Hidden product.', 'aqua')
            ),
            array (
					"type" => "dropdown",
					"heading" => __ ( 'Order by', 'aqua' ),
					"param_name" => "orderby",
					"value" => array (
							"None" => "none",
							"Date" => "date",
							"Price" => "price",
							"Random" => "rand",
							"Sales" => "sales",
					),
					"description" => __ ( 'Order by ("none", "date", "price", "rand", "sales").', 'aqua' )
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
                "type" => "checkbox",
                "heading" => __('Show Pagination', 'aqua'),
                "param_name" => "show_pagination",
                "value" => array(
                    __("Yes, please", 'aqua') => 1
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
