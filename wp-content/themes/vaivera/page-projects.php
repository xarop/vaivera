<?php
/**
 * Page Template: Projects Grid
 * Template Name: Projects Grid
 *
 * Displays page content followed by a grid of all projects
 *
 * @package Vaivera
 * @since   1.0.0
 */

get_header();
?>

<main class="site-main page-with-projects">
    <div class="container">
        <?php while ( have_posts() ) : ?>
            <?php the_post(); ?>
            <article id="page-<?php the_ID(); ?>" <?php post_class('page-content-section'); ?>>
              
                <section class="page-content-section">
                     <aside>
                        <header class="entry-header">
                            <h1 class="entry-title"><?php the_title(); ?></h1>
                        </header>
                    </aside>
                    
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>

                   
                </section>

                <!-- Projects Grid -->
                <?php get_template_part('partials/projects-archive'); ?>

            </article>
        <?php endwhile; ?>
    </div>
    
    
</main>

<?php get_footer(); ?>
