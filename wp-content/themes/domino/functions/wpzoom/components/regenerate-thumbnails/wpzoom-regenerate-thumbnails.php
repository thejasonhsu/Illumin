<?php

/**
 * Regenerate thumbnails.
 */
class ZOOM_Regenerate_Thumbnails
{

    public $ajax_action_names = array(
        'regenerate_thumbnails' => 'zoom_regenerate_thumbnails',
        'get_thumbnails' => 'zoom_get_thumbnails',
        'set_front_page_option' => 'zoom_set_front_page_option'
    );

    public function __construct()
    {
        add_action('wp_ajax_' . $this->ajax_action_names['regenerate_thumbnails'], array($this, 'regenerate_thumbnail'));
        add_action('wp_ajax_' . $this->ajax_action_names['get_thumbnails'], array($this, 'get_thumbnails'));
        add_action('wp_ajax_' . $this->ajax_action_names['set_front_page_option'], array($this, 'set_front_page_option'));
        add_action('load-toplevel_page_wpzoom_options', array($this, 'wpzoom_page_options_callback'));
        add_action('init', array($this, 'ob_start_action'), -1);
    }

    public function ob_start_action()
    {
        if (defined('DOING_AJAX') &&
            DOING_AJAX &&
            isset($_REQUEST['action']) &&
            in_array($_REQUEST['action'], $this->ajax_action_names)
        ) {
            ob_start(NULL, 0, PHP_OUTPUT_HANDLER_CLEANABLE | PHP_OUTPUT_HANDLER_REMOVABLE);
        }
    }

