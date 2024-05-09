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

$(document).ready(function() {
    $('.delete-consult').on('click', function(e) {
        e.preventDefault();

        var url = $(this).attr('href');

        $.ajax({
            url: url,
            type: 'POST',
            success: function(response) {
                // Recarrega a página para a URL atual
                window.location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Erro na exclusão:', status, error);
            }
        });

        return false;
    });
});