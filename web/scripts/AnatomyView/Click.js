$("#newAnatomy").click(function () {
        $("#anatomyModal").modal('show')
            .find("#anatomyModalContent")
            .load($(this).attr('value'));
    });
    
$(document).on('click',".agreedClick",function () {
    var eid = $(this).parent().attr("data-key");
    $("#anatomyModal").modal('show')
        .find("#anatomyModalContent")
        .load($(this).attr('link')+"&eid="+eid);
});