"use strict";

var id = $('meta[name="service"]').attr('content');

function syncDashboard () {
    $.ajax({
        type: "GET",
        url: "/dashboard/stats/service/" + id
    }).done(function(msg) {
        var response = $.parseJSON(msg);

        if(response.status == "success") {
            line.data.labels = response.line.year;

            line.update();
        }
    });
}

function getDashboardCategories () {
    $.ajax({
        type: "GET",
        url: "/dashboard/stats/service/" + id
    }).done(function(msg) {
        var response = $.parseJSON(msg);

        if(response.status == "success") {
            line.data.datasets = response.line.categories.values;

            line.update();
        }
    });
}

syncDashboard();
getDashboardCategories();

var ctx = document.getElementById("chart-dashboard-service").getContext("2d");
var line = new Chart.Line(ctx, {
    data: {
        labels: [],
        datasets: []
    }
});
