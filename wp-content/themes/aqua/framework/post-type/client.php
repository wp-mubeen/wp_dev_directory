<?php
// Register Custom Post Type
function tb_add_post_type_client() {
    // Register taxonomy
    $labels = array(
            'name'              => _x( 'Client Category', 'taxonomy general name', 'aqua' ),
            'singular_name'     => _x( 'Client Category', 'taxonomy singular name', 'aqua' ),
            'search_items'      => __( 'Search Client Category', 'aqua' ),
            'all_items'         => __( 'All Client Category', 'aqua' ),
            'parent_item'       => __( 'Parent Client Category', 'aqua' ),
            'parent_item_colon' => __( 'Parent Client Category:', 'aqua' ),
            'edit_item'         => __( 'Edit Client Category', 'aqua' ),
            'update_item'       => __( 'Update Client Category', 'aqua' ),
            'add_new_item'      => __( 'Add New Client Category', 'aqua' ),
            'new_item_name'     => __( 'New Client Category Name', 'aqua' ),
            'menu_name'         => __( 'Client Category', 'aqua' ),
    );

    $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'client_category' ),
    );
    if(function_exists('custom_reg_taxonomy')) {
        custom_reg_taxonomy( 'client_category', array( 'client' ), $args );
    }
    //Register tags
    $labels = array(
            'name'              => _x( 'Client Tag', 'taxonomy general name', 'aqua' ),
            'singular_name'     => _x( 'Client Tag', 'taxonomy singular name', 'aqua' ),
            'search_items'      => __( 'Search Client Tag', 'aqua' ),
            'all_items'         => __( 'All Client Tag', 'aqua' ),
            'parent_item'       => __( 'Parent Client Tag', 'aqua' ),
            'parent_item_colon' => __( 'Parent Client Tag:', 'aqua' ),
            'edit_item'         => __( 'Edit Client Tag', 'aqua' ),
            'update_item'       => __( 'Update Client Tag', 'aqua' ),
            'add_new_item'      => __( 'Add New Client Tag', 'aqua' ),
            'new_item_name'     => __( 'New Client Tag Name', 'aqua' ),
            'menu_name'         => __( 'Client Tag', 'aqua' ),
    );

    $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'client_tag' ),
    );
    
    if(function_exists('custom_reg_taxonomy')) {
        custom_reg_taxonomy( 'client_tag', array( 'client' ), $args );
    }
    
    //Register post type Client
    $labels = array(
            'name'                => _x( 'Client', 'Post Type General Name', 'aqua' ),
            'singular_name'       => _x( 'Client Item', 'Post Type Singular Name', 'aqua' ),
            'menu_name'           => __( 'Client', 'aqua' ),
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
            'label'               => __( 'Client', 'aqua' ),
            'description'         => __( 'Client Description', 'aqua' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields', 'page-attributes', 'post-formats', ),
            'taxonomies'          => array( 'client_category', 'client_tag' ),
            'hierarchical'        => true,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-networking',
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'page',
    );
    
    if(function_exists('custom_reg_post_type')) {
        custom_reg_post_type( 'client', $args );
    }
    
}

// Hook into the 'init' action
add_action( 'init', 'tb_add_post_type_client', 0 );
