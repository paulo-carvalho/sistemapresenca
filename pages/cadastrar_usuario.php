<?php
	require_once("connect/testmysql_p.php");

	$msg_erro = "";
	$msg_sucesso = "";

	//VALIDA A SESSÃO
	session_start();

	if(!isset($_SESSION['matricula'])) {
    	header("Location: ../index.php");
	}
	else {
		$matricula = $_SESSION['matricula'];
	}

	//Seleciona a permissão do usuário logado na página
	$sql_controle = "SELECT permissao FROM usuarios WHERE matr=$matricula;";
	if (isset($sql_controle)) {
		$controle = mysqli_query($conn, $sql_controle);
	}
	//Armazena o resultado da query acima no array permissao_sessao.
	//O valor fica armazenado na posição permissao_sessao[0]
	$permissao_sessao = mysqli_fetch_row($controle);

	if($permissao_sessao[0] == 3) { //Se o usuário for pós-júnior, não tem acesso ao sistema
		header("Location: ../index.php");
	} else if($permissao_sessao[0] != 1) { //Se o usuário não for administrador, não pode cadastrar novo usuário
		header("Location: home.php");
	}

	$nome = "";
	$email_pessoal = "";
	$email_profissional = "";
	$cargo = "";
	$diretoria = "";
	$ingresso_faculdade = "";
	$ingresso_empresa = "";
	$data_desligamento = "";
	$matr = "";
	$permissao = "";
	$facebook = "";
	$linkedin = "";
	

	/* PARAMETROS RECEBIDOS PELO FORMULÁRIO DE CADASTRO*/
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if(isset($_POST['nome']))
			$nome = $_POST['nome'];

		if(isset($_POST['email_pessoal']))
			$email_pessoal = $_POST['email_pessoal'];

		if(isset($_POST['email_profissional']))
			$email_profissional = $_POST['email_profissional'];

		if(isset($_POST['cargo']))
			$cargo = $_POST['cargo'];

		if(isset($_POST['diretoria']))
			$diretoria = $_POST['diretoria'];

		if(isset($_POST['ingresso_faculdade']))
			$ingresso_faculdade = $_POST['ingresso_faculdade'];

		if(isset($_POST['ingresso_empresa']))
			$ingresso_empresa = $_POST['ingresso_empresa'];

		if(isset($_POST['data_desligamento']))
			$data_desligamento = $_POST['data_desligamento'];

		if(isset($_POST['facebook']))
			$facebook = $_POST['facebook'];

		if(isset($_POST['linkedin']))
			$linkedin = $_POST['linkedin'];

		var_dump($facebook, $linkedin);

		if(isset($_POST['matr']))
			$matr = $_POST['matr'];

		if(isset($_POST['permissao']))
			$permissao = $_POST['permissao'];

		$conectado = '0';

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

		//Cadastra novo usuário no banco
		if (isset($sql_cadastrar)) {
			if (mysqli_query($conn, $sql_cadastrar)) {
				$msg_sucesso = "Usuário cadastrado com sucesso!";
				$_SESSION['sucesso_cadastro'] = $msg_sucesso;
				header("Location: ver_usuario.php?id=$matr");
			}
			else
				$msg_erro = 'Erro: ' . mysqli_error($conn);
		}
	}

	//Usado no <select> das diretorias
	$sql_diretorias = "SELECT id_diretoria, nome_diretoria FROM diretorias;";
	if (isset($sql_diretorias)) {
			$diretorias = mysqli_query($conn, $sql_diretorias);
		} else
			echo 'Erro na query sql_diretorias';

	//Usado no <select> das permissões
	$sql_permissoes = "SELECT id_permissoes, nome_permissoes FROM permissoes;";
	if (isset($sql_permissoes)) {
			$permissoes = mysqli_query($conn, $sql_permissoes);
		} else
			echo 'Erro: na query sql_permissoes';

?>
<!doctype html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Cadastro</title>
	<link rel="stylesheet" href="../css/foundation.css" />
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
	<link rel="icon" href="../favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="../foundation-icons/foundation-icons.css" />
	<!-- Foundation-timepicker CSS -->
    <link type="text/css" href="../css/bootstrap.min.css" />
    <link type="text/css" href="../css/bootstrap-timepicker.min.css" />
    <!-- Foundation-datepicker CSS -->
	<link rel="stylesheet" href="../css/foundation-datepicker.min.css" />
