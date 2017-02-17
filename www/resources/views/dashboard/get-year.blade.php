@extends('template')

@section('head')
    Tableau de bord / Année {{ $year }}
@endsection

@section('meta')
    <meta name="year" content="{{ $year }}" />
@endsection

@section('content')
    <div class="dashboard">
        @include('dashboard.menu')
        <div class="col-md-10 content">
            @foreach($service->get() as $services)
                <div class="col-md-12">
                    <div class="pull-right"><button href="{{ url('dashboard/service/year/'.$year.'/'.$services->id) }}" class="btn btn-xs btn-primary live"><span class="glyphicon glyphicon-print"></span></button></div><h3>Statistique annuelle du service "{{ $services->name }}"</h3>
                    <div class="inner-table">
                        @if($dashboardAmount->count() > 0)
                            <table class="table table-hover table-striped">
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
            @endforeach
        </div>
    </div>
@endsection
