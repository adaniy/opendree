<div class="col-md-2 menu">
    <button href="/dashboard/" class="btn btn-menu btn-home"><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> tableau de bord</button>
    <button href="/dashboard/categories/" class="btn btn-menu btn-year" type="button" data-toggle="collapse" data-target="#collapseAmounts" aria-expanded="false" aria-controls="collapseAmount">
	<div class="pull-right"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></div>
	Catégories
    </button>
    
    <button href="/dashboard/services/" class="btn btn-menu btn-year" type="button" data-toggle="collapse" data-target="#collapseAmounts" aria-expanded="false" aria-controls="collapseAmount">
	<div class="pull-right"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></div>
	Services
    </button>
    <br /><br />
    @foreach($dashboard->orderBy('date', 'ASC')->get() as $dashboards)
    <button class="btn btn-menu btn-year" type="button" data-toggle="collapse" data-target="#collapse{{ $dashboardClass->getYear($dashboards->date) }}" aria-expanded="false" aria-controls="collapse{{ $dashboardClass->getYear($dashboards->date) }}">
	<div class="pull-right"><span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span></div>
	    Année {{ $dashboardClass->getYear($dashboards->date) }}
    </button>
    <div class="collapse" id="collapse{{ $dashboardClass->getYear($dashboards->date) }}">
	<button class="btn btn-menu btn-month">
	    <div class="pull-right"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></div>
	    Toute l'année
	</button>

	<button class="btn btn-menu btn-month">
	    <div class="pull-right"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></div>
	    Janvier
	</button>

	<button data-attribute="{{ $dashboardClass->getYear($dashboards->date) }}" class="btn btn-xs live btn-warning" id="add-month" type="button" data-toggle="tooltip" data-placement="bottom" title="Ajouter un mois">
	    <div class="text-center">
		<span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
	    </div>
	</button>
    </div>
    @endforeach
    <br />
    <button class="btn btn-xs live btn-success" id="add-year" type="button" data-toggle="tooltip" data-placement="bottom" title="Ajouter une année">
	<div class="text-center">
	    <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
	</div>
    </button>
</div>
