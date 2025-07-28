<?php
/**
 * Team Card Partial
 * 
 * Displays a team card with image, title, and categories
 *
 * @package Vaivera
 * @since   1.0.0
 */

// Get team member position/title
$team_position = get_post_meta(get_the_ID(), 'team_member_position', true);
$team_location = get_post_meta(get_the_ID(), 'team_member_location', true);
?>

<article id="team-<?php the_ID(); ?>" <?php post_class('team-item card'); ?>>
    <a href="<?php the_permalink(); ?>" class="team-link card-link">
        <div class="team-thumbnail card-media">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('medium_large'); ?>
            <?php else : ?>
                <div class="no-thumbnail">
                    <span class="no-image-text"><?php _e('No Image', 'vaivera'); ?></span>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="team-content card-content">
            <h3 class="card-title"><?php the_title(); ?></h3>
            
            <div class="team-meta">
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
            </div>
        </div>
    </a>
</article>
