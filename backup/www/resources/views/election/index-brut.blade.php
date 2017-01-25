@extends('template')

@section('back')
    <a href="{{ url('election') }}"><span class="glyphicon glyphicon-arrow-left back" aria-hidden="true"></span></a>
@endsection

@section('contenu')
    <hr />
    <div class="col-md-12">
        <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> <b>Recherche</b> 
        <form class="form-inline" action="{{ url('election/brut') }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <input type="text" name="type" class="form-control" id="type" placeholder="Type de donnée">
            </div>

            <div class="form-group">
                <input type="text" name="date" class="form-control" id="date" placeholder="Date des données">
            </div>
            <button type="submit" class="btn btn-info">Rechercher</button>
        </form>
    </div>
    <br /><br /><br /><br />
    <hr />
    <h3><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Liste des données d'inscriptions en brute</h3>
    <hr />
    <div id="decal" class="pull-right">{{ $election->links() }}</div>
    <table class="table table-striped table-hover table-bordered">
        <tr>
            <th class="col-md-3">Type</th>
            <th class="col-md-5">Nombre</th>
            <th class="col-md-2">Date</th>
            <th class="col-md-2">Action</th>
        </tr>
        @foreach($election as $elections)
        <tr>
            <td>{{ $elections->type }}</td>
            <td>{{ $elections->nb }}</td>
            <td>{{ $elections->date }}</td>
            <td><a class="btn btn-xs btn-danger" href="{{ url('election/brut/supprimer/'.$elections->id) }}" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette inscription ?');">Supprimer</a></td>
        </tr>
        @endforeach
    </table>
@endsection