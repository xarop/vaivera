<?php
/**
 * Template for displaying single projects
 *
 * @package Vaivera
 * @since   1.0.0
 */

get_header();

// Get project meta data
$subtitle = get_post_meta(get_the_ID(), '_vaivera_project_subtitle', true);
$work = get_post_meta(get_the_ID(), '_vaivera_project_work', true);
$year = get_post_meta(get_the_ID(), '_vaivera_project_year', true);
$location = get_post_meta(get_the_ID(), '_vaivera_project_location', true);
$client = get_post_meta(get_the_ID(), '_vaivera_project_client', true);
$superficie = get_post_meta(get_the_ID(), '_vaivera_project_superficie', true);
$budget = get_post_meta(get_the_ID(), '_vaivera_project_budget', true);
$team = get_post_meta(get_the_ID(), '_vaivera_project_team', true);
$colaborators = get_post_meta(get_the_ID(), '_vaivera_project_colaborators', true);
$constructo = get_post_meta(get_the_ID(), '_vaivera_project_constructo', true);
$photograph = get_post_meta(get_the_ID(), '_vaivera_project_photograph', true);
?>

<main class="site-main project-main">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            <article id="project-<?php the_ID(); ?>" <?php post_class('project-article'); ?>>

                <section class="project-section">
                    
                    <aside class="project-aside">
                            <!-- Title and Subtitle -->
                            <div class="project-header">
                                <h1><?php the_title(); ?></h1>
                                <?php if (!empty($subtitle)) : ?>
                                    <h2><?php echo esc_html($subtitle); ?></h2>
                                <?php endif; ?>
                            </div>

                            <div class="project-header-info">
                                <?php if (!empty($location)) : ?>
                                    <h3><?php echo esc_html($location); ?></h3>
                                <?php endif; ?>
                                <?php if (!empty($year)) : ?>
                                    <h4><?php echo esc_html($year); ?></h4>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Project Details -->
                            <dl class="project-details-list">                 
                                
                                <?php if (!empty($work)) : ?>
                                    <dt><?php _e('FEINA REALITZADA', 'vaivera'); ?></dt>
                                    <dd class="project-description-text"><?php echo wpautop(esc_html($work)); ?></dd>
                                <?php endif; ?>

                                <?php 
                                // Check for custom taxonomies (project categories, project types, etc.)
                                $project_cats = get_the_terms(get_the_ID(), 'project_category');
                                
                                if (!empty($project_cats) && !is_wp_error($project_cats)) {
                                    $cat_links = array();
                                    foreach ($project_cats as $cat) {
                                        $cat_links[] = '<a class="project-category" href="' . get_term_link($cat) . '">' . esc_html($cat->name) . '</a>';
                                    }
                                    echo '<dt>Categories</dt><dd>' . implode('<br/> ', $cat_links) . '</dd>';
                                }
                                ?>
                            </dl>
                            <dl class="project-details-list">      
                                <?php if (!empty($client)) : ?>
                                    <dt><?php _e('CLIENT', 'vaivera'); ?></dt>
                                    <dd><?php echo esc_html($client); ?></dd>
                                <?php endif; ?>
                                
                                <?php if (!empty($superficie)) : ?>
                                    <dt><?php _e('SUPERFÍCIE', 'vaivera'); ?></dt>
                                    <dd><?php echo esc_html($superficie); ?> m²</dd>
                                <?php endif; ?>
                                
                                <?php if (!empty($budget)) : ?>
                                    <dt><?php _e('PRESSUPOST', 'vaivera'); ?></dt>
                                    <dd><?php echo esc_html(number_format($budget, 0, ',', '.')); ?> €</dd>
                                <?php endif; ?>
                            </dl>

                            <dl class="project-details-list">    
                                
                                <?php if (!empty($team)) : ?>
                                    <dt><?php _e('EQUIP', 'vaivera'); ?></dt>
                                    <dd><?php echo esc_html($team); ?></dd>
                                <?php endif; ?>
                                
                                <?php if (!empty($colaborators)) : ?>
                                    <dt><?php _e('COL·LABORADORS', 'vaivera'); ?></dt>
                                    <dd><?php echo esc_html($colaborators); ?></dd>
                                <?php endif; ?>
                                
                                <?php if (!empty($constructo)) : ?>
                                    <dt><?php _e('CONSTRUCTOR', 'vaivera'); ?></dt>
                                    <dd><?php echo esc_html($constructo); ?></dd>
                                <?php endif; ?>
                                
                                <?php if (!empty($photograph)) : ?>
                                    <dt><?php _e('FOTÒGRAF', 'vaivera'); ?></dt>
                                    <dd><?php echo esc_html($photograph); ?></dd>
                                <?php endif; ?>
                            </dl>

                            
                            <?php the_excerpt(); ?>
                           
                       
                    </aside>
                    
                    
                    <div class="project-content content">
                        <header class="project-header">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="project-featured-image">
                                    <?php the_post_thumbnail('large'); ?>
                                </div>
                                <div class="project-content">
                                    <?php the_content(); ?>
                                </div>
                            <?php endif; ?>
                        </header>
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
