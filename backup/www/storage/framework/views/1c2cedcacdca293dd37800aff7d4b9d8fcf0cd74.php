<?php $__env->startSection('head'); ?>
    Budget
<?php $__env->stopSection(); ?>

<?php $__env->startSection('meta'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="budget">
	<?php echo $__env->make('budget.menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    
	<div class="tab-content">
	    <div role="budget" class="tab-pane fade in active" id="gestion">
		<?php echo $__env->make('budget.gestion', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	    </div>

	    <div role="budget" class="tab-pane fade" id="board">
		<?php echo $__env->make('budget.board', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	    </div>
	</div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>