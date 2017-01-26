<?php $__env->startSection('head'); ?>
    Actions planifiées
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="action">
	<div class="gauche col-md-3">
	    <div class="search">
		<form method="POST" action="<?php echo e(url('')); ?>">
		    <div class="form-group">
			<input type="text" name="search" class="form-control" placeholder="Recherche ...">
		    </div>
		</form>
	    </div>

	    <div class="action-add text-center">
		<button id="add" class="live"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button>
	    </div>

	    <div class="list"><div class="pull-right"><button id="edit" class="live" data-attribute="1"><span class="glyphicon glyphicon-edit" aria-hidden="true"></button></a></div><a href="#" data-attribute="1"><li>Faire truc et truc</li></a></div>
		<div class="list"><div class="pull-right"><button id="edit" class="live" data-attribute="2"><span class="glyphicon glyphicon-edit" aria-hidden="true"></button></a></div><a href="#" data-attribute="2"><li>Faire truc et truc</li></a></div>
	</div>

	<div class="droite col-md-9">
	    <div class="titre">
		Faire truc et truc
	    </div>

	    <div class="col-md-3">
		<h4>Date de création<div class="pull-right"><a href="#"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></div></h4>
		<div class="inner action-info">
		    10/10/2016
		</div>
	    </div>

	    <div class="col-md-3">
		<h4>Date de réalisation<div class="pull-right"><a href="#"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></div></h4>
		<div class="inner action-info">
		    10/10/2016
		</div>
	    </div>

	    <div class="col-md-3">
		<h4>Date butoire<div class="pull-right"><a href="#"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></div></h4>
		<div class="inner action-info">
		    10/10/2016
		</div>
	    </div>

	    <div class="col-md-3">
		<h4>Jours restant<div class="pull-right"><a href="#"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></div></h4>
		<div class="inner action-info">
		    18 jours
		</div>
	    </div>

	    <div class="col-md-12">
		<div class="col-md-12">
		    <br />
		    <div class="pull-left">
			<a href="#" class="btn btn-md btn-success">recevoir une alerte</a> <a href="#" class="btn btn-md btn-danger">ne pas recevoir d'alertes</a>
		    </div>

		    <div class="pull-right">
			<a href="#" class="btn btn-md btn-danger">Supprimer</a>
		    </div>
		</div>
	    </div>
	</div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>