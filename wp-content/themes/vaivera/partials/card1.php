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
                                        <h3 class="project-title overlay-title"><?php the_title(); ?></h3>
                                        
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
