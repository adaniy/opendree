// déploiement des panneaux supplémentaires pour certains boutons du menu gauche
$(function() {
    $('.module').click(() => {
	$('.deploy').fadeToggle(200, "linear");
    });

    // les alertes clignotent
    (function blink() {
	$('.alerte-on').fadeOut(500).fadeIn(500, blink);
    })();

    // gestion du module "ACTION"
    // ajout de titres
    // formulaire
    $('button#add').on('click', function() {
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	var url = 'action/ajout';
	var form = '<form method="POST" action="' + url + '" class="form action-add">' + '<input type="hidden" name="csrf-token" value="' + csrf_token + '">' + '<input type="text" class="form-control" name="nom" placeholder="Nom de la nouvelle action"></form>';

	$('.list').first().prepend(form);
    });
    // traitement
    $(document).on('submit', ".action-add", function (e) {
	e.preventDefault();
	var nom = $(this).find('input[name=nom]').val();
	$.ajax({
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    type: "POST",
	    url: 'action/ajout',
	    data: $(this).serialize()
	}).done(function(msg) {
	    // I'll put the condition for if the request is successful
	    let replace = '<div class="list"><a href="#"><li>'+ nom +'</li></a></div>';

	    $('.action-edit').replaceWith(replace);
	});
    });
    
    // modification des titres
    $('button#edit').on('click', function() {
	var id = $(this).attr('data-attribute');
	var url = 'action/edit/nom';
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	var old = $(this).closest('.list').text();
	var formBeginning = '<form method="POST" action="' + url + '" class="form action-edit">' + '<input type="hidden" name="csrf-token" value="' + csrf_token + '">' + '<input type="hidden" name="action" value="' + id + '">';
	var formInput = '<input type="text" class="form-control" name="nom" value="' + old + '">';
	var formEnding = '</form>';

	$(this).closest('.list').replaceWith(formBeginning + formInput + formEnding);
    });

    $(document).on('submit', ".action-edit", function (e) {
	e.preventDefault();
	var nom = $(this).find('input[name=nom]').val();
	$.ajax({
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    type: "POST",
	    url: 'action/edit/nom',
	    data: $(this).serialize()
	}).done(function(msg) {
	    // I'll put the condition for if the request is successful
	    let replace = '<div class="list"><a href="#"><li>'+ nom +'</li></a></div>';

	    $('.action-edit').replaceWith(replace);
	});
    });
});



