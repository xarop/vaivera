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
            <h1 class="page-title"><?php _e('Projects', 'vaivera'); ?></h1>
            
            <?php if (term_description()) : ?>
                <div class="archive-description"><?php echo term_description(); ?></div>
            <?php endif; ?>
        </header>
        
        <?php if (have_posts()) : ?>
            <div class="projects-filter">
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
                        <button class="filter-button active" data-filter="all"><?php _e('All', 'vaivera'); ?></button>
                        
                        <?php foreach ($categories as $category) : ?>
                            <button class="filter-button" data-filter="<?php echo esc_attr($category->slug); ?>">
                                <?php echo esc_html($category->name); ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="projects-grid">
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
                                        <h2 class="project-title"><?php the_title(); ?></h2>
                                        
                                        <?php if (!empty($project_categories) && !is_wp_error($project_categories)) : ?>
                                            <div class="project-categories">
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

<style>
/* Projects Archive Styles */
.projects-archive {
    padding: 40px 0;
}

.page-header {
    margin-bottom: 30px;
    text-align: center;
}

/* Filter Styles */
.projects-filter {
    margin-bottom: 30px;
    text-align: center;
}

.filter-categories {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px;
}

.filter-button {
    background: none;
    border: none;
    padding: 8px 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    color: inherit;
}

.filter-button:hover {
    color: var(--color-accent);
}

.filter-button.active {
    color: var(--color-accent);
}

.filter-button.active::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 20px;
    height: 2px;
    background-color: var(--color-accent);
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

.project-item.hidden {
    display: none;
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
    margin: 0 0 10px;
    font-size: 1.5em;
}

.project-categories {
    font-size: 0.9em;
    opacity: 0.8;
}

/* Hover Effects */
.project-item:hover {
    transform: none;
}

.project-item:hover .project-thumbnail img {
    transform: scale(1.05);
}

.project-item:hover .project-overlay {
    opacity: 1;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .projects-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }
    
    .project-title {
        font-size: 1.2em;
    }
}

@media (max-width: 480px) {
    .projects-grid {
        grid-template-columns: 1fr;
    }
}
</style>

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
