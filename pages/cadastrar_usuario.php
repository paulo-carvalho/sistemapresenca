<!doctype html>
<?php
	require_once("connect/testmysql_p.php");

	/* PARAMETROS */
	if(isset($_POST['name']))
		$name = $_POST['name'];
	else
		$name = "";

	if(isset($_POST['email']))
		$email = $_POST['email'];
	else
		$email = "";

	if(isset($_POST['cargo']))
		$cargo = $_POST['cargo'];
	else
		$cargo = "";

	if(isset($_POST['setor']))
		$setor = $_POST['setor'];
	else
		$setor = "";

	if(isset($_POST['matricula']))
		$matricula = substr($_POST['matricula'], 2);
	else
		$matricula = "";

	if(isset($_POST['passw']))
		$passw = hash('sha256', $_POST['passw']);
	else
		$passw = "";

	if(isset($_POST['confirm_passw']))
		$confirm_passw = hash('sha256', $_POST['confirm_passw']);
	else
		$confirm_passw = "";

	if($passw != $confirm_passw)
		echo "SENHAS NAO COINCIDEM!";

	if($cargo == "diretor" || ($cargo == "membro" && $setor == "rh"))
		$permissao = "admin";
	else
		$permissao = "comum";

	/* QUERY */
	if($matricula != "")
		$sql = "INSERT INTO usuario VALUES('".$matricula."', '".$name."', '".$email."', '".$cargo."', '".$setor."', '".$passw."', '".$permissao."')";

	/* DEBUG */
	//if(isset($sql))
		//echo $sql;

	/* OPERAÇÃO DE INSERÇÃO */
	$msg_erro = "";
	$msg_sucesso = "";
	if (isset($sql))
		if (!mysqli_query($conn, $sql)) {
	  		//$msg_erro = 'Erro: ' . mysqli_error($con);
	  		$msg_erro = "Não foi possível realizar essa operação.";
		} else {
			$msg_sucesso = "Usuário cadastrado com sucesso!";
		}
	mysqli_close($conn);
?>

<html class="no-js" lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Cadastro</title>
	<link rel="stylesheet" href="../css/foundation.css" />
	<script src="../js/vendor/modernizr.js"></script>
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
	<link rel="icon" href="../favicon.ico" type="image/x-icon" />
</head>
<body>
	<?php
		require_once("menu/menu.html");
	?>

	<br>

	<div class="row">
		<div class="large-12 medium-10 large-push-0 medium-push-1 columns">
			<?php
				if($msg_erro != "")
					echo "<div data-alert='' class='alert-box alert'>
							".$msg_erro."
							<a href='#' class='close'>×</a>
						</div>";

				if($msg_sucesso != "")
					echo "<div data-alert='' class='alert-box success'>
							".$msg_sucesso."
							<a href='#' class='close'>×</a>
						</div>";
			?>
			<div class="panel">
				<h3 class="text-center">Cadastro de novo usuário</h3>
				<br>
				<div class="row">
					<div class="large-8 medium-10 small-12 large-push-2 medium-push-1 columns">
						<form id="cadastro" name="cadastro" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" data-abide>
							
							<label for="name"> Nome Completo: <span style="color: red;">*</span> 
								<input type="text" id="name" name="name" required pattern="[a-zA-Z]+" autocomplete="off" />
							</label>
    						<small class="error">Nome é um campo obrigatório.</small>

							<label for="email"> Email: <span style="color: red;">*</span> 
								<input type="text" id="email" name="email" required pattern="[a-zA-Z]+@[a-zA-Z]+\.[a-zA-z]+" autocomplete="off" />
							</label>
    						<small class="error">E-mail é um campo obrigatório.</small>

							<label for="cargo">Cargo: <span style="color: red;">*</span> 
								<select name="cargo" id="cargo" required>
									<option value="trainee">Trainee</option>
									<option value="diretor">Diretor</option>
									<option value="membro">Membro</option>
								</select>
							</label>
    						<small class="error">Cargo é um campo obrigatório.</small>

							<label for="diretoria">Diretoria:
								<select name="diretoria" id="diretoria">
									<!-- puxar opções do banco e adicionar linha null-->
									<option value="financeiro">Financeiro</option>
									<option value="marketing">Marketing</option>
									<option value="presidencia">Presidência</option>
									<option value="projetos">Projetos</option>
									<option value="rh">Recursos Humanos</option>
								</select>
							</label>

							<hr>

							<label for="matricula"> Número de matrícula: <span style="color: red;">*</span> 
								<input type="text" name="matricula" id="matricula" required pattern="11[0-9]{10}" autocomplete="off"/>
    						<small class="error">Número de matrícula é um campo obrigatório.</small>
							</label>

							<label for="passw"> Senha: <span style="color: red;">*</span> 
								<input type="password" name="passw" id="passw" required/> 
							</label>
    						<small class="error">Senha é um campo obrigatório.</small>

							<label for="confirm_passw"> Confirmar senha: <span style="color: red;">*</span> 
								<input type="password" name="confirm_passw" id="confirm_passw" required /> 
							</label>
    						<small class="error">As senhas devem ser iguais.</small>
						</div>
					</div>

					<br>
					<div class="row">
						<div class="large-12 columns text-center">
							<button type="submit" id="cadastrar" class="small round button">Cadastrar</button>
						</div>
					</div>
				</form>
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

		$('.close').click(function() {
			$(this).parent().fadeOut(500);
		});
	</script>
</body>
</html>
