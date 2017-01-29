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
            <div class="col-md-12">
		<h3>Statistiques de l'année</h3>
		<div class="inner">
		    <div id="canvas-holder"><canvas id="chart-dashboard-year-1" /></div>
		</div>
            </div>

            <div class="col-md-12">
                <h3>Calendrier des congés</h3>
                @foreach($service->get() as $services)
                    <div class="col-md-12 inner">
                        <div class="category" role="tab" id="heading{{ $services->id }}" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $services->id }}" aria-expanded="false" aria-controls="collapse{{ $services->id }}"><span class="glyphicon glyphicon-chevron-right"></span> {{ $services->name }}</div>
                        <div id="collapse{{ $services->id }}" class="collapse" role="tabpanel" aria-labelledby="heading{{ $services->id }}">
                            <table class="table table-bordered table-hover table-holiday">
                                <tr>
                                    <th class="col-md-12">Date</th>
                                    {{-- Doit être synchronisé avec le foreach() des <td> --}}
                                    @foreach($dashboardAgent->orderBy('id', 'ASC')->where('service_id', $services->id)->get() as $agents)
                                        <th class="agent"><div data-toggle="tooltip" data-placement="bottom" title="{{ $agents->name }}">{{ $agents->id }}</div></th>
                                    @endforeach
                                </tr>
                                @foreach($dashboardClass->holidayCalendar($year, 1) as $calendar)
                                    <tr>
                                        <td>{{ $dashboardClass->temps->parseJour($carbon->parse($calendar)->dayOfWeek) }} {{ $carbon->parse($calendar)->day }} {{ $dashboardClass->temps->parseMois($carbon->parse($calendar)->month) }}</td>
                                        {{-- Doit être synchronisé avec le foreach() des <th> --}}
                                        @foreach($dashboardAgent->orderBy('id', 'ASC')->where('service_id', $services->id)->get() as $agents)
                                            @if($dashboardClass->isInHoliday($agents->id, $carbon->parse($calendar)))
                                                <td class="valide" data-attribute="{{ $dashboardClass->isInHolidayId($agents->id, $carbon->parse($calendar)) }}" data-container="body" data-toggle="popover" data-placement="left" title="{{ $agents->name }}" data-content="En congé du {{ $dashboardClass->temps->parseJour($carbon->parse($dashboardClass->isInHolidayDates($agents->id, $carbon->parse($calendar))['debut'])->dayOfWeek) }} {{ $carbon->parse($dashboardClass->isInHolidayDates($agents->id, $carbon->parse($calendar))['debut'])->day }} {{ $dashboardClass->temps->parseMois($carbon->parse($dashboardClass->isInHolidayDates($agents->id, $carbon->parse($calendar))['debut'])->month) }} (inclu) au {{ $dashboardClass->temps->parseJour($carbon->parse($dashboardClass->isInHolidayDates($agents->id, $carbon->parse($calendar))['fin'])->dayOfWeek) }} {{ $carbon->parse($dashboardClass->isInHolidayDates($agents->id, $carbon->parse($calendar))['fin'])->day }} {{ $dashboardClass->temps->parseMois($carbon->parse($dashboardClass->isInHolidayDates($agents->id, $carbon->parse($calendar))['fin'])->month) }} (non inclu)." data-trigger="hover">&nbsp;</td>
                                            @else
                                                <td>&nbsp;</td>
                                            @endif
                                        @endforeach
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
