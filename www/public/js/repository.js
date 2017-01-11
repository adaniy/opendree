// déploiement des panneaux supplémentaires pour certains boutons du menu gauche
$(document).ready(() => {
    $('.module').click(() => {
	$('.deploy').fadeToggle(200, "linear");
    });
});

// les alertes clignotent
(function blink() {
    $('.alerte-on').fadeOut(500).fadeIn(500, blink);
})();

// gestion du module "ACTION"
$('button.edit').on('click', () => {
    var old = 'test';
    var formBeginning = '<form method="POST">';
    var formInput = '<input type="text" class="form-control" name="test" value="' + old + '">';
    var formEnding = '</form>';

    $('button.edit').parent().parent().find('a').first().replaceWith(formBeginning + formInput + formEnding);
});
