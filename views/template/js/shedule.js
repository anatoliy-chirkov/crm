var Datepicker = $('.datepicker-here');

Datepicker.datepicker({
    multipleDates: true
});

var DatepickerData = Datepicker.datepicker().data('datepicker');

var Dates = DatepickerData.selectedDates;

//Нужно из HTML взять массив выбранных дат, id мастера, событие нажатия кнопки
//Ajax'ом отправить в контроллер (POST)
