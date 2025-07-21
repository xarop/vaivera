<?php
/**
 * Single post template
 *
 * @package Minimalist
 * @since   1.0.0
 */

get_header();
?>

<main class="site-main">
    <div class="container">
        <?php while ( have_posts() ) : ?>
            <?php the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <div class="entry-meta">
                        <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                            <?php echo esc_html( get_the_date() ); ?>
                        </time>
                        <span class="author">
                            <?php
                            printf(
                                /* translators: %s: Author name */
                                esc_html__( 'by %s', 'minimalist' ),
                                esc_html( get_the_author() )
                            );
                            ?>
                        </span>
                        <?php if ( has_category() ) : ?>
                            <span class="categories">
                                <?php
                                printf(
                                    /* translators: %s: Category list */
                                    esc_html__( 'in %s', 'minimalist' ),
                                    get_the_category_list( ', ' ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                );
                                ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </header>

                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="featured-image">
                        <?php the_post_thumbnail( 'large' ); ?>
                    </div>
                <?php endif; ?>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>

                <footer class="entry-footer">
                    <?php if ( has_tag() ) : ?>
                        <div class="tags">
                            <?php the_tags( esc_html__( 'Tags: ', 'minimalist' ), ', ', '' ); ?>
                        </div>
                    <?php endif; ?>
                </footer>
            </article>

            <nav class="post-navigation">
                <div class="nav-previous">
                    <?php previous_post_link( '%link', '← %title' ); ?>
                </div>
                <div class="nav-next">
                    <?php next_post_link( '%link', '%title →' ); ?>
                </div>
            </nav>

            <?php
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;
            ?>

        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>