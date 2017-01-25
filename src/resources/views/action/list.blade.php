<div class="gauche col-md-3">
    <div class="search">
	<form>
	    <div class="form-group">
		<input type="text" name="search" class="live-search form-control" placeholder="Recherche ...">
	    </div>
	</form>
    </div>
    <div class="action-new">
	<div class="pull-right"><button id="refresh" class="live"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button> <a href="{{ url('action') }}" class="button-link"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></div>
	<button id="add" class="live"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button>
    </div>

    <div class="action-list">
	@foreach($action as $actions)
	    <div class="list" data-attribute="{{ $actions->id }}"><div class="pull-right"><button id="edit" class="live" data-attribute="{{ $actions->id }}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button></div><a href="{{ url('action/'.$actions->id) }}"><li @if($actionClass->canAlertBoolean($actions->id)) class="alerte" @endif>{{ $actions->nom }}</li></a></div>
	@endforeach
	    </div>
    </div>
