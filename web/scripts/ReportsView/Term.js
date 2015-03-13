
$(document).ready(function () {

    $('#campaign').on('change', function () {
        $.ajax({
            method: "POST",
            url: "/index.php?r=reports%2Fbuild-terms",
            data: {campaignID: $(this).val() }
        }).done(function (result) {
            console.log(result);
        });
    });

});