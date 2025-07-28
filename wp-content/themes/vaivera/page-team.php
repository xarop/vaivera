<?php
/**
 * Page Template: Team Grid
 * Template Name: Team Grid
 *
 * Displays page content followed by a grid of all team members
 *
 * @package Vaivera
 * @since   1.0.0
 */

get_header();
?>

<main class="site-main page-with-team">
    <div class="container">
        <?php while ( have_posts() ) : ?>
            <?php the_post(); ?>
            <article id="page-<?php the_ID(); ?>" <?php post_class('page-content-section'); ?>>
              
                <section class="page-content-section">
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>

                    <aside>
                        <header class="entry-header">
                            <!-- <h1 class="entry-title"><?php the_title(); ?></h1> -->
                        </header>
                    </aside>

                </section>

            </article>
        <?php endwhile; ?>
    </div>
    
    <!-- Team Grid Section -->
    <?php
    // Query team members
    $teams_query = new WP_Query(
        array(
            'post_type' => 'team',
            'posts_per_page' => -1, // Show all team members
            'post_status' => 'publish',
            'orderby' => 'menu_order',
            'order' => 'ASC'
        )
    );

    if ($teams_query->have_posts()) : ?>
       
            <section class="container">
            
            
                <div class="teams-grid content-grid grid-team">
                    <?php while ($teams_query->have_posts()) : $teams_query->the_post(); ?>
                        <?php get_template_part('partials/team-card'); ?>
                    <?php endwhile; ?>
                </div>
                
                <?php
                // Pagination if needed
                if ($teams_query->max_num_pages > 1) :
                    echo '<div class="pagination-wrapper">';
                    echo paginate_links(
                        array(
                            'total' => $teams_query->max_num_pages,
                            'current' => max(1, get_query_var('paged')),
                            'prev_text' => __('← Anterior', 'vaivera'),
                            'next_text' => __('Següent →', 'vaivera'),
                        )
                    );
                    echo '</div>';
                endif;
                ?>
            </section>
        
    <?php endif; ?>
    
    <?php wp_reset_postdata(); ?>
</main>

<?php get_footer(); ?>
