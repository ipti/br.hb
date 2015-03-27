$("#newAnatomy").click(function () {
        $("#anatomyModal").modal('show')
            .find("#anatomyModalContent")
            .load($(this).attr('value'));
    });