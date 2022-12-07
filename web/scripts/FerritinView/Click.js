/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$("#classrooms").change(function () {
    var clid = $(this).val();
    var cid  = $(this).attr("campaign");
    var url = "";
    url = '/index.php?r=Ferritin%2Fget-agreed-terms&clid=' + clid + '&cid='+cid;
    
    $.ajax({
        url: url,
    }).done(function (r) {
        $("#ferritins tbody").empty();
        var html = "";
        $.each( $.parseJSON( r ), function(name, id){
            html += "<tr>"
                + "<th>"+name+"</th>"
                + "<th><input type='text' class='form-control' name='ferritin["+id+"]'></th>"
                + "<tr>";
        });
        $("#ferritins tbody").append(html);
        $("#send").show();
    }).fail(function(){
        $("#ferritins tbody").empty();
        $("#send").hide();
    });
});
