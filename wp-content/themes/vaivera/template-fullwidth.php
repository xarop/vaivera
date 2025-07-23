<?php
/**
 * Template Name: Full Width (No Title)
 * Template Post Type: page
 *
 * A full-width template with no title and no sidebars
 *
 * @package Vaivera
 * @since   1.0.0
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <script>
        // Prevent flash of unstyled content
        (function() {
            const savedTheme = localStorage.getItem('minimalist-theme');
            if (savedTheme) {
                document.documentElement.setAttribute('data-theme', savedTheme);
            } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        })();
    </script>
    <?php wp_head(); ?>
    <style>
        /* Full width template specific styles */
        body.page-template-template-fullwidth {
            padding: 0;
            margin: 0;
        }
        
        .fullwidth-content {
            width: 100%;
            max-width: 100%;
            padding: 0;
            margin: 0;
        }
        
        .fullwidth-content .entry-content {
            margin: 0;
            padding: 0;
        }
        
        /* Remove default content padding */
        .fullwidth-content .entry-content > * {
            margin-left: 0;
            margin-right: 0;
            max-width: 100%;
        }
        
        /* Make sure WordPress blocks go full width */
        .fullwidth-content .entry-content .alignfull {
            margin-left: 0;
            margin-right: 0;
            width: 100%;
            max-width: 100%;
        }
        
        /* Footer adjustments for full width template */
        .site-footer {
            margin-top: 0;
        }
    </style>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php while ( have_posts() ) : the_post(); ?>
    <div class="fullwidth-content">
        <div class="entry-content">
            <?php the_content(); ?>
        </div>
    </div>
<?php endwhile; ?>

<?php wp_footer(); ?>
</body>
</html>