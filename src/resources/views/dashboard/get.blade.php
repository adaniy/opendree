@extends('template')

@section('head')
    Tableau de bord / {{ $dashboardClass->getDate($year, $month) }}
@endsection

@section('meta')
    <meta name="date" content="{{ $dashboardClass->getDateRaw($year, $month) }}">
@endsection

@section('content')
    <div class="dashboard">
        @include('dashboard.menu')
        <div class="col-md-10 content">
            <div class="col-md-12">
                @foreach($service->get() as $services)
                    <button class="btn btn-xs all btn-primary" type="button" data-toggle="collapse" data-target="#collapse{{ $services->id }}" aria-expanded="false" aria-controls="collapse{{ $services->id }}">{{ $services->name }}</button>
                    <div class="collapse" id="collapse{{ $services->id }}">
                        @foreach($services->categories as $categories)
                            <div class="amounts" data-attribute="{{ $categories->id }}">
                                <div class="data">
                                    <div class="header">{{ $categories->name }}</div>
                                    <div class="middle edit-amount" data-amount="{{ $dashboardClass->getAmountRaw($categories->id, $dashboardClass->getIdMonth($year, $month)) }}" data-category="{{ $categories->id }}" data-dashboard="{{ $dashboardClass->getIdMonth($year, $month) }}">{{ $dashboardClass->getAmount($categories->id, $dashboardClass->getIdMonth($year, $month)) }}</div>
                                    <div class="footer" type="button" data-toggle="collapse" data-target="#collapse-{{ $categories->id }}" aria-expanded="false" aria-controls="collapse-{{ $categories->id }}">
                                        <span class="glyphicon glyphicon-option-horizontal show-more"></span>
                                        <div class="collapse" data-attribute="sous" id="collapse-{{ $categories->id }}">
                                            <div class="previous">
                                                <div class="title">Mois année précédente</div>
                                                @if($categories->type == "money")
                                                    <div class="value">{{ number_format($dashboardClass->getPluralityAmount($categories->id, $dashboardClass->getAmountRaw($categories->id, $dashboardClass->getIdMonth($year, $month)), $dashboardClass->getDateRaw($year, $month), 'month-last-year'), 2) }} €</div>

                                                @else
                                                    <div class="value">{{ $dashboardClass->getPluralityAmount($categories->id, $dashboardClass->getAmountRaw($categories->id, $dashboardClass->getIdMonth($year, $month)), $dashboardClass->getDateRaw($year, $month), 'month-last-year') }}</div>
                                                @endif
                                            </div>

                                            <div class="previous">
                                                <div class="title">Cumul année</div>
                                                @if($categories->type == "money")
                                                    <div class="value">{{ number_format($dashboardClass->getPluralityAmount($categories->id, $dashboardClass->getAmountRaw($categories->id, $dashboardClass->getIdMonth($year, $month)), $dashboardClass->getDateRaw($year, $month), 'year'), 2) }} €</div>
                                                @else
                                                    <div class="value">{{ $dashboardClass->getPluralityAmount($categories->id, $dashboardClass->getAmountRaw($categories->id, $dashboardClass->getIdMonth($year, $month)), $dashboardClass->getDateRaw($year, $month), 'year') }}</div>
                                                @endif
                                            </div>

                                            <div class="previous">
                                                <div class="title">Cumul année précédente</div>
                                                @if($categories->type == "money")
                                                    <div class="value">{{ number_format($dashboardClass->getPluralityAmount($categories->id, $dashboardClass->getAmountRaw($categories->id, $dashboardClass->getIdMonth($year, $month)), $dashboardClass->getDateRaw($year, $month), 'last-year'), 2) }} €</div>
                                                @else
                                                    <div class="value">{{ $dashboardClass->getPluralityAmount($categories->id, $dashboardClass->getAmountRaw($categories->id, $dashboardClass->getIdMonth($year, $month)), $dashboardClass->getDateRaw($year, $month), 'last-year') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
