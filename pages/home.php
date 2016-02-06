<!doctype html>
<?php
	require_once("connect/testmysql_p.php");

	session_start();

// ALTERAR ACAO DE BATER PONTO
	//TODO
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// $stmt = $conn->prepare("UPDATE `usuarios` SET `conectado` =? WHERE `usuarios`.`matr` =?;");
		// // definir dependencias da query preparada
		// $stmt->bind_param("i", $conectado);
	}

// LISTAGEM DE USUARIOS
	// preparar query
	$stmt = $conn->prepare("SELECT `matr`, `nome` FROM `usuarios` WHERE `conectado`=?;");
	// definir dependencias da query preparada
	$stmt->bind_param("i", $conectado);

	// alterar valor da dependencia e executar query
	$conectado = 1;
	$stmt->execute();

	// matriz que recebe os membros online
	$membros = array("matricula" => array(),
					"nome" => array());

	// alinhar variaveis de resultados com ordem
	$stmt->bind_result($nMatricula, $nMembro);

	// definindo valores por linha encontrada no select
	while ( $stmt->fetch() ) {
	    array_push($membros["matricula"], $nMatricula);
	    array_push($membros["nome"], $nMembro);
	}

// VERIFICAR SE USUARIO BATEU PONTO OU NAO
	// preparar query
	$stmt = $conn->prepare("SELECT `conectado` FROM `usuarios` WHERE `matr`=?");
	// definir dependencias da query preparada
	$stmt->bind_param("s", $_SESSION['matricula']);
	$stmt->execute();

	$stmt->bind_result($conectadoUsuario);
	$stmt->fetch();

	$stmt->close();
 	$conn->close();
?>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Controle de Presença</title>
	<link rel="stylesheet" href="../css/foundation.css" />
	<link rel="stylesheet" href="../foundation-icons/foundation-icons.css" />
	<link rel="stylesheet" href="../foundation-icons/ foundation-icons.[eot/ttf/svg/woff]" />
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
	<link rel="icon" href="../favicon.ico" type="image/x-icon" />
</head>
<body>
	<?php
		require_once("menu/menu.html");
	?>

	<br>

	<div class="row">

<?php
	if($conectadoUsuario == 1) {
?>
		<div class="row">
			<div class="large-8 medium-8 small-12 large-push-2 medium-push-2 alert-box success">
				Você atualmente está na empresa.
				<a href="" class="close">&times;</a>
			</div>
		</div>
<?php
	} else {
?>
		<div class="row">
			<div class="large-8 medium-8 small-12 large-push-2 medium-push-2 alert-box alert">
				Você atualmente NÃO está na empresa.
				<a href="" class="close">&times;</a>
			</div>
		</div>
<?php
	}
?>

		<!-- Botão "Bater Ponto" -->
		<br>

		<div class="row">
			<div class="large-8 medium-8 small-8 large-push-2 medium-push-2 small-push-2 columns text-center">
				<a href="ponto_sucesso.html" data-reveal-id="confirmarBaterPonto" class="small round button expand">Bater ponto</a>
			</div>
		</div>

		<br>


		<div class="row">
			<div class="large-10 medium-10 small-12 large-push-1 medium-push-1 columns text-center">
				<div class="panel">
					<h3> Usuários online </h3>
					<table class="large-12 medium-12 small-12 text-center">
						<thead>
							<tr>
								<th>Matrícula</th>
								<th>Nome</th>
								<th class="text-center">Logoff</th>
							</tr>
						</thead>
						<tbody>
							<?php
								for ($i=0; $i < count($membros["matricula"]); $i++) {
							?>

							<tr>
								<td><?php echo $membros["matricula"][$i]; ?></td>
								<td><?php echo $membros["nome"][$i]; ?></td>
								<td class="text-center"><i class="fi-power"></td>
							</tr>

							<?php
								}
							?>
						</tbody>
					</table>
				</div>

			</div>
			</div>

		<!-- modal para confirmar ação de bater ponto -->
		<div id="confirmarBaterPonto" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
			<h2 id="modalTitle">Bater Ponto</h2>
			<p class="lead">Você acionou o botão para bater ponto.</p>
			<p>Confirma essa ação?</p>

			<div class="row">
				<div class="large-6 medium-6 small-6 columns">
				<form name="baterPonto" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
					<input type="hidden" name="conectadoUsuario" value="<?php echo $conectadoUsuario; ?>">
					<p><a href="#" class="button expand">Sim</a></p>
				</form>
				</div>
				<div class="large-6 medium-6 small-6 columns">
					<p><a href="#" class="button expand close-modal">Não</a></p>
				</div>
			</div>

			<a class="close-reveal-modal" aria-label="Close">&#215;</a>
		</div>

		<script src="../js/vendor/modernizr.js"></script>
		<script src="../js/vendor/jquery.js"></script>
		<script src="../js/foundation/foundation.js"></script>
		<script src="../js/foundation/foundation.topbar.js"></script>
  		<script src="../js/foundation/foundation.reveal.js"></script>
		<script type="text/javascript">
			$(document).foundation();

			// para fechar o modal de bater ponto
			$('.close-modal').click(function() {
				$('#confirmarBaterPonto').foundation('reveal', 'close');
			});
		</script>
	</body>
	</html>
