$(document).on('click',".attendedClick",function () {
    $("#updateAttendedModal").modal("show");
    $("#updateAttendedModal").attr("consultation-key", $(this).parent().attr('consultation-key'));
});

$(document).on('click', "#updateAttendedModal-confirm", function(){
    var key = $("#updateAttendedModal").attr('consultation-key');
    submitUpdateAttended(key);
    $("#updateAttendedModal").modal('hide');
});

$(document).on('click',".deliveredClick",function () {
    $("#updateDeliveredModal").modal("show");
    $("#updateDeliveredModal").attr("consultation-key", $(this).parent().attr('consultation-key'));
});

$(document).on('click', "#updateDeliveredModal-confirm", function(){
    var key = $("#updateDeliveredModal").attr('consultation-key');    
    submitUpdateAttended(key);
    submitUpdateDelivered(key);
    $("#updateDeliveredModal").modal('hide');
});

$(document).on('click',"#selectLetterOptions",function () {
    $("#selectLetterOptionsModal").modal('show');
});

$("#submit-consultation-letter").click(function () {
    var $form = $('form#form-consultation-letter');
    $form.submit();
});