<?php
/*
Template Name: Archives Page
*/
?>
<?php get_header(); ?>

    <main id="main" class="site-main" role="main">

        <div class="inner-wrap">

            <?php while (have_posts()) : the_post(); ?>

                <div class="content-area">

                	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                	    <div class="entry-content">

                            <div class="entry-info">
                                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

                                <?php edit_post_link( __( 'Edit', 'wpzoom' ), '<span class="edit-link">', '</span>' ); ?>

                            </div>


        					<div class="col_arch">
        						<h3><?php _e('Popular Categories:', 'wpzoom'); ?></h3>

        						<ul>
        							<?php wp_list_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'show_count' => 1, 'title_li' => '', 'hierarchical' => 0, 'number' => 10 ) ); ?>
        						</ul><div class="clear"></div>
        					</div>



        					<div class="col_arch">
        						<h3><?php _e('Archives:', 'wpzoom'); ?></h3>

        						<ul>
        							<?php wp_get_archives('type=monthly&show_post_count=1') ?>
        						</ul><div class="clear"></div>

        					</div>

        					<div class="col_arch">
        						<h3><?php _e('Tags:', 'wpzoom'); ?></h3>

        						<?php the_widget( 'WP_Widget_Tag_Cloud', 'title= ' ); ?>

        					</div><div class="clear"></div>
                 	    </div><!-- .entry-content -->

                	</article><!-- #post-## -->

                </div>

    		<?php endwhile; ?>

            <?php get_sidebar(); ?>

        </div><!-- /.inner-wrap -->

    </main><!-- #main -->

<?php get_footer(); ?>