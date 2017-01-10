@extends('template')

@section('contenu')
    <div class="col-md-8">
	<h2>Actions planifiées</h2>
	@if($action->count() > 0)
	    <table class="table table-striped table-hover table-bordered">
		<tr>
                    <th class="col-lg-6 col-sm-3">Nom</th>
                    <th class="col-lg-1 col-sm-2">Date de création</th>
                    <th class="col-lg-1 col-sm-2">Date de réalisation</th>
                    <th class="col-lg-1 col-sm-2">Date butoire</th>
                    <th class="col-lg-1 col-sm-1">Jours restant</th>
                    <th class="col-lg-1 col-sm-2">Action</th>
		</tr>

		@foreach($action as $actions)
                    @if($actionClass->canAlertBoolean($actions->id) == 1)
			<tr class="danger">
                    @elseif($actions->realise == 1)
                            <tr class="success">
                    @else
				<tr>                    
                    @endif
                    <td class="nom">{{ $actions->nom }}</td>
                    <td>{{ $temps->parseDate($actions->date_creation) }}</td>
                    @if(!empty($actions->date_realisation))
			<td>{{ $temps->parseDate($actions->date_realisation) }}</td>
                    @else
			<td>N/A</td>
                    @endif
                    <td>{{ $temps->parseDate($actions->date_butoire) }}</td>
                    @if($actions->realise == 1)
			<td>FAIT</td>
                    @else
			@if($carbon->createFromFormat('d/m/Y', $actions->date_butoire) < $carbon->now())
                            <td>DÉPASSÉ</td>
			@else
                            <td>{{ $actionClass->diffDays($actions->date_butoire) }} jours</td>
			@endif
                    @endif
                    <td>
			<a class="btn btn-xs btn-success" href="{{ url('action/modifier/'.$actions->id) }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a><a class="btn btn-xs btn-danger" href="{{ url('action/supprimer/'.$actions->id) }}" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette action ?');"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                    </td>
				</tr>
		@endforeach
	    </table>
	
	    <div class="collapse table-add" id="collapseForm">
		<form class="action-form" method="POST" action="{{ url('action/ajout') }}">
		    <input type="hidden" name="_token" value="{{ csrf_token() }}">
		    <div class="form-group">
			<input type="text" name="nom" class="form-control" placeholder="Nom de la nouvelle action">
		    </div>
		    <div class="form-group">
			<input type="text" name="date_creation" class="form-control" placeholder="Date de création">
		    </div>
		    <div class="form-group">
			<input type="text" name="date_realisation" class="form-control" placeholder="Date de réalisation">
		    </div>

		    <div class="form-group">
			<input type="text" name="date_butoire" class="form-control" placeholder="Date butoire">
		    </div>
		    <div class="form-group">
			<input type="text" name="alertStart" class="form-control" placeholder="Jours restant pour commencer l'alerte">
		    </div>
		    <div class="pull-right">
			<input type="submit" class="btn btn-sm btn-info" value="Valider">
		    </div>
		    <div class="checkbox">
			<label>
			    <input type="checkbox" name="realise"> Réalisé
			</label>
			
			<label>
			    <input type="checkbox" name="alert"> Alerter
			</label>
		</div>
	    </form>
	    </div>
	@else
            <div class="col-md-8">
		<h2>Actions planifiées</h2>
		<div class="inner">
		    Il n'existe aucune action dans la base de donnée actuellement.
		</div>
	    </div>
        @endif
	<button class="deploy-table-add" type="button" data-toggle="collapse" data-target="#collapseForm" aria-expanded="false" aria-controls="collapseForm">Nouvelle action</button>

    </div>

    <div class="col-md-4">
	<h2>Aide</h2>
	<div class="inner">
	    <li>▶ Les actions en rouge sont les actions générant une alerte.</li>
	    <li>▶ Les actions en vert sont les actions réalisée.</li>
	</div>
    </div>
@endsection
