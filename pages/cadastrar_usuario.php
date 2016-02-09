<!doctype html>
<?php
	require_once("connect/testmysql_p.php");

	$msg_erro = "";
	$msg_sucesso = "";

	/* PARAMETROS */
	if(isset($_POST['nome']))
		$nome = $_POST['nome'];
	else
		$nome = "";

	if(isset($_POST['email_pessoal']))
		$email_pessoal = $_POST['email_pessoal'];
	else
		$email_pessoal = "";

	if(isset($_POST['email_profissional']))
		$email_profissional = $_POST['email_profissional'];
	else
		$email_profissional = "";

	if(isset($_POST['cargo']))
		$cargo = $_POST['cargo'];
	else
		$cargo = "";

	if(isset($_POST['diretoria']))
		$diretoria = $_POST['diretoria'];
	else
		$diretoria = "";

	if(isset($_POST['ingresso_faculdade']))
		$ingresso_faculdade = $_POST['ingresso_faculdade'];
	else
		$ingresso_faculdade = "";

	if(isset($_POST['matr']))
		$matr = $_POST['matr'];
	else
		$matr = "";

	if(isset($_POST['permissao']))
		$permissao = $_POST['permissao'];
	else
		$permissao = "";

	$conectado = '0';	
	$data_criacao='0'; 
	$data_desligamento = '0';


	if(isset($_POST['senha']))
		$senha = hash('sha256', $_POST['senha']);
	else
		$senha = "";

	if(isset($_POST['confirm_passw']))
		$confirm_passw = hash('sha256', $_POST['confirm_passw']);
	else
		$confirm_passw = "";

	$fail=FALSE; //flag para verificar se continua com o cadastro;

	//Verifica se existe um usuário com a mesma matrícula no banco
	$matricula = "SELECT matr FROM usuarios;";
	$result_matricula = mysqli_query($conn, $matricula);
	while ($row = mysqli_fetch_assoc($result_matricula)) {
		if($matr == $row['matr']) {
			$fail=TRUE; 
			$msg_erro = "Usuário já cadastrado!";;
		}
	}		


	if ($fail != TRUE) {
		//Se as senhas não coincidirem, exibe mensagem de erro. 
		if($senha != $confirm_passw) {
			$msg_erro = "Senhas não coincidem.";
		}
		else {	
			$sql = "INSERT INTO usuarios (matr, nome, senha, email_pessoal, email_profissional, diretoria, cargo, permissao, conectado, ingresso_faculdade, data_criacao, data_desligamento) VALUES('".$matr."', '".$nome."', '".$senha."', '".$email_pessoal."', '".$email_profissional."', '".$diretoria."', '".$cargo."', '".$permissao."', '".$conectado."', '".$ingresso_faculdade."', '".$data_criacao."', '".$data_desligamento."');";
		}
	}
		 

	/* DEBUG */
	//if(isset($sql))
		//echo $sql;

	/* OPERAÇÃO DE INSERÇÃO */
	if (isset($sql)) {
		if (!mysqli_query($conn, $sql)) {
	  		$msg_erro = 'Erro: ' . mysqli_error($conn);
	  		//$msg_erro = "Erro ao inserir no banco.";
		} else {
			$msg_sucesso = "Usuário cadastrado com sucesso!";
		}
	}

	//Será usado no select das diretorias
	$sql_diretorias = "SELECT id_diretoria, nome_diretoria FROM diretorias;";
	if (isset($sql_diretorias)) {	
			$diretorias = mysqli_query($conn, $sql_diretorias);
		} else
			echo 'Erro na query sql_diretorias';

	//Será usado no select das permissões
	$sql_permissoes = "SELECT id_permissoes, nome_permissoes FROM permissoes;";
	if (isset($sql_permissoes)) {	
			$permissoes = mysqli_query($conn, $sql_permissoes);
		} else
			echo 'Erro: na query sql_permissoes';

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
								<input type="text" id="nome" name="nome"  autocomplete="off" />
							</label>
    						<small class="error">Nome é um campo obrigatório.</small>

							<label for="email"> Email Pessoal: <span style="color: red;">*</span> 
								<input type="text" id="email_pessoal" name="email_pessoal" required pattern="[a-zA-Z]+@[a-zA-Z]+\.[a-zA-z]+" autocomplete="off" />
							</label>
    						<small class="error">E-mail Pessoal é um campo obrigatório.</small>

    						<label for="email"> Email Profissional: 
								<input type="text" id="email_profissional" name="email_profissional" required pattern="[a-zA-Z]+@[a-zA-Z]+\.[a-zA-z]+" autocomplete="off" />
							</label>

    						<label for="email"> Ingresso na faculdade: <span style="color: red;">*</span> 
								<input type="text" id="ingresso_faculdade" name="ingresso_faculdade" autocomplete="off" />
							</label>
    						<small class="error">Ingresso é um campo obrigatório.</small>

							<label for="cargo">Cargo: <span style="color: red;">*</span> 
								<select name="cargo" id="cargo" required>
									<option value="Trainee">Trainee</option>
									<option value="Diretor">Diretor</option>
									<option value="Membro">Membro</option>
								</select>
							</label>
    						<small class="error">Cargo é um campo obrigatório.</small>

    						<label for="diretoria">Diretoria:
								<select name="diretoria" id="diretoria">
    								<?php 
		    							while ($row = mysqli_fetch_assoc($diretorias)) {		
		    								echo("<option value='".$row['id_diretoria']."'>".$row['nome_diretoria']."</option>");		
		    							}				
									?> 
								</select>
							</label>

							<hr>

							<label for="matricula"> Número de matrícula: <span style="color: red;">*</span> 
								<input type="text" name="matr" id="matr" autocomplete="off"/>
    						<small class="error">Número de matrícula é um campo obrigatório.</small>
							</label>

							<label for="matricula"> Permissão: <span style="color: red;">*</span> 
								<select name="permissao" id="permissao" required>
									<?php 
		    							while ($row = mysqli_fetch_assoc($permissoes)) {		
		    								echo("<option value='".$row['id_permissoes']."'>".$row['nome_permissoes']."</option>");		
		    							}				
									?> 
								</select>
							</label>
    						<small class="error">Cargo é um campo obrigatório.</small>

							<label for="passw"> Senha: <span style="color: red;">*</span> 
								<input type="password" name="senha" id="senha" required/> 
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
