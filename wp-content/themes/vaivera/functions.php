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

/**
 * Enqueue block assets for the frontend.
 *
 * @since  1.0.0
 * @return void
 */
function minimalist_enqueue_block_assets()
{
    // Enqueue the gallery lightbox script
    wp_enqueue_script(
        'minimalist-gallery-lightbox',
        get_template_directory_uri() . '/blocks/image-gallery/view.js',
        array(),
        '1.0.0',
        true
    );

    // Enqueue the gallery styles
    wp_enqueue_style(
        'minimalist-gallery-styles',
        get_template_directory_uri() . '/blocks/image-gallery/style.css',
        array(),
        '1.0.0'
    );
}
add_action('wp_enqueue_scripts', 'minimalist_enqueue_block_assets');

/**
 * Enqueue block editor assets.
 *
 * @since  1.0.0
 * @return void
 */
function minimalist_enqueue_block_editor_assets()
{
    // Enqueue the block editor script
    wp_enqueue_script(
        'minimalist-gallery-editor',
        get_template_directory_uri() . '/blocks/image-gallery/index.js',
        array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n' ),
        '1.0.0',
        true
    );

    // Enqueue the block editor styles
    wp_enqueue_style(
        'minimalist-gallery-editor-styles',
        get_template_directory_uri() . '/blocks/image-gallery/editor.css',
        array( 'wp-edit-blocks' ),
        '1.0.0'
    );
}
add_action('enqueue_block_editor_assets', 'minimalist_enqueue_block_editor_assets');

/**
 * Create a simple gallery shortcode as fallback.
 *
 * Usage: [minimalist_gallery ids="1,2,3,4" columns="3" spacing="medium" captions="true"]
 *
 * @param  array $atts Shortcode attributes.
 * @since  1.0.0
 * @return string
 */
function minimalist_gallery_shortcode( $atts )
{
    $atts = shortcode_atts(
        array(
            'ids'      => '',
            'columns'  => 3,
            'spacing'  => 'medium',
            'captions' => 'true',
        ),
        $atts,
        'minimalist_gallery'
    );

    if (empty($atts['ids']) ) {
        return '<p>Please provide image IDs for the gallery.</p>';
    }

    $image_ids = explode(',', $atts['ids']);
    $columns = intval($atts['columns']);
    $spacing = sanitize_text_field($atts['spacing']);
    $show_captions = $atts['captions'] === 'true';

    $output = '<div class="wp-block-minimalist-image-gallery gallery-columns-' . $columns . ' gallery-spacing-' . $spacing . '">';
    $output .= '<div class="gallery-grid" data-lightbox="gallery">';

    foreach ( $image_ids as $index => $image_id ) {
        $image_id = intval(trim($image_id));
        $image = wp_get_attachment_image_src($image_id, 'medium');
        $full_image = wp_get_attachment_image_src($image_id, 'full');
        $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
        $caption = wp_get_attachment_caption($image_id);

        if ($image ) {
            $output .= '<div class="gallery-item" data-id="' . $image_id . '" data-index="' . $index . '">';
            $output .= '<div class="gallery-image-container">';
            $output .= '<img src="' . esc_url($image[0]) . '" alt="' . esc_attr($alt) . '" data-full="' . esc_url($full_image[0]) . '" loading="lazy" />';
            $output .= '<div class="gallery-overlay"><span class="gallery-zoom-icon">🔍</span></div>';
            $output .= '</div>';
            
            if ($show_captions && $caption ) {
                $output .= '<div class="gallery-caption">' . esc_html($caption) . '</div>';
            }
            
            $output .= '</div>';
        }
    }

    $output .= '</div></div>';

    return $output;
}
add_shortcode('minimalist_gallery', 'minimalist_gallery_shortcode');/**
Register the Minimalist Image Gallery block.
                                                                     *
                                                                     * @since  1.0.0
                                                                     * @return void
                                                                     */
function minimalist_register_image_gallery_block()
{
    // Register the block type
    register_block_type(
        'minimalist/image-gallery', array(
        'editor_script'   => 'minimalist-gallery-block-editor',
        'editor_style'    => 'minimalist-gallery-block-editor-style',
        'style'           => 'minimalist-gallery-block-style',
        'render_callback' => 'minimalist_render_gallery_block',
        'attributes'      => array(
            'images' => array(
                'type'    => 'array',
                'default' => array(),
            ),
            'columns' => array(
                'type'    => 'number',
                'default' => 3,
            ),
            'spacing' => array(
                'type'    => 'string',
                'default' => 'medium',
            ),
            'showCaptions' => array(
                'type'    => 'boolean',
                'default' => true,
            ),
         ),
        ) 
    );
}
add_action('init', 'minimalist_register_image_gallery_block');

/**
 * Render callback for the gallery block.
 *
 * @param  array $attributes Block attributes.
 * @return string
 */
