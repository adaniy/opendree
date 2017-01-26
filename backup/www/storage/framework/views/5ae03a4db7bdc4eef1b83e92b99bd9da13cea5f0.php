<button class="btn btn-xs btn-tree btn-default tree-category">gestion budgétaire</button>
<ul class="tree">
    <?php $__currentLoopData = $budget->groupBy('date')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $budgetTree): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
	<li><button class="btn btn-tree btn-xs btn-info" type="button" data-toggle="collapse" data-target="#collapse<?php echo e($budgetTree->date); ?>" aria-expanded="false" aria-controls="collapse<?php echo e($budgetTree->date); ?>"><?php echo e($budgetTree->date); ?></button><button id="delete-year" data-attribute="<?php echo e($budgetTree->date); ?>" class="btn btn-xs btn-danger btn-tree"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
	    <div class="collapse" id="collapse<?php echo e($budgetTree->date); ?>">
		<ul>
		    <?php $__currentLoopData = $service->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $services): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
			<li><button class="btn btn-tree btn-xs btn-warning" type="button" data-toggle="collapse" data-target="#collapse<?php echo e($budgetTree->date); ?><?php echo e($services->id); ?>" aria-expanded="false" aria-controls="collapse<?php echo e($budgetTree->date); ?><?php echo e($services->id); ?>"><?php echo e($services->name); ?></button>
			    <div class="collapse" id="collapse<?php echo e($budgetTree->date); ?><?php echo e($services->id); ?>">
				<ul>
					<?php $__currentLoopData = $budget->where('service_id', $services->id)->where('date', $budgetTree->date)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $budgets): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
					    <li><div class="table-header col-md-12" data-attribute="<?php echo e($budgets->id); ?>"><name><?php echo e($budgets->name); ?></name><div class="pull-right"><button id="edit-budget" class="btn btn-xs btn-info btn-tree" data-attribute="<?php echo e($budgets->id); ?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button><button id="delete-budget" class="btn btn-xs btn-danger btn-tree" data-attribute="<?php echo e($budgets->id); ?>"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></div></div>
						<table class="table table-striped table-hover table-bordered table-board">
						<tr class="vote" data-attribute="<?php echo e($budgets->id); ?>">
						    <td class="category col-md-5">Budget voté</td>
						    <td class="amount col-md-6" data-attribute="<?php echo e($budgets->id); ?>"><?php echo e(number_format($budgets->vote, 2, '.', ' ')); ?></td>
						    <td class="actions col-md-1">&nbsp;</td>
						</tr>

						<tr class="dm" data-attribute="<?php echo e($budgets->id); ?>">
						    <td class="category col-md-5">Modification DM</td>
						    <td class="amount col-md-6"><?php echo e(number_format($budgets->dm, 2, '.', ' ')); ?></td>
						    <td class="actions col-md-1">&nbsp;</td>
						</tr>

						<?php $__currentLoopData = $budgets->depenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $depenses): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
						    <tr class="depense" data-attribute="<?php echo e($depenses->id); ?>"">
							<td class="category" data-attribute="<?php echo e($depenses->id); ?>"><?php echo e($depenses->category); ?></td>
							<td class="amount" data-attribute="<?php echo e($depenses->id); ?>"><?php echo e(number_format($depenses->amount, 2, '.', ' ')); ?></td>
							<td class="actions"><button id="edit-depense" class="btn btn-xs btn-info live" data-attribute="<?php echo e($depenses->id); ?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button> <button id="delete-depense" class="btn btn-xs btn-danger live" data-attribute="<?php echo e($depenses->id); ?>"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td>
						    </tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
	
						<tr class="total table-footer" data-attribute="<?php echo e($budgets->id); ?>">
						    <td class="category">total</td>
						    <td class="amount"><total></total></td>
						    <td class="actions"><div class="add"><button id="add-depense" class="btn btn-md btn-warning btn-tree" data-attribute="<?php echo e($budgets->id); ?>"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button></div></td>
						</tr>
					    </table>
					    </li>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
					<li><button id="add-budget" class="btn btn-xs btn-success btn-tree" data-attribute="<?php echo e($services->id); ?>" data-year="<?php echo e($budgets->date); ?>"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button></li>
				    </li>
				</ul>
		    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
			    </div>
		</ul>
	    </div>
			</li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
    <li><button id="add-year" class="btn btn-xs btn-success btn-tree"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button></li>
	</li>
</ul>
	</li>
</ul>

<button class="btn btn-xs btn-tree btn-default tree-category">gestion des services</button>
<ul class="tree">
    <?php $__currentLoopData = $service->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $services): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
	<li class="services"><button class="btn btn-tree btn-xs btn-warning" type="button"><?php echo e($services->name); ?></button><button id="edit-service" class="btn btn-xs btn-info btn-tree" data-attribute="<?php echo e($services->id); ?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button><button id="delete-service" data-attribute="<?php echo e($services->id); ?>" class="btn btn-xs btn-danger btn-tree"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>

    <li><button id="add-service" class="btn btn-xs btn-success btn-tree"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button></li>
</ul>
