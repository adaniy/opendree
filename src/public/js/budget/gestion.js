function syncBudgetTotal(element, id) {
    if(id == undefined) var idAttr = $(element).attr('data-attribute');
    else var idAttr = id;
    
    $.ajax({
	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	type: "GET",
	url: "/budget/total/" + idAttr,
    }).done(function (msg) {
	var response = $.parseJSON(msg);

	if(response.status == "success") {
	    $('tr.total[data-attribute="'+ idAttr +'"]').find('total').text(response.total);
	}
    });
}

// VALIDATION - TRAITEMENT AJAX \\
$(document).on('click', 'button#add-depense', function (e) {
    e.preventDefault();
    var id = $(this).attr('data-attribute');
    var actual = $(this);

    $.ajax({
	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	type: "GET",
	url: '/budget/ajout/depense/' + id,
    }).done(function(msg) {
	var response = $.parseJSON(msg);

	if(response.status == "success") {
	    $('tr.total[data-attribute="' + id + '"]').before('<tr class="depense" data-attribute="'+ response.id +'"><td class="category">' + response.category +'</td><td class="amount">' + response.amount +'</td><td class="actions"><button id="edit-depense" class="btn  btn-xs btn-info live" data-attribute="'+ response.id +'"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button> <button id="delete-depense" class="btn btn-xs btn-danger live" data-attribute="'+ response.id +'"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>');
	    
	    console.log("The ajax request returned successful result.");
	} else console.log("The ajax request returned an error.");
    });
});

// modification des dépenses
$(document).on('click', 'button#edit-depense', function() {
    var id = $(this).attr('data-attribute');

    var category = $(this).parent().parent().find('.category');
    var amount = $(this).parent().parent().find('.amount');

    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    var formCategory = '<td class="category"><form method="POST" action="edit" class="form depense-category-edit" data-attribute="'+ id +'">' + '<input type="hidden" name="csrf-token" value="' + csrf_token + '"><input type="hidden" name="id" value="'+ id +'">' + '<input type="text" class="form-control" name="category" value="' + category.text() + '"></form></td>';
    var formAmount = '<td class="amount"><form method="POST" action="edit" class="form depense-amount-edit" data-attribute="'+ id +'">' + '<input type="hidden" name="csrf-token" value="' + csrf_token + '"><input type="hidden" name="id" value="'+ id +'">' + '<input type="text" class="form-control" name="amount" value="'+ unformat_number(amount.text()) +'"></form</td>';

    category.replaceWith(formCategory);
    amount.replaceWith(formAmount);
});

// traitement ajax dupliqué pour le second formulaire
$(document).on('submit', '.depense-category-edit', function (e) {
    e.preventDefault();
    var id = $(this).attr("data-attribute");

    var firstForm = '.depense-category-edit';
    var secondForm = '.depense-amount-edit';

    var data1 = $('tr[data-attribute="'+ id +'"]').find(firstForm).serialize();
    var data2 = $('tr[data-attribute="'+ id +'"]').find(secondForm).serialize();

    var category = escapeHtml($('tr[data-attribute="'+ id +'"]').find('input[name=category]').val());
    var amount = escapeHtml($('tr[data-attribute="'+ id +'"]').find('input[name=amount]').val());
    
    $.ajax({
	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	type: "POST",
	url: "/budget/edit/depense",
	data: data1 + "&" + data2
    }).done(function (msg) {
	var response = $.parseJSON(msg);

	if(response.status == "success") {
	    // si la requête est un succès, on rétablis les colonnes avec les nouvelles valeurs asynchrone
	    var categoryReplace = '<td class="category" data-attribute="'+ id +'">'+ response.category +'</td>';
	    var amountReplace = '<td class="amount" data-attribute="'+ id +'">'+ response.amount +'</td>';

	    $('tr[data-attribute="'+ id +'"]').find('.depense-category-edit').parent().replaceWith(categoryReplace);
	    $('tr[data-attribute="'+ id +'"]').find('.depense-amount-edit').parent().replaceWith(amountReplace);

	    syncBudgetTotal('tr.total', response.budget_id);
	}
    });
});

