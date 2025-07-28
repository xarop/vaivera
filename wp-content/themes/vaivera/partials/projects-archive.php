<?php
/**
 * Projects Archive Partial
 *
 * @package Vaivera
 * @since   1.0.0
 */

// Query projects
$projects_query = new WP_Query(
    array(
    'post_type' => 'project',
    'posts_per_page' => -1, // Show all projects
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC'
    )
);

if ($projects_query->have_posts()) : ?>
    <section class="projects-section">
        <div class="container">
            <!-- <?php if (!is_front_page()) : ?>
                <header class="page-header">
                    <h2 class="page-title"><?php _e('Projectes', 'vaivera'); ?></h2>
                </header>
           <?php endif; ?> -->
            
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
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Projects filter script loaded');
        
        // Get all filter buttons and project items
        const filterButtons = document.querySelectorAll('.filter-button');
        const projectItems = document.querySelectorAll('.project-item');
        
        console.log('Found ' + filterButtons.length + ' filter buttons');
        console.log('Found ' + projectItems.length + ' project items');
        
        // Add click event to each filter button
        filterButtons.forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const filter = this.getAttribute('data-filter');
                console.log('Filter clicked: ' + filter);
                
                // Update active button
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                // Filter projects
                projectItems.forEach(function(item) {
                    if (filter === 'all') {
                        // Show all projects
                        item.classList.remove('hidden');
                        item.style.display = '';
                        console.log('Showing all projects');
                    } else {
                        // Check if project has the selected category
                        if (item.classList.contains('category-' + filter)) {
                            item.classList.remove('hidden');
                            item.style.display = '';
                            console.log('Showing project with category: ' + filter);
                        } else {
                            item.classList.add('hidden');
                            item.style.display = 'none';
                            console.log('Hiding project without category: ' + filter);
                        }
                    }
                });
            });
        });
    });
    </script>

<?php endif; 

// Reset post data
wp_reset_postdata();
?>
