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

// d'abord, on obtiens les données avec une requête AJAX unique
syncDashboardYear();
getDashboardYearCategories();

// ensuite on répète ces fonctions dans une intervale les statistiques en temps réel
setInterval(function() {
    syncDashboardYear();
}, 4000);

// statistiques par années des actions planifiées
var ctx = document.getElementById("chart-dashboard-year-1").getContext("2d");
var line = new Chart.Line(ctx, {
    data: {
        labels: [],
        datasets: []
    }
});
