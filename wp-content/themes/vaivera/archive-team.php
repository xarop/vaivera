<?php
/**
 * Page Template: Team Grid
 * Template Name: Team Grid
 * Template for displaying team archives
 *
 * @package Vaivera
 * @since   1.0.0
 */

get_header();
?>

<main class="site-main page-with-team">
    <div class="container">
        <!-- Archive Header -->
        <article class="page-content-section">
            <section class="page-content-section">
                <aside>
                    <header class="entry-header">
                        <h1 class="entry-title"><?php _e('Equip', 'vaivera'); ?></h1>
                    </header>
                </aside>
                
                <div class="entry-content">
                    <p><?php _e('Coneix els professionals que formen part del nostre equip i les seves àrees d\'especialització.', 'vaivera'); ?></p>
                </div>
            </section>
        </article>
    </div>
    
    <!-- Team Grid -->
    <?php get_template_part('partials/teams-archive'); ?>
</main>

<?php get_footer(); ?>
