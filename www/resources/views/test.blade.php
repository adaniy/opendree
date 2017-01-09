<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/override.css') }}" rel="stylesheet">

        <title>GDMC</title>
    </head>
    <body>
	<nav class="menu">
	    <li>
		<button><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span></button>

		<div class="deploy">
		    <div class="titre">Modules</div>
		    <a href="#"><ul>▶ election</ul></a>
		    <a href="#"><ul>▶ reunion</ul></a>
		    <a href="#"><ul>▶ action</ul></a>
		    <a href="#"><ul>▶ budget</ul></a>
		    <a><ul class="disabled">▶ planning</ul></a>
		</div>
	    </li>

	    <li><a href="#"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></a></li>
	</nav>

	<nav class="info">
	    <div class="alerte-off">
		aucune alerte
	    </div>

	    <div class="alerte-on">
		<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span> 3 alertes
	    </div>

	    ▶ intitulé de l'alerte
	</nav>

	<div class="container-fluid">
	    <div class="row">
		<div class="col-md-12">
		    <h2>Intitulé module</h2>
		    <div class="inner">
			test
		    </div>
		</div>

		<div class="col-md-6">
		    <h4>Sous-partie</h4>
		    <div class="inner">
			test
		    </div>
		</div>

		<div class="col-md-6">
		    <h4>Sous-partie</h4>
		    <div class="inner">
			test
		    </div>
		</div>

		<div class="col-md-6">
		    <h4>Sous-partie</h4>
		    <div class="col-md-6">
			<div class="inner">
			    Test
			</div>
		    </div>

		    <div class="col-md-6">
			<div class="inner">
			    Test
			</div>
		    </div>
		</div>
	    </div>
	</div>
	<script src="{{ asset('js/jquery-1.11.3.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/repository.js') }}"></script>
    </body>
</html>
