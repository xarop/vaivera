<?php
/**
 * Teams Archive Partial
 *
 * @package Vaivera
 * @since   1.0.0
 */

// Query teams
$teams_query = new WP_Query(array(
    'post_type' => 'team',
    'posts_per_page' => -1, // Show all teams
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC'
));

if ($teams_query->have_posts()) : ?>
    <section class="teams-section">
        <div class="container">
            <?php if (!is_front_page()) : ?>
                <header class="page-header">
                    <h2 class="page-title"><?php _e('Teams', 'vaivera'); ?></h2>
                </header>
            <?php endif; ?>
            
            <div class="teams-grid content-grid grid-2">
                <?php while ($teams_query->have_posts()) : $teams_query->the_post(); ?>
                    <?php get_template_part('partials/team-card'); ?>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

<?php endif; 

// Reset post data
wp_reset_postdata();
?>