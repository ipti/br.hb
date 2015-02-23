/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(".agreedClick").click(function () {
    /**
     *  Altere isso!!!
     * Precisa alterar isso para usar modal e não confirm!!!
     * Modal que deve ser utilizado: #updateModal
     * 
     * */
    
    if($(this).children(".text-danger").length>0)
        if(confirm("Deseja Realmente Atualizar?") == true)
            submitUpdateTerm($(this).parent().attr('data-key'));
});