@extends('template')

@section('head')
    Tableau de bord / {{ $dashboardClass->getDate($year, $month) }}
@endsection

@section('meta')

@endsection

@section('content')
    <div class="dashboard">
	@include('dashboard.menu')
	<div class="col-md-10 content">
	    <div class="col-md-12">
		@foreach($dashboardCategories->get() as $categories)
		    <div class="col-md-3 amounts" data-attribute="{{ $categories->id }}">
			<div class="data">
			    <div class="header">{{ $categories->name }}</div>
			    <div class="middle edit-amount" data-amount="{{ $dashboardClass->getAmountRaw($categories->id, $year, $month) }}" data-category="{{ $categories->id }}" data-dashboard="{{ $dashboardClass->getIdMonth($year, $month) }}">{{ $dashboardClass->getAmount($categories->id, $year, $month) }}</div>
			    <div class="footer" type="button" data-toggle="collapse" data-target="#collapse-{{ str_slug($categories->name, '-') }}" aria-expanded="false" aria-controls="collapse-{{ str_slug($categories->name, '-') }}">
				<span class="glyphicon glyphicon-option-horizontal show-more"></span>
				<div class="collapse" id="collapse-{{ str_slug($categories->name, '-') }}">
				    <div class="previous">
					<div class="title">Mois année précédente</div>
					<div class="value">187,240.00 €</div>
				    </div>

				    <div class="previous">
					<div class="title">Cumul année</div>
					<div class="value">187,240.00 €</div>
				    </div>

				    <div class="previous">
					<div class="title">Cumul années précédentes</div>
					<div class="value">{{ $dashboardClass->getPluralityAmount($categories->id, $dashboardClass->getAmountRaw($categories->id, $year, $month), 'last-years') }}</div>
				    </div>
				</div>
			    </div>
			</div>
		    </div>
		@endforeach
	    </div>

	    <div class="col-md-12">
		@foreach($service->get() as $services)
		    <div class="col-md-3 services">
			<div class="data">
			    <div class="header">{{ $services->name }}</div>

			    <div class="middle small edit-amount-service" data-id="{{ $services->id }}" data-dashboard="{{ $dashboardClass->getIdMonth($year, $month) }}" data-service="{{ $services->name }}" data-agents="10" data-holidays="20" data-hours="30">
				<li><span class="glyphicon glyphicon-user"></span> 10 agents</li>
				<li><span class="glyphicon glyphicon-calendar"></span> 6 jours de congés</li>
				<li><span class="glyphicon glyphicon-time"></span> 140 heures sup'</li>
			    </div>
			</div>
		    </div>
		@endforeach
	    </div>
	</div>
    </div>
@endsection
