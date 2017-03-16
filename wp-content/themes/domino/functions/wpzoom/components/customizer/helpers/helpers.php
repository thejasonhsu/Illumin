<?php

/**
 * Returns a custom logo, linked to home.
 *
 * @since 4.5.0
 *
 * @param int $blog_id Optional. ID of the blog in question. Default is the ID of the current blog.
 * @return string Custom logo markup.
 */
function get_zoom_custom_logo($blog_id = 0)
{
    $html = '';

    if (is_multisite() && (int)$blog_id !== get_current_blog_id()) {
        switch_to_blog($blog_id);
    }

    $custom_logo_id = get_theme_mod('custom_logo');

    // We have a logo. Logo is go.
    if ($custom_logo_id) {

        $info = zoom_customizer_logo_information();

        $width = absint($info['width']);
        $height = absint($info['height']);

        if (get_theme_mod('custom_logo_retina_ready')) {
            $width /= 2;
            $height /= 2;
        }

        $alt = esc_attr(get_bloginfo('name'));
        $image_url = wp_get_attachment_image_url($custom_logo_id, 'full');

        $html = sprintf(
            '<a href="%s" class="custom-logo-link" rel="home" itemprop="url"><img src="%s" alt="%s" width="%d" height="%d"></a>',
            esc_url(home_url('/')),
            $image_url,
            $alt,
            $width,
            $height
        );

    } // If no logo is set but we're in the Customizer, leave a placeholder (needed for the live preview).
    elseif (is_customize_preview()) {
        $html = sprintf('<a href="%1$s" class="custom-logo-link" style="display:none;"><img class="custom-logo"/></a>',
            esc_url(home_url('/'))
        );
    }

    if (is_multisite() && ms_is_switched()) {
        restore_current_blog();
    }

    /**
     * Filter the custom logo output.
     *
     * @param string $html Custom logo HTML output.
     */
    return apply_filters('get_custom_logo', $html);
}

/**
 * Displays a custom logo, linked to home.
 *
 * @param int $blog_id Optional. ID of the blog in question. Default is the ID of the current blog.
 */
function the_zoom_custom_logo($blog_id = 0)
{
    echo get_zoom_custom_logo($blog_id);
}

/**
 * Utility function for getting information about the theme logos.
 *
 * @param  bool $force Update the dimension cache.
 *
 * @return array Array containing image file, width, and height for each logo.
 */
function zoom_customizer_logo_information($force = false)
{
    $logo_information = array();

    $logo_information['image'] = get_theme_mod('custom_logo');

    if (!empty($logo_information['image'])) {
        $dimensions = zoom_customizer_get_logo_dimensions($logo_information['image'], $force);

        // Set the dimensions to the array if all information is present
        if (!empty($dimensions) && isset($dimensions['width']) && isset($dimensions['height'])) {
            $logo_information['width'] = $dimensions['width'];
            $logo_information['height'] = $dimensions['height'];
        }
    }

    return $logo_information;
}

/**
 * Get the dimensions of a logo image from cache or regenerate the values.
 *
 * @param  int $attachment_id The URL of the image in question.
 * @param  bool $force Cause a cache refresh.
 *
 * @return array The dimensions array on success, and a blank array on failure.
 */

