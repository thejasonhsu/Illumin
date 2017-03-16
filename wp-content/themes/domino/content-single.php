<?php

    $show_media = get_post_meta($post->ID, 'wpzoom_show_media', true);

    $template = get_post_meta($post->ID, 'wpzoom_post_template', true);

    if ($template == 'full') {
        $media_width = 1400;
        $size = "single-full";
    }
    else {
        $media_width = 1000;
        $size = "single";
    }

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <header class="entry-header">

        <?php if ( option::is_on( 'post_thumb' ) && has_post_thumbnail() ) {

            if (!$show_media == 1 || !$show_media) {

                get_the_image( array( 'size' => $size, 'width' => $media_width, 'attachment' => false, 'image_scan' => false, 'before' => '<div class="post-thumb">', 'after' => '</div>', 'link_to_post' => false ) );

            }
        } ?>

        <?php if ( option::is_on( 'post_category' ) ) : ?><span class="entry-category"><?php the_category( ', ' ); ?></span><?php endif; ?>

        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>


        <div class="entry-meta">
            <?php if ( option::is_on( 'post_author' ) )  {

                printf( '<span class="entry-author vcard author">%1$s <a class="url fn n" href="%2$s">%3$s</a></span>',
                    __( 'Written by ', 'wpzoom' ),
                    esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                    get_the_author()
                );

                } ?>

            <?php if ( option::is_on( 'post_date' ) ) { ?>

                <span class="entry-date"><?php _e( 'on', 'wpzoom' ); ?> <?php printf( '<time class="entry-date updated published" datetime="%1$s">%2$s</time> ', esc_attr( get_the_date( 'c' ) ), esc_html( get_the_date() ) ); ?></span>

            <?php } ?>


            <?php edit_post_link( __( 'Edit', 'wpzoom' ), '<span class="edit-link">', '</span>' ); ?>
        </div>

    </header><!-- .entry-header -->


    <div class="clear"></div>

    <div class="post-area">

        <?php if (option::get('post_related') == 'on') {
            get_template_part('related-posts');
        } ?>


        <div class="post-inner">

            <div class="entry-content">

                <?php the_content(); ?>

                <div class="clear"></div>

                <?php if ( option::is_on('banner_post_enable')  ) { // Banner after post ?>

                    <div class="adv_content">
                    <?php
                        if ( option::get('banner_post_html') <> "" ) {
                            echo stripslashes(option::get('banner_post_html'));
                        } else {
                            ?><a href="<?php echo option::get('banner_post_url'); ?>"><img src="<?php echo option::get('banner_post'); ?>" alt="<?php echo option::get('banner_post_alt'); ?>" /></a><?php
                        }

                    ?></div><?php
                } ?>


            </div><!-- .entry-content -->


            <footer class="entry-footer">

                <?php
                    wp_link_pages( array(
                        'before' => '<div class="page-links">' . __( 'Pages:', 'wpzoom' ),
                        'after'  => '</div>',
                    ) );
                ?>


                <?php if ( option::is_on( 'post_tags' ) ) echo preg_replace( '/<a([^>]+)>([^<]+)<\/a>/i', '<a$1><span>$2</span></a>', get_the_tag_list( '<ul class="tags clearfix"><li>', '</li><li>', '</li></ul>' ) ); ?>


                <?php if ( option::is_on( 'post_author_box' ) ) : ?>

                    <div class="post_author">

                        <?php echo get_avatar( get_the_author_meta( 'ID' ) , 90 ); ?>

                        <div class="author-description">
                            <h3 class="author-title author"><?php the_author_posts_link(); ?></h3>

                            <div class="author_links">

                                <?php if ( get_the_author_meta( 'facebook_url' ) ) { ?><a class="author_facebook" href="<?php the_author_meta( 'facebook_url' ); ?>" title="Facebook Profile" target="_blank"></a><?php } ?>


                                <?php if ( get_the_author_meta( 'twitter' ) ) { ?><a class="author_twitter" href="https://twitter.com/<?php the_author_meta( 'twitter' ); ?>" title="Follow <?php the_author_meta( 'display_name' ); ?> on Twitter" target="_blank"></a><?php } ?>


                                <?php if ( get_the_author_meta( 'instagram_url' ) ) { ?><a class="author_instagram" href="https://instagram.com/<?php the_author_meta( 'instagram_url' ); ?>" title="Instagram" target="_blank"></a><?php } ?>

                            </div>


                            <p class="author-bio">
                                <?php the_author_meta( 'description' ); ?>
                            </p>
                        </div>

                    </div>

                <?php endif; ?>


            </footer><!-- .entry-footer -->

        </div><!-- .post-inner -->

    </div><!-- .post-area -->

</article><!-- #post -->