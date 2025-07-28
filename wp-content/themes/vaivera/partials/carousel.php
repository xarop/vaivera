<div class="carousel-container">
        <div class="carousel-slides">
            <?php
            // Get the page ID
            $page_id = get_the_ID();
            
            // Check if we're in gallery modal context
            $is_modal = get_query_var('gallery_modal_context', false);
            
            // Get carousel images from gallery meta field
            $carousel_gallery = get_post_meta($page_id, 'carousel_gallery', true);
            $carousel_images = array();
            
            if (!empty($carousel_gallery)) {
                $image_ids = explode(',', $carousel_gallery);
                foreach ($image_ids as $image_id) {
                    $image_id = intval(trim($image_id));
                    if ($image_id) {
                        $image_url = wp_get_attachment_image_url($image_id, 'full');
                        $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                        $image_caption = wp_get_attachment_caption($image_id);
                        if ($image_url) {
                            $carousel_images[] = array(
                                'url' => $image_url,
                                'alt' => $image_alt ?: sprintf(__('Carousel Image %d', 'vaivera'), count($carousel_images) + 1),
                                'caption' => $image_caption
                            );
                        }
                    }
                }
            }
            
            // If no images are set, show a placeholder message (only for homepage)
            if (empty($carousel_images) && !$is_modal) {
                $carousel_images = array(
                    array(
                        'url' => 'https://via.placeholder.com/1920x1080/c9612c/ffffff?text=Add+Carousel+Images+in+Homepage+Settings',
                        'alt' => 'Placeholder - Add images in gallery field',
                        'caption' => ''
                    )
                );
            }
            
            foreach ($carousel_images as $index => $image) :
                $active_class = $index === 0 ? ' active' : '';
                ?>
                <div class="carousel-slide<?php echo $active_class; ?>">
                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                    <?php if ($is_modal && !empty($image['caption'])) : ?>
                        <div class="image-caption">
                            <?php echo esc_html($image['caption']); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Carousel Navigation -->
        <div class="carousel-nav">
            <button class="carousel-prev slider-nav prev" aria-label="<?php esc_attr_e('Previous slide', 'vaivera'); ?>">‹</button>
            <button class="carousel-next slider-nav next" aria-label="<?php esc_attr_e('Next slide', 'vaivera'); ?>">›</button>
        </div>
        
      
        <div class="carousel-indicators">
            <?php foreach ($carousel_images as $index => $image) : ?>
                <button class="carousel-indicator<?php echo $index === 0 ? ' active' : ''; ?>" 
                        data-slide="<?php echo $index; ?>"
                        aria-label="<?php echo sprintf(esc_attr__('Go to slide %d', 'vaivera'), $index + 1); ?>">
                </button>
            <?php endforeach; ?>
        </div>
       
</div>
