/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$("#schools").change(function () {
    var clid = $(this).val();
    var cid = 2014;
    console.log(clid)
    var url = "";
    var {origin,pathname} = window.location;
    url = `${origin}${pathname}?r=load%2Fget-classrooms&clid=${clid}`;
    $.ajax({
        url: url,
    }).done(function (r) {
        $("#classrooms tbody").empty();
        var html = "";
        $.each( $.parseJSON( r ), function(name, year){
            html += "<tr>"
                    + "<th>"+name+"</th>"
                    + "<th>"+year+"</th>"
                    + "<th><input type='checkbox' class='form-control'></th>"
                    + "<th> </th>"
                + "<tr>";
        });
        $("#classrooms tbody").append(html);
        $("#send").show();
    }).fail(function(){
        $("#classrooms tbody").empty();
        $("#send").hide();
    });
});