// traitement ajax dupliqué pour le second formulaire
$(document).on('submit', '.depense-amount-edit', function (e) {
    e.preventDefault();
    var id = $(this).attr("data-attribute");

    var firstForm = '.depense-category-edit';
    var secondForm = '.depense-amount-edit';

    var data1 = $('tr[data-attribute="'+ id +'"]').find(firstForm).serialize();
    var data2 = $('tr[data-attribute="'+ id +'"]').find(secondForm).serialize();

    var category = escapeHtml($('tr[data-attribute="'+ id +'"]').find('input[name=category]').val());
    var amount = escapeHtml($('tr[data-attribute="'+ id +'"]').find('input[name=amount]').val());
    
    $.ajax({
	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	type: "POST",
	url: "/budget/edit/depense",
	data: data1 + "&" + data2
    }).done(function (msg) {
	var response = $.parseJSON(msg);

	if(response.status == "success") {
	    // si la requête est un succès, on rétablis les colonnes avec les nouvelles valeurs asynchrone
	    var categoryReplace = '<td class="category" data-attribute="'+ id +'">'+ response.category +'</td>';
	    var amountReplace = '<td class="amount" data-attribute="'+ id +'">'+ response.amount +'</td>';

	    $('tr[data-attribute="'+ id +'"]').find('.depense-category-edit').parent().replaceWith(categoryReplace);
	    $('tr[data-attribute="'+ id +'"]').find('.depense-amount-edit').parent().replaceWith(amountReplace);

	    syncBudgetTotal('tr.total', response.budget_id);
	}
    });
});

// suppression
$(document).on('click', 'button#delete-depense', function (e) {
    e.preventDefault();
    var id = $(this).attr("data-attribute");

    $.ajax({
	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	type: "GET",
	url: "/budget/delete/depense/" + id,
    }).done(function (msg) {
	var response = $.parseJSON(msg);

	if(response.status == "success") {
	    $('tr[data-attribute="'+ id +'"]').fadeOut(400, function() {
		$(this).remove();
	    });

	    syncBudgetTotal('tr.total', response.budget_id);
	}
    });
});

// modification des budgets
$(document).on('click', 'button#edit-budget', function() {
    var id = $(this).attr('data-attribute');

    var name = $('.table-header[data-attribute="'+ id +'"]');
    var vote = $('tr.vote[data-attribute="'+ id +'"]').find('.amount');
    var dm = $('tr.dm[data-attribute="'+ id +'"]').find('.amount');

    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    
    var formName = '<div class="table-header col-md-12" data-attribute="'+  id +'"><form method="POST" class="form budget-name-edit" data-attribute="'+ id +'">' + '<input type="hidden" name="csrf-token" value="' + csrf_token + '"><input type="hidden" name="id" value="'+ id +'">' + '<input type="text" class="form-control" name="name" value="' + name.text() + '"></form></div>';
    var formVote = '<td class="amount vote col-md-6"><form method="POST" class="form budget-vote-edit" data-attribute="'+ id +'">' + '<input type="hidden" name="csrf-token" value="' + csrf_token + '"><input type="hidden" name="id" value="'+ id +'">' + '<input type="text" class="form-control" name="vote" value="'+ unformat_number(vote.text()) +'"></form</td>';
    var formDm = '<td class="amount dm col-md-6"><form method="POST" class="form budget-dm-edit" data-attribute="'+ id +'">' + '<input type="hidden" name="csrf-token" value="' + csrf_token + '"><input type="hidden" name="id" value="'+ id +'">' + '<input type="text" class="form-control" name="dm" value="'+ unformat_number(dm.text()) +'"></form</td>';

    name.replaceWith(formName);
    vote.replaceWith(formVote);
    dm.replaceWith(formDm);
});

