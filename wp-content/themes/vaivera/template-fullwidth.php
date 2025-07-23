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
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <script>
        // Prevent flash of unstyled content
        (function() {
            const savedTheme = localStorage.getItem('xarop-theme');
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
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        
        .fullwidth-content .entry-content {
            margin: 0;
            padding: 0;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        /* Center content blocks */
        .fullwidth-content .entry-content > * {
            margin-left: auto;
            margin-right: auto;
            max-width: 1200px; /* You can adjust this value */
            width: 100%;
        }
        
        /* Make sure WordPress blocks go full width when needed */
        .fullwidth-content .entry-content .alignfull {
            margin-left: 0;
            margin-right: 0;
            width: 100%;
            max-width: 100%;
        }
        
        /* Standard content width for regular blocks */
        .fullwidth-content .entry-content > p,
        .fullwidth-content .entry-content > h1,
        .fullwidth-content .entry-content > h2,
        .fullwidth-content .entry-content > h3,
        .fullwidth-content .entry-content > h4,
        .fullwidth-content .entry-content > h5,
        .fullwidth-content .entry-content > h6,
        .fullwidth-content .entry-content > ul,
        .fullwidth-content .entry-content > ol,
        .fullwidth-content .entry-content > blockquote {
            max-width: 800px; /* You can adjust this value */
            padding-left: 20px;
            padding-right: 20px;
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
