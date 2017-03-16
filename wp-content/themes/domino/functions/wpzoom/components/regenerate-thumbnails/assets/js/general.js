/**
 * general.js workflow for regenerate thumbnails.
 */

(function ($, _, zoomData) {

  var regenerateThumbnails = {
        beforeUnloadCallback: function (e) {
            e.returnValue = zoomData.strings.on_leave_alert; // Gecko, Trident, Chrome 34+
            return zoomData.strings.on_leave_alert; // Gecko, WebKit, Chrome <34
        },
        callbackSteps : function (e) {
            e.preventDefault();

            $.magnificPopup.instance.open({
                items: {
                    'src': regenerateThumbnails.popup.getPopupHtml({
                        header: zoomData.strings.widget_header,
                        content: '<p class="description">' +
                        zoomData.strings.widget_description +
                        '</p>',
                        controls: '<button class="button-primary next-step" id="zoom-load-widgets" >' +
                        zoomData.strings.widget_button +
                        '</button>'
                    }),
                    'type': 'inline'
                },
                modal: true
            });


            $('#zoom-load-widgets').on('click', function () {

                regenerateThumbnails.popup.openOnce({data: {message: zoomData.strings.starting_message}});

                _.delay(
                    function () {
                        $.ajax({
                                type: "post",
                                dataType: "json",
                                url: ajaxurl,
                                data: {
                                    action: 'wpzoom_widgets_default',
                                    '_ajax_nonce': zoomData.nonce_widgets_default
                                }
                            }
                        ).done(function (response) {

                            regenerateThumbnails.popup.instance.close();
                            regenerateThumbnails.popup.instance.open({
                                    items: [{
                                        src: regenerateThumbnails.popup.getPopupHtml({
                                            content: '<div class="dashicons dashicons-yes"></div>' +
                                            '<p class="description">' + zoomData.strings.widget_finished + '</p>',
                                            controls: '<button class="button-secondary next-step" id="zoom-show-user-info" >' +
                                            zoomData.strings.next_step +
                                            '</button>'
                                        }),
                                        type: 'inline'
                                    },
                                        {
                                            src: regenerateThumbnails.popup.getPopupHtml({
                                                    content: zoomData.strings.final_general_message,
                                                    header: zoomData.strings.menu_header,
                                                    controls: '<a class="button-primary" target="_blank" href="' + zoomData.menu_url + '">' + zoomData.strings.menu_button + '</a>' +
                                                    '<button class="button-secondary next-step" id="zoom-show-user-info-2" >' +
                                                    zoomData.strings.next_step +
                                                    '</button>'
                                                }
                                            )
                                        },
                                        {
                                            src: regenerateThumbnails.popup.getPopupHtml({
                                                header: zoomData.strings.reading_settings_header,
                                                content: zoomData.front_page_type === 'static_page' ? zoomData.strings.static_page : zoomData.strings.latest_posts,
                                                controls: '<a class="button-primary" target="_blank" href="' + zoomData.options_reading + '">' + zoomData.strings.reading_settings_button + '</a>' +
                                                '<button  class="button-secondary next-step" id="zoom-show-final-user-info" >' +
                                                zoomData.strings.next_step +
                                                '</button>'
                                            }),
                                            modal: false,
                                            showCloseBtn: true,
                                            type: 'inline'
                                        }
                                    ],
                                    modal: true
                                }
                            );

                        }).fail(function (response, status) {
                            regenerateThumbnails.popup.openWarningMoldal({data: {message: status}});
                        }).always(function () {
                            $('#zoom-show-user-info').on('click', function (e) {
                                e.preventDefault();


                                regenerateThumbnails.popup.instance.goTo(1);


                                $('#zoom-show-user-info-2').on('click', function (e) {
                                    e.preventDefault();

                                    if (zoomData.front_page_type === 'static_page') {
                                        regenerateThumbnails.popup.instance.goTo(2);

                                        $('#zoom-show-final-user-info').on('click', function () {
                                            regenerateThumbnails.popup.instance.close();
                                            regenerateThumbnails.popup.instance.open({
                                                items: {
                                                    src: regenerateThumbnails.popup.getPopupHtml({
                                                        content: '<div class="dashicons dashicons-yes"></div>' +
                                                        '<p class="description">' + zoomData.strings.set_front_page_option_message + '</p>',
                                                        controls: '<div style="text-align:center"><a href="' + zoomData.site_url + '" target="_blank" class="button-primary">' +
                                                        zoomData.strings.view_site_button +
                                                        '</a></div>'
                                                    })
                                                },
                                                modal: false,
                                                type: 'inline'
                                            });

                                            $(window).off('beforeunload', regenerateThumbnails.beforeUnloadCallback);

                                        });

                                    } else {

                                        $.ajax({
                                            type: "post",
                                            dataType: "json",
                                            url: ajaxurl,
                                            data: {
                                                action: 'zoom_set_front_page_option',
                                                'nonce_set_front_page_option': zoomData.nonce_set_front_page_option
                                            }
                                        }).done(function () {
                                            regenerateThumbnails.popup.instance.close();
                                            regenerateThumbnails.popup.instance.open({
                                                items: {
                                                    src: regenerateThumbnails.popup.getPopupHtml({
                                                        content: '<div class="dashicons dashicons-yes"></div>' +
                                                        '<p class="description">' + zoomData.strings.set_front_page_option_message + '</p>',
                                                        controls: '<div style="text-align:center"><a href="' + zoomData.site_url + '" target="_blank" class="button-primary">' +
                                                        zoomData.strings.view_site_button +
                                                        '</a></div>'
                                                    })
                                                },
                                                modal: false,
                                                type: 'inline'
                                            });

                                            $(window).off('beforeunload', regenerateThumbnails.beforeUnloadCallback);

                                        });
                                    }
                                });
                            });
                        });
                    }, 500
                );
            })
        },
        popup: {
            instance: $.magnificPopup.instance,
            getPopupHtml: function (data) {
                var opts = $.extend({
                    header: false,
                    content: false,
                    controls: false
                }, data);

                var header = opts.header ? '<div class="white-popup-header">' + opts.header + '</div>' : '<div class="white-popup-header no-border"></div>';
                var content = '<div class="white-popup-content">' + (opts.content ? opts.content : '') + '</div>';
                var controls = '<div class="white-popup-controls' + (opts.controls ? '' : 'no-border') + '">' + (opts.controls ? opts.controls : '') + '</div>';

                var html = '<div class="white-popup">' +
                    header +
                    content +
                    controls +
                    '</div>';
                return html;
            },
            getPopupItem: function (data) {
                var currentThumb = zoomData.thumbs.length - data._thumbsLength + 1;
                var thumbsLength = zoomData.thumbs.length;

                var dataOpts = data.success ? {
                    header: '<div class="white-popup-header-progress-wrapper">' +
                    '<div class="white-popup-header-progress" style="width:' + ( (currentThumb * 100) / thumbsLength) + '%"></div>' +
                    '</div>',
                    'content': '<div class="cssload-container">' +
                    '<div class="cssload-whirlpool"></div>' +
                    '</div>' +
                    '<p class="description">' + data.data.message + '</p>',
                    controls: '<p class="description">' +
                    (zoomData.strings.images_progress.replace('{1}', currentThumb).replace('{2}', thumbsLength))
                    + '</p>'
                } :
                {
                    content: '<p class="description warning-msg">' + data.data.message + '</p>'
                };

                return [
                    {
                        src: regenerateThumbnails.popup.getPopupHtml(dataOpts),
                        type: 'inline'
                    }
                ];
            },
            openOnce: function (data) {
                regenerateThumbnails.popup.instance.open({
                    items: {
                        src: regenerateThumbnails.popup.getPopupHtml({
                            content: '<div class="cssload-container">' +
                            '<div class="cssload-whirlpool"></div>' +
                            '</div>' +
                            '<p class="description">' + data.data.message + '</p>'
                        }),
                        type: 'inline'
                    },
                    modal: true
                }, 0);
            },
            openWarningMoldal: function (data) {
                regenerateThumbnails.popup.instance.close();
                regenerateThumbnails.popup.instance.open({
                    items: {
                        src: '<div class="white-popup">' +
                        '<p class="description warning-msg">' + data.data.message + '</p>' +
                        '</div>',
                        type: 'inline'
                    }
                }, 0);
            }
        },
        runAjax: function (thumbs) {
            var first = _.first(thumbs);


            $.ajax({
                    type: "post",
                    dataType: "json",
                    url: ajaxurl,
                    data: {
                        action: 'zoom_regenerate_thumbnails',
                        'thumb_id': first,
                        'nonce_regenerate_thumbnail': zoomData.nonce_regenerate_thumbnail
                    }
                }
            ).retry({times: 5, statusCodes: [503, 504, 500, 502]}).done(function () {
                // on done
            }).fail(function () {
                // on fail
            }).always(function (data, textStatus, jqxhr) {

                if (textStatus === 'error') {
                    regenerateThumbnails.popup.openWarningMoldal({data: {message: jqxhr}});
                    return;
                }

                if (data.data.halt) {
                    regenerateThumbnails.popup.openWarningMoldal(data);
                    return;
                }

                data._thumbsLength = thumbs.length;
                regenerateThumbnails.popup.instance.items = regenerateThumbnails.popup.getPopupItem(data);
                regenerateThumbnails.popup.instance.updateItemHTML();

                if (thumbs.length > 1) {
                    regenerateThumbnails.runAjax(_.rest(thumbs));
                } else {

                    _.delay(function () {
                        regenerateThumbnails.popup.instance.open({
                            items: {
                                src: regenerateThumbnails.popup.getPopupHtml({
                                    content: '<div class="dashicons dashicons-yes"></div>' +
                                    '<p class="description">' + zoomData.strings.thumbnail_finished + '</p>',
                                    controls: '<button class="button-secondary load-widget-step next-step">' + zoomData.strings.next_step + '</button>'
                                }),
                                type: 'inline'
                            }
                        }, 0);

                        $('.load-widget-step').on('click', regenerateThumbnails.callbackSteps);
                    }, 1000);
                }
            })
        }
    };
    $(document).ready(function () {

        $('#misc_load_demo_content').on('click', function () {
            $(window).on('beforeunload', regenerateThumbnails.beforeUnloadCallback);
        });

        $('body').on('wpzoom:load_demo_content:done', function () {

            regenerateThumbnails.popup.instance.open({
                items: [
                    {
                        'src': regenerateThumbnails.popup.getPopupHtml(
                            {
                                content: '<div class="dashicons dashicons-yes"></div>' +
                                '<p class="description">' + zoomData.strings.import_finished + '</p>',
                                controls: '<button class="button-secondary next-step" id="zoom-show-regenerate-thumbnails" >' +
                                zoomData.strings.next_step +
                                '</button>'
                            }
                        ),
                        'type': 'inline'
                    },
                    {
                        'src': regenerateThumbnails.popup.getPopupHtml({
                            header: zoomData.strings.thumbnail_header,
                            content: '<p class="description">' +
                            zoomData.strings.thumbnail_description +
                            '</p>',
                            controls: '<button   style="float:left" class="button-secondary" id="zoom-skip-regenerate-thumbnails" >' +
                    zoomData.strings.skip_thumbnail_button +
                    '</button>' +
                            '<button class="button-primary next-step" id="zoom-regenerate-thumbnails" >' +
                            zoomData.strings.thumbnail_button +
                            '</button>'
                        }),
                        'type': 'inline'
                    }

                ],
                modal: true
            }, 0);



            $('#zoom-show-regenerate-thumbnails').on('click', function (e) {
                e.preventDefault();
                regenerateThumbnails.popup.instance.goTo(1);

                $('#zoom-skip-regenerate-thumbnails').on('click', regenerateThumbnails.callbackSteps);

                $('#zoom-regenerate-thumbnails').on('click', function (e) {
                    e.preventDefault();

                    regenerateThumbnails.popup.openOnce({data: {message: zoomData.strings.starting_message}});

                    $.ajax({
                        type: "post",
                        dataType: "json",
                        url: ajaxurl,
                        data: {
                            action: 'zoom_get_thumbnails',
                            'nonce_get_thumbnails': zoomData.nonce_get_thumbnails
                        }
                    }).done(function (response) {
                        zoomData.thumbs = response.data.thumbs;
                        regenerateThumbnails.runAjax(zoomData.thumbs);
                    });
                });
            });

        });
    });
})(jQuery, _, zoom_regenerate_thumbnails);
