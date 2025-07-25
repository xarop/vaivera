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
                            
                            <?php
                            // Configure gallery carousel
                            $carousel_config = array(
                                'images' => array_map(function($image_id) {
                                    return array(
                                        'id' => $image_id,
                                        'size' => 'full',
                                        'caption' => wp_get_attachment_caption($image_id)
                                    );
                                }, $gallery_images),
                                'container_class' => 'gallery-carousel',
                                'show_indicators' => false,
                                'show_captions' => true,
                                'show_navigation' => true,
                                'image_size' => 'full'
                            );
                            
                            set_query_var('carousel_config', $carousel_config);
                            get_template_part('partials/carousel');
                            ?>
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
