<?php
/**
 * Page template
 *
 * @package Minimalist
 * @since   1.0.0
 */

get_header();
?>

<main class="site-main">
    <div class="container">
        <?php while ( have_posts() ) : ?>
            <?php the_post(); ?>
            <article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>