<?php
/*
Template Name: Full-width Page
*/

get_header(); ?>

    <main id="main" class="site-main full-width-page" role="main">

        <div class="inner-wrap">

            <?php while ( have_posts() ) : the_post(); ?>

                <?php get_template_part( 'content', 'page' ); ?>

                <?php if (option::get('comments_page') == 'on') { ?>
                    <?php comments_template(); ?>
                <?php } ?>

            <?php endwhile; // end of the loop. ?>

        </div><!-- /.inner-wrap -->

    </main><!-- #main -->

<?php get_footer(); ?>