<?php
/**
 * Theme functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 */

if ( ! function_exists( 'domino_setup' ) ) :
/**
 * Theme setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 */
function domino_setup() {
    // This theme styles the visual editor to resemble the theme style.
    add_editor_style( array( 'css/editor-style.css' ) );

    /* Image Sizes */
    add_image_size( 'loop', 322, 212, true);

    add_image_size( 'single', 1000, 500, true);

    add_image_size( 'single-full', 1400, 500, true);

    add_image_size( 'carousel', 350, 230, true);

    add_image_size( 'widget-1post', 1000, 460, true);

    add_image_size( 'widget-2posts', 500, 329, true);

    add_image_size( 'widget-3posts', 334, 219, true);

    add_image_size( 'widget-2posts-large', 700, 460, true);


    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
    ) );

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support( 'title-tag' );

    // Register nav menus
    register_nav_menus( array(
        'secondary' => __( 'Top Menu', 'wpzoom' ),
        'primary' => __( 'Main Menu', 'wpzoom' ),
        'tertiary' => __( 'Footer Menu', 'wpzoom' )
    ) );


    /*
     * JetPack Infinite Scroll
     */
    add_theme_support( 'infinite-scroll', array(
        'container' => 'recent-posts',
        'wrapper' => false,
        'footer' => false
    ) );

}
endif;
add_action( 'after_setup_theme', 'domino_setup' );




/* Add support for Custom Background
==================================== */

add_theme_support( 'custom-background' );


/* Register Video Post Format
==================================== */

add_theme_support( 'post-formats', array( 'video', 'gallery', 'audio' ) );



/* Custom Excerpt Length
==================================== */

function new_excerpt_length($length) {
	return (int) option::get("excerpt_length") ? (int) option::get("excerpt_length") : 50;
}
add_filter('excerpt_length', 'new_excerpt_length');




/* Maximum width for images in posts
=========================================== */
if ( ! isset( $content_width ) ) $content_width = 1000;




/* Custom Archives titles.
=================================== */

if ( ! function_exists( 'domino_get_the_archive_title' ) ) :

function domino_get_the_archive_title( $title ) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    }

    return $title;
}
endif;
add_filter( 'get_the_archive_title', 'domino_get_the_archive_title' );



if ( ! function_exists( 'domino_alter_main_query' ) ) :
/**
 * Alter main WordPress Query to exclude specific categories
 * and posts from featured slider if this is configured via Theme Options.
 *
 * @param $query WP_Query
 */
function domino_alter_main_query( $query ) {
    // until this is fixed https://core.trac.wordpress.org/ticket/27015
    $is_front = false;

    if ( get_option( 'page_on_front' ) == 0 ) {
        $is_front = is_front_page();
    } else {
        $is_front = $query->get( 'page_id' ) == get_option( 'page_on_front' );
    }

    if ( $query->is_main_query() && $is_front ) {
        if ( option::is_on( 'hide_featured' ) ) {
            $featured_posts = new WP_Query( array(
                'post__not_in'   => get_option( 'sticky_posts' ),
                'posts_per_page' => option::get( 'slideshow_posts' ),
                'meta_key'       => 'wpzoom_is_featured',
                'meta_value'     => 1
            ) );

            $postIDs = array();
            while ( $featured_posts->have_posts() ) {
                $featured_posts->the_post();
                $postIDs[] = get_the_ID();
            }

            wp_reset_postdata();

            $query->set( 'post__not_in', $postIDs );
        }

        if ( count( option::get( 'recent_part_exclude' ) ) ) {
            $query->set( 'cat', '-' . implode( ',-', (array) option::get('recent_part_exclude') ) );
        }
    }
}
endif;
add_action( 'pre_get_posts', 'domino_alter_main_query' );




/* Register Custom Fields in Profile: Facebook, Twitter
===================================================== */

add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );

