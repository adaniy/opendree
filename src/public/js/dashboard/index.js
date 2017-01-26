// prompt des montants
$(document).on('click', '.amounts .middle', function () {
    var actual = $(this);
    var dashboard_id = $(this).data('dashboard');
    var category_id = $(this).data('category');
    var name = $('.amounts[data-attribute="'+ category_id +'"]').find('.header').text();
    var old = actual.data('amount');
    console.log(name)

    bootbox.prompt({
	size: "medium",
	title: 'Modification du montant de <b>"'+ name +'"</b>',
	inputType: "number",
	value: old,
	callback: function(result) {
            if(result != null) {
		$.ajax({
		    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		    type: "POST",
		    url: "/dashboard/edit/amount",
		    data: {
			'dashboard_id': dashboard_id,
			'category_id': category_id,
			amount: result
		    }
		}).done( function(msg) {
		    var response = $.parseJSON(msg);

		    if(response.status == 'success') {
			actual.text(response.amountDisplay);
		    }
		});
		
	    }
	}
    });
});

// prompt des services
$(document).on('click', '.services .edit-amount-service', function () {
    var actual = $(this);
    var service_id = $(this).data('id');
    var dashboard_id = $(this).data('dashboard');
    var name = $(this).data('service');

    var agents = actual.data('agents');
    var holidays = actual.data('holidays');
    var hours = actual.data('hours');

    console.log(agents);
    console.log(holidays);
    console.log(hours);

    var form = '<h4>Modification des valeurs du service <b>"'+ name +'"</b></h4><hr /><form class="form edit-amount-service"><input type="hidden" name="dashboard_id" value="'+ id +'"><input type="hidden" name="service_id" value="'+ service_id  +'"><div class="form-group"><label for="agents">Nombre d\'agents</label><input type="number" class="form-control" name="agents" value="150"></div><div class="form-group"><label for="holidays">Nombre de congés</label><input type="number" class="form-control" name="holidays" value="150"></div><div class="form-group"><label for="hours">Nombre d\'heures supplémentaires</label><input type="number" class="form-control" name="hours" value="150"></div></form>';

    bootbox.confirm(form, function(result) {
	if(result) {
	    $.ajax({
		type: "POST",
		url: "/dashboard/edit/amount/service",
		data: $('form.edit-amount-service').serialize()
	    }).done( function(msg) {
		var response = $.parseJSON(msg);

		if(response.status == 'success') {
		    console.log("success !");
		}
	    });
	}
    });
});

$(document).on('click', 'button#add-agent', function () {
    var id = $(this).data('service');
    var service = $(this).data('service-name');
    var actual = $('table[data-attribute="'+ id +'"]');

    bootbox.prompt({
	title: 'Entrez le nom du nouvel agent dans le service <b>"'+ service +'"</b> :',
	callback: function (input) {
	    if(input != null) {
		$.ajax({
		    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		    type: "POST",
		    url: "/dashboard/add/agent/",
		    data: {
			'service_id': id,
			name: input
		    }
		}).done( function (msg) {
		    var response = $.parseJSON(msg);

		    if(response.status == 'success') {
			var toAppend = '<tr data-attribute="'+ response.id +'"><th class="col-md-10">'+ response.name +'</th><td class="col-md-2"><button class="btn btn-xs btn-danger btn-tree" id="delete-agent">supprimer</button></td></tr>';
			actual.append(toAppend);
		    }
		});
	    }
	}
    });
});

$(document).on('click', 'button#delete-agent', function () {
    var id = $(this).parent().parent().data('attribute');
    var name = $(this).parent().prev().text();
    var actual = $(this).parent().parent();

    bootbox.confirm({
	message: 'Voulez-vous vraiment supprimer l\'agent <b>"'+ name +'"</b>',
	callback: function (input) {
	    if(input) {
		$.ajax({
		    type: 'GET',
		    url: '/dashboard/delete/agent/' + id
		}).done( function(msg) {
		    var response = $.parseJSON(msg);

		    if(response.status == 'success') {
			actual.fadeOut(400);
		    }
		});
	    }
	}
    });
});

$(document).on('click', 'button#edit-service', function () {
    var id = $(this).data('attribute');
    var old = $(this).parent().parent().parent().prev().children().children().text();
    var parent = $(this).parent().parent().parent().prev().children().children();

    bootbox.prompt({
	title: 'Nouveau nom pour le service <b>"'+ old +'"</b>',
	inputType: 'text',
	value: old,
	callback: function (input) {
	    if(input != null) {
		$.ajax({
		    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		    type: "POST",
		    url: "/dashboard/edit/service",
		    data: {
			id: id,
			name: input
		    }
		}).done( function (msg) {
		    var response = $.parseJSON(msg);

		    if(response.status == 'success') {
			parent.text(input);
		    }
		});
	    }
	}
    });
});

$(document).on('click', 'button#delete-service', function () {
    var id = $(this).data('attribute');
    var actual = $(this).parent().parent().parent().prev();
    var actual2 = $(this).parent().parent().parent();
    var old = $(this).parent().parent().parent().prev().children().children().text();

    bootbox.confirm({
	message: 'Voulez-vous vraiment supprimer le service <b>"'+ old +'"</b> ?<br /><br /><b>Cela aura pour effet de supprimer TOUTE les données associées à ce service.</b>',
	callback: function (input) {
	    if(input) {
		$.ajax({
		    type: "GET",
		    url: "/dashboard/delete/service/" + id,
		}).done( function (msg) {
		    var response = $.parseJSON(msg);

		    if(response.status == 'success') {
			actual.fadeOut(800);
			actual2.fadeOut(800);
		    }
		});
	    }
	}
    });
});

