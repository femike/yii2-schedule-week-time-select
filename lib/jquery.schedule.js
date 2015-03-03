/**
 * Created by femike on 02.03.15.
 */
(function ($) {

    $.fn.shchedule = function () {
        var init = function (that) {
            return {
                setValue: function () {
                    var values = '';
                    $('#schedule-week-time').find('td.selected').each(function (i, el) {
                        values += $(el).data('value') + ':';
                    });
                    that.val(values.slice(0, -1));
                },
                setSelection: function () {
                    var values = that.val().split(':');
                    if (values.length) {
                        values.map(function (el) {
                            $('td[data-value="' + el + '"]').prop({selected: true}).text('+').addClass('selected');
                        });
                    }
                }
            }
        };
        return init(this);
    };

    $('#schedule-week-time').on('click', 'td.schedule', function () {
        var $this = $(this);
        var attribute = $('#schedule-week-time').data('attribute');
        var $attribute = $(attribute);
        var $shchedule = $attribute.shchedule();
        if ($this.prop('selected')) {
            $this.removeProp('selected').text('-').removeClass('selected');
            $shchedule.setValue();
        } else {
            $this.prop({selected: true}).text('+').addClass('selected');
            $shchedule.setValue();
        }
    });
})(jQuery);