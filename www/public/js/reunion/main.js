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

/** Ajout d'un sujet dans une réunion */
$(document).on('click', 'button#add-sujet', function (event) {
    event.preventDefault();

    var id = $(this).data('attribute');
    var actual = $(this).parent().prev();

    $.ajax({
        type: "GET",
        url: "/reunion/add/sujet/" + id
    }).done( function(msg) {
        var response = $.parseJSON(msg);

        if(response.status == "success") {
            let id = response.id;
            let sujet = response.sujet;
            let observation = response.observation;
            let action = response.action;

            /** Vivement les méthodes React ... la variable newData DOIT être identique au contenu d'un .wrap-sujets afin de donner l'illusion d'une insertion réactive */
            let newData = '<div class="wrap-sujets"><div class="pull-left buttons"><button class="btn btn-xs btn-danger live" id="delete-sujet" data-attribute="'+ id +'"><span class="glyphicon glyphicon-remove"></span></button> <button class="btn btn-xs btn-success live" id="edit-sujet" data-attribute="' + id + '"><span class="glyphicon glyphicon-edit"></span></button></div><li type="button" class="sujets" data-toggle="collapse" data-target="#collapseEdit'+ id +'" aria-expanded="false" aria-controls="collapseEdit'+ id +'">'+ sujet +'</li><div class="collapse details-collapse-edit" id="collapseEdit' + id + '"><div class="details"><div class="title"><div class="pull-right"><button class="btn btn-xs btn-success live" id="edit-observation" data-attribute="'+ id +'"><span class="glyphicon glyphicon-edit"></span></button></div><span class="glyphicon glyphicon-chevron-right"></span> Observations</div><div class="content">'+ observation +'</div></div><div class="details"><div class="title"><div class="pull-right"><button class="btn btn-xs btn-success live pull-left" id="edit-action" data-attribute="' + id +'"><span class="glyphicon glyphicon-edit"></span></button></div><span class="glyphicon glyphicon-chevron-right"></span> Actions à entreprendre</div><div class="content">' + action + '</div></div></div></div>';

            actual.before(newData);
        }
    });
});

/** Ajout d'un participant */
$(document).on('submit', 'form#participant', function (event) {
    event.preventDefault();
    var id = $(this).find('input[name="id"]').val();
    var type = $(this).find('select[name="type"]').val();
    var nom = $(this).find('input[name="nom"]').val();
    var data = $(this).serialize();
    var actual;

    if(type == "secretaire") actual = $(this).parent().find('.wrap-secretaire');
    else if(type == "present") actual = $(this).parent().find('.wrap-present');
    else if(type == "absent") actual = $(this).parent().find('.wrap-absent');
    else actual = $(this).parent().find('.wrap-present');

    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "POST",
        url: "/reunion/add/participant",
        data: data
    }).done( function (msg) {
        var response = $.parseJSON(msg);

        if(response.status == "success") {
            var newData = '<div class="wrap-participants"><div class="pull-left buttons"><button class="btn btn-xs btn-danger live" id="delete-participant" data-attribute="' + response.id + '"><span class="glyphicon glyphicon-remove"></span></button></div><li class="participants">'+ escapeHtml(response.nom) +'</li></div>';

            actual.append(newData);
        }
    });
});

/** Suppression d'un participant */
$(document).on('click', 'button#delete-participant', function (event) {
    event.preventDefault();

    var id = $(this).data('attribute');
    var actual = $(this).parent().parent();

    $.ajax({
        type: "GET",
        url: "/reunion/delete/participant/" + id
    }).done( function (msg) {
        var response = $.parseJSON(msg);

        if(response.status == "success") {
            actual.fadeOut(600);
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
            var replace = '<div class="pull-left buttons"><button class="btn btn-xs btn-danger live" id="delete-sujet" data-attribute="'+ id +'"><span class="glyphicon glyphicon-remove"></span></button> <button class="btn btn-xs btn-success live" id="edit-sujet" data-attribute="'+ id +'"><span class="glyphicon glyphicon-edit"></span></button></div> <li type="button" class="sujets" data-toggle="collapse" data-target="#collapseEdit'+ id +'" aria-expanded="false" aria-controls="collapseEdit'+ id +'">'+ sujet +'</li>';
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
        var actual = $(this).parent().parent();
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
                let dataReplace = '<div class="details"><div class="title"><div class="pull-right"><button class="btn btn-xs btn-success live" id="edit-observation" data-attribute="'+ id +'"><span class="glyphicon glyphicon-edit"></span></button></div><span class="glyphicon glyphicon-chevron-right"></span> Observations</div><div class="content">'+ value +'</div></div>';

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
        var actual = $(this).parent().parent();
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
                let dataReplace = '<div class="details"><div class="title"><div class="pull-right"><button class="btn btn-xs btn-success live" id="edit-action" data-attribute="'+ id +'"><span class="glyphicon glyphicon-edit"></span></button></div><span class="glyphicon glyphicon-chevron-right"></span> Actions à entreprendre</div><div class="content">'+ value +'</div></div>';

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
