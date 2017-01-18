@foreach($budget->get() as $budgets)
<table class="table table-striped table-hover table-bordered table-board">
	<tr class="budget">
	    <th class="col-md-4">{{ $budgets->name }}</th>
	    <th class="col-md-8">montants</th>
	</tr>

	<tr class="vote">
	    <td class="category">Budget voté</td>
	    <td class="amount">{{ $budgets->vote }}</td>
	</tr>

	@foreach($budgetDepense->where('budget_id', $budgets->id)->get() as $depenses)
	    <tr class="depense">
		<td class="category">{{ $depenses->category }}</td>
		<td class="amount">{{ $depenses->amount }}</td>
	    </tr>
	@endforeach
	
	<tr class="total" data-attribute="{{ $budgets->id }}">
	    <td class="category">total</td>
	    <td class="amount">{{ $budgetClass->total($budgets->id) }}</td>
	</tr>
    
</table>
<div class="add"><button id="add-depense" class="live" data-attribute="{{ $budgets->id }}"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button></div>
@endforeach
