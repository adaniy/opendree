@extends('template')

@section('head')
    Actions planifiées
@endsection

@section('meta')
    <meta name="id" content="{{ $id }}">
@endsection

@section('content')
    <div class="action">
	<div class="gauche col-md-3">
	    <div class="search">
		<form>
		    <div class="form-group">
			<input type="text" name="search" class="live-search form-control" placeholder="Recherche ...">
		    </div>
		</form>
	    </div>

	    <div class="action-new">
		<div class="pull-right"><button id="refresh" class="live"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button></div>
		<button id="add" class="live"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button>
	    </div>

	    @foreach($action as $actions)
		<div class="list"><div class="pull-right"><button id="edit" class="live" data-attribute="{{ $actions->id }}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></button></div><a href="{{ url('action/'.$actions->id) }}"><li>{{ $actions->nom }}</li></a></div>
	    @endforeach
	</div>

	<div class="droite col-md-9">
	    <div class="titre">
		{{ $actionCurrent->nom }}
	    </div>

	    <div class="col-md-3">
		<h4>Date de création<div class="pull-right"><button id="edit-date-creation" class="live"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button></div></h4>
		<div class="inner action-info action-date-creation">{{ $actionClass->date($actionCurrent->date_creation) }}</div>
	    </div>

	    <div class="col-md-3">
		<h4>Date de réalisation<div class="pull-right"><a href="#"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></div></h4>
		<div class="inner action-info">
		    {{ $actionClass->date($actionCurrent->date_realisation) }}
		</div>
	    </div>

	    <div class="col-md-3">
		<h4>Date butoire<div class="pull-right"><a href="#"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></div></h4>
		<div class="inner action-info">
		    {{ $actionClass->date($actionCurrent->date_butoire) }}
		</div>
	    </div>

	    <div class="col-md-3">
		<h4>Jours restant<div class="pull-right"><a href="#"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></div></h4>
		<div class="inner action-info">
		    {{ $actionClass->diff($actionCurrent->alertStart) }}
		</div>
	    </div>

	    <div class="col-md-12">
		<h4>Description<div class="pull-right"><button id="edit-description" class="live"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button></div></h4>
		    <div class="inner">
			<div class="description">{!! $actionClass->description($actionCurrent->description) !!}</div>
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
