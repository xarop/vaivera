<?php
/**
 * Unified Gallery Metabox
 * 
 * Provides a consistent gallery metabox for all post types and pages
 *
 * @package Vaivera
 * @since   1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add gallery meta box to all pages and projects
 */
function vaivera_add_gallery_meta_boxes()
{
    // Add to pages
    add_meta_box(
        'vaivera_gallery_metabox',
        __('Carousel Gallery', 'vaivera'),
        'vaivera_gallery_meta_box_callback',
        'page',
        'normal',
        'high'
    );
    
    // Add to projects
    add_meta_box(
        'vaivera_gallery_metabox',
        __('Carousel Gallery', 'vaivera'),
        'vaivera_gallery_meta_box_callback',
        'project',
        'normal',
        'high'
    );
    
    // Add to posts
    add_meta_box(
        'vaivera_gallery_metabox',
        __('Carousel Gallery', 'vaivera'),
        'vaivera_gallery_meta_box_callback',
        'post',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'vaivera_add_gallery_meta_boxes');

/**
 * Gallery meta box callback
 */
function vaivera_gallery_meta_box_callback($post)
{
    // Add nonce field for security
    wp_nonce_field('vaivera_gallery_nonce', 'vaivera_gallery_nonce');
    
    // Get existing gallery value
    $gallery_value = get_post_meta($post->ID, 'carousel_gallery', true);
    
    ?>
    <div class="vaivera-gallery-metabox">
        <p class="description">
            <?php _e('Select images for the carousel gallery. For the homepage, these images will be displayed in the main carousel. For projects and other pages, these images can be viewed in a modal gallery.', 'vaivera'); ?>
        </p>
        
        <div class="gallery-field-wrapper">
            <input type="hidden" id="carousel_gallery" name="carousel_gallery" value="<?php echo esc_attr($gallery_value); ?>" />
            
            <div class="gallery-preview" id="gallery-preview">
                <?php if (!empty($gallery_value)) : ?>
                    <?php
                    $image_ids = explode(',', $gallery_value);
                    foreach ($image_ids as $image_id) {
                        $image_id = intval(trim($image_id));
                        if ($image_id) {
                            $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
                            if ($image_url) {
                                echo '<div class="gallery-image" data-id="' . esc_attr($image_id) . '">';
                                echo '<img src="' . esc_url($image_url) . '" alt="" />';
                                echo '<span class="remove-image" data-id="' . esc_attr($image_id) . '">&times;</span>';
                                echo '</div>';
                            }
                        }
                    }
                    ?>
                <?php endif; ?>
            </div>
            
            <div class="gallery-controls">
                <button type="button" class="button" id="select-gallery-images">
                    <?php _e('Select Gallery Images', 'vaivera'); ?>
                </button>
                <button type="button" class="button" id="clear-gallery">
                    <?php _e('Clear Gallery', 'vaivera'); ?>
                </button>
            </div>
        </div>
    </div>
    
    <style>
        .vaivera-gallery-metabox {
            padding: 10px 0;
        }
        
        .gallery-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 15px 0;
            min-height: 60px;
            border: 2px dashed #ddd;
            padding: 15px;
            border-radius: 4px;
        }
        
        .gallery-preview:empty:before {
            content: "<?php esc_attr_e('No images selected. Click "Select Gallery Images" to add images.', 'vaivera'); ?>";
            color: #666;
            font-style: italic;
            width: 100%;
            text-align: center;
            padding: 20px 0;
        }
        
        .gallery-image {
            position: relative;
            width: 80px;
            height: 80px;
            border: 2px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
            cursor: move;
        }
        
        .gallery-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .gallery-image .remove-image {
            position: absolute;
            top: -8px;
            right: -8px;
            width: 20px;
            height: 20px;
            background: #dc3232;
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 20px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }
        
        .gallery-image .remove-image:hover {
            background: #a00;
        }
        
        .gallery-controls {
            margin-top: 10px;
        }
        
        .gallery-controls .button {
            margin-right: 10px;
        }
    </style>
    
    <script>
    jQuery(document).ready(function($) {
        var galleryFrame;
        var galleryPreview = $('#gallery-preview');
        var galleryInput = $('#carousel_gallery');
        
        // Make gallery sortable
        galleryPreview.sortable({
            items: '.gallery-image',
            cursor: 'move',
            scrollSensitivity: 40,
            forcePlaceholderSize: true,
            forceHelperSize: false,
            helper: 'clone',
            opacity: 0.65,
            placeholder: 'gallery-image-placeholder',
            start: function(event, ui) {
                ui.placeholder.height(ui.helper.outerHeight());
            },
            update: function(event, ui) {
                updateGalleryInput();
            }
        });
        
        // Select gallery images
        $('#select-gallery-images').on('click', function(e) {
            e.preventDefault();
            
            if (galleryFrame) {
                galleryFrame.open();
                return;
            }
            
            galleryFrame = wp.media({
                title: '<?php esc_attr_e('Select Gallery Images', 'vaivera'); ?>',
                button: {
                    text: '<?php esc_attr_e('Add to Gallery', 'vaivera'); ?>'
                },
                multiple: true,
                library: {
                    type: 'image'
                }
            });
            
            galleryFrame.on('select', function() {
                var selection = galleryFrame.state().get('selection');
                var currentIds = galleryInput.val() ? galleryInput.val().split(',') : [];
                
                selection.map(function(attachment) {
                    attachment = attachment.toJSON();
                    
                    // Check if image is already in gallery
                    if (currentIds.indexOf(attachment.id.toString()) === -1) {
                        addImageToGallery(attachment.id, attachment.sizes.thumbnail.url);
                        currentIds.push(attachment.id);
                    }
                });
                
                updateGalleryInput();
            });
            
            galleryFrame.open();
        });
        
        // Clear gallery
        $('#clear-gallery').on('click', function(e) {
            e.preventDefault();
            galleryPreview.empty();
            galleryInput.val('');
        });
        
        // Remove individual images
        $(document).on('click', '.remove-image', function(e) {
            e.preventDefault();
            $(this).parent('.gallery-image').remove();
            updateGalleryInput();
        });
        
        // Add image to gallery preview
        function addImageToGallery(imageId, imageUrl) {
            var imageHtml = '<div class="gallery-image" data-id="' + imageId + '">' +
                           '<img src="' + imageUrl + '" alt="" />' +
                           '<span class="remove-image" data-id="' + imageId + '">&times;</span>' +
                           '</div>';
            galleryPreview.append(imageHtml);
        }
        
        // Update hidden input with current gallery order
        function updateGalleryInput() {
            var imageIds = [];
            galleryPreview.find('.gallery-image').each(function() {
                imageIds.push($(this).data('id'));
            });
            galleryInput.val(imageIds.join(','));
        }
    });
    </script>
    <?php
}

/**
 * Save gallery meta box data
 */
function vaivera_save_gallery_meta_box($post_id)
{
    // Verify nonce
    if (!isset($_POST['vaivera_gallery_nonce']) || !wp_verify_nonce($_POST['vaivera_gallery_nonce'], 'vaivera_gallery_nonce')) {
        return;
    }
    
    // Check if user has permission to edit the post
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Don't save during autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Save gallery data
    if (isset($_POST['carousel_gallery'])) {
        $gallery_value = sanitize_text_field($_POST['carousel_gallery']);
        update_post_meta($post_id, 'carousel_gallery', $gallery_value);
    } else {
        delete_post_meta($post_id, 'carousel_gallery');
    }
}
add_action('save_post', 'vaivera_save_gallery_meta_box');
