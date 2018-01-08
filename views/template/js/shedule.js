var Shedule = $('.shedule-calendar');

Shedule.datepicker({
    multipleDates: true
});

var SheduleData = Shedule.datepicker().data('datepicker');

var Dates = SheduleData.selectedDates;

//Нужно из HTML взять массив выбранных дат, id мастера, событие нажатия кнопки
//Ajax'ом отправить в контроллер (POST)
