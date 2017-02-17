@extends('template')
@section('head')
    Tableau de bord / Gestion des agents
@endsection

@section('meta')

@endsection

@section('content')
    <div class="dashboard">
	@include('dashboard.menu')
	
	<div class="col-md-10 content">
	    @foreach($service->get() as $services)
		<div class="col-md-12">
		    <h4>{{ $services->name }}</h4>
		    <div class="inner">
			<table class="table table-hover table-striped table-bordered table-agents" data-attribute="{{ $services->id }}">
			    @foreach($services->agents as $agents)
			    <tr data-attribute="{{ $agents->id }}">
				<th class="col-md-10">{{ $agents->name }}</th>
				<td class="col-md-2">
				    <button class="btn btn-xs btn-danger btn-tree" id="delete-agent">supprimer</button>
				</td>
			    </tr>
			    @endforeach
			</table>
			<div class="text-center"><button class="btn btn-xs btn-warning btn-tree" id="add-agent" data-service-name="{{ $services->name }}" data-service="{{ $services->id }}"><span class="glyphicon glyphicon-plus-sign"></span></button></div>
		    </div>
		</div>
	    @endforeach
	</div>
@endsection
