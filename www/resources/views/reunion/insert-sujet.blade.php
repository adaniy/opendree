@extends('template')

@section('back')
    <a href="{{ url('reunion/'.$id) }}"><span class="glyphicon glyphicon-arrow-left back" aria-hidden="true"></span></a>
@endsection

@section('contenu')
	<div class="col-lg">
		<h3><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Insérer un sujet discuté dans une réunion</h3>
	    <hr />
		<form id="decal" action="{{ url('reunion/ajout/sujet/'.$id) }}" method="POST">
			<div class="col-md-12">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="form-group">
					<label for="nom">* Nom du sujet :</label>
					<input type="text" name="sujet" class="form-control" value="{{ old('sujet') }}" placeholder="Nom du sujet" />
				</div>

				<div class="form-group">
					<label for="nom">Observations :</label>
					<textarea name="observation" class="form-control" placeholder="Observations" rows="5">{{ old('observation') }}</textarea>
				</div>

				<div class="form-group">
					<label for="nom">Décisions - actions :</label>
					<textarea name="action" class="form-control" placeholder="Décisions - actions" rows="5">{{ old('action') }}</textarea>
				</div>

				<hr />
				<input type="submit" class="btn btn-success" value="Valider" />
		</form>
	</div>
@endsection