@inject("actionClass", "App\Classes\ActionClass")
<?php 
    // 30 minutes = 1800 secondes
    // 1 heure = 3600 secondes
    // 2 heures = 7200 secondes
    $secondeInterval = 7200;
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="refresh" content="{{ $secondeInterval }}">
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
		<link href="{{ asset('css/override.css') }}" rel="stylesheet">

        <title>GDMC</title>
    </head>
    <body>
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container-fluid">
				<div id="navbar" class="navbar-collapse collapse">
					<a class="navbar-brand" href="{{ url('/') }}">GDMC</a>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="{{ url('election') }}">Élections</a></li>
						<li><a href="{{ url('reunion') }}">Réunions</a></li>
						<li><a href="{{ url('action') }}">Actions</a></li>
					</ul>
				</div>
			</div>
		</nav>
		@yield('back')
		<div class="container-fluid">
			<div class="row">
		    	@if(count($errors) > 0)
			    	<div class="bs-errors" data-example-id="dismissible-alert-css">
					    <div class="alert alert-warning alert-dismissible" role="alert">
					      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					      <strong>Attention : </strong><br />
					      @foreach ($errors->all() as $errorsGet)
							<li>{{ $errorsGet }}</li>
						  @endforeach
					    </div>
					</div>
				@endif

			    @if(session('valide'))
			   		<div class="bs-errors" data-example-id="dismissible-alert-css">
					    <div class="alert alert-success alert-dismissible" role="alert">
					      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					      <strong>Succès : </strong><br />
					      {{ session('valide') }}
					    </div>
					</div>
				@endif

				@if(session('erreur'))
					<div class="bs-errors" data-example-id="dismissible-alert-css">
					    <div class="alert alert-warning alert-dismissible" role="alert">
					      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					      <strong>Attention : </strong><br />
					      {{ session('erreur') }}
					    </div>
					</div>
				@endif

				{!! $actionClass->canAlert() !!}
				@yield('contenu')
			</div>
		</div>

		<script src="{{ asset('js/jquery-1.11.3.min.js') }}"></script>
		<script src="{{ asset('js/bootstrap.min.js') }}"></script>
    </body>
</html>



