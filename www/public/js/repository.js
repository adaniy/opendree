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

	$('.list').first().prepend(form);
    });

    $(document).on('submit', '.action-add', function (e) {
	e.preventDefault();
	var value = $(this).find('input[name=nom]').val();

	var actual = $(this);
	
	$.ajax({
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    type: "POST",
	    url: 'ajout',
	    data: $(this).serialize()
	}).done(function(msg) {
	    var response = $.parseJSON(msg);

	    if(response.status == "success") {
		let dataReplace = '<div class="list"><div class="pull-right"><button id="edit" class="live"><span class="glyphicon glyphicon-remove" aria-hidden="true"></button></div><a href="' + response.id + '"><li>' + value + '</li></a></div>';

		actual.replaceWith(dataReplace);


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
	var form = '<form method="POST" data-attribute="'+ id +'" action="' + url + '" class="form action-edit">' + '<input type="hidden" name="csrf-token" value="' + csrf_token + '">' + '<input type="hidden" name="id" value="'+ id +'"><input type="text" class="form-control" name="nom" value="'+ old +'"></form>';
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
});



