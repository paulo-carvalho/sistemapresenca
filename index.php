<!doctype html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Controle de Presença</title>
	<link rel="stylesheet" href="css/foundation.css" />
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	<link rel="icon" href="favicon.ico" type="image/x-icon" />
</head>
<body>
	<br>
	<div class="row">
		<div class="large-4 medium-4 small-12 push-4 columns ">
			<center><a href="<?php echo $_SERVER['PHP_SELF'];?>"><img src="img/logo.png"></a></center>
		</div>
	</div>
	<br>

	<div class="row">
		<div class="large-6 medium-6 small-12 push-3 columns">
			<div class="panel">
				<h3 class="text-center">Login </h3>
				<br>
				<div class="row">
					<div class="large-8 medium-8 small-12 push-2 columns text-center">
						<form>
							<label> Matrícula: <input type="text" pattern="[0-9]{10}" tabindex="1" name="matricula" /> </label>
							<label> Senha: <input type="password" tabindex="2" name="senha"/> </label>
						</div>
					</div>
					<div class="row">
						<div class="large-6 medium-6 small-12 push-6 columns text-right">
							<a href="pages/esquecer_senha.php" style="font-size:11px">Esqueceu sua senha?</a>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="large-12 medium-12 small-12 columns text-center">
							<a href="pages/home.php" class="small round button">Entrar </a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
</body>
	<script src="js/vendor/modernizr.js"></script>
</html>
