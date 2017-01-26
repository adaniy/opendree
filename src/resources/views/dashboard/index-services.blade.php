@extends('template')

@section('head')
    Tableau de bord / Gestion des services
@endsection

@section('meta')

@endsection

@section('content')
    <div class="dashboard">
	@include('dashboard.menu')
	
	<div class="col-md-10 content">
	    @foreach($service->get() as $services)
		<div class="col-lg-8 col-sm-7">
		    <div class="data services">
			<div class="middle toggle-panel">
			    {{ $services->name }}
			</div>
		    </div>
		</div>

		<div class="col-lg-4 col-sm-4">
		    <div class="buttons">
			<div class="col-lg-6 col-sm-6">
			    <button class="btn btn-xs btn-success btn-crud" id="edit-service">modifier</button>
			</div>
			<div class="col-lg-6 col-sm-6">
			    <button class="btn btn-xs btn-danger btn-crud" id="delete-service">supprimer</button>
			</div>
		    </div>
		</div>
	    @endforeach
	    <div class="col-md-12">
		<div class="data">
		    <div class="middle add-service"><span class="glyphicon glyphicon-plus"></span></div>
		</div>
	    </div>
	</div>

	<div class="col-md-10">
	    <hr />
	    <div class="text-muted">
		<span class="glyphicon glyphicon-exclamation-sign"></span> Attention : supprimer un service aura pour conséquence de supprimer toute ses données associées et ce définitivement (sauf sauvegardes).
	    </div>
	</div>
    </div>
@endsection
