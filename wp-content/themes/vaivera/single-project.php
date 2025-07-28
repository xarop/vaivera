<?php
/**
 * Template for displaying single projects
 *
 * @package Vaivera
 * @since   1.0.0
 */

get_header();

// Get project meta data
$specs = get_post_meta(get_the_ID(), '_vaivera_project_specs', true);
?>

<main class="site-main project-main">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            <article id="project-<?php the_ID(); ?>" <?php post_class('project-article'); ?>>
                <header class="project-header">
                    <h1 class="project-title"><?php the_title(); ?></h1>
                    
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="project-featured-image">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>
                </header>

                <div class="project-content">
                    <?php the_content(); ?>
                </div>
                
                <?php if (!empty($specs) && is_array($specs)) : ?>
                    <div class="project-specs">
                        <h2><?php _e('Característiques', 'vaivera'); ?></h2>
                        
                        <div class="specs-list">
                            <?php foreach ($specs as $spec) : ?>
                                <div class="spec-item">
                                    <h3 class="spec-title"><?php echo esc_html($spec['title']); ?></h3>
                                    <div class="spec-description"><?php echo wp_kses_post($spec['description']); ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Project Gallery -->
                <?php get_template_part('partials/universal-gallery'); ?>
                
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
                <div class="related-projects">
                    <h2><?php _e('Projectes relacionats', 'vaivera'); ?></h2>
                    <div class="projects-grid content-grid grid-3">
                        <?php while ($related_projects->have_posts()) : $related_projects->the_post(); ?>
                            <?php get_template_part('partials/project-card'); ?>
                        <?php endwhile; ?>
                    </div>
                    <?php wp_reset_postdata(); ?>
                </div>
                <?php endif; ?>
            </article>
        <?php endwhile; ?>
    </div>
</main>




<?php get_footer(); ?>
