@extends('template')

@section('head')
    Tableau de bord / Gestion des catégories
@endsection

@section('meta')

@endsection

@section('content')
    <div class="dashboard">
	@include('dashboard.menu')
	
	<div class="col-md-10 content">
	    @foreach($dashboardCategories->get() as $categories)
		<div class="col-lg-8 col-sm-7">
		    <div class="data services">
			<div class="middle">{{ $categories->name }}</div>
		    </div>
		</div>

		<div class="col-lg-4 col-sm-4">
		    <div class="buttons">
			<div class="col-lg-6 col-sm-6">
			    <button class="btn btn-xs btn-success btn-crud" id="edit-category" data-attribute="{{ $categories->id }}" data-type="{{ $categories->type }}">modifier</button>
			</div>
			<div class="col-lg-6 col-sm-6">
			    <button class="btn btn-xs btn-danger btn-crud" id="delete-category" data-attribute="{{ $categories->id }}">supprimer</button>
			</div>
		    </div>
		</div>
	    @endforeach
	    <div class="col-md-12">
		<div class="data">
		    <div class="middle add-category"><span class="glyphicon glyphicon-plus"></span></div>
		</div>
	    </div>
	</div>

	<div class="col-md-10">
	    <hr />
	    <div class="text-muted">
		<span class="glyphicon glyphicon-exclamation-sign"></span> Attention : supprimer une catégorie aura pour conséquence de supprimer toute ses données associées et ce définitivement (sauf sauvegardes).
	    </div>
	</div>
    </div>
@endsection
