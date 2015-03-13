
$(document).ready(function () {

    $('#campaign').on('change', function () {
        
        location.href = "/index.php?r=reports%2Fbuild-terms&campaignID="+$(this).val();
        
        });

});