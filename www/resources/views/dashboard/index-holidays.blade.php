@extends('template')
@section('head')
    Tableau de bord / Ajouter un congé
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
		    <form class="form add-holiday">
			<div class="inner">
			    <table class="table-holiday-add" data-attribute="{{ $services->id }}">
				<tr>
				    <th class="col-md-4">Selection d'un agent</th>
				    <th class="col-md-2">Date de début</th>
				    <th class="col-md-2">Date de fin</th>
				    <th class="col-md-2" rowspan="2"><input type="submit" class="btn btn-xs btn-tree btn-success" value="Valider"></th>
				</tr>

				<tr>
				    <td>
					<div class="form-group">
					    <select name="idAgent" class="form-control">
						@foreach($services->agents as $agents)
						    <option value="{{ $agents->id }}">{{ $agents->name }}</option>
						@endforeach
					    </select>
					</div>
				    </td>

				    <td>
					<div class="form-group">
					    <input type="date" class="form-control" name="debut">
					</div>
				    </td>
				    
				    <td>
					<div class="form-group">
					    <input type="date" class="form-control" name="fin">
					</div>
				    </td>
				</tr>
			    </table>
			</div>
		    </form>
		</div>
	    @endforeach
	</div>
    </div>
@endsection
