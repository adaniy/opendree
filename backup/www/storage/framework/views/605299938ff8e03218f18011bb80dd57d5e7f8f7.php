<?php $__env->startSection('contenu'); ?>
    <div class="col-lg">
        <h3><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Aide</h3>
        <hr />
        <li class="text-muted">Les actions en rouge sont les actions générant une alerte.</li>
        <li class="text-muted">Les actions en vert sont les actions réalisée.</li>
        <li class="text-muted">Ce programme se rafraichis automatiquement toute les deux heures. Les alertes sont envoyées en même temps.</li>
        <hr />
        <h3><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Liste des actions planifiées</h3>
        <hr />
        <div id="decal"><div class="pull-left"><a class="btn btn-sm btn-info" href="<?php echo e(url('action/ajout')); ?>">Ajouter une action</a></div></div>
        <br /><br />
        <?php if($action->count() > 0): ?>
        <table class="table table-striped table-hover table-bordered">
            <tr>
                <th class="col-lg-6 col-sm-3">Nom</th>
                <th class="col-lg-1 col-sm-2">Date de création</th>
                <th class="col-lg-1 col-sm-2">Date de réalisation</th>
                <th class="col-lg-1 col-sm-2">Date butoire</th>
                <th class="col-lg-1 col-sm-1">Jours restant</th>
                <th class="col-lg-2 col-sm-4">Action</th>
            </tr>
            
                <?php $__currentLoopData = $action; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $actions): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <?php if($actionClass->canAlertBoolean($actions->id) == 1): ?>
                        <tr class="danger">
                    <?php elseif($actions->realise == 1): ?>
                        <tr class="success">
                    <?php else: ?>
                        <tr>                    
                    <?php endif; ?>
                    <td class="nom"><?php echo e($actions->nom); ?></td>
                    <td><?php echo e($temps->parseDate($actions->date_creation)); ?></td>
                    <?php if(!empty($actions->date_realisation)): ?>
                        <td><?php echo e($temps->parseDate($actions->date_realisation)); ?></td>
                    <?php else: ?>
                        <td>N/A</td>
                    <?php endif; ?>
                    <td><?php echo e($temps->parseDate($actions->date_butoire)); ?></td>
                    <?php if($actions->realise == 1): ?>
                        <td>FAIT</td>
                    <?php else: ?>
                        <?php if($carbon->createFromFormat('d/m/Y', $actions->date_butoire) < $carbon->now()): ?>
                            <td>DÉPASSÉ</td>
                        <?php else: ?>
                            <td><?php echo e($actionClass->diffDays($actions->date_butoire)); ?> jours</td>
                        <?php endif; ?>
                    <?php endif; ?>
                    <td>
                    <a class="btn btn-xs btn-success" href="<?php echo e(url('action/modifier/'.$actions->id)); ?>">Modifier</a>
                    <a class="btn btn-xs btn-danger" href="<?php echo e(url('action/supprimer/'.$actions->id)); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette action ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
        </table>
        <hr />
        <?php else: ?>
            <div id="decal"><b>Il n'existe aucune action dans la base de donnée actuellement.</b></div>
            <hr />
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>