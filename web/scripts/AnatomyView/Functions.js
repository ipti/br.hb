function submitAnatomyForm($form) {
    $.post(
        $form.attr('action'),
        $form.serialize()
        )
        $('#anatomyModal').modal('hide');
};