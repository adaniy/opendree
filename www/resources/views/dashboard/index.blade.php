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
            @foreach($service->get() as $services)
                <div class="col-md-12">
                    <div class="pull-right"><button href="{{ url('dashboard/service/'.$services->id) }}" class="btn btn-xs btn-primary live"><span class="glyphicon glyphicon-print"></span></button></div><h3>Statistique annuelle du service "{{ $services->name }}"</h3>
                    <div class="inner-table">
                        @if($dashboardAmount->count() > 0)
                            <table class="table table-hover table-striped">
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
            @endforeach
        </div>
    </div>
@endsection
