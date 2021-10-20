<?php
// Register Custom Post Type
function tb_add_post_type_portfolio() {
    // Register taxonomy
    $labels = array(
            'name'              => _x( 'Portfolio Category', 'taxonomy general name', 'aqua' ),
            'singular_name'     => _x( 'Portfolio Category', 'taxonomy singular name', 'aqua' ),
            'search_items'      => __( 'Search Portfolio Category', 'aqua' ),
            'all_items'         => __( 'All Portfolio Category', 'aqua' ),
            'parent_item'       => __( 'Parent Portfolio Category', 'aqua' ),
            'parent_item_colon' => __( 'Parent Portfolio Category:', 'aqua' ),
            'edit_item'         => __( 'Edit Portfolio Category', 'aqua' ),
            'update_item'       => __( 'Update Portfolio Category', 'aqua' ),
            'add_new_item'      => __( 'Add New Portfolio Category', 'aqua' ),
            'new_item_name'     => __( 'New Portfolio Category Name', 'aqua' ),
            'menu_name'         => __( 'Portfolio Category', 'aqua' ),
    );

    $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'portfolio_category' ),
    );
    if(function_exists('custom_reg_taxonomy')) {
        custom_reg_taxonomy( 'portfolio_category', array( 'portfolio' ), $args );
    }
    //Register tags
    $labels = array(
            'name'              => _x( 'Portfolio Tag', 'taxonomy general name', 'aqua' ),
            'singular_name'     => _x( 'Portfolio Tag', 'taxonomy singular name', 'aqua' ),
            'search_items'      => __( 'Search Portfolio Tag', 'aqua' ),
            'all_items'         => __( 'All Portfolio Tag', 'aqua' ),
            'parent_item'       => __( 'Parent Portfolio Tag', 'aqua' ),
            'parent_item_colon' => __( 'Parent Portfolio Tag:', 'aqua' ),
            'edit_item'         => __( 'Edit Portfolio Tag', 'aqua' ),
            'update_item'       => __( 'Update Portfolio Tag', 'aqua' ),
            'add_new_item'      => __( 'Add New Portfolio Tag', 'aqua' ),
            'new_item_name'     => __( 'New Portfolio Tag Name', 'aqua' ),
            'menu_name'         => __( 'Portfolio Tag', 'aqua' ),
    );

    $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'portfolio_tag' ),
    );
    
    if(function_exists('custom_reg_taxonomy')) {
        custom_reg_taxonomy( 'portfolio_tag', array( 'portfolio' ), $args );
    }
    
    //Register post type portfolio
    $labels = array(
            'name'                => _x( 'Portfolio', 'Post Type General Name', 'aqua' ),
            'singular_name'       => _x( 'Portfolio Item', 'Post Type Singular Name', 'aqua' ),
            'menu_name'           => __( 'Portfolio', 'aqua' ),
            'parent_item_colon'   => __( 'Parent Item:', 'aqua' ),
            'all_items'           => __( 'All Items', 'aqua' ),
            'view_item'           => __( 'View Item', 'aqua' ),
            'add_new_item'        => __( 'Add New Item', 'aqua' ),
            'add_new'             => __( 'Add New', 'aqua' ),
            'edit_item'           => __( 'Edit Item', 'aqua' ),
            'update_item'         => __( 'Update Item', 'aqua' ),
            'search_items'        => __( 'Search Item', 'aqua' ),
            'not_found'           => __( 'Not found', 'aqua' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'aqua' ),
    );
    $args = array(
            'label'               => __( 'Portfolio', 'aqua' ),
            'description'         => __( 'Portfolio Description', 'aqua' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields', 'page-attributes', 'post-formats', ),
            'taxonomies'          => array( 'portfolio_category', 'portfolio_tag' ),
            'hierarchical'        => true,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-welcome-view-site',
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'page',
    );
    
    if(function_exists('custom_reg_post_type')) {
        custom_reg_post_type( 'portfolio', $args );
    }
    
}

// Hook into the 'init' action
add_action( 'init', 'tb_add_post_type_portfolio', 0 );
