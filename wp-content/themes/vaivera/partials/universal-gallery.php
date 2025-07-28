<?php
/**
 * Universal Gallery Display Partial
 * 
 * Can be used on any page, post, or project to display the carousel gallery
 *
 * @package Vaivera
 * @since   1.0.0
 */

// Get the current post/page ID
$post_id = get_the_ID();

// Get gallery images from the unified carousel_gallery meta field
$gallery_images = get_post_meta($post_id, 'carousel_gallery', true);

if (!empty($gallery_images)) :
    // Parse comma-separated image IDs
    $image_ids = explode(',', $gallery_images);
    $image_ids = array_map('intval', array_map('trim', $image_ids));
    $image_ids = array_filter($image_ids); // Remove empty values
    
    if (!empty($image_ids)) : ?>
        <div class="universal-gallery">
            <h2><?php _e("Galeria d'imatges", 'vaivera'); ?></h2>
            
            <div class="gallery-grid">
                <?php foreach ($image_ids as $index => $image_id) : ?>
                    <div class="gallery-item">
                        <a href="javascript:void(0);" 
                           class="gallery-link" 
                           data-index="<?php echo esc_attr($index); ?>">
                            <?php echo wp_get_attachment_image($image_id, 'medium_large'); ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Gallery Slider Modal -->
        <div class="gallery-modal" id="galleryModal">
            <div class="modal-content">
                <span class="close-modal">&times;</span>
                <?php 
                // Set context for modal carousel
                set_query_var('gallery_modal_context', true);
                get_template_part('partials/carousel'); 
                // Reset context
                set_query_var('gallery_modal_context', false);
                ?>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
