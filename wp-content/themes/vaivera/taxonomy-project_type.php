<?php
/**
 * Template for displaying project type archives
 *
 * @package Vaivera
 * @since   1.0.0
 */

get_header();

// Get current term
$current_term = get_queried_object();
?>

<main class="site-main projects-archive taxonomy-archive">
    <section class="projects-section">
        <div class="container">
            <header class="page-header">
                <h1 class="page-title">
                    <?php 
                    printf(
                        __('Tipus de projecte: %s', 'vaivera'),
                        '<span class="taxonomy-name">' . esc_html($current_term->name) . '</span>'
                    );
                    ?>
                </h1>
                <?php if (!empty($current_term->description)) : ?>
                    <div class="taxonomy-description">
                        <?php echo wpautop(esc_html($current_term->description)); ?>
                    </div>
                <?php endif; ?>
            </header>
            
            <?php if (have_posts()) : ?>
                <div class="projects-grid content-grid grid-2">
                    <?php while (have_posts()) : the_post(); ?>
                        <?php get_template_part('partials/project-card'); ?>
                    <?php endwhile; ?>
                </div>
                
                <?php
                // Pagination
                the_posts_pagination(
                    array(
                        'mid_size' => 2,
                        'prev_text' => __('&laquo; Anterior', 'vaivera'),
                        'next_text' => __('Següent &raquo;', 'vaivera'),
                    )
                );
                ?>
                
            <?php else : ?>
                <div class="no-projects">
                    <p><?php _e('No s\'han trobat projectes d\'aquest tipus.', 'vaivera'); ?></p>
                    <a href="<?php echo get_post_type_archive_link('project'); ?>" class="btn">
                        <?php _e('Veure tots els projectes', 'vaivera'); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>
