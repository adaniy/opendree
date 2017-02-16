<ul class="tree">
    @foreach($budget->groupBy('date')->get() as $budgetTree)
	<li><button class="btn btn-tree btn-xs btn-info" type="button" data-toggle="collapse" data-target="#collapsetab{{ $budgetTree->date }}" aria-expanded="false" aria-controls="collapsetab{{ $budgetTree->date }}">{{ $budgetTree->date }}</button>
	    <div class="collapse" id="collapsetab{{ $budgetTree->date }}">
		<div class="pull-right"><button href="/budget/print/{{ $budgetTree->date }}" class="btn btn-xs live btn-primary"><span class="glyphicon glyphicon-print"></span></button></div>
		<table class="table table-hover table-striped table-bordered table-tableau">
		    <tr class="header">
			<th class="col-md-2">Service</th>
			<th class="col-md-2">Rubrique</th>
			<th class="col-md-2">Budget voté</th>
			<th class="col-md-2">Modification DM</th>
			<th class="col-md-1">Total budget</th>
			<th class="col-md-1">Utilisé</th>
			<th class="col-md-1">Reste</th>
			<th class="col-md-1">% utilisé</th>
			<th class="col-md-1">Variation</th>
		    </tr>

		    @foreach($budget->where('date', $budgetTree->date)->orderBy('service_id', 'ASC')->get() as $budgets)
			<tr>
			    {!! $budgetClass->rowSpan($budgets->id, $budgets->service_id, $budgetTree->date) !!}
			    <td>{{ $budgets->name }}</td>
			    <td>{{ number_format($budgets->vote, 2) }} €</td>
			    <td>{{ number_format($budgets->dm, 2) }} €</td>
			    <td>{{ number_format($budgetClass->getTotalRaw($budgets->id), 2) }} €</td>
			    <td>{{ number_format($budgetClass->getSpent($budgets->id), 2) }} €</td>
			    <td>{{ number_format($budgetClass->getRemaining($budgetClass->getTotalRaw($budgets->id), $budgetClass->getSpent($budgets->id)), 2) }} €</td>
			    <td>{{ $budgetClass->getSpentPercentage($budgetClass->getTotalRaw($budgets->id), $budgetClass->getSpent($budgets->id)) }} %</td>
			    <td>{{ number_format($budgetClass->getVariation($budgets->dm, $budgets->vote), 2) }}</td>
			</tr>
		    @endforeach
		</table>
	    </div>
	</li>
    @endforeach
</ul>
