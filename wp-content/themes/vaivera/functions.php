<?php
/**
 * Vaivera Theme Functions
 *
 * @category WordPress_Theme
 * @package  Vaivera
 * @author   Theme Developer <developer@example.com>
 * @license  GPL-2.0+ https://www.gnu.org/licenses/gpl-2.0.html
 * @link     https://example.com
 * @since    1.0.0
 */

// Prevent direct access.
if (! defined('ABSPATH') ) {
    exit;
}

// Include custom post types
require_once get_template_directory() . '/inc/cpt-project.php';

// Include project editor support
require_once get_template_directory() . '/inc/project-editor.php';

// Include meta boxes
require_once get_template_directory() . '/inc/project-metaboxes.php';

// Include homepage meta boxes (legacy - specific homepage features only)
// require_once get_template_directory() . '/inc/homepage-metaboxes.php';

// Include unified gallery metabox
require_once get_template_directory() . '/inc/gallery-metabox.php';

/**
 * Theme setup function.
 *
 * @since  1.0.0
 * @return void
 */
function vaivera_setup()
{
    // Make theme available for translation.
    load_theme_textdomain(
        'vaivera',
        get_template_directory() . '/languages'
    );

    // Add theme support for various features.
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        )
    );

    // Gutenberg support.
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    add_theme_support('editor-styles');
    add_editor_style('editor-style.css');

    // Register navigation menu.
    register_nav_menus(
        array(
            'primary' => __('Primary Menu', 'vaivera'),
            'footer'  => __('Footer Menu', 'vaivera'),
        )
    );
}
add_action('after_setup_theme', 'vaivera_setup');

/**
 * Register widget areas.
 *
 * @since  1.0.0
 * @return void
 */
