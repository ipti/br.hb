
    $("#newCampaign, .updateCampaign").click(function () {
        $("#campaignModal").modal('show')
            .find("#campaignModalContent")
            .load($(this).attr('value'));
    });