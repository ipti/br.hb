/**
 * Post the <b>cid</b> to update the Delivered state
 * 
 * @param {integer} cid Consultation ID
 * 
 */
function submitUpdateDelivered(cid) {
    $.ajax({
        url: "/index.php?r=consultation/up&t=2&id=" + cid
    }).done(function () {
        $.pjax.reload({container: '#pjaxConsults'});
    });
}

/**
 * Post the <b>cid</b> to update the Attended state
 * 
 * @param {integer} cid Consultation ID
 * 
 */
function submitUpdateAttended(cid){
    $.ajax({
        url: "/index.php?r=consultation/up&t=1&id=" + cid
    }).done(function () {
        $.pjax.reload({container: '#pjaxConsults'});
    });
    
}