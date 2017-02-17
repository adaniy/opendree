<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="year" content="{{ $year }}">
        <meta name="service" content="{{ $id }}">
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/printable.css') }}" rel="stylesheet" type="text/css" media="screen, print">

        <title>OpenDREE</title>
    </head>
    <body class="landscape">
        <a href="/dashboard" class="no-print"><div class="wrap-return">
            retour
        </div></a>

        <div class="wrap">
            <div class="col-md-12">
            </div><h3>Statistique annuelle du service "{{ $services->name }}"</h3>
            <div class="inner-table">
                @if($dashboardAmount->count() > 0)
                    <table class="table table-hover table-striped table-bordered">
                        <tr class="header">
                            <th>Catégorie</th>
                            @for($x = 1; $x <= 12; $x++)
                                <th>{{ $temps->parseMois($carbon->create($year, $x, 1)->month) }}</th>
                            @endfor
                        </tr>
                        @foreach($services->categories as $categories)
                            <tr>
                                <td class="header">{{ $categories->name }}</td>
                                @for($x = 1; $x <= 12; $x++)
                                    @if($categories->type == 'money')
                                        <td>{{ number_format($dashboardClass->getPluralityAmount($categories->id, 0, $carbon->create($year, $x, 1), 'month'), 2) }} €</td>
                                    @else
                                        <td>{{ $dashboardClass->getPluralityAmount($categories->id, 0, $carbon->create($year, $x, 1), 'month') }}</td>
                                    @endif
                                @endfor
                            </tr>
                        @endforeach
                        </tr>
                    </table>
                @else
                    <b>Il n'y a pas de données à afficher.</b>
                @endif
            </div>
        </div>
        </div>
        </div>

        <a href="#" onclick="window.print()" class="no-print"><div class="wrap-print">
            imprimer
        </div></a>

        <script src="{{ asset('js/jquery-1.11.3.min.js') }}"></script>
        <script src="{{ asset("js/Chart.bundle.min.js") }}"></script>
        <script src="{{ asset("js/chart/dashboard-service-year.js") }}"></script>
    </body>
</html>