function minimalist_render_gallery_block( $attributes )
{
    $images = isset($attributes['images']) ? $attributes['images'] : array();
    $columns = isset($attributes['columns']) ? intval($attributes['columns']) : 3;
    $spacing = isset($attributes['spacing']) ? sanitize_text_field($attributes['spacing']) : 'medium';
    $show_captions = isset($attributes['showCaptions']) ? (bool) $attributes['showCaptions'] : true;

    if (empty($images) ) {
        return '';
    }

    $output = '<div class="wp-block-minimalist-image-gallery gallery-columns-' . $columns . ' gallery-spacing-' . $spacing . '">';
    $output .= '<div class="gallery-grid" data-lightbox="gallery">';

    foreach ( $images as $index => $image ) {
        $image_id = isset($image['id']) ? intval($image['id']) : 0;
        $image_url = isset($image['url']) ? esc_url($image['url']) : '';
        $full_url = isset($image['fullUrl']) ? esc_url($image['fullUrl']) : $image_url;
        $alt = isset($image['alt']) ? esc_attr($image['alt']) : '';
        $caption = isset($image['caption']) ? esc_html($image['caption']) : '';

        if ($image_url ) {
            $output .= '<div class="gallery-item" data-id="' . $image_id . '" data-index="' . $index . '">';
            $output .= '<div class="gallery-image-container">';
            $output .= '<img src="' . $image_url . '" alt="' . $alt . '" data-full="' . $full_url . '" loading="lazy" />';
            $output .= '<div class="gallery-overlay"><span class="gallery-zoom-icon">🔍</span></div>';
            $output .= '</div>';
            
            if ($show_captions && $caption ) {
                $output .= '<div class="gallery-caption">' . $caption . '</div>';
            }
            
            $output .= '</div>';
        }
    }

    $output .= '</div></div>';

    return $output;
}

/**
 * Enqueue block editor assets.
 *
 * @since  1.0.0
 * @return void
 */
function minimalist_enqueue_gallery_block_assets()
{
    // Register and enqueue the block editor script
    wp_register_script(
        'minimalist-gallery-block-editor',
        get_template_directory_uri() . '/js/gallery-block-editor.js',
        array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n' ),
        '1.0.0',
        true
    );

    // Register and enqueue the block editor styles
    wp_register_style(
        'minimalist-gallery-block-editor-style',
        get_template_directory_uri() . '/blocks/image-gallery/editor.css',
        array( 'wp-edit-blocks' ),
        '1.0.0'
    );

    // Register and enqueue the block frontend styles
    wp_register_style(
        'minimalist-gallery-block-style',
        get_template_directory_uri() . '/blocks/image-gallery/style.css',
        array(),
        '1.0.0'
    );

    // Enqueue the lightbox script on frontend
    if (! is_admin() ) {
        wp_enqueue_script(
            'minimalist-gallery-lightbox',
            get_template_directory_uri() . '/blocks/image-gallery/view.js',
            array(),
            '1.0.0',
            true
        );
        
        wp_enqueue_style('minimalist-gallery-block-style');
    }
}
add_action('enqueue_block_editor_assets', 'minimalist_enqueue_gallery_block_assets');
add_action('wp_enqueue_scripts', 'minimalist_enqueue_gallery_block_assets');/**
                                                                             * Re
gister the Minimalist Image Gallery block.
                                                                             *
                                                                             * @since  1.0.0
                                                                             * @return void
                                                                             */
function minimalist_register_gallery_block()
{
    // Only register if we're in WordPress 5.0+
    if (! function_exists('register_block_type') ) {
        return;
    }

    // Enqueue block editor script
    wp_register_script(
        'minimalist-gallery-block',
        get_template_directory_uri() . '/js/gallery-block-editor.js',
        array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n' ),
        '1.0.0',
        true
    );

    // Enqueue block editor styles
    wp_register_style(
        'minimalist-gallery-block-editor',
        get_template_directory_uri() . '/blocks/image-gallery/editor.css',
        array( 'wp-edit-blocks' ),
        '1.0.0'
    );

    // Enqueue block frontend styles
    wp_register_style(
        'minimalist-gallery-block-style',
        get_template_directory_uri() . '/blocks/image-gallery/style.css',
        array(),
        '1.0.0'
    );

    // Register the block
    register_block_type(
        'minimalist/image-gallery', array(
        'editor_script' => 'minimalist-gallery-block',
        'editor_style'  => 'minimalist-gallery-block-editor',
        'style'         => 'minimalist-gallery-block-style',
        ) 
    );
}
add_action('init', 'minimalist_register_gallery_block');

/**
 * Enqueue frontend gallery assets.
 *
 * @since  1.0.0
 * @return void
 */
function minimalist_enqueue_gallery_frontend()
{
    if (! is_admin() ) {
        wp_enqueue_style(
            'minimalist-gallery-style',
            get_template_directory_uri() . '/blocks/image-gallery/style.css',
            array(),
            '1.0.0'
        );
        
        wp_enqueue_script(
            'minimalist-gallery-lightbox',
            get_template_directory_uri() . '/blocks/image-gallery/view.js',
            array(),
            '1.0.0',
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'minimalist_enqueue_gallery_frontend');/**
                                                                         * Debug function to check if block is registered.
                                                                         *
                                                                         * @since  1.0.0
                                                                         * @return void
                                                                         */
function minimalist_debug_blocks()
{
    if (current_user_can('manage_options') && isset($_GET['debug_blocks']) ) {
        $registered_blocks = WP_Block_Type_Registry::get_instance()->get_all_registered();
        echo '<pre>';
        echo "Registered blocks:\n";
        foreach ( $registered_blocks as $name => $block ) {
            echo "- $name\n";
        }
        echo "\nMinimalist gallery block registered: ";
        echo isset($registered_blocks['minimalist/image-gallery']) ? 'YES' : 'NO';
        echo '</pre>';
        exit;
    }
}
add_action('init', 'minimalist_debug_blocks', 999);
