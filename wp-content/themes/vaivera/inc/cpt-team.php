<?php
/**
 * Team Custom Post Type
 *
 * @package Vaivera
 * @since   1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register the Team custom post type
 */
function vaivera_register_team_cpt()
{
    $labels = array(
        'name'               => _x('Team', 'post type general name', 'vaivera'),
        'singular_name'      => _x('Team', 'post type singular name', 'vaivera'),
        'menu_name'          => _x('Team', 'admin menu', 'vaivera'),
        'name_admin_bar'     => _x('Team', 'add new on admin bar', 'vaivera'),
        'add_new'            => _x('Add New', 'team', 'vaivera'),
        'add_new_item'       => __('Add New Member', 'vaivera'),
        'new_item'           => __('New Team Member', 'vaivera'),
        'edit_item'          => __('Edit Team Member', 'vaivera'),
        'view_item'          => __('View Team Member', 'vaivera'),
        'view_items'         => __('View Team Members', 'vaivera'),
        'all_items'          => __('All Team Members', 'vaivera'),
        'search_items'       => __('Search Team Members', 'vaivera'),
        'parent_item_colon'  => __('Parent Team Members:', 'vaivera'),
        'not_found'          => __('No team members found.', 'vaivera'),
        'not_found_in_trash' => __('No team members found in Trash.', 'vaivera')
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __('Team custom post type.', 'vaivera'),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'teams'),
        'capability_type'    => 'post',
        'has_archive'        => 'teams',
        'hierarchical'       => false,
        'menu_position'      => 6,
        'menu_icon'          => 'dashicons-groups',
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest'       => false, // Disable Gutenberg editor
    );

    register_post_type('team', $args);
}
add_action('init', 'vaivera_register_team_cpt');

/**
 * Flush rewrite rules on theme activation to ensure team URLs work correctly
 */
function vaivera_flush_team_rewrite_rules()
{
    vaivera_register_team_cpt();
    flush_rewrite_rules();
}

add_action('after_switch_theme', 'vaivera_flush_team_rewrite_rules');
