<?php

function domino_customizer_define_typography_sections( $sections ) {
    $panel           = WPZOOM::$theme_raw_name . '_typography';
    $typography_sections = array();

    /**
     * Body
     */
    $typography_sections['font-site-body'] = array(
        'panel'   => $panel,
        'title'   => __( 'Body', 'wpzoom' ),
        'options' => array(
            'font-family-site-body'   => array(
                'setting' => array(
                    'sanitize_callback' => 'domino_sanitize_font_choice',
                ),
                'control' => array(
                    'label'   => __( 'Body Font Family', 'wpzoom' ),
                    'type'    => 'select',
                    'choices' => domino_all_font_choices()
                ),
            ),
            'font-size-site-body'     => array(
                'setting' => array(
                    'sanitize_callback' => 'absint',
                ),
                'control' => array(
                    'label' => __( 'Body Font Size (in px)', 'wpzoom' ),
                    'type'  => 'number'
                ),
            ),
        )
    );

    /**
     * Site Title & Tagline
     */
    $typography_sections['font-site-title'] = array(
        'panel'   => $panel,
        'title'   => __( 'Site Title', 'wpzoom' ),
        'options' => array(
            'font-family-site-title'   => array(
                'setting' => array(
                    'sanitize_callback' => 'domino_sanitize_font_choice',
                ),
                'control' => array(
                    'label'   => __( 'Site Title Font Family', 'wpzoom' ),
                    'type'    => 'select',
                    'choices' => domino_all_font_choices()
                ),
            ),
            'font-size-site-title'     => array(
                'setting' => array(
                    'sanitize_callback' => 'absint',
                ),
                'control' => array(
                    'label' => __( 'Site Title Font Size (in px)', 'wpzoom' ),
                    'type'  => 'number'
                ),
            ),


        )
    );

    /**
     * Top Navigation
     */
    $typography_sections['font-nav-top'] = array(
        'panel'   => $panel,
        'title'   => __( 'Top Menu', 'wpzoom' ),
        'options' => array(
            'font-family-nav-top'   => array(
                'setting' => array(
//                    'sanitize_callback' => 'domino_sanitize_font_choice',
                ),
                'control' => array(
                    'label'   => __( 'Top Menu Font Family', 'wpzoom' ),
                    'type'    => 'select',
                    'choices' => domino_all_font_choices()
                ),
            ),
            'font-size-nav-top'     => array(
                'setting' => array(
                    'sanitize_callback' => 'absint',
                ),
                'control' => array(
                    'label' => __( 'Menu Font Size (in px)', 'wpzoom' ),
                    'type'  => 'number'
                ),
            ),
        )
    );


    /**
     * Navigation
     */
    $typography_sections['font-nav'] = array(
        'panel'   => $panel,
        'title'   => __( 'Main Menu', 'wpzoom' ),
        'options' => array(
            'font-family-nav'   => array(
                'setting' => array(
//                    'sanitize_callback' => 'domino_sanitize_font_choice',
                ),
                'control' => array(
                    'label'   => __( 'Menu Font Family', 'wpzoom' ),
                    'type'    => 'select',
                    'choices' => domino_all_font_choices()
                ),
            ),
            'font-size-nav'     => array(
                'setting' => array(
                    'sanitize_callback' => 'absint',
                ),
                'control' => array(
                    'label' => __( 'Menu Font Size (in px)', 'wpzoom' ),
                    'type'  => 'number'
                ),
            ),
        )
    );

    /**
     * Slider Title
     */
    $typography_sections['font-slider'] = array(
        'panel'   => $panel,
        'title'   => __( 'Slider', 'wpzoom' ),
        'options' => array(
            'font-family-slider-title'   => array(
                'setting' => array(
                    'sanitize_callback' => 'domino_sanitize_font_choice',
                ),
                'control' => array(
                    'label'   => __( 'Slider Title Font Family', 'wpzoom' ),
                    'type'    => 'select',
                    'choices' => domino_all_font_choices()
                ),
            ),
            'font-size-slider-title'     => array(
                'setting' => array(
                    'sanitize_callback' => 'absint',
                ),
                'control' => array(
                    'label' => __( 'Slider Title Font Size (in px)', 'wpzoom' ),
                    'type'  => 'number'
                ),
            ),

        )
    );

    /**
     * Widgets
     */
    $typography_sections['font-widgets'] = array(
        'panel'   => $panel,
        'title'   => __( 'Widget Title', 'wpzoom' ),
        'options' => array(
            'font-family-widgets'   => array(
                'setting' => array(
                    'sanitize_callback' => 'domino_sanitize_font_choice',
                ),
                'control' => array(
                    'label'   => __( 'Widgets Font Family', 'wpzoom' ),
                    'type'    => 'select',
                    'choices' => domino_all_font_choices()
                ),
            ),
            'font-size-widgets'     => array(
                'setting' => array(
                    'sanitize_callback' => 'absint',
                ),
                'control' => array(
                    'label' => __( 'Widgets Font Size (in px)', 'wpzoom' ),
                    'type'  => 'number'
                ),
            ),
        )
    );

    /**
     * Post Title
     */
    $typography_sections['font-post-title'] = array(
        'panel'   => $panel,
        'title'   => __( 'Post Title', 'wpzoom' ),
        'options' => array(
            'font-family-post-title'   => array(
                'setting' => array(
                    'sanitize_callback' => 'domino_sanitize_font_choice',
                ),
                'control' => array(
                    'label'   => __( 'Post Title Font Family', 'wpzoom' ),
                    'type'    => 'select',
                    'choices' => domino_all_font_choices()
                ),
            ),
            'font-size-post-title'     => array(
                'setting' => array(
                    'sanitize_callback' => 'absint',
                ),
                'control' => array(
                    'label' => __( 'Post Title Font Size (in px)', 'wpzoom' ),
                    'type'  => 'number'
                ),
            ),
        )
    );



    /**
     * Single Post Title
     */
    $typography_sections['font-single-post-title'] = array(
        'panel'   => $panel,
        'title'   => __( 'Single Post Title', 'wpzoom' ),
        'options' => array(
            'font-family-single-post-title'   => array(
                'setting' => array(
                    'sanitize_callback' => 'domino_sanitize_font_choice',
                ),
                'control' => array(
                    'label'   => __( 'Single Post Title Font Family', 'wpzoom' ),
                    'type'    => 'select',
                    'choices' => domino_all_font_choices()
                ),
            ),
            'font-size-single-post-title'     => array(
                'setting' => array(
                    'sanitize_callback' => 'absint',
                ),
                'control' => array(
                    'label' => __( 'Single Post Title Font Size (in px)', 'wpzoom' ),
                    'type'  => 'number'
                ),
            ),
        )
    );

    /**
     * Page Title
     */
    $typography_sections['font-page-title'] = array(
        'panel'   => $panel,
        'title'   => __( 'Page Title', 'wpzoom' ),
        'options' => array(
            'font-family-page-title'   => array(
                'setting' => array(
                    'sanitize_callback' => 'domino_sanitize_font_choice',
                ),
                'control' => array(
                    'label'   => __( 'Page Title Font Family', 'wpzoom' ),
                    'type'    => 'select',
                    'choices' => domino_all_font_choices()
                ),
            ),
            'font-size-page-title'     => array(
                'setting' => array(
                    'sanitize_callback' => 'absint',
                ),
                'control' => array(
                    'label' => __( 'Page Title Font Size (in px)', 'wpzoom' ),
                    'type'  => 'number'
                ),
            ),
        )
    );


    return array_merge( $sections, $typography_sections );
}

add_filter( 'zoom_customizer_sections', 'domino_customizer_define_typography_sections' );
