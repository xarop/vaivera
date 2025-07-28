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

                <section class="project-section">
                    
                    <aside>
                        <?php if (!empty($specs) && is_array($specs)) : ?>
                        <div class="project-specs">

                            <h1 class="project-title"><?php the_title(); ?></h1>
                            
                            <h2><?php _e('Característiques', 'vaivera'); ?></h2>
                            
                            <ul class="specs-list">
                                <?php foreach ($specs as $spec) : ?>
                                    <li class="spec-item">
                                        <strong class="spec-title"><?php echo esc_html($spec['title']); ?></strong>
                                        <div class="spec-description"><?php echo wp_kses_post($spec['description']); ?></div>
                                    </li>
                                <?php endforeach; ?>
                                </ul>
                        </div>
                        <?php endif; ?>
                    </aside>
                    
                    
                    <div class="project-content content">
                        <header class="project-header">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="project-featured-image">
                                    <?php the_post_thumbnail('large'); ?>
                                </div>
                            <?php endif; ?>
                        </header>

                        <div class="project-description">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </section>
                
                
                
                <!-- Gallery -->
                <?php get_template_part('partials/universal-gallery'); ?>

                <!-- Related Projects -->
                <?php get_template_part('partials/related'); ?>

            </article>
        <?php endwhile; ?>
    </div>
</main>




<?php get_footer(); ?>
