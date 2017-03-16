<?php


/* Tabbed Widget
============================ */

function tabber_tabs_load_widget() {
    // Register widget.
    register_widget( 'WPZOOM_Widget_Tabber' );
}


/**
 * Temporarily hide the "tabber" class so it does not "flash"
 * on the page as plain HTML. After tabber runs, the class is changed
 * to "tabberlive" and it will appear.
 */
function tabber_tabs_temp_hide(){
    echo '<script type="text/javascript">document.write(\'<style type="text/css">.tabber{display:none;}</style>\');</script>';
}


// Function to check if there are widgets in the Tabber Tabs widget area
// Thanks to Themeshaper: http://themeshaper.com/collapsing-wordpress-widget-ready-areas-sidebars/
function is_tabber_tabs_area_active( $index ){
    global $wp_registered_sidebars;

    $widgetcolums = wp_get_sidebars_widgets();

    if ($widgetcolums[$index]) return true;

    return false;
}


// Let's build a widget
class WPZOOM_Widget_Tabber extends WP_Widget {

    function __construct() {
        $widget_ops = array( 'classname' => 'tabbertabs', 'description' => __('Drag me to the Sidebar', 'wpzoom') );
        $control_ops = array( 'width' => 230, 'height' => 300, 'id_base' => 'wpzoom-tabber' );
        parent::__construct( 'wpzoom-tabber', __('WPZOOM: Tabs', 'wpzoom'), $widget_ops, $control_ops );
    }

    function widget( $args, $instance ) {
        extract( $args );

        echo "\n\t\t\t" . $before_widget;

        // Show the Tabs
        echo '<div class="tabber">'; // set the class with style
        if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('tabber_tabs') );
        echo '</div>';

        echo "\n\t\t\t" . $after_widget;
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['style'] = $new_instance['style'];

        return $instance;
    }

    function form( $instance ) {

        //Defaults
        $defaults = array( 'title' => __('Tabber', 'wpzoom'), 'style' => 'style1' );
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>

        <div style="float:left;width:98%;"></div>
        <p>
            <?php _e('Place your widgets in the <strong>WPZOOM: Tabs Widget Area</strong> and have them show up here.', 'wpzoom')?>
        </p>

        <div style="clear:both;">&nbsp;</div>
    <?php
    }
}

/* Tabber Tabs Widget */
tabber_tabs_plugin_init();

/* Initializes the plugin and it's features. */
function tabber_tabs_plugin_init() {

    // Loads and registers the new widget.
    add_action( 'widgets_init', 'tabber_tabs_load_widget' );

    //Registers the new widget area.
    register_sidebar(
        array(
            'name' => __('WPZOOM: Tabs Widget Area', 'wpzoom'),
            'id' => 'tabber_tabs',
            'description' => __('Each widget added here will be shown as a tab in the "WPZOOM: Tabs" widget.', 'wpzoom'),
            'before_widget' => '<div id="%1$s" class="tabbertab %2$s">',
            'after_widget' => '</div>'
        )
    );

    // Hide Tabber until page load
    add_action( 'wp_head', 'tabber_tabs_temp_hide' );
}
