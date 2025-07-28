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
            // If no static front page is set, get the current page ID
            global $wp_query;
            if ($wp_query->is_posts_page) {
                $homepage_id = get_option('page_for_posts');
            } else {
                $homepage_id = get_the_ID();
            }
        }
        
        // Pass the homepage ID to ensure it gets images from the homepage
        get_template_part('partials/carousel', null, array('page_id' => $homepage_id)); 
        ?>
    </div>

    <!-- Header after carousel -->
    <div class="homepage-header-wrapper">
        <?php get_template_part('partials/site-header'); ?>     
    </div>
</div>

<!-- Homepage Content -->
<main class="site-main homepage-main ">
    <section class="container">
        <aside></aside>
        <?php
        // Get the homepage content
        $page_id = get_option('page_on_front');
        if ($page_id) {
            $homepage = get_post($page_id);
            if ($homepage && !empty($homepage->post_content)) {
                echo '<article class="homepage-content">';
                echo '<div class="entry-content">';
                echo apply_filters('the_content', $homepage->post_content);
                echo '</div>';
                echo '</article>';
            }
        }
        ?>
    </section>

    <!-- Projects Archive Section -->
     <div class="container">
    <?php get_template_part('partials/projects-archive'); ?>
    </div>

</main>

<?php get_footer(); ?>
