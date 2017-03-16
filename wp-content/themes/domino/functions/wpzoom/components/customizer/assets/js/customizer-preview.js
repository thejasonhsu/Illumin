(function ($, rules, _, vein, themeName) {
    $(document).ready(function () {

        var $customCssSelector = $('#' + themeName+'-custom-css');

        var styleSheet = $customCssSelector.length ? $customCssSelector[0].sheet : undefined;

        var utils = {
            fontSize: function (current, value) {

                return parseFloat(value) + 'px';
            },
            display: function (current, value) {
                return value ? 'block' : 'none';
            },
            backgroundGradient : function (current, value) {

                var gradients = [
                    {'background': '-moz-linear-gradient(left,  rgba(239,244,247,0) 27%, ' + value + ' 63%)'}, /* FF3.6+ */
                    {'background': '-webkit-linear-gradient(left,  rgba(239,244,247,0) 27%, ' + value + ' 63%)'}, /* Chrome10+,Safari5.1+ */
                    {'background': '-o-linear-gradient(left,  rgba(239,244,247,0) 27%, ' + value + ' 63%)'}, /* Opera 11.10+ */
                    {'background': '-ms-linear-gradient(left,  rgba(239,244,247,0) 27%, ' + value + ' 63%)'}, /* IE10+ */
                    {'background': 'linear-gradient(to right,  rgba(239,244,247,0) 27%, ' + value + '  63%)}'} /* W3C */
                ];
                _.each(gradients, function(gradient){


                    vein.inject(
                        current.style.selector.split(','),
                        gradient,
                        {'stylesheet': styleSheet}
                    );
                });
            },
            fontFamily: function (current, value) {

                var fontInject = function (fontFamily) {
                    vein.inject(
                        current.style.selector.split(','),
                        {'font-family': fontFamily},
                        {'stylesheet': styleSheet}
                    );
                };

                WebFont.load({
                    google: {
                        families: [value]
                    },
                    fontactive: fontInject
                });

                return value;
            }
        };

        _.each(rules, function (current, key) {

            wp.customize(key, function (value) {

                value.bind(function (newval) {
                    var myObj = {};

                    if (_.isArray(current.style)) {
                        _.each(current.style, function (subcurrent) {
                            myObj[subcurrent.rule] = newval;

                            if (_.findKey(utils, function (value, key) {
                                    return key === $.camelCase(subcurrent.rule)
                                })) {
                                myObj[subcurrent.rule] = utils[$.camelCase(subcurrent.rule)](current, newval);

                                if (subcurrent.rule === 'font-family') {
                                    return;
                                }
                            }

                            vein.inject(
                                subcurrent.selector.split(','),
                                myObj,
                                {'stylesheet': styleSheet}
                            );
                        });
                        return;
                    }

                    myObj[current.style.rule] = newval;

                    if (_.findKey(utils, function (value, key) {
                            return key === $.camelCase(current.style.rule)
                        })) {
                        myObj[current.style.rule] = utils[$.camelCase(current.style.rule)](current, newval);

                        if (current.style.rule === 'font-family') {
                            return;
                        }
                    }

                    vein.inject(
                        current.style.selector.split(','),
                        myObj,
                        {'stylesheet': styleSheet}
                    );
                });
            });
        });
    });
})(jQuery, zoom_customizer_css_rules, _, vein, zoom_customizer_theme_name);

(function ($, domRules, _) {
    $(document).ready(function () {

        var utils = {
            toggleClass: function (object, newval, oldval) {
                $(object.dom.selector).removeClass(oldval);
                $(object.dom.selector).addClass(newval);
            },
            changeStylesheet: function (object, newval, oldval) {
                $('#' + object.dom.selector.replace('*', oldval)).attr('href', function (index, href) {
                    return href.replace(oldval, newval)
                }).attr('id', function (index, id) {
                    return id.replace(oldval, newval)
                });
            }
        };

        _.each(domRules, function (current, key) {
            wp.customize(key, function (value) {
                value.bind(function (newval, oldval) {

                    if (_.findKey(utils, function (value, key) {
                            return key === $.camelCase(current.dom.rule)
                        })) {
                        utils[$.camelCase(current.dom.rule)](current, newval, oldval);
                    }
                });
            });
        });
    });
})(jQuery, zoom_customizer_dom_rules, _);