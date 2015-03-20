$(document).on('click',".agreedClick",function () {
    $("#updateModal").modal('show');   
    $("#updateModal").attr("term-key", $(this).parent().attr('term-key'));
});

$(document).on('click',"#updateModal-confirm",function () {
    var key = $("#updateModal").attr('term-key');
    submitUpdateTerm(key);
    $("#updateModal").modal('hide'); 
    
});