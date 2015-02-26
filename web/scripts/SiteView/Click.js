
    $("#newCampaign, .updateCampaign").click(function () {
        $("#campignModal").modal('show')
            .find("#campignModalContent")
            .load($(this).attr('value'));
    });