const {origin,pathname} = window.location;
$("#years, #schools").change(function () {
    var clid = $("#schools").val();
    var cid = $("#years").val();
    console.log(clid)
    console.log(cid)
    var url = "";
    url = `${origin}${pathname}?r=load%2Fget-classrooms&clid=${clid}&cid=${cid}`;
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

$("#send").click(function () {
    var clid = $("#schools").val();
    var cid = $("#years").val();
    url = `${origin}${pathname}?r=load%2Ftag&clid=${clid}&cid=${cid}`;
    $.ajax({
        url: url,
    }).done(function (response) {
        console.log("TURMAS IMPORTADAS")
        console.log(response)
    })
});