// traitement ajax dupliqué pour la modification des budgets
$(document).on('submit', '.budget-name-edit', function (e) {
    e.preventDefault();
    var id = $(this).attr("data-attribute");
    console.log(id);
    var firstForm = $('form.budget-name-edit[data-attribute="'+ id +'"]');
    var secondForm = $('form.budget-vote-edit[data-attribute="'+ id +'"]');
    var thirdForm = $('form.budget-dm-edit[data-attribute="'+ id +'"]');

    var data1 = firstForm.serialize();
    var data2 = secondForm.serialize();
    var data3 = thirdForm.serialize();
    
    $.ajax({
	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	type: "POST",
	url: "/budget/edit",
	data: data1 + "&" + data2 + "&" + data3
    }).done(function (msg) {
	var response = $.parseJSON(msg);

	if(response.status == "success") {
	    // si la requête est un succès, on rétablis les colonnes avec les nouvelles valeurs asynchrone
	    firstForm.parent().replaceWith('<div class="table-header col-md-12" data-attribute="'+  id +'">' + response.name + '<div class="pull-right"><button id="edit-budget" class="btn btn-xs btn-info btn-tree" data-attribute="'+ id +'"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button><button id="delete-budget" class="btn btn-xs btn-danger btn-tree" data-attribute="'+ id +'"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></div>');
	    secondForm.parent().replaceWith('<td class="amount col-md-6" data-attribute="'+ id +'">'+ response.vote +'</td>');
	    thirdForm.parent().replaceWith('<td class="amount col-md-6" data-attribute="'+ id +'">'+ response.dm +'</td>');

	    syncBudgetTotal('tr.total', id);
	}
    });
});

// traitement ajax dupliqué pour la modification des budgets
$(document).on('submit', '.budget-vote-edit', function (e) {
    e.preventDefault();
    var id = $(this).attr("data-attribute");
    console.log(id);
    var firstForm = $('form.budget-name-edit[data-attribute="'+ id +'"]');
    var secondForm = $('form.budget-vote-edit[data-attribute="'+ id +'"]');
    var thirdForm = $('form.budget-dm-edit[data-attribute="'+ id +'"]');

    var data1 = firstForm.serialize();
    var data2 = secondForm.serialize();
    var data3 = thirdForm.serialize();
    
    $.ajax({
	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	type: "POST",
	url: "/budget/edit",
	data: data1 + "&" + data2 + "&" + data3
    }).done(function (msg) {
	var response = $.parseJSON(msg);

	if(response.status == "success") {
	    // si la requête est un succès, on rétablis les colonnes avec les nouvelles valeurs asynchrone
	    firstForm.parent().replaceWith('<div class="table-header col-md-12" data-attribute="'+  id +'">' + response.name + '<div class="pull-right"><button id="edit-budget" class="btn btn-xs btn-info btn-tree" data-attribute="'+ id +'"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button><button id="delete-budget" class="btn btn-xs btn-danger btn-tree" data-attribute="'+ id +'"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></div>');
	    secondForm.parent().replaceWith('<td class="amount col-md-6" data-attribute="'+ id +'">'+ response.vote +'</td>');
	    thirdForm.parent().replaceWith('<td class="amount col-md-6" data-attribute="'+ id +'">'+ response.dm +'</td>');

	    syncBudgetTotal('tr.total', id);
	}
    });
});

// traitement ajax dupliqué pour la modification des budgets
$(document).on('submit', '.budget-dm-edit', function (e) {
    e.preventDefault();
    var id = $(this).attr("data-attribute");
    console.log(id);
    var firstForm = $('form.budget-name-edit[data-attribute="'+ id +'"]');
    var secondForm = $('form.budget-vote-edit[data-attribute="'+ id +'"]');
    var thirdForm = $('form.budget-dm-edit[data-attribute="'+ id +'"]');

    var data1 = firstForm.serialize();
    var data2 = secondForm.serialize();
    var data3 = thirdForm.serialize();
    
    $.ajax({
	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	type: "POST",
	url: "/budget/edit",
	data: data1 + "&" + data2 + "&" + data3
    }).done(function (msg) {
	var response = $.parseJSON(msg);

	if(response.status == "success") {
	    // si la requête est un succès, on rétablis les colonnes avec les nouvelles valeurs asynchrone
	    firstForm.parent().replaceWith('<div class="table-header col-md-12" data-attribute="'+  id +'">' + response.name + '<div class="pull-right"><button id="edit-budget" class="btn btn-xs btn-info btn-tree" data-attribute="'+ id +'"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button><button id="delete-budget" class="btn btn-xs btn-danger btn-tree" data-attribute="'+ id +'"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></div>');
	    secondForm.parent().replaceWith('<td class="amount col-md-6" data-attribute="'+ id +'">'+ response.vote +'</td>');
	    thirdForm.parent().replaceWith('<td class="amount col-md-6" data-attribute="'+ id +'">'+ response.dm +'</td>');

	    syncBudgetTotal('tr.total', id);
	}
    });
});

