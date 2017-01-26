<div class="gauche col-md-3">
    <div class="search">
	<form>
	    <div class="form-group">
		<input type="text" name="search" class="live-search form-control" placeholder="Recherche ...">
	    </div>
	</form>
    </div>
    <div class="action-new">
	<div class="pull-right"><button id="refresh" class="live"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button> <a href="<?php echo e(url('action')); ?>" class="button-link"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></div>
	<button id="add" class="live"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button>
    </div>

    <div class="action-list">
	<?php $__currentLoopData = $action; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $actions): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
	    <div class="list" data-attribute="<?php echo e($actions->id); ?>"><div class="pull-right"><button id="edit" class="live" data-attribute="<?php echo e($actions->id); ?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button></div><a href="<?php echo e(url('action/'.$actions->id)); ?>"><li <?php if($actionClass->canAlertBoolean($actions->id)): ?> class="alerte" <?php endif; ?>><?php echo e($actions->nom); ?></li></a></div>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
	    </div>
    </div>
