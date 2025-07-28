<?php
/**
 * Project Meta Boxes
 *
 * @package Vaivera
 * @since   1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register meta boxes for the Project post type
 */
function vaivera_register_project_meta_boxes()
{
    add_meta_box(
        'vaivera_project_details',
        __('Project Details', 'vaivera'),
        'vaivera_project_details_callback',
        'project',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'vaivera_register_project_meta_boxes');

/**
 * Render the Project Details meta box
 */
function vaivera_project_details_callback($post)
{
    wp_nonce_field('vaivera_project_details_nonce', 'vaivera_project_details_nonce');
    
    // Get existing meta values
    $subtitle = get_post_meta($post->ID, '_vaivera_project_subtitle', true);
    $work = get_post_meta($post->ID, '_vaivera_project_work', true);
    $year = get_post_meta($post->ID, '_vaivera_project_year', true);
    $location = get_post_meta($post->ID, '_vaivera_project_location', true);
    $client = get_post_meta($post->ID, '_vaivera_project_client', true);
    $superficie = get_post_meta($post->ID, '_vaivera_project_superficie', true);
    $budget = get_post_meta($post->ID, '_vaivera_project_budget', true);
    $team = get_post_meta($post->ID, '_vaivera_project_team', true);
    $colaborators = get_post_meta($post->ID, '_vaivera_project_colaborators', true);
    $constructo = get_post_meta($post->ID, '_vaivera_project_constructo', true);
    $photograph = get_post_meta($post->ID, '_vaivera_project_photograph', true);
    
    ?>
    <div id="vaivera-project-details">
        <p><?php _e('Add details for this project.', 'vaivera'); ?></p>
        
        <div class="project-fields-grid">
            <div class="field-group">
                <label for="vaivera_project_subtitle"><?php _e('Subtitle:', 'vaivera'); ?></label>
                <input type="text" class="widefat" 
                    id="vaivera_project_subtitle" 
                    name="vaivera_project_subtitle" 
                    value="<?php echo esc_attr($subtitle); ?>" />
            </div>
            
            <div class="field-group full-width">
                <label for="vaivera_project_work"><?php _e('Feina Realitzada:', 'vaivera'); ?></label>
                <textarea class="widefat" 
                    id="vaivera_project_work" 
                    name="vaivera_project_work" 
                    rows="4"
                    placeholder="<?php esc_attr_e('Descripció de la feina realitzada en el projecte...', 'vaivera'); ?>"><?php echo esc_textarea($work); ?></textarea>
            </div>
            
            <div class="field-group">
                <label for="vaivera_project_year"><?php _e('Year:', 'vaivera'); ?></label>
                <input type="number" class="widefat" 
                    id="vaivera_project_year" 
                    name="vaivera_project_year" 
                    value="<?php echo esc_attr($year); ?>" 
                    min="1900" 
                    max="<?php echo date('Y') + 10; ?>" />
            </div>
            
            <div class="field-group">
                <label for="vaivera_project_location"><?php _e('Location:', 'vaivera'); ?></label>
                <input type="text" class="widefat" 
                    id="vaivera_project_location" 
                    name="vaivera_project_location" 
                    value="<?php echo esc_attr($location); ?>" />
            </div>
            
            <div class="field-group">
                <label for="vaivera_project_client"><?php _e('Client:', 'vaivera'); ?></label>
                <input type="text" class="widefat" 
                    id="vaivera_project_client" 
                    name="vaivera_project_client" 
                    value="<?php echo esc_attr($client); ?>" />
            </div>
            
            <div class="field-group">
                <label for="vaivera_project_superficie"><?php _e('Superficie (m²):', 'vaivera'); ?></label>
                <input type="number" class="widefat" 
                    id="vaivera_project_superficie" 
                    name="vaivera_project_superficie" 
                    value="<?php echo esc_attr($superficie); ?>" 
                    step="0.01" 
                    min="0" />
            </div>
            
            <div class="field-group">
                <label for="vaivera_project_budget"><?php _e('Budget (€):', 'vaivera'); ?></label>
                <input type="number" class="widefat" 
                    id="vaivera_project_budget" 
                    name="vaivera_project_budget" 
                    value="<?php echo esc_attr($budget); ?>" 
                    step="0.01" 
                    min="0" />
            </div>
            
            <div class="field-group">
                <label for="vaivera_project_team"><?php _e('Team:', 'vaivera'); ?></label>
                <input type="text" class="widefat" 
                    id="vaivera_project_team" 
                    name="vaivera_project_team" 
                    value="<?php echo esc_attr($team); ?>" />
            </div>
            
            <div class="field-group">
                <label for="vaivera_project_colaborators"><?php _e('Colaborators:', 'vaivera'); ?></label>
                <input type="text" class="widefat" 
                    id="vaivera_project_colaborators" 
                    name="vaivera_project_colaborators" 
                    value="<?php echo esc_attr($colaborators); ?>" />
            </div>
            
            <div class="field-group">
                <label for="vaivera_project_constructo"><?php _e('Constructor:', 'vaivera'); ?></label>
                <input type="text" class="widefat" 
                    id="vaivera_project_constructo" 
                    name="vaivera_project_constructo" 
                    value="<?php echo esc_attr($constructo); ?>" />
            </div>
            
            <div class="field-group">
                <label for="vaivera_project_photograph"><?php _e('Photograph:', 'vaivera'); ?></label>
                <input type="text" class="widefat" 
                    id="vaivera_project_photograph" 
                    name="vaivera_project_photograph" 
                    value="<?php echo esc_attr($photograph); ?>" />
            </div>
        </div>
    </div>
    
    <style>
    .project-fields-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-top: 15px;
    }
    .field-group {
        display: flex;
        flex-direction: column;
    }
    .field-group.full-width {
        grid-column: 1 / -1;
    }
    .field-group label {
        font-weight: 600;
        margin-bottom: 5px;
        color: #333;
    }
    .field-group textarea {
        min-height: 100px;
        resize: vertical;
    }
    @media (max-width: 782px) {
        .project-fields-grid {
            grid-template-columns: 1fr;
        }
        .field-group.full-width {
            grid-column: 1;
        }
    }
    </style>
    <?php
}



