<?php
/**
 * Header template
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
    <meta name="theme-color" content="#c9612c">
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
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="container">
        <div class="header-content">
            <div class="site-branding">
                <h1 class="site-title">
                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                        <?php bloginfo('name'); ?>
                    </a>
                </h1>
            </div>

            <?php if (get_bloginfo('description') ) : ?>
                <div class="site-description-container">
                    <p class="site-description"><?php bloginfo('description'); ?></p>
                </div>
            <?php endif; ?>

            <nav class="main-navigation">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'fallback_cb'    => false,
                    )
                );
                ?>
            </nav>
        </div>
    </div>
</header>
