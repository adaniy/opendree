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
