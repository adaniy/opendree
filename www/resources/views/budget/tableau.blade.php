<ul class="tree">
    @foreach($budget->groupBy('date')->get() as $budgetTree)
	<li><button class="btn btn-tree btn-xs btn-info" type="button" data-toggle="collapse" data-target="#collapsetab{{ $budgetTree->date }}" aria-expanded="false" aria-controls="collapsetab{{ $budgetTree->date }}">{{ $budgetTree->date }}</button>
	    <div class="collapse" id="collapsetab{{ $budgetTree->date }}">
		<table class="table table-hover table-striped table-bordered">
		    <tr>
			<th>test</th>
		    </tr>

		    <tr>
			<td>test</td>
		    </tr>
		</table>
	    </div>
	</li>
    @endforeach
</ul>
