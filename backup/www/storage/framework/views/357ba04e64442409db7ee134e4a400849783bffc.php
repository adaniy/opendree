<?php $__env->startSection('head'); ?>
    Tableau de bord
<?php $__env->stopSection(); ?>

<?php $__env->startSection('meta'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="dashboard">
	<?php echo $__env->make('dashboard.menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	
	<div class="col-md-10 content">
	</div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>