$("#changeAddress").click(function(){
    $("#addressModal").modal('show')
            .find("#addressModalContent")
            .load($(this).attr('value'));
});

function submitAddressForm($form){
    $.post(
        $form.attr("action"),
        $form.serialize()
    )
        .done(function(result){
            $form.parent().html(result.message);
            $($("#changeAddress").attr('for')).attr('value', result.id);
            $("#changeAddress").attr('value','/index.php?r=address%2Fupdate&id='+result.id);
            $('#addressModal').modal('hide');
        })
        .fail(function(){
            console.log("server error");
            $form.replaceWith('<button class="btn btn-primary">Fail</button>').fadeOut()
        });
    return false;
}
