/** Constant variables */
const rate = 100000;

/** Hack for textarea auto size */
$(function () {
    $(document).on('ready change click keyup keydown paste cut', 'textarea', function () {
        $(this).height(0).height(this.scrollHeight);
    }).find('textarea').change();
});

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

            setTimeout(this.getReunions, rate);
        },
	addReunion: function () {
	    $.ajax({
		type: "GET",
		url: "/reunion/add"
	    }).done( function(msg) {
		var response = $.parseJSON(msg);

		if(response.status == "success") {
		    console.log("added, now make a confirmation notify !");
		}
	    });
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
        editReunion: function(reunion) {
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
        },
        addSubject: function(reunion) {
            var id = reunion.id;

            $.ajax({
                type: "GET",
                url: "reunion/add/subject/" + id
            }).done( function(msg) {
                var response = $.parseJSON(msg);

                if(response.status == "success") {
                    $.notify({
                        title: '<strong>Requête executée avec succès.</strong><hr />',
                        message: 'Un sujet débattu dans la réunion a bien été créé.'
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
    template: "#subject-template",
    props: ['parent'],
    data: function() {
        return {
            subjects: []
        }
    },
    created: function () {
        this.getSubjects();
    },
    methods: {
        getSubjects: function() {
            $.getJSON("/reunion/get/subjects/" + this.parent, function (subject) {
                this.subjects = subject;
            }.bind(this));

            setTimeout(this.getSubjects, rate);
        },
        editReunionSubject: function(subject) {
            var id = subject.id;
            var sujet = subject.sujet;

            bootbox.prompt({
                title: "Modification du sujet débattu dans la réunion #"+ id +".",
                type: "text",
                value: sujet,
                callback: function (event) {
                    if(event) {
                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            type: "POST",
                            url: "/reunion/edit/subject",
                            data: {
                                id: id,
                                sujet: event
                            }
                        }).done( function(msg) {
                            var response = $.parseJSON(msg);

                            if(response.status == "success") {
                                $.notify({
                                    title: '<strong>Requête executée avec succès.</strong><hr />',
                                    message: 'Le sujet débattu selectionné a bien été modifiée.'
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
        editReunionObservation: function(subject) {
            var id = subject.id;
            var sujet = subject.sujet;
            var observation = subject.observation;

            bootbox.prompt({
                title: "Modification de l'observation du sujet débattu \""+ escapeHtml(sujet) +"\"",
                inputType: "textarea",
                value: observation,
                callback: function (event) {
                    if(event) {
                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            type: "POST",
                            url: "/reunion/edit/observation",
                            data: {
                                id: id,
                                observation: event
                            }
                        }).done( function(msg) {
                            var response = $.parseJSON(msg);

                            if(response.status == "success") {
                                $.notify({
                                    title: '<strong>Requête executée avec succès.</strong><hr />',
                                    message: "L'observation selectionné a bien été mise à jour."
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
        editReunionAction: function(subject) {
            var id = subject.id;
            var action = subject.action;
            var sujet = subject.sujet;

            bootbox.prompt({
                title: "Modification de l'action du sujet débattu \""+ escapeHtml(sujet) +"\"",
                inputType: "textarea",
                value: action,
                callback: function (event) {
                    if(event) {
                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            type: "POST",
                            url: "/reunion/edit/action",
                            data: {
                                id: id,
                                action: event
                            }
                        }).done( function(msg) {
                            var response = $.parseJSON(msg);

                            if(response.status == "success") {
                                $.notify({
                                    title: '<strong>Requête executée avec succès.</strong><hr />',
                                    message: "L'action selectionnée a bien été mise à jour."
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
        deleteReunionSubject: function(subject) {
            var id = subject.id;
            var sujet = subject.sujet;

            bootbox.confirm({
                message: 'Voulez-vous vraiment supprimer le sujet débattu <strong>"'+ escapeHtml(sujet) +'"</strong> ?',
                callback: function (event) {
                    if(event) {
                        $.ajax({
                            type: "GET",
                            url: "/reunion/delete/subject/" + id
                        }).done( function(msg) {
                            var response = $.parseJSON(msg);

                            if(response.status == "success") {
                                $.notify({
                                    title: '<strong>Requête executée avec succès.</strong><hr />',
                                    message: 'Le sujet débattu selectionné a bien été supprimé.'
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
        nl2br: function (string) {
            return nl2br(string);
        },
        escapeHtml: function (string) {
            return escapeHtml(string);
        }
    }
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

            setTimeout(this.getAmount, rate);
        }
    }
});

new Vue({
    el: '#reunion-module'
});
