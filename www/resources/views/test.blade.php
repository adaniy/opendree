@extends('template')

@section('head')
    Actions planifiées
@endsection

@section('content')
    <div class="action">
	<div class="gauche col-md-3">
	    <div class="search">
		<form method="POST" action="{{ url('') }}">
		    <div class="form-group">
			<input type="text" name="search" class="form-control" placeholder="Recherche ...">
		    </div>
		</form>
	    </div>

	    <div class="list">
		<div class="pull-right"><a href="bleble"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></div><a href="#"><li>Faire truc et truc</li></a>
		<div class="pull-right"><a href="bleble"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></div><a href="#"><li class="active disabled">Action active</li></a>
		<div class="pull-right"><a href="bleble"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></div><a href="#"><li class="alerte">Action provoquant une alerte</li></a>
		<div class="pull-right"><a href="bleble"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></div><a href="#"><li>Faire truc et truc</li></a>
		<div class="pull-right"><a href="bleble"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></div><a href="#"><li>Lorem ipsum dolor sit amet</li></a>
		<div class="pull-right"><a href="bleble"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></div><a href="#"><li>Lorem ipsum dolor sit amet</li></a>
		<div class="pull-right"><a href="bleble"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></div><a href="#"><li>Lorem ipsum dolor sit amet</li></a>
		<div class="pull-right"><a href="bleble"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></div><a href="#"><li>Lorem ipsum dolor sit amet</li></a>
		<div class="pull-right"><a href="bleble"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></div><a href="#"><li>Lorem ipsum dolor sit amet</li></a>
		<div class="pull-right"><a href="bleble"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></div><a href="#"><li>Lorem ipsum dolor sit amet</li></a>
		<div class="pull-right"><a href="bleble"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></div><a href="#"><li>Lorem ipsum dolor sit amet</li></a>
	    </div>
	</div>

	<div class="droite col-md-9">
	    <div class="titre">
		Faire truc et truc
	    </div>

	    <div class="col-md-3">
		<h4>Date de création<div class="pull-right"><a href="#"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></div></h4>
		<div class="inner action-info">
		    10/10/2016
		</div>
	    </div>

	    <div class="col-md-3">
		<h4>Date de réalisation<div class="pull-right"><a href="#"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></div></h4>
		<div class="inner action-info">
		    10/10/2016
		</div>
	    </div>

	    <div class="col-md-3">
		<h4>Date butoire<div class="pull-right"><a href="#"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></div></h4>
		<div class="inner action-info">
		    10/10/2016
		</div>
	    </div>

	    <div class="col-md-3">
		<h4>Jours restant<div class="pull-right"><a href="#"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></div></h4>
		<div class="inner action-info">
		    18 jours
		</div>
	    </div>

	    <div class="col-md-12">
		<div class="col-md-12">
		    <br />
		    <div class="pull-left">
			<a href="#" class="btn btn-md btn-success">recevoir une alerte</a> <a href="#" class="btn btn-md btn-danger">ne pas recevoir d'alertes</a>
		    </div>

		    <div class="pull-right">
			<a href="#" class="btn btn-md btn-danger">Supprimer</a>
		    </div>
		</div>
	    </div>
	</div>
    </div>
@endsection
