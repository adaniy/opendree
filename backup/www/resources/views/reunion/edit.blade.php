@extends('template')

@section('back')
    <a href="{{ url('reunion') }}"><span class="glyphicon glyphicon-arrow-left back" aria-hidden="true"></span></a>
@endsection

@section('contenu')
	<div class="col-lg">
		<h3><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Aide</h3>
	    <hr />
	    <li class="text-muted">Les dates sont au format jj/mm/aaaa hh:mm:ss donc par exemple 30/12/2016 12:00:00.</li>
	    <li class="text-muted">Vous pourrez ajouter des participants lorsque la réunion aura été créée.</li>
	    <hr />
		<form id="decal" action="{{ url('reunion/modifier/'.$id) }}" method="POST">
			<div class="col-md-12">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="form-group">
					<label for="nom">* Sujet de la réunion :</label>
					<input type="text" name="sujet" class="form-control" value="{{ $reunion->sujet }}" placeholder="Sujet de la réunion" /><br />
				</div>

				<div class="form-group">
					<label for="nom">* Date et heure de la réunion :</label>
					<input type="text" name="date" class="form-control" value="{{ $reunion->date }}" placeholder="Date et heure de la réunion" /><br />
				</div>

				<div class="form-group">
					<label for="nom">Date et heure de la prochaine réunion :</label>
					<input type="text" name="date_prochain" class="form-control" value="{{ $reunion->date_prochain }}" placeholder="Date et heure de la prochaine réunion" /><br />
				</div>

				<hr />
				<input type="submit" class="btn btn-success" value="Valider" />
		</form>
	</div>
@endsection