<ul class="tree">
    <?php $__currentLoopData = $budget->groupBy('date')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $budgetTree): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
	<li><button class="btn btn-tree btn-xs btn-info" type="button" data-toggle="collapse" data-target="#collapsetab<?php echo e($budgetTree->date); ?>" aria-expanded="false" aria-controls="collapsetab<?php echo e($budgetTree->date); ?>"><?php echo e($budgetTree->date); ?></button>
	    <div class="collapse" id="collapsetab<?php echo e($budgetTree->date); ?>">
		<table class="table table-hover table-striped table-bordered table-tableau">
		    <tr>
			<th>Service</th>
			<th>Rubrique</th>
			<th>Budget voté</th>
			<th>Modification DM</th>
			<th>Total budget</th>
			<th>Utilisé 2018</th>
			<th>Reste</th>
			<th>% utilisé</th>
			<th>Variation</th>
		    </tr>

		    <tr>
			
			<!-- la taille du rowspan doit être égal au nombre de budget dans un service afin d'être correct -->
			<th class="service-side" rowspan="0"><tableau></tableau></th>
			<th>la poste</th>
			<td>36000</td>
			<td>560</td>
			<td>36560</td>
			<td>2400</td>
			<td>1400</td>
			<td>40 %</td>
			<td>1.10</td>
		    </tr>
		</table>
	    </div>
	</li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
</ul>
