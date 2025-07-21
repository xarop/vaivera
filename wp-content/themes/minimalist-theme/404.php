<?php
/**
 * 404 Error template
 *
 * @package Minimalist
 * @since   1.0.0
 */

get_header();
?>

<main class="site-main">
    <div class="container">
        <article class="error-404">
            <header class="entry-header">
                <h1 class="entry-title"><?php esc_html_e( 'Page Not Found', 'minimalist' ); ?></h1>
            </header>

            <div class="entry-content">
                <p><?php esc_html_e( 'Sorry, the page you\'re looking for doesn\'t exist.', 'minimalist' ); ?></p>
                <p>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <?php esc_html_e( '← Back to Home', 'minimalist' ); ?>
                    </a>
                </p>
            </div>
        </article>
    </div>
</main>

<?php get_footer(); ?>