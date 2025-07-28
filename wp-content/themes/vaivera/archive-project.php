<?php
/**
 * Template for displaying project archives
 *
 * @package Vaivera
 * @since   1.0.0
 */

get_header();
?>

<main class="site-main page-with-projects">
    <div class="container">
        <!-- Archive Header -->
        <article class="page-content-section">
            <section class="page-content-section">
                <aside>
                    <header class="entry-header">
                        <h1 class="entry-title"><?php _e('Projectes', 'vaivera'); ?></h1>
                    </header>
                </aside>
                
                <div class="entry-content">
                    <p><?php _e('Descobreix els nostres projectes més destacats i les solucions que hem desenvolupat per als nostres clients.', 'vaivera'); ?></p>
                </div>
            </section>
        </article>
    </div>
    
    <!-- Projects Grid -->
    <?php get_template_part('partials/projects-archive'); ?>
</main>

<?php get_footer(); ?>
