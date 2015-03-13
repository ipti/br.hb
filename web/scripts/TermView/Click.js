$(document).on('click',".agreedClick",function () {
    $("#updateModal").modal('show');   
    $("#updateModal").attr("data-key", $(this).parent().attr('data-key'));
});

$(document).on('click',"#updateModal-confirm",function () {
    var key = $("#updateModal").attr('data-key');
    submitUpdateTerm(key);
    $("#updateModal").modal('hide'); 
    
});