<?php

class WPZOOM_Importer extends WXR_Importer
{
    /**
     * Parses the WXR file and prepares us for the task of processing parsed data
     *
     * @param string $file Path to the WXR file for importing
     */
    protected function import_start($file)
    {
        // Suspend bunches of stuff in WP core
        wp_defer_term_counting(true);
        wp_defer_comment_counting(true);
        wp_suspend_cache_invalidation(true);

        // Prefill exists calls if told to
        if ($this->options['prefill_existing_posts']) {
            $this->prefill_existing_posts();
        }
        if ($this->options['prefill_existing_comments']) {
            $this->prefill_existing_comments();
        }
        if ($this->options['prefill_existing_terms']) {
            $this->prefill_existing_terms();
        }

        /**
         *  Set empty array to image_size in order
         */
        add_action('intermediate_image_sizes_advanced', '__return_empty_array');

        /**
         * Begin the import.
         *
         * Fires before the import process has begun. If you need to suspend
         * caching or heavy processing on hooks, do so here.
         */
        do_action('import_start');

    }
}
