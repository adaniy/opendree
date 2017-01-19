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
	    $('tr[data-attribute="' + id + '"]').before('<tr class="depense" data-attribute="'+ response.id +'"><td class="category">' + response.category +'</td><td class="amount">' + response.amount +'</td><td class="actions"><button id="edit-depense" class="btn  btn-xs btn-info live" data-attribute="'+ response.id +'"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button> <button id="delete-depense" class="btn btn-xs btn-danger live" data-attribute="'+ response.id +'"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>');
	    
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
    var id = $(this).parent().parent().attr('data-attribute');

    var name = $(this).parent().parent();
    var vote = $('.amount[data-attribute="'+ id +'"]');
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    
    var formName = '<div class="table-header col-md-12"><form method="POST" class="form budget-name-edit" data-attribute="'+ id +'">' + '<input type="hidden" name="csrf-token" value="' + csrf_token + '"><input type="hidden" name="id" value="'+ id +'">' + '<input type="text" class="form-control" name="name" value="' + name.text() + '"></form></div>';
    var formVote = '<td class="amount"><form method="POST" class="form budget-vote-edit" data-attribute="'+ id +'">' + '<input type="hidden" name="csrf-token" value="' + csrf_token + '"><input type="hidden" name="id" value="'+ id +'">' + '<input type="text" class="form-control" name="vote" value="'+ unformat_number(vote.text()) +'"></form</td>';

    name.replaceWith(formName);
    vote.replaceWith(formVote);
});

// traitement ajax dupliqué pour la modification des budgets
$(document).on('submit', '.budget-name-edit', function (e) {
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

$('tr.total').each(function () {
    syncBudgetTotal('tr.total', $(this).attr('data-attribute'));
});
