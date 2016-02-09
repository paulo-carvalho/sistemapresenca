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
</head>
<body>

	<?php
		require_once("menu/menu.html");
		echo "<br>";

		require_once("connect/testmysql_p.php");

		$matr = $_GET['id'];
		//echo $matr;

		$sql_usuario = "SELECT * FROM usuarios WHERE matr='$matr';";
		$sql_diretoria = "SELECT nome_diretoria FROM usuarios JOIN diretorias ON diretoria=id_diretoria WHERE matr='$matr';";


		if (isset($sql_usuario)) {	
			$result = mysqli_query($conn, $sql_usuario);
		}
		
		if (isset($sql_diretoria)) {	
			$result2 = mysqli_query($conn, $sql_diretoria);
		} else
			echo 'Erro: ' . mysqli_error($conn);

		while ($row = mysqli_fetch_assoc($result2)) {
			$nome_diretoria = $row['nome_diretoria'];
		}

		while ($row = mysqli_fetch_assoc($result)) {
						

	?>

	<div class="row">
		<div class="large-12 columns">
			<div class="panel">
				<h3 class="text-center"><?php echo $row['nome']?></h3>
				<br>
				<div class="row">

					<div class="large-8 push-2 columns">

						<form>
							<label> Nome Completo: <input type="text" id="name" value='<?php echo $row['nome']?>' /> </label>
							<label> Número matrícula: <input type="text" id="matricula" value='<?php echo $row['matr']?>' disabled/> </label>
							<label> Email Pessoal: <input type="text" id="email" value='<?php echo $row['email_pessoal']?>' /> </label>
							<label> Email Profissional: <input type="text" id="email" value='<?php echo $row['email_profissional']?>' /> </label>
							<label>Cargo:
								<select >
									<option value="" ><?php echo $row['cargo']?></option>
								</select>
							</label>
							<label>Diretoria:
								<select >
									<option value=""><?php echo $nome_diretoria?></option>
								</select>
							</label>

							<br>
							<div class="row">
								<div class="large-12 columns text-center">
									<button type="submit" id="editar" class="small round button">Salvar edição</button>
									<a href="listar_usuarios.php"class="small round button">Cancelar</a>
								</div>
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
</html>
