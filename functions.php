<?php
/**
 * Jekkilekki functions and definitions
 *
 * @package Jekkilekki
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'jekkilekki_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function jekkilekki_setup() {

        // This theme styles the visual editor to resemble the theme style.
        $font_url = 'http://fonts.googleapis.com/css?family=Stint+Ultra+Condensed|Roboto:400,100,300,100italic,300italic,400italic,500,500italic,700,700italic,900,900italic';
        add_editor_style( array( 'inc/editor-style.css', str_replace( ',', '%2C', $font_url) ) );
    
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Jekkilekki, use a find and replace
	 * to change 'jekkilekki' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'jekkilekki', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
        add_image_size('large-thumb', 1060, 650, true); // true = take a large img, scale down and crop it / false = stretches
        add_image_size('index-thumb', 250, 450, true); // if you want variable HEIGHT, set height to 9999 so it is (almost) never cropped
        
        
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'jekkilekki' ),
                'top-menu'=> __( 'Top Menu', 'jekkilekki' ),
                'social'  => __( 'Social Menu', 'jekkilekki' ),
                'footer-menu' => __( 'Footer Menu', 'jekkilekki' ),
	) );
	
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link'
	) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'jekkilekki_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
        
        // Enable support for HTML5 markup.
        add_theme_support( 'html5', array(
            'comment-list',
            'search-form',
            'comment-form',
            'gallery',
            'caption',
        ) );
}
endif; // jekkilekki_setup
add_action( 'after_setup_theme', 'jekkilekki_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function jekkilekki_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'jekkilekki' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
        
        register_sidebar( array(
		'name'          => __( 'Footer Widgets', 'jekkilekki' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Footer widgets area appears in the footer of the site.', 'jekkilekki'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'jekkilekki_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function jekkilekki_scripts() {
	wp_enqueue_style( 'jekkilekki-style', get_stylesheet_uri() );
        
        if (is_page_template('page-templates/page-nosidebar.php')) {
            wp_enqueue_style( 'jekkilekki-layout-style', get_template_directory_uri() . '/layouts/no-sidebar.css');
        } else {
            wp_enqueue_style( 'jekkilekki-layout-style', get_template_directory_uri() . '/layouts/content-sidebar.css');
        }
        
        wp_enqueue_style( 'jekkilekki-google-fonts', 'http://fonts.googleapis.com/css?family=Stint+Ultra+Condensed|Roboto:400,100,300,100italic,300italic,400italic,500,500italic,700,700italic,900,900italic');
        
        wp_enqueue_style( 'jekkilekki-font-awesome', 'http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css');
        
        wp_enqueue_script( 'jekkilekki-superfish', get_template_directory_uri() . '/js/superfish.min.js', array( 'jquery' ), '20140718', true);
        
        wp_enqueue_script( 'jekkilekki-superfish-settings', get_template_directory_uri() . '/js/superfish-settings.js', array( 'jekkilekki-superfish' ), '20140718', true);
        
        wp_enqueue_script( 'jekkilekki-hide-search', get_template_directory_uri() . '/js/hide-search.js', array( 'jquery' ), '20140719', true);
       
	wp_enqueue_script( 'jekkilekki-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'jekkilekki-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

        wp_enqueue_script( 'jekkilekki-masonry', get_template_directory_uri() . '/js/masonry-settings.js', array( 'masonry' ), '20140719', true);
        
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'jekkilekki_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


// Add a Logo Uploader with the Theme Customizer from Kirk Wight
// http://kwight.ca/2012/12/02/adding-a-logo-uploader-to-your-wordpress-site-with-the-theme-customizer/

function themeslug_theme_customizer( $wp_customize ) {
    // Fun code will go here
    $wp_customize->add_section( 'themeslug_logo_section', array(
        'title'         => __( 'Logo', 'themeslug' ),
        'priority'      => 30,
        'description'   => 'Upload a logo to replace the default site name and description in the header',
    ) );
    $wp_customize->add_setting( 'themeslug_logo' );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'themeslug_logo', array(
        'label'         => __( 'Logo', 'themeslug' ),
        'section'       => 'themeslug_logo_section',
        'settings'      => 'themeslug_logo',
    ) ) );
}
add_action( 'customize_register', 'themeslug_theme_customizer' );