// ajout d'un budget
$(document).on('click', 'button#add-budget', function (e) {
    e.preventDefault();
    var id = $(this).attr("data-attribute");
    var year = $(this).attr("data-year");
    var parent = $(this).parent();

    console.log(id);

    $.ajax({
	type: "GET",
	url: "/budget/add/" + id + "/" + year,
    }).done(function (msg) {
	var response = $.parseJSON(msg);

	if(response.status == "success") {
	    var newData = '<li><div class="table-header col-md-12" data-attribute="'+ response.id +'"><name>'+ response.name +'</name><div class="pull-right"><button id="edit-budget" class="btn btn-xs btn-info btn-tree" data-attribute="'+ response.id +'"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button><button id="delete-budget" class="btn btn-xs btn-danger btn-tree" data-attribute="'+ response.id +'"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></div></div><table class="table table-striped table-hover table-bordered table-board"><tr class="vote" data-attribute="'+ response.id +'"><td class="category col-md-5">Budget voté</td><td class="amount col-md-6">'+ response.vote +'</td><td class="actions col-md-1">&nbsp;</td></tr><tr class="dm" data-attribute="'+ response.id +'"><td class="category col-md-5">Modification DM</td><td class="amount col-md-6">'+ response.dm +'</td><td class="actions col-md-1">&nbsp;</td></tr><tr class="total table-footer" data-attribute="'+ response.id +'"><td class="category">total</td><td class="amount"><total></total></td><td class="actions"><div class="add"><button id="add-depense" class="btn btn-md btn-warning btn-tree" data-attribute="'+ response.id +'"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button></div></td></tr></table></li>';
	    parent.before(newData);
	}
    });
});

// ajout d'une année budgétaire
$(document).on('click', 'button#add-year', function (e) {
    e.preventDefault();
	bootbox.prompt({
	    title: "Ajout d'une année budgétaire",
	    placeholder: "année souhaitée",
	    callback: function (year) {
		if(year != null) {
		    $.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			type: 'GET',
			url: 'budget/add/year/' + year,
		    }).done( function (msg) {
			var response = $.parseJSON(msg);

			if(response.status == "success") {
			    location.reload();
			}
		    });

		    location.reload();
		}
	    }
	});
});

// suppression d'un budget
$(document).on('click', 'button#delete-budget', function (e) {
    e.preventDefault();
    var id = $(this).attr("data-attribute");
    var parent = $(this).parent().parent().parent();

    console.log(id);

    $.ajax({
	type: "GET",
	url: "/budget/delete/" + id,
    }).done(function (msg) {
	var response = $.parseJSON(msg);

	if(response.status == "success") {
	    parent.fadeOut(800, function () {
		parent.remove();
	    });
	}
    });
});

// suppression d'une année budgétaire
$(document).on('click', 'button#delete-year', function (e) {
    e.preventDefault();
    var year = $(this).attr("data-attribute");
    var parent = $(this).parent();

    bootbox.confirm("Êtes-vous sûr de vouloir supprimer l'année budgétaire <b>"+ year +"</b> ?", function (result) {
	if(result) {
	    $.ajax({
		type: "GET",
		url: "/budget/delete/year/" + year,
	    }).done(function (msg) {
		var response = $.parseJSON(msg);

		if(response.status == "success") {
		    parent.fadeOut(800, function () {
			parent.remove();
		    });
		}
	    });
	}
    });
});

$('tr.total').each(function () {
    syncBudgetTotal('tr.total', $(this).attr('data-attribute'));
});
