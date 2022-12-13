/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$("#classrooms").change(function () {
    var clid = $(this).val();
    var cid  = $(this).attr("campaign");
    var sample = $(this).attr("sample");
    var url = "";
    var {origin,pathname} = window.location;
    if (sample == 1) {
        url = `${origin}${pathname}?r=hemoglobin%2Fget-agreed-terms&clid=${clid}&cid=${cid}&samp=${sample}`;
    }
    else {
        url = `${origin}${pathname}?r=hemoglobin%2Fget-attended-consults&clid=${clid}&cid=${cid}&samp=${sample}`;
    }

    console.log(url)
    
    $.ajax({
        url: url,
    }).done(function (r) {
        $("#hemoglobins tbody").empty();
        var html = "";
        $.each( $.parseJSON( r ), function(name, id){
            html += "<tr>"
                + "<th>"+name+"</th>"
                + "<th><input type='text' class='form-control' name='hemoglobin["+id+"]'></th>"
                + "<tr>";
        });
        $("#hemoglobins tbody").append(html);
        $("#send").show();
    }).fail(function(){
        $("#hemoglobins tbody").empty();
        $("#send").hide();
    });
});
