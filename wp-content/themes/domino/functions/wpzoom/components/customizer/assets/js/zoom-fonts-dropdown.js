(function (wp, $) {
    var api = wp.customize;

    /**
     * A zoomSelect control.
     *
     * @class
     * @augments wp.customize.Control
     * @augments wp.customize.Class
     */
    api.fontsDropdown = api.Control.extend({
        ready: function () {
            var control = this,
                select = this.container.find('.zoom-fonts-dropdown-control');

            select.on('change', function () {
                control.setting.set($(this).val());
            });

            this.setting.bind(function (value) {
                select.val(value);
            });
        }
    });

    api.controlConstructor['zoom-fonts-dropdown'] = api.fontsDropdown;
})(wp, jQuery);