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
	    <div class="pull-right"><div class="date">janvier 2017</div></div>
	    <div class="title">Direction de la Règlementation et du domaine Public</div>

	    <div class="data col-md-3">
		<div class="header">
		    <div class="pull-right"><span class="glyphicon glyphicon-pencil"></span></div>
		    Autorisations de voirie
		</div>
		<div class="middle">173,560.45 €</div>
		<div class="footer">
		    <button class="btn btn-xs btn-more" type="button" data-toggle="collapse" data-target="#collapseVoirie" aria-expanded="false" aria-controls="collapseVoirie"><span class="glyphicon glyphicon-option-horizontal"></span></button>
		    <div class="collapse" id="collapseVoirie">
			<div class="previous">
			    <div class="title">Année précédente</div>
			    <div class="value">187,240.00 €</div>
			</div>

			<div class="previous">
			    <div class="title">Cumul année</div>
			    <div class="value">187,240.00 €</div>
			</div>

			<div class="previous">
			    <div class="title">Cumul année précédente</div>
			    <div class="value">187,240.00 €</div>
			</div>
		    </div>
		</div>
	    </div>

	    <div class="data col-md-3">
		<div class="header">
		    <div class="pull-right"><span class="glyphicon glyphicon-pencil"></span></div>
		    Autorisations de voirie
		</div>
		<div class="middle">173,560.45 €</div>
		<div class="footer">
		    <button class="btn btn-xs btn-more" type="button" data-toggle="collapse" data-target="#collapseVoirie2" aria-expanded="false" aria-controls="collapseVoirie2"><span class="glyphicon glyphicon-option-horizontal"></span></button>
		    <div class="collapse" id="collapseVoirie2">
			<div class="previous">
			    <div class="title">Année précédente</div>
			    <div class="value">187,240.00 €</div>
			</div>

			<div class="previous">
			    <div class="title">Cumul année</div>
			    <div class="value">187,240.00 €</div>
			</div>

			<div class="previous">
			    <div class="title">Cumul année précédente</div>
			    <div class="value">187,240.00 €</div>
			</div>
		    </div>
		</div>
	    </div>

	    <div class="data col-md-3">
		<div class="header">
		    <div class="pull-right"><span class="glyphicon glyphicon-pencil"></span></div>
		    Autorisations de voirie
		</div>
		<div class="middle">173,560.45 €</div>
		<div class="footer">
		    <button class="btn btn-xs btn-more" type="button" data-toggle="collapse" data-target="#collapseVoirie3" aria-expanded="false" aria-controls="collapseVoirie3"><span class="glyphicon glyphicon-option-horizontal"></span></button>
		    <div class="collapse" id="collapseVoirie3">
			<div class="previous">
			    <div class="title">Année précédente</div>
			    <div class="value">187,240.00 €</div>
			</div>

			<div class="previous">
			    <div class="title">Cumul année</div>
			    <div class="value">187,240.00 €</div>
			</div>

			<div class="previous">
			    <div class="title">Cumul année précédente</div>
			    <div class="value">187,240.00 €</div>
			</div>
		    </div>
		</div>
	    </div>

	    <div class="data col-md-3">
		<div class="header">
		    <div class="pull-right"><span class="glyphicon glyphicon-pencil"></span></div>
		    Autorisations de voirie
		</div>
		<div class="middle">173,560.45 €</div>
		<div class="footer">
		    <button class="btn btn-xs btn-more" type="button" data-toggle="collapse" data-target="#collapseVoirie4" aria-expanded="false" aria-controls="collapseVoirie4"><span class="glyphicon glyphicon-option-horizontal"></span></button>
		    <div class="collapse" id="collapseVoirie4">
			<div class="previous">
			    <div class="title">Année précédente</div>
			    <div class="value">187,240.00 €</div>
			</div>

			<div class="previous">
			    <div class="title">Cumul année</div>
			    <div class="value">187,240.00 €</div>
			</div>

			<div class="previous">
			    <div class="title">Cumul année précédente</div>
			    <div class="value">187,240.00 €</div>
			</div>
		    </div>
		</div>
	    </div>
	</div>
    </div>
@endsection
