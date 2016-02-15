<?php
	require_once("connect/testmysql_p.php");

	$matr = $_GET['id'];

	/* Busca os dados do usuário */
	$sql = "SELECT matr, nome FROM usuarios WHERE matr=$matr";

	/* Executa a query */
	if (isset($sql))
		if (mysqli_query($conn, $sql)) {
			$result = mysqli_query($conn, $sql);
		}
	
	/*Armazena o nome do usuário na variável nome */
	while ($row = mysqli_fetch_assoc($result)) {
		$nome = $row['nome'];
	}

	mysqli_close($conn);
	unset($conn);
?>

<!doctype html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Ativar Usuário</title>
	<link rel="stylesheet" href="../css/foundation.css" />
	<script src="../js/vendor/modernizr.js"></script>
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
	<link rel="icon" href="../favicon.ico" type="image/x-icon" />
</head>
<body>

	<div class="row">
		<div class="large-12 columns">
				
			<h2>Ativar usuário </h2>
			<p class="lead">Você acionou o botão para ativar o usuário <?php echo $nome?></p>
			<p>Confirma essa ação?</p>
			
			<div class="row">
				<div class="large-6 medium-6 small-6 columns">
					<form name="ativar_usuario" action="ativar_usuario.php" method="post">
						<!-- Passa o valor 2, pois é a permissão de membro -->
						<input type="hidden" name="ativar" id="ativar" value="2">
						<input type="hidden" name="matr" id="matr" value="<?php echo $matr ?>">
						<button class="button expand" name="Sim" type="submit">Sim</button>
					</form>
				</div>
				<div class="large-6 medium-6 small-6 columns">
					<a href="listar_pos_juniores.php" class="button expand close-modal">Não</a>
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
