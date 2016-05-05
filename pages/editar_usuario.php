<?php
	require_once("connect/testmysql_p.php");

	//VALIDA A SESSÃO
	session_start();

	if(!isset($_SESSION['matricula'])) {
    	header("Location: ../index.php");
	}
	else {
		if(isset($_GET['id']))
			$matr = $_GET['id'];
		else
			$matr = $_SESSION['matricula'];
	}

	$msg_erro = "";
	$msg_sucesso = "";

	if(isset($_SESSION['erro_edicao'])) {
    	$msg_erro = $_SESSION['erro_edicao'];
	}
	$_SESSION['erro_edicao']="";

	//Seleciona a permissão do usuário logado na página
	$sql_controle = "SELECT permissao FROM usuarios WHERE matr=$matr;";
	if (isset($sql_controle)) {
		$controle = mysqli_query($conn, $sql_controle);
	}
	//Armazena o resultado da query acima no array permissao_sessao.
	//O valor fica armazenado na posição permissao_sessao[0]
	$permissao_sessao = mysqli_fetch_row($controle);

	if($permissao_sessao[0] == 3) { //Se o usuário for pós-júnior, não tem acesso ao sistema
		header("Location: ../index.php");
	}

	//QUERIES PARA PREENCHER FORMULÁRIO
	//Pega os dados do usuário a ser editado
	$sql_usuario = "SELECT * FROM usuarios WHERE matr='$matr';";
	if (isset($sql_usuario)) {
		$usuario = mysqli_query($conn, $sql_usuario);
	}

	$sql_diretorias = "SELECT id_diretoria, nome_diretoria FROM diretorias";
	if (isset($sql_diretorias)) {
		$diretorias = mysqli_query($conn, $sql_diretorias);
	}

	$sql_permissoes = "SELECT id_permissoes, nome_permissoes FROM permissoes;";
	if (isset($sql_permissoes)) {
		$permissoes = mysqli_query($conn, $sql_permissoes);
	}


	while ($user = mysqli_fetch_assoc($usuario)) {


?>
<!doctype html>
<html class="no-js" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Editar usuário</title>
	<link rel="stylesheet" href="../css/foundation.css" />
	<script src="../js/vendor/modernizr.js"></script>
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
	<link rel="icon" href="../favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="../foundation-icons/foundation-icons.css" />
	<!-- Foundation-datepicker CSS -->
	<link rel="stylesheet" href="../css/foundation-datepicker.min.css" />
</head>
<body>
	<?php
		require_once("menu/menu.php");
		echo "<br>";
	?>

	<div class="row">
		<div class="large-12 columns">
			<?php
				if($_SESSION['erro_edicao'] != "")
					echo "<div data-alert='' class='alert-box alert'>
							".$_SESSION['erro_edicao']."
						</div>";
				$_SESSION['erro_edicao']="";

				if($_SESSION['sucesso_edicao'] != "")
					echo "<div data-alert='' class='alert-box success'>
							".$_SESSION['sucesso_edicao']."
						</div>";
				$_SESSION['sucesso_edicao']="";
			?>
			<div class="panel">
				<h3 class="text-center"><?php echo $user['nome']?></h3>
				<br>
				<div class="row">

					<div class="large-8 push-2 columns">
						<form id="editar" name="editar" method="post" action="salvar_edicao.php" data-abide>
							<label class="fn"><strong> Número matrícula: </strong><input type="text" id="matr" name="matr" value='<?php echo $user['matr']?>' readonly/> </label>
							<label> Nome Completo: <span style="color: red;">*</span>
								<input type="text"  id="nome" name="nome" value='<?php echo $user['nome']?>' required title="Nome é obrigatório"/> </label>
							<label> Email Pessoal: <span style="color: red;">*</span>
								<input type="email" id="email_pessoal" name="email_pessoal" value='<?php echo $user['email_pessoal']?>' required title="Email pessoal é obrigatório" /> </label>
							<label> Email Profissional:
								<input type="email" d="email_profissional" name="email_profissional" value='<?php echo $user['email_profissional']?>' /> </label>

		    				<div class="row">
    							<div class="large-6 columns" >
									<label>Cargo: <span style="color: red;">*</span>
										<select name="cargo" id="cargo" required title="Cargo é obrigatório">
											<option value='Trainee'<?php if('Trainee' == $user['cargo']) echo "selected"?>>Trainee</option>
											<option value='Diretor'<?php if('Diretor' == $user['cargo']) echo "selected"?>>Diretor</option>
											<option value='Membro'<?php if('Membro' == $user['cargo']) echo "selected"?>>Membro</option>
										</select>
									</label>
		    					</div>
		    					<div class="large-6 columns" >
		    						<label >Diretoria:
										<select name="diretoria" id="diretoria" required title="Diretoria é obrigatório">
		    								<?php
				    							while ($row = mysqli_fetch_assoc($diretorias)) {
				    						?>
				    								<option value='<?php echo $row['id_diretoria']?>'<?php if($row['id_diretoria'] == $user['diretoria']) echo "selected"?>><?php echo $row['nome_diretoria']?></option>
				    						<?php
				    							}
											?>
										</select>
									</label>
								</div>
							</div>

							<div class="row">
    							<div class="large-4 columns" >
    								<label> Ingresso na Faculdade: <span style="color: red;">*</span>
		    							<input type="text" id="ingresso_faculdade" name="ingresso_faculdade"  value='<?php echo $user['ingresso_faculdade']?>' placeholder="Ano/Semestre" pattern="[1-2]{1}[0|9]{1}[0-9]{2}\/[1,2]{1}" title="Insira no formato 2016/1" required />
		    						</label>
		    					</div>
		    					<div class="large-4 columns" >
		    						<label> Ingresso na Empresa: <span data-tooltip aria-haspopup="true" class="has-tip" title="Data de assinatura do termo"><i class="fi-info"> </i></span>
		    							<input type="text" id="ingresso_empresa" name="ingresso_empresa" value='<?php echo $user['ingresso_empresa']?>'  class="fdatepicker" autocomplete="off"  />
		    						</label>
		    					</div>
		    					<div class="large-4 columns" >
		    						<label> Data de desligamento:
		    							<input type="text" id="data_desligamento" name="data_desligamento" value='<?php echo $user['data_desligamento']?>'  class="fdatepicker" autocomplete="off"  />
		    						</label>
		    					</div>

		    				</div>

							<label> Permissão: <span style="color: red;">*</span>
								<select name="permissao" id="permissao" required>
									<?php
		    							while ($row = mysqli_fetch_assoc($permissoes)) {
    								?>
		    								<option value='<?php echo $row['id_permissoes']?>'<?php if($row['id_permissoes'] == $user['permissao']) echo "selected"?>><?php echo $row['nome_permissoes']?></option>
		    						<?php
		    							}
									?>
								</select>
							</label>
							<hr>
							<div class="row">
    							<div class="large-12 columns" >
    								<center><h5 class="subheader">Alterar Senha</h5></center>
		    					</div>
		    				</div>
		    				<div class="row">
    							<div class="large-12 columns" >
									<label> Senha antiga:
										<input type="password" id="senha_antiga" name="senha_antiga"/>
									</label>
								</div>
		    				</div>
							<div class="row">
    							<div class="large-12 columns" >
									<label> Nova senha:
										<input type="password" id="nova_senha" name="senha_nova"/>
									</label>
								</div>
		    				</div>
							<div class="row">
    							<div class="large-12 columns" >
									<label> Confirma a nova senha:
										<input type="password" id="confirma_senha_nova" name="confirma_senha_nova"/>
									</label>
								</div>
		    				</div>

							<div class="row">
								<div class="large-6 columns text-right">
									<a href="listar_usuarios.php" class="small button">Cancelar</a>
								</div>
								<div class="large-6 columns text-left">
									<button type="submit" id="salvar_edicao" class="small button">Salvar edição</button>
								</div>
							</div>
							<br>
						<?php
							}
						?>
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
