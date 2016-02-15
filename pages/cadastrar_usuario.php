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

	if(isset($_POST['ingresso_empresa']))
		$ingresso_empresa = $_POST['ingresso_empresa'];
	else
		$ingresso_empresa = "";

	if(isset($_POST['matr']))
		$matr = $_POST['matr'];
	else
		$matr = "";

	if(isset($_POST['permissao']))
		$permissao = $_POST['permissao'];
	else
		$permissao = "";

	$conectado = '0';
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
			$sql_cadastrar = "INSERT INTO usuarios (matr, nome, senha, email_pessoal, email_profissional, diretoria, cargo, ingresso_faculdade, ingresso_empresa, permissao, conectado, data_criacao, data_desligamento) VALUES('".$matr."', '".$nome."', '".$senha."', '".$email_pessoal."', '".$email_profissional."', '".$diretoria."', '".$cargo."', '".$ingresso_faculdade."', '".$ingresso_empresa."', '".$permissao."', '".$conectado."',   NOW() , '".$data_desligamento."');";
		}
	}
		 

	/* OPERAÇÃO DE INSERÇÃO */
	if (isset($sql_cadastrar)) {
		if (mysqli_query($conn, $sql_cadastrar)) {
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
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
	<link rel="icon" href="../favicon.ico" type="image/x-icon" />
	<!-- Foundation-timepicker CSS -->
    <link type="text/css" href="../css/bootstrap.min.css" />
    <link type="text/css" href="../css/bootstrap-timepicker.min.css" />
    <!-- Foundation-datepicker CSS -->
	<link rel="stylesheet" href="../css/foundation-datepicker.min.css" />
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

  							<div class="name-field">
								<label for="name"> Nome Completo: <span style="color: red;">*</span> 
									<input type="text" id="nome" name="nome" required autocomplete="off" />
								</label>
	    						<small class="error">Nome é um campo obrigatório.</small>
	    					</div>

							<label for="email"> Email Pessoal: <span style="color: red;">*</span> 
								<input type="email" id="email_pessoal" name="email_pessoal" required autocomplete="off" />
							</label>
    						<small class="error">E-mail Pessoal é um campo obrigatório.</small>

    						<label for="email"> Email Profissional: 
								<input type="email" id="email_profissional" name="email_profissional" autocomplete="off" />
							</label>

							<div class="row">
    							<div class="large-6 columns" >
		    						<label for="email"> Ingresso na faculdade: <span style="color: red;">*</span> 
										<input type="text"  id="ingresso_faculdade" name="ingresso_faculdade" placeholder="Ano/Semestre" pattern="[1-2]{1}[0|9]{1}[0-9]{2}\/[1,2]{1}" title="Insira no formato 2016/1" />
									</label>
		    						<small class="error">Ingresso na faculdade é um campo obrigatório.</small>

		    					</div>
		    					<div class="large-6 columns" >
		    						<label for="email"> Ingresso na Empresa Júnior:
										<input type="text" id="ingresso_empresa" name="ingresso_empresa" class="fdatepicker" autocomplete="off" />
									</label>
		    						<small class="error">Ingresso na Empresa Júnior é um campo obrigatório.</small>
		    					</div>
		    				</div>

    						<div class="row">
    							<div class="large-6 columns" >
									<label for="cargo">Cargo: <span style="color: red;">*</span> 
										<select name="cargo" id="cargo" required>
											<option value="Trainee">Trainee</option>
											<option value="Diretor">Diretor</option>
											<option value="Membro">Membro</option>
										</select>
									</label>
		    						<small class="error">Cargo é um campo obrigatório.</small>
		    					</div>
		    					<div class="large-6 columns" >
		    						<label for="diretoria">Diretoria:
										<select name="diretoria" id="diretoria" required>
											<option value=" "> </option>
		    								<?php 
				    							while ($row = mysqli_fetch_assoc($diretorias)) {		
				    								echo("<option value='".$row['id_diretoria']."'>".$row['nome_diretoria']."</option>");
				    							}				
											?> 
										</select>
									</label>
								</div>
							</div>

							<hr>

							<label for="matricula"> Número de matrícula: <span style="color: red;">*</span> 
								<input type="text" name="matr" id="matr" required pattern="[0-9]{10}" title="A matrículo deve possuir 10 caracteres" autocomplete="off"/>
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
    						<small class="error">Permissão é um campo obrigatório.</small>

							<label for="passw"> Senha: <span style="color: red;">*</span> 
								<input type="password" name="senha" id="senha" pattern=".{6,}" title="Insira seis ou mais caracteres" required/> 
							</label>
    						<small class="error">Senha é um campo obrigatório.</small>

							<label for="confirm_passw"> Confirmar senha: <span style="color: red;">*</span> 
								<input type="password" data-equalto="senha" name="confirm_passw" id="confirm_passw" required /> 
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
	<script type="text/javascript">
		$(document).foundation();
	</script>
	
	<!-- Datepicker para campos com data. Repositorio: https://github.com/najlepsiwebdesigner/foundation-datepicker -->
	<script src="../js/foundation-datepicker/foundation-datepicker.min.js"></script>
	<script src="../js/foundation-datepicker/locales/foundation-datepicker.pt-br.js"></script>
	<script type="text/javascript">
	$('.fdatepicker').fdatepicker({
		language: 'pt-br', //versao brasileira de foundation-datepicker
		format: 'dd/mm/yyyy'
	});
	</script>
</body>
</html>