function zoom_customizer_get_logo_dimensions($attachment_id, $force = false)
{
    // Build the cache key
    $key = WPZOOM::$theme_raw_name . '-' . md5('logo-dimensions-' . $attachment_id . WPZOOM::$themeVersion);

    // Pull from cache
    $dimensions = get_transient($key);

    // If the value is not found in cache, regenerate
    if (false === $dimensions || is_preview() || true === $force) {
        $dimensions = array();

        // Get the dimensions
        $info = wp_get_attachment_image_src($attachment_id, 'full');

        if (false !== $info && isset($info[0]) && isset($info[1]) && isset($info[2])) {
            // Detect JetPack altered src
            if (false === $info[1] && false === $info[2]) {
                // Parse the URL for the dimensions
                $pieces = parse_url(urldecode($info[0]));

                // Pull apart the query string
                if (isset($pieces['query'])) {
                    parse_str($pieces['query'], $query_pieces);

                    // Get the values from "resize"
                    if (isset($query_pieces['resize']) || isset($query_pieces['fit'])) {
                        if (isset($query_pieces['resize'])) {
                            $jp_dimensions = explode(',', $query_pieces['resize']);
                        } elseif ($query_pieces['fit']) {
                            $jp_dimensions = explode(',', $query_pieces['fit']);
                        }

                        if (isset($jp_dimensions[0]) && isset($jp_dimensions[1])) {
                            // Package the data
                            $dimensions = array(
                                'width' => $jp_dimensions[0],
                                'height' => $jp_dimensions[1],
                            );
                        }
                    }
                }
            } else {
                // Package the data
                $dimensions = array(
                    'width' => $info[1],
                    'height' => $info[2],
                );
            }
        } else {
            // Get the image path from the URL
            $wp_upload_dir = wp_upload_dir();
            $path = trailingslashit($wp_upload_dir['basedir']) . get_post_meta($attachment_id, '_wp_attached_file', true);

            // Sometimes, WordPress just doesn't have the metadata available. If not, get the image size
            if (file_exists($path)) {
                $getimagesize = getimagesize($path);

                if (false !== $getimagesize && isset($getimagesize[0]) && isset($getimagesize[1])) {
                    $dimensions = array(
                        'width' => $getimagesize[0],
                        'height' => $getimagesize[1],
                    );
                }
            }
        }

        // Store the transient
        if (!is_preview()) {
            set_transient($key, $dimensions, 86400);
        }
    }

    return $dimensions;
}


function zoom_customizer_sanitize_choice($value, $setting)
{
    return $value;
}

function zoom_customizer_sanitize_show_hide_checkbox($value)
{
    return (int)$value ? 'block' : 'none';
}

if (!function_exists('maybe_hash_hex_color')) :
    /**
     * Ensures that any hex color is properly hashed.
     *
     * This is a copy of the core function for use when the customizer is not being shown.
     *
     * @param  string $color The proposed color.
     *
     * @return string|null The sanitized color.
     */
    function maybe_hash_hex_color($color)
    {
        if ($unhashed = sanitize_hex_color_no_hash($color)) {
            return '#' . $unhashed;
        }

        return $color;
    }
endif;


if (!function_exists('sanitize_hex_color')) :
    /**
     * Sanitizes a hex color.
     *
     * This is a copy of the core function for use when the customizer is not being shown.
     *
     * @param  string $color The proposed color.
     * @return string|null              The sanitized color.
     */
    function sanitize_hex_color($color)
    {
        if ('' === $color) {
            return '';
        }

        // 3 or 6 hex digits, or the empty string.
        if (preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color)) {
            return $color;
        }

        return null;
    }
endif;

if (!function_exists('sanitize_hex_color_no_hash')) :
    /**
     * Sanitizes a hex color without a hash. Use sanitize_hex_color() when possible.
     *
     * This is a copy of the core function for use when the customizer is not being shown.
     *
     * @param  string $color The proposed color.
     * @return string|null              The sanitized color.
     */
    function sanitize_hex_color_no_hash($color)
    {
        $color = ltrim($color, '#');

        if ('' === $color) {
            return '';
        }

        return sanitize_hex_color('#' . $color) ? $color : null;
    }
endif;

if (!function_exists('maybe_hash_hex_color')) :
    /**
     * Ensures that any hex color is properly hashed.
     *
     * This is a copy of the core function for use when the customizer is not being shown.
     *
     * @param  string $color The proposed color.
     * @return string|null              The sanitized color.
     */
    function maybe_hash_hex_color($color)
    {
        if ($unhashed = sanitize_hex_color_no_hash($color)) {
            return '#' . $unhashed;
        }

        return $color;
    }
endif;

/**
 * Allow only certain tags and attributes in a string.
 *
 * @param  string $string The unsanitized string.
 * @return string               The sanitized string.
 */
function zoom_customizer_sanitize_text($string)
{
    global $allowedtags;
    $expandedtags = $allowedtags;

    // span
    $expandedtags['span'] = array();

    // Enable id, class, and style attributes for each tag
    foreach ($expandedtags as $tag => $attributes) {
        $expandedtags[$tag]['id'] = true;
        $expandedtags[$tag]['class'] = true;
        $expandedtags[$tag]['style'] = true;
    }

    // br (doesn't need attributes)
    $expandedtags['br'] = array();

    /**
     * Customize the tags and attributes that are allows during text sanitization.
     *
     * @param array $expandedtags The list of allowed tags and attributes.
     * @param string $string The text string being sanitized.
     */
    apply_filters('zoom_customizer_sanitize_text_allowed_tags', $expandedtags, $string);

    return wp_kses($string, $expandedtags);
}


