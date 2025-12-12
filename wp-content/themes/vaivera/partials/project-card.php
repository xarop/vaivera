<?php
/**
 * Project Card Partial
 * 
 * Displays a project card with image, title, and categories
 *
 * @package Vaivera
 * @since   1.0.0
 */

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
                <div class="no-thumbnail">
                    <span class="no-image-text"><?php _e('No Image', 'vaivera'); ?></span>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="project-content card-content">
            <h3 class="card-title"><?php the_title(); ?></h3>
            
            <?php 
            $subtitle = get_post_meta(get_the_ID(), '_vaivera_project_subtitle', true);
            $location = get_post_meta(get_the_ID(), '_vaivera_project_location', true);
            ?>
            
            <?php if (!empty($subtitle)) : ?>
                <p class="card-subtitle"><?php echo esc_html($subtitle); ?></p>
            <?php endif; ?>
            
            <!-- <?php if (!empty($location)) : ?>
                <div class="card-location"><?php echo esc_html($location); ?></div>
           <?php endif; ?>
            
            <?php if (!empty($project_categories) && !is_wp_error($project_categories)) : ?>
                <div class="card-excerpt">
                    <?php 
                    $category_names = array();
                    foreach ($project_categories as $category) {
                        $category_names[] = $category->name;
                    }
                    echo esc_html(implode(', ', $category_names));
                    ?>
                </div>
            <?php endif; ?> -->
        </div>
    </a>
</article>
