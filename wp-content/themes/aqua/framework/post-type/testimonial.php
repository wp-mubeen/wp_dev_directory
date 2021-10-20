<?php
// Register Custom Post Type
function tb_add_post_type_testimonial() {
    // Register taxonomy
    $labels = array(
            'name'              => _x( 'Testimonial Category', 'taxonomy general name', 'aqua' ),
            'singular_name'     => _x( 'Testimonial Category', 'taxonomy singular name', 'aqua' ),
            'search_items'      => __( 'Search Testimonial Category', 'aqua' ),
            'all_items'         => __( 'All Testimonial Category', 'aqua' ),
            'parent_item'       => __( 'Parent Testimonial Category', 'aqua' ),
            'parent_item_colon' => __( 'Parent Testimonial Category:', 'aqua' ),
            'edit_item'         => __( 'Edit Testimonial Category', 'aqua' ),
            'update_item'       => __( 'Update Testimonial Category', 'aqua' ),
            'add_new_item'      => __( 'Add New Testimonial Category', 'aqua' ),
            'new_item_name'     => __( 'New Testimonial Category Name', 'aqua' ),
            'menu_name'         => __( 'Testimonial Category', 'aqua' ),
    );

    $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'testimonial_category' ),
    );
    if(function_exists('custom_reg_taxonomy')) {
        custom_reg_taxonomy( 'testimonial_category', array( 'testimonial' ), $args );
    }
    //Register tags
    $labels = array(
            'name'              => _x( 'Testimonial Tag', 'taxonomy general name', 'aqua' ),
            'singular_name'     => _x( 'Testimonial Tag', 'taxonomy singular name', 'aqua' ),
            'search_items'      => __( 'Search Testimonial Tag', 'aqua' ),
            'all_items'         => __( 'All Testimonial Tag', 'aqua' ),
            'parent_item'       => __( 'Parent Testimonial Tag', 'aqua' ),
            'parent_item_colon' => __( 'Parent Testimonial Tag:', 'aqua' ),
            'edit_item'         => __( 'Edit Testimonial Tag', 'aqua' ),
            'update_item'       => __( 'Update Testimonial Tag', 'aqua' ),
            'add_new_item'      => __( 'Add New Testimonial Tag', 'aqua' ),
            'new_item_name'     => __( 'New Testimonial Tag Name', 'aqua' ),
            'menu_name'         => __( 'Testimonial Tag', 'aqua' ),
    );

    $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'testimonial_tag' ),
    );
    
    if(function_exists('custom_reg_taxonomy')) {
        custom_reg_taxonomy( 'testimonial_tag', array( 'testimonial' ), $args );
    }
    
    //Register post type Testimonial
    $labels = array(
            'name'                => _x( 'Testimonial', 'Post Type General Name', 'aqua' ),
            'singular_name'       => _x( 'Testimonial Item', 'Post Type Singular Name', 'aqua' ),
            'menu_name'           => __( 'Testimonial', 'aqua' ),
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
            'label'               => __( 'Testimonial', 'aqua' ),
            'description'         => __( 'Testimonial Description', 'aqua' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields', 'page-attributes', 'post-formats', ),
            'taxonomies'          => array( 'testimonial_category', 'testimonial_tag' ),
            'hierarchical'        => true,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-yes',
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'page',
    );
    
    if(function_exists('custom_reg_post_type')) {
        custom_reg_post_type( 'testimonial', $args );
    }
    
}

// Hook into the 'init' action
add_action( 'init', 'tb_add_post_type_testimonial', 0 );
