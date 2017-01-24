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
	    <div class="title">{{ $dashboardClass->getDate($year, $month) }}</div>
	    <div class="col-md-12">
		@foreach($dashboardCategories->get() as $categories)
		<div class="data col-md-3 amounts">
		    <div class="header">
			{{ $categories->name }}
		    </div>
		    <div class="middle">{{ $dashboardClass->getAmount($categories->id) }}</div>
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
				<div class="title">Cumul année précédente</div>
				<div class="value"->187,240.00 €</div>
			    </div>
			</div>
		    </div>
		</div>
		@endforeach
	    </div>

	    <div class="col-md-12">
		@foreach($service->get() as $services)
		<div class="data col-md-3 services">
		    <div class="header">{{ $services->name }}</div>

		    <div class="middle small">
			<li><span class="glyphicon glyphicon-user"></span> 48 agents</li>
			<li><span class="glyphicon glyphicon-calendar"></span> 6 jours de congés</li>
			<li><span class="glyphicon glyphicon-time"></span> 140 heures sup'</li>
		    </div>
		</div>
		@endforeach
	    </div>
	</div>
    </div>
@endsection
