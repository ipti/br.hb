/**
 * Post the FORM to add a new Address.
 * 
 * @param {form} $form
 */
 function submitAddressForm($form) {
    $.post(
        $form.attr("action"),
        $form.serialize()
        )
        .done(function (result) {
            $form.parent().html(result.message);
            $($("#changeAddress").attr('for')).attr('value', result.id);
            $("#changeAddress").attr('value', '/index.php?r=address%2Fupdate&id=' + result.id);
            $('#addressModal').modal('hide');
        })
        .fail(function () {
            $form.replaceWith('<button class="btn btn-primary">Fail</button>').fadeOut();
        });
};


/**
 * Post the sid to add a new Term.
 * 
 * @param {integer} sid
 */
function addTerm(sid) {
    $.ajax({
        url: "/index.php?r=term/add&sid=" + sid
    }).done(function () {
        $.pjax.reload({container: '#pjaxTerm'});
    });
};

/**
 * Post the FORM to add a new Address.
 * 
 * @param {form} $form
 */
function submitAnatomyForm($form) {
    $.post(
        $form.attr("action"),
        $form.serialize()
        )
        .done(function (result) {
            $form.parent().html(result.message);
            $($("#changeAddress").attr('for')).attr('value', result.id);
            $("#changeAddress").attr('value', '/index.php?r=address%2Fupdate&id=' + result.id);
            $('#addressModal').modal('hide');
            $.pjax.reload({container: '#pjaxAnatomy'});
        });
};