$(document).on('click', '.add-service', function () {
    var actual = $(this);

    $.ajax({
	type: "GET",
	url: "/dashboard/add/service"
    }).done( function (msg) {
	var response = $.parseJSON(msg);

	if(response.status == 'success') {
	    location.reload();
	}
    });
});

$(document).on('click', 'button#edit-category', function () {
    var id = $(this).data('attribute');
    var old = $(this).parent().parent().parent().prev().children().children().text();
    var oldType = $(this).data('type');

    if(oldType == 'amount') var options = '<option value="amount" selected="selected">Nombre simple</option><option value="money">Monétaire</option>';
    else if(oldType == 'money') var options = '<option value="amount">Nombre simple</option><option value="money" selected="selected">Monétaire</option>';
    else var options = '<option value="amount">Nombre simple</option><option value="money">Monétaire</option>';

    
    var form = '<form class="form edit-category"><input type="hidden" name="id" value="'+ id +'"><div class="form-group"><label for="name">Nom de la catégorie :</label><input type="text" class="form-control" name="name" value="'+ old +'"></div><div class="form-group"><label for="type">Type de montant associé :</label><select class="form-control" name="type">'+ options +'</select></div></form>';

    bootbox.confirm(form, function(result) {
	if(result) {
	    $('.edit-category').submit();
	}
    });
});

$(document).on('submit', '.edit-category', function (e) {
    e.preventDefault();

    var id = $(this).find('input[name=id]').val();
    var name = $(this).find('input[name=name]').val();
    var type = $(this).find('select[name=type]').val();

    $.ajax({
	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	type: "POST",
	url: "/dashboard/edit/category",
	data: {
	    id: id,
	    name: name,
	    type: type
	}
    }).done( function (msg) {
	location.reload();
    });
});

$(document).on('click', 'button#delete-category', function () {
    var id = $(this).data('attribute');
    var actual = $(this).parent().parent().parent().prev();
    var actual2 = $(this).parent().parent().parent();
    var old = $(this).parent().parent().parent().prev().children().children().text();

    bootbox.confirm({
	message: 'Voulez-vous vraiment supprimer la catégorie <b>"'+ old +'"</b> ?<br /><br /><b>Cela aura pour effet de supprimer TOUTE les données associées à cette catégorie.</b>',
	callback: function (input) {
	    if(input) {
		$.ajax({
		    type: "GET",
		    url: "/dashboard/delete/category/" + id,
		}).done( function (msg) {
		    var response = $.parseJSON(msg);

		    if(response.status == 'success') {
			actual.fadeOut(800);
			actual2.fadeOut(800);
		    }
		});
	    }
	}
    });
});

$(document).on('click', '.add-category', function () {
    var actual = $(this);

    $.ajax({
	type: "GET",
	url: "/dashboard/add/category"
    }).done( function (msg) {
	var response = $.parseJSON(msg);

	if(response.status == 'success') {
	    location.reload();
	}
    });
});

$(document).on('submit', '.add-holiday', function (e) {
    e.preventDefault();
    var actual = $(this);
    var data = $(this).serialize();

    $.ajax({
	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	type: "POST",
	url: "/dashboard/add/holiday",
	data: data
    }).done( function(msg) {
	var response = $.parseJSON(msg);

	if(response.status == 'success') {
	    actual.trigger('reset');

	    $.notify({
		message: 'Les congés ont été attribués avec succès.',
		animate: {
		    enter: 'animated fadeInDown',
		    exit: 'animated fadeOutUp'
		},
	    }, {
		type: 'success'
	    });
	} else if(response.error != undefined) {
	    $.notify({
		message: response.error,
		animate: {
		    enter: 'animated fadeInDown',
		    exit: 'animated fadeOutUp'
		},
	    }, {
		type: 'danger'
	    });
	}
    });
});

$(document).on('click', 'button#add-year', function () {
    bootbox.prompt({
	size: "medium",
	title: "Ajout d'une année dans le tableau de bord",
	inputType: "number",
	placeholder: "Ecrivez une année",
	callback: function(result) {
	    if(result != null) {
		$.ajax({
		    type: "GET",
		    url: "/dashboard/add/" + result
		}).done( function(msg) {
		    var response = $.parseJSON(msg);

		    if(response.status == 'success') {
			location.reload();
		    } else if(response.error != undefined) {
			msgError(response.error);
		    } else {
			msgError("La requête n'a pas pu aboutir.");
		    }
		});
	    }
	}
    });
});

$(document).on('click', 'button#add-month', function () {
    var year = $(this).data('attribute');
    var actual = $(this);
    
    $.ajax({
	type: "GET",
	url: "/dashboard/add/" + year + "/month"
    }).done( function(msg) {
	var response = $.parseJSON(msg);

	if(response.status == 'success') {
	    if(response.monthNumber == 12) {
		actual.fadeOut(100);
	    }

	    var added = '<button href="/dashboard/'+ response.year +'/'+ response.monthNumber +'" class="btn btn-menu btn-month"><div class="pull-right"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></div>'+ response.month +'</button>';
	    actual.before(added);
	    
	} else if(response.error != undefined) {
	    msgError(response.error);
	} else {
	    msgError("La requête n'a pas pu aboutir.");
	}
    });
});

$('.collapse').on('show.bs.collapse', function () {
    $(this).parent().find('.show-more').animate({opacity: 0}, 400);

});

$('.collapse').on('hide.bs.collapse', function () {
    $(this).parent().find('.show-more').animate({opacity: 1});
});

$(document).on('click', 'button#add-month', function () {
    $(this).tooltip('hide');
});