/**
 * Save project meta data
 */
function vaivera_save_project_meta($post_id)
{
    // Check if nonce is set
    if (!isset($_POST['vaivera_project_details_nonce'])) {
        return;
    }
    
    // Verify nonce
    if (!wp_verify_nonce($_POST['vaivera_project_details_nonce'], 'vaivera_project_details_nonce')) {
        return;
    }
    
    // Check if autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save project details
    $fields = array(
        'vaivera_project_subtitle' => '_vaivera_project_subtitle',
        'vaivera_project_work' => '_vaivera_project_work',
        'vaivera_project_year' => '_vaivera_project_year',
        'vaivera_project_location' => '_vaivera_project_location',
        'vaivera_project_client' => '_vaivera_project_client',
        'vaivera_project_superficie' => '_vaivera_project_superficie',
        'vaivera_project_budget' => '_vaivera_project_budget',
        'vaivera_project_team' => '_vaivera_project_team',
        'vaivera_project_colaborators' => '_vaivera_project_colaborators',
        'vaivera_project_constructo' => '_vaivera_project_constructo',
        'vaivera_project_photograph' => '_vaivera_project_photograph'
    );
    
    foreach ($fields as $field_name => $meta_key) {
        if (isset($_POST[$field_name])) {
            $value = $_POST[$field_name];
            
            // Special handling for number fields
            if ($field_name === 'vaivera_project_superficie' || $field_name === 'vaivera_project_budget') {
                $value = floatval($value);
            } elseif ($field_name === 'vaivera_project_year') {
                $value = intval($value);
            } else {
                $value = sanitize_text_field($value);
            }
            
            if (!empty($value)) {
                update_post_meta($post_id, $meta_key, $value);
            } else {
                delete_post_meta($post_id, $meta_key);
            }
        }
    }
}
add_action('save_post_project', 'vaivera_save_project_meta');
