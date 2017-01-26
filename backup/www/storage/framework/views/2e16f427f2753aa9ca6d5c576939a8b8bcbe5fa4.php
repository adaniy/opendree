<div class="col-md-2 menu">
    <button href="/dashboard/" class="btn btn-menu btn-home"><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> tableau de bord</button>
    <button href="/dashboard/categories/" class="btn btn-menu btn-year" type="button" data-toggle="collapse" data-target="#collapseAmounts" aria-expanded="false" aria-controls="collapseAmount">
	<div class="pull-right"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></div>
	Catégories
    </button>
    
    <button href="/dashboard/services/" class="btn btn-menu btn-year" type="button" data-toggle="collapse" data-target="#collapseAmounts" aria-expanded="false" aria-controls="collapseAmount">
	<div class="pull-right"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></div>
	Services
    </button>
    <br /><br />
    <?php $__currentLoopData = $dashboard->orderBy('date', 'DESC')->groupBy(DB::raw('date(date, "start of year")'))->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dashboards): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
    <button class="btn btn-menu btn-year" type="button" data-toggle="collapse" data-target="#collapse<?php echo e($dashboardClass->getYear($dashboards->date)); ?>" aria-expanded="false" aria-controls="collapse<?php echo e($dashboardClass->getYear($dashboards->date)); ?>">
	<div class="pull-right"><span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span></div>
	    Année <?php echo e($dashboardClass->getYear($dashboards->date)); ?>

    </button>
    <div class="collapse" id="collapse<?php echo e($dashboardClass->getYear($dashboards->date)); ?>">
	<button href="<?php echo e(url('dashboard/'.$dashboardClass->getYear($dashboards->date))); ?>" class="btn btn-menu btn-month">
	    <div class="pull-right"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></div>
	    Toute l'année
	</button>
	<?php $__currentLoopData = $dashboard->orderBy('date', 'ASC')->whereYear('date', (string) $dashboardClass->getYear($dashboards->date))->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $months): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
	<button href="<?php echo e(url('dashboard/'.$dashboardClass->getYear($dashboards->date).'/'.$dashboardClass->getMonthNumber($months->date))); ?>" class="btn btn-menu btn-month">
	    <div class="pull-right"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></div>
	    <?php echo e($dashboardClass->getMonth($months->date)); ?>

	</button>

	<?php if($loop->last): ?>
	    <?php if($dashboardClass->getMonthNumber($months->date) != 12): ?>
		<button data-attribute="<?php echo e($dashboardClass->getYear($dashboards->date)); ?>" class="btn btn-xs live btn-warning" id="add-month" type="button" data-toggle="tooltip" data-placement="bottom" title="Ajouter un mois">
		    <div class="text-center">
			<span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
		    </div>
		</button>
	    <?php endif; ?>
	<?php endif; ?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
    <br />
    <button class="btn btn-xs live btn-success" id="add-year" type="button" data-toggle="tooltip" data-placement="bottom" title="Ajouter une année">
	<div class="text-center">
	    <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
	</div>
    </button>
</div>
