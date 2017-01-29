$(function () {
    $('[data-toggle="popover"]').popover()
})

/** Obtention de la liste des participants */
$('button#participants').each(function (e) {
    var id = $(this).data('attribute');

    /** Requête Ajax ici pour remplir la liste des participants */
    var participants = '<li class="participants">test</li>';
    $(this).data('content', participants);
});

/** Ajout d'une réunion */
$(document).on('click', 'button#add-reunion', function () {
    $.ajax({
        type: "GET",
        url: "/reunion/add"
    }).done( function(msg) {
        var response = $.parseJSON(msg);

        if(response.status == 'success') {
            location.reload();
        }
    });
});

/** Modification d'une réunion */
$(document).on('click', 'button#edit-reunion', function () {
    
});

/** Suppression d'une réunion */
$(document).on('click', 'button#delete-reunion', function () {
    var id = $(this).data('attribute');
    var parent = $(this).parent().parent().parent();

    bootbox.confirm({
        message: "Êtes-vous sûr de vouloir supprimer cette réunion ?",
        callback: function (input) {
            if(input) {
                $.ajax({
                    type: "GET",
                    url: "/reunion/delete/" + id
                }).done( function(msg) {
                    var response = $.parseJSON(msg);

                    if(response.status == 'success') {
                        $.notify({
                            message: response.message
                        },{
                            type: 'success'
                        });

                        parent.fadeOut(800);
                    }
                });
            }
        }
    });
});
