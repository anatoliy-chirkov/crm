$('.status-button').change(function() {
   var status_id = $(this).val();

   $.ajax({
        type: "POST",
        url: "/ajax/getFinalReportFields",
        dataType: "html",
        data: {
            status_id,
        },
        success: function(response) {
            $('.fluid_fields').html(response);
        }
    });
});
