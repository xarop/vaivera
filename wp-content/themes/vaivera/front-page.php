<?php
/**
 * Front Page Template
 *
 * @package Vaivera
 * @since   1.0.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#c9612c">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <script>
        // Prevent flash of unstyled content
        (function() {
            const savedTheme = localStorage.getItem('xarop-theme');
            if (savedTheme) {
                document.documentElement.setAttribute('data-theme', savedTheme);
            } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        })();
    </script>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Homepage Container -->
<div class="homepage-container">
    <!-- Homepage Image Carousel -->
    <div class="homepage-carousel">
        <div class="carousel-container">
            <div class="carousel-slides">
            <?php
            // Get the homepage ID
            $homepage_id = get_option('page_on_front');
            if (!$homepage_id) {
                $homepage_id = get_the_ID();
            }
            
            // Get carousel images from gallery meta field
            $carousel_gallery = get_post_meta($homepage_id, 'homepage_carousel_gallery', true);
            $carousel_images = array();
            
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
            
            // If no images are set, show a placeholder message
            if (empty($carousel_images)) {
                $carousel_images = array(
                    array(
                        'url' => 'https://via.placeholder.com/1920x1080/c9612c/ffffff?text=Add+Carousel+Images+in+Homepage+Settings',
                        'alt' => 'Placeholder - Add images in homepage gallery field'
                    )
                );
            }
            
            foreach ($carousel_images as $index => $image) :
                $active_class = $index === 0 ? ' active' : '';
                ?>
                <div class="carousel-slide<?php echo $active_class; ?>">
                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Carousel Navigation -->
        <div class="carousel-nav">
            <button class="carousel-prev slider-nav prev" aria-label="<?php esc_attr_e('Previous slide', 'vaivera'); ?>">‹</button>
            <button class="carousel-next slider-nav next" aria-label="<?php esc_attr_e('Next slide', 'vaivera'); ?>">›</button>
        </div>
        
        <!-- Carousel Indicators -->
        <div class="carousel-indicators">
            <?php foreach ($carousel_images as $index => $image) : ?>
                <button class="carousel-indicator<?php echo $index === 0 ? ' active' : ''; ?>" 
                        data-slide="<?php echo $index; ?>"
                        aria-label="<?php echo sprintf(esc_attr__('Go to slide %d', 'vaivera'), $index + 1); ?>">
                </button>
            <?php endforeach; ?>
        </div>
        </div>
    </div>

    <!-- Header after carousel -->
    <header class="site-header homepage-header">
        <div class="container">
            <div class="header-content">
                <div class="site-branding">
                    <h1 class="site-title">
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                            <?php bloginfo('name'); ?>
                        </a>
                    </h1>
                </div>

                <?php if (get_bloginfo('description') ) : ?>
                    <div class="site-description-container">
                        <p class="site-description"><?php bloginfo('description'); ?></p>
                    </div>
                <?php endif; ?>

                <nav class="main-navigation">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'primary',
                            'menu_id'        => 'primary-menu',
                            'fallback_cb'    => false,
                        )
                    );
                    ?>
                </nav>
            </div>
        </div>
    </header>
</div>

<!-- Homepage Content -->
<main class="site-main homepage-main">
    <div class="container">
        <?php
        // Get the homepage content
        $homepage_id = get_option('page_on_front');
        if ($homepage_id) {
            $homepage = get_post($homepage_id);
            if ($homepage && !empty($homepage->post_content)) {
                echo '<article class="homepage-content">';
                echo '<div class="entry-content">';
                echo apply_filters('the_content', $homepage->post_content);
                echo '</div>';
                echo '</article>';
            }
        }
        ?>
    </div>

    <!-- Projects Archive Section -->
    <?php get_template_part('partials/projects-archive'); ?>
</main>

<?php get_footer(); ?>
