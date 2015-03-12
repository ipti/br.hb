$(document).on('click',".attendedClick",function () {
    /**
     * TODO: Altere isso!!!
     * Precisa alterar isso para usar modal e não confirm!!!
     * Modal que deve ser utilizado: #updateModal
     * 
     * */
    if($(this).children(".text-danger").length>0)
        if(confirm("Deseja Realmente Atualizar?") == true)
            submitUpdateAttended($(this).parent().attr('data-key'));
});
$(document).on('click',".deliveredClick",function () {
    /**
     * TODO: Altere isso!!!
     * Precisa alterar isso para usar modal e não confirm!!!
     * Modal que deve ser utilizado: #updateModal
     * 
     * */
    
    if($(this).children(".text-danger").length>0)
        if(confirm("Deseja Realmente Atualizar?") == true)
            submitUpdateDelivered($(this).parent().attr('data-key'));
});