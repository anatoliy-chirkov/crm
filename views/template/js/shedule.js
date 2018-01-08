var Shedule = $('.shedule-calendar');

Shedule.datepicker({
    multipleDates: true
});

var SheduleData = Shedule.datepicker().data('datepicker');

$('.shedule_button-master').click(function () {
    var dates = SheduleData.selectedDates;
    var id = $('.user_info').attr('user_id');

    $.ajax({
        type: "POST",
        url: "/ajax/setSheduleForMaster",
        dataType: "html",
        data: {
            id,
            dates
        },
        success: function() {
            $('.shedule_help').html('Сохранено');
        }
    });

});


if ($('.user_info').attr('role_id') == 1) {

    var id = $('.user_info').attr('user_id');

    $.ajax({
        type: "POST",
        url: "/ajax/getSheduleForMaster",
        dataType: "html",
        data: {
            id
        },
        success: function(response) {
            var data = $.parseJSON(response);
            var convertedDates = data.map(function(name) {
                return new Date(name);
            });
            SheduleData.selectDate(convertedDates);
        }
    });
}

$('.shedule_button').click(function () {
    var dates = SheduleData.selectedDates;
    var id = $('.shedule_select').val();

    $.ajax({
        type: "POST",
        url: "/ajax/setSheduleForMaster",
        dataType: "html",
        data: {
            id,
            dates
        },
        success: function() {
            $('.shedule_help').html('Сохранено');
        }
    });
});

$('.shedule_select').change(function () {
    $('.shedule_help').html('');
    var id = $('.shedule_select').val();
    SheduleData.clear();

    $.ajax({
        type: "POST",
        url: "/ajax/getSheduleForMaster",
        dataType: "html",
        data: {
            id
        },
        success: function(response) {
            var data = $.parseJSON(response);
            var convertedDates = data.map(function(name) {
                return new Date(name);
            });
            SheduleData.selectDate(convertedDates);
        }
    });
});
