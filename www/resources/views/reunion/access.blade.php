@extends('template')

@section('back')
    <a href="{{ url('reunion') }}"><span class="glyphicon glyphicon-arrow-left back" aria-hidden="true"></span></a>
@endsection

@section('contenu')
    <h3><p class="text-center">Réunion <b>"{{ $reunion->sujet }}"</b> du {{ $temps->parseDateTime2($reunion->date) }}</p></h3>
    <hr />

    <li><b>Date et heure :</b> {{ $temps->parseDateTime($reunion->date) }}</li>
    <li>
    <b>Présents :</b> 
    @foreach($reunionParticipant->where('type','present')->get() as $participant) 
        {{ $participant->nom }} <a href="{{ url('reunion/participant/supprimer/'.$participant->id) }}"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>&nbsp;
    @endforeach
    </li>
    <li>
    <b>Absents excusés :</b> 
    @foreach($reunionParticipant2->where('type','absent')->get() as $participant) 
        {{ $participant->nom }} <a href="{{ url('reunion/participant/supprimer/'.$participant->id) }}"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>&nbsp;
    @endforeach
    </li>
    <li>
    <b>Secrétaire de séance :</b> 
    @foreach($reunionParticipant3->where('type','secretaire')->get() as $participant) 
        {{ $participant->nom }} <a href="{{ url('reunion/participant/supprimer/'.$participant->id) }}"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>&nbsp;
    @endforeach
    </li>
    <br />
    <div id="decal"><button class="btn btn-xs btn-warning" type="button" data-toggle="collapse" data-target="#collapseParticipant" aria-expanded="false" aria-controls="collapseParticipant">Insérer participant</button></div>
    <div class="collapse" id="collapseParticipant">
        <form id="decal" action="{{ url('reunion/'.$id) }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="col-md-6">
                <div class="form-group">
                        <label for="nom">Nom du participant</label>
                        <input type="text" name="nom" class="form-control" value="{{ old('nom') }}" placeholder="Nom du participant" />
                </div>
                <input type="submit" class="btn btn-success" value="Ajouter" />
            </div>

            <div class="col-md-6">
                <label for="nom">Type de participant</label>
                <div class="radio">
                    <label>
                        <input type="radio" name="type" id="type" value="present" checked>
                         Présent
                    </label>
                </div>

                <div class="radio">
                    <label>
                        <input type="radio" name="type" id="type" value="absent">
                         Absent excusé
                    </label>
                </div>

                <div class="radio">
                    <label>
                        <input type="radio" name="type" id="type" value="secretaire">
                         Secrétaire
                    </label>
                </div>
                </div> 
                <br /><br /><br /><br /><br /> 
    </div>
        </form>
    <hr />

    <div id="decal" class="pull-left"><a href="{{ url('reunion/ajout/sujet/'.$reunion->id) }}" class="btn btn-sm btn-info">Ajouter un sujet</a></div>
    <br /><br />

    @if($reunionSujet->count() > 0)
    <table class="table table-striped table-bordered table-hover">
    <tr>
        <th class="col-lg-2 col-sm-2">Sujet</th>
        <th class="col-lg-4 col-sm-4">Observation</th>
        <th class="col-lg-4 col-sm-3">Décisions - actions à effectuer</th>
        <th class="col-lg-2 col-sm-3">Action</th>
    </tr>
    @foreach($reunionSujet as $reunionSujets)
        <tr>
            <td class="reunionSujetBold">{{ $reunionSujets->sujet }}</td>
            <td class="reunionSujet">{!! nl2br($reunionSujets->observation) !!}</td>
            <td class="reunionSujet">{!! nl2br($reunionSujets->action) !!}</td>
            <td><a href="{{ url('reunion/modifier/sujet/'.$reunionSujets->id) }}" class="btn btn-sm btn-success">Modifier</a> <a href="{{ url('reunion/supprimer/sujet/'.$reunionSujets->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce sujet ?');">Supprimer</a></td>
        </tr>
    @endforeach
    </table>
    @else
        <div id="decal"><b>Il n'y a pas encore de sujet discuté dans cette réunion.</b></div>
    @endif
    <br /><br />
    @if(!empty($reunion->date_prochain))
    <h3><p class="text-center">Prochaine réunion <b>"{{ $reunion->sujet }}"</b> : {{ $temps->parseDateTime($reunion->date_prochain) }}</p></h3>
    @endif
    <p class="text-center"><a href="{{ url('reunion/print/'.$id) }}">> Version imprimable <</a></p>
@endsection