<?php get_header(); ?>

<main id="main" class="site-main" role="main">

    <div class="inner-wrap">

        <section class="content-area">

            <header class="page-header">

                <h1 class="archive-title"><?php _e( 'Error 404', 'wpzoom' ); ?></h1>

            </header><!-- .page-header -->

            <?php get_template_part( 'content', 'none' ); ?>

        </section><!-- .content-area -->

        <?php get_sidebar(); ?>

    </div><!-- /.inner-wrap -->

</main><!-- .site-main -->

<?php
get_footer();
