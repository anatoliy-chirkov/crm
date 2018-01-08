$('.call_confirmed-button').click(function() {
    $(this).addClass("hidden");
    $(this).next().removeClass("hidden");
});
