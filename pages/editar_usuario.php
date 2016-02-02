<!doctype html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Editar Usuário</title>
	<link rel="stylesheet" href="../css/foundation.css" />
	<link rel="stylesheet" href="../css/menu.css" />

	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
	<link rel="icon" href="../favicon.ico" type="image/x-icon" />
</head>
<body>
	<?php
		require_once("menu/menu.html");
	?>

	<br>

	<div class="row">
		<div class="large-12 medium-10 columns">
			<div class="panel">
				<h3 class="text-center">Editar usuário</h3>

				<br>

				<div class="row">
					<div class="large-8 medium-10 large-push-2 medium-push-1 columns">
						<form>
						<label> Nome Completo: <input type="text" id="name" value="Gabriela Brant Alves"/> </label>
						<label> Email: <input type="text" id="email" value="gabibrantalves@gmail.com"/> </label>
						<label>Cargo:
							<select>
								<option value="trainee">Trainee</option>
								<option value="diretor">Diretor</option>
								<option value="membro">Membro</option>
							</select>
						</label>
						<label>Setor:
							<select>
								<option value="financeiro">Financeiro</option>
								<option value="marketing">Marketing</option>
								<option value="presidencia">Presidência</option>
								<option value="projetos">Projetos</option>
								<option value="rh">Recursos Humanos</option>
							</select>
						</label>
						<label> Número matrícula: <input type="text" id="matricula" value="2013062901" disabled /> </label>
						<label> Senha: <input type="password" id="passw" disabled/> </label>
						<label> Confirmar senha: <input type="password" id="confirm_passw" disabled/> </label>
						<div class="row">
							<div class="large-12 columns text-center">
								<a href="lista_usuarios.html" class="small round button">Editar </a>
							</div>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

	<script src="../js/vendor/modernizr.js"></script>
	<script src="../js/vendor/jquery.js"></script>
	<script src="../js/foundation/foundation.js"></script>
	<script src="../js/foundation/foundation.topbar.js"></script>
	<script type="text/javascript">
		$(document).foundation();
	</script>
</body>
</html>
