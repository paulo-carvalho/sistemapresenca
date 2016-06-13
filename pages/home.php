<!doctype html>
<?php
	require_once("connect/testmysql_p.php");

	session_start();

	if(!isset($_SESSION['matricula']))
    	header("Location: ../index.php");

// ALTERAR ACAO DE BATER PONTO
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// Batendo ponto na tabela de presenca
		$stmt = $conn->prepare("INSERT INTO `presenca` (`id_presenca`, `matr`, `data`, `entrada`) VALUES (NULL, ?, NOW(), ?);");
		// definir dependencias da query preparada
		$stmt->bind_param("ii", $sessaoMatricula, $alterarConectado);

		if (isset($_POST['matricula']))
			$sessaoMatricula = $_POST['matricula'];
		else
			$sessaoMatricula = $_SESSION['matricula'];
		if (isset($_POST['alterarConectado']))
			$alterarConectado = ($_POST['alterarConectado'] == 0) ? 1 : 0;
		else
			$alterarConectado = 0;
		$stmt->execute();

		// Atualizando na tabela usuarios
		$stmt = $conn->prepare("UPDATE `usuarios` SET `conectado` =? WHERE `usuarios`.`matr` =?;");
		// definir dependencias da query preparada
		$stmt->bind_param("is", $alterarConectado, $sessaoMatricula);

		// Parametros ja definidos para a query anterior
		$stmt->execute();
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

// VERIFICAR SE USUARIO BATEU PONTO OU NAO E SE ELE E ADMINISTRADOR
	// preparar query
	$stmt = $conn->prepare("SELECT `conectado`, `nome`, `permissao` FROM `usuarios` WHERE `matr`=?");
	// definir dependencias da query preparada
	$stmt->bind_param("s", $_SESSION['matricula']);
	$stmt->execute();

	$stmt->bind_result($conectadoUsuario, $nomeUsuario, $permissaoUsuario);
	$stmt->fetch();

	$stmt->close();
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
		require_once("menu/menu.php");
	?>

	<br>

	<div class="row">

<?php
	if($conectadoUsuario == 1) {
?>
		<div class="row">
			<div class="large-8 medium-8 small-12 large-push-2 medium-push-2 alert-box success">
				<?php echo $nomeUsuario; ?>, você atualmente está na empresa.
			</div>
		</div>
<?php
	} else {
?>
		<div class="row">
			<div class="large-8 medium-8 small-12 large-push-2 medium-push-2 alert-box alert">
				<?php echo $nomeUsuario; ?>, você atualmente NÃO está na empresa.
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
								<td class="text-center">
								<?php
									if($permissaoUsuario == 1 || $membros["matricula"][$i] == $_SESSION['matricula']) {
								?>
									<a href="#"
										class="botaoForcarBaterPonto"
										id="<?php echo $membros["matricula"][$i]; ?>"
										name="<?php echo $membros["nome"][$i]; ?>"
										data-reveal-id="forcarBaterPonto"
										onclick="pegarMatricula(this.id, this.name)">
								<?php
									}
								?>
										<i class="fi-power"></i>
									</a>
								</td>
							</tr>

							<?php
								}

								// Imprime mensagem se ninguem estiver na empresa
								if($i == 0)
									echo "<tr><td colspan='3' class='text-center'>Nenhum membro presente.</td></tr>";
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
					<input type="hidden" name="alterarConectado" value="<?php echo $conectadoUsuario; ?>">
					<button class="button expand" name="Sim" type="submit">Sim</button>
				</form>
				</div>
				<div class="large-6 medium-6 small-6 columns">
					<a href="#" class="button expand close-modal">Não</a>
				</div>
			</div>

			<a class="close-reveal-modal" aria-label="Close">&#215;</a>
		</div>
		<!-- fim modal -->
		<!-- modal para forcar acao de bater ponto de algum usuario listado -->
		<div id="forcarBaterPonto" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
			<h2 id="modalTitle">Bater Ponto</h2>
			<p class="lead">Você acionou o botão para retirar <span class="matriculaForcarBaterPonto"></span> da empresa.</p>
			<p>Confirma essa ação?</p>

			<div class="row">
				<div class="large-6 medium-6 small-6 columns">
				<form name="baterPonto" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
					<input type="hidden" name="alterarConectado" value="1">
					<input type="hidden" name="matricula" class="matriculaForcarBaterPonto" value="">
					<button class="button expand" name="Sim" type="submit">Sim</button>
				</form>
				</div>
				<div class="large-6 medium-6 small-6 columns">
					<a href="#" class="button expand close-modal">Não</a>
				</div>
			</div>

			<a class="close-reveal-modal" aria-label="Close">&#215;</a>
		</div>
		<!-- fim modal -->
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

			// ao clicar em logoff, identificar o numero de matricula forcado.
			// usado para envio de form, retirando membro da empresa.
			// usado para exibir no modal de forcar saida do membro.
			function pegarMatricula(matricula, nome) {
				// input hidden de form
				$("input.matriculaForcarBaterPonto").val(matricula);
				// texto de exibicao
				$("span.matriculaForcarBaterPonto").text(matricula+" - "+nome);
			}
		</script>
	</body>

<?php
	$conn->close();
?>
	</html>
