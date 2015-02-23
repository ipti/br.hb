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
        .done(function (result) {
            $form.parent().html(result.message);
            $($("#changeAddress").attr('for')).attr('value', result.id);
            //$("#changeAddress").attr('value', '/index.php?r=address%2Fupdate&id=' + result.id);
            $('#addressModal').modal('hide');
            window.location.assign("/");
        })
        .fail(function () {
            $form.replaceWith('<button class="btn btn-primary">Fail</button>').fadeOut();
        });
};

