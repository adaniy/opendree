function syncActionStatsDoughnut () {
    $.ajax({
	type: "GET",
	url: "action/stats",
    }).done(function(msg) {
	var response = $.parseJSON(msg);
    
	if(response.status == "success") {
	    realise = response.realise;
	    nonRealise = response.nonRealise;
	    
	    doughnut.data.datasets[0].data = [ realise, nonRealise ];
	    doughnut.update();
	}
    });

    
}

function syncActionStatsLine () {
    $.ajax({
	type: "GET",
	url: "action/stats",
    }).done(function(msg) {
	var response = $.parseJSON(msg);

	if(response.status == "success") {
	    line.data.labels = response.line.annee;
	    line.data.datasets[0].data = response.line.nbRealise;
	    line.data.datasets[1].data = response.line.nbNonRealise;

	    line.update();
	}
    });
}

function syncActionStats () {
    $.ajax({
	type: "GET",
	url: "action/stats",
    }).done(function(msg) {
	var response = $.parseJSON(msg);

	if(response.status == "success") {
	    $('action-realise').text(response.realise);
	    $('action-non-realise').text(response.nonRealise);
	    $('action-total').text(response.nb);
	}
    });
}

// d'abord, on obtiens les données avec une requête AJAX unique
syncActionStatsDoughnut();
syncActionStatsLine();
syncActionStats();

// ensuite on répète ces fonctions dans une intervale les statistiques en temps réel
setInterval(function() {
    syncActionStatsDoughnut();
    syncActionStatsLine();
    syncActionStats();
}, 4000);

var defaultData = 1;

// comparaison des actions
var ctx = document.getElementById("chart-action").getContext("2d");
var doughnut = new Chart(ctx, {
    type: 'doughnut',
    data: {
        datasets: [{
	    data: [
                defaultData,
                defaultData,
	    ],
	    backgroundColor: [
                '#56E953',
		'#D31C13',
	    ],
	    label: 'Actions planifiées'
        }],
        labels: [
	    "Réalisés",
	    "Non réalisés",
        ]
    },
    options: {
        responsive: true,
        legend: {
	    position: 'top',
        },
        title: {
	    display: true,

        },
        animation: {
	    animateScale: true,
	    animateRotate: true
        }
    }
});

// statistiques par années des actions planifiées
var ctx2 = document.getElementById("chart-action2").getContext("2d");
var line = new Chart.Line(ctx2, {
    data: {
	labels: [],
	datasets: [
            {
		label: "Réalisés",
		fill: false,
		lineTension: 0.2,
		backgroundColor: "#56E953",
		borderColor: "#56E953",
		borderCapStyle: 'butt',
		borderDash: [],
		borderDashOffset: 0.0,
		borderJoinStyle: 'miter',
		pointBorderColor: "rgba(75,192,192,1)",
		pointBackgroundColor: "#fff",
		pointBorderWidth: 1,
		pointHoverRadius: 5,
		pointHoverBackgroundColor: "#56E953",
		pointHoverBorderColor: "#56E953",
		pointHoverBorderWidth: 2,
		pointRadius: 1,
		pointHitRadius: 10,
		data: [],
		spanGaps: false,
            },
	    {
		label: "Non réalisés",
		fill: false,
		lineTension: 0.2,
		backgroundColor: "#D31C13",
		borderColor: "#D31C13",
		borderCapStyle: 'butt',
		borderDash: [],
		borderDashOffset: 0.0,
		borderJoinStyle: 'miter',
		pointBorderColor: "#D31C13",
		pointBackgroundColor: "#fff",
		pointBorderWidth: 1,
		pointHoverRadius: 5,
		pointHoverBackgroundColor: "#D31C13",
		pointHoverBorderColor: "#D31C13",
		pointHoverBorderWidth: 2,
		pointRadius: 1,
		pointHitRadius: 10,
		data: [],
		spanGaps: false,
            }
	]
    }
});
