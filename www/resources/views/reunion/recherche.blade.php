@extends('template')

@section('back')
    <a href="{{ url('reunion') }}"><span class="glyphicon glyphicon-arrow-left back" aria-hidden="true"></span></a>
@endsection

@section('contenu')
    <h3><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Résultat de votre recherche</h3>
    <p id="decal" class="text-muted">Cliquez sur l'id d'une réunion pour y accéder.</p>
    <hr />
    @if($reunion->count() > 0)
    <table class="table table-striped table-bordered table-hover">
    <tr>
        <th class="col-lg-1 col-sm-1">N°</th>
        <th class="col-lg-8 col-sm-8">Sujet</th>
        <th class="col-lg-1 col-sm-1">Nb participants</th>
        <th class="col-lg-2 col-sm-2">Date</th>
    </tr>
    @foreach($reunion as $reunions)
        <tr>
            <td><a href="{{ url('reunion/'.$reunions->id) }}"><span class="glyphicon glyphicon-link"></span>{{ $reunions->id }}</a></td>
            <td class="sujet">{{ $reunions->sujet }}</td>
            <td>{{ $reunionClass->nbParticipant($reunions->id) }}</td>
            <td>{{ $temps->parseDateTime($reunions->date) }}</td>
        </tr>
    @endforeach
    </table>
    @else
        <hr />
        <div id="decal"><b>Aucun résultat ne sort de votre recherche.</b></div>
    @endif
    <script>
        function reload() {
            location.reload();
        }
    </script>
@endsection