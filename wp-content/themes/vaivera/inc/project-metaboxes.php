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
        'vaivera_project_specs',
        __('Project Specifications', 'vaivera'),
        'vaivera_project_specs_callback',
        'project',
        'normal',
        'high'
    );

    // Gallery metabox is now handled by the unified gallery metabox system
    /*
    add_meta_box(
        'vaivera_project_gallery',
        __('Project Gallery', 'vaivera'),
        'vaivera_project_gallery_callback',
        'project',
        'normal',
        'high'
    );
    */
}
add_action('add_meta_boxes', 'vaivera_register_project_meta_boxes');

/**
 * Render the Project Specs meta box
 */
function vaivera_project_specs_callback($post)
{
    wp_nonce_field('vaivera_project_specs_nonce', 'vaivera_project_specs_nonce');
    
    $specs = get_post_meta($post->ID, '_vaivera_project_specs', true);
    
    // Ensure we have at least one empty spec if none exist
    if (empty($specs) || !is_array($specs)) {
        $specs = array(
            array(
                'title' => '',
                'description' => ''
            )
        );
    }
    
    ?>
    <div id="vaivera-project-specs">
        <p><?php _e('Add specifications for this project.', 'vaivera'); ?></p>
        
        <div class="specs-container">
            <?php foreach ($specs as $index => $spec) : ?>
                <div class="spec-row" data-index="<?php echo esc_attr($index); ?>">
                    <div class="spec-header">
                        <span class="spec-title-preview"><?php echo !empty($spec['title']) ? esc_html($spec['title']) : __('New Specification', 'vaivera'); ?></span>
                        <span class="spec-toggle dashicons dashicons-arrow-down-alt2"></span>
                    </div>
                    
                    <div class="spec-content">
                        <p>
                            <label for="vaivera_spec_title_<?php echo esc_attr($index); ?>"><?php _e('Title:', 'vaivera'); ?></label>
                            <input type="text" class="widefat spec-title" 
                                id="vaivera_spec_title_<?php echo esc_attr($index); ?>" 
                                name="vaivera_project_specs[<?php echo esc_attr($index); ?>][title]" 
                                value="<?php echo esc_attr($spec['title']); ?>" />
                        </p>
                        
                        <p>
                            <label for="vaivera_spec_description_<?php echo esc_attr($index); ?>"><?php _e('Description:', 'vaivera'); ?></label>
                            <textarea class="widefat spec-description" 
                                id="vaivera_spec_description_<?php echo esc_attr($index); ?>" 
                                name="vaivera_project_specs[<?php echo esc_attr($index); ?>][description]" 
                                rows="3"><?php echo esc_textarea($spec['description']); ?></textarea>
                        </p>
                        
                        <p>
                            <button type="button" class="button remove-spec"><?php _e('Remove', 'vaivera'); ?></button>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <p>
            <button type="button" class="button add-spec"><?php _e('Add Specification', 'vaivera'); ?></button>
        </p>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        // Toggle spec content
        $('.specs-container').on('click', '.spec-header', function() {
            $(this).next('.spec-content').slideToggle();
            $(this).find('.spec-toggle').toggleClass('dashicons-arrow-down-alt2 dashicons-arrow-up-alt2');
        });
        
        // Update spec title preview when typing
        $('.specs-container').on('input', '.spec-title', function() {
            var title = $(this).val();
            if (title === '') {
                title = '<?php echo esc_js(__('New Specification', 'vaivera')); ?>';
            }
            $(this).closest('.spec-row').find('.spec-title-preview').text(title);
        });
        
        // Add new spec
        $('.add-spec').on('click', function() {
            var index = $('.spec-row').length;
            var newSpec = `
                <div class="spec-row" data-index="${index}">
                    <div class="spec-header">
                        <span class="spec-title-preview"><?php echo esc_js(__('New Specification', 'vaivera')); ?></span>
                        <span class="spec-toggle dashicons dashicons-arrow-down-alt2"></span>
                    </div>
                    
                    <div class="spec-content">
                        <p>
                            <label for="vaivera_spec_title_${index}"><?php echo esc_js(__('Title:', 'vaivera')); ?></label>
                            <input type="text" class="widefat spec-title" 
                                id="vaivera_spec_title_${index}" 
                                name="vaivera_project_specs[${index}][title]" 
                                value="" />
                        </p>
                        
                        <p>
                            <label for="vaivera_spec_description_${index}"><?php echo esc_js(__('Description:', 'vaivera')); ?></label>
                            <textarea class="widefat spec-description" 
                                id="vaivera_spec_description_${index}" 
                                name="vaivera_project_specs[${index}][description]" 
                                rows="3"></textarea>
                        </p>
                        
                        <p>
                            <button type="button" class="button remove-spec"><?php echo esc_js(__('Remove', 'vaivera')); ?></button>
                        </p>
                    </div>
                </div>
            `;
            
            $('.specs-container').append(newSpec);
        });
        
        // Remove spec
        $('.specs-container').on('click', '.remove-spec', function() {
            $(this).closest('.spec-row').remove();
            
            // Re-index remaining specs
            $('.spec-row').each(function(index) {
                var $row = $(this);
                $row.attr('data-index', index);
                
                $row.find('.spec-title')
                    .attr('id', 'vaivera_spec_title_' + index)
                    .attr('name', 'vaivera_project_specs[' + index + '][title]');
                    
                $row.find('.spec-description')
                    .attr('id', 'vaivera_spec_description_' + index)
                    .attr('name', 'vaivera_project_specs[' + index + '][description]');
            });
        });
    });
    </script>
    
    <style>
    .spec-row {
        margin-bottom: 10px;
        border: 1px solid #ddd;
        background: #f9f9f9;
    }
    .spec-header {
        padding: 10px;
        cursor: pointer;
        background: #f1f1f1;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .spec-content {
        padding: 10px;
        border-top: 1px solid #ddd;
    }
    .spec-toggle {
        color: #777;
    }
    </style>
    <?php
}

