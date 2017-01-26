<?php $__env->startSection('back'); ?>
    <a href="<?php echo e(url('/')); ?>"><span class="glyphicon glyphicon-arrow-left back" aria-hidden="true"></span></a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contenu'); ?>
	<div class="col-lg">
		<h3><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Aide</h3>
	    <hr />
	    <li class="text-muted">Les dates sont au format jj/mm/aaaa donc par exemple 30/12/2016</li>
	    <hr />
		<form id="decal" action="<?php echo e(url('action/modifier/'.$id)); ?>" method="POST">
			<div class="col-md-6">
				<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
				<div class="form-group">
					<label for="nom">* Nom de l'action : </label>
					<input type="text" name="nom" class="form-control" value="<?php echo e($action->nom); ?>" placeholder="Nom de l'action" /><br />
				</div>

				<div class="form-group">
					<label for="date_creation">* Date de création : </label>
					<input type="text" name="date_creation" class="form-control" value="<?php echo e($action->date_creation); ?>" placeholder="Date de création" /><br />
				</div>
				<div class="form-group">
					<label for="date_butoire">* Date butoire : </label>
					<input type="text" name="date_butoire" class="form-control" value="<?php echo e($action->date_butoire); ?>" placeholder="Date butoire" />
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="date_realisation">Date de réalisation : </label>
					<input type="text" name="date_realisation" class="form-control" value="<?php echo e($action->date_realisation); ?>" placeholder="Date de réalisation" />
				</div>
				<?php if($action->realise == 1): ?>
					<div class="radio">
						<label>
							<input type="radio" name="realise" value="1" checked>
							Réalisé
						</label>
					</div>

					<div class="radio">
						<label>
							<input type="radio" name="realise" value="0">
							Non réalisé
						</label>
					</div>
				<?php else: ?>
					<div class="radio">
						<label>
							<input type="radio" name="realise" value="1">
							Réalisé
						</label>
					</div>

					<div class="radio">
						<label>
							<input type="radio" name="realise" value="0" checked>
							Non réalisé
						</label>
					</div>
				<?php endif; ?>
				<div class="form-group">
					<label for="alertStart">Nombre de jour restant où commencer les alertes : </label>
					<input type="numeric" name="alertStart" class="form-control" value="<?php echo e($action->alertStart); ?>" placeholder="Nombre de jour" />
				</div>

				<?php if($action->alert == 1): ?>
					<div class="radio">
						<label>
							<input type="radio" name="alert" value="1" checked>
							Alerter
						</label>
					</div>
						<div class="radio">
						<label>
							<input type="radio" name="alert" value="0">
							Ne pas alerter
						</label>
					</div>
				<?php elseif($action->alert == 0): ?>
					<div class="radio">
						<label>
							<input type="radio" name="alert" value="1">
							Alerter
						</label>
					</div>

					<div class="radio">
						<label>
							<input type="radio" name="alert" value="0" checked>
							Ne pas alerter
						</label>
					</div>
				<?php else: ?>
					<div class="radio">
						<label>
							<input type="radio" name="alert" value="1" checked>
							Alerter
						</label>
					</div>

					<div class="radio">
						<label>
							<input type="radio" name="alert" value="0">
							Ne pas alerter
						</label>
					</div>
				<?php endif; ?>
				<br />
			</div>
			<div class="col-md-12">
				<hr />
				<input type="submit" class="btn btn-success" value="Valider" />
			</div>
		</form>
	</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>