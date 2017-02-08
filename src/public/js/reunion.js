/** Component of the reunion listing */
Vue.component('list', {
    template: '#reunion-template',
    data: function () {
        return {
            reunions: []
        }
    },
    created: function () {
        this.getReunions();
    },
    methods: {
        getReunions: function() {
            $.getJSON("/reunion/get", function (reunions) {
                this.reunions = reunions;
            }.bind(this));

            setTimeout(this.getReunions, 800);
        },
        deleteReunion: function(reunion) {
            var id = reunion.id;

            bootbox.confirm({
                message: "Êtes-vous sûr de vouloir supprimer cette réunion ?",

                callback: function(event) {
                    if(event) {
                        $.ajax({
                            type: "GET",
                            url: "/reunion/delete/" + id
                        }).done( function (msg) {
                            var response = $.parseJSON(msg);

                            if(response.status == "success") {
                                $.notify({
                                    title: '<strong>Requête executée avec succès.</strong><hr />',
                                    message: 'La réunion selectionnée a bien été supprimée de la base de donnée.'
                                }, {
                                    type: "success"
                                });
                            } else {
                                $.notify({
                                    title: "<strong>La requête n'a pas pu être exécutée.</strong><hr />",
                                    message: "Une erreur est survenu lors de l'execution de la requête. Veuillez ré-essayer ultérieurement."
                                }, {
                                    type: "danger"
                                });
                            }
                        });
                    }
                }
            });
        },
        editReunionSujet: function(reunion) {
            var id = reunion.id;
            var sujet = reunion.sujet;

            bootbox.prompt({
                title: "Modification du sujet de la réunion #"+ id +".",
                type: "text",
                value: sujet,
                callback: function (event) {
                    if(event) {
                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            type: "POST",
                            url: "/reunion/edit",
                            data: {
                                id: id,
                                sujet: event
                            }
                        }).done( function(msg) {
                            var response = $.parseJSON(msg);

                            if(response.status == "success") {
                                $.notify({
                                    title: '<strong>Requête executée avec succès.</strong><hr />',
                                    message: 'La réunion selectionnée a bien été modifiée.'
                                }, {
                                    type: "success"
                                });
                            } else {
                                $.notify({
                                    title: "<strong>La requête n'a pas pu être exécutée.</strong><hr />",
                                    message: "Une erreur est survenu lors de l'execution de la requête. Veuillez ré-essayer ultérieurement."
                                }, {
                                    type: "danger"
                                });
                            }
                        });
                    }
                }
            });
        }
    },
    filters: {
        moment: function (date) {
            moment.locale('fr');
            return moment(date).format('dddd Do MMMM YYYY à HH:mm:ss');
        }
    }
});

/** Component of the reunion's discussed subjects */
Vue.component('subjects', {
    props: ['parent'],
    data: function() {
	return {
	    subjects: []
	}
    },
    template: "<div><strong>{{ this.parent }}</strong></div>"
});

/** Component of the reunion amount */
Vue.component('amount', {
    data: function () {
        return {
            amount: 0
        }
    },
    template: "<strong v-cloak>{{ this.amount }} réunion(s)</strong>",
    created: function () {
        this.getAmount();
    },
    methods: {
        getAmount : function () {
            $.getJSON("/reunion/get/amount", function (amount) {
                this.amount = amount;
            }.bind(this));

            setTimeout(this.getAmount, 5000);
        }
    }
});

new Vue({
    el: '#reunion-module'
});
