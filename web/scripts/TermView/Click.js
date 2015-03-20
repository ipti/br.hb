$(document).on('click',".agreedClick",function () {
    $("#updateModal").modal('show');   
    $("#updateModal").attr("term-key", $(this).parent().attr('term-key'));
});

$(document).on('click',"#updateModal-confirm",function () {
    var key = $("#updateModal").attr('term-key');
    submitUpdateTerm(key);
    $("#updateModal").modal('hide'); 
    
});

$(document).on('click',"#selectSchoolButton",function () {
    $("#selectSchoolModal").modal('show');
});

$(document).on('click',"#selectSchoolModal-confirm",function () {
    var s = $("#schools").val();
    var c = $("#schools").attr('campaign');
    location.href = "/index.php?r=reports/agreed-terms&cid="+c+"&sid="+s;
    $("#updateModal").modal('hide'); 
    
});