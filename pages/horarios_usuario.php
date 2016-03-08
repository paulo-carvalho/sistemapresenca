<!doctype html>
<?php
	require_once("connect/testmysql_p.php");

	session_start();

	if(!isset($_SESSION['matricula']))
    	header("Location: ../index.php");
    else
    	$matricula = $_SESSION['matricula'];

	$msg_erro = "";
	$msg_sucesso = "";

	/* PARAMETROS */
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if(isset($_POST['horario1']))
			$horario1 = $_POST['horario1'];
		else
			$horario1 = "";

		if(isset($_POST['horario2']))
			$horario2 = $_POST['horario2'];
		else
			$horario2 = "";

		if(isset($_POST['dia_horario1']))
			$dia_horario1 = $_POST['dia_horario1'];
		else
			$dia_horario1 = "";

		if(isset($_POST['dia_horario2']))
			$dia_horario2 = $_POST['dia_horario2'];
		else
			$dia_horario2 = "";

		$sql_verifica = "SELECT * FROM horarios WHERE matr_usuario=$matricula;";


		if (isset($sql_verifica)) {
			$result_sql_verifica = mysqli_query($conn, $sql_verifica);
		}

		$count = mysqli_num_rows($result_sql_verifica);

		//Se não houverem registros na tabela horários para esse usuário, insere novos dados. 
		if($count == 0) {
			$sql_horario1 = "INSERT INTO horarios (matr_usuario, dia_semana, horario) VALUES ('".$matricula."', '".$dia_horario1."', '".$horario1."'); ";
			$sql_horario2 = "INSERT INTO horarios (matr_usuario, dia_semana, horario) VALUES ('".$matricula."', '".$dia_horario2."', '".$horario2."'); ";

			/* OPERAÇÃO DE INSERÇÃO */
			if (isset($sql_horario1) && isset($sql_horario2)) {
				if (mysqli_query($conn, $sql_horario1) && mysqli_query($conn, $sql_horario2)) {
					$msg_sucesso = "Horários Fixos Atualizados!";
				}
				else
					$msg_erro = "Erro ao atualizar os horários!";
			}
		}
	
		else if($count == 2) {
			//$arr = array("foo" => "bar", 12 => true);
			$horarios = array();
			for($i=1; $i<=$count; $i++) {
				$row = mysqli_fetch_assoc($result_sql_verifica);
				$horarios[$i] = $row['id_horario'];
			}

			$sql_horario1 = "UPDATE horarios SET id_horario=$horarios[1], matr_usuario=$matricula, dia_semana='$dia_horario1', horario='$horario1' WHERE id_horario=$horarios[1]; ";
			$sql_horario2 = "UPDATE horarios SET id_horario='$horarios[2]', matr_usuario=$matricula, dia_semana='$dia_horario2', horario='$horario2' WHERE id_horario=$horarios[2]; ";

			/*OPERAÇÃO DE ATUALIZAÇÃO */
			if (isset($sql_horario1) && isset($sql_horario2)) {
				if (mysqli_query($conn, $sql_horario1) && mysqli_query($conn, $sql_horario2)) {
					$msg_sucesso = "Horários Fixos Atualizados!";
				}
				else
					//$msg_erro = "Erro ao atualizar os horários!";
					$msg_erro = 'Erro: ' . mysqli_error($conn);
			}
		}
		
	}

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
	<!-- Foundation-timepicker CSS -->
    <link type="text/css" href="../css/bootstrap.min.css" />
    <link type="text/css" href="../css/bootstrap-timepicker.min.css" />
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
						<form id="cadastro" name="cadastro" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" data-abide>
	   						<h4 class="text-center">Horários Presenciais Fixos</h4>
    						<br>
    						
    						<div class="row">
    							<div class="large-6 columns" >
    								<h6 class="text-center">Horário 1</h6>
    							</div>
    							<div class="large-6 columns" >
    								<h6 class="text-center">Horário 2</h6>
    							</div>
    						</div>

    						<div class="row">
    							<div class="large-3 columns" >
									<select name="dia_horario1" id="dia_horario1" required>
										<option value="Segunda">Segunda</option>
										<option value="Terça">Terça</option>
										<option value="Quarta">Quarta</option>
										<option value="Quinta">Quinta</option>
										<option value="Sexta">Sexta</option>
									</select>
				        		</div>
	    						<div class="large-3 columns">
									<div class="bootstrap-timepicker">
				            			<input id="horario1" name="horario1" type="text" class="input-small" required>
				            			<i class="icon-time"></i>
				        			</div>
				        		</div>
				        		<div class="large-3 columns">
									<select name="dia_horario2" id="dia_horario2" required>
										<option value="Segunda">Segunda</option>
										<option value="Terça">Terça</option>
										<option value="Quarta">Quarta</option>
										<option value="Quinta">Quinta</option>
										<option value="Sexta">Sexta</option>
									</select>
				        		</div>
				        		<div class="large-3 columns">
									<div class="bootstrap-timepicker">
				            			<input id="horario2" name="horario2" type="text" class="input-small" required>
				            			<i class="icon-time"></i>
				        			</div>
				        		</div>
				        	</div>

						</div>
					</div>

					<br>

					<div class="row">
						<div class="large-12 columns text-center">
							<button type="submit" id="cadastrar" class="small round button">Atualizar</button>
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
	<!-- Timepicker. Fonte: http://jdewit.github.io/bootstrap-timepicker/ -->
    <script type="text/javascript" src="../js/bootstrap-timepicker/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
	 <script type="text/javascript">
	        $('#horario1').timepicker({
	            template: false,
	            showInputs: false,
	            minuteStep: 10,
	            showMeridian: false
	        });

	        $('#horario2').timepicker({
	            template: false,
	            showInputs: false,
	            minuteStep: 10,
	            showMeridian: false
	        });
	  </script>
</body>
<?php
	//Encerra a conexão com o banco
	mysqli_close($conn);
?>
</html>
