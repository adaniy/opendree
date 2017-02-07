

Vue.component('list', {
    template: '#reunion-template',
    data: function () {
        return {
            reunions: []
        }
    },
    created: function () {
        this.getReunions();
        console.log("success !");
    },
    methods: {
        getReunions: function() {
            $.getJSON("/reunion/get", function (reunions) {
                this.reunions = reunions;
            }.bind(this));

            setTimeout(this.getReunions, 1000);
        },
    },
    filters: {
        moment: function (date) {
	    moment.locale('fr');
            return moment(date).format('dddd Do MMMM YYYY à h:mm:ss a');
        }
    }
});

new Vue({
    el: '#reunion-module'
});
