/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$("#classrooms").change(function () {
    var clid = $(this).val();
    var cid  = $(this).attr("campaign");
    var url = "";
    var host = window.location.origin + window.location.pathname
    url = host+'?r=ferritin%2Fget-agreed-terms&clid='+clid+'&cid='+cid;
    console.log(url)
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
