function liveAddForm(element, url, actionName, actionAttr, placeholder, prependTo) {
    $(element).on('click', function() {
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	var form = '<form method="POST" action="' + url + '" class="form '+ actionName +'">' + '<input type="hidden" name="csrf-token" value="' + csrf_token + '">' + '<input type="text" class="form-control" name="'+ actionAttr +'" placeholder="'+ placeholder +'"></form>';

	$(prependTo).first().prepend(form);
    });
}
function liveEditForm(element, data, url, actionName, actionAttr, replaceAt) {
    $(element).on('click', function() {
	var id = $(this).attr(data);
	var old = $(this).closest(replaceAt).text();
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	var form = '<form method="POST" data-attribute="'+ id +'" action="' + url + '" class="form '+ actionName +'">' + '<input type="hidden" name="csrf-token" value="' + csrf_token + '">' + '<input type="hidden" name="id" value="'+ id +'"><input type="text" class="form-control" name="'+ actionAttr +'" value="'+ old +'"></form>';
	$(this).closest(replaceAt).replaceWith(form);
    });
}

function liveExec(type, element, url, actionName, actionAttr, prependTo, newData) {
    $(document).on('submit', element, function (e) {
	if(type == "add") {
	    e.preventDefault();
	    var value = $(this).find('input[name='+ actionName +']').val();
	    var deleteForm = $(this).remove();
	
	    $.ajax({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		type: "POST",
		url: url,
		data: $(this).serialize()
	    }).done(function(msg) {
		var response = $.parseJSON(msg);

		if(response.status == "success") {
		    var part1 = newData.part1;
		    var part2 = newData.part2;
		    var part3 = newData.part3;

		    let dataReplace = part1 + response.id + part2 + value + part3;

		    $(prependTo).first().prepend(dataReplace);
		    deleteForm;

		    console.log("The ajax request returned successful result.");
		} else console.log("The ajax request returned an error.");
	    });
	} else if(type == "edit") {
	    e.preventDefault();
	    var value = $(this).find('input[name='+ actionName +']').val();
	    var id = $(this).attr(actionAttr);
	    var actual = $(this);
	
	    $.ajax({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		type: "POST",
		url: url,
		data: $(this).serialize()
	    }).done(function(msg) {
		var response = $.parseJSON(msg);
		console.log(response.status);
		if(response.status == "success") {
		    var part1 = newData.part1;
		    var part2 = newData.part2;
		    var part3 = newData.part3;

		    let dataReplace = part1 + response.id + part2 + value + part3;
		    
		    actual.replaceWith(dataReplace); // a corrigé, modifie tous ce qui est en cours de modification d'un coup
		}
	    });
	}
    });    
}

$(function() {
    $('.module').click(() => {
	$('.deploy').fadeToggle(200, "linear");
    });

    // les alertes clignotent
    (function blink() {
	$('.alerte-on').fadeOut(500).fadeIn(500, blink);
    })();

    $('#refresh').on('click', function () {
	location.href = location.href;
    });

    // gestion du module "ACTION"
    // recherche instantané
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
    
    // ajout de titres
    liveAddForm('button#add', 'ajout', 'action-add', 'nom', "Nom de la nouvelle action", '.list');

    liveExec('add', '.action-add', 'ajout', 'nom', '', '.list', {
	part1: '<div class="list"><div class="pull-right"><button id="edit" class="live"><span class="glyphicon glyphicon-remove" aria-hidden="true"></button></div><a href="action/',
	part2: '"><li>',
	part3: '</li></a></div>'
    });

    // modification de titres
    liveEditForm('button#edit', 'data-attribute', 'edit/nom', 'action-edit', 'nom', '.list');
    
    liveExec('edit', '.action-edit', 'edit/nom', 'nom', 'data-attribute','.action-edit', {
	part1: '<div class="list"><div class="pull-right"><button id="edit" class="live"><span class="glyphicon glyphicon-remove" aria-hidden="true"></button></div><a href="action/',
	part2: '"><li>',
	part3: '</li></a></div>'
    });
    // liveEditForm(element, data, url, actionName, actionAttr, replaceAt)
    // modification de la description
    liveEditForm('button#edit-description', 'data-attribute', 'edit/description', 'description', 'description', '.list');
});



