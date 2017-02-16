@extends('template')

@section('head')
    Tableau de bord
@endsection

@section('meta')

@endsection

@section('content')
    <div class="dashboard">
        @include('dashboard.menu')

        <div class="col-md-10 content">
            <div class="col-md-8">
                <h3>Suivi annuel</h3>
                <div class="inner">
                    <button class="pull-right btn btn-xs btn-tree btn-default" id="update-amount-line"><span class="glyphicon glyphicon-refresh"></button>
                        <div id="canvas-holder"><canvas id="chart-dashboard-1" /></div>

                </div>
            </div>

            <div class="col-md-4">
                <h3>Comparatif depuis le début des temps</h3>
                <div class="inner">
                    <button class="pull-right btn btn-xs btn-tree btn-default" id="update-amount-pie"><span class="glyphicon glyphicon-refresh"></button>
                        <div id="canvas-holder"><canvas id="chart-dashboard-2" /></div>
                </div>
            </div>

            <div class="col-md-12">
                <h3>Statistique annuel</h3>
                <div class="inner-table">
                    @if($dashboardAmount->count() > 0)
                        <table class="table table-hover table-striped">
                            <tr class="header">
                                <th>Année</th>
                                @foreach($dashboardAmount->orderBy('date', 'ASC')->groupBy(DB::raw('date(date, "start of year")'))->get() as $amounts)
                                    <th>{{ $carbon->parse($amounts->date)->year }}</th>
                                @endforeach
                            </tr>
                            @foreach($dashboardCategories->orderBy('id')->get() as $categories)
                                <tr>
                                    <td>{{ $categories->name }}</td>
                                    @foreach($dashboardAmount->orderBy('date', 'ASC')->groupBy(DB::raw('date(date, "start of year")'))->get() as $amounts)
                                        @if($categories->type == 'money')
                                            <td>{{ number_format($dashboardClass->getPluralityAmount($categories->id, 0, $amounts->date, 'year'), 2) }} €</td>
                                        @else
                                            <td>{{ $dashboardClass->getPluralityAmount($categories->id, 0, $amounts->date, 'year') }}</td>
                                        @endif
                                    @endforeach
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
@endsection