    public function wpzoom_page_options_callback()
    {
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    public function get_assets_uri($endpoint = '')
    {
        return WPZOOM::$wpzoomPath . '/components/regenerate-thumbnails/assets/' . $endpoint;
    }

    public function get_js_uri($endpoint = '')
    {
        return $this->get_assets_uri('js/' . $endpoint);
    }

    public function get_css_uri($endpoint = '')
    {
        return $this->get_assets_uri('css/' . $endpoint);
    }

    public function get_front_page_type()
    {
        $type = 'latest_posts';

        $themes = array(
            'angle',
            'capital',
            'diamond',
            'wpzoom-diamond',
            'inspiro',
            'medicus',
            'venture'
        );

        if (in_array(WPZOOM::$theme_raw_name, $themes)) {
            $type = 'static_page';
        }

        $theme_front_page_type = get_theme_support('zoom-front-page-type');

        if (!empty($theme_front_page_type[0]) and
            array_key_exists('type', $theme_front_page_type[0]) and
            in_array($theme_front_page_type[0]['type'], array('static_page', 'latest_posts'))
        ) {
            $type = $theme_front_page_type[0]['type'];
        }

        return $type;
    }

    public function enqueue_scripts()
    {
        wp_enqueue_script('zoom-regenerate-thumbnails', $this->get_js_uri('general.js'), array('jquery', 'underscore', 'wp-util'), '1.0.0', true);
        wp_enqueue_script('zoom-magnific-popup', $this->get_js_uri('jquery.magnific-popup.min.js'));
        wp_enqueue_script('zoom-retry-ajax', $this->get_js_uri('jquery.ajax.retry.js'));
        wp_enqueue_style('zoom-magnific-popup', $this->get_css_uri('magnific-popup.css'));
        wp_localize_script('zoom-regenerate-thumbnails', 'zoom_regenerate_thumbnails',
            array(
                'nonce_regenerate_thumbnail' => wp_create_nonce('regenerate_thumbnail'),
                'nonce_get_thumbnails' => wp_create_nonce('get_thumbnails'),
                'nonce_set_front_page_option' => wp_create_nonce('set_front_page_option'),
                'nonce_widgets_default' => wp_create_nonce('wpzoom-ajax-save'),
                'menu_url' => admin_url('nav-menus.php'),
                'options_reading' => admin_url('options-reading.php'),
                'site_url' => site_url(),
                'front_page_type' => $this->get_front_page_type(),
                'strings' =>
                    array(
                        'on_leave_alert' => __( 'Attention, the importing process was not finished yet!', 'wpzoom' ),
                        'open_popup' => __('Please wait, process will start in a couple of seconds...', 'wpzoom'),
                        'thumbnail_header' => __('Thumbnails Regeneration is Needed', 'wpzoom'),
                        'widget_header' => __('Load default widget settings', 'wpzoom'),
                        'widget_button' => __('Load default widget settings', 'wpzoom'),
                        'thumbnail_button' => __('Regenerate Thumbnails', 'wpzoom'),
                        'skip_thumbnail_button' => __('Skip this step', 'wpzoom'),
                        'images_progress' => __('Image {1} of {2}', 'wpzoom'),
                        'thumbnail_description' => __('Click on this button to start to regenerate the thumbnails for the images that were imported.', 'wpzoom'),
                        'widget_description' => __('Click on this button to load the default widget settings (as in theme demo)', 'wpzoom'),
                        'thumbnail_finished' => __('Thumbnails have been successfully regenerated', 'wpzoom'),
                        'widget_finished' => __('Default widgets have been successfully loaded.', 'wpzoom'),
                        'import_finished' => __('Demo Content has been successfully imported', 'wpzoom'),
                        'next_step' => __('Next Step', 'wpzoom'),
                        'regenerate_images_button' => __('Start regenerate thumbnails', 'wpzoom'),
                        'starting_message' => __('Please wait, the process will start in a couple of seconds...', 'wpzoom'),
                        'final_general_message' => sprintf(__('In the final step you have to go to the <a href="%s" target="_blank">Menus</a> page and configure your theme\'s menus. <p>You can find more instructions in this <br/><a href="http://www.wpzoom.com/docs/set-up-navigation-menus/" target="_blank">video tutorial</a> <em>(opens in new tab)</em>.</p>', 'wpzoom'), admin_url('nav-menus.php')),
                        'menu_header' => __('Configure Theme Menus', 'wpzoom'),
                        'reading_settings_header' => __('Complete the Theme Setup', 'wpzoom'),
                        'reading_settings_button' => __('Open Reading settings', 'wpzoom'),
                        'view_site_button' => __('View your Site', 'wpzoom'),
                        'menu_button' => __('Open Menus page', 'wpzoom'),
                        'static_page' => sprintf(__('Your theme uses a special page template for the front page. <p><strong>1.</strong> Go to the <a href="%s" target="_blank">Reading Settings</a> page.</p><p><strong>2.</strong> In the option <strong>Front page displays</strong> select <strong>"A static page"</strong>. </p><p><strong>3.</strong> In the <strong>Front page</strong> dropdown select the <strong>Homepage</strong> page.</p>', 'wpzoom'), admin_url('options-reading.php')),
                        'latest_posts' => sprintf(__('Your theme displays your <strong>latest posts</strong> on the front page. Go to the <a href="%s" target="_blank">Reading Settings</a> page and make sure that the option <strong>Your latest posts</strong> is selected in the <strong>Front page displays</strong>.', 'wpzoom'), admin_url('options-reading.php')),
                        'set_front_page_option_message' => __('The theme has been successfully configured!', 'wpzoom')
                    )
            ));
    }

    function set_front_page_option()
    {

        //clear buffer from error notices , it not clear fatal errors
        ob_end_clean();
        check_ajax_referer('set_front_page_option', 'nonce_set_front_page_option');
        update_option('show_on_front', 'posts');
        wp_send_json_success();
    }

    function get_attachment_images()
    {
        global $wpdb;

        $sql = "SELECT ID FROM $wpdb->posts
				WHERE post_type = 'attachment' AND post_mime_type LIKE 'image/%'
				ORDER BY ID DESC";

        $result = $wpdb->get_results($sql);
        $result = wp_list_pluck($result, 'ID');

        return $result;
    }

    public function get_thumbnails()
    {
        //clear buffer from error notices , it not clear fatal errors
        ob_end_clean();
        check_ajax_referer('get_thumbnails', 'nonce_get_thumbnails');

        wp_send_json_success(array('thumbs' => $this->get_attachment_images()));
    }

    public function regenerate_thumbnail()
    {

        check_ajax_referer('regenerate_thumbnail', 'nonce_regenerate_thumbnail');

        $thumb_id = (int)$_POST['thumb_id'];
        $image = get_post($thumb_id);

        //clear buffer from error notices , it not clear fatal errors
        ob_end_clean();

        if (!$image || 'attachment' != $image->post_type || 'image/' != substr($image->post_mime_type, 0, 6)) {
            wp_send_json_error(array('message' => sprintf(
                    __('Failed resize: %d is an invalid image ID.', 'wpzoom'), $thumb_id)
                )
            );
        }

        if (!current_user_can('manage_options')) {
            wp_send_json_error(
                array(
                    'halt' => true,
                    'message' => __("Your user account doesn't have permission to resize images", 'wpzoom')
                )
            );
        }

        $fullsizepath = get_attached_file($image->ID);

        if (false === $fullsizepath || !file_exists($fullsizepath)) {
            wp_send_json_error(
                array(
                    'message' => sprintf(__('The originally uploaded image file cannot be found at %s', 'wpzoom'), '<code>' . esc_html($fullsizepath) . '</code>')
                )
            );
        }

        @set_time_limit(900); // 5 minutes per image should be PLENTY

        $metadata = wp_generate_attachment_metadata($image->ID, $fullsizepath);

        if (is_wp_error($metadata)) {
            wp_send_json_error(array(
                'message' => $metadata->get_error_message()
            ));
        }

        if (empty($metadata)) {
            wp_send_json_error(array(
                'message' => __('Unknown failure reason.', 'wpzoom')
            ));
        }

        wp_update_attachment_metadata($image->ID, $metadata);

        wp_send_json_success(array(
                'message' => sprintf(
                    __('&quot;%1$s&quot; (ID %2$s) was successfully resized in %3$s seconds.', 'wpzoom'),
                    esc_html(get_the_title($image->ID)), $image->ID, timer_stop()
                )
            )
        );
    }
}