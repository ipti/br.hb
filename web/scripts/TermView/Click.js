$(document).on('click',".agreedClick",function () {
    submitUpdateTerm($(this).parent().attr('term-key'));
});

$(document).on('click',"#selectSchoolButton",function () {
    $("#selectSchoolModal").modal('show');
});

$(document).on('click',"#selectSchoolModal-confirm",function () {
    var s = $("#schools").val();
    var c = $("#schools").attr('campaign');
    location.href = "/index.php?r=reports/agreed-terms&cid="+c+"&sid="+s;
    $("#selectSchoolModal").modal('hide'); 
    
});

$("#newTerm").click(function () {
        $("#termModal").modal('show')
            .find("#termModalContent")
            .load($(this).attr('value'));
    });