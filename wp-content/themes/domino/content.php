<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php if ( option::is_on('display_thumb') ) {
        get_the_image( array( 'size' => 'loop', 'width' => 640, 'height' => 400, 'before' => '<div class="post-thumb">', 'after' => '</div>' ) );
    } ?>

    <section class="entry-body">

        <?php if ( option::is_on( 'display_category' ) ) printf( '<span class="cat-links">%s</span>', get_the_category_list( ' ' ) ); ?>

        <?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>


        <div class="entry-meta">
            <?php if ( option::is_on( 'display_date' ) )  printf( '<span class="entry-date"><time class="entry-date" datetime="%1$s">%2$s</time></span>', esc_attr( get_the_date( 'c' ) ), esc_html( get_the_date() ) ); ?>
            <?php if ( option::is_on( 'display_author' ) ) { printf( '<span class="entry-author">%s ', __( 'by', 'wpzoom' ) ); the_author_posts_link(); print('</span>'); } ?>
             <?php if ( option::is_on( 'display_comments' ) ) { ?><span class="comments-link"><?php comments_popup_link( __('0 comments', 'wpzoom'), __('1 comment', 'wpzoom'), __('% comments', 'wpzoom'), '', __('Comments are Disabled', 'wpzoom')); ?></span><?php } ?>

            <?php edit_post_link( __( 'Edit', 'wpzoom' ), '<span class="edit-link">', '</span>' ); ?>
        </div>

        <div class="entry-content">
            <?php if (option::is_on('display_content') )  {
                the_excerpt();
            } ?>
        </div>

        <?php if ( option::is_on('display_more') ) { ?>
            <div class="readmore_button">
                <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'wpzoom' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php _e('Continue Reading &rarr;', 'wpzoom'); ?></a>
            </div>
        <?php } ?>

    </section>

    <div class="clearfix"></div>
</article><!-- #post-<?php the_ID(); ?> -->