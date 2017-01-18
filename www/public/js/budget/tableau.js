$('button#add').on('click', function() {
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    var form = '<form method="POST" action="ajout" class="form action-add">' + '<input type="hidden" name="csrf-token" value="' + csrf_token + '">' + '<input type="text" class="form-control" name="nom" placeholder="Nom de la nouvelle action"></form>';

    $('.action-list').prepend(form);
});
    
// VALIDATION - TRAITEMENT AJAX \\
$(document).on('click', 'button#add-depense', function (e) {
    e.preventDefault();
    var id = $(this).attr('data-attribute');
    var actual = $(this);

    console.log(id);

    $.ajax({
	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	type: "GET",
	url: '/budget/ajout/depense/' + id,
    }).done(function(msg) {
	var response = $.parseJSON(msg);

	if(response.status == "success") {
	    $('tr[data-attribute="' + id + '"]').before('<tr class="depense"><td class="category">' + response.category +'</td><td class="amount">' + response.amount +'</td></tr>');
	    
	    console.log("The ajax request returned successful result.");
	} else console.log("The ajax request returned an error.");
    });
});

