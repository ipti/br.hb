/**
 * Post the FORM to add a new Address.
 * 
 * @param {form} $form
 */
function submitCampaignForm($form) {
    $('#campaignModal button[type=submit]').html('<i class="fa fa-spinner  fa-spin"></i> Criando...');
    $('#campaignModal button[type=submit]').click(function(e){
        e.preventDefault();
    });
    $.post(
        $form.attr("action"),
        $form.serialize()
    ).done(function(){
        window.location.assign("/");
    }).fail(function(){
        window.location.assign("/");
    });
};

