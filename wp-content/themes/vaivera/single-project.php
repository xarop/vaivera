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
                        <h2><?php _e('Project Specifications', 'vaivera'); ?></h2>
                        
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
                        <h2><?php _e('Project Gallery', 'vaivera'); ?></h2>
                        
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
@media (max-width: 768px) {
    .specs-list {
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
