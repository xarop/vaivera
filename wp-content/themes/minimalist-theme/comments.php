<?php
/**
 * Comments template
 *
 * @package Minimalist
 * @since   1.0.0
 */

if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php if ( have_comments() ) : ?>
        <h2 class="comments-title">
            <?php
            $comments_number = get_comments_number();
            if ( 1 === $comments_number ) {
                printf(
                    /* translators: %s: Post title */
                    esc_html_x( 'One thought on &ldquo;%s&rdquo;', 'comments title', 'minimalist' ),
                    '<span>' . esc_html( get_the_title() ) . '</span>'
                );
            } else {
                printf(
                    /* translators: 1: Number of comments, 2: Post title */
                    esc_html( _nx(
                        '%1$s thought on &ldquo;%2$s&rdquo;',
                        '%1$s thoughts on &ldquo;%2$s&rdquo;',
                        $comments_number,
                        'comments title',
                        'minimalist'
                    ) ),
                    esc_html( number_format_i18n( $comments_number ) ),
                    '<span>' . esc_html( get_the_title() ) . '</span>'
                );
            }
            ?>
        </h2>

        <?php the_comments_navigation(); ?>

        <ol class="comment-list">
            <?php
            wp_list_comments(
                array(
                    'style'       => 'ol',
                    'short_ping'  => true,
                    'avatar_size' => 60,
                    'callback'    => 'minimalist_comment_callback',
                )
            );
            ?>
        </ol>

        <?php the_comments_navigation(); ?>

        <?php if ( ! comments_open() ) : ?>
            <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'minimalist' ); ?></p>
        <?php endif; ?>

    <?php endif; ?>

    <?php
    comment_form(
        array(
            'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title">',
            'title_reply_after'  => '</h3>',
            'class_form'         => 'comment-form',
            'class_submit'       => 'submit',
            'submit_button'      => '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />',
            'comment_field'      => '<div class="form-group comment-form-comment"><label for="comment">' . esc_html_x( 'Comment', 'noun', 'minimalist' ) . ' <span class="required">*</span></label> <textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required" placeholder="' . esc_attr__( 'Write your comment here...', 'minimalist' ) . '"></textarea></div>',
            'fields'             => array(
                'author' => '<div class="form-row"><div class="form-group comment-form-author"><label for="author">' . esc_html__( 'Name', 'minimalist' ) . ' <span class="required">*</span></label> <input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" maxlength="245" autocomplete="name" required="required" placeholder="' . esc_attr__( 'Your name', 'minimalist' ) . '" /></div>',
                'email'  => '<div class="form-group comment-form-email"><label for="email">' . esc_html__( 'Email', 'minimalist' ) . ' <span class="required">*</span></label> <input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" maxlength="100" aria-describedby="email-notes" autocomplete="email" required="required" placeholder="' . esc_attr__( 'your@email.com', 'minimalist' ) . '" /></div></div>',
                'url'    => '<div class="form-group comment-form-url"><label for="url">' . esc_html__( 'Website', 'minimalist' ) . '</label> <input id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" maxlength="200" autocomplete="url" placeholder="' . esc_attr__( 'https://yourwebsite.com (optional)', 'minimalist' ) . '" /></div>',
            ),
        )
    );
    ?>

</div><!-- #comments -->