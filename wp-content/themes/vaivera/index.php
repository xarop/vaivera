<?php
/**
 * Main template file
 *
 * @package Vaivera
 * @since   1.0.0
 */

get_header();
?>

<main class="site-main">
    <div class="container">
        <?php if (have_posts() ) : ?>
            <?php while ( have_posts() ) : ?>
                <?php the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <h2 class="entry-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <div class="entry-meta">
                            <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                <?php echo esc_html(get_the_date()); ?>
                            </time>
                            <span class="author">
                                <?php
                                printf(
                                    /* translators: %s: Author name */
                                    esc_html__('by %s', 'vaivera'),
                                    esc_html(get_the_author())
                                );
                                ?>
                            </span>
                        </div>
                    </header>

                    <div class="entry-content">
                        <?php the_excerpt(); ?>
                    </div>

                    <footer class="entry-footer">
                        <a href="<?php the_permalink(); ?>" class="read-more">
                            <?php esc_html_e('Read More', 'vaivera'); ?>
                        </a>
                    </footer>
                </article>
            <?php endwhile; ?>

            <div class="pagination">
                <?php
                the_posts_pagination(
                    array(
                        'prev_text' => __('← Previous', 'vaivera'),
                        'next_text' => __('Next →', 'vaivera'),
                    )
                );
                ?>
            </div>

        <?php else : ?>
            <p><?php esc_html_e('No posts found.', 'vaivera'); ?></p>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
