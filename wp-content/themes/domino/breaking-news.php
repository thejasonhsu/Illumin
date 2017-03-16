<?php
$loop = new WP_Query( array(
    'post__not_in' => get_option( 'sticky_posts' ),
    'posts_per_page' => option::get( 'breaking_number' ),
    'meta_key' => 'wpzoom_is_breaking',
    'meta_value' => 1
) );
?>

<?php if ( $loop->have_posts() ) :?>

    <div id="news-ticker">
        <div class="inner-wrap clearfix">

            <h3><?php _e('Breaking News', 'wpzoom'); ?></h3>

            <div class="news-ticker-container">
                <dl id="ticker">

                    <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

                        <dt><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . __(' ago', 'wpzoom'); ?> </dt>
                        <dd><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></dd>

                    <?php endwhile; ?>

                    <?php wp_reset_postdata(); ?>

                </dl>
            </div>

        </div><!-- /.inner-wrap -->
    </div><!-- #news-ticker -->

<?php endif; ?>
