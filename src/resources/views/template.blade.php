@inject("actionClass", "App\Classes\ActionClass")
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/override.css') }}" rel="stylesheet">
        <title>GDMC</title>

	@yield('meta')
    </head>
    <body>
	<nav class="head col-md-12 col-xs-12">
	    <div class="content col-md-11 col-xs-10">
		GDMC / @yield('head')
	    </div>

	    <div class="menu col-md-1 col-xs-2">
		<button class="module"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span></button>
		<div class="deploy">
		    <div class="titre">Modules</div>
		    <a href="{{ url('election') }}"><ul>▶ election</ul></a>
		    <a href="{{ url('reunion') }}"><ul>▶ reunion</ul></a>
		    <a href="{{ url('action') }}"><ul>▶ action</ul></a>
		    <a href="{{ url('budget') }}"><ul>▶ budget</ul></a>
		    <a href="{{ url('planning') }}"><ul>▶ planning</ul></a>
		</div>
	    </div>
	</nav>

	<div class="container-fluid">
	    <div class="row">
		@if(count($errors) > 0)
		    <div class="bs-errors" data-example-id="dismissible-alert-css">
			<div class="alert alert-warning alert-dismissible" role="alert">
&			    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
		
		@yield('content')
	    </div>
	</div>

	<script src="{{ asset('js/jquery-1.11.3.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/bootbox.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap-notify.min.js') }}"></script>
	<script src="{{ asset('js/repository.js') }}"></script>

	{{-- on ne permet le chargement des fonctions JS des statistiques uniquement dans la page concernée --}}
	@if(Request::segment(1) == "action")
	    <script src="{{ asset("js/Chart.bundle.min.js") }}"></script>
	    <script src="{{ asset("js/chart/utils.js") }}"></script>
	    <script src="{{ asset("js/chart/action.js") }}"></script>
	@endif

	{{-- on ne permet le chargement des fonctions JS des budgets uniquement dans la page concernée --}}
	@if(Request::segment(1) == "budget")
	    <script src="{{ asset("js/budget/gestion.js") }}"></script>
	    <script src="{{ asset("js/budget/board.js") }}"></script>
	@endif

	{{-- on ne permet le chargement des fonctions JS des budgets uniquement dans la page concernée --}}
	@if(Request::segment(1) == "dashboard")
	    <script src="{{ asset("js/dashboard/index.js") }}"></script>
	@endif
    </body>
</html>



