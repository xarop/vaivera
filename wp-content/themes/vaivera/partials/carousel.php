<?php
/**
 * Unified Carousel Partial
 * 
 * Reusable carousel component for homepage and gallery modals
 *
 * @package Vaivera
 * @since   1.0.0
 */

// Get carousel configuration from passed arguments
$carousel_config = get_query_var('carousel_config', array());

// Default configuration
$defaults = array(
    'images' => array(),
    'container_class' => 'carousel-container',
    'slides_class' => 'carousel-slides',
    'slide_class' => 'carousel-slide',
    'nav_class' => 'carousel-nav',
    'indicators_class' => 'carousel-indicators',
    'show_indicators' => true,
    'show_navigation' => true,
    'show_captions' => false,
    'image_size' => 'full'
);

$config = wp_parse_args($carousel_config, $defaults);

if (!empty($config['images'])) : ?>
    <div class="<?php echo esc_attr($config['container_class']); ?>">
        <div class="<?php echo esc_attr($config['slides_class']); ?>">
            <?php foreach ($config['images'] as $index => $image) :
                $active_class = $index === 0 ? ' active' : '';
                ?>
                <div class="<?php echo esc_attr($config['slide_class'] . $active_class); ?>">
                    <?php if (isset($image['id'])) : ?>
                        <?php echo wp_get_attachment_image($image['id'], $config['image_size']); ?>
                        <?php if ($config['show_captions'] && wp_get_attachment_caption($image['id'])) : ?>
                            <div class="image-caption">
                                <?php echo wp_get_attachment_caption($image['id']); ?>
                            </div>
                        <?php endif; ?>
                    <?php else : ?>
                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        
        <?php if ($config['show_navigation']) : ?>
            <!-- Carousel Navigation -->
            <div class="<?php echo esc_attr($config['nav_class']); ?>">
                <button class="carousel-prev slider-nav prev" aria-label="<?php esc_attr_e('Previous slide', 'vaivera'); ?>">‹</button>
                <button class="carousel-next slider-nav next" aria-label="<?php esc_attr_e('Next slide', 'vaivera'); ?>">›</button>
            </div>
        <?php endif; ?>
        
        <?php if ($config['show_indicators'] && count($config['images']) > 1) : ?>
            <!-- Carousel Indicators -->
            <div class="<?php echo esc_attr($config['indicators_class']); ?>">
                <?php foreach ($config['images'] as $index => $image) : ?>
                    <button class="carousel-indicator<?php echo $index === 0 ? ' active' : ''; ?>" 
                            data-slide="<?php echo $index; ?>"
                            aria-label="<?php echo sprintf(esc_attr__('Go to slide %d', 'vaivera'), $index + 1); ?>">
                    </button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>
