<?php
/**
 * The Template for displaying all single posts.
 */

get_header(); ?>

<?php $template = get_post_meta($post->ID, 'wpzoom_post_template', true); ?>

    <main id="main" class="site-main<?php if ($template == 'full') { echo ' full-width'; } ?>" role="main">

        <div class="inner-wrap">

            <?php while ( have_posts() ) : the_post(); ?>

                <div class="content-area">

                    <?php get_template_part( 'content', 'single' ); ?>

                    <?php if (option::get('post_comments') == 'on') : ?>

                        <?php comments_template(); ?>

                    <?php endif; ?>

                </div>

            <?php endwhile; // end of the loop. ?>

            <?php if ($template != 'full') {
                get_sidebar();
            } else { echo "<div class=\"clear\"></div>"; } ?>

       </div><!-- /.inner-wrap -->

    </main><!-- #main -->

<?php get_footer(); ?>