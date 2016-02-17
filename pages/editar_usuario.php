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

	$matr = $_GET['id'];
	//echo $matr;

	//DADOS FORMULÁRIO	
	$sql_usuario = "SELECT * FROM usuarios WHERE matr='$matr';";
	$sql_diretoria = "SELECT nome_diretoria FROM usuarios JOIN diretorias ON diretoria=id_diretoria WHERE matr='$matr';";

	if (isset($sql_usuario)) {	
		$result = mysqli_query($conn, $sql_usuario);
	}
	
	if (isset($sql_diretoria)) {	
		$result2 = mysqli_query($conn, $sql_diretoria);
	} else
		echo 'Erro: sql_diretoria';

	while ($row = mysqli_fetch_assoc($result2)) {
		$nome_diretoria = $row['nome_diretoria'];
	}

	while ($row = mysqli_fetch_assoc($result)) {
						

?>
<!doctype html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Editar usuário</title>
	<link rel="stylesheet" href="../css/foundation.css" />
	<script src="../js/vendor/modernizr.js"></script>
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
	<link rel="icon" href="../favicon.ico" type="image/x-icon" />
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
			<div class="panel">
				<h3 class="text-center"><?php echo $row['nome']?></h3>
				<br>
				<div class="row">

					<div class="large-8 push-2 columns">
						<form id="editar" name="editar" method="post" action="salvar_edicao.php" data-abide>
							<label class="fn"><strong> Número matrícula: </strong><input type="text" id="matricula" value='<?php echo $row['matr']?>' /> </label> 
							<label> Nome Completo: <input type="text" value='<?php echo $row['nome']?>' id="name" /> </label>
							<label> Email Pessoal: <input type="email" value='<?php echo $row['email_pessoal']?>' id="email_pessoal" name="email_pessoal" /> </label>
							<label> Email Profissional: <input type="email" value='<?php echo $row['email_profissional']?>' id="email_profissional" name="email_profissional" /> </label>
							
							<div class="row">
    							<div class="large-6 columns" >
		    						<label> Ingresso na faculdade: <input type="text" value='<?php echo $row['ingresso_faculdade']?>' id="ingresso_faculdade" name="ingresso_faculdade" placeholder="Ano/Semestre" pattern="[1-2]{1}[0|9]{1}[0-9]{2}\/[1,2]{1}" title="Insira no formato 2016/1" /></label>
		    					</div>
		    					<div class="large-6 columns" >
		    						<label> Ingresso na Empresa Júnior: <input type="text" value='<?php echo $row['ingresso_empresa']?>' id="ingresso_empresa" name="ingresso_empresa" class="fdatepicker" autocomplete="off"  /> </label>
		    					</div>
		    				</div>

		    				<div class="row">
    							<div class="large-6 columns" >
									<label>Cargo: 
										<select>
											<option value="" ><?php echo $row['cargo']?></option>
										</select>
									</label>
		    					</div>
		    					<div class="large-6 columns" >
		    						<label >Diretoria:
										<select>
											<option value=""><?php echo $nome_diretoria?></option>
										</select>
									</label>
								</div>
							</div>

							<div class="row">
								<div class="large-12 columns text-center">
									<button type="submit" id="salvar_edicao" class="small round button">Salvar edição</button>
									<a href="listar_usuarios.php" class="small round button">Cancelar</a>
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
