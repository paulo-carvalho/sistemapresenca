<!doctype html>
<?php
	require_once("connect/testmysql_p.php");

	/* QUERY */
	$sql = "SELECT matr, nome FROM usuarios WHERE permissao='3' ORDER BY nome ASC";

	/* DEBUG */
	//if(isset($sql))
	//	echo $sql;

	/* OPERAÇÃO DE CONSULTA */
	$msg_erro = "";
	$msg_sucesso = "";
	if (isset($sql))
		if (!mysqli_query($conn, $sql)) {
	  		//$msg_erro = 'Erro: ' . mysqli_error($con);
	  		$msg_erro = "Não foi possível realizar essa operação.";
		} else {
			$resultado = mysqli_query($conn, $sql);
		}
	//mysqli_close($conn);
?>

<html class="no-js" lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Lista de Pós Juniores</title>
	<link rel="stylesheet" href="../css/foundation.css" />
	<link rel="stylesheet" href="../foundation-icons/foundation-icons.css" />
	<link rel="stylesheet" href="../foundation-icons/ foundation-icons.[eot/ttf/svg/woff]" />
	<script src="../js/vendor/modernizr.js"></script>
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
	<link rel="icon" href="../favicon.ico" type="image/x-icon" />
</head>
<body>
	<?php
		require_once("menu/menu.html");
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
				<h3 class="text-center">Lista de Pós Juniores</h3>
				<br>
				<div class="row">

					<div class="large-8 push-2 columns">
						<table class="large-12">
							<thead>
								<tr>
									<th>Matrícula</th>
									<th>Nome</th>
									<th class="text-center">Ver</th>
									<th class="text-center">Ativar</th>
								</tr>
							</thead>
							
							<!-- Direcionar para as paginas corretas e exibir resultados !-->

							<tbody>
								<?php
									while ($row = mysqli_fetch_assoc($resultado)) {
								?>
									    <tr>
											<td> <?php echo $row['matr'] ?></td>
											<td> <?php echo $row['nome'] ?></td>
											<td class="text-center"><a href="ver_usuario.php?id=<?php echo $row['matr']?>"><i class="fi-zoom-in"></a></td>
											<td class="text-center"><a href="modal_ativar_usuario.php?id=<?php echo $row['matr']?>" data-reveal-id="ativar_usuario" data-reveal-ajax="true"><i class="fi-check"></a></td>
										</tr>
								<?php	
									}
								?>	
								

							</tbody>
						</table>

						<!-- Modal para confirmar ação de desativar usuário -->
						<div id="ativar_usuario" class="reveal-modal" data-reveal  aria-hidden="true" role="dialog">
							<!-- Conteúdo do div está na página modal_ativar_usuario.php -->
						</div>

						
						<!-- Botão para exibir os membros -->
						<div class="row">
							<div class="large-12 medium-12 small-12 columns text-center">
								<a href="listar_usuarios.php" class="small round button">Ver Membros </a>
							</div>
						</div>

					</div>
				</div>

				<br>

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
	<script src="../js/foundation/foundation.reveal.js"></script>
	<script type="text/javascript">
		$(document).foundation();

		$('.close').click(function() {
			$(this).parent().fadeOut(500);
		});
	</script>
</body>
</html>
