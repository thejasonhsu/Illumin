<?php

function domino_customizer_define_header_sections( $sections ) {
    $panel           = WPZOOM::$theme_raw_name . '_nav';
    $header_sections = array();

    $theme_prefix = WPZOOM::$theme_raw_name . '_';

    /**
     * Navbar
     */
    $header_sections['navbar'] = array(
        'title'   => __( 'Search Form', 'wpzoom' ),
        'priority' => 50,
        'options' => array(
            'navbar-hide-search' => array(
                'setting' => array(
                    'sanitize_callback' => 'absint',
                ),
                'control' => array(
                    'label' => __( 'Hide Search Field', 'wpzoom' ),
                    'type'  => 'checkbox'
                )
            )
        )
    );

    return array_merge( $sections, $header_sections );
}

add_filter( 'zoom_customizer_sections', 'domino_customizer_define_header_sections' );
