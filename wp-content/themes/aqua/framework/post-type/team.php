<?php
// Register Custom Post Type
function tb_add_post_type_team() {
    // Register taxonomy
    $labels = array(
            'name'              => _x( 'Team Category', 'taxonomy general name', 'aqua' ),
            'singular_name'     => _x( 'Team Category', 'taxonomy singular name', 'aqua' ),
            'search_items'      => __( 'Search Team Category', 'aqua' ),
            'all_items'         => __( 'All Team Category', 'aqua' ),
            'parent_item'       => __( 'Parent Team Category', 'aqua' ),
            'parent_item_colon' => __( 'Parent Team Category:', 'aqua' ),
            'edit_item'         => __( 'Edit Team Category', 'aqua' ),
            'update_item'       => __( 'Update Team Category', 'aqua' ),
            'add_new_item'      => __( 'Add New Team Category', 'aqua' ),
            'new_item_name'     => __( 'New Team Category Name', 'aqua' ),
            'menu_name'         => __( 'Team Category', 'aqua' ),
    );

    $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'team_category' ),
    );
    if(function_exists('custom_reg_taxonomy')) {
        custom_reg_taxonomy( 'team_category', array( 'team' ), $args );
    }
    //Register tags
    $labels = array(
            'name'              => _x( 'Team Tag', 'taxonomy general name', 'aqua' ),
            'singular_name'     => _x( 'Team Tag', 'taxonomy singular name', 'aqua' ),
            'search_items'      => __( 'Search Team Tag', 'aqua' ),
            'all_items'         => __( 'All Team Tag', 'aqua' ),
            'parent_item'       => __( 'Parent Team Tag', 'aqua' ),
            'parent_item_colon' => __( 'Parent Team Tag:', 'aqua' ),
            'edit_item'         => __( 'Edit Team Tag', 'aqua' ),
            'update_item'       => __( 'Update Team Tag', 'aqua' ),
            'add_new_item'      => __( 'Add New Team Tag', 'aqua' ),
            'new_item_name'     => __( 'New Team Tag Name', 'aqua' ),
            'menu_name'         => __( 'Team Tag', 'aqua' ),
    );

    $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'team_tag' ),
    );
    
    if(function_exists('custom_reg_taxonomy')) {
        custom_reg_taxonomy( 'team_tag', array( 'team' ), $args );
    }
    
    //Register post type Team
    $labels = array(
            'name'                => _x( 'Team', 'Post Type General Name', 'aqua' ),
            'singular_name'       => _x( 'Team Item', 'Post Type Singular Name', 'aqua' ),
            'menu_name'           => __( 'Team', 'aqua' ),
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
            'label'               => __( 'Team', 'aqua' ),
            'description'         => __( 'Team Description', 'aqua' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields', 'page-attributes', 'post-formats', ),
            'taxonomies'          => array( 'team_category', 'team_tag' ),
            'hierarchical'        => true,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-groups',
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'page',
    );
    
    if(function_exists('custom_reg_post_type')) {
        custom_reg_post_type( 'team', $args );
    }
    
}

// Hook into the 'init' action
add_action( 'init', 'tb_add_post_type_team', 0 );
