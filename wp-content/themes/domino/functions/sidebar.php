<?php

/*-----------------------------------------------------------------------------------*/
/* Initializing Widgetized Areas (Sidebars)                                          */
/*-----------------------------------------------------------------------------------*/


/*----------------------------------*/
/* Sidebars                         */
/*----------------------------------*/

register_sidebar( array(
	'name' => 'Sidebar',
	'id' => 'sidebar',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '<div class="clear"></div></div>',
	'before_title' => '<h3 class="title">',
	'after_title' => '</h3>'
) );



/* Header - for social icons
===============================*/

register_sidebar(array(
    'name'=>'Header Social Icons',
    'id' => 'header_social',
    'description' => 'Widget area in the header. Install the "Social Icons Widget by WPZOOM" plugin and add the widget here.',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3 class="title"><span>',
    'after_title' => '</span></h3>',
));



/*----------------------------------*/
/* Right side of slider             */
/*----------------------------------*/

register_sidebar( array(
	'name' => 'Right of Slider',
	'id' => 'slider',
	'description' => 'Widget area on the right side of the featured slider. Add here "Featured Category" widget. Works only with 2 widgets with 2 posts each.',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '<div class="clear"></div></div>',
	'before_title' => '<h3 class="title">',
	'after_title' => '</h3>'
) );


/*----------------------------------*/
/* Homepage                         */
/*----------------------------------*/

register_sidebar( array(
	'name' => 'Below the Slider (full-width)',
	'id' => 'home-main',
	'description' => 'Widget area for: "WPZOOM: Carousel Slider" widget.',
	'before_widget' => '<div class="widget %2$s" id="%1$s">',
	'after_widget' => '<div class="clear">&nbsp;</div></div>',
	'before_title' => '<h3 class="title">',
	'after_title' => '</h3>'
) );

register_sidebar( array(
	'name' => 'Featured Categories (Homepage)',
	'id' => 'home-categories',
	'description' => 'Widget area for: "Featured Category" widgets.',
	'before_widget' => '<div class="widget %2$s" id="%1$s">',
	'after_widget' => '<div class="clear">&nbsp;</div></div>',
	'before_title' => '<h3 class="title">',
	'after_title' => '</h3>'
) );


register_sidebar( array(
	'name' => 'Video Area',
	'id' => 'home-video',
	'description' => 'Widget area for: "Featured Category" widgets.',
	'before_widget' => '<div class="widget %2$s" id="%1$s">',
	'after_widget' => '<div class="clear">&nbsp;</div></div>',
	'before_title' => '<h3 class="title">',
	'after_title' => '</h3>'
) );



/*----------------------------------*/
/* Footer widgetized areas		    */
/*----------------------------------*/

register_sidebar( array(
    'name'          => 'Footer: Column 1',
    'id'            => 'footer_1',
    'before_widget' => '<div class="widget %2$s" id="%1$s">',
    'after_widget'  => '<div class="clear"></div></div>',
    'before_title'  => '<h3 class="title">',
    'after_title'   => '</h3>',
) );

register_sidebar( array(
    'name'          => 'Footer: Column 2',
    'id'            => 'footer_2',
    'before_widget' => '<div class="widget %2$s" id="%1$s">',
    'after_widget'  => '<div class="clear"></div></div>',
    'before_title'  => '<h3 class="title">',
    'after_title'   => '</h3>',
) );

register_sidebar( array(
    'name'          => 'Footer: Column 3',
    'id'            => 'footer_3',
    'before_widget' => '<div class="widget %2$s" id="%1$s">',
    'after_widget'  => '<div class="clear"></div></div>',
    'before_title'  => '<h3 class="title">',
    'after_title'   => '</h3>',
) );

register_sidebar( array(
    'name'          => 'Footer: Column 4',
    'id'            => 'footer_4',
    'before_widget' => '<div class="widget %2$s" id="%1$s">',
    'after_widget'  => '<div class="clear"></div></div>',
    'before_title'  => '<h3 class="title">',
    'after_title'   => '</h3>',
) );
