<?php
// Register Custom Post Type
function tb_add_post_type_space() {
    // Register taxonomy
    $labels = array(
            'name'              => _x( 'Space Category', 'taxonomy general name', 'aqua' ),
            'singular_name'     => _x( 'Space Category', 'taxonomy singular name', 'aqua' ),
            'search_items'      => __( 'Search Space Category', 'aqua' ),
            'all_items'         => __( 'All Space Category', 'aqua' ),
            'parent_item'       => __( 'Parent Space Category', 'aqua' ),
            'parent_item_colon' => __( 'Parent Space Category:', 'aqua' ),
            'edit_item'         => __( 'Edit Space Category', 'aqua' ),
            'update_item'       => __( 'Update Space Category', 'aqua' ),
            'add_new_item'      => __( 'Add New Space Category', 'aqua' ),
            'new_item_name'     => __( 'New Space Category Name', 'aqua' ),
            'menu_name'         => __( 'Space Category', 'aqua' ),
    );

    $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'space_category' ),
    );
    if(function_exists('custom_reg_taxonomy')) {
        custom_reg_taxonomy( 'space_category', array( 'space' ), $args );
    }
    //Register tags
    $labels = array(
            'name'              => _x( 'Space Tag', 'taxonomy general name', 'aqua' ),
            'singular_name'     => _x( 'Space Tag', 'taxonomy singular name', 'aqua' ),
            'search_items'      => __( 'Search Space Tag', 'aqua' ),
            'all_items'         => __( 'All Space Tag', 'aqua' ),
            'parent_item'       => __( 'Parent Space Tag', 'aqua' ),
            'parent_item_colon' => __( 'Parent Space Tag:', 'aqua' ),
            'edit_item'         => __( 'Edit Space Tag', 'aqua' ),
            'update_item'       => __( 'Update Space Tag', 'aqua' ),
            'add_new_item'      => __( 'Add New Space Tag', 'aqua' ),
            'new_item_name'     => __( 'New Space Tag Name', 'aqua' ),
            'menu_name'         => __( 'Space Tag', 'aqua' ),
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
        custom_reg_taxonomy( 'portfolio_tag', array( 'space' ), $args );
    }
    
    //Register post type space
    $labels = array(
            'name'                => _x( 'Space', 'Post Type General Name', 'aqua' ),
            'singular_name'       => _x( 'Space Item', 'Post Type Singular Name', 'aqua' ),
            'menu_name'           => __( 'Space', 'aqua' ),
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
            'label'               => __( 'Space', 'aqua' ),
            'description'         => __( 'Space Description', 'aqua' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields', 'page-attributes', 'post-formats', ),
            'taxonomies'          => array( 'space_category', 'portfolio_tag' ),
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
        custom_reg_post_type( 'space', $args );
    }
    
}

// Hook into the 'init' action
add_action( 'init', 'tb_add_post_type_space', 0 );
