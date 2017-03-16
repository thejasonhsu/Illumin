<?php

/**
 * Process user options to generate CSS needed to implement the choices.
 *
 * This function reads in the options from theme mods and determines whether a CSS rule is needed to implement an
 * option. CSS is only written for choices that are non-default in order to avoid adding unnecessary CSS. All options
 * are also filterable allowing for more precise control via a child theme or plugin.
 *
 * Note that all CSS for options is present in this function except for the CSS for fonts and the logo, which require
 * a lot more code to implement.
 *
 * @return void
 */
function domino_css_add_rules() {
    /**
     * Colors section
     */
    domino_css_add_simple_color_rule( 'color-body-text', 'body', 'color' );
    domino_css_add_simple_color_rule( 'color-header-bg', '#header', 'background' );

    domino_css_add_simple_color_rule( 'color-logo', '.navbar-brand a, .navbar-brand a:hover', 'color' );
    domino_css_add_simple_color_rule( 'color-link', 'a', 'color' );
    domino_css_add_simple_color_rule( 'color-link-hover', 'a:hover', 'color' );

    // Menu
    domino_css_add_simple_color_rule( 'color-menu-link', '.navbar-nav a', 'color' );
    domino_css_add_simple_color_rule( 'color-menu-link-hover', '.navbar-nav a:hover', 'color' );
    domino_css_add_simple_color_rule( 'color-menu-link-current-top', '.top-navbar .navbar-nav .current-menu-item > a, .top-navbar .navbar-nav .current_page_item > a, .top-navbar.navbar-nav .current-menu-parent > a ', 'color' );
    domino_css_add_simple_color_rule( 'color-menu-link-current-background', '.main-navbar .current-menu-item > a,.main-navbar .current_page_item > a,.main-navbar .current-menu-parent > a,.main-navbar .current_page_parent > a', 'background-color' );
    domino_css_add_simple_color_rule( 'color-menu-dropdown-background', '.navbar-nav ul', 'background-color' );
    domino_css_add_simple_color_rule( 'color-menu-dropdown-background', '.navbar-nav > li > ul:before', 'border-bottom-color' );

    // Breaking News
    domino_css_add_simple_color_rule( 'color-breaking-title', '#news-ticker h3', 'color' );

    // Post
    domino_css_add_simple_color_rule( 'color-post-title', '.entry-title a', 'color' );
    domino_css_add_simple_color_rule( 'color-post-title-hover', '.entry-title a:hover', 'color' );

    domino_css_add_simple_color_rule( 'color-post-meta', '.entry-meta', 'color' );
    domino_css_add_simple_color_rule( 'color-post-meta-link', '.entry-meta a', 'color' );
    domino_css_add_simple_color_rule( 'color-post-meta-link-hover', '.entry-meta a:hover', 'color' );

    // Widgets
    domino_css_add_simple_color_rule( 'color-widget-title', '.widget h3.title', 'color' );

    // Footer
    domino_css_add_simple_color_rule( 'color-footer-link', '.site-info-top a, .site-info-top a:hover', 'color' );
    domino_css_add_simple_color_rule( 'color-footer-link-hover', '.site-info-top a:hover', 'color' );


    /**
     * Footer Background
     */
    domino_css_add_simple_color_rule( 'footer-background-color', '.site-info-top', 'background-color' );

    $footer_background_image = get_theme_mod( 'footer-background-image', domino_get_default( 'footer-background-image' ) );
    if ( ! empty( $footer_background_image ) ) {
        $footer_background_image    = addcslashes( esc_url_raw( $footer_background_image ), '"' );
        $footer_background_size     = get_theme_mod( 'footer-background-size', domino_get_default( 'footer-background-size' ) );
        $footer_background_repeat   = get_theme_mod( 'footer-background-repeat', domino_get_default( 'footer-background-repeat' ) );
        $footer_background_position = get_theme_mod( 'footer-background-position', domino_get_default( 'footer-background-position' ) );

        domino_get_css()->add( array(
            'selectors'    => array( '#footer' ),
            'declarations' => array(
                'background-image'    => 'url("' . $footer_background_image . '")',
                'background-size'     => $footer_background_size,
                'background-repeat'   => $footer_background_repeat,
                'background-position' => $footer_background_position . ' center'
            )
        ) );
    }
}

add_action( 'domino_css', 'domino_css_add_rules' );

function domino_css_add_simple_color_rule( $setting_id, $selectors, $declarations ) {
    $value = maybe_hash_hex_color( get_theme_mod( $setting_id, domino_get_default( $setting_id ) ) );

    if ( $value === domino_get_default( $setting_id ) ) {
        return;
    }

    if ( strtolower( $value ) === strtolower( domino_get_default( $setting_id ) ) ) {
        return;
    }

    if ( is_string( $selectors ) ) {
        $selectors = array( $selectors );
    }

    if ( is_string( $declarations ) ) {
        $declarations = array(
            $declarations => $value
        );
    }

    domino_get_css()->add( array(
        'selectors'    => $selectors,
        'declarations' => $declarations
    ) );
}
