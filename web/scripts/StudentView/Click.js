/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$("#changeAddress").click(function () {
    $("#addressModal").modal('show')
        .find("#addressModalContent")
        .load($(this).attr('value'));
});

$("#addTerm").click(function () {
    addTerm($(this).attr('value'));
});

$("#addAnatomy").click(function () {
    $("#anatomyModal").modal('show')
        .find("#anatomyModalContent")
        .load($(this).attr('value'));
});