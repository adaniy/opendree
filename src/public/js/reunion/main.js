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
$(document).on('click', 'button#add-sujet', function (event) {
    event.preventDefault();

    var id = $(this).data('attribute');

    $.ajax({
        type: "GET",
        url: "/reunion/add/sujet/" + id
    }).done( function(msg) {
        var response = $.parseJSON(msg);

        if(response.status == "success") {
	    // exécuter l'insertion du nouveau sujet, ça va être compliqué ...
        }
    });
});

/** Modification du sujet d'une réunion */
$(document).on('click', 'button#edit-sujet', function (event) {
    event.preventDefault();
    var id = $(this).data('attribute');
    var old = $(this).parent().next().text();
    var buttons = $(this).parent();
    var actual = $(this).parent().next();

    var form = '<form class="edit-sujet"><input type="hidden" name="id" value="'+ id +'" /><input class="form-control" type="text" name="sujet" value="'+ old +'" /></form>';

    buttons.remove();
    actual.replaceWith(form);
});

$(document).on('submit', '.edit-sujet', function (event) {
    event.preventDefault();
    var id = $(this).find('input[name="id"]').val();
    var sujet = $(this).find('input[name="sujet"]').val();
    var actual = $(this);

    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "POST",
        url: "/reunion/edit/sujet/",
        data: $(this).serialize()
    }).done( function(msg) {
        var response = $.parseJSON(msg);

        if(response.status == "success") {
            var replace = '<div class="pull-left buttons"><button class="btn btn-xs btn-danger live" id="delete-sujet" data-attribute="'+ id +'"><span class="glyphicon glyphicon-remove"></span></button> <button class="btn btn-xs btn-success live" id="edit-sujet" data-attribute="'+ id +'"><span class="glyphicon glyphicon-edit"></span></button></div> <li type="button" data-toggle="collapse" data-target="#collapseEdit'+ id +'" aria-expanded="false" aria-controls="collapseEdit'+ id +'">'+ sujet +'</li>';
            actual.replaceWith(replace);
        }
    });
});

/** Modification de l'observation d'une réunion */
$(document).on('click', 'button#edit-observation', function (event) {
    event.preventDefault();

    var id = $(this).data('attribute');
    var old = $(this).parent().parent().next().text();
    var buttons = $(this);
    var actual = $(this).parent().parent().next();

    var form = '<form class="edit-observation"><input type="hidden" name="id" value="'+ id +'" /><textarea class="form-control edit-observation-textarea" name="observation">'+ old +'</textarea></form>';

    buttons.remove();
    actual.replaceWith(form);
    $('.edit-observation-textarea').trigger('click'); // on déclenche l'action click pour assurer que le textarea prenne la bonne hauteur lors de son apparition
});

$(document).on('keypress', '.edit-observation-textarea', function (event) {
    if(event.keyCode == 13 && !event.shiftKey) {
        var actual = $(this).parent();
        var value = nl2br(escapeHtml(actual.find('textarea[name="observation"]').val()));
        var id = actual.find('input[name="id"]').val();

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            url: '/reunion/edit/observation',
            data: {
                id: id,
                observation: value
            }
        }).done(function(msg) {
            var response = $.parseJSON(msg);

            if(response.status == "success") {
                let dataReplace = '<div class="content">'+ value +'</div>';

                actual.replaceWith(dataReplace);
            }
        });

        return false;
    }
});

/** Modification de l'action d'une réunion */
$(document).on('click', 'button#edit-action', function (event) {
    event.preventDefault();

    var id = $(this).data('attribute');
    var old = $(this).parent().parent().next().text();
    var buttons = $(this);
    var actual = $(this).parent().parent().next();

    var form = '<form class="edit-action"><input type="hidden" name="id" value="'+ id +'" /><textarea class="form-control edit-action-textarea" name="action">'+ old +'</textarea></form>';

    buttons.remove();
    actual.replaceWith(form);
    $('.edit-action-textarea').trigger('click'); // on déclenche l'action click pour assurer que le textarea prenne la bonne hauteur lors de son apparition
});

$(document).on('keypress', '.edit-action-textarea', function (event) {
    if(event.keyCode == 13 && !event.shiftKey) {
        var actual = $(this).parent();
        var value = nl2br(escapeHtml(actual.find('textarea[name="action"]').val()));
        var id = actual.find('input[name="id"]').val();

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            url: '/reunion/edit/action',
            data: {
                id: id,
                action: value
            }
        }).done(function(msg) {
            var response = $.parseJSON(msg);

            if(response.status == "success") {
                let dataReplace = '<div class="content">'+ value +'</div>';

                actual.replaceWith(dataReplace);
            }
        });

        return false;
    }
});

/** Suppression d'un sujet de réunion */
$(document).on('click', 'button#delete-sujet', function (event) {
    event.preventDefault();
    var id = $(this).data('attribute');
    var parent = $(this).parent().parent();

    $.ajax({
        type: "GET",
        url: "/reunion/delete/sujet/" + id
    }).done( function(msg) {
        var response = $.parseJSON(msg);

        if(response.status == "success") {
            parent.fadeOut(600);
        }
    });
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

/** On permet que la hauteur des textarea se mettent à jour tous seul */
$(document).on('change click keyup keydown paste cut', 'textarea', function () {
    $(this).height(0).height(this.scrollHeight);
}).find('textarea').change();
