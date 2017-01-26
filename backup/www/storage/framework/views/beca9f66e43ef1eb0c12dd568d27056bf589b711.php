<ul class="tree">
    <?php $__currentLoopData = $budget->groupBy('date')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $budgetTree): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
	<li><button class="btn btn-tree btn-xs btn-info" type="button" data-toggle="collapse" data-target="#collapsetab<?php echo e($budgetTree->date); ?>" aria-expanded="false" aria-controls="collapsetab<?php echo e($budgetTree->date); ?>"><?php echo e($budgetTree->date); ?></button>
	    <div class="collapse" id="collapsetab<?php echo e($budgetTree->date); ?>">
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

		    <?php $__currentLoopData = $budget->where('date', $budgetTree->date)->orderBy('service_id', 'ASC')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $budgets): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
			<tr>
			    <?php echo $budgetClass->rowSpan($budgets->id, $budgets->service_id, $budgetTree->date); ?>

			    <td><?php echo e($budgets->name); ?></td>
			    <td><?php echo e(number_format($budgets->vote, 2)); ?> €</td>
			    <td><?php echo e(number_format($budgets->dm, 2)); ?> €</td>
			    <td><?php echo e(number_format($budgetClass->getTotalRaw($budgets->id), 2)); ?> €</td>
			    <td><?php echo e(number_format($budgetClass->getSpent($budgets->id), 2)); ?> €</td>
			    <td><?php echo e(number_format($budgetClass->getRemaining($budgetClass->getTotalRaw($budgets->id), $budgetClass->getSpent($budgets->id)), 2)); ?> €</td>
			    <td><?php echo e($budgetClass->getSpentPercentage($budgetClass->getTotalRaw($budgets->id), $budgetClass->getSpent($budgets->id))); ?> %</td>
			    <td><?php echo e(number_format($budgetClass->getVariation($budgets->dm, $budgets->vote), 2)); ?></td>
			</tr>
		    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
		</table>
	    </div>
	</li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
</ul>
