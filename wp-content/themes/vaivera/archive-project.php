<?php
/**
 * Template for displaying project archives
 *
 * @package Vaivera
 * @since   1.0.0
 */

get_header();
?>

<main class="site-main projects-archive">
    <div class="container">
        <header class="page-header">
            <h1 class="page-title"><?php _e('Projectes', 'vaivera'); ?></h1>
            
            <?php if (term_description()) : ?>
                <div class="archive-description"><?php echo term_description(); ?></div>
            <?php endif; ?>
        </header>
        
        <?php if (have_posts()) : ?>
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
            
            <div class="projects-grid content-grid grid-3">
                <?php while (have_posts()) : the_post(); 
                    // Get project categories
                    $project_categories = get_the_terms(get_the_ID(), 'project_category');
                    $category_classes = '';
                    
                    if (!empty($project_categories) && !is_wp_error($project_categories)) {
                        foreach ($project_categories as $category) {
                            $category_classes .= ' category-' . $category->slug;
                        }
                    }
                    ?>
                    <article id="project-<?php the_ID(); ?>" <?php post_class('project-item card' . $category_classes); ?>>
                        <a href="<?php the_permalink(); ?>" class="project-link card-link">
                            <div class="project-thumbnail card-media">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium_large'); ?>
                                <?php else : ?>
                                    <div class="no-thumbnail"></div>
                                <?php endif; ?>
                                
                                <div class="project-overlay overlay">
                                    <div class="project-overlay-content overlay-content">
                                        <h2 class="project-title overlay-title"><?php the_title(); ?></h2>
                                        
                                        <?php if (!empty($project_categories) && !is_wp_error($project_categories)) : ?>
                                            <div class="project-categories overlay-meta">
                                                <?php 
                                                $category_names = array();
                                                foreach ($project_categories as $category) {
                                                    $category_names[] = $category->name;
                                                }
                                                echo esc_html(implode(', ', $category_names));
                                                ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </article>
                <?php endwhile; ?>
            </div>
            
            <?php the_posts_pagination(); ?>
            
        <?php else : ?>
            <p><?php _e('No projects found.', 'vaivera'); ?></p>
        <?php endif; ?>
    </div>
</main>

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

<?php get_footer(); ?>
