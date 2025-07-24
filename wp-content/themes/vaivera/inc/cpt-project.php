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
        'rewrite'            => array('slug' => 'projects'),
        'capability_type'    => 'post',
        'has_archive'        => 'projects',
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

/**
 * Modify admin bar menu items for Project CPT
 *
 * @param WP_Admin_Bar $wp_admin_bar Admin bar object.
 */
function vaivera_modify_project_admin_bar_menu($wp_admin_bar)
{
    // Find the "View Posts" node for projects
    $view_item = $wp_admin_bar->get_node('archive');
    
    // If we're on a project page and the archive node exists
    if (is_singular('project') && $view_item) {
        // Modify the title to "View Projects"
        $view_item->title = __('View Projects', 'vaivera');
        
        // Update the node
        $wp_admin_bar->add_node($view_item);
    }
}
add_action('admin_bar_menu', 'vaivera_modify_project_admin_bar_menu', 80);

/**
 * Filter admin bar menu items for Project CPT
 */
function vaivera_filter_admin_bar_menu()
{
    global $wp_admin_bar;
    
    // Only run on project post type
    if (!is_singular('project') && !is_post_type_archive('project')) {
        return;
    }
    
    // Get all nodes
    $all_toolbar_nodes = $wp_admin_bar->get_nodes();
    
    if (!$all_toolbar_nodes) {
        return;
    }
    
    // Loop through nodes to find and modify "View Posts"
    foreach ($all_toolbar_nodes as $node) {
        if (isset($node->href) && strpos($node->href, '/project/') !== false && $node->title === 'View Posts') {
            // Update the title
            $wp_admin_bar->add_node(
                array(
                'id' => $node->id,
                'title' => __('View Projects', 'vaivera'),
                'href' => $node->href,
                'parent' => $node->parent,
                )
            );
        }
    }
}
add_action('wp_before_admin_bar_render', 'vaivera_filter_admin_bar_menu', 999);

/**
 * Flush rewrite rules on theme activation to ensure project URLs work correctly
 */
function vaivera_flush_rewrite_rules()
{
    // First, we need to re-register the post type with the new rewrite rules
    vaivera_register_project_cpt();
    
    // Then flush the rules
    flush_rewrite_rules();
}

// Register an activation hook for the theme
add_action('after_switch_theme', 'vaivera_flush_rewrite_rules');

/**
 * Add a function to manually flush rewrite rules
 * This can be called from the theme's functions.php if needed
 */
function vaivera_manual_flush_rewrite_rules()
{
    flush_rewrite_rules();
}
