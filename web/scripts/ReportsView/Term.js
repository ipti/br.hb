
$(document).ready(function () {

    $('#campaign').on('change', function () {
        
        location.href = "/index.php?r=reports%2Fbuild-terms&campaignID="+$(this).val();
        
//        $.ajax({
//            method: "POST",
//            url: "/index.php?r=reports%2Fbuild-terms",
//            data: {campaignID: $(this).val() }
//        }).done(function (result) {
//            console.log(result);
//        });
        
        
        
        
    });

});