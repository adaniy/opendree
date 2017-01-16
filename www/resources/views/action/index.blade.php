@extends('template')

@section('head')
    Actions planifiées
@endsection

@section('meta')

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
		<div class="pull-right"><button id="refresh" class="live"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button> <a href="{{ url('action') }}" class="button-link"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></div>
		<button id="add" class="live"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button>
	    </div>
	    <div class="action-list">
	    @foreach($action as $actions)
		<div class="list"><div class="pull-right"><button id="edit" class="live" data-attribute="{{ $actions->id }}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button></div><a href="{{ url('action/'.$actions->id) }}"><li @if($actionClass->canAlertBoolean($actions->id)) class="alerte" @endif>{{ $actions->nom }}</li></a></div>
	    @endforeach
	    </div>
	</div>
	<div class="droite col-md-9">
	    <div class="titre">
		tableau de bord des actions planifiées
	    </div>

	    <div class="col-md-4">
		<h3>Comparatif des actions</h3>
		<div class="inner">
		    <div id="canvas-holder"><canvas id="chart-action" /></div>
		</div>
	    </div>

	    <div class="col-md-8">
		<h3>Statistique annuelle des actions</h3>
		<div class="inner">
		    <div id="canvas-holder"><canvas id="chart-action2" /></div>
		</div>
	    </div>

	    <div class="col-md-12">
		<h3>Statistique globale des actions planifiées</h3>
		<div class="inner">
		    <table class="table table-hover table-striped table-bordered table-stats">
			<tr>
			    <th class="col-md-4">Catégorie</th>
			    <th class="col-md-8">Donnée</th>
			</tr>

			<tr>
			    <td class="categorie">Nombre d'actions réalisés</td>
			    <td class="value"><action-realise></action-realise></td>
			</tr>

			<tr>
			    <td class="categorie">Nombre d'actions non réalisés</td>
			    <td class="value"><action-non-realise></action-non-realise></td>
			</tr>

			<tr>
			    <td class="categorie">Total</td>
			    <td class="value"><action-total></action-total></td>
			</tr>
		    </table>
		</div>
	    </div>
	</div>
    </div>
@endsection