function my_show_extra_profile_fields( $user ) { ?>

    <h3>Additional Profile Information</h3>

    <table class="form-table">


        <tr>
            <th><label for="twitter">Twitter Username</label></th>

            <td>
                <input type="text" name="twitter" id="twitter" value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description">Please enter your Twitter username</span>
            </td>
        </tr>

        <tr>
            <th><label for="facebook_url">Facebook Profile URL</label></th>

            <td>
                <input type="text" name="facebook_url" id="facebook_url" value="<?php echo esc_attr( get_the_author_meta( 'facebook_url', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description">Please enter your Facebook profile URL</span>
            </td>
        </tr>

        <tr>
            <th><label for="facebook_url">Instagram Username</label></th>

            <td>
                <input type="text" name="instagram_url" id="instagram_url" value="<?php echo esc_attr( get_the_author_meta( 'instagram_url', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description">Please enter your Instagram username</span>
            </td>
        </tr>

    </table>
<?php }

add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );

function my_save_extra_profile_fields( $user_id ) {

    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;

    update_user_meta( $user_id, 'instagram_url', $_POST['instagram_url'] );
    update_user_meta( $user_id, 'facebook_url', $_POST['facebook_url'] );
    update_user_meta( $user_id, 'twitter', $_POST['twitter'] );
}



add_action( 'init', 'remove_jetpack_sharing_excerpt' );

function remove_jetpack_sharing_excerpt() {
     remove_filter( 'the_excerpt', 'sharing_display', 19 );
}


/* Enqueue scripts and styles for the front end.
=========================================== */

function domino_scripts() {
    if ( '' !== $google_request = domino_get_google_font_uri() ) {
        wp_enqueue_style( 'domino-google-fonts', $google_request, WPZOOM::$themeVersion );
    }

    // Load our main stylesheet.
    wp_enqueue_style( 'domino-style', get_stylesheet_uri() );

    wp_enqueue_style( 'media-queries', get_template_directory_uri() . '/css/media-queries.css', array(), WPZOOM::$themeVersion );


    wp_enqueue_style( 'domino-google-font-default', '//fonts.googleapis.com/css?family=Playfair+Display:400,700|Roboto+Condensed:400,700|Roboto:400,500,700|Merriweather:400,700,900,400italic,700italic,900italic&subset=latin,greek,cyrillic' );


    wp_enqueue_style( 'dashicons' );

    wp_enqueue_script( 'mmenu', get_template_directory_uri() . '/js/jquery.mmenu.min.all.js', array( 'jquery' ), WPZOOM::$themeVersion, true );

    wp_enqueue_script( 'flickity', get_template_directory_uri() . '/js/flickity.pkgd.min.js', array(), WPZOOM::$themeVersion, true );

    wp_enqueue_script( 'carouFredSel', get_template_directory_uri() . '/js/jquery.carouFredSel-6.2.1-packed.js', array( 'jquery' ), WPZOOM::$themeVersion, true );

    wp_enqueue_script( 'search_button', get_template_directory_uri() . '/js/search_button.js', array(), WPZOOM::$themeVersion, true );

    wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array( 'jquery' ), WPZOOM::$themeVersion, true );

    wp_enqueue_script( 'sticky-sidebar', get_template_directory_uri() . '/js/theia-sticky-sidebar.js', array( 'jquery' ), WPZOOM::$themeVersion, true );

    wp_enqueue_script( 'superfish', get_template_directory_uri() . '/js/superfish.min.js', array( 'jquery' ), WPZOOM::$themeVersion, true );

    wp_enqueue_script( 'tabber-tabs', get_template_directory_uri() . '/js/tabs.js', array( 'jquery' ), WPZOOM::$themeVersion, true );


    $themeJsOptions = option::getJsOptions();

    wp_enqueue_script( 'domino-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), WPZOOM::$themeVersion, true );
    wp_localize_script( 'domino-script', 'zoomOptions', $themeJsOptions );
}

add_action( 'wp_enqueue_scripts', 'domino_scripts' );



if ( ! function_exists( 'domino_remove_hentry' ) ) :
/**
 * Remove hentry class from posts.
 */
function domino_remove_hentry( $classes ) {
    $classes = array_diff( $classes, array( 'hentry' ) );

    return $classes;
}
endif;

add_filter( 'post_class', 'domino_remove_hentry' );