function vaivera_widgets_init()
{
    // Footer Widget Area 1
    register_sidebar(
        array(
            'name'          => __('Footer Widget 1', 'vaivera'),
            'id'            => 'footer-1',
            'description'   => __('Add widgets here to appear in the first footer column.', 'vaivera'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );

    // Footer Widget Area 2
    register_sidebar(
        array(
            'name'          => __('Footer Widget 2', 'vaivera'),
            'id'            => 'footer-2',
            'description'   => __('Add widgets here to appear in the second footer column.', 'vaivera'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );

    // Footer Widget Area 3
    register_sidebar(
        array(
            'name'          => __('Footer Widget 3', 'vaivera'),
            'id'            => 'footer-3',
            'description'   => __('Add widgets here to appear in the third footer column.', 'vaivera'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );

    // Footer Widget Area 4
    register_sidebar(
        array(
            'name'          => __('Footer Widget 4', 'vaivera'),
            'id'            => 'footer-4',
            'description'   => __('Add widgets here to appear in the fourth footer column.', 'vaivera'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );

    // Footer Bottom Banner Widget Area
    register_sidebar(
        array(
            'name'          => __('Footer Bottom Banner', 'vaivera'),
            'id'            => 'footer-bottom',
            'description'   => __('Add widgets here for a centered full-width banner above the copyright.', 'vaivera'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );
}
add_action('widgets_init', 'vaivera_widgets_init');

/**
 * Enqueue styles and scripts.
 *
 * @since  1.0.0
 * @return void
 */
function vaivera_scripts()
{
    // Enqueue Google Fonts
    wp_enqueue_style(
        'vaivera-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap',
        array(),
        '1.0'
    );
    
    wp_enqueue_style(
        'vaivera-style',
        get_stylesheet_uri(),
        array('vaivera-google-fonts'),
        '1.0'
    );

    // Enqueue theme toggle script.
    wp_enqueue_script(
        'vaivera-theme-toggle',
        get_template_directory_uri() . '/js/theme-toggle.js',
        array(),
        '1.0',
        true
    );

    // Enqueue unified slider script
    if (is_front_page() || is_singular('project') || is_post_type_archive('project') || is_tax('project_category')) {
        wp_enqueue_script(
            'vaivera-unified-slider',
            get_template_directory_uri() . '/assets/js/unified-slider.js',
            array('jquery'),
            '1.0',
            true
        );
        
        wp_enqueue_style(
            'vaivera-unified-slider',
            get_template_directory_uri() . '/assets/css/unified-slider.css',
            array('vaivera-style'),
            '1.0'
        );
    }
    
    // Enqueue project-related assets
    if (is_singular('project') || is_post_type_archive('project') || is_tax('project_category')) {
        // Enqueue project archive styles for archive pages
        if (is_post_type_archive('project') || is_tax('project_category')) {
            wp_enqueue_style(
                'vaivera-project-archive',
                get_template_directory_uri() . '/css/project-archive.css',
                array('vaivera-style'),
                '1.0'
            );
        }
        
        // Enqueue project content styles
        wp_enqueue_style(
            'vaivera-project-content',
            get_template_directory_uri() . '/css/project-content.css',
            array(),
            '1.0'
        );
        

    }

    // Only load scripts when needed.
    if (is_singular() && comments_open() && get_option('thread_comments') ) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'vaivera_scripts');

/**
 * Enqueue Gutenberg editor styles.
 *
 * @since  1.0.0
 * @return void
 */
function vaivera_editor_styles()
{
    wp_enqueue_style(
        'vaivera-editor-style',
        get_template_directory_uri() . '/editor-style.css',
        array(),
        '1.0'
    );
}
add_action('enqueue_block_editor_assets', 'vaivera_editor_styles');

/**
 * Custom excerpt length.
 *
 * @param  int $length The excerpt length.
 * @since  1.0.0
 * @return int
 */
function vaivera_excerpt_length( $length )
{
    return 30;
}
add_filter('excerpt_length', 'vaivera_excerpt_length');

/**
 * Custom excerpt more text.
 *
 * @param  string $more The excerpt more text.
 * @since  1.0.0
 * @return string
 */
function vaivera_excerpt_more( $more )
{
    return '...';
}
add_filter('excerpt_more', 'vaivera_excerpt_more');

/**
 * Remove unnecessary WordPress features for performance.
 *
 * @since  1.0.0
 * @return void
 */
function vaivera_remove_wp_features()
{
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
}
add_action('init', 'vaivera_remove_wp_features');

/**
 * Disable emojis for performance.
 *
 * @since  1.0.0
 * @return void
 */
function vaivera_disable_emojis()
{
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init', 'vaivera_disable_emojis');

/**
 * Optimize images.
 *
 * @since  1.0.0
 * @return void
 */
function vaivera_image_sizes()
{
    // Remove default image sizes we don't need.
    remove_image_size('medium_large');

    // Add custom image sizes if needed.
    add_image_size('vaivera-featured', 800, 400, true);
}
add_action('after_setup_theme', 'vaivera_image_sizes');

/**
 * Theme Customizer.
 *
 * @param  WP_Customize_Manager $wp_customize Theme Customizer object.
 * @since  1.0.0
 * @return void
 */
function vaivera_customize_register( $wp_customize )
{
    // Colors Section.
    $wp_customize->add_section(
        'vaivera_colors',
        array(
            'title'    => __('Theme Colors', 'vaivera'),
            'priority' => 30,
        )
    );

    // Primary Color.
    $wp_customize->add_setting(
        'vaivera_primary_color',
        array(
            'default'           => '#333333',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'vaivera_primary_color',
            array(
                'label'    => __('Primary Color', 'vaivera'),
                'section'  => 'vaivera_colors',
                'settings' => 'vaivera_primary_color',
            )
        )
    );

    // Accent Color.
    $wp_customize->add_setting(
        'vaivera_accent_color',
        array(
            'default'           => '#333333',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'vaivera_accent_color',
            array(
                'label'    => __('Accent Color', 'vaivera'),
                'section'  => 'vaivera_colors',
                'settings' => 'vaivera_accent_color',
            )
        )
    );


}
add_action('customize_register', 'vaivera_customize_register');

/**
 * Output customizer CSS.
 *
 * @since  1.0.0
 * @return void
 */
function vaivera_customizer_css()
{
    $primary_color = get_theme_mod('vaivera_primary_color', '#333333');
    $accent_color  = get_theme_mod('vaivera_accent_color', '#333333');

    if ('#333333' !== $primary_color || '#333333' !== $accent_color ) {
        echo '<style type="text/css">';
        echo ':root {';
        if ('#333333' !== $primary_color ) {
            echo '--color-primary: ' . esc_attr($primary_color) . ';';
        }
        if ('#333333' !== $accent_color ) {
            echo '--color-accent: ' . esc_attr($accent_color) . ';';
        }
        echo '}';
        echo '</style>';
    }
}
add_action('wp_head', 'vaivera_customizer_css');

/**
 * Custom comment callback function.
 *
 * @param  WP_Comment $comment Comment object.
 * @param  array      $args    Comment arguments.
 * @param  int        $depth   Comment depth.
 * @since  1.0.0
 * @return void
 */
function vaivera_comment_callback( $comment, $args, $depth )
{
    if ('div' === $args['style'] ) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }
    ?>
    <<?php echo esc_attr($tag); ?> <?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?> id="comment-<?php comment_ID(); ?>">
    <?php if ('div' !== $args['style'] ) : ?>
        <div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
    <?php endif; ?>
    
    <div class="comment-author vcard">
        <?php if (0 !== $args['avatar_size'] ) : ?>
            <div class="comment-avatar">
                <?php echo get_avatar($comment, $args['avatar_size']); ?>
            </div>
        <?php endif; ?>
        <div class="comment-metadata">
            <?php
            printf(
                '<cite class="fn">%s</cite>',
                get_comment_author_link()
            );
            ?>
            <div class="comment-meta commentmetadata">
                <a href="<?php echo esc_url(htmlspecialchars(get_comment_link($comment->comment_ID))); ?>">
                    <?php
                    printf(
                        /* translators: 1: Date, 2: Time */
                        esc_html__('%1$s at %2$s', 'vaivera'),
                        esc_html(get_comment_date()),
                        esc_html(get_comment_time())
                    );
                    ?>
                </a>
                <?php edit_comment_link(esc_html__('(Edit)', 'vaivera'), '  ', ''); ?>
            </div>
        </div>
    </div>

    <?php if ('0' === $comment->comment_approved ) : ?>
        <em class="comment-awaiting-moderation">
            <?php esc_html_e('Your comment is awaiting moderation.', 'vaivera'); ?>
        </em>
        <br />
    <?php endif; ?>

    <div class="comment-content">
        <?php comment_text(); ?>
    </div>

    <div class="comment-reply">
        <?php
        comment_reply_link(
            array_merge(
                $args,
                array(
                    'add_below' => $add_below,
                    'depth'     => $depth,
                    'max_depth' => $args['max_depth'],
                )
            )
        );
        ?>
    </div>

    <?php if ('div' !== $args['style'] ) : ?>
        </div>
    <?php endif; ?>
    <?php
}

/**
 * Add custom form field classes for better styling.
 *
 * @param  array $fields Comment form fields.
 * @since  1.0.0
 * @return array
 */
function vaivera_comment_form_fields( $fields )
{
    $commenter = wp_get_current_commenter();
    
    $fields['author'] = '<div class="form-row"><div class="form-group comment-form-author"><label for="author">' . esc_html__('Name', 'vaivera') . ' <span class="required">*</span></label> <input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" maxlength="245" autocomplete="name" required="required" placeholder="' . esc_attr__('Your name', 'vaivera') . '" /></div>';
    
    $fields['email'] = '<div class="form-group comment-form-email"><label for="email">' . esc_html__('Email', 'vaivera') . ' <span class="required">*</span></label> <input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" maxlength="100" aria-describedby="email-notes" autocomplete="email" required="required" placeholder="' . esc_attr__('your@email.com', 'vaivera') . '" /></div></div>';
    
    $fields['url'] = '<div class="form-group comment-form-url"><label for="url">' . esc_html__('Website', 'vaivera') . '</label> <input id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" maxlength="200" autocomplete="url" placeholder="' . esc_attr__('https://yourwebsite.com (optional)', 'vaivera') . '" /></div>';
    
    return $fields;
}
add_filter('comment_form_default_fields', 'vaivera_comment_form_fields');

/**
 * Register custom blocks.
 *
 * @since  1.0.0
 * @return void
 */
function vaivera_register_blocks()
{
    // Register the image gallery block
    register_block_type(get_template_directory() . '/blocks/image-gallery');
}
add_action('init', 'vaivera_register_blocks');
