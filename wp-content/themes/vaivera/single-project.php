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
$gallery_images = get_post_meta(get_the_ID(), '_vaivera_project_gallery', true);
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
                
                <?php if (!empty($gallery_images) && is_array($gallery_images)) : ?>
                    <div class="project-gallery">
                        <h2><?php _e("Galeria d'imatges", 'vaivera'); ?></h2>
                        
                        <div class="gallery-grid">
                            <?php foreach ($gallery_images as $index => $image_id) : ?>
                                <div class="gallery-item">
                                    <a href="javascript:void(0);" 
                                       class="gallery-link" 
                                       data-index="<?php echo esc_attr($index); ?>">
                                        <?php echo wp_get_attachment_image($image_id, 'medium_large'); ?>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <!-- Gallery Slider Modal -->
                    <div class="gallery-modal" id="galleryModal">
                        <div class="modal-content">
                            <span class="close-modal">&times;</span>
                            
                            <div class="slider-container">
                                <div class="slider">
                                    <?php foreach ($gallery_images as $image_id) : ?>
                                        <div class="slide">
                                            <?php echo wp_get_attachment_image($image_id, 'full'); ?>
                                            <?php if (wp_get_attachment_caption($image_id)) : ?>
                                                <div class="image-caption">
                                                    <?php echo wp_get_attachment_caption($image_id); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                
                                <button type="button" class="slider-nav prev">←</button>
                                <button type="button" class="slider-nav next">→</button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                
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
                    <div class="projects-grid">
                        <?php while ($related_projects->have_posts()) : $related_projects->the_post(); 
                            // Get project categories for classes
                            $project_cats = get_the_terms(get_the_ID(), 'project_category');
                            $category_classes = '';
                            
                            if (!empty($project_cats) && !is_wp_error($project_cats)) {
                                foreach ($project_cats as $category) {
                                    $category_classes .= ' category-' . $category->slug;
                                }
                            }
                            ?>
                            <article id="project-<?php the_ID(); ?>" <?php post_class('project-item' . $category_classes); ?>>
                                <a href="<?php the_permalink(); ?>" class="project-link">
                                    <div class="project-thumbnail">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <?php the_post_thumbnail('medium_large'); ?>
                                        <?php else : ?>
                                            <div class="no-thumbnail"></div>
                                        <?php endif; ?>
                                        
                                        <div class="project-overlay">
                                            <div class="project-overlay-content">
                                                <h3 class="project-title"><?php the_title(); ?></h3>
                                                
                                                <?php if (!empty($project_cats) && !is_wp_error($project_cats)) : ?>
                                                    <div class="project-categories">
                                                        <?php 
                                                        $category_names = array();
                                                        foreach ($project_cats as $category) {
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
                    <?php wp_reset_postdata(); ?>
                </div>
                <?php endif; ?>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<style>
/* Project Styles */
.project-main {
    padding: 40px 0;
}

.project-featured-image {
    margin-bottom: 30px;
}

.project-featured-image img {
    width: 100%;
    height: auto;
}

.project-content {
    margin-bottom: 40px;
}

/* Specs Styles */
.project-specs {
    margin-bottom: 40px;
}

.specs-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

.spec-item {
    padding: 20px;
    border-bottom: 1px solid var(--color-border);
}

.spec-title {
    margin-top: 0;
    margin-bottom: 10px;
    font-size: 1.2em;
}

/* Responsive Styles */
/* Related Projects Styles */
.related-projects {
    margin-top: 40px;
    margin-bottom: 40px;
}

.related-projects h2 {
    margin-bottom: 20px;
}

/* Projects Grid */
.projects-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 30px;
}

.project-item {
    transition: transform 0.3s ease;
}

.project-link {
    display: block;
    text-decoration: none;
    color: inherit;
}

.project-thumbnail {
    position: relative;
    overflow: hidden;
    aspect-ratio: 4/3;
}

.project-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.no-thumbnail {
    width: 100%;
    height: 100%;
    background: var(--color-border);
}

.project-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.project-overlay-content {
    text-align: center;
    padding: 20px;
    color: #fff;
}

.project-title {
    /* margin: 0 0 10px;
    font-size: 1.5em; */
}

.project-categories {
    font-size: 0.9em;
    opacity: 0.8;
}

/* Hover Effects */
.project-item:hover .project-thumbnail img {
    transform: scale(1.05);
}

.project-item:hover .project-overlay {
    opacity: 1;
}

@media (max-width: 768px) {
    .specs-list {
        grid-template-columns: 1fr;
    }
    
    .projects-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }
    
    .project-title {
        /* font-size: 1.2em; */
    }
}

@media (max-width: 480px) {
    .projects-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php
// Enqueue gallery slider script
wp_enqueue_script(
    'vaivera-gallery-slider',
    get_template_directory_uri() . '/js/gallery-slider.js',
    array('jquery'),
    '1.0.0',
    true
);
?>
</script>

<?php get_footer(); ?>
