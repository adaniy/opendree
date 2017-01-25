@extends('template')

@section('contenu')
    <div class="col-lg">
        <h3><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Aide</h3>
        <hr />
        <li class="text-muted">Les actions en rouge sont les actions générant une alerte.</li>
        <li class="text-muted">Les actions en vert sont les actions réalisée.</li>
        <li class="text-muted">Ce programme se rafraichis automatiquement toute les deux heures. Les alertes sont envoyées en même temps.</li>
        <hr />
        <h3><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Liste des actions planifiées</h3>
        <hr />
        <div id="decal"><div class="pull-left"><a class="btn btn-sm btn-info" href="{{ url('action/ajout') }}">Ajouter une action</a></div></div>
        <br /><br />
        @if($action->count() > 0)
        <table class="table table-striped table-hover table-bordered">
            <tr>
                <th class="col-lg-6 col-sm-3">Nom</th>
                <th class="col-lg-1 col-sm-2">Date de création</th>
                <th class="col-lg-1 col-sm-2">Date de réalisation</th>
                <th class="col-lg-1 col-sm-2">Date butoire</th>
                <th class="col-lg-1 col-sm-1">Jours restant</th>
                <th class="col-lg-2 col-sm-4">Action</th>
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
                    <a class="btn btn-xs btn-success" href="{{ url('action/modifier/'.$actions->id) }}">Modifier</a>
                    <a class="btn btn-xs btn-danger" href="{{ url('action/supprimer/'.$actions->id) }}" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette action ?');">Supprimer</a>
                        </td>
                    </tr>
                @endforeach
        </table>
        <hr />
        @else
            <div id="decal"><b>Il n'existe aucune action dans la base de donnée actuellement.</b></div>
            <hr />
        @endif
    </div>
@endsection
