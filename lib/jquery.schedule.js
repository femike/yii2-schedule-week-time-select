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

    $('#schedule-week-time')./**/on('click', 'td.schedule', function () {
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

    $('#schedule-buttons').on('click', 'a', function () {
        var attribute = $('#schedule-week-time').data('attribute');
        var $attribute = $(attribute);
        var $shchedule = $attribute.shchedule();

        $('td.schedule.selected').each(function () {
            $(this).removeProp('selected').text('-').removeClass('selected');
        });

        var id = $(this).attr('id');

        var hour_start = 0;
        var hour_end = 23;
        var day_start = 0;
        var day_end = 6;

        if (id == 'weekdays') {
            day_start = 0;
            day_end = 4;
        } else if (id == 'weekend') {
            day_start = 5;
            day_end = 6;
        } else if (id == 'working-hours') {
            day_start = 0;
            day_end = 4;
            hour_start = 10;
            hour_end = 18;
        }

        for (var day = day_start; day <= day_end; day++) {
            for (var hour = hour_start; hour <= hour_end; hour++) {
                $("td.schedule[data-value='" + day + "_" + hour + "']").prop({selected: true}).text('+').addClass('selected');
            }
        }
        $shchedule.setValue();
    })
})(jQuery);