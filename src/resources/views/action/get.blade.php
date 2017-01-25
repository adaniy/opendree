@extends('template')

@section('head')
    Actions planifiées
@endsection

@section('meta')
    <meta name="id" content="{{ $id }}">
@endsection

@section('content')
    <div class="action">
	@include('action.list')

	<div class="droite col-md-9">
	    <div class="titre">
		{{ $actionCurrent->nom }}
	    </div>

	    <div class="col-md-3">
		<h4>Date de création<div class="pull-right"><button id="edit-date-creation" class="live"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button></div></h4>
		<div class="inner action-info action-date-creation">{{ $actionClass->date($actionCurrent->date_creation) }}</div>
	    </div>

	    <div class="col-md-3">
		<h4>Date de réalisation<div class="pull-right"><button id="edit-date-realisation" class="live"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button></div></h4>
		<div class="inner action-info action-date-realisation">{{ $actionClass->date($actionCurrent->date_realisation) }}</div>
	    </div>

	    <div class="col-md-3">
		<h4>Date butoir<div class="pull-right"><button id="edit-date-butoir" class="live"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button></div></h4>
		<div class="inner action-info action-date-butoir">{{ $actionClass->date($actionCurrent->date_butoir) }}</div>
	    </div>

	    <div class="col-md-3">
		<h4>Jours restant</h4>
		<div class="inner action-info action-jour-restant">{{ $actionClass->diff($actionCurrent->date_butoir) }}</div>
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
		    <div class="pull-left">{!! $actionClass->alertButton($id) !!}</div>

		    <div class="pull-right">
			<a href="{{ url('action/delete/'.$id) }}" onclick="return confirm('Confirmez-vous la suppression de cette action ?')" class="btn btn-md btn-danger">Supprimer</a>
		    </div>
		</div>
	    </div>
	</div>
    </div>
@endsection
