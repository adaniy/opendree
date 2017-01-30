function syncRaw () {
    $.ajax({
        type: "GET",
        url: "/dashboard/stats/raw",
    }).done(function(msg) {
        var response = $.parseJSON(msg);

        if(response.status == "success") {
	    console.log(response);
        }
    });
}

function syncDashboard () {
    $.ajax({
        type: "GET",
        url: "/dashboard/stats",
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
        url: "/dashboard/stats/",
    }).done(function(msg) {
        var response = $.parseJSON(msg);

        if(response.status == "success") {
            line.data.datasets = response.line.categories.values;

            line.update();
        }
    });
}

function syncDashboardComparison () {
    $.ajax({
        type: "GET",
        url: "/dashboard/stats/comparison",
    }).done(function(msg) {
        var response = $.parseJSON(msg);

        if(response.status == "success") {
            pie.data.datasets[0].data = response.pie.data;

            pie.update();
        }
    });
}

function getDashboardComparisonCategories () {
    $.ajax({
        type: "GET",
        url: "/dashboard/stats/comparison/",
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

// d'abord, on obtiens les données avec une requête AJAX unique
syncRaw();
syncDashboard();
getDashboardCategories();

syncDashboardComparison();
getDashboardComparisonCategories();

// ensuite on répète ces fonctions dans une intervale les statistiques en temps réel
setInterval(function() {
    syncDashboard();
    syncDashboardComparison();
}, 4000);

/** Mise à jour manuelle des graphiques */
$(document).on('click', 'button#update-amount-line', function () {
    syncDashboard();
    getDashboardCategories();
});
$(document).on('click', 'button#update-amount-pie', function () {
    syncDashboardComparison();
    getDashboardComparisonCategories();
});

// statistiques par années des actions planifiées
var ctx = document.getElementById("chart-dashboard-1").getContext("2d");
var line = new Chart.Line(ctx, {
    data: {
        labels: [],
        datasets: []
    }
});

var ctx2 = document.getElementById("chart-dashboard-2").getContext("2d");
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
