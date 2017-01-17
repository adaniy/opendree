<table class="table table-striped table-hover table-bordered table-board">
    <tr>
	<th>Catégorie</th>

	@foreach($budget->get() as $budgets)
	    <th>{{ $budgets->name }}</th>
	@endforeach
    </tr>

    {{-- ligne apparaissant obligatoirement --}}
    <tr>
	<td>Budget voté</td>

	@foreach($budget->get() as $budgets)
	    <td>{{ $budgets->vote }}</td>
	@endforeach
    </tr>

    @foreach($budgetCategory->get() as $categories)
	<tr>
	    <td>{{ $categories->name }}</td>

	    @foreach($categories->depenses as $depenses)
		<td>{{ $depenses->amount }}</td>
	    @endforeach
	</tr>
    @endforeach

    {{-- ligne apparaissant obligatoirement --}}
    <tr>
	<td>total</td>

	@foreach($budget->get() as $budgets)
	    <td>{{ $budgetClass->total($budgets->id) }}</td>
	@endforeach
    </tr>
</table>
