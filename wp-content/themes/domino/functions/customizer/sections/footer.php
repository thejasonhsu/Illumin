<?php

function domino_customizer_define_footer_sections( $sections ) {
    $panel           = WPZOOM::$theme_raw_name . '_footer';
    $footer_sections = array();

    $theme_prefix = WPZOOM::$theme_raw_name . '_';

    /**
     * Widget Areas
     */
    $footer_sections['footer'] = array(
        'title'   => __( 'Footer', 'wpzoom' ),
        'priority' => 5000,
        'options' => array(
            'footer-widget-areas' => array(
                'setting' => array(
                    'sanitize_callback' => 'domino_sanitize_choice',
                ),
                'control' => array(
                    'label'   => __( 'Number of Widget Areas', 'wpzoom' ),
                    'type'    => 'select',
                    'choices' => array( '0', '1', '2', '3', '4' ),
                ),
            ),

            'footer-text' => array(
                'setting' => array(
                    'sanitize_callback' => 'domino_sanitize_text',
                ),
                'control' => array(
                    'label'             => __( 'Footer Text', 'wpzoom' ),
                    'type'              => 'text',
                ),
            ),
        ),
    );

    $footer_sections['footer-background'] = array(
        'title'   => __( 'Footer Menu Background', 'wpzoom' ),
        'options' => array(
            'footer-background-color' => array(
                'setting' => array(
                    'sanitize_callback' => 'maybe_hash_hex_color',
                ),
                'control' => array(
                    'control_type' => 'WP_Customize_Color_Control',
                    'label'        => __( 'Footer Background Color', 'wpzoom' ),
                ),
            ),

            'footer-background-image'    => array(
                'setting' => array(
                    'sanitize_callback' => 'esc_url_raw',
                ),
                'control' => array(
                    'control_type' => 'WP_Customize_Image_Control',
                    'label'        => __( 'Footer Background Image', 'wpzoom' ),
                    'context'      => $theme_prefix . 'footer-background-image',
                ),
            ),
            'footer-background-repeat'   => array(
                'setting' => array(
                    'sanitize_callback' => 'domino_sanitize_choice',
                ),
                'control' => array(
                    'label'   => __( 'Footer Background Repeat', 'wpzoom' ),
                    'type'    => 'radio',
                    'choices' => array(
                        'no-repeat' => __( 'No Repeat', 'wpzoom' ),
                        'repeat'    => __( 'Tile', 'wpzoom' ),
                        'repeat-x'  => __( 'Tile Horizontally', 'wpzoom' ),
                        'repeat-y'  => __( 'Tile Vertically', 'wpzoom' )
                    )
                ),
            ),
            'footer-background-position' => array(
                'setting' => array(
                    'sanitize_callback' => 'domino_sanitize_choice',
                ),
                'control' => array(
                    'label'   => __( 'Footer Background Position', 'wpzoom' ),
                    'type'    => 'radio',
                    'choices' => array(
                        'left'   => __( 'Left', 'wpzoom' ),
                        'center' => __( 'Center', 'wpzoom' ),
                        'right'  => __( 'Right', 'wpzoom' )
                    )
                ),
            ),
            'footer-background-size'     => array(
                'setting' => array(
                    'sanitize_callback' => 'domino_sanitize_choice',
                ),
                'control' => array(
                    'label'   => __( 'Footer Background Size', 'wpzoom' ),
                    'type'    => 'radio',
                    'choices' => array(
                        'auto'    => __( 'Auto', 'wpzoom' ),
                        'cover'   => __( 'Cover', 'wpzoom' ),
                        'contain' => __( 'Contain', 'wpzoom' )
                    )
                ),
            ),
        )
    );

    return array_merge( $sections, $footer_sections );
}

add_filter( 'zoom_customizer_sections', 'domino_customizer_define_footer_sections' );
