<?php $__env->startSection('contenu'); ?>
    <div class="pull-left"><div id="decal"><a class="btn btn-sm btn-danger" href="<?php echo e(url('election/brut')); ?>">Données brutes</a></div></div>

    <div class="pull-right"><div id="decal"><a class="btn btn-sm btn-info" href="<?php echo e(url('election/printable')); ?>">Version imprimable</a></div></div>
    
    <br /><br /><hr />
    <h3><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Insérer des inscriptions</h3>
    <hr />
        <form class="form-inline" action="<?php echo e(url('election')); ?>" method="POST">
            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
            <div class="col-md-12">
                <div class="form-group">
                    <input type="text" name="date" class="form-control" id="id" placeholder="Date de l'inscription">
                </div>

                <div class="form-group">
                    <input type="text" name="nb" class="form-control" id="id" placeholder="Nombre d'inscription">
                </div>
                <br /><br />
            </div>

            <div class="col-md-12">
                <div class="radio">
                    <label>
                        <input type="radio" name="type" value="vote" checked>
                        Électorales
                    </label>
                </div>
                &nbsp;
                <div class="radio">
                    <label>
                        <input type="radio" name="type" value="recensement">
                        Recensements
                    </label>
                </div>
            </div>
            <br />
            <br /><br /><br /><br />
            
            <div class="col-md-12">
                <input type="submit" class="btn btn-sm btn-info" value="Insérer">
            </div>
        </form>
    <br /><br />
    <hr />
    <h3><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Inscriptions aux listes électorales par mois et années</h3>
    <hr />
    <table class="table table-striped table-hover table-bordered">
        <tr>
            <th>Année</th>
            <?php for($i = 1; $i <= 12; $i++): ?>
                <th><?php echo e($tempsClass->parseMois($i)); ?></th>
            <?php endfor; ?>
            <th>Total année</th>
        </tr>
        <?php for($a = $carbon->now()->subYear(4)->year; $a <= $carbon->now()->year; $a++): ?>
            <tr>
                <td class="annéeBold"><?php echo e($a); ?></td>
                <?php for($i = 1; $i <= 12; $i++): ?>
                    <td><?php echo e($electionClass->totalVoteNbPerMonth($i, $a)); ?></td>
                <?php endfor; ?>
                <td><b><?php echo e($electionClass->totalVoteNbPerYear($a)); ?></b></td>
            </tr>
        <?php endfor; ?>
    </table>

    <div class="bs-voteNov">
        <p>
            <a id="deroule" role="button" data-toggle="collapse" href="#collapseRecensementNov" aria-expanded="false" aria-controls="collapseRecensementNov"><h4><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Mois de novembre</h4></a>
        </p>
        <div class="collapse" id="collapseRecensementNov">
            <hr />
            <table class="table table-striped table-hover table-bordered">
                <tr>
                    <th>Jour</th>
                    <?php for($a = $carbon->now()->subYear(4)->year; $a <= $carbon->now()->year; $a++): ?>
                        <th class="annéeBold"><?php echo e($a); ?></th>
                    <?php endfor; ?>
                    <th>Total</th>
                </tr>
                <?php for($i = 1; $i <= 30; $i++): ?>
                <tr>
                    <td><b><?php echo e($i); ?></b></td>
                    <?php for($a = $carbon->now()->subYear(4)->year; $a <= $carbon->now()->year; $a++): ?>
                        <td><?php echo e($electionClass->totalVoteNbPerDay($i, 11, $a)); ?></td>
                    <?php endfor; ?>
                    <td><b><?php echo e($electionClass->totalVoteNbPerSpecial($i, 11)); ?></b></td>
                </tr>
                <?php endfor; ?>
            </table>
        </div>
    </div>

    <div class="bs-voteNov">
        <p>
            <a id="deroule" role="button" data-toggle="collapse" href="#collapseRecensementDec" aria-expanded="false" aria-controls="collapseRecensementDec"><h4><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Mois de décembre</h4></a>
        </p>
        <div class="collapse" id="collapseRecensementDec">
            <hr />
            <table class="table table-striped table-hover table-bordered">
                <tr>
                    <th>Jour</th>
                    <?php for($a = $carbon->now()->subYear(4)->year; $a <= $carbon->now()->year; $a++): ?>
                        <th class="annéeBold"><?php echo e($a); ?></th>
                    <?php endfor; ?>
                    <th>Total </th>
                </tr>
                <?php for($i = 1; $i <= 31; $i++): ?>
                <tr>
                    <td><b><?php echo e($i); ?></b></td>
                    <?php for($a = $carbon->now()->subYear(4)->year; $a <= $carbon->now()->year; $a++): ?>
                        <td><?php echo e($electionClass->totalVoteNbPerDay($i, 12, $a)); ?></td>
                    <?php endfor; ?>
                    <td><b><?php echo e($electionClass->totalVoteNbPerSpecial($i, 12)); ?></b></td>
                </tr>
                <?php endfor; ?>
            </table>
        </div>
    </div>
    <hr />
    <h3><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Inscriptions aux recensements par mois et années</h3>
    <hr />
    <table class="table table-striped table-hover table-bordered">
        <tr>
            <th>Année</th>
            <?php for($i = 1; $i <= 12; $i++): ?>
                <th><?php echo e($tempsClass->parseMois($i)); ?></th>
            <?php endfor; ?>
            <th>Total année</th>
        </tr>
        <?php for($a = $carbon->now()->subYear(4)->year; $a <= $carbon->now()->year; $a++): ?>
            <tr>
                <td class="annéeBold"><?php echo e($a); ?></td>
                <?php for($i = 1; $i <= 12; $i++): ?>
                    <td><?php echo e($electionClass->totalRecensementNbPerMonth($i, $a)); ?></td>
                <?php endfor; ?>
                <td><b><?php echo e($electionClass->totalRecensementNbPerYear($a)); ?></b></td>
            </tr>
        <?php endfor; ?>
    </table>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>