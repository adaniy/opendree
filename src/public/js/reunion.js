/** Constant variables */
const rate = 500;

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
            reunions: [],
            page: {
                actual: 1,
                max: 1
            },
            loading: false
        }
    },
    created: function () {
        this.getReunions();
        this.getMaxPage();
    },
    methods: {
        getReunions: function() {
            $.getJSON("/reunion/get/page/" + this.page.actual, function (reunions) {
                this.reunions = reunions;
                this.loading = false;
            }.bind(this));

            setTimeout(this.getReunions, rate);
        },
        nextPage: function () {
            this.loading = true;
            this.page.actual++;
        },
        previousPage: function () {
            this.loading = true;
            this.page.actual--;
        },
        lastPage: function () {
            this.loading = true;
            this.page.actual = this.page.max;
        },
        firstPage: function () {
            this.loading = true;
            this.page.actual = 1;
        },
        getMaxPage: function () {
            $.getJSON("/reunion/get/max-page/", function (maxPage) {
                this.page.max = maxPage;
            }.bind(this));

            setTimeout(this.getMaxPage, rate);
        },
        addReunion: function () {
	    this.loading = true;

            $.ajax({
                type: "GET",
                url: "/reunion/add"
            }).done( function(msg) {
                var response = $.parseJSON(msg);

                if(response.status == "success") {
                    $.notify({
                        title: '<strong>Requête executée avec succès.</strong><hr />',
                        message: "Une réunion viens d'être créée. Vous pouvez librement la modifier."
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
        },
        deleteReunion: function(reunion) {
            var id = reunion.id;

            bootbox.confirm({
                message: "Êtes-vous sûr de vouloir supprimer cette réunion ?",

                callback: function(event) {
                    if(event) {
			this.loading = true;

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
			this.loading = true;
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
        editDateReunion: function(reunion) {
            var id = reunion.id;
            var date = moment(reunion.date).format("YYYY-MM-DD");
            var hour = moment(reunion.date).format("HH:mm");

            var form = '<h4>Modification de la date de la réunion #'+ reunion.id +'</h4><hr /><form class="form edit-date"><div class="form-group col-md-7"><label for="date">Date :</label><br /><input type="date" class="form-control" value="'+ date +'" /></div><div class="form-group col-md-5"><label for="date">Heure :</label><br /><input type="time" class="form-control" value="'+ hour +'" /></div></form><br /><br /><br />';

            bootbox.confirm(form, function(result) {
                if(result) {
		    this.loading = true;
                    var date = $(document).find('.edit-date').find('input[type="date"]').val();
                    var hour = $(document).find('.edit-date').find('input[type="time"]').val();

                    /** Date finale a envoyer à la base de donnée, important d'ajouter manuellement les secondes à 0 pour éviter d'embrouiller l'utilisateur avec les secondes */
                    var finalDate = date + ' ' + hour + ':00';

                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        type: "POST",
                        url: "/reunion/edit/date",
                        data: {
                            id: id,
                            date: finalDate
                        }
                    }).done( function(msg) {
                        var response = $.parseJSON(msg);

                        if(response.status == "success") {
                            $.notify({
                                title: '<strong>Requête executée avec succès.</strong><hr />',
                                message: 'La date de la réunion selectionnée a bien été modifiée.'
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
            });
        },
        editDateProchainReunion: function(reunion) {
            var id = reunion.id;
            if(reunion.date_prochain) {
                var date = moment(reunion.date_prochain).format("YYYY-MM-DD");
                var hour = moment(reunion.date_prochain).format("HH:mm");
            } else {
                var date = "";
                var hour = "";
            }

            var form = '<h4>Modification de la date de la prochaine réunion, de la réunion #'+ reunion.id +'</h4><hr /><form class="form edit-date"><div class="form-group col-md-7"><label for="date">Date :</label><br /><input type="date" class="form-control" value="'+ date +'" /></div><div class="form-group col-md-5"><label for="date">Heure :</label><br /><input type="time" class="form-control" value="'+ hour +'" /></div></form><br /><br /><br />';

            bootbox.confirm(form, function(result) {
                if(result) {
		    this.loading = true;
                    var date = $(document).find('.edit-date').find('input[type="date"]').val();
                    var hour = $(document).find('.edit-date').find('input[type="time"]').val();

                    /** Date finale a envoyer à la base de donnée, important d'ajouter manuellement les secondes à 0 pour éviter d'embrouiller l'utilisateur avec les secondes */
                    var finalDate = date + ' ' + hour + ':00';

                    if(finalDate >= reunion.date) {
                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            type: "POST",
                            url: "/reunion/edit/dateprochain",
                            data: {
                                id: id,
                                date_prochain: finalDate
                            }
                        }).done( function(msg) {
                            var response = $.parseJSON(msg);

                            if(response.status == "success") {
                                $.notify({
                                    title: '<strong>Requête executée avec succès.</strong><hr />',
                                    message: 'La date de la prochaine réunion selectionnée a bien été modifiée.'
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
                    } else {
                        $.notify({
                            title: "<strong>La requête n'a pas pu être exécutée.</strong><hr />",
                            message: "La date de la prochaine réunion selectionnée ne peut pas être antérieure à la date de la réunion elle-même."
                        }, {
                            type: "danger"
                        });
                    }
                }
            });
        },
        nullifyDateProchain: function(reunion) {
	    this.loading = true;
            var id = reunion.id;

            $.ajax({
                type: "GET",
                url: "reunion/nullify-date-prochain/" + id
            }).done( function(msg) {
                var response = $.parseJSON(msg);
                if(response.status == "success") {
                    $.notify({
                        title: '<strong>Requête executée avec succès.</strong><hr />',
                        message: 'La date de la prochaine réunion selectionnée a bien été supprimée.'
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
        },
        addSubject: function(reunion) {
	    this.loading = true;
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
            return moment(date).format('dddd Do MMMM YYYY à HH:mm');
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
