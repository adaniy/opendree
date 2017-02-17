<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
            <div class="col-md-12 text-center">
                <div class="col-md-6 col-md-offset-3">
                    <h3>Suivi annuel</h3>
                    <div class="inner">
                        <div id="canvas-holder"><canvas id="chart-dashboard-service" /></div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <h3>Statistique annuelle du service "{{ $services->name }}"</h3>
                <div class="inner-table">
                    @if($dashboardAmount->count() > 0)
                        <table class="table table-striped table-bordered">
                            <tr class="header">
                                <th>Catégorie</th>
                                @foreach($dashboardAmount->orderBy('date', 'ASC')->groupBy(DB::raw('date(date, "start of year")'))->get() as $amounts)
                                    <th>{{ $carbon->parse($amounts->date)->year }}</th>
                                @endforeach
                                <th>Total</th>
                            </tr>
                            @foreach($services->categories as $categories)
                                <tr>
                                    <td class="header">{{ $categories->name }}</td>
                                    @foreach($dashboardAmount->orderBy('date', 'ASC')->groupBy(DB::raw('date(date, "start of year")'))->get() as $amounts)
                                        @if($categories->type == 'money')
                                            <td>{{ number_format($dashboardClass->getPluralityAmount($categories->id, 0, $amounts->date, 'year'), 2) }} €</td>
                                        @else
                                            <td>{{ $dashboardClass->getPluralityAmount($categories->id, 0, $amounts->date, 'year') }}</td>
                                        @endif
                                    @endforeach
                                    @if($categories->type == 'money')
                                        <td>{{ number_format($dashboardClass->getPluralityAmount($categories->id, 0, $amounts->date, 'all-time'), 2) }} €</td>
                                    @else
                                        <td>{{ $dashboardClass->getPluralityAmount($categories->id, 0, $amounts->date, 'all-time') }}</td>
                                    @endif
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

        <a href="#" onclick="window.print()" class="no-print"><div class="wrap-print">
            imprimer
        </div></a>

        <script src="{{ asset('js/jquery-1.11.3.min.js') }}"></script>
        <script src="{{ asset("js/Chart.bundle.min.js") }}"></script>
        <script src="{{ asset("js/chart/dashboard-service.js") }}"></script>
    </body>
</html>
