<?php $__env->startSection('head'); ?>
    Actions planifiées
<?php $__env->stopSection(); ?>

<?php $__env->startSection('meta'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="action">
	<?php echo $__env->make('action.list', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

	<div class="droite col-md-9">
	    <div class="titre">
		tableau de bord des actions planifiées
	    </div>

	    <div class="col-md-4">
		<h3>Comparatif des actions</h3>
		<div class="inner">
		    <div id="canvas-holder"><canvas id="chart-action" /></div>
		</div>
	    </div>

	    <div class="col-md-8">
		<h3>Statistique annuelle des actions</h3>
		<div class="inner">
		    <div id="canvas-holder"><canvas id="chart-action2" /></div>
		</div>
	    </div>

	    <div class="col-md-12">
		<h3>Statistique globale des actions planifiées</h3>
		<div class="inner">
		    <table class="table table-hover table-striped table-bordered table-stats">
			<tr>
			    <th class="col-md-4">Catégorie</th>
			    <th class="col-md-8">Donnée</th>
			</tr>

			<tr>
			    <td class="categorie">Nombre d'actions réalisés</td>
			    <td class="value"><action-realise></action-realise></td>
			</tr>

			<tr>
			    <td class="categorie">Nombre d'actions non réalisés</td>
			    <td class="value"><action-non-realise></action-non-realise></td>
			</tr>

			<tr>
			    <td class="categorie">Total</td>
			    <td class="value"><action-total></action-total></td>
			</tr>
		    </table>
		</div>
	    </div>
	</div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>