<button class="btn btn-xs btn-tree btn-default tree-category">gestion budgétaire</button>
<ul class="tree">
    @foreach($budget->groupBy('date')->get() as $budgetTree)
	<li><button class="btn btn-tree btn-xs btn-info" type="button" data-toggle="collapse" data-target="#collapse{{ $budgetTree->date }}" aria-expanded="false" aria-controls="collapse{{ $budgetTree->date }}">{{ $budgetTree->date }}</button><button id="delete-year" data-attribute="{{ $budgetTree->date }}" class="btn btn-xs btn-danger btn-tree"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
	    <div class="collapse" id="collapse{{ $budgetTree->date }}">
		<ul>
		    @foreach($service->get() as $services)
			<li><button class="btn btn-tree btn-xs btn-warning" type="button" data-toggle="collapse" data-target="#collapse{{ $budgetTree->date }}{{ $services->id }}" aria-expanded="false" aria-controls="collapse{{ $budgetTree->date }}{{ $services->id }}">{{ $services->name }}</button>
			    <div class="collapse" id="collapse{{ $budgetTree->date }}{{ $services->id }}">
				<ul>
					@foreach($budget->where('service_id', $services->id)->where('date', $budgetTree->date)->get() as $budgets)
					    <li><div class="table-header col-md-12" data-attribute="{{ $budgets->id }}"><name>{{ $budgets->name }}</name><div class="pull-right"><button id="edit-budget" class="btn btn-xs btn-info btn-tree" data-attribute="{{ $budgets->id }}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button><button id="delete-budget" class="btn btn-xs btn-danger btn-tree" data-attribute="{{ $budgets->id }}"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></div></div>
						<table class="table table-striped table-hover table-bordered table-board">
						<tr class="vote" data-attribute="{{ $budgets->id }}">
						    <td class="category col-md-5">Budget voté</td>
						    <td class="amount col-md-6" data-attribute="{{ $budgets->id }}">{{ number_format($budgets->vote, 2, '.', ' ') }}</td>
						    <td class="actions col-md-1">&nbsp;</td>
						</tr>

						<tr class="dm" data-attribute="{{ $budgets->id }}">
						    <td class="category col-md-5">Modification DM</td>
						    <td class="amount col-md-6">{{ number_format($budgets->dm, 2, '.', ' ') }}</td>
						    <td class="actions col-md-1">&nbsp;</td>
						</tr>

						@foreach($budgets->depenses as $depenses)
						    <tr class="depense" data-attribute="{{ $depenses->id }}"">
							<td class="category" data-attribute="{{ $depenses->id }}">{{ $depenses->category }}</td>
							<td class="amount" data-attribute="{{ $depenses->id }}">{{ number_format($depenses->amount, 2, '.', ' ') }}</td>
							<td class="actions"><button id="edit-depense" class="btn btn-xs btn-info live" data-attribute="{{ $depenses->id }}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button> <button id="delete-depense" class="btn btn-xs btn-danger live" data-attribute="{{ $depenses->id }}"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td>
						    </tr>
						@endforeach
	
						<tr class="total table-footer" data-attribute="{{ $budgets->id }}">
						    <td class="category">total</td>
						    <td class="amount"><total></total></td>
						    <td class="actions"><div class="add"><button id="add-depense" class="btn btn-md btn-warning btn-tree" data-attribute="{{ $budgets->id }}"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button></div></td>
						</tr>
					    </table>
					    </li>
					@endforeach
					<li><button id="add-budget" class="btn btn-xs btn-success btn-tree" data-attribute="{{ $services->id }}" data-year="{{ $budgets->date }}"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button></li>
				    </li>
				</ul>
		    @endforeach
			    </div>
		</ul>
	    </div>
			</li>
    @endforeach
    <li><button id="add-year" class="btn btn-xs btn-success btn-tree"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button></li>
	</li>
</ul>
	</li>
</ul>

<button class="btn btn-xs btn-tree btn-default tree-category">gestion des services</button>
<ul class="tree">
    @foreach($service->get() as $services)
	<li class="services"><button class="btn btn-tree btn-xs btn-warning" type="button">{{ $services->name }}</button><button id="edit-service" class="btn btn-xs btn-info btn-tree" data-attribute="{{ $services->id }}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button><button id="delete-service" data-attribute="{{ $services->id }}" class="btn btn-xs btn-danger btn-tree"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></li>
    @endforeach

    <li><button id="add-service" class="btn btn-xs btn-success btn-tree"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button></li>
</ul>
