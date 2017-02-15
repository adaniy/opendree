const rate = 120000;

Vue.component('list', {
    template: "#list",
    data: function () {
        return {
            years: [],
            nbPerMonth: {

            }
        }
    },
    created: function () {
        this.getYears();

        setInterval( () => {
            this.getYears()
        }, rate);
    },
    methods: {
        getYears: function () {
            axios.get('/election/get/years')
                .then( response => {
                    this.years = response.data;
                })
                .catch( error => {
                    console.log(error);
                })
        },
        getYear: function(date) {
            moment.locale('fr');
            return moment(date).format("YYYY");
        },
        addData: function(type) {
            var form = '<h4>Ajout de donnée dans les inscriptions aux listes électorales</h4><hr /><form id="add-data" class="form"><div class="form-group"><input type="date" class="form-control" name="date" /></div><div class="form-group"><input type="number" class="form-control" name="nb" placeholder="Nombre d\'inscription" /></div></form>';

            bootbox.confirm(form, function(result) {
                if(result) {
                    var date = $(document).find('#add-data').find('input[name="date"]').val();
                    var nb = $(document).find('#add-data').find('input[name="nb"]').val();

                    axios.post("/election/add", {
                        type: type,
                        date: date,
                        nb: nb
                    })
                        .then( response => {
                            location.reload();
                        })
                        .catch( error => {
                            console.log(error);
                        })
                }
            });
        }
    },
    filters: {
        year: function (date) {
            moment.locale('fr');
            return moment(date).format("YYYY");
        },
        month: function (month) {
            moment.locale('fr');
            return moment().month(month - 1).format("MMMM");
        }
    }
});

Vue.component('total-year-electoral', {
    props: ['year'],
    template: "#total-year-electoral",
    data: function () {
        return {
            nb: 0
        }
    },
    created: function () {
        this.getNbDay();

        setInterval( () => {
            this.getNbDay();
        }, rate);
    },
    methods: {
        getNbDay: function() {
            axios.get("/election/get/total/electoral/year/"+ this.year)
                .then( response => {
                    this.nb = response.data;
                })
                .catch( error => {
                    console.log(error);
                })
        }
    }
});

Vue.component('nb-year-electoral', {
    props: ['year', 'month'],
    template: "#nb-year-electoral",
    data: function () {
        return {
            nb: 0
        }
    },
    created: function () {
        this.getNbYear();

        setInterval( () => {
            this.getNbYear();
        }, rate);
    },
    methods: {
        getNbYear: function() {
            axios.get("/election/get/nb/electoral/year/"+ this.year +"/month/"+ this.month +"")
                .then( response => {
                    this.nb = response.data;
                })
                .catch( error => {
                    console.log(error);
                })
        }
    }
});

Vue.component('nb-spec-electoral', {
    props: ['year', 'month', 'day'],
    template: "#nb-year-electoral",
    data: function () {
        return {
            nb: 0
        }
    },
    created: function () {
        this.getNbDay();

        setInterval( () => {
            this.getNbDay();
        }, rate);
    },
    methods: {
        getNbDay: function() {
            axios.get("/election/get/nb/spec/year/"+ this.year +"/month/"+ this.month +"/day/" + this.day)
                .then( response => {
                    this.nb = response.data;
                })
                .catch( error => {
                    console.log(error);
                })
        }
    }
});

Vue.component('total-year-recensement', {
    props: ['year'],
    template: "#total-year-recensement",
    data: function () {
        return {
            nb: 0
        }
    },
    created: function () {
        this.getNbDay();

        setInterval( () => {
            this.getNbDay();
        }, rate);
    },
    methods: {
        getNbDay: function() {
            axios.get("/election/get/total/recensement/year/"+ this.year)
                .then( response => {
                    this.nb = response.data;
                })
                .catch( error => {
                    console.log(error);
                })
        }
    }
});

Vue.component('nb-year-recensement', {
    props: ['year', 'month'],
    template: "#nb-year-recensement",
    data: function () {
        return {
            nb: 0
        }
    },
    created: function () {
        this.getNbYear();

        setInterval( () => {
            this.getNbYear();
        }, rate);
    },
    methods: {
        getNbYear: function() {
            axios.get("/election/get/nb/recensement/year/"+ this.year +"/month/"+ this.month +"")
                .then( response => {
                    this.nb = response.data;
                })
                .catch( error => {
                    console.log(error);
                })
        }
    }
});

new Vue({
    el: "#election-module"
});
