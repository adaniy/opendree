/** Constant variables
 *
 * Rate variable handles the rate speed of all asynchronous datas in this file
 */
const rate = 10000;
const rate2 = 3000;

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
            regexp: {
                nom: "",
                date: ""
            },
            search: false,
            loading: false,
            amount: 0
        }
    },
    created: function () {
        this.getReunions();
        this.getMaxPage();
        this.getAmount();

        setInterval(() => {
            this.getReunions();
            this.getMaxPage();
            this.getAmount();
        }, rate);
    },
    methods: {
        getReunions: function() {
            if(this.search) {
                if(this.regexp.nom != "" && this.regexp.date != "") { /** If the name and date is completed */
                    var url = "/reunion/get/page/" + this.page.actual + "/search/" + this.regexp.nom + "/" + this.regexp.date;
                } else if(this.regexp.nom != "" && this.regexp.date == "") { /** If the name alone is completed */
                    var url = "/reunion/get/page/" + this.page.actual + "/search/" + this.regexp.nom + "/null";
                } else if(this.regexp.date != "" && this.regexp.nom == "") { /** If the date alone is completed */
                    var url = "/reunion/get/page/" + this.page.actual + "/search/null/" + this.regexp.date;
                } else { /** If neither is completed */
                    var url = "/reunion/get/page/" + this.page.actual;
                }
            } else {
                var url = "/reunion/get/page/" + this.page.actual;
            }

            axios.get(url)
                .then( response => {
                    this.reunions = response.data.reunions;
                    this.loading = false;
                })
                .catch( error => {
                    console.log(error);
                });
        },
	getUrlPrintable: function (reunion) {
	    return "/reunion/get/printable/" + reunion.id;
	},
        getMaxPage: function () {
            if(this.search) {
                if(this.regexp.nom != "" && this.regexp.date != "") { /** If the name and date is completed */
                    var url = "/reunion/get/max-page/" + this.regexp.nom + "/" + this.regexp.date;
                } else if(this.regexp.nom != "" && this.regexp.date == "") { /** If the name alone is completed */
                    var url = "/reunion/get/max-page/" + this.regexp.nom + "/null";
                } else if(this.regexp.date != "" && this.regexp.nom == "") { /** If the date alone is completed */
                    var url = "/reunion/get/max-page/null/" + this.regexp.date;
                } else { /** If neither is completed */
                    var url = "/reunion/get/max-page";
                }
            } else {
                var url = "/reunion/get/max-page/";
            }

            axios.get(url)
                .then( response => {
                    this.page.max = response.data;
                })
                .catch( error => {
                    console.log(error);
                });
        },
        getAmount : function () {
            if(this.search) {
                if(this.regexp.nom != "" && this.regexp.date != "") { /** If the name and date is completed */
                    var url = "/reunion/get/amount/" + this.regexp.nom + "/" + this.regexp.date;
                } else if(this.regexp.nom != "" && this.regexp.date == "") { /** If the name alone is completed */
                    var url = "/reunion/get/amount/" + this.regexp.nom + "/null";
                } else if(this.regexp.date != "" && this.regexp.nom == "") { /** If the date alone is completed */
                    var url = "/reunion/get/amount/null/" + this.regexp.date;
                } else { /** If neither is completed */
                    var url = "/reunion/get/amount";
                }
            } else {
                var url = "/reunion/get/amount/";
            }

            axios.get(url)
                .then( response => {
                    this.amount = response.data;
                })
                .catch( error => {
                    console.log(error);
                });

            this.getMaxPage();
        },
        nextPage: function () {
            this.loading = true;
            this.page.actual++;
            this.getReunions();

            clearInterval();
        },
        previousPage: function () {
            this.loading = true;
            this.page.actual--;
            this.getReunions();
        },
        lastPage: function () {
            this.loading = true;
            this.page.actual = this.page.max;
            this.getReunions();
        },
        firstPage: function () {
            this.loading = true;
            this.page.actual = 1;
            this.getReunions();
        },
        addReunion: function () {
            var component = this;

            $.ajax({
                type: "GET",
                url: "/reunion/add"
            }).done( function(msg) {
                var response = $.parseJSON(msg);

                if(response.status == "success") {
                    component.getReunions();
                    component.loading = true;

                    $.notify({
                        message: "Une réunion viens d'être créée. Vous pouvez librement la modifier."
                    }, {
                        type: "success"
                    });
                } else {
                    $.notify({
                        message: "Une erreur est survenu lors de l'execution de la requête. Veuillez ré-essayer ultérieurement."
                    }, {
                        type: "danger"
                    });
                }
            });
        },
        deleteReunion: function(reunion) {
            var id = reunion.id;

            var component = this;

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
                                component.getReunions();
                                component.getAmount();
                                component.loading = true;

                                $.notify({
                                    message: 'La réunion selectionnée a bien été supprimée de la base de donnée.'
                                }, {
                                    type: "success"
                                });
                            } else {
                                $.notify({
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

            var component = this;

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
                            component.getReunions();
                            component.loading = true;

                            var response = $.parseJSON(msg);

                            if(response.status == "success") {
                                $.notify({
                                    message: 'La réunion selectionnée a bien été modifiée.'
                                }, {
                                    type: "success"
                                });
                            } else {
                                $.notify({
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

            var component = this;

            bootbox.confirm(form, function(result) {
                if(result) {
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
                            component.getReunions();
                            component.loading = true;

                            $.notify({
                                message: 'La date de la réunion selectionnée a bien été modifiée.'
                            }, {
                                type: "success"
                            });
                        } else {
                            $.notify({
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

            var component = this;

            bootbox.confirm(form, function(result) {
                if(result) {
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
                                component.getReunions();
                                component.loading = true;

                                $.notify({
                                    message: 'La date de la prochaine réunion selectionnée a bien été modifiée.'
                                }, {
                                    type: "success"
                                });
                            } else {
                                $.notify({
                                    message: "Une erreur est survenu lors de l'execution de la requête. Veuillez ré-essayer ultérieurement."
                                }, {
                                    type: "danger"
                                });
                            }
                        });
                    } else {
                        $.notify({
                            message: "La date de la prochaine réunion selectionnée ne peut pas être antérieure à la date de la réunion elle-même."
                        }, {
                            type: "danger"
                        });
                    }
                }
            });
        },
        nullifyDateProchain: function(reunion) {
            var id = reunion.id;

            var component = this;

            $.ajax({
                type: "GET",
                url: "reunion/nullify-date-prochain/" + id
            }).done( function(msg) {
                var response = $.parseJSON(msg);
                if(response.status == "success") {
                    component.getReunions();
                    component.loading = true;

                    $.notify({
                        message: 'La date de la prochaine réunion selectionnée a bien été supprimée.'
                    }, {
                        type: "success"
                    });
                } else {
                    $.notify({
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

/** Component of the reunion's participants */
Vue.component('participants', {
    template: "#participant-template",
    props: ['parent'],
    data: function() {
        return {
            presents: [],
            absents: [],
            secretaires: [],
            nom: "",
            type: ""
        }
    },
    created: function() {
        this.getPresents();
        this.getAbsents();
        this.getSecretaires();

        setInterval( () => {
            this.getParticipants();
        }, rate2);
    },
    methods: {
        getParticipants: function () {
            this.getPresents();
            this.getAbsents();
            this.getSecretaires();
        },
        getPresents: function() {
            axios.get("/reunion/get/present/" + this.parent)
                .then( response => {
                    this.presents = response.data;
                })
                .catch( error => {
                    console.log(error);
                });
        },
        getAbsents: function () {
            axios.get("/reunion/get/absent/" + this.parent)
                .then( response => {
                    this.absents = response.data;
                })
                .catch( error => {
                    console.log(error);
                });
        },
        getSecretaires: function () {
            axios.get("/reunion/get/secretaire/" + this.parent)
                .then( response => {
                    this.secretaires = response.data;
                })
                .catch( error => {
                    console.log(error);
                });
        },
        addParticipant: function (input) {
            var id = input.target.id.value;
            var nom = input.target.nom.value;
            var type = input.target.type.value;

            var component = this;

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "POST",
                url: "/reunion/add/participant",
                data: {
                    id: id,
                    nom: nom,
                    type: type
                }
            }).done( function(msg) {
                var response = $.parseJSON(msg);

                component.nom = "";
                component.type = "";

                component.getParticipants();
                component.loading = true;

                if(response.status == "success") {
                    $.notify({
                        message: "Le participant entré a bien été inséré dans la base de donnée."
                    }, {
                        type: "success"
                    });
                } else {
                    $.notify({
                        message: "Une erreur est survenu lors de l'execution de la requête. Veuillez ré-essayer ultérieurement."
                    }, {
                        type: "danger"
                    });
                }
            }.bind(this));
        },
        deleteParticipant: function(participant) {
            var id = participant.id;

            var component = this;

            $.ajax({
                type: "GET",
                url: "/reunion/delete/participant/" + id
            }).done( function(msg) {
                var response = $.parseJSON(msg);

                if(response.status == "success") {
                    component.getParticipants();
                    component.loading = true;

                    $.notify({
                        message: "Le participant selectionné a bien été supprimé de la base de donnée."
                    }, {
                        type: "success"
                    });
                } else {
                    $.notify({
                        message: "Une erreur est survenu lors de l'execution de la requête. Veuillez ré-essayer ultérieurement."
                    }, {
                        type: "danger"
                    });
                }
            });
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

        setInterval( () => {
            this.getSubjects();
        }, rate2)
    },
    methods: {
        getSubjects: function() {
            axios.get("/reunion/get/subjects/" + this.parent)
                .then( response => {
                    this.subjects = response.data;
                })
                .catch( error => {
                    console.log(error);
                });
        },
        addSubject: function(subject) {
            var id = this.parent;

            var component = this;

            $.ajax({
                type: "GET",
                url: "reunion/add/subject/" + id
            }).done( function(msg) {
                var response = $.parseJSON(msg);

                if(response.status == "success") {
                    component.getSubjects();
                    component.loading = true;

                    $.notify({
                        message: 'Un sujet débattu dans la réunion a bien été créé.'
                    }, {
                        type: "success"
                    });
                } else {
                    $.notify({
                        message: "Une erreur est survenu lors de l'execution de la requête. Veuillez ré-essayer ultérieurement."
                    }, {
                        type: "danger"
                    });
                }
            });
        },
        editReunionSubject: function(subject) {
            var id = subject.id;
            var sujet = subject.sujet;

            var component = this;

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
                                component.getSubjects();

                                $.notify({
                                    message: 'Le sujet débattu selectionné a bien été modifiée.'
                                }, {
                                    type: "success"
                                });
                            } else {
                                $.notify({
                                    message: "Une erreur est survenu lors de l'execution de la requête. Veuillez ré-essayer ultérieurement."
                                }, {
                                    type: "danger"
                                });
                            }
                        }.bind(this));
                    }
                }
            });
        },
        editReunionObservation: function(subject) {
            var id = subject.id;
            var sujet = subject.sujet;
            var observation = subject.observation;

            var component = this;

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
                                component.getSubjects();

                                $.notify({
                                    message: "L'observation selectionné a bien été mise à jour."
                                }, {
                                    type: "success"
                                });
                            } else {
                                $.notify({
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

            var component = this;

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
                                component.getSubjects();

                                $.notify({
                                    message: "L'action selectionnée a bien été mise à jour."
                                }, {
                                    type: "success"
                                });
                            } else {
                                $.notify({
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

            var compoent = this;

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
                                component.getSubjects();

                                $.notify({
                                    message: 'Le sujet débattu selectionné a bien été supprimé.'
                                }, {
                                    type: "success"
                                });
                            } else {
                                $.notify({
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

new Vue({
    el: '#reunion-module'
});
