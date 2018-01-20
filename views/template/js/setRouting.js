$('.stop_routing-checkbox').change(function() {
    var stop_routing = $(this).prop('checked');
    var id = $('.order_id-input').val();

    stop_routing = !stop_routing;

    $.ajax({
        type: "POST",
        url: "/orders/actionStopRouting",
        dataType: "html",
        data: {
            id,
            stop_routing,
        }
    });
});