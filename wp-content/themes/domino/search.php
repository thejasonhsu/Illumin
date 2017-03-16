<?php get_header(); ?>

<main id="main" class="site-main" role="main">

	<div class="inner-wrap">

	   <h2 class="archive-title"><?php _e('Search Results for','wpzoom');?> <strong>"<?php the_search_query(); ?>"</strong></h2>


	        <?php if ( have_posts() ) : ?>

                <section id="recent-posts" class="recent-posts">

    	            <?php while ( have_posts() ) : the_post(); ?>

    	                <?php

    	                get_template_part( 'content', get_post_format() );
    	                ?>

    	            <?php endwhile; ?>

                </section><!-- .recent-posts -->

	            <?php get_template_part( 'pagination' ); ?>

	        <?php else: ?>

	            <?php get_template_part( 'content', 'none' ); ?>

	        <?php endif; ?>


    </div><!-- /.inner-wrap -->

</main><!-- .site-main -->


<?php
get_footer();
