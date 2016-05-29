<?php
	require_once("connect/testmysql_p.php");

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
	}

	$msg_sucesso = "";

	if(isset($_SESSION['sucesso_cadastro'])) {
    	$msg_sucesso = $_SESSION['sucesso_cadastro'];
	} else if(isset($_SESSION['msg_edicao']) && $_SESSION['msg_edicao'] == 0) {
    	$msg_sucesso = "Usuário alterado com sucesso!";
	}
	
	unset($_SESSION['sucesso_cadastro']);
	unset($_SESSION['msg_edicao']);

	$matr = $_GET['id'];

	$sql_usuario = "SELECT * FROM usuarios WHERE matr='$matr';";
	if (isset($sql_usuario)) {
		$result = mysqli_query($conn, $sql_usuario);
	}

	$sql_diretoria = "SELECT nome_diretoria FROM usuarios JOIN diretorias ON diretoria=id_diretoria WHERE matr='$matr';";
	if (isset($sql_diretoria)) {
		$result2 = mysqli_query($conn, $sql_diretoria);
	} else
		echo 'Erro: ' . mysqli_error($conn);

	while ($row = mysqli_fetch_assoc($result2)) {
		$nome_diretoria = $row['nome_diretoria'];
	}

	$sql_permissao = "SELECT nome_permissoes FROM usuarios JOIN permissoes ON permissao=id_permissoes WHERE matr='$matr';";
	if (isset($sql_permissao)) {
		$result3 = mysqli_query($conn, $sql_permissao);
	} else
		echo 'Erro: ' . mysqli_error($conn);

	while ($row = mysqli_fetch_assoc($result3)) {
		$nome_permissao = $row['nome_permissoes'];
	}

	while ($row = mysqli_fetch_assoc($result)) {


?>

<!doctype html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Ver usuário</title>
	<link rel="stylesheet" href="../css/foundation.css" />
	<script src="../js/vendor/modernizr.js"></script>
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
	<link rel="icon" href="../favicon.ico" type="image/x-icon" />
</head>
<body>
	<?php
		require_once("menu/menu.php");
		echo "<br>";
	?>

	<div class="row">
		<div class="large-12 columns">
			<?php
				if(!empty($msg_sucesso))
					echo "<div data-alert='' class='alert-box success'>
							".$msg_sucesso."
						</div>";
				$msg_sucesso = "";
			?>
			<div class="panel">
				<h3 class="text-center"><?php echo $row['nome']?></h3>
				<h5 class="text-center"><small>Usuário criado em <?php echo $row['data_criacao']?></small></h5>
				<br>
				<div class="row">

					<div class="large-8 push-2 columns">

						<form>
							<label class="fn"><strong> Número matrícula: </strong><input type="text" id="matricula" value='<?php echo $row['matr']?>' disabled /> </label>
							<label> Nome Completo: <input type="text" id="name" value='<?php echo $row['nome']?>' disabled/> </label>
							<label> Email Pessoal: <input type="text" id="email" value='<?php echo $row['email_pessoal']?>' disabled/> </label>
							<label> Email Profissional: <input type="text" id="email" value='<?php echo $row['email_profissional']?>' disabled/> </label>

							<div class="row">
    							<div class="large-6 columns" >
									<label>Cargo:
										<select disabled>
											<option value="" ><?php echo $row['cargo']?></option>
										</select>
									</label>
		    					</div>
		    					<div class="large-6 columns" >
		    						<label >Diretoria:
										<select disabled>
											<option value=""><?php echo $nome_diretoria?></option>
										</select>
									</label>
								</div>
							</div>

							<div class="row">
    							<div class="large-4 columns" >
		    						<label> Ingresso na Faculdade: <input type="text" value='<?php echo $row['ingresso_faculdade']?>' disabled/></label>
		    					</div>
		    					<div class="large-4 columns" >
		    						<label> Ingresso na Empresa Júnior: <input type="text" value='<?php echo $row['ingresso_empresa']?>' disabled/> </label>
		    					</div>
		    					<div class="large-4 columns" >
		    						<label> Data de desligamento: <input type="text" value='<?php echo $row['data_desligamento']?>' disabled/> </label>
		    					</div>
		    				</div>



							<?php
								//Apenas o administrador pode ver a permissão do usuário
								if($permissao_sessao[0] == 1) {
							?>
									<label >Permissão:
										<select disabled>
											<option value=""><?php echo $nome_permissao?></option>
										</select>
									</label>
							<?php
								}
							?>

							<br>
							<div class="row">
								<div class="large-6 columns text-right">
									<a href="listar_usuarios.php"class="small button">Voltar</a>
								</div>

							<?php
								//Apenas o administrador pode Editar o usuário
								if($permissao_sessao[0] == 1) {
							?>

								<div class="large-6 columns text-left">
									<a href="editar_usuario.php?id=<?php echo $matr?>"class="small button">Editar usuário</a>
								</div>

							<?php
								}
							?>


							</div>
						</form>
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
</body>
<?php
	//Encerra a conexão com o banco
	mysqli_close($conn);
?>
</html>
