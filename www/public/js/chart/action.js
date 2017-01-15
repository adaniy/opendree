function syncActionStats () {
    // le dougnuts
    $.ajax({
	type: "GET",
	url: "action/stats",
    }).done(function(msg) {
	var response = $.parseJSON(msg);
    
	if(response.status == "success") {
	    realise = response.realise;
	    nonRealise = response.nonRealise;
	    
	    config.data.datasets[0].data = [ realise, nonRealise ];
	    window.action.update();
	}
    });

    // les lignes
    $.ajax({
	type: "GET",
	url: "action/stats",
    }).done(function(msg) {
	var response = $.parseJSON(msg);

	if(response.status == "success") {
	    // à finir pour permettre l'auto rafraichissement des tableaux complexe
	    for(var data in response) {
		if($.inArray(response.line.annee, config2.data.labels) == -1) config2.data.labels.push(response.line.annee);
	    }

	    window.action2.update();
	}
    });
}

// d'abord, on obtiens les données avec une requête AJAX unique
syncActionStats();

// ensuite on synchronise les statistiques en temps réel
setInterval(function() {
    syncActionStats();

    console.log("test");
}, 5000);

var defaultData = 1;

// statistique par si réalisé ou non
var config = {
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
};

// statistiques par années des actions planifiées
var config2 = {
    type: 'line',
    data: {
	labels: [],
	datasets: [
            {
		label: "Réalisés",
		fill: false,
		lineTension: 0.1,
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
		pointHoverBackgroundColor: "rgba(75,192,192,1)",
		pointHoverBorderColor: "rgba(220,220,220,1)",
		pointHoverBorderWidth: 2,
		pointRadius: 1,
		pointHitRadius: 10,
		data: [],
		spanGaps: false,
            }
	]
    },
    options: {

    }
};

window.onload = function() {
    var ctx = document.getElementById("chart-action").getContext("2d");
    window.action = new Chart(ctx, config);

    var ctx2 = document.getElementById("chart-action2").getContext("2d");
    window.action2 = new Chart(ctx2, config2);
};
