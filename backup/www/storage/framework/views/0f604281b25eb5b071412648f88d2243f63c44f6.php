<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="<?php echo e(asset('css/bootstrap.min.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('css/login.css')); ?>" rel="stylesheet">

        <title>Connexion</title>
    </head>
    <body>
	<div class="row">
	    <div class="col-md-3 login">
		<div class="titre"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> GDMC - Connexion</div>
		<form method="POST">
		    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
			
		    <div class="form-group">
			<input type="text" name="compte" class="form-control" value="<?php echo e(old('compte')); ?>" placeholder="Nom du compte" />
		    </div>

		    <div class="form-group">
			<input type="password" name="password" class="form-control" value="<?php echo e(old('compte')); ?>" placeholder="Mot de passe" />
		    </div>

		    <div class="pull-left">
			<div class="checkbox">
			    <label>
				<input type="checkbox" name="remember"> Mémoriser 
			    </label>
			</div>
		    </div>
			
		    <div class="pull-right">
			<input type="submit" class="btn btn-md btn-info" value="Connexion" />
		    </div>
		</form>
	    </div>
	</div>

	<script src="<?php echo e(asset('js/jquery-1.11.3.min.js')); ?>"></script>
	<script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
	<script src="<?php echo e(asset('js/repository.js')); ?>"></script>
    </body>
</html>
