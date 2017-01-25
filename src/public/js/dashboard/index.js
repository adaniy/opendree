// a copier pour .header
// prompt des montants
$(document).on('click', '.amounts .middle', function () {
    var id = 1;

    bootbox.prompt({
	size: "medium",
	title: "Modification du montant de Grande Voirie",
	inputType: "number",
	value: 150,
	callback: function(result) {
            if(result != null) {
		// requête XHR
		
	    }
	}
    });
});

// a copier pour .header
// prompt des services
$(document).on('click', '.services .edit-amount-service', function () {
    var id = 1;
    var form = '<form class="form"><div class="form-group"><label for="agents">Nombre d\'agents</label><input type="number" class="form-control" name="agents" value="150"></div><div class="form-group"><label for="holidays">Nombre de congés</label><input type="number" class="form-control" name="holidays" value="150"></div><div class="form-group"><label for="hours">Nombre d\'heures supplémentaires</label><input type="number" class="form-control" name="hours" value="150"></div></form>';

    bootbox.confirm(form, function(result) {
	if(result) {
	    console.log("success");
	}
    });
});

$(document).on('click', '.toggle-panel', function () {
    $(this).parent().find('.panel-buttons').fadeToggle();
});

$(document).on('click', '.edit-service', function () {
    
});

$(document).on('click', '.add-service', function () {
    $.ajax({
	type: "GET",
	url: "/dashboard/add/service"
    }).done( function (msg) {
	var response = $.parseJSON(msg);

	if(response.status == 'success') {
	    // -_- \\
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
