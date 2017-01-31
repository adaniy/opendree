@extends('template')

@section('head')
    Tableau de bord / Année {{ $year }} / <button class="btn btn-xs btn-default live" href="{{ url('/dashboard/print/'.$year) }}">version imprimable</button>
@endsection

@section('meta')
    <meta name="year" content="{{ $year }}" />
@endsection

@section('content')
    <div class="dashboard">
        @include('dashboard.menu')
        <div class="col-md-10 content">
            <div class="col-md-8">
		<h3>Suivi mensuel des montants</h3>
		<div class="inner">
		    <button class="pull-right btn btn-xs btn-tree btn-default" id="update-amount-line"><span class="glyphicon glyphicon-refresh"></button>
		    <div id="canvas-holder"><canvas id="chart-dashboard-year-1" /></div>
		</div>
            </div>

	    <div class="col-md-4">
		<h3>Comparatifs des montants sur l'année</h3>
		<div class="inner">
		    <button class="pull-right btn btn-xs btn-tree btn-default" id="update-amount-pie"><span class="glyphicon glyphicon-refresh"></button>
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
@endsection
