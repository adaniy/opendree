<!DOCTYPE html>

<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="year" content="{{ $year }}" />
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/override.css') }}" rel="stylesheet">
        <title>GDMC</title>
    </head>

    <body>
        <div class="dashboard">
            <div class="col-md-12 content">
                <div class="col-md-8">
                    <h3>Suivi mensuel des recettes</h3>
                    <div class="inner">
                        <div id="canvas-holder"><canvas id="chart-dashboard-year-1" /></div>
                    </div>
                </div>

                <div class="col-md-4">
                    <h3>Comparatifs des recettes sur l'année</h3>
                    <div class="inner">
                        <div id="canvas-holder"><canvas id="chart-dashboard-year-2" /></div>
                    </div>
                </div>

                <div class="col-md-12">
                    <h3>Statistique annuelle des recettes</h3>
                    <div class="inner">
                        @if($dashboardAmount->count() > 0)
                            <table class="table table-hover table-striped table-bordered table-dashboard">
                                <tr>
                                    <th class="col-md-11">Année</th>
                                    @for($x = 1; $x <= 12; $x++)
                                        <th>{{ $temps->parseMois($carbon->create($year, $x, 1)->month) }}</th>
                                    @endfor
                                </tr>
                                @foreach($dashboardCategories->orderBy('id')->get() as $categories)
                                    <tr>
                                        <td class="category">{{ $categories->name }}</td>
                                        @for($x = 1; $x <= 12; $x++)
                                            @if($categories->type == 'money')
                                                <td>{{ number_format($dashboardClass->getPluralityAmount($categories->id, 0, $x, 'month'), 2) }} €</td>
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
        <script src="{{ asset('js/jquery-1.11.3.min.js') }}" onload="$ = jQuery = module.exports;"></script>

        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/bootbox.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap-notify.min.js') }}"></script>
        <script src="{{ asset('js/repository.js') }}"></script>
        <script src="{{ asset('js/dashboard/index.js') }}"></script>
        <script src="{{ asset("js/Chart.bundle.min.js") }}"></script>
        <script src="{{ asset("js/chart/dashboard-year.js") }}"></script>
    </body>
</html>
