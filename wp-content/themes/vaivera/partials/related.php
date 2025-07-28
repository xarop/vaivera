<?php
// Get current project categories
$project_categories = wp_get_post_terms(get_the_ID(), 'project_category', array('fields' => 'ids'));
                
// If we have categories, get related projects
if (!empty($project_categories) && !is_wp_error($project_categories)) {
    $related_args = array(
        'post_type' => 'project',
        'posts_per_page' => 3,
        'post__not_in' => array(get_the_ID()), // Exclude current project
        'tax_query' => array(
            array(
                'taxonomy' => 'project_category',
                'field' => 'id',
                'terms' => $project_categories
            )
        )
    );
} else {
    // If no categories, just get recent projects
    $related_args = array(
        'post_type' => 'project',
        'posts_per_page' => 3,
        'post__not_in' => array(get_the_ID()) // Exclude current project
    );
}
                
$related_projects = new WP_Query($related_args);
                
// Only show related projects section if we have related projects
if ($related_projects->have_posts()) :
    ?>
    <!-- Related Projects Section -->
    <section class="related-projects">
        <aside>
            <h2><?php _e('Projectes relacionats', 'vaivera'); ?></h2>
        </aside>
        <div class="projects-grid content-grid grid-3">
            <?php while ($related_projects->have_posts()) : $related_projects->the_post(); ?>
            <div class="project-card">
                <?php get_template_part('partials/project-card'); ?>
            </div>
            <?php endwhile; ?>
        </div>
        <?php wp_reset_postdata(); ?>
    </section>
<?php endif; ?>
