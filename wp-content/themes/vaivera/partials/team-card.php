<?php
/**
 * Team Card Partial
 * 
 * Displays a team card with image, contact information, and details
 *
 * @package Vaivera
 * @since   1.0.0
 */

// Get team member information
$team_position = get_post_meta(get_the_ID(), 'team_member_position', true);
$team_location = get_post_meta(get_the_ID(), 'team_member_location', true);
$team_phone = get_post_meta(get_the_ID(), 'team_member_phone', true);
$team_email = get_post_meta(get_the_ID(), 'team_member_email', true);
$team_website = get_post_meta(get_the_ID(), 'team_member_website', true);
?>

<article id="team-<?php the_ID(); ?>" <?php post_class('team-item team-card'); ?>>
    <div class="team-card-inner">
        <!-- Team Member Photo -->
        <div class="team-photo">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('medium_large', array('class' => 'team-image')); ?>
            <?php else : ?>
                <div class="no-thumbnail team-placeholder">
                    <span class="no-image-text"><?php _e('No Photo', 'vaivera'); ?></span>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Team Member Info -->
        <div class="team-info">
            <div class="team-content-row">
                <header class="team-header">    
                    <h3 class="team-name"><?php the_title(); ?></h3>
                    
                    <?php if ($team_position) : ?>
                        <div class="team-position">
                            <?php echo esc_html($team_position); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($team_location) : ?>
                        <div class="team-location">
                            <?php echo esc_html($team_location); ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Contact Information -->
                    <div class="team-contact">
                        <?php if ($team_phone) : ?>
                            <div class="team-phone">
                                <a href="tel:<?php echo esc_attr(str_replace(' ', '', $team_phone)); ?>">
                                    <?php echo esc_html($team_phone); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($team_email) : ?>
                            <div class="team-email">
                                <a href="mailto:<?php echo esc_attr($team_email); ?>">
                                    <?php echo esc_html($team_email); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($team_website) : ?>
                            <div class="team-website">
                                <a href="<?php echo esc_url($team_website); ?>" target="_blank" rel="noopener noreferrer">
                                    <?php echo esc_html($team_website); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </header>
                
                <!-- Bio/Description -->
                <?php if (has_excerpt() || get_the_content()) : ?>
                    <div class="team-bio">
                        <?php if (has_excerpt()) : ?>
                            <?php the_excerpt(); ?>
                        <?php else : ?>
                            <?php 
                            $content = get_the_content();
                            // if ($content) {
                            //     echo wpautop(wp_trim_words($content, 250, '...'));
                            // }
                            echo $content; // Display full content if no excerpt 
                            ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</article>
