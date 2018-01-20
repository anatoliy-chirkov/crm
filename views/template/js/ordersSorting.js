$('.sorting_by_date').change(function() {
    var date = $(this).val();

    $.ajax({
        type: "POST",
        url: "/ajax/getOrders",
        dataType: "html",
        data: {
            date,
        },
        success: function(response) {
            $('.orders-partial').html(response);
        }
    });
});

$('.complete_orders_on_day').change(function() {
    var date = $(this).val();

    $.ajax({
        type: "POST",
        url: "/ajax/getOrdersInOneDay",
        dataType: "html",
        data: {
            date,
        },
        success: function(response) {
            $('.orders-partial').html(response);
        }
    });
});

$('.sorting_by_status').change(function() {
    var status = $(this).val();

    $.ajax({
        type: "POST",
        url: "/ajax/getOrders",
        dataType: "html",
        data: {
            status,
        },
        success: function(response) {
            $('.orders-partial').html(response);
        }
    });
});