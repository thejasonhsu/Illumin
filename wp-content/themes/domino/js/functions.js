/**
 * Theme functions file
 */
(function ($) {
    'use strict';

    var $document = $(document);
    var $window = $(window);


    /**
    * Document ready (jQuery)
    */
    $(function () {


        /**
         * Activate superfish menu.
         */
        $('.sf-menu').superfish({
            'speed': 'fast',
            'delay' : 0,
            'animation': {
                'height': 'show'
            }
        });


        /**
         * Activate jQuery.mmenu.
         */
        $("#menu-top-slide").mmenu({
            "slidingSubmenus": false,
            "extensions": [
                "theme-dark",
                "pageshadow",
                "border-full"
            ]
        });

        $("#menu-main-slide").mmenu({
            "slidingSubmenus": false,
            "extensions": [
                "theme-dark",
                "pageshadow",
                "border-full"
            ]
        });


        /* Sticky Sidebar */

        $('#sidebar').theiaStickySidebar({
            additionalMarginTop: 40
        });

        $('.related_posts').theiaStickySidebar({
            additionalMarginTop: 40
        });



        /**
         * FitVids - Responsive Videos in posts
         */
        $(".entry-content").fitVids();



        /**
         * News ticker.
         */
        $('#ticker').ticker();



    });

    $window.on('load', function() {
        /**
         * Activate main slider.
         */
        $('#slider').sllider();

    });


    $.fn.sllider = function() {
        return this.each(function () {
            var $this = $(this);

            var flky = new Flickity('.slides', {
                autoPlay: (zoomOptions.slideshow_auto ? parseInt(zoomOptions.slideshow_speed, 10) : false),
                cellAlign: 'center',
                contain: true,
                percentPosition: false,
                pageDots: true,
                accessibility: false,
                wrapAround: true
            });
        });
    };



    $.fn.ticker = function() {
        return this.each(function () {
            var $this = $(this);

            var _scroll = {
                delay: 1000,
                easing: 'linear',
                items: 1,
                duration: 0.05,
                timeoutDuration: 0,
                pauseOnHover: 'immediate'
            };

            $this.carouFredSel({
                width: 1000,
                align: false,
                items: {
                    width: 'variable',
                    height: 35,
                    visible: 1
                },
                scroll: _scroll
            });

            $this.parent('.caroufredsel_wrapper').css('width', '100%');
        }) ;
    };



})(jQuery);

new UISearch( document.getElementById( 'sb-search' ) );