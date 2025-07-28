<?php
/**
 * Teams Archive Partial
 *
 * @package Vaivera
 * @since   1.0.0
 */

// Query teams
$teams_query = new WP_Query(
    array(
        'post_type' => 'team',
        'posts_per_page' => -1, // Show all teams
        'post_status' => 'publish',
        'orderby' => 'menu_order',
        'order' => 'ASC'
    )
);

if ($teams_query->have_posts()) : ?>
    <section class="teams-section">
        <div class="container">
            <?php if (!is_front_page()) : ?>
                <header class="page-header">
                    <h1 class="page-title"><?php _e('Equip', 'vaivera'); ?></h1>
                    <div class="page-description">
                        <p><?php _e('Coneix el nostre equip de professionals', 'vaivera'); ?></p>
                    </div>
                </header>
            <?php endif; ?>
            
            <div class="teams-grid content-grid grid-team">
                <?php while ($teams_query->have_posts()) : $teams_query->the_post(); ?>
                    <?php get_template_part('partials/team-card'); ?>
                <?php endwhile; ?>
            </div>
            
            <?php
            // Pagination if needed
            if ($teams_query->max_num_pages > 1) :
                the_posts_pagination(
                    array(
                        'mid_size' => 2,
                        'prev_text' => __('&laquo; Anterior', 'vaivera'),
                        'next_text' => __('Següent &raquo;', 'vaivera'),
                    )
                );
            endif;
            ?>
        </div>
    </section>

<?php else : ?>
    <section class="teams-section">
        <div class="container">
            <div class="no-teams">
                <p><?php _e('No s\'han trobat membres de l\'equip.', 'vaivera'); ?></p>
            </div>
        </div>
    </section>
<?php endif; 

// Reset post data
wp_reset_postdata();
?>
