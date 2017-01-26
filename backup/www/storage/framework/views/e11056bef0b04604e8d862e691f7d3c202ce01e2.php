<?php $actionClass = app('App\Classes\ActionClass'); ?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <link href="<?php echo e(asset('css/bootstrap.min.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('css/override.css')); ?>" rel="stylesheet">
        <title>GDMC</title>

	<?php echo $__env->yieldContent('meta'); ?>
    </head>
    <body>
	<nav class="head col-md-12 col-xs-12">
	    <div class="content col-md-11 col-xs-10">
		GDMC / <?php echo $__env->yieldContent('head'); ?>
	    </div>

	    <div class="menu col-md-1 col-xs-2">
		<button class="module"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span></button>
		<div class="deploy">
		    <div class="titre">Modules</div>
		    <a href="<?php echo e(url('election')); ?>"><ul>▶ election</ul></a>
		    <a href="<?php echo e(url('reunion')); ?>"><ul>▶ reunion</ul></a>
		    <a href="<?php echo e(url('action')); ?>"><ul>▶ action</ul></a>
		    <a href="<?php echo e(url('budget')); ?>"><ul>▶ budget</ul></a>
		    <a href="<?php echo e(url('planning')); ?>"><ul>▶ planning</ul></a>
		</div>
	    </div>
	</nav>

	<div class="container-fluid">
	    <div class="row">
		<?php if(count($errors) > 0): ?>
		    <div class="bs-errors" data-example-id="dismissible-alert-css">
			<div class="alert alert-warning alert-dismissible" role="alert">
&			    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			    <strong>Attention : </strong><br />
			    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $errorsGet): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
				<li><?php echo e($errorsGet); ?></li>
			    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
			</div>
		    </div>
		<?php endif; ?>

		<?php if(session('valide')): ?>
		    <div class="bs-errors" data-example-id="dismissible-alert-css">
			<div class="alert alert-success alert-dismissible" role="alert">
			    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			    <strong>Succès : </strong><br />
			    <?php echo e(session('valide')); ?>

			</div>
		    </div>
		<?php endif; ?>

		<?php if(session('erreur')): ?>
		    <div class="bs-errors" data-example-id="dismissible-alert-css">
			<div class="alert alert-warning alert-dismissible" role="alert">
			    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			    <strong>Attention : </strong><br />
			    <?php echo e(session('erreur')); ?>

			</div>
		    </div>
		<?php endif; ?>
		
		<?php echo $__env->yieldContent('content'); ?>
	    </div>
	</div>

	<script src="<?php echo e(asset('js/jquery-1.11.3.min.js')); ?>"></script>
	<script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
	<script src="<?php echo e(asset('js/bootbox.min.js')); ?>"></script>
	<script src="<?php echo e(asset('js/bootstrap-notify.min.js')); ?>"></script>
	<script src="<?php echo e(asset('js/repository.js')); ?>"></script>

	
	<?php if(Request::segment(1) == "action"): ?>
	    <script src="<?php echo e(asset("js/Chart.bundle.min.js")); ?>"></script>
	    <script src="<?php echo e(asset("js/chart/utils.js")); ?>"></script>
	    <script src="<?php echo e(asset("js/chart/action.js")); ?>"></script>
	<?php endif; ?>

	
	<?php if(Request::segment(1) == "budget"): ?>
	    <script src="<?php echo e(asset("js/budget/gestion.js")); ?>"></script>
	    <script src="<?php echo e(asset("js/budget/board.js")); ?>"></script>
	<?php endif; ?>

	
	<?php if(Request::segment(1) == "dashboard"): ?>
	    <script src="<?php echo e(asset("js/dashboard/index.js")); ?>"></script>
	<?php endif; ?>
    </body>
</html>



