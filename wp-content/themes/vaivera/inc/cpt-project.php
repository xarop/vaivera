<?php
/**
 * Project Custom Post Type
 *
 * @package Vaivera
 * @since   1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register the Project custom post type
 */
function vaivera_register_project_cpt()
{
    $labels = array(
        'name'               => _x('Projects', 'post type general name', 'vaivera'),
        'singular_name'      => _x('Project', 'post type singular name', 'vaivera'),
        'menu_name'          => _x('Projects', 'admin menu', 'vaivera'),
        'name_admin_bar'     => _x('Project', 'add new on admin bar', 'vaivera'),
        'add_new'            => _x('Add New', 'project', 'vaivera'),
        'add_new_item'       => __('Add New Project', 'vaivera'),
        'new_item'           => __('New Project', 'vaivera'),
        'edit_item'          => __('Edit Project', 'vaivera'),
        'view_item'          => __('View Project', 'vaivera'),
        'view_items'         => __('View Projects', 'vaivera'),
        'all_items'          => __('All Projects', 'vaivera'),
        'search_items'       => __('Search Projects', 'vaivera'),
        'parent_item_colon'  => __('Parent Projects:', 'vaivera'),
        'not_found'          => __('No projects found.', 'vaivera'),
        'not_found_in_trash' => __('No projects found in Trash.', 'vaivera')
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __('Project custom post type.', 'vaivera'),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'project'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-portfolio',
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest'       => false, // Disable Gutenberg editor
    );

    register_post_type('project', $args);
}
add_action('init', 'vaivera_register_project_cpt');

/**
 * Register Project taxonomy
 */
function vaivera_register_project_taxonomy()
{
    $labels = array(
        'name'              => _x('Project Categories', 'taxonomy general name', 'vaivera'),
        'singular_name'     => _x('Project Category', 'taxonomy singular name', 'vaivera'),
        'search_items'      => __('Search Project Categories', 'vaivera'),
        'all_items'         => __('All Project Categories', 'vaivera'),
        'parent_item'       => __('Parent Project Category', 'vaivera'),
        'parent_item_colon' => __('Parent Project Category:', 'vaivera'),
        'edit_item'         => __('Edit Project Category', 'vaivera'),
        'update_item'       => __('Update Project Category', 'vaivera'),
        'add_new_item'      => __('Add New Project Category', 'vaivera'),
        'new_item_name'     => __('New Project Category Name', 'vaivera'),
        'menu_name'         => __('Categories', 'vaivera'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'project-category'),
        'show_in_rest'      => true, // Enable in Gutenberg
    );

    register_taxonomy('project_category', array('project'), $args);
}
add_action('init', 'vaivera_register_project_taxonomy');
