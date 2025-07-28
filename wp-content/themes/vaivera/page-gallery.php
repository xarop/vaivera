<?php
/**
 * Template for displaying pages with gallery
 * Template Name: Page with Gallery
 *
 * @package Vaivera
 * @since   1.0.0
 */

get_header();
?>

<main class="site-main">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            <article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="page-header">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                </header>

                <div class="page-content">
                    <?php the_content(); ?>
                </div>
                
                <!-- Universal Gallery - automatically shows if images are added in admin -->
                <?php get_template_part('partials/universal-gallery'); ?>
                
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
