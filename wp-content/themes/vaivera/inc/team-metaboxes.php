<?php
/**
 * Team Meta Boxes
 *
 * @package Vaivera
 * @since   1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register meta boxes for the Team post type
 */
function vaivera_register_team_meta_boxes()
{
    add_meta_box(
        'vaivera_team_member_info',
        __('Team Member Information', 'vaivera'),
        'vaivera_team_member_info_callback',
        'team',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'vaivera_register_team_meta_boxes');

/**
 * Render the Team Member Information meta box
 */
function vaivera_team_member_info_callback($post)
{
    wp_nonce_field('vaivera_team_member_nonce', 'vaivera_team_member_nonce');
    
    // Get current values
    $position = get_post_meta($post->ID, 'team_member_position', true);
    $location = get_post_meta($post->ID, 'team_member_location', true);
    $phone = get_post_meta($post->ID, 'team_member_phone', true);
    $email = get_post_meta($post->ID, 'team_member_email', true);
    $website = get_post_meta($post->ID, 'team_member_website', true);
    
    ?>
    <div id="vaivera-team-member-fields">
        <p><?php _e('Enter the team member\'s contact information and details.', 'vaivera'); ?></p>
        
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="team_member_position"><?php _e('Position/Title', 'vaivera'); ?></label>
                </th>
                <td>
                    <input type="text" class="regular-text" 
                        id="team_member_position" 
                        name="team_member_position" 
                        value="<?php echo esc_attr($position); ?>" 
                        placeholder="<?php esc_attr_e('e.g., Arquitecta núm. 0000', 'vaivera'); ?>" />
                    <p class="description"><?php _e('Job title or professional designation', 'vaivera'); ?></p>
                </td>
            </tr>
            
            <tr>
                <th scope="row">
                    <label for="team_member_location"><?php _e('Location', 'vaivera'); ?></label>
                </th>
                <td>
                    <input type="text" class="regular-text" 
                        id="team_member_location" 
                        name="team_member_location" 
                        value="<?php echo esc_attr($location); ?>" 
                        placeholder="<?php esc_attr_e('e.g., Barcelona', 'vaivera'); ?>" />
                    <p class="description"><?php _e('City or location where this person is based', 'vaivera'); ?></p>
                </td>
            </tr>
            
            <tr>
                <th scope="row">
                    <label for="team_member_phone"><?php _e('Phone', 'vaivera'); ?></label>
                </th>
                <td>
                    <input type="tel" class="regular-text" 
                        id="team_member_phone" 
                        name="team_member_phone" 
                        value="<?php echo esc_attr($phone); ?>" 
                        placeholder="<?php esc_attr_e('e.g., +34 679 583 834', 'vaivera'); ?>" />
                    <p class="description"><?php _e('Contact phone number', 'vaivera'); ?></p>
                </td>
            </tr>
            
            <tr>
                <th scope="row">
                    <label for="team_member_email"><?php _e('Email', 'vaivera'); ?></label>
                </th>
                <td>
                    <input type="email" class="regular-text" 
                        id="team_member_email" 
                        name="team_member_email" 
                        value="<?php echo esc_attr($email); ?>" 
                        placeholder="<?php esc_attr_e('e.g., name@vaivera.eu', 'vaivera'); ?>" />
                    <p class="description"><?php _e('Contact email address', 'vaivera'); ?></p>
                </td>
            </tr>
            
            <tr>
                <th scope="row">
                    <label for="team_member_website"><?php _e('Website', 'vaivera'); ?></label>
                </th>
                <td>
                    <input type="url" class="regular-text" 
                        id="team_member_website" 
                        name="team_member_website" 
                        value="<?php echo esc_attr($website); ?>" 
                        placeholder="<?php esc_attr_e('e.g., https://website.com', 'vaivera'); ?>" />
                    <p class="description"><?php _e('Personal or professional website (optional)', 'vaivera'); ?></p>
                </td>
            </tr>
        </table>
    </div>
    
    <style>
    #vaivera-team-member-fields .form-table th {
        width: 200px;
        padding-left: 0;
    }
    #vaivera-team-member-fields .regular-text {
        width: 100%;
        max-width: 400px;
    }
    #vaivera-team-member-fields .description {
        font-style: italic;
        color: #666;
    }
    </style>
    <?php
}

/**
 * Save team member meta data
 */
function vaivera_save_team_meta($post_id)
{
    // Check if nonce is set
    if (!isset($_POST['vaivera_team_member_nonce'])) {
        return;
    }
    
    // Verify nonce
    if (!wp_verify_nonce($_POST['vaivera_team_member_nonce'], 'vaivera_team_member_nonce')) {
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
    
    // Save individual team member fields
    $fields = array(
        'team_member_position',
        'team_member_location',
        'team_member_phone',
        'team_member_email',
        'team_member_website'
    );
    
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            $value = $_POST[$field];
            
            // Sanitize based on field type
            switch ($field) {
            case 'team_member_email':
                $value = sanitize_email($value);
                break;
            case 'team_member_website':
                $value = esc_url_raw($value);
                break;
            default:
                $value = sanitize_text_field($value);
                break;
            }
            
            // Update or delete meta
            if (!empty($value)) {
                update_post_meta($post_id, $field, $value);
            } else {
                delete_post_meta($post_id, $field);
            }
        }
    }
}
add_action('save_post_team', 'vaivera_save_team_meta');
