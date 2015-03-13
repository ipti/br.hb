$(document).on('click',".attendedClick",function () {
    $("#updateAttendedModal").modal("show");
    $("#updateAttendedModal").attr("data-key", $(this).parent().attr('data-key'));
});

$(document).on('click', "#updateAttendedModal-confirm", function(){
    var key = $("#updateAttendedModal").attr('data-key');
    submitUpdateAttended(key);
    $("#updateAttendedModal").modal('hide');
});

$(document).on('click',".deliveredClick",function () {
    $("#updateDeliveredModal").modal("show");
    $("#updateDeliveredModal").attr("data-key", $(this).parent().attr('data-key'));
});

$(document).on('click', "#updateDeliveredModal-confirm", function(){
    var key = $("#updateDeliveredModal").attr('data-key');    
    submitUpdateAttended(key);
    submitUpdateDelivered(key);
    $("#updateDeliveredModal").modal('hide');
});