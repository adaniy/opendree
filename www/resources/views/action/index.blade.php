@extends('template')

@section('head')
    Actions planifiées
@endsection

@section('meta')

@endsection

@section('content')
    <div class="action">
        @include('action.list')

        <div class="droite col-md-9">
            <div class="titre">
                actions planifiées
            </div>

            <div class="col-md-12">
                <div class="text-muted">
		    Ce module sert à gérer les actions planifiées lors des réunions. Une alerte sera transmise toute les deux heures sous forme d'alerte javascript, si une action arrive à date butoir ( < 30 jours de la date butoir ) et que l'alerte est activée pour celle-ci.
                </div>
            </div>
        </div>
    </div>
@endsection
