<ul class="tree">
    @foreach($budget->groupBy('date')->get() as $budgetTree)
    <li><button class="btn btn-tree btn-xs btn-info" type="button" data-toggle="collapse" data-target="#collapse{{ $budgetTree->date }}" aria-expanded="false" aria-controls="collapse{{ $budgetTree->date }}">{{ $budgetTree->date }}</button><button id="delete-budget" class="btn btn-xs btn-danger btn-tree"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
	    <div class="collapse" id="collapse{{ $budgetTree->date }}">
		<ul>
		    @foreach($service->get() as $services)
			<li><button class="btn btn-tree btn-xs btn-warning" type="button" data-toggle="collapse" data-target="#collapse{{ $budgetTree->date }}{{ $services->name }}" aria-expanded="false" aria-controls="collapse{{ $budgetTree->date }}{{ $services->name }}">{{ $services->name }}</button>
			    <div class="collapse" id="collapse{{ $budgetTree->date }}{{ $services->name }}">
				<ul>
				    <li>
					@foreach($budget->where('service_id', $services->id)->where('date', $budgetTree->date)->get() as $budgets)
					    <button id="edit-budget" class="btn btn-xs btn-info btn-tree"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button><button id="delete-budget" class="btn btn-xs btn-danger btn-tree"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
					    <table class="table table-striped table-hover table-bordered table-board">
						<tr class="budget">
						    <th class="col-md-3">{{ $budgets->name }}</th>
						    <th class="col-md-8">montants</th>
						    <th class="col-md-1">actions</th>
						</tr>

						<tr class="vote">
						    <td class="category">Budget voté</td>
						    <td class="amount">{{ number_format($budgets->vote, 2, '.', ' ') }}</td>
						    <td class="actions">&nbsp;</td>
						</tr>

						@foreach($budgets->depenses as $depenses)
						    <tr class="depense" data-attribute="{{ $depenses->id }}"">
							<td class="category" data-attribute="{{ $depenses->id }}">{{ $depenses->category }}</td>
							<td class="amount" data-attribute="{{ $depenses->id }}">{{ number_format($depenses->amount, 2, '.', ' ') }}</td>
							<td class="actions"><button id="edit-depense" class="btn btn-xs btn-info live" data-attribute="{{ $depenses->id }}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button> <button id="delete-depense" class="btn btn-xs btn-danger live" data-attribute="{{ $depenses->id }}"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td>
						    </tr>
						@endforeach
	
						<tr class="total" data-attribute="{{ $budgets->id }}">
						    <td class="category">total</td>
						    <td class="amount"><total></total></td>
						    <td class="actions">&nbsp;</td>
						</tr>
					    </table>
					    <div class="add"><button id="add-depense" class="btn btn-md btn-warning live" data-attribute="{{ $budgets->id }}"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button></div>
					@endforeach
					<li><button id="add-budget" class="btn btn-xs btn-success btn-tree"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button></li>
				    </li>
				</ul>
		    @endforeach
			    </div>
		</ul>
	    </div>
			</li>
    @endforeach
    <li><button id="add-annee" class="btn btn-xs btn-success btn-tree"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button></li>
    </li>
</ul>
    </li>
</ul>


