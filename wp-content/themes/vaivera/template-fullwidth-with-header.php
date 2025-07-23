<?php
/**
 * Template Name: Full Width with Header (No Title)
 * Template Post Type: page
 *
 * A full-width template with header and footer but no title and no sidebars
 *
 * @package Vaivera
 * @since   1.0.0
 */

get_header();
?>

<main class="site-main fullwidth-main">
    <?php while ( have_posts() ) : ?>
        <?php the_post(); ?>
        <article id="page-<?php the_ID(); ?>" <?php post_class('fullwidth-article'); ?>>
            <div class="entry-content fullwidth-content">
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile; ?>
</main>

<style>
    /* Full width template specific styles */
    .fullwidth-main {
        width: 100%;
        max-width: 100%;
        padding: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    
    .fullwidth-article {
        width: 100%;
        max-width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    
    .fullwidth-content {
        width: 100%;
        max-width: 100%;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    
    /* Center content blocks */
    .fullwidth-content > * {
        margin-left: auto;
        margin-right: auto;
        max-width: 1200px; /* You can adjust this value */
        width: 100%;
    }
    
    /* Make sure WordPress blocks go full width when needed */
    .fullwidth-content .alignfull {
        margin-left: 0;
        margin-right: 0;
        width: 100%;
        max-width: 100%;
    }
    
    /* Standard content width for regular blocks */
    .fullwidth-content > p,
    .fullwidth-content > h1,
    .fullwidth-content > h2,
    .fullwidth-content > h3,
    .fullwidth-content > h4,
    .fullwidth-content > h5,
    .fullwidth-content > h6,
    .fullwidth-content > ul,
    .fullwidth-content > ol,
    .fullwidth-content > blockquote,
    .fullwidth-content > .wp-block-paragraph {
        max-width: 800px; /* You can adjust this value */
        padding-left: 20px;
        padding-right: 20px;
    }
</style>

<?php get_footer(); ?>