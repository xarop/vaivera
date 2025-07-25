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
        
        // Set carousel configuration
        set_query_var('carousel_config', array(
            'images' => $carousel_images,
            'show_indicators' => true,
            'show_navigation' => true,
            'show_captions' => false,
            'image_size' => 'full'
        ));
        
        // Include carousel partial
        get_template_part('partials/carousel');
        ?>
        </div>
    </div>

    <!-- Header after carousel -->
    <div class="homepage-header-wrapper">
        <?php get_template_part('partials/site-header'); ?>
    </div>
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
