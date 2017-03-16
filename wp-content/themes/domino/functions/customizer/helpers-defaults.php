<?php

function domino_option_defaults() {
    $defaults = array(
        /**
         * General
         */
        // Site Title & Tagline
        'hide-tagline'                        => 0,
        // Navbar
        'navbar-hide-search'                  => 0,
        // Logo
        'logo'                                => '',
        'logo-retina-ready'                   => 0,
        'logo-favicon'                        => 0,

        /**
         * Typography
         */
        // Body
        'font-family-site-body'               => 'Merriweather',
        'font-size-site-body'                 => 16,
        // Site Title & Tag Line
        'font-family-site-title'              => 'Merriweather',
        'font-size-site-title'                => 48,
        // Top Navigation
        'font-family-nav-top'                 => 'Merriweather',
        'font-size-nav-top'                   => 14,
        // Main Navigation
        'font-family-nav'                     => 'Roboto Condensed',
        'font-size-nav'                       => 18,
        // Slider Title
        'font-family-slider-title'            => 'Merriweather',
        'font-size-slider-title'              => 34,
        // Widgets
        'font-family-widgets'                 => 'Merriweather',
        'font-size-widgets'                   => 18,
        // Post Title
        'font-family-post-title'              => 'Merriweather',
        'font-size-post-title'                => 18,
        // Single Post Title
        'font-family-single-post-title'       => 'Merriweather',
        'font-size-single-post-title'         => 50,
        // Page Title
        'font-family-page-title'              => 'Merriweather',
        'font-size-page-title'                => 50,

        /**
         * Color Scheme
         */
        // General
        'color-body-text'                     => '#222222',
        'color-header-bg'                     => '#212425',
        'color-logo'                          => '#ffffff',
        'color-link'                          => '#212425',
        'color-link-hover'                    => '#F47857',
        // Menu
        'color-menu-link'                     => '#ffffff',
        'color-menu-link-hover'               => '#F47857',
        'color-menu-link-current-top'         => '#F47857',
        'color-menu-link-current-background'  => '#F47857',
        'color-menu-dropdown-background'      => '#F47857',
        // Breaking News
        'color-breaking-title'                => '#F47857',
        // Post
        'color-post-title'                    => '#212425',
        'color-post-title-hover'              => '#F47857',
        'color-post-meta'                     => '#999999',
        'color-post-meta-link'                => '#212425',
        'color-post-meta-link-hover'          => '#F47857',
        // Widgets
        'color-widget-title'                  => '#212425',

        // Footer
        'color-footer-link'                   => '#ffffff',
        'color-footer-link-hover'             => '#F47857',

        /**
         * Footer
         */
        // Background Image
        'footer-background-color'             => '#212425',
        'footer-background-image'             => '',
        'footer-background-repeat'            => 'no-repeat',
        'footer-background-position'          => 'center',
        'footer-background-size'              => 'cover',
        // Widget Areas
        'footer-widget-areas'                 => 3,
        // Copyright
        'footer-text'                         => sprintf( __( 'Copyright &copy; %1$s %2$s', 'wpzoom' ), date( 'Y' ), get_bloginfo( 'name' ) ),
    );

    return $defaults;
}

function domino_get_default( $option ) {
    $defaults = domino_option_defaults();
    $default  = ( isset( $defaults[ $option ] ) ) ? $defaults[ $option ] : false;

    return $default;
}
