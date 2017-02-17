function syncDashboardYear () {
    var year = $('meta[name="year"]').attr('content');

    $.ajax({
        type: "GET",
        url: "/dashboard/stats/year/" + year,
    }).done(function(msg) {
        var response = $.parseJSON(msg);

        if(response.status == "success") {
            line.data.labels = response.line.month;

            line.update();
        }
    });
}

function getDashboardYearCategories () {
    var year = $('meta[name="year"]').attr('content');

    $.ajax({
        type: "GET",
        url: "/dashboard/stats/year/" + year,
    }).done(function(msg) {
        var response = $.parseJSON(msg);

        if(response.status == "success") {
            line.data.datasets = response.line.categories.values;

            line.update();
        }
    });
}

function syncDashboardYearComparison () {
    var year = $('meta[name="year"]').attr('content');

    $.ajax({
        type: "GET",
        url: "/dashboard/stats/comparison/year/" + year,
    }).done(function(msg) {
        var response = $.parseJSON(msg);

        if(response.status == "success") {
            pie.data.datasets[0].data = response.pie.data;


            pie.update();
        }
    });
}

function getDashboardYearComparisonCategories () {
    var year = $('meta[name="year"]').attr('content');

    $.ajax({
        type: "GET",
        url: "/dashboard/stats/comparison/year/" + year,
    }).done(function(msg) {
        var response = $.parseJSON(msg);

        if(response.status == "success") {
            pie.data.labels = response.pie.labels;
            pie.data.datasets[0].backgroundColor = response.pie.backgroundColor;
            pie.data.datasets[0].hoverBackgroundColor = response.pie.hoverBackgroundColor;

            pie.update();
        }
    });
}

/** Mise à jour manuelle des graphiques */
$(document).on('click', 'button#update-amount-line', function () {
    getDashboardYearCategories();
});

$(document).on('click', 'button#update-amount-pie', function () {
    getDashboardYearComparisonCategories();
});

// d'abord, on obtiens les données avec une requête AJAX unique
syncDashboardYear();
getDashboardYearCategories();

syncDashboardYearComparison();
getDashboardYearComparisonCategories();

// ensuite on répète ces fonctions dans une intervale les statistiques en temps réel
setInterval(function() {
    syncDashboardYear();
    syncDashboardYearComparison();
}, 4000);

// statistiques par années des actions planifiées
var ctx = document.getElementById("chart-dashboard-year-1").getContext("2d");
var line = new Chart.Line(ctx, {
    data: {
        labels: [],
        datasets: []
    }
});

var ctx2 = document.getElementById("chart-dashboard-year-2").getContext("2d");
var pie = new Chart(ctx2,{
    type: 'pie',
    data: {
        labels: [],
        datasets: [
            {
                data: [],
                backgroundColor: [],
                hoverBackgroundColor: []
            }
        ]
    }
});
