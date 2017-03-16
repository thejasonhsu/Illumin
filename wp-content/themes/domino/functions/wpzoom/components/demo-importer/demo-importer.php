<?php
@ini_set('max_execution_time', 300);

class ZOOM_Demo_Importer {

public function __construct()
{
    add_action('load-toplevel_page_wpzoom_options', array($this, 'wpzoom_page_options_callback'));

    add_filter('zoom_options', array($this, 'demo_importer_options'));
    add_action('wp_ajax_zoom_demo_importer_set_selected_demo', array($this, 'set_selected_demo'));
}

public function demo_importer_options($data)
{

    $data['import-export'][] = array("type" => "preheader", "name" => __("Demo Content", 'wpzoom'));

    $data['import-export'][] = array("name" => __("Load Demo Content", 'wpzoom'),
        "desc" => '</p><div class="clear"></div><p style="width:100%; margin-top:20px;">' . __('Click on this button to load the demo content for this theme. This is useful for seeing how the theme will look when filled with content.<br/><br/>After the demo content was imported, we recommend you to configure <a href="nav-menus.php" target="_blank">Menus</a>, <a href="widgets.php" target="_blank">Widgets</a>, <a href="options-reading.php" target="_blank">Front Page</a> (if your theme uses a special homepage template), and other theme-specific features. <br/><br/>If the importer doesn\'t work for you, try importing the demo content <a href="http://www.wpzoom.com/theme-demo-content/" target="_blank">manually</a>.', 'wpzoom') . '</p><div class="clear"></div><div id="wpzoom-demo-content-info"><p>' .
            __("Importing the Demo Content will not delete your current posts, pages or anything else. You can delete the demo content (posts, pages, menus) only manually after that from your site.
                     <br/><br/> The importing process can take up to <strong>5 minutes</strong> or longer depending on your server configuration and the number of images included in the demo. Please do not leave this screen until you see &ldquo;<strong><em>All done!</em></strong>&rdquo; in the box that will appear below.</p></div>", 'wpzoom') .
            '

                     <table class="tg widefat" style="undefined;table-layout: fixed; width: 100%">


                    <colgroup>
                    <col style="width: 245px">
                    <col style="width: 108px">
                    <col style="width: 86px">
                    </colgroup>
                        <tr>
                         <th class="tg-yw4l"><strong>' . __('Server Environment', 'wpzoom') . '</strong></th>
                         <th class="tg-baqh">' . __('Recommended', 'wpzoom') . '</th>
                         <th class="tg-baqh">' . __('Current', 'wpzoom') . '</th>
                       </tr>
                       <tr>
                         <td class="tg-yw4l">' . __('PHP Maximum Execution Time (seconds)', 'wpzoom') . '</td>
                         <td class="tg-baqh">' . __('300 or greater', 'wpzoom') . '</td>
                         <td class="tg-baqh"><strong class="' . (absint(preg_replace('[^0-9]', '', ini_get("max_execution_time"))) < 300 ? 'bad' : 'good') . '">' . ini_get("max_execution_time") . '</strong></td>
                       </tr>
                       <tr>
                         <td class="tg-yw4l">' . __('PHP Maximum Upload Filesize', 'wpzoom') . '</td>
                         <td class="tg-baqh">' . __('64<abbr title="Megabytes">M</abbr> or greater', 'wpzoom') . '</td>
                         <td class="tg-baqh"><strong class="' . (absint(preg_replace('[^0-9]', '', ini_get("upload_max_filesize"))) < 64 ? 'bad' : 'good') . '">' . ini_get("upload_max_filesize") . '</strong></td>
                       </tr>
                       <tr>
                         <td class="tg-yw4l">' . __('PHP Maximum Post Size', 'wpzoom') . '</td>
                         <td class="tg-baqh">' . __('5<abbr title="Megabytes">M</abbr> or greater', 'wpzoom') . '</td>
                         <td class="tg-baqh"><strong class="' . (absint(preg_replace('[^0-9]', '', ini_get("post_max_size"))) < 5 ? 'bad' : 'good') . '">' . ini_get("post_max_size") . '</strong></td>
                       </tr>
                       <tr>
                         <td class="tg-yw4l">' . __('PHP Maximum Input Time (seconds)', 'wpzoom') . '</td>
                         <td class="tg-baqh">' . __('100 or greater', 'wpzoom') . '</td>
                         <td class="tg-baqh"><strong class="' . (absint(preg_replace('[^0-9]', '', ini_get("max_input_time"))) < 100 ? 'bad' : 'good') . '">' . ini_get("max_input_time") . '</strong></td>
                       </tr>
                       <tr>
                         <td class="tg-yw4l">' . __('PHP Memory Limit', 'wpzoom') . '</td>
                         <td class="tg-baqh">' . __('128<abbr title="Megabytes">M</abbr> or greater', 'wpzoom') . '</td>
                         <td class="tg-baqh"><strong class="' . (absint(preg_replace('[^0-9]', '', ini_get("memory_limit"))) < 128 ? 'bad' : 'good') . '">' . ini_get("memory_limit") . '</strong></td>
                       </tr>
                      </table>

                      <p style="width:100%; margin-top:20px;">' . __('If any of these indicators are lower than recommended values, ask your hosting to increase them.', 'wpzoom') . '</p> <p>',
        "id" => "misc_load_demo_content",
        "type" => "button");

    return $data;
}

public function wpzoom_page_options_callback()
{
    add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
}

public function enqueue_scripts()
{
    wp_enqueue_script('zoom-demo-importer', $this->get_js_uri('general.js'), array('jquery', 'underscore'), '1.0.0', true);
    if(current_theme_supports('wpz-multiple-demo-importer')){
        $localize_data = array(
            'nonce_set_selected_demo' => wp_create_nonce('set_selected_demo'),
        );
        wp_localize_script('zoom-demo-importer','zoom_multiple_demo_importer',  $localize_data);
        add_action('admin_print_footer_scripts', array($this, 'admin_js_templates'));
    }
}

    public function set_selected_demo(){
        check_ajax_referer('set_selected_demo', 'nonce_set_selected_demo');

        set_theme_mod('wpz_multiple_demo_importer', sanitize_text_field($_POST['selected_demo']));
    }

    /**
     * JavaScript templates for back-end widget form.
     */
public function admin_js_templates()
{
    ?>
    <script type="text/html" id="tmpl-zoom-demo-importer-modal-list"><?php $this->get_modal_demo_importer_template(); ?></script>
<?php
}
    /**
     * Generate modal search template.
     */
public function get_modal_demo_importer_template(){

    $wrapped_demos = get_theme_support('wpz-multiple-demo-importer');
    $demos = array_pop($wrapped_demos);
    $selected = get_theme_mod('wpz_multiple_demo_importer', $demos['default']);
    printf('<p style="text-align: center;">%s</p>', __('Select the content you want to import:'));
    echo '<div style="text-align:center;"><select name="demo_importer_select">';
     foreach($demos['demos'] as $demo ){
            echo '<option value="'.$demo.'" '.selected($selected, $demo, false).'>'.ucwords(str_replace(array('-', '_'),' ',$demo)).'</option>';
        }
    echo '</select></div><div style="margin:15px 0 0;padding:15px;color: #858500; background: #ffe; border: 1px solid #D2CBB9;box-shadow: 0 1px 1px rgba(0,0,0,.04);border-radius:3px;text-align:center;"><strong>IMPORTANT</strong>: In order to import the demo content correctly, please <a href="admin.php?page=tgmpa-install-plugins" target="_blank">install and activate</a> all recommended or required <strong>plugins</strong>.</div>';
}

public function get_assets_uri($endpoint = '')
{
    return WPZOOM::$wpzoomPath . '/components/demo-importer/assets/' . $endpoint;
}


public function get_js_uri($endpoint = '')
{
    return $this->get_assets_uri('js/' . $endpoint);
}

public static function do_import() {

require dirname(__FILE__) . '/wordpress-importer/plugin.php';
require dirname(__FILE__) . '/importer.php';
require dirname(__FILE__) . '/importer-logger.php';

$logger = new WPZOOM_Importer_Logger();
$logger->min_level = 'info';

$importer = new WPZOOM_Importer(array('fetch_attachments' => true));
$importer->set_logger($logger);

?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" href="<?php echo WPZOOM::$wpzoomPath; ?>/components/demo-importer/output-iframe.css"
          type="text/css" media="all"/>
</head>
<body>
<pre><strong><?php _e("Loading demo content&hellip;\n", 'wpzoom'); ?></strong><?php $importer->import(get_demo_xml_url()); ?>
    <strong><?php _e('All done!', 'wpzoom'); ?></strong></pre>
<script type="text/javascript">window.setTimeout(parent.wpzoom_load_demo_content_done, 500);</script>
</body>
</html><?php

return true;

}

}