<?php
/**
 * Customize API: WP_Customize_Color_Control class
 *
 * @package WordPress
 * @subpackage Customize
 * @since 4.4.0
 */

/**
 * Customize Select Control class.
 *
 * @since 3.4.0
 *
 * @see WP_Customize_Control
 */
class WPZOOM_Customize_Select_Control extends WP_Customize_Control {
    /**
     * @access public
     * @var string
     */
    public $type = 'zoom-select';

    public function __construct($manager, $id, $args = array()) {
        parent::__construct($manager, $id, $args);
    }
    /**
     * Enqueue scripts/styles for the color picker.
     *
     * @since 3.4.0
     */
    public function enqueue() {
        wp_enqueue_script(
            'zoom-customizer-select-control-js',
            WPZOOM::$wpzoomPath . '/components/customizer/assets/js/zoom-select.js',
            array(),
            false,
            true
        );
    }

    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     *
     * @since 3.4.0
     * @uses WP_Customize_Control::to_json()
     */
    public function to_json() {
        parent::to_json();
        $this->json['dataLink'] = $this->get_link();
        $this->json['value'] = $this->value();
        $this->json['choices'] = $this->choices;
        $this->json['defaultValue'] = $this->setting->default;
    }

    /**
     * Don't render the control content from PHP, as it's rendered via JS on load.
     *
     * @since 3.4.0
     */
    public function render_content() {}

    /**
     * Render a JS template for the content of the color picker control.
     *
     * @since 4.1.0
     */
    public function content_template()
    {
        ?>
            <label>
                <# if ( data.label ) { #>
                    <span class="customize-control-title">{{{ data.label }}}</span>
                    <# } #>
                        <# if ( data.description ) { #>
                            <span class="description customize-control-description">{{{ data.description }}}</span>
                            <# } #>
                                <select  class="zoom-select-control" {{{ data.dataLink }}}>

                                    <# _.each(data.choices, function(label, choice){
                                        var selected = (choice === data.value) ? 'selected="selected"' : '';
                                        #>
                                        <option {{{ selected }}} value="{{{ choice }}}">{{{label}}}</option>
                                        <#}); #>
                                </select>
            </label>
        <?php
    }
}

/**
 * Customize Input Control class.
 *
 * @since 3.4.0
 *
 * @see WP_Customize_Control
 */
class WPZOOM_Customize_Input_Control extends WP_Customize_Control {
    /**
     * @access public
     * @var string
     */
    public $type = 'zoom-input';

    public $input_type = 'text';

    public function __construct($manager, $id, $args = array()) {
        parent::__construct($manager, $id, $args);

        if(!empty($args['input_type'])){
            $this->input_type = esc_attr($args['input_type']);
        }

    }
    /**
     * Enqueue scripts/styles for the color picker.
     *
     * @since 3.4.0
     */
    public function enqueue() {
        wp_enqueue_script(
            'zoom-customizer-input-control-js',
            WPZOOM::$wpzoomPath . '/components/customizer/assets/js/zoom-input.js',
            array(),
            false,
            true
        );
    }

    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     *
     * @since 3.4.0
     * @uses WP_Customize_Control::to_json()
     */
    public function to_json() {
        parent::to_json();
        $this->json['value'] = $this->value();
        $this->json['input_attrs'] = $this->input_attrs();
        $this->json['input_type'] = $this->input_type;

    }

    /**
     * Don't render the control content from PHP, as it's rendered via JS on load.
     *
     * @since 3.4.0
     */
    public function render_content() {}

    /**
     * Render a JS template for the content of the color picker control.
     *
     * @since 4.1.0
     */
    public function content_template()
    {
        ?>
            <label>
                <# if ( data.label ) { #>
                    <span class="customize-control-title">{{{ data.label }}}</span>
                    <# } #>
                        <# if ( data.description ) { #>
                            <span class="description customize-control-description">{{{ data.description }}}</span>
                            <# } #>
                                <input class="zoom-input-control" type="{{data.input_type}}" {{{ data.input_attrs }}} value="{{{ data.value }}}" />
            </label>
        <?php
    }
}

class WPZOOM_Customize_Fonts_Dropdown_Control extends WPZOOM_Customize_Select_Control {
    /**
     * @access public
     * @var string
     */
    public $type = 'zoom-fonts-dropdown';


    /**
     * Enqueue scripts/styles for the color picker.
     *
     * @since 3.4.0
     */
    public function enqueue() {

        wp_enqueue_script(
            'zoom-customizer-fonts-dropdown-control-js',
            WPZOOM::$wpzoomPath . '/components/customizer/assets/js/zoom-fonts-dropdown.js',
            array(),
            false,
            true
        );

        static $localized = false;

        if(!$localized){
            $localized = true;
            wp_localize_script('zoom-customizer-fonts-dropdown-control-js', 'wpzoom_customize_fonts_dropdown_choices', zoom_customizer_all_font_choices());

        }
    }


    /**
     * Render a JS template for the content of the color picker control.
     *
     * @since 4.1.0
     */
    public function content_template()
    {
        ?>
            <label>
                <# if ( data.label ) { #>
                    <span class="customize-control-title">{{{ data.label }}}</span>
                    <# } #>
                        <# if ( data.description ) { #>
                            <span class="description customize-control-description">{{{ data.description }}}</span>
                            <# } #>
                                <select  class="zoom-fonts-dropdown-control">

                                    <# _.each(wpzoom_customize_fonts_dropdown_choices, function(label, choice){
                                        var selected = (choice === data.value) ? 'selected="selected"' : '';
                                        #>
                                        <option {{{ selected }}} value="{{{ choice }}}">{{{label}}}</option>
                                        <#}); #>
                                </select>
            </label>
        <?php
    }
}

