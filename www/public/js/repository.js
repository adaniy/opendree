var entityMap = {
  "&": "&amp;",
  "<": "&lt;",
  ">": "&gt;",
  '"': '&quot;',
  "'": '&#39;',
  "/": '&#x2F;'
};

function escapeHtml(string) {
  return String(string).replace(/[&<>"'\/]/g, function (s) {
    return entityMap[s];
  });
}

function nl2br (str, is_xhtml) {   
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';    
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
}

function unformat_number(number) {
    return number.replace(/ /g, '');
}

$(function() {
    $('.module').click(() => {
	$('.deploy').fadeToggle(200, "linear");
    });

    var csrfToken = $('[name="csrf_token"]').attr('content');

    // rafraichissement des tokens csrf
    setInterval(refreshToken, 3600000); 
    function refreshToken() {
        $.get('refresh-csrf').done(function(data){
            csrfToken = data;
        });
    }
    setInterval(refreshToken, 3600000);
    
    // les alertes clignotent
    (function blink() {
	$('.alerte-on').fadeOut(500).fadeIn(500, blink);
    })();

    $('#refresh').on('click', function () {
	location.href = location.href;
    });

    // ----------- MODULE - ACTION ----------- \\
    // ---------------------------------------- \\

    // RECHERCHE INSTANTANE \\
    // ------------------------ \\
    $('.live-search').keyup( function() {
	var filter = $(this).val(), count = 0;

	$(".list").each( function () {
	    if($(this).text().search(new RegExp(filter, "i")) < 0) {
		$(this).fadeOut();
	    } else {
		$(this).show();
		count++;
	    }
	});
    });
    
    // TITRES - AJOUTS \\
    // ------------------------- \\
    $('button#add').on('click', function() {
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	var form = '<form method="POST" action="ajout" class="form action-add">' + '<input type="hidden" name="csrf-token" value="' + csrf_token + '">' + '<input type="text" class="form-control" name="nom" placeholder="Nom de la nouvelle action"></form>';

	$('.action-list').prepend(form);
    });
    
    // VALIDATION - TRAITEMENT AJAX \\
    $(document).on('submit', '.action-add', function (e) {
	e.preventDefault();
	var value = $(this).find('input[name=nom]').val();

	var actual = $(this);
	
	$.ajax({
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    type: "POST",
	    url: '/action/ajout',
	    data: $(this).serialize()
	}).done(function(msg) {
	    var response = $.parseJSON(msg);

	    if(response.status == "success") {
		let dataReplace = '<div class="list"><div class="pull-right"><button id="edit" data-attribute="'+ response.id +'"f class="live"><span class="glyphicon glyphicon-edit" aria-hidden="true"></button></div><a href="/action/' + response.id + '"><li>' + value + '</li></a></div>';

		actual.replaceWith(dataReplace);


		console.log("The ajax request returned successful result.");
	    } else console.log("The ajax request returned an error.");
	});
    });

    // TITRES - MODIFICATIONS \\
    // ---------------------------- \\
    $(document).on('click', 'button#edit', function() {
	var id = $(this).attr('data-attribute');
	var old = $(this).closest('.list').text();
	var url = '/action/edit/nom';
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	var form = '<form method="POST" data-attribute="'+ id +'" action="' + url + '" class="form action-edit">' + '<input type="hidden" name="csrf-token" value="' + csrf_token + '">' + '<input type="hidden" name="id" value="'+ id +'"><input type="text" class="form-control" name="nom" value="'+ old +'"></form>';
	$(this).parent().parent().closest('.list').replaceWith(form);
    });
    
    // VALIDATION - TRAITEMENT AJAX \\
    $(document).on('submit', '.action-edit', function (e) {
	e.preventDefault();
	var value = $(this).find('input[name=nom]').val();
	var id = $(this).attr('data-attribute');
	var actual = $(this);
	var url = '/action/edit/nom';
	
	$.ajax({
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    type: "POST",
	    url: url,
	    data: $(this).serialize()
	}).done(function(msg) {
	    var response = $.parseJSON(msg);
	    console.log(response.status);
	    if(response.status == "success") {
		if(id == $('meta[name=id]').attr('content')) { // si l'id du titre de l'action modifié est celle de la page actuelle ...
		    // alors on modifie aussi le titre dans la partie droite
		    let titreReplace = '<div class="titre">'+ escapeHtml(value) +'</div>';
		    $('.titre').text(value);
		}

		let dataReplace = '<div class="list"><div class="pull-right"><button id="edit" class="live" data-attribute="'+ id +'"><span class="glyphicon glyphicon-edit" aria-hidden="true"></button></div><a href="' + id + '"><li>' + escapeHtml(value) + '</li></a></div>';
		    
		actual.replaceWith(dataReplace);
	    }
	});
    });

    // DESCRIPTION  - MODIFICATION \\
    // ------------------------------ \\
    $('button#edit-description').on('click', function() {
	var old = escapeHtml($('.description').text());
	var url = 'edit/description';
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	var id = $('meta[name="id"]').attr('content');
	
	var form = '<form method="POST" action="' + url + '" class="form">' + '<input type="hidden" name="csrf-token" value="' + csrf_token + '">' + '<input type="hidden" name="id" value="'+ id +'"><textarea id="test" name="description" class="form-control description-edit">'+ old +'</textarea></form>';
	
	$('.description').replaceWith(form);
	$('.description-edit').trigger('click'); // on déclenche l'action click pour assurer que le textarea prenne la bonne hauteur lors de son apparition
    });

    // on s'assure que la hauteur du textarea s'ajuste en fonction du contenu
    $('.inner').on('change click keyup keydown paste cut', 'textarea', function () {
        $(this).height(0).height(this.scrollHeight);
    }).find('textarea').change();

    // VALIDATION - TRAITEMENT AJAX \\
    $('.inner').on('keypress', '.description-edit', function (e) {
	if(e.keyCode == 13 && !e.shiftKey) {
	    var value = nl2br(escapeHtml($(this).parent().find('textarea[name=description]').val()));
	    var actual = $(this);
	    var url = 'edit/description';
	    var id = $(this).parent().find('input[name=id]').val();

	    $.ajax({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		type: "POST",
		url: url,
		data: {
		    id: id,
		    description: value
		}
	    }).done(function(msg) {
		var response = $.parseJSON(msg);
		console.log(response.status);
		if(response.status == "success") {
		    let dataReplace = '<div class="description">'+ value +'</div>';
		    
		    actual.replaceWith(dataReplace);
		}
	    });

	    return false;
	}
    });

    // DATE DE CREATION - MODIFICATION
    // ------------------------------------ \\
    $('.action').on('click', 'button#edit-date-creation', function() {
	var id = $(this).attr('data-attribute');
	var old = $('.action-date-creation').text();
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	var form = '<div class="inner action-info action-date-creation"><form method="POST" class="form action-edit-date-creation">' + '<input type="hidden" name="csrf-token" value="' + csrf_token + '">' + '<input type="text" class="form-control" name="date_creation" value="'+ old +'"></form></div>';
	$('.action-date-creation').replaceWith(form);
    });

    // VALIDATION - TRAITEMENT AJAX \\
    $(document).on('submit', '.action-edit-date-creation', function (e) {
	e.preventDefault();
	var value = $(this).find('input[name=date_creation]').val();
	var id = $('meta[name="id"]').attr('content');
	var actual = $(this);
	var url = 'edit/date-creation';
	
	$.ajax({
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    type: "POST",
	    url: url,
	    data: {
		id: id,
		"date_creation": value
	    }
	}).done(function(msg) {
	    var response = $.parseJSON(msg);
	    console.log(response.status);
	    if(response.status == "success") {
		let dataReplace = '<div class="inner action-info action-date-creation"><div class="pull-right"><button id="edit-date-creation" class="live"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button></div>'+ value +'</div>';
		    
		actual.text(value);
	    }
	});
    });

    // DATE DE REALISATION - MODIFICATION
    // ------------------------------------ \\
    $('.action').on('click', 'button#edit-date-realisation', function() {
	var id = $(this).attr('data-attribute');
	var old = $('.action-date-realisation').text();
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	var form = '<div class="inner action-info action-date-realisation"><form method="POST" class="form action-edit-date-realisation">' + '<input type="hidden" name="csrf-token" value="' + csrf_token + '">' + '<input type="text" class="form-control" name="date_realisation" value="'+ old +'"></form></div>';
	$('.action-date-realisation').replaceWith(form);
    });

    // VALIDATION - TRAITEMENT AJAX \\
    $(document).on('submit', '.action-edit-date-realisation', function (e) {
	e.preventDefault();
	var value = $(this).find('input[name=date_realisation]').val();
	var id = $('meta[name="id"]').attr('content');
	var actual = $(this);
	var url = 'edit/date-realisation';
	
	$.ajax({
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    type: "POST",
	    url: url,
	    data: {
		id: id,
		"date_realisation": value
	    }
	}).done(function(msg) {
	    var response = $.parseJSON(msg);
	    console.log(response.status);
	    if(response.status == "success") {
		let dataReplace = '<div class="inner action-info action-date-realisation"><div class="pull-right"><button id="edit-date-realisation" class="live"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button></div>'+ value +'</div>';
		    
		actual.text(value);
	    }
	});
    });

    // DATE BUTOIR - MODIFICATION
    // ------------------------------------ \\
    $('.action').on('click', 'button#edit-date-butoir', function() {
	var id = $(this).attr('data-attribute');
	var old = $('.action-date-butoir').text();
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	var form = '<div class="inner action-info action-date-butoir"><form method="POST" class="form action-edit-date-butoir">' + '<input type="hidden" name="csrf-token" value="' + csrf_token + '">' + '<input type="text" class="form-control" name="date_butoir" value="'+ old +'"></form></div>';
	$('.action-date-butoir').replaceWith(form);
    });

    // VALIDATION - TRAITEMENT AJAX \\
    $(document).on('submit', '.action-edit-date-butoir', function (e) {
	e.preventDefault();
	var value = $(this).find('input[name=date_butoir]').val();
	var id = $('meta[name="id"]').attr('content');
	var actual = $(this);
	var url = 'edit/date-butoir';

	// requête get ajax de la mise à jour du nombre de jour restant
	$.ajax({
	    type: "GET",
	    url: "get/jour-restant",
	    data: {
		"date_butoir": value
	    }
	}).done(function(msg) {
	    var response = $.parseJSON(msg);
	    
	    if(response.status == "success") {
		$('.action-jour-restant').text(response.newDate);
	    }
	});
	
	$.ajax({
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    type: "POST",
	    url: url,
	    data: {
		id: id,
		"date_butoir": value
	    }
	}).done(function(msg) {
	    var response = $.parseJSON(msg);
	    console.log(response.status);

	    if(response.status == "success") {
		let dataReplace = '<div class="inner action-info action-date-butoir"><div class="pull-right"><button id="edit-date-butoir" class="live"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button></div>'+ value +'</div>';
		    
		actual.text(value);
	    }
	});
    });

    // ACTIVER LES ALERTES
    // ------------------------------------ \\
    $(document).on('click', '.action-alerte', function (e) {
	var id = $('meta[name="id"]').attr('content');
	var value = $(this).attr("value");
	var actual = $(this);

	e.preventDefault();

	$.ajax({
	    type: "GET",
	    url: "alerte",
	    data: {
		id: id,
		alerte: value
	    }
	}).done(function(msg) {
	    var response = $.parseJSON(msg);
	    console.log(response.status);

	    if(response.status == "success") {
		if(value == 1) {
		    var dataReplace = '<button class="btn btn-md btn-danger action-alerte" value="0">ne pas recevoir d\'alerte</button>';
		} else {
		    var dataReplace = '<button class="btn btn-md btn-success action-alerte" value="1">recevoir une alerte</button>';
		}

		actual.replaceWith(dataReplace);
	    }
	});
    });
});



