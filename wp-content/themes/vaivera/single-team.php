<?php
/**
 * Template for displaying single team members
 *
 * @package Vaivera
 * @since   1.0.0
 */

get_header();

// Get team member data using native WordPress meta
$team_position = get_post_meta(get_the_ID(), 'team_member_position', true);
$team_location = get_post_meta(get_the_ID(), 'team_member_location', true);
$team_phone = get_post_meta(get_the_ID(), 'team_member_phone', true);
$team_email = get_post_meta(get_the_ID(), 'team_member_email', true);
$team_website = get_post_meta(get_the_ID(), 'team_member_website', true);
?>

<main class="site-main team-main">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            <article id="team-<?php the_ID(); ?>" <?php post_class('team-member-article'); ?>>

                <header class="team-member-header">
                    <h1 class="team-member-name"><?php the_title(); ?></h1>
                    
                    <?php if ($team_position) : ?>
                        <p class="team-member-position"><?php echo esc_html($team_position); ?></p>
                    <?php endif; ?>
                    
                    <div class="team-member-layout">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="team-member-image">
                                <?php the_post_thumbnail('medium_large'); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="team-member-details">
                            <?php if ($team_location || $team_phone || $team_email || $team_website) : ?>
                                <div class="team-member-contact">
                                    <h3><?php _e('Contact Information', 'vaivera'); ?></h3>
                                    
                                    <?php if ($team_location) : ?>
                                        <div class="contact-item">
                                            <strong><?php _e('Location:', 'vaivera'); ?></strong> 
                                            <?php echo esc_html($team_location); ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($team_phone) : ?>
                                        <div class="contact-item">
                                            <strong><?php _e('Phone:', 'vaivera'); ?></strong> 
                                            <a href="tel:<?php echo esc_attr($team_phone); ?>"><?php echo esc_html($team_phone); ?></a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($team_email) : ?>
                                        <div class="contact-item">
                                            <strong><?php _e('Email:', 'vaivera'); ?></strong> 
                                            <a href="mailto:<?php echo esc_attr($team_email); ?>"><?php echo esc_html($team_email); ?></a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($team_website) : ?>
                                        <div class="contact-item">
                                            <strong><?php _e('Website:', 'vaivera'); ?></strong> 
                                            <a href="<?php echo esc_url($team_website); ?>" target="_blank" rel="noopener"><?php echo esc_html($team_website); ?></a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </header>

                <?php if (get_the_content()) : ?>
                    <section class="team-member-bio">
                        <h3><?php _e('Biography', 'vaivera'); ?></h3>
                        <div class="team-member-content">
                            <?php the_content(); ?>
                        </div>
                    </section>
                <?php endif; ?>

                <!-- Gallery -->
                <?php get_template_part('partials/universal-gallery'); ?>

                <!-- Related Teams -->
                <?php get_template_part('partials/related'); ?>

            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
