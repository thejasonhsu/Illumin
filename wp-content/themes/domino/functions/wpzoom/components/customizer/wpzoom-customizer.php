<?php
require_once get_template_directory() . '/functions/wpzoom/components/customizer/helpers/helpers.php';
require_once get_template_directory() . '/functions/wpzoom/components/customizer/includes/wpzoom-customizer-css-parser.php';


class WPZOOM_Customizer
{

    private $sections = array();

    public function __construct($data)
    {
        if (empty($data)) {
            return;
        }
        $this->sections = (array)$data;

        add_action('wp_head', array($this, 'display_customization'));
        add_action('init', 'zoom_customizer_get_css', 1);
        add_action('customize_register', array($this, 'register_custom_control_type'));


        if (is_customize_preview()) {
            add_action('customize_register', array($this, 'add_panels'));
            add_action('customize_register', array($this, 'add_sections_settings_controls'));
            add_action('wp_enqueue_scripts', array($this, 'enqueue_customizer_js'), 100);
        }
    }

    function register_custom_control_type($wp_customize){
        //$wp_customize->register_control_type( 'WPZOOM_Customize_Select_Control' );

    }

    function enqueue_customizer_js()
    {
        wp_enqueue_script(
            'zoom-customizer-vein-js',
            $this->get_js_uri('vein.min.js'),
            array(),
            false,
            true
        );

        wp_enqueue_script('zoom-customizer-typekit-font-loader',
            'https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js'
        );

        wp_enqueue_script(
            'zoom-customizer-general-js',
            $this->get_js_uri('customizer-preview.js'),
            array('jquery', 'customize-preview', 'underscore'),
            false,
            true // In the footer!
        );

        wp_localize_script('zoom-customizer-general-js', 'zoom_customizer_css_rules', $this->get_css_rules());
        wp_localize_script('zoom-customizer-general-js', 'zoom_customizer_dom_rules', $this->get_dom_rules());
        wp_localize_script('zoom-customizer-general-js', 'zoom_customizer_theme_name', WPZOOM::$theme_raw_name);
    }

    public function get_assets_uri($endpoint = '')
    {
        return WPZOOM::$wpzoomPath . '/components/customizer/assets/' . $endpoint;
    }

    public function get_js_uri($endpoint = '')
    {
        return $this->get_assets_uri('js/' . $endpoint);
    }

    public function get_dom_rules()
    {
        static $collector = array();

        if (empty($collector)) {
            foreach ($this->sections as $section) {
                foreach ($section['options'] as $option_id => $option_data) {
                    if (!empty($option_data['dom'])) {
                        $collector[$option_id]['dom'] = $option_data['dom'];
                        $collector[$option_id]['default'] = $option_data['setting']['default'];
                    }
                }
            }
        }

        return $collector;
    }

    public function get_css_rules()
    {
        static $collector = array();

        if (empty($collector)) {
            foreach ($this->sections as $section) {
                foreach ($section['options'] as $option_id => $option_data) {
                    if (!empty($option_data['style'])) {
                        $collector[$option_id]['style'] = $option_data['style'];
                        $collector[$option_id]['default'] = $option_data['setting']['default'];
                    }
                }
            }
        }

        return $collector;
    }

    public function get_panels()
    {
        return apply_filters('wpzoom_customizer_get_panels', array(
            'general' => array('title' => __('General', 'wpzoom')),
            'typography' => array('title' => __('Typography', 'wpzoom')),
            'color-scheme' => array('title' => __('Colors', 'wpzoom')),
        ));
    }

    public function add_panels($wp_customize)
    {
        $wp_customize->remove_section('colors');
        foreach ($this->get_panels() as $panel => $panel_data) {
            $wp_customize->add_panel($panel, $panel_data);
        }
    }

    private function validate_control_type($control_type)
    {
        return class_exists($control_type) && in_array($control_type, $this->get_custom_controls());
    }

    private function get_custom_controls()
    {
        return apply_filters('wpzoom_customizer_get_custom_controls', array(
            'WP_Customize_Control',
            'WP_Customize_Color_Control',
            'WP_Customize_Upload_Control',
            'WP_Customize_Image_Control',
            'WP_Customize_Background_Image_Control',
            'WP_Customize_Header_Image_Control',
            'WPZOOM_Customize_Select_Control',
            'WPZOOM_Customize_Input_Control',
            'WPZOOM_Customize_Fonts_Dropdown_Control'

        ));
    }

    public function add_sections_settings_controls($wp_customize)
    {
        require_once get_template_directory() . '/functions/wpzoom/components/customizer/includes/controls.php';
        $wp_customize->register_control_type('WPZOOM_Customize_Select_Control');
        $wp_customize->register_control_type('WPZOOM_Customize_Input_Control');
        $wp_customize->register_control_type('WPZOOM_Customize_Fonts_Dropdown_Control');

        foreach ($this->sections as $section_id => $section_data) {
            $wp_customize->add_section($section_id, $section_data);

            if (isset($section_data['options']) && !empty($section_data['options'])) {

                foreach ($section_data['options'] as $option_id => $option_data) {

                    if (isset($option_data['setting'])) {

                        $wp_customize->add_setting($option_id, wp_parse_args($option_data['setting'], array(
                            'type' => 'theme_mod',
                            'capability' => 'edit_theme_options',
                            'theme_supports' => '',
                            'default' => '',
                            'transport' => 'postMessage',
                            'sanitize_callback' => '',
                            'sanitize_js_callback' => '',
                        )));
                    }

                    if (isset($option_data['control'])) {
                        $control_args = wp_parse_args($option_data['control'], array('section' => $section_id, 'settings' => $option_id));

                        if (!empty($option_data['control']['control_type']) && $this->validate_control_type($option_data['control']['control_type'])) {
                            // Dynamically generate a new class instance
                            $reflection = new ReflectionClass($option_data['control']['control_type']);
                            $class_instance = $reflection->newInstanceArgs(array(
                                $wp_customize,
                                $option_id,
                                $control_args
                            ));

                            $wp_customize->add_control($class_instance);
                        } else {
                            $wp_customize->add_control($option_id, $control_args);
                        }
                    }

                    if (isset($option_data['partial']) && isset($wp_customize->selective_refresh)) {
                        $wp_customize->selective_refresh->add_partial($option_id, $option_data['partial']);
                    }

                }
            }
        }
    }

    /**
     * @return string Theme prefix
     */
    private function get_prefix()
    {
        return WPZOOM::$theme_raw_name . '_';
    }

    public function display_customization()
    {
        do_action('zoom_customizer_display_customization_css', $this->get_css_rules());

        $css = zoom_customizer_get_css()->build();

        if (!empty($css)) {
            echo "\n<!-- Begin Theme Custom CSS -->\n<style type=\"text/css\" id=\"" . WPZOOM::$theme_raw_name . "-custom-css\">\n";
            echo $css;
            echo "\n</style>\n<!-- End Theme Custom CSS -->\n";
        }
    }
}