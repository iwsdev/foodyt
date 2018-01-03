<?php
/**
 * Twenty Seventeen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 */
/**
 * Twenty Seventeen only works in WordPress 4.7 or later.
 */
if (version_compare($GLOBALS['wp_version'], '4.7-alpha', '<')) {
    require get_template_directory() . '/inc/back-compat.php';
    return;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function twentyseventeen_setup() {
    /*
     * Make theme available for translation.
     * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/twentyseventeen
     * If you're building a theme based on Twenty Seventeen, use a find and replace
     * to change 'twentyseventeen' to the name of your theme in all the template files.
     */
    load_theme_textdomain('twentyseventeen');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support('title-tag');

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');
    add_image_size( 'dish-img', 350, 350, true);


    add_image_size('twentyseventeen-featured-image', 2000, 1200, true);

    add_image_size('twentyseventeen-thumbnail-avatar', 100, 100, true);

    // Set the default content width.
    $GLOBALS['content_width'] = 525;

    // This theme uses wp_nav_menu() in two locations.
    register_nav_menus(array(
        'top' => __('Top Menu', 'twentyseventeen'),
        'social' => __('Social Links Menu', 'twentyseventeen'),
        'primary' => __('Primary Menu', 'twentyseventeen'),
        'footer' => __('Footer Menu', 'twentyseventeen'),
    ));

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support('html5', array(
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    /*
     * Enable support for Post Formats.
     *
     * See: https://codex.wordpress.org/Post_Formats
     */
    add_theme_support('post-formats', array(
        'aside',
        'image',
        'video',
        'quote',
        'link',
        'gallery',
        'audio',
    ));

    // Add theme support for Custom Logo.
    add_theme_support('custom-logo', array(
        'width' => 250,
        'height' => 250,
        'flex-width' => true,
    ));

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    /*
     * This theme styles the visual editor to resemble the theme style,
     * specifically font, colors, and column width.
     */
    add_editor_style(array('assets/css/editor-style.css', twentyseventeen_fonts_url()));

    // Define and register starter content to showcase the theme on new sites.
    $starter_content = array(
        'widgets' => array(
            // Place three core-defined widgets in the sidebar area.
            'sidebar-1' => array(
                'text_business_info',
                'search',
                'text_about',
            ),
            // Add the core-defined business info widget to the footer 1 area.
            'sidebar-2' => array(
                'text_business_info',
            ),
            // Put two core-defined widgets in the footer 2 area.
            'sidebar-3' => array(
                'text_about',
                'search',
            ),
        ),
        // Specify the core-defined pages to create and add custom thumbnails to some of them.
        'posts' => array(
            'home',
            'about' => array(
                'thumbnail' => '{{image-sandwich}}',
            ),
            'contact' => array(
                'thumbnail' => '{{image-espresso}}',
            ),
            'blog' => array(
                'thumbnail' => '{{image-coffee}}',
            ),
            'homepage-section' => array(
                'thumbnail' => '{{image-espresso}}',
            ),
        ),
        // Create the custom image attachments used as post thumbnails for pages.
        'attachments' => array(
            'image-espresso' => array(
                'post_title' => _x('Espresso', 'Theme starter content', 'twentyseventeen'),
                'file' => 'assets/images/espresso.jpg', // URL relative to the template directory.
            ),
            'image-sandwich' => array(
                'post_title' => _x('Sandwich', 'Theme starter content', 'twentyseventeen'),
                'file' => 'assets/images/sandwich.jpg',
            ),
            'image-coffee' => array(
                'post_title' => _x('Coffee', 'Theme starter content', 'twentyseventeen'),
                'file' => 'assets/images/coffee.jpg',
            ),
        ),
        // Default to a static front page and assign the front and posts pages.
        'options' => array(
            'show_on_front' => 'page',
            'page_on_front' => '{{home}}',
            'page_for_posts' => '{{blog}}',
        ),
        // Set the front page section theme mods to the IDs of the core-registered pages.
        'theme_mods' => array(
            'panel_1' => '{{homepage-section}}',
            'panel_2' => '{{about}}',
            'panel_3' => '{{blog}}',
            'panel_4' => '{{contact}}',
        ),
        // Set up nav menus for each of the two areas registered in the theme.
        'nav_menus' => array(
            // Assign a menu to the "top" location.
            'top' => array(
                'name' => __('Top Menu', 'twentyseventeen'),
                'items' => array(
                    'link_home', // Note that the core "home" page is actually a link in case a static front page is not used.
                    'page_about',
                    'page_blog',
                    'page_contact',
                ),
            ),
            // Assign a menu to the "social" location.
            'social' => array(
                'name' => __('Social Links Menu', 'twentyseventeen'),
                'items' => array(
                    'link_yelp',
                    'link_facebook',
                    'link_twitter',
                    'link_instagram',
                    'link_email',
                ),
            ),
        ),
    );

    /**
     * Filters Twenty Seventeen array of starter content.
     *
     * @since Twenty Seventeen 1.1
     *
     * @param array $starter_content Array of starter content.
     */
    $starter_content = apply_filters('twentyseventeen_starter_content', $starter_content);

    add_theme_support('starter-content', $starter_content);
}

add_action('after_setup_theme', 'twentyseventeen_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function twentyseventeen_content_width() {

    $content_width = $GLOBALS['content_width'];

    // Get layout.
    $page_layout = get_theme_mod('page_layout');

    // Check if layout is one column.
    if ('one-column' === $page_layout) {
        if (twentyseventeen_is_frontpage()) {
            $content_width = 644;
        } elseif (is_page()) {
            $content_width = 740;
        }
    }

    // Check if is single post and there is no sidebar.
    if (is_single() && !is_active_sidebar('sidebar-1')) {
        $content_width = 740;
    }

    /**
     * Filter Twenty Seventeen content width of the theme.
     *
     * @since Twenty Seventeen 1.0
     *
     * @param $content_width integer
     */
    $GLOBALS['content_width'] = apply_filters('twentyseventeen_content_width', $content_width);
}

add_action('template_redirect', 'twentyseventeen_content_width', 0);

/**
 * Register custom fonts.
 */
function twentyseventeen_fonts_url() {
    $fonts_url = '';

    /**
     * Translators: If there are characters in your language that are not
     * supported by Libre Franklin, translate this to 'off'. Do not translate
     * into your own language.
     */
    $libre_franklin = _x('on', 'Libre Franklin font: on or off', 'twentyseventeen');

    if ('off' !== $libre_franklin) {
        $font_families = array();

        $font_families[] = 'Libre Franklin:300,300i,400,400i,600,600i,800,800i';

        $query_args = array(
            'family' => urlencode(implode('|', $font_families)),
            'subset' => urlencode('latin,latin-ext'),
        );

        $fonts_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');
    }

    return esc_url_raw($fonts_url);
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function twentyseventeen_resource_hints($urls, $relation_type) {
    if (wp_style_is('twentyseventeen-fonts', 'queue') && 'preconnect' === $relation_type) {
        $urls[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin',
        );
    }

    return $urls;
}

add_filter('wp_resource_hints', 'twentyseventeen_resource_hints', 10, 2);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function twentyseventeen_widgets_init() {
    register_sidebar(array(
        'name' => __('Social Icons', 'twentyseventeen'),
        'id' => 'social-list',
        'description' => __('', 'twentyseventeen'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
    register_sidebar(array(
        'name' => __('Copyright Spnish', 'twentyseventeen'),
        'id' => 'copyright_spanish',
        'description' => __('', 'twentyseventeen'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
     register_sidebar(array(
        'name' => __('Copyright English', 'twentyseventeen'),
        'id' => 'copyright_english',
        'description' => __('', 'twentyseventeen'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));

    register_sidebar(array(
        'name' => __('Footer 2', 'twentyseventeen'),
        'id' => 'sidebar-3',
        'description' => __('Add widgets here to appear in your footer.', 'twentyseventeen'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
      register_sidebar(array(
        'name' => __('For the Diner Spanish', 'twentyseventeen'),
        'id' => 'for-the-diner-spanish',
        'description' => __('Add widgets here to appear in your footer.', 'twentyseventeen'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

      register_sidebar(array(
        'name' => __('For the Restaurant Spanish', 'twentyseventeen'),
        'id' => 'For-the-restaurant-spanish',
        'description' => __('Add widgets here to appear in your footer.', 'twentyseventeen'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

      register_sidebar(array(
        'name' => __('For the Diner English', 'twentyseventeen'),
        'id' => 'for-the-diner-english',
        'description' => __('Add widgets here to appear in your footer.', 'twentyseventeen'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

      register_sidebar(array(
        'name' => __('For the Restaurant English', 'twentyseventeen'),
        'id' => 'For-the-restaurant-english',
        'description' => __('Add widgets here to appear in your footer.', 'twentyseventeen'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

}

add_action('widgets_init', 'twentyseventeen_widgets_init');

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @since Twenty Seventeen 1.0
 *
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function twentyseventeen_excerpt_more($link) {
    if (is_admin()) {
        return $link;
    }

    $link = sprintf('<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>', esc_url(get_permalink(get_the_ID())),
            /* translators: %s: Name of current post */ sprintf(__('Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen'), get_the_title(get_the_ID()))
    );
    return ' &hellip; ' . $link;
}

add_filter('excerpt_more', 'twentyseventeen_excerpt_more');

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Seventeen 1.0
 */
function twentyseventeen_javascript_detection() {
    echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}

add_action('wp_head', 'twentyseventeen_javascript_detection', 0);

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function twentyseventeen_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">' . "\n", get_bloginfo('pingback_url'));
    }
}

add_action('wp_head', 'twentyseventeen_pingback_header');

/**
 * Display custom color CSS.
 */
function twentyseventeen_colors_css_wrap() {
    if ('custom' !== get_theme_mod('colorscheme') && !is_customize_preview()) {
        return;
    }

    require_once( get_parent_theme_file_path('/inc/color-patterns.php') );
    $hue = absint(get_theme_mod('colorscheme_hue', 250));
    ?>
    <style type="text/css" id="custom-theme-colors" <?php
           if (is_customize_preview()) {
               echo 'data-hue="' . $hue . '"';
           }
           ?>>
               <?php echo twentyseventeen_custom_colors_css(); ?>
    </style>
    <?php
}

add_action('wp_head', 'twentyseventeen_colors_css_wrap');

/**
 * Enqueue scripts and styles.
 */
function twentyseventeen_scripts() {
    // Add custom fonts, used in the main stylesheet.
    wp_enqueue_style('twentyseventeen-fonts', twentyseventeen_fonts_url(), array(), null);

    // Theme stylesheet.
    wp_enqueue_style('twentyseventeen-style', get_stylesheet_uri());

    wp_enqueue_style('responsive', get_theme_file_uri('/assets/css/responsive.css'), array('twentyseventeen-style'), '1.0');

    // Load the dark colorscheme.
    if ('dark' === get_theme_mod('colorscheme', 'light') || is_customize_preview()) {
        wp_enqueue_style('twentyseventeen-colors-dark', get_theme_file_uri('/assets/css/colors-dark.css'), array('twentyseventeen-style'), '1.0');
    }

    // Load the Internet Explorer 9 specific stylesheet, to fix display issues in the Customizer.
    if (is_customize_preview()) {
        wp_enqueue_style('twentyseventeen-ie9', get_theme_file_uri('/assets/css/ie9.css'), array('twentyseventeen-style'), '1.0');
        wp_style_add_data('twentyseventeen-ie9', 'conditional', 'IE 9');
    }

    // Load the Internet Explorer 8 specific stylesheet.
    wp_enqueue_style('twentyseventeen-ie8', get_theme_file_uri('/aCustomer Profilessets/css/ie8.css'), array('twentyseventeen-style'), '1.0');
    wp_style_add_data('twentyseventeen-ie8', 'conditional', 'lt IE 9');

    // Load the html5 shiv.
    wp_enqueue_script('html5', get_theme_file_uri('/assets/js/html5.js'), array(), '3.7.3');
    wp_script_add_data('html5', 'conditional', 'lt IE 9');

    wp_enqueue_script('twentyseventeen-skip-link-focus-fix', get_theme_file_uri('/assets/js/skip-link-focus-fix.js'), array(), '1.0', true);

    $twentyseventeen_l10n = array(
        'quote' => twentyseventeen_get_svg(array('icon' => 'quote-Customer Profileright')),
    );

    if (has_nav_menu('top')) {
        wp_enqueue_script('twentyseventeen-navigation', get_theme_file_uri('/assets/js/navigation.js'), array(), '1.0', true);
        $twentyseventeen_l10n['expand'] = __('Expand child menu', 'twentyseventeen');
        $twentyseventeen_l10n['collapse'] = __('Collapse child menu', 'twentyseventeen');
        $twentyseventeen_l10n['icon'] = twentyseventeen_get_svg(array('icon' => 'angle-down', 'fallback' => true));
    }

    wp_enqueue_script('twentyseventeen-global', get_theme_file_uri('/assets/js/global.js'), array('jquery'), '1.0', true);

    wp_enqueue_script('jquery-scrollto', get_theme_file_uri('/assets/js/jquery.scrollTo.js'), array('jquery'), '2.1.2', true);

    wp_localize_script('twentyseventeen-skip-link-focus-fix', 'twentyseventeenScreenReaderText', $twentyseventeen_l10n);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'twentyseventeen_scripts');

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function twentyseventeen_content_image_sizes_attr($sizes, $size) {
    $width = $size[0];

    if (740 <= $width) {
        $sizes = '(max-width: 706px) 89vw, (max-width: 767px) 82vw, 740px';
    }

    if (is_active_sidebar('sidebar-1') || is_archive() || is_search() || is_home() || is_page()) {
        if (!( is_page() && 'one-column' === get_theme_mod('page_options') ) && 767 <= $width) {
            $sizes = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
        }
    }

    return $sizes;
}

add_filter('wp_calculate_image_sizes', 'twentyseventeen_content_image_sizes_attr', 10, 2);

/**
 * Filter the `sizes` value in the header image markup.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $html   The HTML image tag markup being filtered.
 * @param object $header The custom header object returned by 'get_custom_header()'.
 * @param array  $attr   Array of the attributes for the image tag.
 * @return string The filtered header image HTML.
 */
function twentyseventeen_header_image_tag($html, $header, $attr) {
    if (isset($attr['sizes'])) {
        $html = str_replace($attr['sizes'], '100vw', $html);
    }
    return $html;
}

add_filter('get_header_image_tag', 'twentyseventeen_header_image_tag', 10, 3);

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array $attr       Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size       Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function twentyseventeen_post_thumbnail_sizes_attr($attr, $attachment, $size) {
    if (is_archive() || is_search() || is_home()) {
        $attr['sizes'] = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
    } else {
        $attr['sizes'] = '100vw';
    }

    return $attr;
}

add_filter('wp_get_attachment_image_attributes', 'twentyseventeen_post_thumbnail_sizes_attr', 10, 3);

/**
 * Use front-page.php when Front page displays is set to a static page.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $template front-page.php.
 *
 * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
 */
function twentyseventeen_front_page_template($template) {
    return is_home() ? '' : $template;
}

add_filter('frontpage_template', 'twentyseventeen_front_page_template');

/**
 * Implement the Custom Header feature.
 */
require get_parent_theme_file_path('/inc/custom-header.php');

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path('/inc/template-tags.php');

/**
 * Additional features to allow styling of the templates.
 */
require get_parent_theme_file_path('/inc/template-functions.php');

/**
 * Customizer additions.
 */
require get_parent_theme_file_path('/inc/customizer.php');

/**
 * SVG icons functions and filters.
 */
require get_parent_theme_file_path('/inc/icon-functions.php');

function register_my_menus_english() {
  register_nav_menus(
    array(
      'header-menu-english' => __( 'Header Menu' ),
      'footer-menu-english' => __( 'Footer Menu' ),
      'sidebar-menu-english' => __( 'Sidebar Menu' ),
      'sidebar-report-menu-english' => __( 'Sidebar Report Menu' ),
    )
  );
}
add_action( 'init', 'register_my_menus_english' );


function insert_attachment($file_handler, $post_id, $setthumb = 'false') {
    // check to make sure its a successful upload
    if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK)
        __return_false();

    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');

    $attach_id = media_handle_upload($file_handler, $post_id);

    if ($setthumb)
        update_post_meta($post_id, '_thumbnail_id', $attach_id);
    return $attach_id;
}

add_action('wp_login_failed', 'pippin_login_fail');  // hook failed login

function pippin_login_fail($username) {
    $referrer = $_SERVER['HTTP_REFERER'];  // where did the post submission come from?
    // if there's a valid referrer, and it's not the default log-in screen
    if (!empty($referrer) && !strstr($referrer, 'wp-login') && !strstr($referrer, 'wp-admin')) {
        wp_redirect(home_url() . '/login/?login=failed');  // let's append some information (login=failed) to the URL for the theme to use

        exit;
    }
}

//multiplefile
function reArrayFiles(&$file_post) {

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i = 0; $i < $file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}

function getMenuStatus($obj, $statusid) {
    global $wpdb;
    $menu_status_table = $wpdb->prefix."menu_status";
    $query = "SELECT `status` FROM $menu_status_table WHERE id=" . $statusid;
   $menuArr = $obj->get_results($query);
   return $menuArr[0]->status;
}

function register_my_menus() {
    register_nav_menus(
            array(
                'sidebar-menu' => __('Sidebar Menu'),
                'sidebar-report-menu' => __('Sidebar Report Menu'),
            )
    );
}
add_action('init', 'register_my_menus');

//menu form validation
function menuformvalidation(array $postdata) {
    $return = TRUE;
    foreach ($postdata as $value) {
        if (!$return)
            continue;
        if ($value['menuname'] == '') {
            $return = FALSE;
        }
    }
    return $return;
}

function checkSelected($str, $match) {
    $return = '';
    if (strpos($str, ',') !== FALSE) {
        $str = explode(',', $str);
        $return = (in_array($match, $str)) ? 'checked="checked"' : '';
    } else {
        $return = ($str == $match) ? 'checked="checked"' : '';
    }
    return $return;
}

function checkSelectedbool($str, $match) {
    $return = FALSE;
    if (strpos($str, ',') !== FALSE) {
        $str = explode(',', $str);
        $return = (in_array($match, $str)) ? TRUE : FALSE;
    } else {
        $return = ($str == $match) ? TRUE : FALSE;
    }
    return $return;
}

/* Disable WordPress Admin Bar for all users but admins. */
show_admin_bar(false);
add_filter('wp_mail_from', 'new_mail_from');
add_filter('wp_mail_from_name', 'new_mail_from_name');

function new_mail_from($old) {
    return 'foodyT@gmail.com';
}

function new_mail_from_name($old) {
    return 'foodyT';
}
    

add_action( 'init', 'my_script_enqueuer' );

function my_script_enqueuer()
   {
   
   wp_enqueue_script( 'my_voter_script', get_template_directory_uri() . '/js/my-ajax-script.js', array('jquery') );
   wp_localize_script( 'my_voter_script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        
   wp_enqueue_script( 'jquery' );
   wp_enqueue_script( 'my_voter_script' );
    }

/* view dish */

add_action("wp_ajax_viewdish", "viewdish");
add_action('wp_ajax_nopriv_viewdish', 'viewdish' );
function viewdish()
 {
        global $wpdb;
        $prevUrl = wp_get_referer();
        $dishid = $_REQUEST['dishid'];
        $tablename=$wpdb->prefix.'viewdish';
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER))
        {
            $ipAddress = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
        }
        if ( is_user_logged_in() )
        {
             $visitorid =get_current_user_id();
        }
        else
        {
            $visitorid =0;
        }
        $Addedon = date('Y-m-d H:i:s');
        $datavisitor=array('ip' =>$ipAddress,'userid' =>$visitorid,'dishid' =>$dishid,'referer' =>$prevUrl,'Addedon' =>$Addedon);
        $wpdb->insert( $tablename, $datavisitor);
  die;

}

    add_action("wp_ajax_emailIdTest", "emailIdTest");
    add_action('wp_ajax_nopriv_emailIdTest', 'emailIdTest' );
    function emailIdTest() {
        $exists = email_exists($_REQUEST['email']);
        echo $exists;
        die;

    }

    add_action("wp_ajax_dragDropOrder", "dragDropOrder");
    add_action('wp_ajax_nopriv_dragDropOrder', 'dragDropOrder' );
    function dragDropOrder() {
       global $wpdb;
       $menu_detail_table = $wpdb->prefix."menu_categories";
       $orderArray = $_REQUEST['orderArr'];
        foreach($orderArray as $key=>$val){
            $wpdb->update( 
                    $menu_detail_table, 
                    array( 
                        'cat_order' => $key	// integer (number) 
                    ), 
                    array( 'id' => $val ), 
                    array( 
                        '%d'	// value2
                    ), 
                    array( '%d') 
                );
        }
       die;
    }

    add_action("wp_ajax_twitCount", "twitCount");
    add_action('wp_ajax_nopriv_twitCount', 'twitCount' );
    function twitCount()
    {
        global $wpdb;
        $menu_detailsTable = $wpdb->prefix."menu_details";
        $dishid = $_REQUEST['dishId'];
        $tablename=$wpdb->prefix.'socialshare';
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER))
        {
            $ipAddress = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
        }
        if ( is_user_logged_in() )
        {
             $visitorid =get_current_user_id();
        }
        else
        {
            $visitorid =0;
        }
        $Addedon = date('Y-m-d H:i:s');
        $share_type='twitter';
        $datavisitor=array('ip' =>$ipAddress,'visitorid' =>$visitorid,'dishId' =>$dishid,'share_type'=>$share_type,'Addedon' =>$Addedon);
        $wpdb->insert( $tablename, $datavisitor);
        
        
        $dishInfo = $wpdb->get_row("SELECT * FROM $menu_detailsTable WHERE id = $dishid");
        $twitCount= $dishInfo->twitter_count+1;
        $wpdb->update( 
            $menu_detailsTable, 
            array( 
                'twitter_count' => $twitCount   // integer (number) 
            ), 
            array( 'id' =>  $dishid), 
            array( 
                '%d',   // value1
            ), 
            array( '%d' ) 
       );
        
       die;

    }

    add_action("wp_ajax_fbCount", "fbCount");
    add_action('wp_ajax_nopriv_fbCount', 'fbCount' );
    function fbCount() {
        global $wpdb;
       
        $menu_detailsTable = $wpdb->prefix."menu_details";
        $dishid = $_REQUEST['dishId'];
        $tablename=$wpdb->prefix.'socialshare';
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER))
        {
            $ipAddress = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
        }
        if ( is_user_logged_in() )
        {
             $visitorid =get_current_user_id();
        }
        else
        {
            $visitorid =0;
        }
        $Addedon = date('Y-m-d H:i:s');
        $share_type='facebook';
        $datavisitor=array('ip' =>$ipAddress,'visitorid' =>$visitorid,'dishId' =>$dishid,'share_type'=>$share_type,'Addedon' =>$Addedon);
        $wpdb->insert( $tablename, $datavisitor);
        
        
        $dishInfo = $wpdb->get_row("SELECT * FROM $menu_detailsTable WHERE id = $dishid");
        $fbCount= $dishInfo->fb_count+1;
        $wpdb->update( 
            $menu_detailsTable, 
            array( 
                'fb_count' => $fbCount   // integer (number) 
            ), 
            array( 'id' =>  $dishid), 
            array( 
                '%d',   // value1
            ), 
            array( '%d' ) 
       );
        
       die;

    }

    add_action("wp_ajax_whatsupCount", "whatsupCount");
    add_action('wp_ajax_nopriv_whatsupCount', 'whatsupCount' );
    function whatsupCount() {
       global $wpdb;
        
        $menu_detailsTable = $wpdb->prefix."menu_details";
        $dishid = $_REQUEST['dishId'];
        $tablename=$wpdb->prefix.'socialshare';
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER))
        {
            $ipAddress = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
        }
        if ( is_user_logged_in() )
        {
             $visitorid =get_current_user_id();
        }
        else
        {
            $visitorid =0;
        }
        $Addedon = date('Y-m-d H:i:s');
        $share_type='whatsapp';
        $datavisitor=array('ip' =>$ipAddress,'visitorid' =>$visitorid,'dishId' =>$dishid,'share_type'=>$share_type,'Addedon' =>$Addedon);
        $wpdb->insert( $tablename, $datavisitor);
        
        
        $dishInfo = $wpdb->get_row("SELECT * FROM $menu_detailsTable WHERE id = $dishid");
        $whats_up_count= $dishInfo->whats_up_count+1;
        $wpdb->update( 
            $menu_detailsTable, 
            array( 
                'whats_up_count' => $whats_up_count   // integer (number) 
            ), 
            array( 'id' =>  $dishid), 
            array( 
                '%d',   // value1
            ), 
            array( '%d' ) 
       );
        
       die;

    }


    add_action("wp_ajax_rating_form", "rating_form");
    add_action('wp_ajax_nopriv_rating_form', 'rating_form' );
    function rating_form() {
		global $wpdb;
		session_start();
		
		 // unset($_SESSION['facebook_access_token']); // will delete just the name data
          $commentTable = $wpdb->prefix."comments";
         
          $ipAddress = $_SERVER['REMOTE_ADDR'];        
          if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER))    
              {
              $ipAddress = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
               }
        
              $commentSucess = $wpdb->insert( 
              $commentTable, 
                array( 
                    'comment_title' => $_REQUEST['comment_title'], 
                    'comment_content' => $_REQUEST['comment_description'] ,
                    'dish_id' => $_REQUEST['dish_id'] ,
                    'rating' => $_REQUEST['star'] ,
                    'comment_approved' => 0,
                    'language_code' => $_REQUEST['language_code'] ,
                    'comment_post_ID' => $_REQUEST['in_response'] ,
                    'comment_author' => $_REQUEST['name'], 
                    'comment_author_email' => $_REQUEST['email'], 
                    'comment_author_IP' => $ipAddress, 
                    'user_id' => $_REQUEST['userid'],
                    'created_date' => date("Y-m-d h:i:s")
                ), 
                array( 
                    '%s', 
                    '%s',
                    '%d',
                    '%d',
                    '%d',
                    '%s',
                    '%d',
                    '%s',
                    '%s',
                    '%s',
                    '%d',
                    '%s'
                ) 
            );

        //unset($_SESSION['insertuser_id']);
       // unset($_SESSION['first_name']);
        //unset($_SESSION['email']);
      die;
    }
    add_action("wp_ajax_update_plan", "update_plan");
    add_action('wp_ajax_nopriv_update_plan', 'update_plan' );
    function update_plan() {
          $userid=$_REQUEST['userId'];
          global $wpdb;
          $payment_table = $wpdb->prefix."payment";
          $restaurant_info_table = $wpdb->prefix."restaurant_infos";

          $res = $wpdb->get_row("SELECT subscription_id,restaurant_id FROM $payment_table where user_id = $userid AND payment_by=1 AND cancel_sub=0 ORDER BY id DESC LIMIT 1",ARRAY_A);
          $subId = $res['subscription_id'];
          $restaurant_id = $res['restaurant_id'];
              //$subId = "sub_BYoYiupVUgjxBO";
                require_once('stripe/init.php');
                stripeCredential();
                if($res){
				$subscription = \Stripe\Subscription::retrieve($subId);
				$subscription->cancel();
                $wpdb->update( 
                $payment_table, 
                array( 
                    'cancel_sub' => 1
                 ), 
                array( 'user_id' => $userid ), 
                array( 
                    '%d' 	
                ),
             array( '%d' ) 
             );
			   
                    
                }
               update_user_meta($userid,'ja_disable_user',1);
               $title = get_the_title($restaurant_id);

                $user_info = get_userdata($userid);
                $username = $user_info->user_login;
                $useremail = $user_info->user_email;
                $admin_email = get_option( 'admin_email' );
                $to =$useremail;
                $subjects = "Subscription cancel";
                $headers = "From: " . strip_tags($admin_email) . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                $messages="<html><body>
                        Dear $title,
                        <p>Your subscription plan has been cancelled.
                        </p>
                        <p style='margin:1px;'>Best Regards,</p>
                        FoodyT Team
    
               </body>
               </html>  
              ";
                mail($to,$subjects,$messages,$headers);

                $user_info = get_userdata($userid);
                $username = $user_info->user_login;
                $useremail = get_option( 'admin_email' );
                $admin_email = get_option( 'admin_email' );
                $to =$useremail;
                $subjects = "Subscription cancel";
                $headers = "From: " . strip_tags($admin_email) . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                $messages="<html><body>
                        Dear admin,
                        <p>$username has cancelled subscription plan.
                        </p>
                        <p style='margin:1px;'>Best Regards,</p>
                        FoodyT Team
    
               </body>
               </html>  
              ";
                  mail($to,$subjects,$messages,$headers);
                  wp_logout(); 
                  
             die();
    }
 
/** Start Removed custom post_type slug from posts url**/
function custom_parse_request_tricksy( $query ) {

    // Only noop the main query
    if ( ! $query->is_main_query() )
        return;

    // Only noop our very specific rewrite rule match
    if ( 2 != count( $query->query ) || ! isset( $query->query['page'] ) ) {
        return;
    }

    // 'name' will be set if post permalinks are just post_name, otherwise the page rule will match
    if ( ! empty( $query->query['name'] ) ) {
        $query->set( 'post_type', array( 'restaurant','post','page') );
    }
}
add_action( 'pre_get_posts', 'custom_parse_request_tricksy' );
 function custom_remove_cpt_slug( $post_link, $post, $leavename ) {

    if ( 'restaurant' != $post->post_type  || 'publish' != $post->post_status ) {
        return $post_link;
    }

    $post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );

    return $post_link;
}
add_filter( 'post_type_link', 'custom_remove_cpt_slug', 10, 3 );

    add_action("wp_ajax_change_language", "change_language");
    add_action('wp_ajax_nopriv_change_language', 'change_language' );
    function change_language() {
        session_start();
        $_SESSION['lanCode'] = $_REQUEST['lang'];
        unset($_SESSION['catId']); // will delete just the catId data
        //echo "session unset";
            
    }

    add_action("wp_ajax_setCatId", "setCatId");
    add_action('wp_ajax_nopriv_setCatId', 'setCatId' );
    function setCatId() {
        session_start();
       $_SESSION['catId'] = $_REQUEST['catId'];    
    }



function getArrayOfContent()
{
 $languageContent = array( 
    "en" => array (
       'home' => array('location'=>'Search Restaurant by Location','name'=>'Search  Restaurant by Name','cuisine'=>'Search Restaurant by Cuisine'),
       "restaurant_name" => "Restaurant's Name",
       "restaurant_description" => "Restaurant's Description",
       "address" => "Address",
       "address_placeholder" => "Enter your Address",
       "languageText" => "Language",
       "languageList" => array('Spanish','English','French','Italian','Japanese'),
       "yes_i_want" => "Yes, I want this",
       "additional_each" => "Additional each from the second language",

       'beacon' => array('0'=>'Beacon','1'=>"Beacons are awesome little high-tech tools,and we're excited to tell you all about them!",'2'=>"So,what is a beacon?"),
       'monthly_report' => array('0'=>'Monthly Report','1'=>'Would you like to receive a monthly report with your digital menu traffic? We will show you how your customer surf by the web, all their favourite dishes and much more information. Analize and improve!'),
       'photograph' => array('0'=>'Photographs by foodyt team','1'=>'Photographs for your Digital Menu will be done by a professional photographer of Foodyt team, who will contact you to meet.'),
       'lang_added' => "languages added",
       'addition' => 'Additional',
       'banner_img' => 'Banner Image',
       'kind_cuision' => 'Kind of Cuisine',
       'create_now' => "CREATE NOW",
       'account_info' => "Account Information",
       'mobile_no' => "Mobile Number",
       'mobile_placeholder' => "Enter your Mobile number",
       'payment_method' => "Payment Method",
       'card_no' => "Card Number",
       'card_holder' => "Cardholder Name",
       'card_holder_placeholder' => "Enter your card holder name",
       'expiry' => "Expiry",
       'cvv' => "CVV",
       'billing_add' => "Billing Address",
       'city' => "City",
       'state' => "State",
       'postal' => "Postal Code",
       'order_summary' => 'Order Summary',
       'basic' => 'Basic',
       'month' => "Month",
       'download' => "Download",
       'back' => "Back",
       'error_registration' => array('restaurant_name'=>'Please enter your Restaurant Name.','restaurant_des'=>'Please enter your Restaurant Description.','email'=>'Please enter your email.','address'=>'Please enter your Address.','logo_img'=>'Please upload logo image.','banner_img'=>'Please upload banner image.','select_cuisine'=>'Please select any kind of Cuisine.','mobile_no'=>'Enter your mobile no','card'=>'Please Enter your valid card number','cardHolderName' => "Please enter card holder name ",'cvv'=>'Please enter three digit cvv number','billing_address' => "Please enter your Billing Address",'city'=> "Please enter your city",'state' => "Please enter your state",'postal'=>'Please Enter valid postal code','valid_img' => "Please select valid image type.",'email_exit' => "The provided Email Id already exists. Please use different one to create the account",'emailExit' => "Email id already exit."),
       'prev_img' => "npa.jpg",
       'place_order' => "Place Order",
       'help'=> array('Frequent Questions','Hello, how can we help you?'),
       'login' => array('username' => "Username",'password' => "Password",'remember' => "Remember Me",'forget_pass' => "Forgot Your Password",'forget_msg' => "Please enter your username or email address. You will receive a link to create a new password via email",'username_email' => "Username or Email Address",'get_new_pass' => "Get New Password",'error' => "Your User name and Password is incorrect."),
       'my_account' => "My Account",
       'update_plan' => 'UPDATE PLAN',
       'cancel_sub' =>"CANCEL SUBSCRIPTION",
       'cancel_sub_msg' => "Your subscription plan has been successfully cancelled",
       'u_will_logout' => "You will be logout shortly.",
       'current_plan' => "Current Plan",
       'edit_res_profile' => "Edit Restaurant Profile",
       'update' => "UPDATE",
       'manage_res_menu' => "Manage Restaurant Menu",
        'manage_cat_menu' => "Manage Category Menu",
       'add_dish' => "Add Dish",
       'edit' => "Edit",
       'remove' => "Remove",
       'approve' => "Approved",
       'review' => "In Review",
       'reject' => "Rejected",
       'not_add_menu' => "You have not added any menu!..",
       'prev' => "Prev",
       'next' => "Next",
       'preview' => "Preview",
       'dish_page' => array('dish' => "Dish",'category' => "Category",'categories' => "Categories",'add_category' => "Add Category",'cat_menu' => "Category Menu",'saveandclose' => "Save & Close" ,'select_cat' => "Please select a category",'no_option_avila' => "No option available", 'dish_name' => "Name", 'note' => "Note if you want images to be taken by a FoodyT professional please update your plan.",'short_des' => "Short Description",'price' => "Price",'size_optional' => "Size (Optional)",'u_can_create' => "You can create size options for this menu product ex.small, medium and large.",'title_size' => "Size Title",'add_another' => "ADD ANOTHER",'allergen' => "Allergens",'sub_dish' => "SUBMIT DISH",'submitbtn' => "SUBMIT",'dish_succ' => "Dish has been created successfully.",'form_sub_error'=>"Form can not be submitted as blank or without filled required fields.",'img_prev' =>'no-image-available-en.png','success' => "Success",'dish_form_added' => "A new dish form has been added",'img_req' => "Image File Required!",'success' => "Successfully saved!",'manageCat' =>"Manage Category Menu"),
       'login_credential' => array('manage_credential' => "Manage Login Credentials" ,'reset_pass' => "Reset Your Password",'current_pass' => "Current Password",'new_pass' => "New Password ",'confirm_new_pass' => "Confirm New Password",'submit'=>"SUBMIT",'error' => "Your current password is wrong."),
       'notification' => array("Attention","Your account will expire in 2 days. Please update your plan to continue enjoying Foodyt.","Click here"),
       'search_list' => array('search_result' => "Search Results",'sortby' => "Sort By",'ascTodes' => "Ascending to Descending",'within' => "Within",'mile' => "Miles",'descToasc' => "Descending to Ascending",'recently' => "Recently Added",'location' => "Location",'cuisine' => "Cuisine",'select_cuision' => "Select a cuisine",'seeall' => "See all Cuisines",'no_result' => "No Result Found!"),
       'reg_mail_client' => array("Registration mail","Dear","Your registration is successfull at FoodyT Team" ,"Your account & details are under review and you will be notified once they are approved from the admin."),
       'reg_mail_admin' => array('admin' => "admin",'added' => "A new  Restaurant has been registered on the website using below details" ,'user_name' => "User Name",'res_name' => "Restaurant Name",'res_des' => "Restaurant Description",'address' => "Address",'lan_add' => "Language Add",'cus_data' => "Cuisine Data",'mobile_number' => "Mobile Number",'pls' => "Please",'appro_action' => "to admin panel for review and take appropriate action of Approving OR Rejecting the Restaurant."),
       'best_regards' => "Best Regards",
       'foody_team' => "FoodyT Team",
       'Loginwithfacebook' => "FB LOGIN",
       'ANALYTICS' => "ANALYTICS",
       'CustomerProfile' => "Customer Profile",
        'Filter' => "Filter",
        'Country' => "Time zone",
        'Sex' => "Sex",
        'Age' => "Age",
        'Male' => "Male",
       'FeMale' => "FeMale",
       'notfound' => "Sorry ! data not found",
        'SocialNetwork' => "Social Network",
        'Total' => "Total",
        'PerDishfood' => "Per Dish food",
        'WhatsApp' => "WhatsApp",
        'Facebook' => "Facebook",
        'Twitter' => "Twitter",
        'Valuations' => "Valuations",
        'Visits' => "Visits",
        'ByQRURL' => "By QR/URL",
        'BySearchEngine' => "By Search Engine",
        'TOTAL' => "TOTAL",
        'visittopage' => "Number of page views",
        'DishFood' => "Dish Food",
        'Visitor' => "Visitor",
        'Sessions' => "Sessions",
        'Users' => "Users",
        'DishFood' => "Dish Food",
        'Order' => "Order",
       'dishname' => "Name",
       'ASC' => "ASC",
       'DESC' => "DESC",
       'pdfinvoice' => array('billthe'=>'Bill the','detail'=>'Details','comp_name'=>'Company name','direction'=>'Direction','invoice_no'=>'Invoice Number','date_issue'=>'Date of issue','payment_codition'=>'Payment conditions',
                      'desc'=>'Description','interval'=>'Interval','qty'=>'Quantity','amt'=>'Amount',
                      'montly_free'=>'Monthly subscription to Foodyt','subtotal'=>'Subtotal in','amt_in'=>'Amount in',
                      'thank_regarding'=>'Thank you so much for trusting us! For any questions regarding the
                      invoice contact','artical_note'=>'In accordance with Article 196 of Council Directive 2006/112 / EC, the addressee of this
                      service is obliged to make the payment of the corresponding charges and VAT. You will be charged
                      the amount automatically. No action required.'),
       'rating_form' => array('overview'=>'Overview','dinner_review'=>'Diner reviews','excellent'=>'Excellent','very_good'=>'Very good','average'=>'Average','poor'=>'Poor','terrible'=>'Terrible','title'=>'Title','ur_review'=>'Write your review','send'=>'Send'),
       'setting' => array('setting_page'=>'Setting Page','hide_price'=>'Hide Price','info_hide_price'=>'Hide the pricing on Restaurant Detaild Page when looking by search box','success'=>'Your Restaurant Detail page price setting has been save Successfully .','save'=>'Save'),
       'invoice' => array('listofinvoice'=>'List of Invoices','invoice_no'=>'Invoice No','dateIssue'=>'Date of issue','amt'=>'Amount','download'=>'Download'),
       'billing' => array('bill' =>'Billing','cus_type'=>'Customer type','business'=>'Business',
                         'particular'=>'Particular','fname' =>'First name','surname'=>'Surnames','update'=>'Update',
                         'address' => 'Address','population' => 'Population','province'=>'Province','postalcode'=> 'Postal Code','sucess' => 'Your Tax information has been Updated successfully.'),
       'Vat' =>"Vat",
       'Creditor_debitcard' => "Credit or debit card",
       'information_fiscal' => "Tax information",
       'cardInfo' => array('payment_method_sele'=>'Payment Method Selection','select_payment_method'=>'Select Payment Method','enter_payment_detail'=>'Enter Your Payment Details','fname'=>'First Name','lname'=>'Last Name','card_number'=> 'Card Number','exp_date'=>'Expiration Date')

       ),
     "es" => array (
       'home' => array('location'=>'Busca el Restaurante por Localización','name'=>'Busca el Restaurante por Nombre','cuisine'=>'Busca el Restaurante por Tipo de Cocina'),
       "restaurant_name" => "Nombre del Establecimiento",
       "restaurant_description" => "Descripción",
       "address" => "Dirección",
       "address_placeholder" => "Dirección",
       "languageText" => "Idioma",
       "languageList" => array('Español','Inglés','Francés','Italiano','Japonés'),
       "yes_i_want" => "Sí, lo quiero",
       "additional_each" => "adicionales cada idioma a partir del segundo",
       'beacon' => array(
                           '0'=>'Beacon','1'=>"Beacons son unos increíbles pequeños aparatos electrónicos que harán crecer tu número de clientes. Te contamos sobre ellos!",'2'=>"¿Qué es un Beacon?"),
       'monthly_report' => array(
                           '0'=>'Informe Mensual','1'=>'¿Te gustaría recibir un informe mensual acerca de la navegación de tu carta?Te enseñaremos como los comensales han interactuado con ella y de esta forma podrás adaptar tu oferta a su demanda. ¡Analiza y mejora!'),
       'photograph' => array(
                       '0'=>'Fotografía por el equipo de Foodyt','1'=>'Las fotografías para tu Carta Digital serán hechas por un fotógrafo profesional de Foodyt, que contactará una vez al mes.'),
       'lang_added' => "Idiomas añadidos",
       'addition' => 'adicionales',
       'banner_img' => 'Imagen Fondo de Carta',
       'kind_cuision' => 'Tipo de Cocina',
       'create_now' => "CREAR AHORA",
       'account_info' => "Información de la cuenta",
       'mobile_no' => "Número de Teléfono",
       'mobile_placeholder' => "Número de Teléfono",
       'payment_method' => "Método de Pago",
       'card_no' => "Número de Tarjeta",
       'card_holder' => "Nombre del titular de la tarjeta",
       'card_holder_placeholder' => "Nombre del titular de la tarjeta",
       'expiry' => "Fecha de Caducidad",
       'cvv' => "CVV",
       'billing_add' => "Dirección de Facturación",
       'city' => "Ciudad",
       'state' => "Provincia",
       'postal' => "Código Postal",
       'order_summary' => 'Resumen del Pedido',
       'basic' => 'Base',
       'month' => "mes",
       'download' => "DESCARGAR",
       'back' => "Atrás",
       'error_registration' => array('restaurant_name'=>'Ingresa el nombre de tu restaurante.','restaurant_des'=>'Por favor, introduzca su descripción del restaurante.','email'=>'Por favor introduzca su correo electrónico.','address'=>'Por favor, introduzca su dirección.','logo_img'=>'Cargue la imagen del logotipo.','banner_img'=>'Subir imagen de la pancarta.','select_cuisine'=>'Por favor, seleccione cualquier tipo de cocina.','mobile_no'=>'Ingresa tu móvil no','card'=>'Introduzca su número de tarjeta válido','cardHolderName' => "Introduzca el nombre del titular de la tarjeta",'cvv'=>'Por favor, entre el código CVV','billing_address' => "Ingrese su dirección de facturación",'city'=> "Introduzca su ciudad",'state' => "Ingrese su estado",'postal'=>'Ingrese un código postal válido','valid_img' => "Seleccione el tipo de imagen válido.",'email_exit' => "Él proporcionó Email Id ya existe. Utilice uno diferente para crear la cuenta",'emailExit' => "El ID de correo electrónico ya se ha salido."),
       'prev_img' => "spanish_no_prev.jpg",
       'place_order' => "REALIZAR PEDIDO",
       'help'=> array('Preguntas Frecuentes',"Hola, ¿Cómo puedo ayudarte?"),
       'login' => array('username' => "Usuario/Email",'password' => "Contraseña",'remember' => "Recuérdame",'forget_pass' => "Se me olvidó la contraseña",'forget_msg' => "Por favor, introduzca su usuario o email. Recibirás un email para crear una nueva contraseña.",'username_email' => "Usuario/Email",'get_new_pass' => "Obtén Nueva Contraseña",'error' => "Su nombre de usuario y contraseña son incorrectos"),
        'my_account' => "MI CUENTA",
        'update_plan' => "ACTUALIZAR PLAN",
        'cancel_sub' =>"CANCELAR SUSCRIPCIÓN",
        'cancel_sub_msg' => "Su plan de suscripción se ha cancelado correctamente.",
        'u_will_logout' => "Usted se pondrá en.",
        'current_plan' => "Plan Actual",
        'edit_res_profile' => "Editar Perfil del Restaurante",
        'update' => "ACTUALIZAR",
        'manage_res_menu' => "Gestión Carta Digital",
        'manage_cat_menu' => "Administrar Menú de Categorías",
        'add_dish' => "Añadir Plato",
        'edit' => "Editar",
        'remove' => "Eliminar",
        'approve' => "Aprobado",
        'review' => "En revisión",
        'reject' => "Rechazado",
        'prev' => "Anterior",
        'next' => "Siguiente",
        'preview' => "Vista Previa",
        'not_add_menu' => "¡No has añadido ningún menú!..",
        'dish_page' => array('dish' => "Plato",'category' => "Categorías",'categories' => "Categorías",'add_category' => "añadir categoría",'cat_menu' => "Menú de Categoría",'saveandclose' => "Guardar cerrar" ,'select_cat' => "Porfavor seleccione una categoría",'no_option_avila' => "No hay opción disponible", 'dish_name' => "Nombre", 'note' => "Nota: Si quieres que las fotos sean tomadas por el equipo Foodyt, actualice el plan.",'short_des' => "Descripción Corta",'price' => "Precio",'size_optional' => "Tamaño (Opcional)",'u_can_create' => "Puedes crear diferentes tamaños para un mismo producto. Ej, Tapa, Ración,..",'title_size' => "Título del Tamaño",'add_another' => "AÑADIR NUEVO",'allergen' => "Alérgenos",'sub_dish' => "ACTUALIZAR CARTA",'submitbtn' => "ENVIAR",'dish_succ' => "El plato ha sido creado con éxito.",'form_sub_error'=>"El formulario no puede ser presentado en blanco o sin campos obligatorios.",'img_prev' =>'no-image-available-es.png','success' => "Éxito",'dish_form_added' => "Se ha añadido un nuevo plato",'img_req' => "Archivo de imagen requerido!",'success' => "Creado satisfactoriamente",'manageCat' =>"Administrar menú de categoría"),
        'login_credential' => array('manage_credential' => "Editar Credenciales" ,'reset_pass' => "Modifica Tu Contraseña",'current_pass' => "Contraseña Actual",'new_pass' => "Nueva Contraseña",'confirm_new_pass' => "Confirma Nueva Contraseña",'submit'=>"ACTUALIZAR",'error' => "Su contraseña actual es incorrecta."),
        'notification' => array("Atención","Su cuenta expirará en 2 días. Por favor actualice su plan para continuar disfrutando de Foodyt.","Pulse Aquí"),
        'search_list' => array('search_result' => "Resultados de la búsqueda",'sortby' => "Ordenar por",'ascTodes' => "Ascendente a Descendente",'within' => "Dentro",'mile' => "Millas",'descToasc' => "Descendente a Ascendente",'recently' => "Recientemente añadido",'location' => "Ubicación",'cuisine' => "Cocina",'select_cuision' => "Seleccione una cocina",'seeall' => "Ver todas las Cocinas",'no_result' => "¡No se han encontrado resultados!"),
        'reg_mail_client' => array("Correo de registro","Estimado","Se ha registrado satisfactoriamente en Foodyt." ,"Su cuenta y detalles están bajo revisión y será notificado una vez que sea aprovada."),
       'reg_mail_admin' => array('dearadmin' => "Estimado Administrador,",'added' => "AUn nuevo Restaurante se ha registrado en la web con los siguientes detalles" ,'user_name' => "Usuario",'res_name' => "Nombre del Establecimiento",'res_des' => "Descripción del Restaurante",'address' => "Dirección",'lan_add' => "Idiomas",'cus_data' => "Tipo de Cocina",'mobile_number' => "Número de Teléfono",'pls' => "Por favor",'appro_action' => "el panel de administración para revisar y aprovar o rechazar al establecimiento.",'login' => "iniciar sesión"),
       'best_regards' => "Muchas gracias por confiar en nosotros,",
       'foody_team' => "Equipo Foodyt",
       'Loginwithfacebook' => "FB LOGIN",
       'ANALYTICS' => "ANALÍTICAS",
       'CustomerProfile' => "PERFIL DE CLIENTES",
       'Filter' => "Filtrar",
       'Country' => "zona horaria",
       'Sex' => "Sexo",
       'Age' => "Edad",
       'Male' => "Hombres",
       'FeMale' => "Mujeres",
       'notfound' => "Lo siento ! Datos no encontrados",
        'SocialNetwork' => "Redes sociales",
        'Total' => "Total",
        'PerDishfood' => "Por Plato",
        'WhatsApp' => "WhatsApp",
        'Facebook' => "Facebook",
        'Twitter' => "Twitter",
        'Valuations' => "Valoraciones",
        'Visits' => "Visitados",
        'ByQRURL' => "Por QR/URL",
        'BySearchEngine' => "Por Buscador",
        'TOTAL' => "TOTAL",
        'visittopage' => "Número de visitas a páginas",
        'DishFood' => "Platos",
        'Visitor' => "Visitados",
        'Sessions' => "Sesiones",
        'Users' => "Usuarios",
        'DishFood' => "PLATOS",
        'Order' => "Ordenar",
        'dishname' => "Plato",
        'ASC' => "ASC",
       'DESC' => "DESC",
       'pdfinvoice' => array('billthe'=>'Facturar a','detail'=>'Detalles','comp_name'=>'nombre de empresa','direction'=>'Dirección','invoice_no'=>'Numero de Factura','date_issue'=>'Fecha de emision','payment_codition'=>'Condiciones de Pago',
                      'desc'=>'Descripción','interval'=>'Intervalo','qty'=>'Cantidad','amt'=>'Importe',
                      'montly_free'=>'Cuota mensual de suscripcion a Foodyt','subtotal'=>'Subtotal en','amt_in'=>'Importe en',
                      'thank_regarding'=>'iMuchas gracias por confiar en nosotros! Para cualquier duda referente a la
                      factura contacte con','artical_note'=>'De acuerdo con el articulo 196 de la Directiva del Consejo 2006/112/CE, el destinatario de este
                      servicio esta obligado a realizar el pago de los cargos e IVA correspondientes. Se le cobrara
                      automaticamente el importe. No hace falta realizar ninguna accion'),
       'rating_form' => array('overview'=>'Opiniones','dinner_review'=>'Puntuación de comensales','excellent'=>'Excelente','very_good'=>'Muy bueno','average'=>'Normal','poor'=>'Malo','terrible'=>'Pésimo','title'=>'Título','ur_review'=>'Escriba su opinión','send'=>'Enviar'),
       'setting' => array('setting_page'=>'Página de configuración','hide_price'=>'Ocultar precio','info_hide_price'=>'Solo aparecerán los precios accediendo desde el local','success'=>'Se ha guardado la configuración de precio de la página Detalle de Restaurante con éxito.','save'=>'Salvar'),
       'invoice' => array('listofinvoice'=>'Lista de Facturas','invoice_no'=>'N° Factura','dateIssue'=>'Fecha de Emision','amt'=>'Importe','download'=>'Descargar'),
       'billing' => array('bill' =>'Facturación','cus_type'=>'Tipo de Cliente','business'=>'Empresa',
                         'particular'=>'Particular','fname' =>'Nombre','surname'=>'Apellidos','update'=>'Actualizar',
                         'address' => 'Direccion','population' => 'Poblacion','province'=>'Provincia','postalcode'=> 'Codigo Postal','sucess' => 'Su información fiscal ha sido actualizada con éxito.'),
       'Vat' =>"IVA",
       'Creditor_debitcard' => "Tarjeta de Crédito o Débito",
       'information_fiscal' => "Información fiscal",
       'cardInfo' => array('payment_method_sele'=>'Selección del Método de Pago','select_payment_method'=>'Seleccionar método de pago
','enter_payment_detail'=>'Método de Pago','fname'=>'Nombre','lname'=>'Apellidos','card_number'=> 'Número de Tarjeta','exp_date'=>'Fecha de Caducidad')
  )
 );
 return $languageContent;

}
function wp_login_form_by_jai( $args = array() ) {
    $defaults = array(
        'echo' => true,
        // Default 'redirect' value takes the user back to the request URI.
        'redirect' => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
        'form_id' => 'loginform',
        'label_username' => __( 'Username or Email Address' ),
        'label_password' => __( 'Password' ),
        'label_remember' => __( 'Remember Me' ),
        'label_log_in' => __( 'Log In' ),
        'id_username' => 'user_login',
        'id_password' => 'user_pass',
        'id_remember' => 'rememberme',
        'id_submit' => 'wp-submit',
        'remember' => true,
        'value_username' => '',
        // Set 'value_remember' to true to default the "Remember me" checkbox to checked.
        'value_remember' => false,
    );
 
    /**
     * Filters the default login form output arguments.
     *
     * @since 3.0.0
     *
     * @see wp_login_form()
     *
     * @param array $defaults An array of default login form arguments.
     */
    $args = wp_parse_args( $args, apply_filters( 'login_form_defaults', $defaults ) );
 
    /**
     * Filters content to display at the top of the login form.
     *
     * The filter evaluates just following the opening form tag element.
     *
     * @since 3.0.0
     *
     * @param string $content Content to display. Default empty.
     * @param array  $args    Array of login form arguments.
     */
    $login_form_top = apply_filters( 'login_form_top', '', $args );
 
    /**
     * Filters content to display in the middle of the login form.
     *
     * The filter evaluates just following the location where the 'login-password'
     * field is displayed.
     *
     * @since 3.0.0
     *
     * @param string $content Content to display. Default empty.
     * @param array  $args    Array of login form arguments.
     */
    $login_form_middle = apply_filters( 'login_form_middle', '', $args );
 
    /**
     * Filters content to display at the bottom of the login form.
     *
     * The filter evaluates just preceding the closing form tag element.
     *
     * @since 3.0.0
     *
     * @param string $content Content to display. Default empty.
     * @param array  $args    Array of login form arguments.
     */
    $login_form_bottom = apply_filters( 'login_form_bottom', '', $args );
 
    $form = '
        <form name="' . $args['form_id'] . '" id="' . $args['form_id'] . '" action="' . esc_url( site_url( 'wp-login.php', 'login_post' ) ) . '" method="post">
            ' . $login_form_top . '
            <p class="login-username ggggg">
                <label for="' . esc_attr( $args['id_username'] ) . '">' . esc_html( $args['label_username'] ) . '</label>
                <input type="text" name="log" id="' . esc_attr( $args['id_username'] ) . '" class="input" value="' . esc_attr( $args['value_username'] ) . '" size="20" />
            </p>
            <p class="login-password">
                <label for="' . esc_attr( $args['id_password'] ) . '">' . esc_html( $args['label_password'] ) . '</label>
                <input type="password" name="pwd" id="' . esc_attr( $args['id_password'] ) . '" class="input" value="" size="20" />
            </p>
            ' . $login_form_middle . '
            ' . ( $args['remember'] ? '<p class="login-remember"><label><input name="rememberme" type="checkbox" id="' . esc_attr( $args['id_remember'] ) . '" value="forever"' . ( $args['value_remember'] ? ' checked="checked"' : '' ) . ' /> ' . esc_html( $args['label_remember'] ) . '</label></p>' : '' ) . '
            <div class="g-recaptcha loginCap" data-sitekey="6LdcEhoUAAAAALXpeUN4Af7VAcpzAqsjoC-9w5Sz"></div>

            <p class="login-submit">
                <input type="submit" name="wp-submit" id="' . esc_attr( $args['id_submit'] ) . '" class="button button-primary" value="' . esc_attr( $args['label_log_in'] ) . '" />
                <input type="hidden" name="redirect_to" value="' . esc_url( $args['redirect'] ) . '" />
            </p>
            ' . $login_form_bottom . '
        </form>';
 
    if ( $args['echo'] )
        echo $form;
    else
        return $form;
}
function myplugin_comment_columns( $columns )
{
  
    $column_meta = array( 'title' => 'Comment Title' );
    $columns = array_slice( $columns, 0, 2, true ) + $column_meta + array_slice( $columns, 2, NULL, true );
    return $columns;
}
add_filter( 'manage_edit-comments_columns', 'myplugin_comment_columns' );
function myplugin_comment_column( $column, $comment_ID )
{
    if ( 'title' == $column ) {
        global $wpdb;

        $commentTable = $wpdb->prefix."comments";
        $commentTitle = $wpdb->get_row("SELECT comment_ID,comment_title FROM $commentTable where comment_ID = $comment_ID ");
        echo $commentTitle->comment_title;
    }
}
add_filter( 'manage_comments_custom_column', 'myplugin_comment_column', 10, 2 );

function Socialsharecount($type,$dishid,$datequery="")
{
    global $wpdb;
    $viewdish_table = $wpdb->prefix."socialshare";
    $query = "SELECT count(*) as totalcount FROM  $viewdish_table WHERE  dishId ='".$dishid."' AND share_type='$type' $datequery";		
	$singleDishShare = $wpdb->get_results($query);
    $count = $singleDishShare[0]->totalcount;
    return $count;
    
}

function GetDays($sStartDate, $sEndDate)
{  
      // Firstly, format the provided dates.  
      // This function works best with YYYY-MM-DD  
      // but other date formats will work thanks  
      // to strtotime().  
      $sStartDate = gmdate("Y-m-d", strtotime($sStartDate));  
      $sEndDate = gmdate("Y-m-d", strtotime($sEndDate));  

      // Start the variable off with the start date  
     $aDays[] = $sStartDate;  

     // Set a 'temp' variable, sCurrentDate, with  
     // the start date - before beginning the loop  
     $sCurrentDate = $sStartDate;  

     // While the current date is less than the end date  
     while($sCurrentDate < $sEndDate){  
       // Add a day to the current date  
       $sCurrentDate = gmdate("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));  

       // Add this new day to the aDays array  
       $aDays[] = $sCurrentDate;  
     }  

     // Once the loop has finished, return the  
     // array of days.  
     return $aDays;  
}  

/*
add_filter( 'manage_restaurant_posts_columns', 'set_custom_edit_restaurant_columns' );
add_action( 'manage_restaurant_posts_custom_column' , 'custom_restaurant_column', 10, 2 );

function set_custom_edit_restaurant_columns($columns) {
    $columns['invoice'] = __( 'Invoice Payment' );
    return $columns;
}

function custom_restaurant_column( $column, $post_id ) {
    switch ( $column ) {


        case 'invoice' :
            echo "<a href='#'>Invoice List</a>"; 
            break;

    }
}
*/
// Get LatLong from given address it return
function getLatLong($address){
    if(!empty($address)){
        //Formatted address
        $formattedAddr = str_replace(' ','+',$address);
        //Send request and receive json data by address
        $geocodeFromAddr = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false'); 
        $output = json_decode($geocodeFromAddr);
        //Get latitude and longitute from json data
        $data['latitude']  = $output->results[0]->geometry->location->lat; 
        $data['longitude'] = $output->results[0]->geometry->location->lng;
        //Return latitude and longitude of the given address
        if(!empty($data)){
            return $data;
        }else{
            return false;
        }
    }else{
        return false;   
    }
}

remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

if ( is_admin() ) {
function fpw_post_info( $id, $post ) {
       if ( 'trash' != get_post_status( $post ) ) {
           
            if($post->post_type=='restaurant'){
          global $wpdb;
          $payment_table = $wpdb->prefix."payment";
          $restaurant_info_table = $wpdb->prefix."restaurant_infos";
          $meta = get_post_meta( $post->ID );
          $plan = $meta['update_plan'][0];
        if($plan!='0'){
              $res = $wpdb->get_row("SELECT * FROM $payment_table where restaurant_id= $id AND cancel_sub=0 ORDER BY id DESC LIMIT 1", ARRAY_A);
              $subId = $res['subscription_id'];
              //$subId = "sub_BYoYiupVUgjxBO";

                require_once('stripe/init.php');
                stripeCredential();
                $subscription = \Stripe\Subscription::retrieve($subId);
                $itemID = $subscription->items->data[0]->id;
                $customer = \Stripe\Subscription::update($subId, array(
                  "items" => array(
                    array(
                      "id" => $itemID,
                      "plan" => $plan,
                    ),
                  ),
                ));
            
          
             $days = $customer->items->data[0]->plan->trial_period_days;
             $start_date = date('Y-m-d h:i:s');
			 $end_date = date('Y-m-d h:i:s', strtotime("+".$days."days"));
            
            // To update a trial end of current plan that is now updated
            $trial_end_date = strtotime($end_date);
            $subscription->trial_end = $trial_end_date;
            $subscription->prorate = false;
            $subscription->save();
            
             $wpdb->update( 
					$restaurant_info_table, 
					array( 
						'plan' => $plan,
						'start_date' => $start_date,
						'end_date' => $end_date
                     ), 
                    array( 'page_id' => $id ), 
					array( 
						'%s', 
						'%s', 
						'%s' 	
					),
                 array( '%d' ) 
				);
              update_post_meta($id,'update_plan','');
              update_post_meta($id, 'plan_type', $plan); 
          
             }
          }

       }
    }
add_action( 'save_post', 'fpw_post_info', 10, 2 );
}

/*Start Offline payment code*/
function new_modify_restaurant_table( $column ) {
    $column['payment'] = 'Payment Reminder';
    $column['exp_date'] = 'Expiry Date';
    return $column;
}
add_filter( 'manage_restaurant_posts_columns', 'new_modify_restaurant_table' );

function new_modify_restaurant_table_row($column_name, $id ) {
	global $wpdb;
    $restaurant_info_table = $wpdb->prefix."restaurant_infos";
	$res = $wpdb->get_row("SELECT end_date FROM $restaurant_info_table where page_id= $id", ARRAY_A);
	$endDate = strtotime($res['end_date']);
    switch ($column_name) {
        case 'payment' :
            echo "<a href='#' data-postid='$id' class='paymentReminder' style='padding: 4px;border-radius: 4px;
            color: #fff;background: #a0a5aa;'>Send Offline Payment Reminder</a>";
            break;
		case 'exp_date' :
            echo "<b style='background: #006799;color: #fff;padding: 4px 6px;border-radius: 4px;'>".date('d M, Y',$endDate)."</b>";
            break;
        default:
			
    }
}
add_filter( 'manage_restaurant_posts_custom_column', 'new_modify_restaurant_table_row', 10, 2 );

add_action("wp_ajax_offlinePayment", "offlinePayment");
add_action('wp_ajax_nopriv_offlinePayment', 'offlinePayment' );
    function offlinePayment()
    {
        $postid = $_REQUEST['postid'];
		$email = get_post_meta($postid,'email',true);
		//$email ='jaisingh.iws@gmail.com';
        $site_url= site_url();
        $id = $postid;
        $admin_email = get_option( 'admin_email' );
				$to =$email;
         $title = get_the_title( $postid ); 

            if($_SESSION['lanCode']=='' || $_SESSION['lanCode']=='es')
			 { 
				$subjects = "Pago Foodyt";
				$headers = "From: " . strip_tags($admin_email) . "\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				$messages="<html><body>
				        Estimado $title,
						<p>Foodyt le envía este email para que pueda completar su pago.</p> 
                        <p>Por favor, pulse en el siguiente enlace para completar el pago.</p>
                        <p><a href='$site_url/offline-payment/?rsId=$id' alt=''>Haga clic aquí</a></p>
                        <p style='margin:1px;'>Muchas gracias!</p>
						<img id='whiteLogo' style='width: 18%;' src='$site_url/wp-content/themes/foodyT/assets/images/foodyT-logo.png' alt=''>
	
	 		   </body>
	 		   </html>	
	          ";
			mail($to,$subjects,$messages,$headers);
             } else
             {
                $subjects = "FoodyT payment";
				$headers = "From: " . strip_tags($admin_email) . "\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				$messages="<html><body>
				        Dear $title,
						<p>FoodyT is sending this email to you so that you could complete the payment for your Restaruant.</p> 
                        <p>Please follow the below URL to complete the payment:</p>
                        <p><a href='$site_url/offline-payment/?rsId=$id' alt=''>Click Here</a></p>
                        <p style='margin:1px;'>Best Regards,</p>
						<img id='whiteLogo' style='width: 18%;' src='$site_url/wp-content/themes/foodyT/assets/images/logo.png' alt=''>
	
	 		   </body>
	 		   </html>	
	          ";
			mail($to,$subjects,$messages,$headers);
            }
		
		die;
   }
function my_success_notice() {
    ?>
    <div class="updated notice" id="offlinePaymentMsg" style="display:none;">
        <p><?php _e( 'A mail  has been sent successfully, excellent!', 'my_plugin_textdomain' ); ?></p>
    </div>
    <?php
}
add_action( 'admin_notices', 'my_success_notice' );
/*End Offline payment code*/

/*Start section of user add column with value*/
function new_modify_user_table( $column ) {
    $column['file_upload'] = 'No of Invoice';
    return $column;
}
add_filter( 'manage_users_columns', 'new_modify_user_table' );

function new_modify_user_table_row( $val, $column_name, $user_id ) {
    switch ($column_name) {
        case 'file_upload' :
            return getFileUploaded( $user_id );
            break;
        default:
    }
    return $val;
}
function getFileUploaded($user_id)
{
global $wpdb;
$paymentTable = $wpdb->prefix."payment";	
$query1="SELECT count(user_id) as count FROM $paymentTable where user_id= $user_id AND payment_status='active'";
$getgata1 = $wpdb->get_row($query1);
  return "<a href='users.php?page=userinvoice&actions=view&id=$user_id'>$getgata1->count</a>";
}
add_filter( 'manage_users_custom_column', 'new_modify_user_table_row', 10, 3 );
/*End section of user add column with value*/
function stripeCredential(){
                $private_live_key = 'sk_live_dkMbLcPsyAYYY54I9QNZfDxw'; 
                $public_live_key = 'pk_live_H3slFZ0fimE4cZnN1ZC8tMSD';   
                $private_test_key = 'sk_test_IychtxwEyfxJnBcziCe2ZA38'; 
                $public_test_key = 'pk_test_9jbBKGfAha5CEoHzVXaZpId6';     
                $params = array(
                  "testmode"   => "on",
                  "private_live_key" => $private_live_key,
                  "public_live_key"  => $public_live_key,
                  "private_test_key" => $private_test_key,
                  "public_test_key"  => $public_test_key
                );
                if ($params['testmode'] == "on") {
                      \Stripe\Stripe::setApiKey($params['private_test_key']);
                      $pubkey = $params['public_test_key'];
                } else {
                     \Stripe\Stripe::setApiKey($params['private_test_key']);
                     $pubkey = $params['public_live_key'];
                }
        
}