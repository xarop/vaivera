<?php
/**
 * Carousel Partial
 *
 * @package Vaivera
 * @since   1.0.0
 */

// Get carousel images - can be passed as parameter or use default logic
$carousel_images = isset($args['images']) ? $args['images'] : array();
$show_indicators = isset($args['indicators']) ? $args['indicators'] : true;
$show_navigation = isset($args['navigation']) ? $args['navigation'] : true;

// If no images provided, try to get from homepage meta
if (empty($carousel_images)) {
    $homepage_id = get_option('page_on_front');
    if (!$homepage_id) {
        $homepage_id = get_the_ID();
    }
    
    $carousel_gallery = get_post_meta($homepage_id, 'homepage_carousel_gallery', true);
    
    if (!empty($carousel_gallery)) {
        $image_ids = explode(',', $carousel_gallery);
        foreach ($image_ids as $image_id) {
            $image_id = intval(trim($image_id));
            if ($image_id) {
                $image_url = wp_get_attachment_image_url($image_id, 'full');
                $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                if ($image_url) {
                    $carousel_images[] = array(
                        'url' => $image_url,
                        'alt' => $image_alt ?: sprintf(__('Carousel Image %d', 'vaivera'), count($carousel_images) + 1)
                    );
                }
            }
        }
    }
}

// If still no images, don't show anything (removed placeholder)
if (empty($carousel_images)) {
    return;
}
?>

<div class="carousel-container">
    <div class="carousel-slides">
        <?php foreach ($carousel_images as $index => $image) : ?>
            <?php $active_class = $index === 0 ? ' active' : ''; ?>
            <div class="carousel-slide<?php echo $active_class; ?>">
                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
            </div>
        <?php endforeach; ?>
    </div>
    
    <?php if ($show_navigation && count($carousel_images) > 1) : ?>
        <!-- Carousel Navigation -->
        <div class="carousel-nav">
            <button class="carousel-prev slider-nav prev" aria-label="<?php esc_attr_e('Previous slide', 'vaivera'); ?>">&#8249;</button>
            <button class="carousel-next slider-nav next" aria-label="<?php esc_attr_e('Next slide', 'vaivera'); ?>">&#8250;</button>
        </div>
    <?php endif; ?>
    
    <?php if ($show_indicators && count($carousel_images) > 1) : ?>
        <!-- Carousel Indicators -->
        <div class="carousel-indicators">
            <?php foreach ($carousel_images as $index => $image) : ?>
                <button class="carousel-indicator<?php echo $index === 0 ? ' active' : ''; ?>" 
                        data-slide="<?php echo $index; ?>"
                        aria-label="<?php echo sprintf(esc_attr__('Go to slide %d', 'vaivera'), $index + 1); ?>">
                </button>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
