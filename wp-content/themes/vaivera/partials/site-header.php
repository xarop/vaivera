<?php
/**
 * Site Header Partial
 * 
 * Reusable header component for consistent header across all pages
 *
 * @package Vaivera
 * @since   1.0.0
 */
?>


<header class="site-header">
    <div class="container">
        <div class="header-content">
            <aside class="site-branding">
                <h1 class="site-title">
                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                        <?php bloginfo('name'); ?>
                        <span class="site-title-description"><?php bloginfo('description'); ?></span>
                    </a>
                </h1>
            </aside>
            <div class="site-navigation">
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
    </div>
</header>
