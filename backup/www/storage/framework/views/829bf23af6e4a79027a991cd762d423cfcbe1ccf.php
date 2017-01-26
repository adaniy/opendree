<?php $__env->startSection('head'); ?>
    Actions planifiées
<?php $__env->stopSection(); ?>

<?php $__env->startSection('meta'); ?>
    <meta name="id" content="<?php echo e($id); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="action">
	<?php echo $__env->make('action.list', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

	<div class="droite col-md-9">
	    <div class="titre">
		<?php echo e($actionCurrent->nom); ?>

	    </div>

	    <div class="col-md-3">
		<h4>Date de création<div class="pull-right"><button id="edit-date-creation" class="live"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button></div></h4>
		<div class="inner action-info action-date-creation"><?php echo e($actionClass->date($actionCurrent->date_creation)); ?></div>
	    </div>

	    <div class="col-md-3">
		<h4>Date de réalisation<div class="pull-right"><button id="edit-date-realisation" class="live"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button></div></h4>
		<div class="inner action-info action-date-realisation"><?php echo e($actionClass->date($actionCurrent->date_realisation)); ?></div>
	    </div>

	    <div class="col-md-3">
		<h4>Date butoir<div class="pull-right"><button id="edit-date-butoir" class="live"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button></div></h4>
		<div class="inner action-info action-date-butoir"><?php echo e($actionClass->date($actionCurrent->date_butoir)); ?></div>
	    </div>

	    <div class="col-md-3">
		<h4>Jours restant</h4>
		<div class="inner action-info action-jour-restant"><?php echo e($actionClass->diff($actionCurrent->date_butoir)); ?></div>
	    </div>

	    <div class="col-md-12">
		<h4>Description<div class="pull-right"><button id="edit-description" class="live"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button></div></h4>
		    <div class="inner">
			<div class="description"><?php echo $actionClass->description($actionCurrent->description); ?></div>
		</div>
	    </div>

	    <div class="col-md-12">
		<div class="col-md-12">
		    <br />
		    <div class="pull-left"><?php echo $actionClass->alertButton($id); ?></div>

		    <div class="pull-right">
			<a href="<?php echo e(url('action/delete/'.$id)); ?>" onclick="return confirm('Confirmez-vous la suppression de cette action ?')" class="btn btn-md btn-danger">Supprimer</a>
		    </div>
		</div>
	    </div>
	</div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>