if (!function_exists('zoom_customizer_all_font_choices')) :
    /**
     * Packages the font choices into value/label pairs for use with the customizer.
     *
     * @return array    The fonts in value/label pairs.
     */
    function zoom_customizer_all_font_choices()
    {
        $fonts = zoom_customizer_get_all_fonts();
        $choices = array();

        // Repackage the fonts into value/label pairs
        foreach ($fonts as $key => $font) {
            $choices[$key] = $font['label'];
        }

        /**
         * Allow for developers to modify the full list of fonts.
         *
         * @param array $choices The list of all fonts.
         */
        return apply_filters('zoom_customizer_all_font_choices', $choices);
    }
endif;


function zoom_customizer_alias_rules($rule)
{

    $aliases = array('background-gradient' => 'background');
    if (array_key_exists($rule, $aliases)) {
        $rule = $aliases[$rule];
    }

    return $rule;
}

function zoom_customizer_get_filtered_value($rule, $value)
{
    $callbacks = array(
        'color' => 'maybe_hash_hex_color',
        'font' => 'zoom_customizer_get_font_stack',
        'font-size' => 'zoom_customizer_get_font_size',
        'display' => 'zoom_customizer_display_element',
        'background-gradient' => 'zoom_customizer_display_gradient'
    );

    $keys = array_keys($callbacks);

    if (in_array($rule, $keys)) {
        $value = call_user_func($callbacks[$rule], $value);
    }

    return $value;
}

function zoom_customizer_display_gradient($color)
{

    return 'background: -moz-linear-gradient(left,  rgba(239,244,247,0) 27%, ' . maybe_hash_hex_color($color) . ' 63%); /* FF3.6+ */
   background: -webkit-linear-gradient(left,  rgba(239,244,247,0) 27%, ' . maybe_hash_hex_color($color) . ' 63%); /* Chrome10+,Safari5.1+ */
   background: -o-linear-gradient(left,  rgba(239,244,247,0) 27%, ' . maybe_hash_hex_color($color) . ' 63%); /* Opera 11.10+ */
   background: -ms-linear-gradient(left,  rgba(239,244,247,0) 27%, ' . maybe_hash_hex_color($color) . ' 63%); /* IE10+ */
   background: linear-gradient(to right,  rgba(239,244,247,0) 27%, ' . maybe_hash_hex_color($color) . '  63%); /* W3C */;';
}

function zoom_customizer_get_font_size($size)
{
    return ((float)$size) . 'px';
}

function zoom_customizer_display_element($value)
{
    return !empty($value) ? 'block' : 'none';
}

if (!function_exists('zoom_customizer_get_font_stack')) :
    /**
     * Validate the font choice and get a font stack for it.
     *
     * @since  1.0.0.
     *
     * @param  string $font The 1st font in the stack.
     * @return string             The full font stack.
     */
    function zoom_customizer_get_font_stack($font)
    {
        $all_fonts = zoom_customizer_get_all_fonts();

        // Sanitize font choice
        $font = zoom_customizer_sanitize_font_choice($font);

        // Standard font
        if (isset($all_fonts[$font]['stack']) && !empty($all_fonts[$font]['stack'])) {
            $stack = $all_fonts[$font]['stack'];
        } elseif (in_array($font, zoom_customizer_all_font_choices())) {
            $stack = '"' . $font . '","Helvetica Neue",Helvetica,Arial,sans-serif';
        } else {
            $stack = '"Helvetica Neue",Helvetica,Arial,sans-serif';
        }

        /**
         * Allow developers to filter the full font stack.
         *
         * @param string $stack The font stack.
         * @param string $font The font.
         */
        return apply_filters('zoom_customizer_get_font_stack', $stack, $font);
    }
endif;

if (!function_exists('zoom_customizer_sanitize_font_choice')) :
    /**
     * Sanitize a font choice.
     *
     * @param  string $value The font choice.
     * @return string              The sanitized font choice.
     */
    function zoom_customizer_sanitize_font_choice($value)
    {
        if (!is_string($value)) {
            // The array key is not a string, so the chosen option is not a real choice
            return '';
        } else if (array_key_exists($value, zoom_customizer_all_font_choices())) {
            return $value;
        } else {
            return '';
        }
    }
