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
        <p>
            <?php
            printf(
                /* translators: 1: Copyright year, 2: Site name */
                esc_html__( '© %1$s %2$s. All rights reserved.', 'minimalist' ),
                esc_html( gmdate( 'Y' ) ),
                esc_html( get_bloginfo( 'name' ) )
            );
            ?>
        </p>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>