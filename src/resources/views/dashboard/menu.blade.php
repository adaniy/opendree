<div class="col-md-2 menu">
    <button href="/dashboard/" class="btn btn-menu btn-home"><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> tableau de bord</button>
    <button href="/dashboard/services/" class="btn btn-menu btn-year">
	<div class="pull-right"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></div>
	Services
    </button>
    <button href="/dashboard/agents/" class="btn btn-menu btn-year">
	<div class="pull-right"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></div>
	Agents
    </button>
    <button href="/dashboard/categories/" class="btn btn-menu btn-year">
	<div class="pull-right"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></div>
	Catégories
    </button>
    <button href="/dashboard/holidays/" class="btn btn-menu btn-year">
	<div class="pull-right"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></div>
	Congés
    </button>
    <br /><br />
    @foreach($dashboard->orderBy('date', 'DESC')->groupBy(DB::raw('date(date, "start of year")'))->get() as $dashboards)
    <button class="btn btn-menu btn-year" type="button" data-toggle="collapse" data-target="#collapse{{ $dashboardClass->getYear($dashboards->date) }}" aria-controls="collapse{{ $dashboardClass->getYear($dashboards->date) }}">
	<div class="pull-right"><span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span></div>
	    Année {{ $dashboardClass->getYear($dashboards->date) }}
    </button>
    <div class="collapse @if(isset($year)) {{ $dashboardClass->isActual($year, $dashboardClass->getYear($dashboards->date)) }} @endif" id="collapse{{ $dashboardClass->getYear($dashboards->date) }}">
	<button href="{{ url('dashboard/'.$dashboardClass->getYear($dashboards->date)) }}" class="btn btn-menu btn-month">
	    <div class="pull-right"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></div>
	    Toute l'année
	</button>
	@foreach($dashboard->orderBy('date', 'ASC')->whereYear('date', (string) $dashboardClass->getYear($dashboards->date))->get() as $months)
	<button href="{{ url('dashboard/'.$dashboardClass->getYear($dashboards->date).'/'.$dashboardClass->getMonthNumber($months->date)) }}" class="btn btn-menu btn-month">
	    <div class="pull-right"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></div>
	    {{ $dashboardClass->getMonth($months->date) }}
	</button>

	@if($loop->last)
	    @if($dashboardClass->getMonthNumber($months->date) != 12)
		<button data-attribute="{{ $dashboardClass->getYear($dashboards->date) }}" class="btn btn-xs live btn-warning" id="add-month" type="button" data-toggle="tooltip" data-placement="bottom" title="Ajouter un mois">
		    <div class="text-center">
			<span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
		    </div>
		</button>
	    @endif
	@endif
	@endforeach
    </div>
    @endforeach
    <br />
    <button class="btn btn-xs live btn-success" id="add-year" type="button" data-toggle="tooltip" data-placement="bottom" title="Ajouter une année">
	<div class="text-center">
	    <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
	</div>
    </button>
</div>

