<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/printable.css') }}" rel="stylesheet" type="text/css" media="screen, print">

        <title>GDMC</title>
    </head>
    <body class="landscape">
        <a href="/reunion" class="no-print"><div class="wrap-return">
	    retour
        </div></a>
        <div class="wrap">
            <h3><p class="text-center"><strong>{{ $reunion->sujet }}</strong><br />
                <b>{{ $temps->parseDateTime2($reunion->date) }}</b></p></h3>
            <hr />

            <li><b>Date et heure :</b> {{ $temps->parseDateTime($reunion->date) }}</li>
            <li>
                <b>Présents :</b>
                @foreach($reunionParticipant2->where('type','absent')->get() as $participant)
                    @if($loop->first && $loop->count > 1 OR !$loop->last)
                        {{ $participant->nom }},
                    @elseif($loop->last)
                        {{ $participant->nom }}.
                    @else
                        {{ $participant->nom }}
                    @endif
                @endforeach
            </li>

            <li>
                <b>Absents :</b>
                @foreach($reunionParticipant->where('type','absent')->get() as $participant)
                    @if($loop->first && $loop->count > 1 OR !$loop->last)
                        {{ $participant->nom }},
                    @elseif($loop->last)
                        {{ $participant->nom }}.
                    @else
                        {{ $participant->nom }}
                    @endif
                @endforeach
            </li>

            <li>
                <b>Secrétaire de séance :</b>
                @foreach($reunionParticipant3->where('type','secretaire')->get() as $participant)
                    @if($loop->first && $loop->count > 1 OR !$loop->last)
                        {{ $participant->nom }},
                    @elseif($loop->last)
                        {{ $participant->nom }}.
                    @else
                        {{ $participant->nom }}
                    @endif
                @endforeach
            </li>

            <hr />

            @if($reunionSujet->count() > 0)
                <table class="table table-striped table-bordered table-hover">
                    <tr>
                        <th class="col-lg-2 col-sm-2">Sujet</th>
                        <th class="col-lg-5 col-sm-5">Observation</th>
                        <th class="col-lg-5 col-sm-5">Décisions - actions à effectuer</th>
                    </tr>
                    @foreach($reunionSujet as $reunionSujets)
                        <tr>
                            <td class="reunionSujetBold">{{ $reunionSujets->sujet }}</td>
                            <td class="reunionSujet">{!! nl2br(e($reunionSujets->observation)) !!}</td>
                            <td class="reunionSujet">{!! nl2br(e($reunionSujets->action)) !!}</td>
                        </tr>
                    @endforeach
                </table>
            @else
                <div id="decal"><b>Il n'y a pas encore de sujet discuté dans cette réunion.</b></div>
            @endif
            <br /><br />
            @if($reunion->date_prochain != null)
                <h3><p class="text-center">Prochaine réunion <b>"{{ $reunion->sujet }}"</b> : {{ $temps->parseDateTime($reunion->date_prochain) }}</p></h3>
            @endif
        </div>
        </div>
        <a href="#" onclick="window.print()" class="no-print"><div class="wrap-print">
	    imprimer
        </div></a>
        <script>

        </script>
    </body>
</html>
