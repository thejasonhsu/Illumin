(function (wp, $) {
    var api = wp.customize;

    /**
     * A zoomSelect control.
     *
     * @class
     * @augments wp.customize.Control
     * @augments wp.customize.Class
     */
    api.zoomInput = api.Control.extend({
        ready: function () {
            var control = this,
                select = this.container.find('.zoom-input-control');

            select.on('input', function () {
                control.setting.set($(this).val());
            });

            this.setting.bind(function (value) {
                select.val(value);
            });
        }
    });

    api.controlConstructor['zoom-input'] = api.zoomInput;
})(wp, jQuery);