endif;

if (!function_exists('zoom_customizer_get_all_fonts')) :
    /**
     * Compile font options from different sources.
     *
     * @return array    All available fonts.
     */
    function zoom_customizer_get_all_fonts()
    {
        $heading1 = array(1 => array('label' => sprintf('--- %s ---', __('Standard Fonts', 'wpzoom'))));
        $standard_fonts = zoom_customizer_get_standard_fonts();
        $heading2 = array(2 => array('label' => sprintf('--- %s ---', __('Google Fonts', 'wpzoom'))));
        $google_fonts = zoom_customizer_get_google_fonts();

        /**
         * Allow for developers to modify the full list of fonts.
         *
         * @param array $fonts The list of all fonts.
         */
        return apply_filters('zoom_customizer_get_all_fonts', array_merge($heading1, $standard_fonts, $heading2, $google_fonts));
    }
endif;

if (!function_exists('zoom_customizer_get_standard_fonts')) :
    /**
     * Return an array of standard websafe fonts.
     *
     * @return array    Standard websafe fonts.
     */
    function zoom_customizer_get_standard_fonts()
    {
        /**
         * Allow for developers to modify the standard fonts.
         *
         * @param array $fonts The list of standard fonts.
         */
        return apply_filters('zoom_customizer_get_standard_fonts', array(
            'serif' => array(
                'label' => _x('Serif', 'font style', 'wpzoom'),
                'stack' => 'Georgia,Times,"Times New Roman",serif'
            ),
            'sans-serif' => array(
                'label' => _x('Sans Serif', 'font style', 'wpzoom'),
                'stack' => '"Helvetica Neue",Helvetica,Arial,sans-serif'
            ),
            'monospace' => array(
                'label' => _x('Monospaced', 'font style', 'wpzoom'),
                'stack' => 'Monaco,"Lucida Sans Typewriter","Lucida Typewriter","Courier New",Courier,monospace'
            )
        ));
    }
endif;


if (!function_exists('zoom_customizer_get_google_fonts')) :
    /**
     * Return an array of all available Google Fonts.
     *
     * @return array    All Google Fonts.
     */
    function zoom_customizer_get_google_fonts()
    {
        static $google_fonts = array();

        if (empty($google_fonts)) {
            $google_fonts = zoom_customizer_get_google_fonts_from_api();
        }

        return $google_fonts;
    }
endif;

if (!function_exists('zoom_customizer_get_google_fonts_from_api')) :

    function zoom_customizer_get_google_fonts_from_api()
    {
        $api_url = apply_filters('zoom_customizer_google_fonts_api_url', 'https://www.googleapis.com/webfonts/v1/webfonts?key=');
        $api_key = apply_filters('zoom_customizer_google_fonts_api_key', 'AIzaSyALmRY1LOeH4eIRhrQ35yJPHHAye9ujPkA');
        static $transient = false;

        if (empty($transient)) {
            if (($transient = get_site_transient('zoom_customizer_google_fonts_json')) === false) {

                $response = wp_remote_get($api_url . $api_key);
                $transient = wp_remote_retrieve_body($response);

                if (
                    200 === wp_remote_retrieve_response_code($response)
                    &&
                    !is_wp_error($transient) && !empty($transient)
                ) {
                    set_site_transient('zoom_customizer_google_fonts_json', $transient, WEEK_IN_SECONDS);
                }
            }

            $transient = json_decode($transient, true);

            $collector = array();
            if(array_key_exists('items', $transient)) {
                foreach ($transient['items'] as $active) {
                    $collector[$active['family']] = array(
                        'label' => $active['family'],
                        'variants' => $active['variants'],
                        'subsets' => $active['subsets']
                    );
                }
            }

            $transient = $collector;
        }

        return apply_filters('zoom_customizer_get_google_fonts_from_api', $transient);
    }

endif;

function zoom_customizer_add_css_rule($setting_id, $default, $css_rule)
{
    $declarations = zoom_customizer_alias_rules($css_rule['rule']);
    $value = zoom_customizer_get_filtered_value($css_rule['rule'], get_theme_mod($setting_id, $default));
    $default = zoom_customizer_get_filtered_value($css_rule['rule'], $default);
    if (strtolower($value) === strtolower($default)) {
        return;
    }

    if (is_string($declarations)) {
        $declarations = array(
            $declarations => $value
        );
    }

    $css_data = array(
        'selectors' => (array)$css_rule['selector'],
        'declarations' => $declarations
    );

    if (!empty($css_rule['media'])) {
        $css_data['media'] = $css_rule['media'];
    }

    zoom_customizer_get_css()->add($css_data);
}

