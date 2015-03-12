    $("document").ready(function(){
        $(".report-content").hide();
        $("#print-button").hide();
    });


    $("#submit-consultation-letter").click(function () {
        var $form = $('form#form-consultation-letter');
        $(".report-content").hide();
        $("#print-button").hide();
        submitConsultationLetter($form);
    });