<?php
/**
 * Footer template
 *
 * @package Minimalist
 * @since   1.0.0
 */

?>
<footer class="site-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-info">
                <p>
                    <?php
                    printf(
                        /* translators: 1: Copyright year, 2: Site name */
                        esc_html__('© %1$s %2$s. All rights reserved.', 'vaivera'),
                        esc_html(gmdate('Y')),
                        esc_html(get_bloginfo('name'))
                    );
                    ?>
                </p>
            </div>
            
            <?php if (has_nav_menu('footer') ) : ?>
                <nav class="footer-navigation" role="navigation" aria-label="<?php esc_attr_e('Footer Menu', 'vaivera'); ?>">
                    <?php
                    wp_nav_menu(
                        array(
                        'theme_location' => 'footer',
                        'menu_class'     => 'footer-menu',
                        'container'      => false,
                        'depth'          => 1,
                        ) 
                    );
                    ?>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</footer>

<!-- Theme Toggle Button -->
<div class="theme-toggle-container">
    <?php get_template_part('partials/theme-toggle'); ?>
</div>

<?php wp_footer(); ?>
</body>
</html>
