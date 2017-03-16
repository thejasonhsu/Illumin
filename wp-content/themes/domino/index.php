<?php get_header(); ?>

<?php if ( is_home() && $paged < 2 ) { // This allows us to display the Featured area only on the Front Page ?>

	<div class="featured_area">

		<div class="inner-wrap">

			<?php if ( option::is_on('featured_posts_show') ) get_template_part('wpzoom-slider'); // Featured Slider ?>

			<div class="slider_widgets">
				<?php dynamic_sidebar('Right of Slider'); ?>
			</div><div class="clear"></div>

			<?php
			if ( is_active_sidebar( 'home-main' ) ) { // Widget area for Carousel
				?><div class="home_widgets">
					<?php dynamic_sidebar('Below the Slider (full-width)'); ?>
					<div class="clear"></div>
				</div><?php
			}
			?>

		</div><!-- /.inner-wrap -->

	</div><!--/.featured_area -->

<?php } ?>



<div id="main" role="main">

    <?php if ( is_home() && $paged < 2 ) { ?>

        <?php if ( is_active_sidebar( 'home-categories' ) ) { // Widget area for Featured Categories ?>

        	<div class="inner-wrap">

        		<section class="content-area">

                    <?php dynamic_sidebar('Featured Categories (Homepage)'); ?>

        		</section><!-- .content-area -->

                <?php get_sidebar(); // Sidebar appears on the right of Featured Categories ?>

        	</div><!-- /.inner-wrap -->

        <?php } ?>


    	<?php if ( is_active_sidebar( 'home-video' ) ) { // Widget area with dark background

    		echo '<div class="video-area">';

        		echo '<div class="inner-wrap">';

                    dynamic_sidebar('Video Area');

        		echo '</div>';

    		echo '</div>';

    	} ?>

    <?php } ?>


    <?php if ( $paged > 1 || option::is_on('recent_posts') ) { ?>

    	<div class="inner-wrap">

        	<h2 class="section-title">

                <?php if ( is_front_page() ) : ?>

                    <?php echo esc_html( option::get('recent_title') ); ?>

                <?php else: ?>

                    <?php echo get_the_title( get_option( 'page_for_posts' ) ); ?>

                <?php endif; ?>

             </h2>



            <?php if ( have_posts() ) : ?>

                <section id="recent-posts" class="recent-posts">


                    <?php while ( have_posts() ) : the_post();  ?>

                        <?php get_template_part( 'content', get_post_format() ); ?>


                    <?php endwhile; ?>

                </section>

                <?php get_template_part( 'pagination' ); ?>

            <?php else: ?>

                <?php get_template_part( 'content', 'none' ); ?>

            <?php endif; ?>


        </div><!-- /.inner-wrap -->

    <?php } ?>

 	<div class="clear"></div>

</div><!-- /#main -->

<?php get_footer(); ?>