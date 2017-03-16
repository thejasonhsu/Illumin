<?php
/**
 * The template for displaying the footer
 *
 */

$widgets_areas = (int) get_theme_mod( 'footer-widget-areas', domino_get_default( 'footer-widget-areas' ) );

$has_active_sidebar = false;
if ( $widgets_areas > 0 ) {
    $i = 1;

    while ( $i <= $widgets_areas ) {
        if ( is_active_sidebar( 'footer_' . $i ) ) {
            $has_active_sidebar = true;
            break;
        }

        $i++;
    }
}

?>

    <footer id="colophon" class="site-footer" role="contentinfo">

        <?php if ( $has_active_sidebar ) : ?>

            <div class="footer-widgets widgets widget-columns-<?php echo esc_attr( $widgets_areas ); ?>">

                <div class="inner-wrap">

                    <?php for ( $i = 1; $i <= $widgets_areas; $i ++ ) : ?>

                        <div class="column">
                            <?php dynamic_sidebar( 'footer_' . $i ); ?>
                        </div><!-- .column -->

                    <?php endfor; ?>

                    <div class="clear"></div>

                </div><!-- .inner-wrap -->

            </div><!-- .footer-widgets -->


        <?php endif; ?>

        <div class="site-info-top">

            <div class="inner-wrap">

                <div class="navbar-brand">
                    <h2><a href="<?php echo home_url(); ?>" title="<?php bloginfo( 'description' ); ?>"><?php bloginfo( 'name' );  ?></a></h2>

                </div><!-- .navbar-brand -->

                <div class="footer-menu">
                    <?php
                    if ( has_nav_menu( 'tertiary' ) ) {
                        wp_nav_menu( array(
                            'container' => 'menu',
                            'container_class' => '',
                            'menu_id' => 'secondmenu',
                            'sort_column' => 'menu_order',
                            'theme_location' => 'tertiary',
                            'depth' => 1
                        ) );
                    }
                    ?>
                </div>

                <div class="clear"></div>

            </div><!-- .inner-wrap -->

        </div><!-- .site-info-top -->


        <div class="site-info">

            <div class="inner-wrap">

                <p class="copyright">
                    <?php echo get_theme_mod( 'footer-text', domino_get_default( 'footer-text' ) ); ?>. <?php printf( __( 'Designed by %s', 'wpzoom' ), '<a href="http://www.wpzoom.com/" target="_blank" rel="designer">WPZOOM</a>' ); ?>
                </p>

            </div><!-- .inner-wrap -->

        </div><!-- .site-info -->


    </footer><!-- #colophon -->

</div>
<?php wp_footer(); ?>

</body>
</html>