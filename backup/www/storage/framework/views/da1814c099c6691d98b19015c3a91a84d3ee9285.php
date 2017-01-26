<?php $__env->startSection('head'); ?>
    Tableau de bord
<?php $__env->stopSection(); ?>

<?php $__env->startSection('meta'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="dashboard">
	<?php echo $__env->make('dashboard.menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	
	<div class="col-md-10 content">
	    <div class="title"><?php echo e($dashboardClass->getDate($year, $month)); ?></div>
	    <div class="col-md-12">
		<?php $__currentLoopData = $dashboardCategories->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categories): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
		    <div class="col-md-3 amounts">
			<div class="data">
			    <div class="header">
				<?php echo e($categories->name); ?>

			    </div>
			    <div class="middle edit-amount"><?php echo e($dashboardClass->getAmount($categories->id)); ?></div>
			    <div class="footer" type="button" data-toggle="collapse" data-target="#collapse-<?php echo e(str_slug($categories->name, '-')); ?>" aria-expanded="false" aria-controls="collapse-<?php echo e(str_slug($categories->name, '-')); ?>">
				<span class="glyphicon glyphicon-option-horizontal show-more"></span>
				<div class="collapse" id="collapse-<?php echo e(str_slug($categories->name, '-')); ?>">
				    <div class="previous">
					<div class="title">Mois année précédente</div>
					<div class="value">187,240.00 €</div>
				    </div>

				    <div class="previous">
					<div class="title">Cumul année</div>
					<div class="value">187,240.00 €</div>
				    </div>

				    <div class="previous">
					<div class="title">Cumul année précédente</div>
					<div class="value"->187,240.00 €</div>
				    </div>
				</div>
			    </div>
			</div>
		    </div>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
	    </div>

	    <div class="col-md-12">
		<?php $__currentLoopData = $service->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $services): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
		    <div class="col-md-3 services">
			<div class="data">
			    <div class="header"><?php echo e($services->name); ?></div>

			    <div class="middle small edit-amount-service">
				<li><span class="glyphicon glyphicon-user"></span> 48 agents</li>
				<li><span class="glyphicon glyphicon-calendar"></span> 6 jours de congés</li>
				<li><span class="glyphicon glyphicon-time"></span> 140 heures sup'</li>
			    </div>
			</div>
		    </div>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
	    </div>
	</div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>