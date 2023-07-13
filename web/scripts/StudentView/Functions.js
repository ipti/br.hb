/**
 * Post the FORM to add a new Address.
 * 
 * @param {form} $form
 */
$(document).on("click", "#student-allergy", function () {
    $(this).prop('checked') ? $(".field-student-allergy_text").show() : $(".field-student-allergy_text").hide();
});

$(document).on("click", "#student-anemia", function () {
    $(this).prop('checked') ? $(".field-student-anemia_text").show() : $(".field-student-anemia_text").hide();
});


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