function zoom_customizer_get_font_familiy_ids($data)
{
    $font_families = array();
    foreach ($data as $section_element) {
        foreach ($section_element['options'] as $key => $option) {
            if (!empty($option['style']['rule']) && $option['style']['rule'] == 'font-family') {
                array_push($font_families, $key);
                $font_families[$key] = $option['setting']['default'];
            }
        }
    }

    return $font_families;
}

if (!function_exists('zoom_customizer_choose_google_font_variants')) :
    /**
     * Given a font, chose the variants to load for the theme.
     *
     * Attempts to load regular, italic, and 700. If regular is not found, the first variant in the family is chosen. italic
     * and 700 are only loaded if found. No fallbacks are loaded for those fonts.
     *
     * @param  string $font The font to load variants for.
     * @param  array $variants The variants for the font.
     * @return array                  The chosen variants.
     */
    function zoom_customizer_choose_google_font_variants($font, $variants = array())
    {
        $chosen_variants = array();
        if (empty($variants)) {
            $fonts = zoom_customizer_get_google_fonts();

            if (array_key_exists($font, $fonts)) {
                $variants = $fonts[$font]['variants'];
            }
        }

        // If a "regular" variant is not found, get the first variant
        if (!in_array('regular', $variants)) {
            $chosen_variants[] = $variants[0];
        } else {
            $chosen_variants[] = 'regular';
        }

        // Only add "italic" if it exists
        if (in_array('italic', $variants)) {
            $chosen_variants[] = 'italic';
        }

        // Only add "700" if it exists
        if (in_array('700', $variants)) {
            $chosen_variants[] = '700';
        }

        /**
         * Allow developers to alter the font variant choice.
         *
         * @param array $variants The list of variants for a font.
         * @param string $font The font to load variants for.
         * @param array $variants The variants for the font.
         */
        return apply_filters('zoom_customizer_font_variants', array_unique($chosen_variants), $font, $variants);
    }
endif;

function zoom_customizer_normalize_options(&$customizer_data)
{
    foreach ($customizer_data as $section_id => &$section_data) {

        if (isset($section_data['options']) && !empty($section_data['options'])) {
            zoom_customizer_filter_options($section_data['options']);
        }

    }
}

function zoom_customizer_filter_options(&$options)
{
    foreach ($options as $key => $option) {
        if (array_key_exists('type', $option) && $option['type'] === 'typography') {
            unset($options[$key]);

            $typography_options = zoom_customizer_typography_callback($key, $option);
            $options = array_merge($options, $typography_options);
        }
    }
}

