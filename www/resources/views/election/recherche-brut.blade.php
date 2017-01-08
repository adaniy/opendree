@extends('template')

@section('back')
    <a href="{{ url('election/brut') }}"><span class="glyphicon glyphicon-arrow-left back" aria-hidden="true"></span></a>
@endsection

@section('contenu')
    <hr />
    <h3><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Recherche de données d'inscription</h3>
    <hr />
    @if($election->count() > 0)
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
    @else
        <b>Aucune donnée trouvée pour votre recherche.</b>
    @endif
@endsection