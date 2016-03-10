<?php
	require_once("connect/testmysql_p.php");

	$msg_erro = "";
	$msg_sucesso = "";

	//VALIDA A SESSÃO
	session_start();

	if(!isset($_SESSION['matricula']))
    	header("Location: ../index.php");
    else
    	$matricula = $_SESSION['matricula'];

	/* PARAMETROS */
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if(isset($_POST['evento']))
			$evento = $_POST['evento'];
		else
			$evento = "";

		if(isset($_POST['inicio']))
			$inicio = $_POST['inicio'];
		else
			$inicio = "";

		if(isset($_POST['fim']))
			$fim = $_POST['fim'];
		else
			$fim = "";

		if(isset($_POST['obs']))
			$obs = $_POST['obs'];
		else
			$obs = "";

		$sql_verifica = "SELECT * FROM horarios WHERE matr_usuario=$matricula;";

		$sql_cadastrar_evento = "INSERT INTO evento (nome_evento, data_inicio, data_fim, observacoes, matr) VALUES ('$evento', STR_TO_DATE('$inicio', '%d/%m/%Y %h:%i'), STR_TO_DATE('$fim', '%d/%m/%Y %h:%i'), '$obs', '$matricula'); ";


		if (isset($sql_cadastrar_evento)) {
			if (mysqli_query($conn, $sql_cadastrar_evento)) {
					$msg_sucesso = "Evento Cadastrado!";
				}
				else
					//$msg_erro = "Erro ao atualizar os horários!";
					$msg_erro = 'Erro: ' . mysqli_error($conn);
			}
		}

		//$count = mysqli_num_rows($result_sql_verifica);
?>

<!doctype html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Lançamento de horas não-presenciais</title>
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
				<h3 class="text-center">Horários</h3>
				<br>
				<div class="row">
					<div class="large-8 medium-10 small-12 large-push-2 medium-push-1 columns">
						<h4 class="text-center">Horários Não Presenciais</h4>
						<br>
						<form id="nao_presencial" name="nao_presencial" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" data-abide>    

							<label> Evento: <span style="color: red;">*</span> 
								<input type="text" id="evento" name="evento" required/> 
							</label>
							<div class="row">		
								<div class="large-6 columns">
									<label> Início: <span style="color: red;">*</span> 
										<input type="text" id="inicio" name="inicio" class="fdatepicker" required/> 
									</label>
								</div>
								<div class="large-6 columns">
									<label> Fim: <span style="color: red;">*</span> 
										<input type="text" id="fim" name="fim" class="fdatepicker" required/> 
									</label>
								</div>
							</div>
							<div class="row">		
								
							</div>
							
							<label> Observações: <textarea id="obs" name="obs" form="nao_presencial" rows="10"></textarea> </label>		
					</div>

					<br>

					<div class="row">
						<div class="large-12 columns text-center">
							<button type="submit" id="enviar" class="small round button">Enviar</button>
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
	<!-- Datepicker para campos com data. Repositorio: https://github.com/najlepsiwebdesigner/foundation-datepicker -->
	<script src="../js/foundation-datepicker/foundation-datepicker.min.js"></script>
	<script src="../js/foundation-datepicker/locales/foundation-datepicker.pt-br.js"></script>
	<script type="text/javascript">
		$(document).foundation();
		$('.fdatepicker').fdatepicker({
		language: 'pt-br', //versao brasileira de foundation-datepicker
		format: 'dd/mm/yyyy hh:ii',
		pickTime: true
	});
	</script>
</body>
<?php
	//Encerra a conexão com o banco
	mysqli_close($conn);
?>
</html>