/**
 * Render the Project Gallery meta box
 */
function vaivera_project_gallery_callback($post)
{
    wp_nonce_field('vaivera_project_gallery_nonce', 'vaivera_project_gallery_nonce');
    
    $gallery_images = get_post_meta($post->ID, '_vaivera_project_gallery', true);
    
    ?>
    <div id="vaivera-project-gallery">
        <p><?php _e('Add images to the project gallery.', 'vaivera'); ?></p>
        
        <div class="gallery-container">
            <div class="gallery-preview">
                <?php if (!empty($gallery_images)) : ?>
                    <?php foreach ($gallery_images as $image_id) : ?>
                        <div class="gallery-image" data-id="<?php echo esc_attr($image_id); ?>">
                            <?php echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
                            <button type="button" class="remove-image dashicons dashicons-no-alt"></button>
                            <input type="hidden" name="vaivera_project_gallery[]" value="<?php echo esc_attr($image_id); ?>">
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <div class="clear"></div>
            
            <p>
                <button type="button" class="button add-images"><?php _e('Add Images', 'vaivera'); ?></button>
            </p>
        </div>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        // Initialize media frame
        var frame;
        
        // Add images
        $('.add-images').on('click', function(e) {
            e.preventDefault();
            
            // If frame exists, open it
            if (frame) {
                frame.open();
                return;
            }
            
            // Create media frame
            frame = wp.media({
                title: '<?php echo esc_js(__('Select or Upload Images', 'vaivera')); ?>',
                button: {
                    text: '<?php echo esc_js(__('Add to Gallery', 'vaivera')); ?>'
                },
                multiple: true
            });
            
            // When images are selected
            frame.on('select', function() {
                var attachments = frame.state().get('selection').toJSON();
                
                $.each(attachments, function(index, attachment) {
                    $('.gallery-preview').append(`
                        <div class="gallery-image" data-id="${attachment.id}">
                            <img src="${attachment.sizes.thumbnail.url}" alt="${attachment.alt}">
                            <button type="button" class="remove-image dashicons dashicons-no-alt"></button>
                            <input type="hidden" name="vaivera_project_gallery[]" value="${attachment.id}">
                        </div>
                    `);
                });
            });
            
            // Open media frame
            frame.open();
        });
        
        // Remove image
        $('.gallery-preview').on('click', '.remove-image', function() {
            $(this).closest('.gallery-image').remove();
        });
        
        // Make gallery sortable
        $('.gallery-preview').sortable({
            items: '.gallery-image',
            cursor: 'move',
            opacity: 0.6
        });
    });
    </script>
    
    <style>
    .gallery-preview {
        margin: 10px 0;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .gallery-image {
        position: relative;
        width: 150px;
        height: 150px;
        border: 1px solid #ddd;
        background: #f9f9f9;
        cursor: move;
    }
    .gallery-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .remove-image {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(0, 0, 0, 0.5);
        color: #fff;
        border-radius: 50%;
        cursor: pointer;
        padding: 0;
        width: 24px;
        height: 24px;
        font-size: 16px;
        line-height: 24px;
        text-align: center;
        border: none;
    }
    .remove-image:hover {
        background: rgba(0, 0, 0, 0.8);
    }
    .clear {
        clear: both;
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
    if (!isset($_POST['vaivera_project_specs_nonce']) || !isset($_POST['vaivera_project_gallery_nonce'])) {
        return;
    }
    
    // Verify nonces
    if (!wp_verify_nonce($_POST['vaivera_project_specs_nonce'], 'vaivera_project_specs_nonce') 
        || !wp_verify_nonce($_POST['vaivera_project_gallery_nonce'], 'vaivera_project_gallery_nonce')
    ) {
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
    
    // Save project specs
    if (isset($_POST['vaivera_project_specs'])) {
        $specs = array();
        
        foreach ($_POST['vaivera_project_specs'] as $spec) {
            if (!empty($spec['title']) || !empty($spec['description'])) {
                $specs[] = array(
                    'title' => sanitize_text_field($spec['title']),
                    'description' => wp_kses_post($spec['description'])
                );
            }
        }
        
        update_post_meta($post_id, '_vaivera_project_specs', $specs);
    }
    
    // Save project gallery - now handled by unified gallery metabox
    /*
    if (isset($_POST['vaivera_project_gallery'])) {
        $gallery_images = array_map('intval', $_POST['vaivera_project_gallery']);
        update_post_meta($post_id, '_vaivera_project_gallery', $gallery_images);
    } else {
        delete_post_meta($post_id, '_vaivera_project_gallery');
    }
    */
}
add_action('save_post_project', 'vaivera_save_project_meta');
