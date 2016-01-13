<?php 

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'bbpress-style', get_template_directory_uri() . '/css/bbpress.css' );
    wp_enqueue_style( 'admin-shortcodes-style', get_template_directory_uri() . '/library/functions/css/admin_shortcodes.css' );
	wp_enqueue_style( 'theme-options-style', get_template_directory_uri() . '/library/functions/css/theme-options.css' );
	wp_enqueue_style( 'media-ie-style', get_template_directory_uri() . '/library/media/css/ie.css' );
	wp_enqueue_style( 'print-style', get_template_directory_uri() . '/library/media/css/print.css' );
	wp_enqueue_style( 'reset-style', get_template_directory_uri() . '/library/media/css/reset.css' );
	wp_enqueue_style( 'editor-rtl-style', get_template_directory_uri() . '/editor-style-rtl.css' );
	wp_enqueue_style( 'editor-style', get_template_directory_uri() . '/editor-style.css' );
	wp_enqueue_style( 'ie-style', get_template_directory_uri() . '/ie.css' );
}

?>