<?php
	$featured = new WP_Query(
	array(
		'post__not_in' => get_option( 'sticky_posts' ),
		'posts_per_page' => option::get('slideshow_posts'),
		'meta_key' => 'wpzoom_is_featured',
		'meta_value' => 1
	) );

	$slide_counter = 0;
?>



<div id="slider">

    <h3 class="section-title"><?php echo esc_html( option::get('featured_title') ); ?></h3>

	<?php if ( $featured->have_posts() ) : ?>

		<ul class="slides clearfix">

			<?php while ( $featured->have_posts() ) : $featured->the_post(); ?>

                <?php
                $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'widget-2posts-large');

                $slide_counter++;

                $style = ' style="background-image:url(\'' . $large_image_url[0] . '\')"';

                ?>

                <li class="slide"<?php echo $style; ?>>

                    <div class="slide-overlay">

                        <div class="slide-header">

                            <?php the_title( sprintf( '<h3><a href="%s">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>

                            <div class="entry-meta">
                                <?php if ( option::is_on( 'slider_category' ) ) printf( '<span class="cat-links">%s</span>', get_the_category_list( ', ' ) ); ?>

                                <?php if ( option::is_on( 'slider_date' ) )     printf( '<span class="entry-date"><time class="entry-date" datetime="%1$s">%2$s</time></span>', esc_attr( get_the_date( 'c' ) ), esc_html( get_the_date() ) ); ?>
                                <?php if ( option::is_on( 'slider_comments' ) ) { ?><span class="comments-link"><?php comments_popup_link( __('0 comments', 'wpzoom'), __('1 comment', 'wpzoom'), __('% comments', 'wpzoom'), '', __('Comments are Disabled', 'wpzoom')); ?></span><?php } ?>
                            </div>

                        </div>

                    </div>
                </li>
            <?php endwhile; ?>

		</ul>

	<?php else: ?>

		<div class="empty-slider">
			<p><strong><?php _e( 'You are now ready to set-up your Slideshow content.', 'wpzoom' ); ?></strong></p>

			<p>
				<?php
				printf(
					__( 'For more information about adding posts to the slider, please <a href="%1$s">read the documentation</a>', 'wpzoom' ),
					'http://www.wpzoom.com/documentation/domino/'
				);
				?>
			</p>
		</div>

	<?php endif; ?>

</div><!-- /#slider -->