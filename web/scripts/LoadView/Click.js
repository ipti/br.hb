const {origin,pathname} = window.location;
$("#years, #schools").change(function () {
    $("#error_message").css("display", "none");
    $("#sucess_message").css("display", "none");
    $("#sucess_details").empty();
    var clid = $("#schools").val();
    var cid = $("#years").val();
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
                    + "<th><input type='checkbox' class='form-control' disabled='true'></th>"
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
        $.each( $.parseJSON( response ), function(name, id){
            if(id == clid) $("#sucess_details").append("<h5>TURMAS IMPORTADAS DE: "+name+"</h5>")
            else $("#sucess_details").append("<h6>"+name+"</h6>")
        });
        $("#sucess_message").css("display", "block");
        $("#classrooms tbody").empty();
    }).fail(function () {
        $("#error_message").css("display", "block");
    })
});
