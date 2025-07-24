<?php
/**
 * Project Editor Support
 *
 * @package Vaivera
 * @since   1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Force classic editor for Project CPT
 */
function vaivera_force_classic_editor_for_project($use_block_editor, $post_type)
{
    if ($post_type === 'project') {
        return false; // Disable block editor for projects
    }
    return $use_block_editor;
}
add_filter('use_block_editor_for_post_type', 'vaivera_force_classic_editor_for_project', 10, 2);

/**
 * Add custom styles for the project editor
 */
function vaivera_project_editor_styles()
{
    global $post_type;
    
    if ($post_type === 'project') {
        // Add custom styles for the classic editor
        add_editor_style('css/project-editor.css');
    }
}
add_action('admin_init', 'vaivera_project_editor_styles');

/**
 * Customize the editor for projects
 */
function vaivera_customize_project_editor()
{
    global $post_type;
    
    if ($post_type === 'project') {
        // Add custom TinyMCE settings
        add_filter('tiny_mce_before_init', 'vaivera_project_tinymce_settings');
        
        // Add custom editor classes
        add_filter('admin_body_class', 'vaivera_project_admin_body_class');
    }
}
add_action('admin_head', 'vaivera_customize_project_editor');

/**
 * Add custom TinyMCE settings for project editor
 */
function vaivera_project_tinymce_settings($settings)
{
    // Set custom editor height
    $settings['height'] = 400;
    
    // Add custom styles to the format dropdown
    $style_formats = array(
        array(
            'title' => 'Project Heading',
            'block' => 'h3',
            'classes' => 'project-heading',
        ),
        array(
            'title' => 'Project Subheading',
            'block' => 'h4',
            'classes' => 'project-subheading',
        ),
        array(
            'title' => 'Highlight Text',
            'inline' => 'span',
            'classes' => 'project-highlight',
        ),
        array(
            'title' => 'Feature List',
            'selector' => 'ul',
            'classes' => 'project-features',
        ),
    );
    
    $settings['style_formats'] = json_encode($style_formats);
    $settings['style_formats_merge'] = false;
    
    return $settings;
}

/**
 * Add custom admin body class for project editor
 */
function vaivera_project_admin_body_class($classes)
{
    return $classes . ' vaivera-project-editor';
}

/**
 * Add help text above the editor
 */
function vaivera_project_editor_help_text()
{
    global $post_type;
    
    if ($post_type === 'project' && get_current_screen()->base === 'post') {
        ?>
        <!-- <div class="project-editor-help">
            <p><?php _e('Add your project description here. Use the formatting options in the toolbar to style your content.', 'vaivera'); ?></p>
            <p><?php _e('You can add images, lists, and other content using the editor buttons above.', 'vaivera'); ?></p>
        </div> -->
        <style>
            .project-editor-help {
                margin: 10px 0;
                padding: 10px 15px;
                background: #f8f8f8;
                border-left: 4px solid #0073aa;
            }
            
            .vaivera-project-editor #post-body-content {
                margin-bottom: 20px;
            }
            
            /* Make the editor more prominent */
            .vaivera-project-editor .wp-editor-container {
                border: 1px solid #ddd;
                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            }
            
            /* Add some spacing between editor and metaboxes */
            .vaivera-project-editor #postdivrich {
                margin-bottom: 30px;
            }
        </style>
        <?php
    }
}
add_action('edit_form_after_title', 'vaivera_project_editor_help_text');

/**
 * Add custom CSS for the project editor
 */
function vaivera_project_editor_css()
{
    // Create the CSS directory if it doesn't exist
    $css_dir = get_template_directory() . '/css';
    if (!file_exists($css_dir)) {
        wp_mkdir_p($css_dir);
    }
    
    // Create the project editor CSS file if it doesn't exist
    $css_file = $css_dir . '/project-editor.css';
    if (!file_exists($css_file)) {
        $css_content = "
/**
 * Project Editor Styles
 */

/* Project Heading */
.project-heading {
    font-size: 24px;
    color: #333;
    margin-top: 30px;
    margin-bottom: 15px;
    border-bottom: 2px solid #eee;
    padding-bottom: 5px;
}

/* Project Subheading */
.project-subheading {
    font-size: 18px;
    color: #555;
    margin-top: 20px;
    margin-bottom: 10px;
}

/* Highlight Text */
.project-highlight {
    background-color: #f8f9fa;
    padding: 2px 5px;
    border-left: 3px solid #0073aa;
}

/* Feature List */
.project-features {
    margin-left: 0;
    padding-left: 20px;
}

.project-features li {
    margin-bottom: 10px;
    list-style-type: none;
    position: relative;
    padding-left: 25px;
}

.project-features li:before {
    content: '✓';
    position: absolute;
    left: 0;
    color: #0073aa;
    font-weight: bold;
}

/* General Content Styles */
body#tinymce.wp-editor {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif;
    line-height: 1.6;
    color: #333;
    padding: 20px;
}

body#tinymce.wp-editor p {
    margin-bottom: 15px;
}

body#tinymce.wp-editor h2 {
    font-size: 28px;
    margin-top: 30px;
    margin-bottom: 15px;
}

body#tinymce.wp-editor h3 {
    font-size: 24px;
    margin-top: 25px;
    margin-bottom: 12px;
}

body#tinymce.wp-editor h4 {
    font-size: 20px;
    margin-top: 20px;
    margin-bottom: 10px;
}

body#tinymce.wp-editor ul,
body#tinymce.wp-editor ol {
    margin-left: 20px;
    margin-bottom: 15px;
}

body#tinymce.wp-editor li {
    margin-bottom: 5px;
}

body#tinymce.wp-editor img {
    max-width: 100%;
    height: auto;
}

body#tinymce.wp-editor blockquote {
    border-left: 4px solid #0073aa;
    padding-left: 15px;
    margin-left: 0;
    font-style: italic;
    color: #555;
}
";
        file_put_contents($css_file, $css_content);
    }
}
add_action('after_setup_theme', 'vaivera_project_editor_css');