</head>
<body>
	<?php
		require_once("menu/menu.php");
	?>

	<br>

	<div class="row">
		<div class="large-12 medium-10 large-push-0 medium-push-1 columns">
			<?php
				if($msg_erro != "")
					echo "<div data-alert='' class='alert-box alert'>
							".$msg_erro."
						</div>";

				if($msg_sucesso != "")
					echo "<div data-alert='' class='alert-box success'>
							".$msg_sucesso."
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
									<input type="text" id="nome" name="nome" required title="Nome é obrigatório" value='<?php echo $nome?>' autocomplete="off" />
								</label>
	    					</div>

							<label for="email"> Email Pessoal: <span style="color: red;">*</span>
								<input type="email" id="email_pessoal" name="email_pessoal" value='<?php echo $email_pessoal?>'required title="Email Pessoal é campo obrigatório" autocomplete="off" />
							</label>

    						<label for="email"> Email Profissional:
								<input type="email" id="email_profissional" name="email_profissional" value='<?php echo $email_profissional?>' autocomplete="off" />
							</label>

							<div class="row">
    							<div class="large-6 columns" >
									<label>Cargo: <span style="color: red;">*</span>
										<select name="cargo" id="cargo" required title="Cargo é um campo obrigatório">
											<option value='Trainee'<?php if('Trainee' == $cargo) echo "selected"?>>Trainee</option>
											<option value='Diretor'<?php if('Diretor' == $cargo) echo "selected"?>>Diretor</option>
											<option value='Membro'<?php if('Membro' == $cargo) echo "selected"?>>Membro</option>
										</select>
									</label>
		    						<small class="error">Cargo é um campo obrigatório.</small>
		    					</div>
		    					<div class="large-6 columns" >
		    						<label for="diretoria">Diretoria:
										<select name="diretoria" id="diretoria" required>
		    								<?php
				    							while ($row = mysqli_fetch_assoc($diretorias)) {
				    						?>
				    								<option value='<?php echo $row['id_diretoria']?>'
				    									<?php
				    										if($diretoria != "") { //Se o form ja foi submetido ainda
				    											if($row['id_diretoria'] == $diretoria) //Deixa selecionado a opcao
				    												echo "selected";
				    										}
				    										else if($row['id_diretoria'] == '6') echo "selected"?>><?php echo $row['nome_diretoria']?></option>
				    						<?php
				    							}
											?>
										</select>
									</label>
								</div>
							</div>


							<div class="row">
    							<div class="large-4 columns" >
		    						<label for="email">  Ingresso na Faculdade: <span style="color: red;">*</span>
										<input type="text"  id="ingresso_faculdade" name="ingresso_faculdade" value='<?php echo $ingresso_faculdade?>' placeholder="Ano/Semestre" pattern="[1-2]{1}[0|9]{1}[0-9]{2}\/[1,2]{1}" title="Insira no formato 2016/1" autocomplete="off"/>
									</label>
		    					</div>
		    					<div class="large-4 columns" >
		    						<label for="email"> Ingresso na Empresa: <span data-tooltip aria-haspopup="true" class="has-tip" title="Data de assinatura do termo"><i class="fi-info"> </i></span>
										<input type="text" id="ingresso_empresa" name="ingresso_empresa" class="fdatepicker" value='<?php echo $ingresso_empresa?>' autocomplete="off" />
									</label>
		    					</div>
		    					<div class="large-4 columns" >
		    						<label for="email"> Data de desligamento:
										<input type="text"  id="data_desligamento" name="data_desligamento" class="fdatepicker" value='<?php echo $data_desligamento?>' autocomplete="off"/>
									</label>
		    					</div>
		    				</div>

		    				<div class="row">
    							<div class="large-6 columns" >
		    						<label for="email">  Facebook:
										<input type="text"  id="facebook" name="facebook" value='<?php echo $facebook?>'
									</label>
		    					</div>
		    					<div class="large-6 columns" >
		    						<label for="email"> Linkedin:
										<input type="text" id="linkedin" name="linkedin" value='<?php echo $linkedin?>' autocomplete="off" />
									</label>
		    					</div>
		    				</div>



							<hr>

							<label> Número de matrícula: <span style="color: red;">*</span>
								<input type="text" name="matr" id="matr" required pattern="[0-9]{10}" title="A matrícula deve possuir 10 caracteres" value='<?php echo $matr?>' autocomplete="off"/>
							</label>

							<label> Permissão: <span style="color: red;">*</span>
								<select name="permissao" id="permissao" required>
									<?php
		    							while ($row = mysqli_fetch_assoc($permissoes)) {
		    						?>
		    								<option value='<?php echo $row['id_permissoes']?>'
		    									<?php
		    										if($row['id_permissoes'] == $permissao) {
		    											echo "selected";}?> > <?php echo $row['nome_permissoes']?></option>
		    						<?php
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
								<input type="password" data-equalto="senha" name="confirm_passw" id="confirm_passw" required title="Senhas devem coincidir" />
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
<?php
	//Encerra a conexão com o banco
	mysqli_close($conn);
?>
</html>
