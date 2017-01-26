<?php $__env->startSection('head'); ?>
    Tableau de bord / Gestion des services
<?php $__env->stopSection(); ?>

<?php $__env->startSection('meta'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="dashboard">
	<?php echo $__env->make('dashboard.menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	
	<div class="col-md-10 content">
	    <?php $__currentLoopData = $service->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $services): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
		<div class="col-lg-8 col-sm-7">
		    
		    <div class="data services">

			<div class="middle toggle-panel">
			    <?php echo e($services->name); ?>

			</div>
		    </div>
		</div>

		<div class="col-lg-4 col-sm-4">
		    <div class="buttons">
			<div class="col-lg-6 col-sm-6">
			    <button class="btn btn-xs btn-success btn-crud">modifier</button>
			</div>
			<div class="col-lg-6 col-sm-6">
			    <button class="btn btn-xs btn-danger btn-crud">supprimer</button>
			</div>
		    </div>
		</div>
	    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
	    <div class="col-md-12">
		<div class="data add-service">
		    <div class="middle add-service"><span class="glyphicon glyphicon-plus"></span></div>
		</div>
	    </div>
	</div>

	<div class="col-md-10">
	    <hr />
	    <div class="text-muted">
		<span class="glyphicon glyphicon-exclamation-sign"></span> Attention : supprimer un service aura pour conséquence de supprimer toute ses données associées et ce définitivement (sauf sauvegardes).
	    </div>
	</div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>