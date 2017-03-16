<?php
/**
 * General WP and WPZOOM functions.
 *
 * @package WPZOOM
 */

/**
 * Function for sending AJAX responses, present since WP 3.5.0, loaded only
 * for older versions for backward compatibility.
 */
if ( ! function_exists( 'wp_send_json' ) ) {
    /**
     * Send a JSON response back to an Ajax request.
     *
     * @since WP 3.5.0
     *
     * @param mixed $response Variable (usually an array or object) to encode as JSON, then print and die.
     */
    function wp_send_json( $response ) {
        @header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );
        echo json_encode( $response );
        if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
            wp_die();
        else
            die;
    }
}

/**
 * Function for sending AJAX responses, present since WP 3.5.0, loaded only
 * for older versions for backward compatibility.
 */
if ( ! function_exists( 'wp_send_json_success' ) ) {
    /**
     * Send a JSON response back to an Ajax request, indicating success.
     *
     * @since WP 3.5.0
     *
     * @param mixed $data Data to encode as JSON, then print and die.
     */
    function wp_send_json_success( $data = null ) {
        $response = array( 'success' => true );

        if ( isset( $data ) )
            $response['data'] = $data;

        wp_send_json( $response );
    }
}

/**
 * Function for sending AJAX responses, present since WP 3.5.0, loaded only
 * for older versions for backward compatibility.
 */
if ( ! function_exists( 'wp_send_json_error' ) ) {
    /**
     * Send a JSON response back to an Ajax request, indicating failure.
     *
     * @since WP 3.5.0
     *
     * @param mixed $data Data to encode as JSON, then print and die.
     */
    function wp_send_json_error( $data = null ) {
        $response = array( 'success' => false );

        if ( isset( $data ) )
            $response['data'] = $data;

        wp_send_json( $response );
    }
}

if( ! function_exists('get_deprecated_themes')) {

    function get_deprecated_themes(){
        return array(
            'artistica',
            'bizpress',
            'bonpress',
            'business-bite',
            'cadabrapress',
            'convention',
            'delicious',
            'domestica',
            'edupress',
            'elegance',
            'eventina',
            'evertis',
            'gallery',
            'graphix',
            'horizon',
            'hotelia',
            'impulse',
            'magnet',
            'magnific',
            'manifesto',
            'monograph',
            'newsley',
            'photoblog',
            'photoland',
            'photoria',
            'polaris',
            'prime',
            'professional',
            'proudfolio',
            'pulse',
            'sensor',
            'splendid',
            'sportpress',
            'techcompass',
            'technologic',
            'telegraph',
            'virtuoso',
            'voyage',
            'yamidoo-pro',
            'zenko',
            'elastik',
            'momentum',
            'insider',
            'magazine_explorer',
            'onplay',
            'daily_headlines',
            'litepress',
            'morning',
            'digital',
            'photoframe'
        );
    }
}

if(! function_exists('get_demo_xml_url')) {
    function get_demo_xml_url()
    {
        $url = 'http://www.wpzoom.com/downloads/xml/' . str_replace(array('_', ' '), '-', strtolower(WPZOOM::$themeName)) . '.xml';

        if (current_theme_supports('wpz-multiple-demo-importer')) {
            $wrapped_demos = get_theme_support('wpz-multiple-demo-importer');
            $demos = array_pop($wrapped_demos);
            $selected = get_theme_mod('wpz_multiple_demo_importer', $demos['default']);
            $url = 'http://www.wpzoom.com/downloads/xml/' . str_replace(array('_', ' '), '-', strtolower(WPZOOM::$themeName)) . '-' . $selected . '.xml';
        }

        return $url;
    }
}

/**
 * Get the ID of an attachment from its image URL.
 *
 * @author  Taken from reverted change to WordPress core http://core.trac.wordpress.org/ticket/23831
 *
 * @param   string $url The path to an image.
 *
 * @return  int|bool            ID of the attachment or 0 on failure.
 */

if(! function_exists('zoom_get_attachment_id_from_url')){
    function zoom_get_attachment_id_from_url( $url = '' ) {
        // If there is no url, return.
        if ( '' === $url ) {
            return false;
        }

        global $wpdb;
        $attachment_id = 0;

        // Function introduced in 4.0
        if ( function_exists( 'attachment_url_to_postid' ) ) {
            $attachment_id = absint( attachment_url_to_postid( $url ) );
            if ( 0 !== $attachment_id ) {
                return $attachment_id;
            }
        }

        // First try this
        if ( preg_match( '#\.[a-zA-Z0-9]+$#', $url ) ) {
            $sql = $wpdb->prepare(
                "SELECT ID FROM $wpdb->posts WHERE post_type = 'attachment' AND guid = %s",
                esc_url_raw( $url )
            );
            $attachment_id = absint( $wpdb->get_var( $sql ) );

            if ( 0 !== $attachment_id ) {
                return $attachment_id;
            }
        }

        // Then try this
        $upload_dir_paths = wp_upload_dir();
        if ( false !== strpos( $url, $upload_dir_paths['baseurl'] ) ) {
            // If this is the URL of an auto-generated thumbnail, get the URL of the original image
            $url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $url );

            // Remove the upload path base directory from the attachment URL
            $url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $url );

            // Finally, run a custom database query to get the attachment ID from the modified attachment URL
            $sql = $wpdb->prepare(
                "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'",
                esc_url_raw( $url )
            );
            $attachment_id = absint( $wpdb->get_var( $sql ) );
        }

        return $attachment_id;
    }

}