function zoom_customizer_typography_callback($key, $option)
{
    $collector = array();

    static $cached_font_choices = array();
    static $defaults = array();
    if (empty($cached_font_choices)) {
        $cached_font_choices = zoom_customizer_all_font_choices();
    }

    if (empty($defaults)) {
        $defaults = array(
            'font-family' => array(
                'setting' => array(
                    'sanitize_callback' => 'zoom_customizer_sanitize_font_choice',
                    'transport' => 'postMessage',
                    'default' => ''
                ),
                'control' => array(
                    'label' => __('Font Family', 'wpzoom'),
                    'control_type' => 'WPZOOM_Customize_Fonts_Dropdown_Control',
                )
            ),
            'font-size' => array(
                'setting' => array(
                    'sanitize_callback' => 'absint',
                    'transport' => 'postMessage',
                    'default' => 18
                ),
                'control' => array(
                    'label' => __('Font Size (in px)', 'wpzoom'),
                    'control_type' => 'WPZOOM_Customize_Input_Control',
                    'input_type' => 'number'
                ),
            ),
            'font-style' => array(
                'setting' => array(
                    'transport' => 'postMessage',
                    'default' => 'normal'
                ),
                'control' => array(
                    'label' => __('Font Style', 'wpzoom'),
                    'control_type' => 'WPZOOM_Customize_Select_Control',
                    'choices' => array(
                        'normal' => __('Normal', 'wpzoom'),
                        'italic' => __('Italic', 'wpzoom'),
                        'oblique' => __('Oblique', 'wpzoom'),
                    )
                )
            ),
            'font-weight' => array(
                'setting' => array(
                    'transport' => 'postMessage',
                    'default' => 'normal'
                ),
                'control' => array(
                    'label' => __('Font Weight', 'wpzoom'),
                    'control_type' => 'WPZOOM_Customize_Select_Control',
                    'choices' => array(
                        'normal' => __('Normal', 'wpzoom'),
                        'bold' => __('Bold', 'wpzoom'),
                        '300' => '300',
                        '400' => '400',
                        '600' => '600',
                        '700' => '700',
                        '900' => '900'
                    )
                )
            ),
            'text-transform' => array(
                'setting' => array(
                    'transport' => 'postMessage',
                    'default' => 'none'
                ),
                'control' => array(
                    'label' => __('Text Transform', 'wpzoom'),
                    'control_type' => 'WPZOOM_Customize_Select_Control',
                    'choices' => array(
                        'none' => __('None', 'wpzoom'),
                        'capitalize' => __('Capitalize', 'wpzoom'),
                        'lowercase' => __('Lowercase', 'wpzoom'),
                        'uppercase' => __('Uppercase', 'wpzoom'),
                    )
                )
            )
        );
    }

    foreach ($option['rules'] as $rule => $default) {
        $collector[$key . '-' . $rule] = array(
            'setting' => $defaults[$rule]['setting'],
            'control' => $defaults[$rule]['control'],
            'style' => array(
                'selector' => $option['selector'],
                'rule' => $rule
            )
        );

        if (!empty($option['media'])) {
            $collector[$key . '-' . $rule]['style']['media'] = $option['media'];
        }

        $collector[$key . '-' . $rule]['setting']['default'] = $default;
    }

    return $collector;
}

function zoom_customizer_add_css_rules($rules)
{
    foreach ($rules as $setting_id => $rule) {

        if (is_array(current($rule['style']))) {
            foreach ($rule['style'] as $subrule) {
                zoom_customizer_add_css_rule($setting_id, $rule['default'], $subrule);
            }
            continue;
        }

        zoom_customizer_add_css_rule($setting_id, $rule['default'], $rule['style']);
    }
}

function zoom_customizer_get_default_option_value($option_id, $data)
{
    $value = false;
    foreach ($data as $section) {
        if (!empty($section['options'])) {
            foreach ($section['options'] as $key => $option) {
                if ($key == $option_id) {
                    $value = $option['setting']['default'];
                }
            }
        }
    }
    return $value;
}

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function zoom_customizer_partial_blogname()
{
    bloginfo('name');
}

/**
 * Render the blog copyright for the selective refresh partial.
 */
function zoom_customizer_partial_blogcopyright()
{
    echo get_option('blogcopyright', sprintf(__('Copyright &copy; %1$s %2$s', 'wpzoom'), date('Y'), get_bloginfo('name')));
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function zoom_customizer_partial_blogdescription()
{
    bloginfo('description');
}

if (!function_exists('zoom_customizer_get_google_font_subsets')) :
    /**
     * Retrieve the list of available Google font subsets.
     *
     * @since  1.0.0.
     *
     * @return array    The available subsets.
     */
    function zoom_customizer_get_google_font_subsets()
    {
        /**
         * Filter the list of supported Google Font subsets.
         *
         * @since 1.2.3.
         *
         * @param array $subsets The list of subsets.
         */
        return apply_filters('zoom_customizer_get_google_font_subsets', array(
            'all' => __('All', 'wpzoom'),
            'cyrillic' => __('Cyrillic', 'wpzoom'),
            'cyrillic-ext' => __('Cyrillic Extended', 'wpzoom'),
            'devanagari' => __('Devanagari', 'wpzoom'),
            'greek' => __('Greek', 'wpzoom'),
            'greek-ext' => __('Greek Extended', 'wpzoom'),
            'khmer' => __('Khmer', 'wpzoom'),
            'latin' => __('Latin', 'wpzoom'),
            'latin-ext' => __('Latin Extended', 'wpzoom'),
            'vietnamese' => __('Vietnamese', 'wpzoom'),
        ));
    }
endif;


add_action('zoom_customizer_display_customization_css', 'zoom_customizer_add_css_rules');