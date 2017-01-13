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
    
    // TITRES - AJOUTS \\
    // ------------------------- \\
    $('button#add').on('click', function() {
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	var form = '<form method="POST" action="ajout" class="form action-add">' + '<input type="hidden" name="csrf-token" value="' + csrf_token + '">' + '<input type="text" class="form-control" name="nom" placeholder="Nom de la nouvelle action"></form>';

	$('.list').first().prepend(form);
    });

    $(document).on('submit', '.action-add', function (e) {
	e.preventDefault();
	var value = $(this).find('input[name=nom]').val();
	var deleteForm = $(this).remove();
	
	$.ajax({
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    type: "POST",
	    url: 'ajout',
	    data: $(this).serialize()
	}).done(function(msg) {
	    var response = $.parseJSON(msg);

	    if(response.status == "success") {
		let dataReplace = '<div class="list"><div class="pull-right"><button id="edit" class="live"><span class="glyphicon glyphicon-remove" aria-hidden="true"></button></div><a href="' + response.id + '"><li>' + value + '</li></a></div>';

		$('.list').first().prepend(dataReplace);
		deleteForm;

		console.log("The ajax request returned successful result.");
	    } else console.log("The ajax request returned an error.");
	});
    });

    // TITRES - MODIFICATIONS \\
    // ---------------------------- \\
    $('button#edit').on('click', function() {
	var id = $(this).attr('data-attribute');
	var old = $(this).closest('.list').text();
	var url = 'edit/nom';
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	var form = '<form method="POST" data-attribute="'+ id +'" action="' + url + '" class="form action-edit">' + '<input type="hidden" name="csrf-token" value="' + csrf_token + '">' + '<input type="hidden" name="id" value="'+ id +'"><input tfype="text" class="form-control" name="nom" value="'+ old +'"></form>';
	$(this).closest('.list').replaceWith(form);
    });

    $(document).on('submit', '.action-edit', function (e) {
	e.preventDefault();
	var value = $(this).find('input[name=nom]').val();
	var id = $(this).attr('data-attribute');
	var actual = $(this);
	var url = 'edit/nom';
	
	$.ajax({
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    type: "POST",
	    url: url,
	    data: $(this).serialize()
	}).done(function(msg) {
	    var response = $.parseJSON(msg);
	    console.log(response.status);
	    if(response.status == "success") {
		let dataReplace = '<div class="list"><div class="pull-right"><button id="edit" class="live"><span class="glyphicon glyphicon-remove" aria-hidden="true"></button></div><a href="action/' + id + '"><li>' + value + '</li></a></div>';
		    
		actual.replaceWith(dataReplace);
	    }
	});
    });

    // DESCRIPTION  - MODIFICATION \\
    // ------------------------------ \\
    
});



