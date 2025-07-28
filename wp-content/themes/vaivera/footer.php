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
        <?php
        // Check if any footer widgets are active
        $has_widgets = is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3') || is_active_sidebar('footer-4');
        ?>
        
        <?php if ($has_widgets) : ?>
            <div class="footer-widgets">
                <div class="footer-widget-area">
                    <?php if (is_active_sidebar('footer-1')) : ?>
                        <div class="footer-widget-column">
                            <?php dynamic_sidebar('footer-1'); ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="footer-widget-area">
                    <?php if (is_active_sidebar('footer-2')) : ?>
                        <div class="footer-widget-column">
                            <?php dynamic_sidebar('footer-2'); ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="footer-widget-area">
                    <?php if (is_active_sidebar('footer-3')) : ?>
                        <div class="footer-widget-column">
                            <?php dynamic_sidebar('footer-3'); ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="footer-widget-area">
                    <?php if (is_active_sidebar('footer-4')) : ?>
                        <div class="footer-widget-column">
                            <?php dynamic_sidebar('footer-4'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Bottom Banner Widget Area -->
        <?php if (is_active_sidebar('footer-bottom')) : ?>
            <div class="footer-bottom-widget">
                <div class="footer-bottom-widget-area">
                    <?php dynamic_sidebar('footer-bottom'); ?>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- // bottom widget -->
        <div class="footer-content">
            <div class="footer-info">
                    <?php
                    printf(
                        /* translators: 1: Copyright year, 2: Site name */
                        esc_html__('© %1$s %2$s. All rights reserved', 'vaivera'),
                        esc_html(gmdate('Y')),
                        esc_html(get_bloginfo('name'))
                    );
                    ?>
                    · Desenvolupat a Barcelona per <a href="https://xarop.com" target="_blank">xarop.com</a>
            </div>
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
