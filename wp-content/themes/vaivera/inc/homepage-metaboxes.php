<?php
/**
 * Homepage Meta Boxes
 *
 * @package Vaivera
 * @since   1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add meta boxes for homepage
 */
function vaivera_add_homepage_meta_boxes()
{
    // Get the homepage ID
    $homepage_id = get_option('page_on_front');
    
    if ($homepage_id) {
        add_meta_box(
            'homepage_carousel_settings',
            __('Homepage Carousel Settings', 'vaivera'),
            'vaivera_homepage_carousel_meta_box_callback',
            'page',
            'normal',
            'high'
        );
    }
}
add_action('add_meta_boxes', 'vaivera_add_homepage_meta_boxes');

/**
 * Homepage carousel meta box callback
 */
function vaivera_homepage_carousel_meta_box_callback($post)
{
    // Get the homepage ID
    $homepage_id = get_option('page_on_front');
    
    // Only show on homepage
    if ($post->ID != $homepage_id) {
        return;
    }
    
    // Add nonce field
    wp_nonce_field('vaivera_homepage_carousel_nonce', 'vaivera_homepage_carousel_nonce');
    
    // Get current gallery value
    $gallery_ids = get_post_meta($post->ID, 'homepage_carousel_gallery', true);
    
    ?>
    <div class="homepage-carousel-meta-box">
        <p><?php _e('Select images for the homepage carousel. You can add unlimited images and reorder them by dragging.', 'vaivera'); ?></p>
        
        <div class="carousel-gallery-container">
            <input type="hidden" id="homepage_carousel_gallery" name="homepage_carousel_gallery" value="<?php echo esc_attr($gallery_ids); ?>" />
            
            <div class="carousel-gallery-preview" id="carousel-gallery-preview">
                <?php if (!empty($gallery_ids)) : ?>
                    <?php
                    $image_ids = explode(',', $gallery_ids);
                    foreach ($image_ids as $image_id) :
                        $image_id = intval(trim($image_id));
                        if ($image_id) :
                            $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
                            $image_title = get_the_title($image_id);
                            if ($image_url) :
                                ?>
                        <div class="carousel-image-item" data-id="<?php echo $image_id; ?>">
                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_title); ?>" />
                            <div class="image-controls">
                                <span class="image-title"><?php echo esc_html($image_title); ?></span>
                                <button type="button" class="remove-image" data-id="<?php echo $image_id; ?>">&times;</button>
                            </div>
                        </div>
                                <?php 
                            endif;
                        endif;
                    endforeach; 
                    ?>
                <?php endif; ?>
            </div>
            
            <div class="carousel-gallery-actions">
                <button type="button" class="button button-primary" id="add-carousel-images">
                    <?php _e('Add Images', 'vaivera'); ?>
                </button>
                <button type="button" class="button" id="clear-carousel-gallery">
                    <?php _e('Clear All', 'vaivera'); ?>
                </button>
            </div>
        </div>
    </div>
    
    <style>
    .homepage-carousel-meta-box {
        padding: 10px 0;
    }
    
    .carousel-gallery-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin: 15px 0;
        min-height: 100px;
        border: 2px dashed #ddd;
        padding: 15px;
        border-radius: 5px;
    }
    
    .carousel-gallery-preview.has-images {
        border-style: solid;
        border-color: #ccc;
    }
    
    .carousel-image-item {
        position: relative;
        width: 120px;
        height: 120px;
        border: 1px solid #ddd;
        border-radius: 5px;
        overflow: hidden;
        cursor: move;
        background: #f9f9f9;
    }
    
    .carousel-image-item img {
        width: 100%;
        height: 80px;
        object-fit: cover;
    }
    
    .carousel-image-item .image-controls {
        padding: 5px;
        font-size: 11px;
        position: relative;
    }
    
    .carousel-image-item .image-title {
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 2px;
    }
    
    .carousel-image-item .remove-image {
        position: absolute;
        top: 5px;
        right: 5px;
        background: #dc3232;
        color: white;
        border: none;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        cursor: pointer;
        font-size: 14px;
        line-height: 1;
    }
    
    .carousel-image-item .remove-image:hover {
        background: #a00;
    }
    
    .carousel-gallery-actions {
        margin-top: 10px;
    }
    
    .carousel-gallery-actions .button {
        margin-right: 10px;
    }
    
    .carousel-gallery-preview:empty::before {
        content: "<?php _e('No images selected. Click "Add Images" to get started.', 'vaivera'); ?>";
        color: #666;
        font-style: italic;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 70px;
    }
    </style>
    
    <script>
    jQuery(document).ready(function($) {
        var mediaUploader;
        
        // Add images button
        $('#add-carousel-images').on('click', function(e) {
            e.preventDefault();
            
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }
            
            mediaUploader = wp.media({
                title: '<?php _e('Select Carousel Images', 'vaivera'); ?>',
                button: {
                    text: '<?php _e('Add to Carousel', 'vaivera'); ?>'
                },
                multiple: true,
                library: {
                    type: 'image'
                }
            });
            
            mediaUploader.on('select', function() {
                var attachments = mediaUploader.state().get('selection').toJSON();
                var currentIds = $('#homepage_carousel_gallery').val();
                var idsArray = currentIds ? currentIds.split(',') : [];
                
                attachments.forEach(function(attachment) {
                    if (idsArray.indexOf(attachment.id.toString()) === -1) {
                        idsArray.push(attachment.id);
                        addImageToPreview(attachment);
                    }
                });
                
                $('#homepage_carousel_gallery').val(idsArray.join(','));
                updatePreviewState();
            });
            
            mediaUploader.open();
        });
        
        // Clear all images
        $('#clear-carousel-gallery').on('click', function(e) {
            e.preventDefault();
            if (confirm('<?php _e('Are you sure you want to remove all images?', 'vaivera'); ?>')) {
                $('#carousel-gallery-preview').empty();
                $('#homepage_carousel_gallery').val('');
                updatePreviewState();
            }
        });
        
        // Remove individual image
        $(document).on('click', '.remove-image', function(e) {
            e.preventDefault();
            var imageId = $(this).data('id');
            var $item = $(this).closest('.carousel-image-item');
            
            $item.remove();
            
            var currentIds = $('#homepage_carousel_gallery').val();
            var idsArray = currentIds ? currentIds.split(',') : [];
            var index = idsArray.indexOf(imageId.toString());
            
            if (index > -1) {
                idsArray.splice(index, 1);
            }
            
            $('#homepage_carousel_gallery').val(idsArray.join(','));
            updatePreviewState();
        });
        
        // Make images sortable
        $('#carousel-gallery-preview').sortable({
            items: '.carousel-image-item',
            cursor: 'move',
            update: function() {
                var idsArray = [];
                $('.carousel-image-item').each(function() {
                    idsArray.push($(this).data('id'));
                });
                $('#homepage_carousel_gallery').val(idsArray.join(','));
            }
        });
        
        function addImageToPreview(attachment) {
            var html = '<div class="carousel-image-item" data-id="' + attachment.id + '">' +
                '<img src="' + attachment.sizes.thumbnail.url + '" alt="' + attachment.alt + '" />' +
                '<div class="image-controls">' +
                '<span class="image-title">' + attachment.title + '</span>' +
                '<button type="button" class="remove-image" data-id="' + attachment.id + '">&times;</button>' +
                '</div>' +
                '</div>';
            
            $('#carousel-gallery-preview').append(html);
        }
        
        function updatePreviewState() {
            var $preview = $('#carousel-gallery-preview');
            if ($preview.children().length > 0) {
                $preview.addClass('has-images');
            } else {
                $preview.removeClass('has-images');
            }
        }
        
        // Initial state
        updatePreviewState();
    });
    </script>
    <?php
}

