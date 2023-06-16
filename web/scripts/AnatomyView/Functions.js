function submitAnatomyForm($form) {
    $.post(
        $form.attr('action'),
        $form.serialize()
        )
        $('#anatomyModal').modal('hide');
};

// função para remover um texto perdido inserido no html
$(document).ready(function() {
    $('.container').contents().filter(function() {
        return this.nodeType === 3;
    }).remove();
});