<?php
/**
 * Projects Archive Partial
 *
 * @package Vaivera
 * @since   1.0.0
 */

// Query projects
$projects_query = new WP_Query(array(
    'post_type' => 'project',
    'posts_per_page' => -1, // Show all projects
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC'
));

if ($projects_query->have_posts()) : ?>
    <section class="projects-section">
        <div class="container">
            <?php if (!is_front_page()) : ?>
                <header class="page-header">
                    <h2 class="page-title"><?php _e('Projectes', 'vaivera'); ?></h2>
                </header>
            <?php endif; ?>
            
            <div class="projects-filter filter-container">
                <?php
                $categories = get_terms(
                    array(
                    'taxonomy' => 'project_category',
                    'hide_empty' => true,
                    )
                );
                
                if (!empty($categories) && !is_wp_error($categories)) :
                    ?>
                    <div class="filter-categories">
                        <button class="filter-button active" data-filter="all"><?php _e('Tot', 'vaivera'); ?></button>
                        
                        <?php foreach ($categories as $category) : ?>
                            <button class="filter-button" data-filter="<?php echo esc_attr($category->slug); ?>">
                                <?php echo esc_html($category->name); ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="projects-grid content-grid grid-2">
                <?php while ($projects_query->have_posts()) : $projects_query->the_post(); ?>
                    <?php get_template_part('partials/project-card'); ?>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <script>
    jQuery(document).ready(function($) {
        // Filter projects
        $('.filter-button').on('click', function() {
            var filter = $(this).data('filter');
            
            // Update active button
            $('.filter-button').removeClass('active');
            $(this).addClass('active');
            
            if (filter === 'all') {
                // Show all projects
                $('.project-item').removeClass('hidden');
            } else {
                // Hide all projects
                $('.project-item').addClass('hidden');
                // Show only projects with selected category
                $('.project-item.category-' + filter).removeClass('hidden');
            }
        });
    });
    </script>

<?php endif; 

// Reset post data
wp_reset_postdata();
?>
