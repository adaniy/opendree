@extends('template')

@section('contenu')
    <h3><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Liste des réunions</h3>
    <p id="decal" class="text-muted">Cliquez sur l'id d'une réunion pour y accéder.</p>
    <hr />
    <br />
    <div class="col-md-12">
        <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> <b>Recherche</b> 
        <p class="text-muted">N'importe quel champs peut être remplis pour effectuer une recherche. Ils seront tous pris en compte.</p>
        <form class="form-inline" action="{{ url('reunion') }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <input type="text" name="id" class="form-control" id="id" placeholder="N° réunion">
            </div>

            <div class="form-group">
                <input type="text" name="sujet" class="form-control" id="sujet" placeholder="Sujet de la réunion">
            </div>
            <div class="form-group">
                <input type="text" name="date" class="form-control" id="date" placeholder="Date de la réunion">
            </div>
            <button type="submit" class="btn btn-info">Rechercher</button>
        </form>
    </div>
    <br /><br /><br /><br />
    <hr />
    <div id="decal" class="pull-left"><a href="{{ url('reunion/ajout') }}" class="btn btn-sm btn-info">Créer une réunion</a></div>
    <div id="decal" class="pull-right">{!! $reunion->links() !!}</div>
    <br /><br />
    @if($reunion->count() > 0)
    <table class="table table-striped table-bordered table-hover">
    <tr>
        <th class="col-lg-1 col-sm-1">N°</th>
        <th class="col-lg-6 col-sm-6">Sujet</th>
        <th class="col-lg-1 col-sm-1">Nb participants</th>
        <th class="col-lg-2 col-sm-2">Date</th>
        <th class="col-lg-2 col-sm-2">Action</th>
    </tr>
    @foreach($reunion as $reunions)
        <tr>
            <td><a href="{{ url('reunion/'.$reunions->id) }}"><span class="glyphicon glyphicon-link"></span>{{ $reunions->id }}</a></td>
            <td class="sujet">{{ $reunions->sujet }}</td>
            <td>{{ $reunionClass->nbParticipant($reunions->id) }}</td>
            <td>{{ $temps->parseDateTime($reunions->date) }}</td>
            <td><a href="{{ url('reunion/modifier/'.$reunions->id) }}" class="btn btn-xs btn-success">Modifier</a> <a href="{{ url('reunion/supprimer/'.$reunions->id) }}" class="btn btn-xs btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réunion ?');">Supprimer</a></td>
        </tr>
    @endforeach
    </table>
    @else
        <hr />
        <div id="decal"><b>Il n'existe aucune réunion dans la base de donnée actuellement.</b></div>
    @endif
    <script>
        function reload() {
            location.reload();
        }
    </script>
@endsection