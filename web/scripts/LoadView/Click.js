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
        console.clear();
        var imported_classes = []
        var school = ""
        $.each( $.parseJSON( response ), function(name, id){
            if(id != clid){
                imported_classes.push(name)
            }else {
                school = name
            }
            console.log(name)
        });
    })
});
