/**
 * Post the FORM to add a new Address.
 * 
 * @param {form} $form
 */
function submitCampaignForm($form) {
    $.post(
        $form.attr("action"),
        $form.serialize()
        )
        $('#campaignModal').modal('hide');
};