/**
 * Save homepage carousel meta box data
 */
function vaivera_save_homepage_carousel_meta_box($post_id)
{
    // Check if nonce is valid
    if (!isset($_POST['vaivera_homepage_carousel_nonce'])  
        || !wp_verify_nonce($_POST['vaivera_homepage_carousel_nonce'], 'vaivera_homepage_carousel_nonce')
    ) {
        return;
    }
    
    // Check if user has permission to edit
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Check if this is the homepage
    $homepage_id = get_option('page_on_front');
    if ($post_id != $homepage_id) {
        return;
    }
    
    // Save gallery data
    if (isset($_POST['homepage_carousel_gallery'])) {
        $gallery_ids = sanitize_text_field($_POST['homepage_carousel_gallery']);
        update_post_meta($post_id, 'homepage_carousel_gallery', $gallery_ids);
    } else {
        delete_post_meta($post_id, 'homepage_carousel_gallery');
    }
}
add_action('save_post', 'vaivera_save_homepage_carousel_meta_box');

/**
 * Enqueue admin scripts for homepage meta boxes
 */
function vaivera_enqueue_homepage_admin_scripts($hook)
{
    global $post;
    
    if ($hook == 'post.php' || $hook == 'post-new.php') {
        $homepage_id = get_option('page_on_front');
        if ($post && $post->ID == $homepage_id) {
            wp_enqueue_media();
            wp_enqueue_script('jquery-ui-sortable');
        }
    }
}
add_action('admin_enqueue_scripts', 'vaivera_enqueue_homepage_admin_scripts');
